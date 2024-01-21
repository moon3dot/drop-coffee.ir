<?php
namespace ahura\app;

class mw_config
{
    public const MINIMUM_PHP_VER = '7.4';

    public static function getParentMenuSlug(){
        return license::is_active() ? 'admin.php?page=ahura-wizard&step=content' : 'ahura-wizard';
    }

    static function before_mini_cart()
    {
        echo '<div id="mcart-widget" class="mini-cart-header-content">';
    }
    static function after_minicart()
    {
        echo '</div>';
    }
    static function minicart_fragments($fragments)
    {
        ob_start();
        woocommerce_mini_cart();
        $fragments['#mcart-widget'] = ob_get_clean();
        return $fragments;
    }
    static function image_sizes()
    {
        add_image_size('stthumb',600,350, true);
        add_image_size('sqthumb',250,250, true);
        add_image_size('verthumb',500,600, true);
        add_image_size('smthumb',100,100, true);
    }
    static function after_setup_theme()
    {
        self::load_text_domain();
        self::theme_support();
        self::image_sizes();
        self::init_check_license_process();
        self::handle_db_version_changes();
    }
    static function load_text_domain()
    {
        load_theme_textdomain( 'ahura', get_template_directory() . '/languages' );
    }
    static function theme_support()
    {
        add_theme_support('title-tag');
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'woocommerce', array(
            'thumbnail_image_width' => 300,
            'single_image_width'    => 600,
            'product_grid'          => array(
                'default_rows'    => 4,
                'min_rows'        => 2,
                'max_rows'        => 8,
                'default_columns' => 3,
                'min_columns'     => 2,
                'max_columns'     => 3,
            ),
        ) );
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        if(class_exists('LifterLMS')){
            add_theme_support('lifterlms-sidebars');
        }
    }
    static function reset_minicart_template_path($template, $template_name, $template_path)
    {
        if($template_name !== 'cart/mini-cart.php'){
            return $template;
        }
        $woocommerce_path = \WC()->plugin_path();
        $default_path = $woocommerce_path . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        // check is mini cart exists in theme
        $mini_cart_template = locate_template([
            trailingslashit($template_path) . $template_name,
            $template_name
        ]);
        if(!$mini_cart_template){
            $mini_cart_template = $default_path . $template_name;
        }
        return $mini_cart_template;
    }
    static function init_check_license_process()
    {
        if(!wp_next_scheduled('ahura_check_license'))
        {
            $hour = mt_rand(0, 23);
            $minute = mt_rand(0, 59);
            $second = mt_rand(0, 59);
            $time = strtotime("Y-m-d {$hour}:{$minute}:{$second}", strtotime('+1 day'));
            wp_schedule_event($time, 'daily', 'ahura_check_license');
        }
    }
    static function handle_upgrader_process_complete($upgrade_object, $options)
    {
        if($options['action'] == 'update' && $options['type'] == 'theme' && in_array('ahura', $options['themes']))
        {
            \ahura\app\customization\customizer_save::generate();
        }
    }

    static function add_theme_settings_menu()
    {
        add_menu_page(
            __( 'Ahura', 'ahura' ),
            __( 'Ahura', 'ahura' ),
            'manage_options',
            self::getParentMenuSlug(),
            null,
            get_template_directory_uri() . '/img/mihanwp.png'
        );
    }

    static function add_theme_settings_sub_menu()
    {
        if (license::is_active()){
            add_submenu_page(self::getParentMenuSlug(),__('Studio','ahura'),__('Studio','ahura'),'manage_options', self::getParentMenuSlug());
        }
        add_submenu_page(self::getParentMenuSlug(), __( 'Theme Settings', 'ahura' ), __( 'Theme Settings', 'ahura' ), 'manage_options', 'customize.php');
        if(\ahura\app\mw_options::is_ahura_builder_accessible()){
            add_submenu_page(self::getParentMenuSlug(),__('Section builder','ahura'), __('Builder','ahura'),'manage_options',admin_url().'/edit.php?post_type=section_builder');
        }
        add_submenu_page(self::getParentMenuSlug(),__('Ahura Fonts','ahura'),__('Ahura Fonts','ahura'),'manage_options',admin_url().'/edit.php?post_type=ahura_fonts');
        $childMenuHookSuffix = add_submenu_page(self::getParentMenuSlug(),__('Child theme','ahura'),__('Child theme','ahura'),'manage_options', 'ahura_child_theme', ['\ahura\app\child_theme', 'admin_menu_callback']);
        add_action('load-' . $childMenuHookSuffix, ['\ahura\app\child_theme', 'load_admin_menu_assets']);

        if (!defined('AHURA_LICENSE_KEY')){
            $title = esc_html__('Ahura License', 'ahura');
            add_submenu_page(self::getParentMenuSlug(),$title, $title, 'manage_options', 'ahura-license', ['\ahura\app\license', 'license_menu_c']);
        }

        add_submenu_page(self::getParentMenuSlug(), __('Ahura Theme Guide','ahura'), __('Ahura Theme Guide','ahura'), 'manage_options', ahura_get_theme_guide_url('primary'));
    }

    static function handle_db_version_changes()
    {
        $current_version = mw_options::get_db_version();
        if($current_version < AHURA_DB_VERSION)
        {
            if($current_version < 1)
            {
                /**
                 * in this version
                 * custom post type and custom taxonomy was generated
                 * need to rewrite flush rules
                */
                 flush_rewrite_rules();
            }
            mw_options::update_db_version(AHURA_DB_VERSION);
        }
    }
    static function add_custom_upload_mimes($existing_mimes) {
        if(is_admin()){
            $existing_mimes['ttf'] = 'application/x-font-ttf';
            $existing_mimes['woff'] = 'application/font-woff';
            $existing_mimes['woff2'] = 'application/font-woff2';
            $existing_mimes['eot'] = 'application/vnd.ms-fontobject';
            if (\ahura\app\mw_options::get_theme_option('ahura_allow_upload_svg')){
                $existing_mimes['svg'] = 'image/svg+xml';
            }
            if (\ahura\app\mw_options::get_theme_option('ahura_allow_upload_json')){
                $existing_mimes['json'] = 'application/json';
            }
            if (\ahura\app\mw_options::get_theme_option('ahura_allow_upload_webp')){
                $existing_mimes['webp'] = 'image/webp';
            }
            if (\ahura\app\mw_options::get_theme_option('ahura_allow_upload_ico')){
                $existing_mimes['ico'] = 'image/x-icon';
            }
        }
        return $existing_mimes;
    }

    public static function enable_upload_ico_file($types, $file, $filename, $mimes) {
        if (is_admin() && \ahura\app\mw_options::get_theme_option('ahura_allow_upload_ico') && false !== strpos( $filename, '.ico')) {
            $types['ext'] = 'ico';
            $types['type'] = 'image/ico';
        }

        return $types;
    }

    static function set_lifterlms_default_sidebar($id){
        $sidebar_id = 'ahura_llms_primary_sidebar';
        return $sidebar_id;
    }

    /**
     * 
     * 
     * Register default template fullwidth for elementor builder page
     * 
     * 
     */
    static function elementor_builder_default_template_types($template){
		$post_id = get_queried_object_id();

		if (empty($post_id)) {
			return $template;
		}

        if (!empty($post_id)) {
            $template_type = get_post_meta($post_id, '_elementor_template_type', true);
        }
    
        if ('section_builder' !== get_post_type() || !in_array($template_type, ['wp-post', 'page'], true)) {
            return $template;
        }

        if(!class_exists('\ahura\app\elementor\Ahura_Elementor_Builder'))
        {
            return $template;
        }

        $builder = new \ahura\app\elementor\Ahura_Elementor_Builder();

        if($builder->isPreviewMode()){
            add_filter('show_admin_bar', '__return_false');
        }

        return get_parent_theme_file_path('/fullwidth.php');
    }

    public static function _notice_minimum_version($property, $minimum_version, $current_version, $notice_type = 'warning'){
        if((!empty($minimum_version) && !empty($current_version)) && version_compare($current_version, $minimum_version, '<')){
            $str_before = '<strong>';
            $str_after = '</strong>';
            $message = sprintf(
                esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'ahura'),
                $str_before . esc_html__('Ahura', 'ahura') . $str_after,
                $str_before . $property . $str_after,
                $minimum_version
            );
            return sprintf('<div class="notice ah-notice ah-%1$s is-dismissible"><p>%2$s</p></div>', $notice_type, $message);
        }
        return false;
    }

    public static function _check_requirements_minimum_version_callback(){
        echo self::_notice_minimum_version('PHP', self::MINIMUM_PHP_VER, PHP_VERSION, 'error');
    }

    public static function _requirements_notice_callback(){
        $errors = [];
        $warnings = [];

        $site_url = strtolower(get_option('siteurl'));
        $home_url = strtolower(get_option('home'));
        if(ahura_is_ssl() && (strpos($site_url, 'http://') !== false || strpos($home_url, 'http://') !== false)){
            $errors[] = __('Your website supports SSL, change the values of http to https in the site addresses through the general settings of wordpress.', 'ahura');
        }

        $permalink_name = get_option('permalink_structure');
        if(strpos($permalink_name, 'postname') === false){
            $errors[] = __('Set wordpress permalinks to the post name, if you don`t do this, you may encounter a 404 error on the website and editing pages.', 'ahura');
        }

        if(!is_active_elementor()){
            $errors[] = __('Elementor page builder plugin is not active, install and activate Elementor.', 'ahura');
        }

        if(!empty($errors)){
            printf('<div class="notice ah-notice ah-error is-dismissible">%s</div>', implode('<hr>',$errors));
        }

        if(!empty($warnings)){
            printf('<div class="notice ah-notice ah-warning is-dismissible">%s</div>', implode('<hr>',$warnings));
        }
    }

    public static function has_minimum_php_version(){
        return version_compare(PHP_VERSION, self::MINIMUM_PHP_VER, '>=');
    }

    public static function append_to_admin_footer(){
        if(isset($_GET['post_type']) && $_GET['post_type'] == 'section_builder'){
            include_once get_template_directory() . '/template-parts/admin/admin-footer.php';
        }
    }
}