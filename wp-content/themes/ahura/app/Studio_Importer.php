<?php
namespace ahura\app;

use ahura\app\customization\Customizer;
use ahura\app\customization\customizer_save;
use ahura\app\traits\Singleton;

class Studio_Importer extends Studio_Demo {
    private $result;
    private $processed_terms = [];
    private $processed_posts = [];

    use Singleton;

    public function __construct(){
        add_action('ahura_after_import_demo', [$this, 'handle_after_import_demo'], 10, 2);
    }

    /**
     *
     * Get home page names
     *
     * @return array|object
     */
    public function get_home_names($hash = false){
        $names = [
            'Home',
            'home',
            'خانه',
            'خانه اصلی',
            'صفحه اصلی',
            'صفحه خانه',
            'صفحه نخست'
        ];
        $names = apply_filters('ahura_get_home_names', $names);
        if($hash === true){
            $names = mw_tools::array_hash_values($names);
        }
        return $names;
    }

    /**
     *
     * Get header page names
     *
     * @return array|object
     */
    public function get_header_names($hash = false){
        $names = [
            'Header',
            'header',
            'هدر',
            'سربرگ',
            'هدر اصلی',
            'سربرگ اصلی'
        ];
        $names = apply_filters('ahura_get_header_names', $names);
        if($hash === true){
            $names = mw_tools::array_hash_values($names);
        }
        return $names;
    }

    /**
     *
     * Get footer page names
     *
     * @return array|object
     */
    public function get_footer_names($hash = false){
        $names = [
            'Footer',
            'footer',
            'فوتر',
            'پاورقی',
            'فوتر اصلی',
            'پاورقی اصلی'
        ];
        $names = apply_filters('ahura_get_footer_names', $names);
        if($hash === true){
            $names = mw_tools::array_hash_values($names);
        }
        return $names;
    }

    private function set_result($key, $value){
        if(is_array($key) && count($key) == 2){
            $this->result[$key[0]][$key[1]] = $value;
        } else {
            $this->result[$key] = $value;
        }
    }

    private function get_result(){
        return $this->result;
    }

    /**
     *
     * Import demo content
     *
     * @return false|void
     */
    public function import_demo($params = null){
        // Set the memory limit to 128MB
        @ini_set('memory_limit', '256M');

        if(!isset($params['demo']) || $params['demo'] < 0){
            return false;
        }

        $step = $params['step'];
        $is_first = $params['is_first'] == 'true';
        $is_last = $params['is_last'] == 'true';

        if($is_first){
            delete_option('ahura_demo_home_id');
            delete_option('ahura_demo_header_id');
            delete_option('ahura_demo_footer_id');
            $this->set_demo_id($params['demo']);
            $this->set_result('start', true);
        }

        $demo_content = $this->get_demo_content();

        if(!$demo_content){
            $this->set_result('empty', true);
            return $this->get_result();
        }

        $attachments = isset($demo_content['posts']['attachment']) ? $demo_content['posts']['attachment'] : false;
        if($attachments){
            unset($demo_content['posts']['attachment']);
        }

        do_action('ahura_before_import_demo', $demo_content);

        #---------- START IMPORT DATA ----------#

        wp_suspend_cache_invalidation(true);
        if(in_array($step, ['customizer', 'options'])){
            $this->import_customizer($demo_content);
        } elseif($step === 'terms'){
            $this->import_terms($demo_content);
        } elseif($step === 'widgets'){
            $this->import_widgets($demo_content);
        } elseif($step === 'menus'){
            $this->import_menus($demo_content);
        } elseif(in_array($step, ['posts', 'content'])){
            $this->import_posts($demo_content);
            $this->import_elementor_data($demo_content);
        } elseif($step === 'media'){
            if(isset($attachments[$params['start_media']])){
                $this->import_media($attachments[$params['start_media']], $attachments);
            }
        }
        wp_suspend_cache_invalidation(false);
        
        #---------- / END IMPORT DATA ----------#

        if($is_last){
            do_action('ahura_after_import_demo', $this->get_result(), $demo_content);
            $this->remove_demo_file();
            $this->set_result('complete', true);
        }

        // Reset the memory limit back to the default value
        @ini_set('memory_limit', '-1');

        return $this->get_result();
    }

    /**
     *
     * Import demo media
     *
     * @param $attachment
     * @return false|int
     */
    public function import_media($attachment, $attachments = []){
        if (!is_array($attachment) || empty($attachment))
            return false;

        $import_count = 0;
        $attachment = (array) $attachment;
        $attachment_url = isset($attachment['guid']) && !empty($attachment['guid']) ? $attachment['guid'] : false;
        if($attachment_url){
            $sideload = @self::sideload_attachment($attachment_url, $attachment);
            if(is_object($sideload) && isset($sideload->url)){
                $this->set_result(['imported', 'url'], $sideload->url);
                $import_count++;
            }
        }

        $this->set_result(['imported', 'success'], $import_count);
        $this->set_result(['imported', 'all'], count($attachments));
        $this->set_result(['imported', 'attachment'], $attachment);
        return $import_count;
    }

    public static function sideload_attachment($file, $params = []){
        $data = new \stdClass();

        add_filter('upload_mimes', function ($existing_mimes){
            if(is_admin()){
                $existing_mimes['svg'] = 'image/svg+xml';
            }
            return $existing_mimes;
        });

        if ( ! function_exists( 'media_handle_sideload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/media.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
        }

        if ( ! empty( $file ) ) {
            // Set variables for storage, fix file filename for query strings.
            preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png|svg|mp3|mp4|webm|webp)\b/i', $file, $matches );
            $file_array = array();
            $file_array['name'] = basename( $matches[0] );

            // Download file to temp location.
            $file_array['tmp_name'] = download_url( $file );

            // If error storing temporarily, return the error.
            if ( is_wp_error( $file_array['tmp_name'] ) ) {
                return $file_array['tmp_name'];
            }
            $params['import_id'] = $params['ID'];
            // Do the validation and storage stuff.
            $id = media_handle_sideload($file_array, $params['ID'], null, $params);

            // If error storing permanently, unlink.
            if ( is_wp_error( $id ) ) {
                unlink( $file_array['tmp_name'] );
                return $id;
            }

            // Build the object to return.
            $meta                = wp_get_attachment_metadata( $id );
            $data->attachment_id = $id;
            $data->url           = wp_get_attachment_url( $id );
            $data->thumbnail_url = wp_get_attachment_thumb_url( $id );
            $data->height        = $meta['height'];
            $data->width         = $meta['width'];
        }

        return $data;
    }

    /**
     *
     * Import demo posts
     *
     * @param $demo_content
     * @return void
     */
    private function import_posts($demo_content){
        $i = 0;
        $this->set_result(['imported', 'content'], $i);

        $extra = $demo_content['extra'];
        $front_page = isset($extra['front_page']) ? (int) $extra['front_page'] : false;
        $header = isset($extra['header']) ? (int) $extra['header'] : false;
        $footer = isset($extra['footer']) ? (int) $extra['footer'] : false;

        if(isset($demo_content['posts'])){
            $posts = $demo_content['posts'];
            if(is_array($posts) && count($posts) > 0){
                foreach ($posts as $post_type => $post_type_posts) {
                    foreach ($post_type_posts as $post) {
                        if(!$post) continue;
                        
                        $categories = [];
                        $taxonomy = '';
                        if(isset($post['categories']) && !empty($post['categories'])){
                            $demo_categories = $post['categories'];
                            foreach ($demo_categories as $category){
                                $cat = get_term_by('name', $category['name'], $category['taxonomy']);
                                if($cat){
                                    $categories[] = $cat->term_id;
                                    $taxonomy = $category['taxonomy'];
                                }
                            }
                        }
                        
                        $post_id = wp_insert_post(array(
                            'import_id ' => $post['ID'],
                            'post_type' => $post_type,
                            'post_title' => $post['post_title'],
                            'post_content' => is_array($post['post_content']) ? json_encode($post['post_content']) : $post['post_content'],
                            'post_status' => $post['post_status'],
                            'post_date' => $post['post_date'],
                            'post_date_gmt' => $post['post_date_gmt'],
                            'guid' => $post['guid'],
                        ));

                        if(!$post_id) continue;

                        wp_set_post_terms($post_id, $categories, $taxonomy);

                        self::set_cache_option($post['ID'], 'before_id', $post_id);

                        if(in_array($post_type, ['page', 'section_builder'])){
                            if($front_page == $post['ID']){
                                update_option('ahura_demo_home_id', $post_id);
                            } elseif (in_array(md5($post['post_title']), self::get_home_names(true))){
                                update_option('ahura_demo_home_id', $post_id);
                            }

                            if($header == $post['ID']){
                                update_option('ahura_demo_header_id', $post_id);
                            } elseif (in_array(md5($post['post_title']), self::get_header_names(true))){
                                update_option('ahura_demo_header_id', $post_id);
                            }

                            if($footer == $post['ID']){
                                update_option('ahura_demo_footer_id', $post_id);
                            } elseif (in_array(md5($post['post_title']), self::get_footer_names(true))){
                                update_option('ahura_demo_footer_id', $post_id);
                            }
                        }
                        if (isset($post['meta'])){
                            foreach ($post['meta'] as $key => $value) {
                                if (is_string($key) && strpos($key,'wxr_import_user_slug') !== false || strpos($key,'_elementor_css') !== false) continue;

                                $value = self::sanitize_meta_value($value[0]);

                                add_post_meta($post_id, wp_unslash($key), $value);
                            }
                        }
                        $i++;
                    }
                }
                $this->set_result(['imported', 'content'], $i);
            }
        }
    }

    /**
     *
     * Import elementor data
     *
     * @param $demo_content
     * @return false|void
     */
    private function import_elementor_data($demo_content){
        $data = $demo_content['elementor_data'];

        if (!is_array($data))
            return false;

        $has_kit = get_posts(['name' => 'default_elementor_kit', 'post_type' => 'elementor_library', 'posts_per_page' => 1, 'post_status' => 'publish']);

        if (!$has_kit){
            $active_kit_id = wp_insert_post([
                'post_title' => 'Default Kit',
                'post_name' => 'default_elementor_kit',
                'post_type' => 'elementor_library',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ]);
        } else {
            $active_kit_id = get_option('elementor_active_kit');
        }

        if (isset($data['kit_meta']) && !empty($data['kit_meta'])){
            update_option('elementor_active_kit', $active_kit_id);
            foreach ($data['kit_meta'] as $key => $value){
                if (!empty($value[0]) && strpos($key, 'elementor_css') === false){
                    $value = self::sanitize_meta_value($value[0]);
                    update_post_meta($active_kit_id, wp_unslash($key), $value);
                }
            }
        }
    }

    /**
     *
     * Import demo terms
     *
     * @return void
     */
    private function import_terms($demo_content){
        $i = 0;
        if(isset($demo_content['terms'])){
            // Import terms
            $terms = $demo_content['terms'];
            usort($terms, function($a, $b) {
                return $a["term_id"] - $b["term_id"];
            });
            foreach ($terms as $term) {
                $term_exists = term_exists($term['term_id'], $term['taxonomy']);

                if ($term_exists) {
                    $term_exists = (array) $term_exists;
                    $term_data = (array) get_term($term_exists['term_id'], $term['taxonomy']);

                    $term_id = wp_insert_term($term_data['name'], $term_data['taxonomy'], array(
                        'description' => $term_data['description'],
                        'parent' => $term_data['parent'],
                        'slug' => $term_data['slug'],
                        'term_group' => $term_data['term_group'],
                        'term_id' => $term_exists['term_id']
                    ));
                } else {
                    $term_id = wp_insert_term($term['name'], $term['taxonomy'], array(
                        'description' => $term['description'],
                        'slug' => $term['slug'],
                        'parent' => $term['parent'],
                        'term_id' => $term['term_id']
                    ));
                }

                if(!is_wp_error($term_id)){
                    self::set_cache_option($term['term_id'], 'before_id', $term_id, 'term');
                    if(isset($term['meta']) && !empty($term['meta'])){
                        foreach ($term['meta'] as $key => $value) {
                            update_term_meta($term_id, $key, $value[0]);
                        }
                    }
                    $i++;
                }
            }
        }
        $this->set_result(['imported', 'terms'], $i);
    }

    /**
     *
     * Import demo customizer settings
     *
     * @param $demo_content
     * @return void
     */
    private function import_customizer($demo_content){
        global $wp_customize;
        $i = 0;
        try{
            if(isset($demo_content['customizer']) && !empty($demo_content['customizer'])){
                $mods = get_theme_mods();
                if($mods){
                    $save_mods = update_option('ahura_before_theme_mods', json_encode($mods));
                    set_theme_mod('theme_dark', false);
                }

                $customizer_settings = $demo_content['customizer'];
                if($wp_customize){
                    do_action('customize_save', $wp_customize);
                }

                foreach ( $customizer_settings as $key => $val ) {
                    if($wp_customize){
                        do_action('customize_save_' . $key, $wp_customize);
                    }

                    set_theme_mod( $key, $val );
                    $i++;
                }
            }
        } catch(\Exception $e){
            $i = 0;
        }
        $this->set_result(['imported', 'customizer'], $i);
    }

    /**
     *
     * Import demo widgets
     *
     * @param $demo_content
     * @return void
     */
    private function import_widgets($demo_content){
        $i = 0;
        if(isset($demo_content['widgets'])){
            $widgets = $demo_content['widgets'];
            if(!empty($widgets)){
                foreach ($widgets as $widget_id => $widget) {
                    $demo_widget_content = $widget;
                    update_option($widget_id, $demo_widget_content);
                    $i++;
                }
            }
        }
        if(isset($demo_content['sidebar_widgets'])){
            $demo_sidebar = $demo_content['sidebar_widgets'];
            update_option('sidebars_widgets', $demo_sidebar);
            $i++;
        }
        if(isset($demo_content['sidebar_blocks'])){
            $demo_widgets_block = $demo_content['sidebar_blocks'];
            update_option('widget_block', $demo_widgets_block);
            $i++;
        }
        $this->set_result(['imported', 'widgets'], $i);
    }

    /**
     *
     * Import demo menu items
     *
     * @param $demo_content
     * @return void
     */
    private function import_menus($demo_content){
        self::session_start();

        $i = 0;
        $this->set_result(['imported', 'menus'], $i);

        if(isset($demo_content['menus'])){
            $menus = $demo_content['menus'];
            if(!empty($menus)){
                $locations = get_nav_menu_locations();
                foreach ($menus as $location => $menu_data) {

                    $menu = $menu_data['menu'];
                    $menu['menu-name'] = $menu['name'];
                    $menu_id = wp_update_nav_menu_object($menu['term_id'], $menu);
                    if(is_wp_error($menu_id)){
                        $nav = wp_get_nav_menu_object($menu['name']);
                        if(!is_wp_error($nav)){
                            if(is_object($nav) && isset($nav->term_id)){
                                $menu_id = $nav->term_id;
                            }
                        }
                    }

                    if($menu_id && isset($menu_data['menu_items'])){
                        $menu_items = $menu_data['menu_items'];
                        foreach ($menu_items as $key => $menu_item) {
                            if(isset($menu_item['object_id'])){
                                $term = $menu_item['object_id'];
                                if(isset($menu_item['object_data']) && is_array($menu_item['object_data']) && isset($menu_item['object_data']['name']) && isset($menu_item['object_data']['taxonomy'])){
                                    $term = get_term_by('name', $menu_item['object_data']['name'], $menu_item['object_data']['taxonomy']);
                                }
                                $object_id = !is_wp_error($term) && is_object($term) ? $term->term_id : $menu_item['object_id'];
                                $before_parent = (int) isset($menu_item['menu_item_parent']) && !empty($menu_item['menu_item_parent']) ? $menu_item['menu_item_parent'] : 0;

                                if ('taxonomy' == $menu_item['type'] && !empty(self::get_cache_option($menu_item['object_id'], 'before_id', 'meta'))) {
                                    $object_id = self::get_cache_option($menu_item['object_id'], 'before_id', 'meta');
                                } elseif ('post_type' == $menu_item['type'] && !empty(self::get_cache_option($menu_item['object_id'], 'before_id'))) {
                                    $object_id = self::get_cache_option($menu_item['object_id'], 'before_id');
                                } elseif('custom' == $menu_item['type']) {
                                    $object_id = 0;
                                }

                                if(empty($object_id) || is_wp_error($object_id)){
                                    $object_id = 0;
                                }

                                $menu_item_data = [
                                    'menu-item-object-id'   => $object_id,
                                    'menu-item-type'        => $menu_item['type'],
                                    'menu-item-status'      => $menu_item['post_status'],
                                    'menu-item-title'       => $menu_item['title'],
                                    'menu-item-description' => $menu_item['description'],
                                    'menu-item-url'         => $menu_item['url'],
                                ];

                                if($before_parent && $before_parent != $menu_item['ID']){
                                    $parent_id = self::get_cache_item($before_parent);
                                    if($parent_id !== $menu_item['ID']){
                                        $menu_item_data['menu-item-parent-id'] = $parent_id;
                                    }
                                }

                                $menu_item_id = wp_update_nav_menu_item($menu_id, 0, $menu_item_data);

                                if(!is_object($menu_item_id) && !is_wp_error($menu_item_id)){
                                    self::cache_item($menu_item['ID'], $menu_item_id);
                                    if(isset($menu_item['meta'])){
                                        $menu_meta = $menu_item['meta'];
                                        if(!empty($menu_meta)){
                                            foreach ($menu_meta as $key1 => $meta_item){
                                                if (in_array($key1, ['_menu_item_type', '_menu_item_menu_item_parent', '_menu_item_object_id'])) continue;
                                                $meta_value = self::sanitize_meta_value($meta_item[0]);
                                                update_post_meta($menu_item_id, $key1, $meta_value);
                                            }
                                        }
                                    }
                                    $i++;
                                }
                            }
                        }
                    }

                    $locations[$location] = $menu_id;
                }
                if(!empty($locations)){
                    set_theme_mod('nav_menu_locations', $locations);
                }
                $this->set_result(['imported', 'menus'], $i);
            }
        }
        session_destroy();
    }

    public static function get_post_types(){
        global $wpdb;
        $post_types = [];
        $sql = "SELECT DISTINCT post_type FROM {$wpdb->posts}";
        $stmt = $wpdb->get_results($sql, ARRAY_N);
        if($stmt){
            foreach($stmt as $post_type){
                $post_type_name = $post_type[0];
                if(in_array($post_type_name, ['nav_menu_item', 'revision'])) continue;
                $post_types[] = $post_type_name;
            }
        }
        return $post_types;
    }

    public static function get_page_by_title($title){
        $post_types = self::get_post_types();
        $post = false;
        foreach ( $post_types as $post_type ) {
            $post = get_page_by_title( $title, OBJECT, $post_type );
            if($post){
                break;
            }
        }
        return $post;
    }

    public static function set_permalinks_structure($structure = '/%postname%/'){
        update_option('permalink_structure', $structure);
        flush_rewrite_rules();
    }

    public static function sanitize_meta_value($value){
        if($value){
            $data = @preg_replace_callback(
                '!s:(\d+):"(.*?)";!',
                function($m) {
                    return 's:'.strlen($m[2]).':"'.$m[2].'";';
                },
                $value);
            if(is_string($data) && is_array(@unserialize($data))){
                $value = @unserialize($data);
            } else {
                $value = mw_tools::maybe_serialize($value);
            }
        }
        return wp_slash_strings_only($value);
    }

    public static function cache_item($item_id, $item_value){
        $_SESSION[$item_id] = $item_value;
    }

    public static function get_cache_item($item_id){
        if(isset($_SESSION[$item_id])){
            return $_SESSION[$item_id];
        }

        return false;
    }

    public static function set_cache_option($item_id, $item_key, $item_value, $type = 'option'){
        $options = get_option('ahura_demo_cache');
        if (!is_array($options) || empty($options)){
            $options = [];
        }
        $options[$type][$item_id][$item_key] = $item_value;
        update_option('ahura_demo_cache', $options);
    }

    public static function get_cache_option($item_id, $item_key, $type = 'option'){
        $options = get_option('ahura_demo_cache');
        return is_array($options) && isset($options[$type][$item_id]) && isset($options[$type][$item_id][$item_key]) ? $options[$type][$item_id][$item_key] : false;
    }

    public static function session_start(){
        if(!session_id()){
            session_start();
        }
    }

    /**
     *
     * Fired after import demo
     *
     * @param null $result Default is NULL
     * @param null $demo_content Default is NULL
     * @return void
     */
    public function handle_after_import_demo($result = null, $demo_content = null){
        $home_page_id = get_option('ahura_demo_home_id');
        $header_page_id = get_option('ahura_demo_header_id');
        $footer_page_id = get_option('ahura_demo_footer_id');

        self::set_permalinks_structure();

        if($home_page_id){
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_page_id);
        }

        if($header_page_id && !empty($demo_content) && isset($demo_content['extra'])){
            set_theme_mod('use_custom_header', true);
            set_theme_mod('custom_header', $header_page_id);
        } else {
            set_theme_mod('use_custom_header', false);
        }

        if($footer_page_id && !empty($demo_content) && isset($demo_content['extra'])){
            set_theme_mod('use_custom_footer', true);
            set_theme_mod('custom_footer', $footer_page_id);
        } else {
            set_theme_mod('use_custom_footer', false);
        }

        if($helloWorldPost = get_page_by_path('hello-world', '', 'post')){
            wp_delete_post($helloWorldPost->ID);
        }

        if($helloWorldPost = get_page_by_path('سلام-دنیا', '', 'post')){
            wp_delete_post($helloWorldPost->ID);
        }

        if(is_rtl()){
            update_option('woocommerce_currency', 'IRT');
            update_option('woocommerce_price_num_decimals', 0);
            update_option('woocommerce_currency_pos', 'right_space');
        }

        update_option( 'elementor_container_width', '1280' );
        update_option( 'elementor_default_generic_fonts', 'IRANSans' );
        update_option( 'elementor_disable_typography_schemes', 'yes' );

        customizer_save::generate();

        global $wp_customize;
        if (!empty($wp_customize)){
            do_action('customize_save_after', $wp_customize);
        }

        delete_option('ahura_demo_cache');
    }
}