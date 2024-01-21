<?php
namespace ahura\app;

class mw_post_type
{
    private static $post_types = [];

    /**
     * Register post_types
     * 
     * Post types method name must start with register_post_type_${post_type}
     *
     * @return void
     */
    static function init()
    {
        self::register_post_type_team();
        self::register_post_type_portfolio();
        self::register_post_type_testimonial();
        self::register_post_type_section_builder();
        self::register_post_type_ahura_fonts();
        self::updated_post_types_messages();

        $post_types = static::$post_types;
        
        if($post_types && is_array($post_types)){
            if(count($post_types) > 0){
                foreach($post_types as $key => $value){
                    if(static::is_disabled_post_type($key)){
                        unregister_post_type($key);
                    }
                }
            }
        }

        if(md5(json_encode($post_types)) != md5(json_encode(static::get_post_types()))){
            $save_post_types = update_option('ahura_post_types', $post_types);
        }

        add_action('pre_post_update', [__CLASS__, 'pre_post_update'], 10, 2);
        add_action('admin_notices', [__CLASS__, 'post_types_notices']);
        add_filter('the_title', [__CLASS__, 'handle_edit_section_builder_items_title']);
    }

    /**
     * 
     * Public post types
     * 
     * * * Important: post types that are added to this list can be disabled by the user.
     *
     * @return array
     */
    public static function get_post_types(){
        return get_option('ahura_post_types');
    }

    /**
     * Get disabled post types list
     *
     * @return void
     */
    public static function get_disabled_post_types()
    {
        return get_theme_mod('ahura_disabled_post_types');
    }

    /**
     * Check post type is disabled
     *
     * @param string $post_type
     * @return boolean
     */
    public static function is_disabled_post_type($post_type = ''){
        $types = static::get_disabled_post_types();

        if(!empty($post_type) && is_array($types)){
            if(count($types) > 0){
                if(in_array($post_type, $types)){
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Register post type
     *
     * @param string $post_type
     * @param array $args
     * @return void
     */
    public static function register_post_type($post_type, $args, $params = []){
        static::$post_types[$post_type] = array_merge($args, $params);
        return register_post_type($post_type, $args);
    }

    static function register_post_type_testimonial()
    {
        $labels = [
            'name' => __('Testimonial', 'ahura'),
            'singular_name' => __('Testimonial', 'ahura'),
            'add_new' => __('Add New', 'ahura'),
            'add_new_item' => __('Add new item', 'ahura'),
            'edit_item' => __('Edit item', 'ahura'),
            'new_item' => __('New Item', 'ahura'),
            'view_item' => __("View Item", 'ahura'),
            'view_items' => __("View Items", 'ahura'),
            'search_items' => __("Search Items", 'ahura'),
            'not_found' => __('No Item Found', 'ahura'),
            'not_found_in_trash' => __("No item found in trash", 'ahura'),
            'parent_item_colon' => __('Parent item', 'ahura'),
            'all_items' => __("All Items", 'ahura'),
            'archives' => __("Items Archives", 'ahura'),
            'attributes' => __("Testimonial Attributes", "ahura"),
            'insert_into_item' => __("Insert into testimonial", 'ahura'),
            'uploaded_to_this_item' => __("Upload to this item", 'ahura'),
            'featured_image' => __("Featured Image", 'ahura'),
            'set_featured_image' => __("Set featured image", 'ahura'),
            'remove_featured_image' => __("Remove featured image", 'ahura'),
            'use_featured_image' => __("Use as featured image", 'ahura'),
            'filter_items_list' => __("Filter testimonial list", 'ahura'),
            'items_list_navigation' => __('Testimonial list navigation', 'ahura'),
            'items_list' => __('Testimonial list', 'ahura'),
            'item_published' => __("Testimonial Published", 'ahura'),
            'item_published_privately' => __("Testimonial published privately", 'ahura'),
            'item_reverted_to_draft' => __("Testimonial reverted to draft", 'ahura'),
            'item_scheduled' => __("Testimonial scheduled", 'ahura'),
            'item_updated' => __("Testimonial updated", 'ahura'),
        ];
        $args = [
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => false,
            'rewrite' => ['slug' => 'testimonial'],
            'exclude_from_search' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
			'taxonomies' => ['testimonial_cat'],
        ];
        static::register_post_type('testimonial', $args, ['is_public' => true]);
    }

    static function register_post_type_section_builder()
    {
        $labels = [
            'name' => __('Section builder', 'ahura'),
            'singular_name' => __('Section builder', 'ahura'),
            'add_new' => __('Add New', 'ahura'),
            'add_new_item' => __('Add new item', 'ahura'),
            'edit_item' => __('Edit item', 'ahura'),
            'new_item' => __('New Item', 'ahura'),
            'view_item' => __("View Item", 'ahura'),
            'view_items' => __("View Items", 'ahura'),
            'search_items' => __("Search Items", 'ahura'),
            'not_found' => __('No Item Found', 'ahura'),
            'not_found_in_trash' => __("No item found in trash", 'ahura'),
            'parent_item_colon' => __('Parent item', 'ahura'),
            'all_items' => __("All Items", 'ahura'),
            'archives' => __("Items Archives", 'ahura'),
            'attributes' => __("Section builder Attributes", "ahura"),
            'insert_into_item' => __("Insert into section builder", 'ahura'),
            'uploaded_to_this_item' => __("Upload to this item", 'ahura'),
            'featured_image' => __("Featured Image", 'ahura'),
            'set_featured_image' => __("Set featured image", 'ahura'),
            'remove_featured_image' => __("Remove featured image", 'ahura'),
            'use_featured_image' => __("Use as featured image", 'ahura'),
            'filter_items_list' => __("Filter testimonial list", 'ahura'),
            'items_list_navigation' => __('Section builder list navigation', 'ahura'),
            'items_list' => __('Section builder list', 'ahura'),
            'item_published' => __("Section builder Published", 'ahura'),
            'item_published_privately' => __("Section builder published privately", 'ahura'),
            'item_reverted_to_draft' => __("Section builder reverted to draft", 'ahura'),
            'item_scheduled' => __("Section builder scheduled", 'ahura'),
            'item_updated' => __("Section builder updated", 'ahura'),
        ];
        $args = [
            'labels' => $labels,
            'show_ui' => true,
            'public' => false,
            'show_in_menu' => false,
            'publicly_queryable' => true,
            'rewrite' => ['slug' => 'section_builder'],
            'exclude_from_search' => true,
            'supports' => ['title', 'editor', 'elementor'],
            'capability_type' => 'page'
        ];
        static::register_post_type('section_builder', $args);
    }

    public static function register_post_type_ahura_fonts()
    {
        $labels = [
            'name' => __('Ahura Fonts', 'ahura'),
            'singular_name' => __('Ahura Fonts', 'ahura'),
            'add_new' => __('Add New', 'ahura'),
            'add_new_item' => __('Add new Font', 'ahura'),
            'edit_item' => __('Edit Font', 'ahura'),
            'new_item' => __('New Font', 'ahura'),
            'view_items' => __('View Fonts', 'ahura'),
            'search_items' => __('Search Fonts', 'ahura'),
            'not_found' => __('No Font Found', 'ahura'),
            'not_found_in_trash' => __('No font found in trash', 'ahura'),
            'parent_item_colon' => __('Parent item', 'ahura'),
            'all_items' => __('All Fonts', 'ahura'),
            'archives' => __('Fonts Archives', 'ahura'),
            'insert_into_item' => __('Insert into ahura fonts', 'ahura'),
            'uploaded_to_this_item' => __('Upload to this font', 'ahura'),
            'filter_items_list' => __('Filter fonts list', 'ahura'),
            'items_list' => __('Ahura Fonts list', 'ahura'),
            'item_published' => __('Ahura Fonts Published', 'ahura'),
            'item_reverted_to_draft' => __('Ahura Fonts reverted to draft', 'ahura'),
            'item_updated' => __('Ahura Fonts updated', 'ahura'),
        ];
        $args = [
            'labels' => $labels,
            'show_ui' => true,
            'public' => false,
            'show_in_menu' => false,
            'publicly_queryable' => true,
            'rewrite' => ['slug' => 'ahura_fonts'],
            'exclude_from_search' => true,
            'supports' => ['title']
        ];
        static::register_post_type('ahura_fonts', $args);
    }

    public static function register_post_type_portfolio(){
        $labels = [
            'name' => __('Portfolios', 'ahura'),
            'singular_name' => __('Portfolio', 'ahura'),
            'add_new' => __('Add New', 'ahura'),
            'add_new_item' => __('Add new item', 'ahura'),
            'edit_item' => __('Edit item', 'ahura'),
            'new_item' => __('New Item', 'ahura'),
            'view_item' => __("View Item", 'ahura'),
            'view_items' => __("View Items", 'ahura'),
            'search_items' => __("Search Items", 'ahura'),
            'not_found' => __('No Item Found', 'ahura'),
            'not_found_in_trash' => __("No item found in trash", 'ahura'),
            'parent_item_colon' => __('Parent item', 'ahura'),
            'all_items' => __("All Items", 'ahura'),
            'archives' => __("Items Archives", 'ahura'),
            'attributes' => __("Portfolio Attributes", "ahura"),
            'insert_into_item' => __("Insert into portfolio", 'ahura'),
            'uploaded_to_this_item' => __("Upload to this item", 'ahura'),
            'featured_image' => __("Featured Image", 'ahura'),
            'set_featured_image' => __("Set featured image", 'ahura'),
            'remove_featured_image' => __("Remove featured image", 'ahura'),
            'use_featured_image' => __("Use as featured image", 'ahura'),
            'filter_items_list' => __("Filter Portfolio list", 'ahura'),
            'items_list_navigation' => __('Portfolio list navigation', 'ahura'),
            'items_list' => __('Portfolio list', 'ahura'),
            'item_published' => __("Portfolio Published", 'ahura'),
            'item_published_privately' => __("Portfolio published privately", 'ahura'),
            'item_reverted_to_draft' => __("Portfolio reverted to draft", 'ahura'),
            'item_scheduled' => __("Portfolio scheduled", 'ahura'),
            'item_updated' => __("Portfolio updated", 'ahura'),
        ];
        $args = [
            'labels' => $labels,
            'show_ui' => true,
            'public' => true,
            'has_archive' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-portfolio',
            'publicly_queryable' => true,
            'rewrite' => ['slug' => 'portfolio', 'with_front' => false],
            'exclude_from_search' => false,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields', 'post-formats', 'excerpt', 'elementor'],
            'taxonomies' => ['portfolio_cat', 'portfolio_skills'],
        ];
        static::register_post_type('portfolio', $args, ['is_public' => true]);
    }

    static function register_post_type_team()
    {
        $labels = [
            'name' => __('Team Members', 'ahura'),
            'singular_name' => __('Team Member', 'ahura'),
            'add_new' => __('Add New', 'ahura'),
            'add_new_item' => __('Add new item', 'ahura'),
            'edit_item' => __('Edit item', 'ahura'),
            'new_item' => __('New Item', 'ahura'),
            'view_item' => __("View Item", 'ahura'),
            'view_items' => __("View Items", 'ahura'),
            'search_items' => __("Search Items", 'ahura'),
            'not_found' => __('No Item Found', 'ahura'),
            'not_found_in_trash' => __("No item found in trash", 'ahura'),
            'parent_item_colon' => __('Parent item', 'ahura'),
            'all_items' => __("All Items", 'ahura'),
            'archives' => __("Items Archives", 'ahura'),
            'attributes' => __("Team Attributes", "ahura"),
            'insert_into_item' => __("Insert into Team", 'ahura'),
            'uploaded_to_this_item' => __("Upload to this item", 'ahura'),
            'featured_image' => __("Featured Image", 'ahura'),
            'set_featured_image' => __("Set featured image", 'ahura'),
            'remove_featured_image' => __("Remove featured image", 'ahura'),
            'use_featured_image' => __("Use as featured image", 'ahura'),
            'filter_items_list' => __("Filter Team list", 'ahura'),
            'items_list_navigation' => __('Team list navigation', 'ahura'),
            'items_list' => __('Team list', 'ahura'),
            'item_published' => __("Team Member Published", 'ahura'),
            'item_published_privately' => __("Team Member published privately", 'ahura'),
            'item_reverted_to_draft' => __("Team Member reverted to draft", 'ahura'),
            'item_scheduled' => __("Team Member scheduled", 'ahura'),
            'item_updated' => __("Team Member updated", 'ahura'),
        ];
        $args = [
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => false,
			'show_in_rest' => true,
			'show_in_menu' => true,
			'show_ui' => true,
            'menu_icon' => 'dashicons-groups',
            'rewrite' => ['slug' => 'team', 'with_front' => false],
            'exclude_from_search' => true,
            'supports' => ['title', 'thumbnail', 'custom-fields', 'excerpt'],
			'taxonomies' => ['team_cat'],
        ];
        static::register_post_type('team', $args, ['is_public' => true]);
    }

    public static function updated_post_types_messages()
    {
        add_filter('post_updated_messages', function ($messages) {
            $messages['ahura_fonts'] = array(
                "",
                __('Ahura Fonts updated.', 'ahura'),
                __('Custom field updated.', 'ahura'),
                __('Custom field deleted.', 'ahura'),
                __('Ahura Fonts updated.', 'ahura'),
                isset($_GET['revision']) ? sprintf(__('Ahura Fonts restored to revision from %s', 'ahura'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                __('Ahura Fonts published.', 'ahura'),
                __('Ahura Fonts saved.', 'ahura'),
                __('Ahura Fonts submitted.', 'ahura'),
                "",
                __('Ahura Fonts draft updated.', 'ahura'),
            );

            $messages['portfolio'] = array(
                "",
                __('Portfolio updated.', 'ahura'),
                __('Custom field updated.', 'ahura'),
                __('Custom field deleted.', 'ahura'),
                __('Portfolio updated.', 'ahura'),
                isset($_GET['revision']) ? sprintf(__('Portfolio restored to revision from %s', 'ahura'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                __('Portfolio published.', 'ahura'),
                __('Portfolio saved.', 'ahura'),
                __('Portfolio submitted.', 'ahura'),
                "",
                __('Portfolio draft updated.', 'ahura'),
            );

            $messages['team'] = array(
                "",
                __('Team Member updated.', 'ahura'),
                __('Custom field updated.', 'ahura'),
                __('Custom field deleted.', 'ahura'),
                __('Team Member updated.', 'ahura'),
                isset($_GET['revision']) ? sprintf(__('Team restored to revision from %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
                __('Team Member published.'),
                __('Team Member saved.'),
                __('Team Member submitted.'),
                "",
                __('Team Member draft updated.'),
            );

            return $messages;
        });
    }

    public static function pre_post_update($post_id, $post_data){
        if (wp_is_post_revision($post_id) || wp_doing_ajax())
            return;

        if ($post_data['post_type'] == 'ahura_fonts') {
            $error = true;
            $fonts = isset($_POST['font_face']) && !empty($_POST['font_face']) ? $_POST['font_face'] : false;

            if(is_array($fonts)){
                foreach($fonts as $key => $value){
                    if(!empty($value)){
                        foreach($value as $value2){
                            if(is_array($value2) && (isset($value2['url']) && !empty($value2['url']))){
                                $error = false;
                                break;
                            }
                        }
                    } else {
                        $error = true;
                        break;
                    }
                }
            }

            if($error && isset($_GET['action']) && $_GET['action'] == 'edit'){
                if(wp_redirect(get_edit_post_link($post_id, 'redirect'))){
                    session_start();
                    $_SESSION['font_save_error'] = __('Error: Upload the desired font files and then save.', 'ahura');
                    exit;
                }
            }
        }
    }

    public static function post_types_notices(){
        if(!headers_sent() && session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(isset($_SESSION['font_save_error']) && !empty($_SESSION['font_save_error'])){
            echo '<div class="notice notice-error is-dismissible"><p>' . $_SESSION['font_save_error'] . '</p></div>';
            unset($_SESSION['font_save_error']);
        }
    }

    public static function handle_edit_section_builder_items_title($title){
        global $post;
        if (is_admin() && isset($_GET['post_type']) && $post && $post->post_type === 'section_builder') {
            $post_id = $post->ID;

            if (
                $post_id != get_theme_mod('custom_header') &&
                $post_id != get_theme_mod('custom_footer') &&
                $post_id != get_theme_mod('custom_404_page') &&
                $post_id != get_theme_mod('custom_archive_page')
            ){
                return $title;
            }

            $suffix = __('Default', 'ahura');

            $title = sprintf('%s — %s', $post->post_title, $suffix);
        }
        return $title;
    }
}