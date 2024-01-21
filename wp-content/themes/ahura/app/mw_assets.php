<?php
namespace ahura\app;

use ahura\app\mw_tools;
use ahura\app\Fonts;

class mw_assets
{
    static function get_handle_name($name)
    {
        return 'ahura_script_' . $name;
    }
    static function register_script($name, $src, $deps=['jquery'], $in_footer=true)
    {
        $handle_name = self::get_handle_name($name);
        $version = mw_tools::get_theme_version();
        return wp_register_script($handle_name, $src, $deps, $version, $in_footer);
    }
    static function enqueue_script($handle_name, $src, $deps=['jquery'], $in_footer=true)
    {
        $handle_name = self::get_handle_name($handle_name);
        $version = mw_tools::get_theme_version();
        wp_enqueue_script($handle_name, $src, $deps, $version, $in_footer);
    }
    static function register_style($name, $src, $deps=[])
    {
        $handle_name = self::get_handle_name($name);
        $version = mw_tools::get_theme_version();
        return wp_register_style($handle_name, $src, $deps, $version);
    }
    static function enqueue_style($handle_name, $src, $deps=[])
    {
        $handle_name = self::get_handle_name($handle_name);
        $version = mw_tools::get_theme_version();
        wp_enqueue_style($handle_name, $src, $deps, $version);
    }
    static function localize($name, $object, $data)
    {
        $handle_name = self::get_handle_name($name);
        wp_localize_script($handle_name, $object, $data);
    }
    static function get_assets($file_name, $type, $extension=false)
    {
        $extension = $extension ? $extension : $type;
        $file_name = str_replace('.', '/', $file_name);
        $file_url = sprintf('%s/%s/%s.%s',
                            get_template_directory_uri(),
                            $type,
                            $file_name,
                            $extension
                            );
        return $file_url;
    }
    static function get_css($file_name, $extension=false)
    {
        return self::get_assets($file_name, 'css', $extension);
    }
    static function get_js($file_name, $extension=false)
    {
        return self::get_assets($file_name, 'js', $extension);
    }
    static function get_img($file_name, $extension='png')
    {
        return self::get_assets($file_name, 'img', $extension);
    }

    public static function get_localize_data(){
        $data = [
            'au' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ahura_nonce'),
            'merlin_nonce' => wp_create_nonce('merlin_nonce'),
            'translate' => array(
                'weight'=> __('Weight', 'ahura'),
                'normal'=> __('Normal', 'ahura'),
                'bold'=> __('Bold', 'ahura'),
                'select_font'=> __('Select an Font', 'ahura'),
                'select_file'=> __('Select an File', 'ahura'),
                'select'=> __('Select', 'ahura'),
                'are_you_sure'=> __('Are you sure?', 'ahura'),
                'edit'=> __('Edit', 'ahura'),
                'delete'=> __('Delete', 'ahura'),
                'cancel'=> __('Cancel', 'ahura'),
                'select_woff_file'=> __('Select WOFF File', 'ahura'),
                'select_woff2_file'=> __('Select WOFF2 File', 'ahura'),
                'select_ttf_file'=> __('Select TTF File', 'ahura'),
                'select_svg_file'=> __('Select SVG File', 'ahura'),
                'select_eot_file'=> __('Select EOT File', 'ahura'),
                'studio_import_title'=> __('Import Demo Data', 'ahura'),
                'studio_import_placeholder'=> __('Enable this option to install faster and avoid consuming hosting resources.', 'ahura'),
                'studio_import_progress'=> __('Importing demo is in progress.', 'ahura'),
                'studio_import'=> __('Import', 'ahura'),
                'studio_import_done'=> __('Demo Imported!', 'ahura'),
                'studio_import_error'=> __('Failed Demo Import!', 'ahura'),
                'studio_server_error'=> __('A server side error occurred.', 'ahura'),
                'unknown_error'=> __('An error occurred, please try again.', 'ahura'),
                'studio_sideload_tooltip' => __( 'If you are importing on localhost or if you encounter any problem in importing the demo, if you are using vpn, please turn it off and import again.', 'ahura' ),
                'plz_wait' => __( 'Please Wait...', 'ahura' ),
                'request_is_progress' => __( 'The request is in progress...', 'ahura' ),
                'doing' => __( 'Doing...', 'ahura' ),
            ),
        ];

        return $data;
    }

    static function init()
    {
        $version = mw_tools::get_theme_version();
        $customizer_file = \ahura\app\customization\customizer_save::get_customizer_css_file();
        self::load_font_assets();
        wp_enqueue_style( 'style', get_stylesheet_uri() , null, $version);
        wp_enqueue_style( 'ahura-font-awesome', get_template_directory_uri() . '/css/fontawesome.css', array(), $version);
        wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), $version);
        wp_enqueue_style( 'ahura_bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), $version);
		wp_enqueue_style( 'ahura-assets', get_template_directory_uri() . '/css/assets.css', array(), $version);

        self::enqueue_assets_by_mode('sidebar', mw_options::get_sidebar_mode());

        if (mw_options::get_mod_use_ready_preloader()){
            wp_enqueue_style( 'ahura-preloaders', get_template_directory_uri() . '/css/preloaders.css', array(), $version);
        }

        wp_enqueue_script(self::get_handle_name('assets'), get_template_directory_uri(). '/js/assets.js' , ['jquery'], $version , true);

        if(\ahura\app\mw_options::get_mod_is_show_header_popup_login()){
            wp_enqueue_script(self::get_handle_name('modaljs'), get_template_directory_uri(). '/js/jquery.modal.min.js' , ['jquery'], $version , true);
        }

		if(!is_front_page()){
            wp_enqueue_script('swiperjs', get_template_directory_uri(). '/js/swiper-bundle-min.js' , ['jquery'], $version , false);
            self::enqueue_style('swipercss',self::get_css('swiper-bundle-min'));
            if(woocommerce::is_woocommerce_page()){
                self::enqueue_style('owl_carousel_css', self::get_css('owl-carousel'));
                self::enqueue_script('owl_carousel_js', self::get_js('owl-carousel-min'));
            }
        }

        wp_enqueue_script('ahura_sweetalert_js', get_template_directory_uri() .'/js/sweetalert2.min.js', null, $version, true);

        if(\ahura\app\mw_options::get_mod_show_product_thumbnails_in_slider()){
            wp_enqueue_script('woocommerce_product_slider', get_template_directory_uri() .'/js/product-slider.js', null, $version, true);
        }

        if(is_single() && get_post_type() === 'portfolio'){
            wp_enqueue_script('portfolio_slider', get_template_directory_uri() .'/js/portfolio-slider.js', null, $version, true);
        }

        if(!is_rtl()){
            wp_enqueue_style('ahura-ltr', get_template_directory_uri() . '/ltr.css', array(), $version);
        }

        if(\ahura\app\mw_options::get_mod_is_active_images_lightbox()){
            wp_enqueue_script('simple-lightbox', get_template_directory_uri(). '/js/simple-lightbox-min.js' , ['jquery'], $version , true);
        }

        wp_enqueue_script('menujs', get_template_directory_uri(). '/js/menu.js' , ['jquery'], $version , true);
        wp_localize_script('menujs', 'mm_data', [
            'open_sub_with_click' => get_theme_mod('ahura_open_mobile_submenu_with_click_title'),
            'more_menu_items_status' => \ahura\app\mw_options::get_mod_mega_menu_more_items_status(),
            'more_menu_active_items_count' => \ahura\app\mw_options::get_mod_mega_menu_more_items_count(),
            'more_menu_items_text' => __('Show More Items', 'ahura'),
        ]);

        if(\ahura\app\mw_options::get_mod_is_active_dark_theme()){
            wp_enqueue_script('ahura-dark-mode-js', get_template_directory_uri() . '/js/dark-mode.js', ['jquery'], $version, true);
        }

        if(get_theme_mod('use_ahura_player')){
            self::enqueue_style('player_css', self::get_css('player'));
            self::enqueue_script('player_js', self::get_js('player'));
            $data = [
                'msg' => [
                    'no_video' => __('Can\'t play the video', 'ahura')
                ]
            ];
            self::localize('player_js', 'ahura_player', $data);
        }
        if(get_theme_mod('ahura_fixed_sidebar')){
            wp_enqueue_script('resizeSensor', get_template_directory_uri(). '/js/ResizeSensor.min.js', null , $version , false);
            wp_enqueue_script('theia_sticky_sidebar', get_template_directory_uri(). '/js/theia-sticky-sidebar.min.js' , ['jquery', 'resizeSensor'], $version , false);
        }

        self::enqueue_header_footer_assets();

        wp_enqueue_script('main', get_template_directory_uri(). '/js/main.js' , ['jquery'], $version , false);
        wp_add_inline_script('main', 'var ahura_elementor_players_data = [], ahura_players_timer_countdowns = [];');

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
        if(\ahura\app\mw_options::get_mod_is_ajax_search())
        {
            wp_enqueue_script('mw_ajax_search', get_template_directory_uri() . '/js/ajax_search.js', ['jquery'], $version, true);
            wp_localize_script('mw_ajax_search', 'search_data', ['au' => admin_url('admin-ajax.php')]);
        }
        if(mw_options::get_mod_is_stickyheader())
        {
            self::load_sticky_header();
        }
        if($customizer_file && !is_customize_preview()){
            $version = \ahura\app\customization\customizer_save::getVersion();
            wp_enqueue_style( 'ahura_customizer', $customizer_file, array(), $version);
        }

        if(\ahura\app\mw_options::get_mod_is_active_images_lightbox()){
            self::enqueue_style('simple-lightbox',self::get_css('simple-lightbox-min'));
        }

		$inline_style_file = get_theme_file_path('css/inline-style.css');
		wp_add_inline_style('style', file_get_contents($inline_style_file));

        wp_enqueue_script('ahura_ajax', get_template_directory_uri(). '/js/ajax.js' , ['jquery'], $version);
        wp_localize_script('ahura_ajax', 'ajax_data', [
            'au' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ahura_nonce'),
            'show_captcha' => \ahura\app\mw_options::get_mod_show_login_captcha_code(),
            'translate' => array(
                'already_liked' => __('You have already liked the post.', 'ahura'),
                'already_disliked' => __('You have already disliked the post.', 'ahura'),
                'unknown_error'=> __('An error occurred, please try again.', 'ahura'),
                'invalid_security_code'=> __('Invalid security code.', 'ahura'),
            )
        ]);

        if(mw_options::get_mod_show_product_quick_view() && !woocommerce::is_product() && (woocommerce::is_shop() || is_tax())){
            wp_enqueue_style('ahura_quick_view_product', self::get_css('quick-view-product'), null, $version);
            wp_enqueue_script('ahura_quick_view_product', self::get_js('quick-view-product'), ['jquery'], $version);
            wp_localize_script('ahura_quick_view_product', 'ahura_data', self::get_localize_data());
        }

        self::load_woocommerce_assets();

        self::enqueue_elementor_post_scripts();
    }

    public static function load_woocommerce_assets(){
        if (!woocommerce::is_active())
            return false;

        $version = mw_tools::get_theme_version();

        if (woocommerce::is_woocommerce() && !woocommerce::is_product()){
            wp_enqueue_style('ahura_woocommerce_filters', self::get_css('woocommerce.woocommerce-filters'), null, $version);
            if (!is_rtl()){
                wp_enqueue_style('ahura_woocommerce_filters_ltr', self::get_css('woocommerce.woocommerce-filters-ltr'), null, $version);
            }
        }
    }

    static function load_head_assets()
    {
        if(is_customize_preview()){
            \ahura\app\Fonts::generate_fonts_style_file();
            echo '<style>';
            require_once get_template_directory() . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'css.php';
            echo '</style>';
        }

        if(\ahura\app\mw_options::get_mod_is_active_dark_theme()){
            require_once get_template_directory() . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'dark.php';
        }
    }
    static function load_sticky_header()
    {
        $sticky_header = get_template_directory_uri() . '/js/sticky-header.js';
        $version = mw_tools::get_theme_version();
        wp_enqueue_script('ahura_sticky_header', $sticky_header, ['jquery'], $version, true);
        wp_localize_script('ahura_sticky_header', 'sticky_header_data', [
            'scrolling_top_show' => get_theme_mod('ahura_sticky_header_show_top_scrolling'),
            'only_desktop' => get_theme_mod('ahura_header_sticking_only_desktop'),
        ]);
    }

    static function load_admin_assets($hook_suffix)
    {
        $version = mw_tools::get_theme_version();

        $localize_data = self::get_localize_data();

        if (!empty($hook_suffix)){
            self::load_widgets_management_assets($hook_suffix);
            self::load_nav_menus_assets($hook_suffix);
        }

        global $taxonomy;
        if($taxonomy) {
            taxonomies::load_admin_assets($taxonomy);
        }

        wp_enqueue_style('ahura-font-awesome', get_template_directory_uri() . '/css/fontawesome.css');
        wp_enqueue_style('ahura_admin_style', get_template_directory_uri() .'/css/admin.css');

        wp_enqueue_media();
		wp_enqueue_style('wp-color-picker');

        wp_enqueue_script('ahura_sweetalert_js', get_template_directory_uri() .'/js/sweetalert2.min.js', null, $version, true);
        wp_enqueue_script('ahura_assets_js', get_template_directory_uri() .'/js/assets.js', ['jquery'], $version, true);
        wp_localize_script('ahura_assets_js', 'assets_data', $localize_data);
        wp_enqueue_script('ahura_admin_js', get_template_directory_uri() .'/js/admin/admin.js', ['jquery', 'wp-color-picker'], $version, true);
        wp_localize_script('ahura_admin_js', 'ahura_data', $localize_data);

        wp_enqueue_script('ahura_admin_ajax_js', get_template_directory_uri() .'/js/admin/admin-ajax.js', ['jquery'], $version, true);
        wp_localize_script('ahura_admin_ajax_js', 'ahura_data', $localize_data);

        if(Studio::is_studio()){
            wp_enqueue_style('ahura_studio_style', get_template_directory_uri() .'/css/studio.css');
            if(!is_rtl()){
                wp_enqueue_style('ahura_studio_ltr_style', get_template_directory_uri() .'/css/studio-ltr.css');
            }
            wp_enqueue_script('ahura_studio_js', get_template_directory_uri() .'/js/admin/studio.js', ['jquery'], MERLIN_VERSION, true);
            wp_localize_script('ahura_studio_js', 'ahura_data', $localize_data);
        }
    }
    static function load_font_assets()
    {
        if(is_rtl() || mw_options::get_mod_use_fa_fonts_status()){
            $version = rand(1, 999999);

            $fonts_style = Fonts::get_fonts_stylesheet_uri();

            if(!empty($fonts_style)){
                wp_enqueue_style('ahura_fonts', $fonts_style, null, $version);
            }
        }
    }
    static function load_widgets_management_assets($hook_suffix)
    {
        if($hook_suffix !== 'widgets.php')
        {
            return false;
        }
        $version = \ahura\app\mw_tools::get_theme_version();
        $admin_widget_js = get_template_directory_uri() . '/js/admin_widgets.js';
        self::load_media_uploader();
        wp_enqueue_script('ahura_widget_manage', $admin_widget_js, ['jquery'], $version, true);
        wp_localize_script( 'ahura_widget_manage', 'ahura_widget_manage_translate',[
            'Title' => __('Title','ahura'),
            'Value' => __('Value','ahura'),
            'TitlePlaceholder' => __('Please enter the title','ahura'),
            'ValuePlaceholder' => __('Please enter the value','ahura'),
            'Delete' => __('Delete','ahura')
        ]
        );
    }
    static function load_media_uploader()
    {
        wp_enqueue_media();
    }

    /**
     *
     *
     * Method for hook elementor/editor/after_enqueue_scripts
     *
     *
     */
    static function load_elementor_editor_scripts()
    {
        $version = \ahura\app\mw_tools::get_theme_version();
        $elementor = get_template_directory_uri() .'/css/fonts/elementor.css';
        wp_enqueue_style('ahura_elementor_style', $elementor);
		wp_enqueue_style( 'ahura-assets', get_template_directory_uri() . '/css/assets.css', array(), $version);

        self::enqueue_script('elementor_editor_js', self::get_js('elementor-editor'), [], false);
        wp_localize_script(self::get_handle_name('elementor_editor_js'), 'ahura_editor_data', [
            'paste_title' => __('Paste Ahura Element','ahura'),
        ]);
    }

    /**
     *
     *
     * Method for hook elementor/editor/after_enqueue_styles
     *
     *
     */
    static function load_elementor_editor_styles(){
        $version = mw_tools::get_theme_version();
        wp_enqueue_style('ahura_icons_css', get_template_directory_uri() .'/css/ahura-icons.css', $version);
        wp_enqueue_style('elementor_editor_css', get_template_directory_uri() .'/css/elementor-editor.css', $version);
        if(!mw_tools::is_active_elementor_pro()){
            wp_enqueue_style('elementor_editor_lite_css', get_template_directory_uri() .'/css/elementor-editor-lite.css', $version);
        }
        wp_enqueue_style('mw_ahura_elementor_font_css', get_template_directory_uri() . '/css/customization/dana.css', [], mw_tools::get_theme_version());
    }

    static function load_elementor_preview_assets()
    {
        $elem = get_template_directory_uri() . '/css/elem.css';
        wp_enqueue_style('mw_elem', $elem, null, mw_tools::get_theme_version());
    }

    static function load_woocommerce_mini_cart()
    {
        if(woocommerce::is_active())
        {
            $cart_js = get_template_directory_uri() . '/js/cart.js';
            $version = \ahura\app\mw_tools::get_theme_version();
            wp_enqueue_script('ahura_cart', $cart_js, ['jquery'], $version, true);
            wp_localize_script('ahura_cart', 'ahura_cart', ['au' => admin_url('admin-ajax.php')]);
        }
    }

    static function load_nav_menus_assets($hook_suffix)
    {
        if($hook_suffix !== 'nav-menus.php')
        {
            return false;
        }
        self::load_uploader_assets();

        $navMenuJS = get_template_directory_uri() . '/js/admin_nav_menus.js';
        wp_enqueue_script('mw_admin_nav_menus', $navMenuJS, ['jquery'], mw_tools::get_theme_version(), true);
    }

    public static function load_uploader_assets(){
        self::load_media_uploader();
        $media_uploader =get_template_directory_uri() . '/js/mw_uploader.js';
        wp_enqueue_script('mw_nav_media_uploader', $media_uploader, ['jquery'], mw_tools::get_theme_version(), true);
    }

    static function load_customization_assets()
    {
        $version = mw_tools::get_theme_version();
        $customization_js = get_template_directory_uri() . '/js/customization.js';
        $customization_main_css = get_template_directory_uri() . '/css/customization/main.css';
        $customization_font_css = get_template_directory_uri() . '/css/customization/dana.css';
        wp_enqueue_style('mw_ahura_customization_main_css', $customization_main_css, [], $version);
        wp_enqueue_style('select2', get_template_directory_uri() . '/css/select2.min.css', [], $version);

        wp_enqueue_script('select2', get_template_directory_uri() . '/js/select2.min.js', [], $version);
        wp_enqueue_script('mw_ahura_customization', $customization_js, ['jquery'], $version, true);
        wp_localize_script('mw_ahura_customization', 'ahura_customizer_data', array(
            'au' => admin_url('admin-ajax.php'),
			'reset'   => __('Reset', 'ahura'),
			'confirm' => __("Attention!\n\nThis will remove all customizations ever made via customizer to this theme.\n\nThis action is irreversible.", 'ahura'),
            'empty_import' => __('Please choose a file to import.', 'ahura'),
            'customizer_url' => admin_url('customize.php'),
			'nonce'   => array(
                'export' => wp_create_nonce('ahura-exporting'),
				'reset' => wp_create_nonce('ahura-customizer-reset'),
			),
            'translate' => array(
                'select' => __('Select...', 'ahura'),
            ),
		));
        wp_enqueue_style('mw_ahura_customization_font_css', $customization_font_css, [], $version);

        wp_enqueue_style('ahura_panels_icon_style', get_template_directory_uri() . '/css/customization/panels-icon.css');

        wp_enqueue_script('ahura_customizer_search_js', get_template_directory_uri() .'/js/admin/customization/customizer-search.js', ['jquery'], $version, true);
        wp_localize_script('ahura_customizer_search_js', 'ahura_data', [
            'texts' => [
                'search' => __('Search', 'ahura'),
                'placeholder' => __('What are you looking for?', 'ahura'),
                'clear' => __('Clear', 'ahura'),
            ]
        ]);
    }

    protected static function enqueue_header_footer_assets(){
        self::enqueue_assets_by_mode('header', mw_options::get_header_style());
        self::enqueue_assets_by_mode('footer', mw_options::get_footer_style());
    }

    protected static function enqueue_assets_by_mode($key, $mode){
        $version = mw_tools::get_theme_version();
        $theme_dir = get_template_directory();
        $theme_dir_uri = get_template_directory_uri();
        $mode_id = $mode;
        $file_name = sprintf($key . '-%s', $mode_id);
        $ltr_file_name = sprintf($key . '-%s-ltr', $mode_id);
        $dark_file_name = sprintf($key . '-%s-dark', $mode_id);
        $css_dir = '/css/' . $key . '/';
        $css_ltr_dir = $css_dir . 'ltr/';
        $css_dark_dir = $css_dir . 'dark/';
        $js_dir = '/js/' . $key . '/';
        $css_file_name = $file_name . '.css';
        $css_dark_file_name = $dark_file_name . '.css';
        $css_ltr_file_name = $ltr_file_name . '.css';
        $js_file_name = $file_name . '.js';

        $css_url = $css_dir . $css_file_name;
        $ltr_css_url = $css_dir . 'ltr/' . $css_ltr_file_name;
        $dark_css_url = $css_dir . 'dark/' . $css_dark_file_name;
        $js_url = $js_dir . $js_file_name;

        if(file_exists($theme_dir . $css_dir . $css_file_name)){
            wp_enqueue_style("ahura_{$key}_style_" . $mode_id, $theme_dir_uri . $css_url, $version);
        }
        if(mw_options::get_mod_is_active_dark_theme() && file_exists($theme_dir . $css_dark_dir . $css_dark_file_name)){
            wp_enqueue_style("ahura_{$key}_style_dark_" . $mode_id, $theme_dir_uri . $dark_css_url, $version);
        }
        if(file_exists($theme_dir . $css_ltr_dir . $css_ltr_file_name) && !is_rtl()){
            wp_enqueue_style("ahura_{$key}_style_ltr_" . $mode_id, $theme_dir_uri . $ltr_css_url, $version);
        }
        if(file_exists($theme_dir . $js_dir . $js_file_name)){
            wp_enqueue_script("ahura_{$key}_script_" . $mode_id, $theme_dir_uri . $js_url, ['jquery'], $version, true);
            wp_localize_script("ahura_{$key}_script_" . $mode_id, 'ahura_data', self::get_localize_data());
        }
    }

    protected static function enqueue_elementor_post_scripts(){
        if(!is_active_elementor()) return;

        if ( class_exists( '\Elementor\Plugin' ) ) {
            $elementor = \Elementor\Plugin::instance();
            $elementor->frontend->enqueue_styles();
        }

        if ( class_exists( '\ElementorPro\Plugin' ) ) {
            $elementor_pro = \ElementorPro\Plugin::instance();
            $elementor_pro->enqueue_styles();
        }

        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
            $css_file = new \Elementor\Core\Files\CSS\Post(mw_options::get_custom_header_id());
        } elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
            $css_file = new \Elementor\Post_CSS_File(mw_options::get_custom_header_id());
        }

        if (isset($css_file))
            $css_file->enqueue();

        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
            $css_file = new \Elementor\Core\Files\CSS\Post(mw_options::get_custom_footer_id());
        } elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
            $css_file = new \Elementor\Post_CSS_File(mw_options::get_custom_footer_id());
        }

        if (isset($css_file))
            $css_file->enqueue();
    }
}
