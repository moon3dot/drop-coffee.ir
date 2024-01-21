<?php

namespace ahura\app;

class mw_options
{
    public static $_tesimonial_username_option_name = 'ahura_testimonial_username';
    public static $_tst_user_sitename = 'ahura_testimonial_sitename';
    public static $_page_is_sticky_header = 'ahura_page_is_sticky_header';
    public static $_page_is_transparent_header = 'ahura_page_is_transparent_header';
    private static $_page_is_float_mode_header = 'ahura_page_is_float_mode_header';
    private static $_page_breadcrumb = 'ahura_page_breadcrumb';

    public static function get_db_version()
    {
        return intval(get_option('ahura_db_version'));
    }

    public static function update_db_version($new_version)
    {
        return update_option('ahura_db_version', $new_version);
    }

    public static function set_testimonial_username($pid, $value)
    {
        return update_post_meta($pid, self::$_tesimonial_username_option_name, $value);
    }

    public static function get_testimonial_username($pid)
    {
        return get_post_meta($pid, self::$_tesimonial_username_option_name, true);
    }

    public static function remove_testimonial_username($pid)
    {
        return delete_post_meta($pid, self::$_tesimonial_username_option_name);
    }

    public static function set_testimonial_sitename($pid, $value)
    {
        return update_post_meta($pid, self::$_tst_user_sitename, $value);
    }

    public static function get_testimonial_sitename($pid)
    {
        return get_post_meta($pid, self::$_tst_user_sitename, true);
    }

    public static function remove_testimonial_sitename($pid)
    {
        return delete_post_meta($pid, self::$_tst_user_sitename);
    }

    public static function set_page_is_sticky_header($pid, $status = 1) // 1: active, 2: inactive
    {
        return update_post_meta($pid, self::$_page_is_sticky_header, $status);
    }

    public static function get_page_is_sticky_header($pid)
    {
        return intval(get_post_meta($pid, self::$_page_is_sticky_header, true));
    }

    public static function remove_page_is_sticky_header($pid)
    {
        return delete_post_meta($pid, self::$_page_is_sticky_header);
    }

    public static function set_page_is_transparent_header($pid, $status = 1) // 1: active, 2: inactive
    {
        return update_post_meta($pid, self::$_page_is_transparent_header, $status);
    }

    public static function get_page_is_transparent_header($pid)
    {
        return intval(get_post_meta($pid, self::$_page_is_transparent_header, true));
    }

    public static function remove_page_is_transparent_header($pid)
    {
        return delete_post_meta($pid, self::$_page_is_transparent_header);
    }

    public static function get_page_is_float_mode_header($pid)
    {
        return intval(get_post_meta($pid, self::$_page_is_float_mode_header, true));
    }

    public static function set_page_is_float_mode_header($pid)
    {
        return update_post_meta($pid, self::$_page_is_float_mode_header, 1);
    }

    public static function remove_page_is_float_mode_header($pid)
    {
        return delete_post_meta($pid, self::$_page_is_float_mode_header);
    }

    public static function set_page_show_breadcrumb($pid)
    {
        return update_post_meta($pid, self::$_page_breadcrumb, 'show');
    }

    public static function set_page_hide_breadcrumb($pid)
    {
        return update_post_meta($pid, self::$_page_breadcrumb, 'hide');
    }

    public static function get_page_breadcrumb_status($pid)
    {
        return get_post_meta($pid, self::$_page_breadcrumb, true);
    }

    public static function remove_page_show_breadcrumb($pid)
    {
        return delete_post_meta($pid, self::$_page_breadcrumb);
    }

    public static function get_theme_option($key, $default = ''){
        return get_theme_mod($key, $default);
    }

    public static function get_mod_logo_option(){
        return get_theme_mod('ahura_theme_logo');
    }

    public static function get_mod_theme_logo()
    {
        $logo = self::get_mod_logo_option();
        if (!$logo) {
            $logo = get_template_directory_uri() . '/img/ahura-logo.png';
        }
        return $logo;
    }

    public static function get_mod_logo_text(){
        return get_theme_mod('ahura_logo_text');
    }

    public static function get_mod_theme_dark_logo()
    {
        $logo = get_theme_mod('ahura_theme_dark_logo');
        if (!$logo) {
            $logo = get_template_directory_uri() . '/img/ahura-logo.webp';
        }
        return $logo;
    }

    public static function get_mod_dark_mode_has_scheduler()
    {
        return get_theme_mod('ahura_dark_mode_has_scheduler', false);
    }

    public static function get_mod_dark_mode_schedule_start_time()
    {
        return get_theme_mod('ahura_dark_mode_schedule_start_time');
    }

    public static function get_mod_dark_mode_schedule_end_time()
    {
        return get_theme_mod('ahura_dark_mode_schedule_end_time');
    }
    public static function get_mod_theme_use_mobile_logo()
    {
        return get_theme_mod('ahura_use_mobile_logo', false);
    }

    public static function get_mod_theme_mobile_logo()
    {
        $logo = get_theme_mod('ahura_theme_mobile_logo', false);
        return ($logo) ? $logo : false;
    }

    public static function get_mod_is_ajax_search()
    {
        return get_theme_mod('ahura_is_active_ajax_search', true);
    }

    public static function page_has_breadcsrumb()
    {
        if (!is_page() || is_front_page()) {
            return get_theme_mod('show_breadcrumb');
        }
        $pid = get_the_ID();
        $breadcrumb = self::get_page_breadcrumb_status($pid);
        if (!$breadcrumb) {
            // return setting value
            return get_theme_mod('show_breadcrumb');
        }
        return $breadcrumb == 'show' ? true : false;
    }

    public static function get_mod_is_stickyheader()
    {
        $pid = get_the_ID();
        // check is sticky from metabox option
        $sticky_state = self::get_page_is_sticky_header($pid);
        if ($sticky_state) {
            return $sticky_state == 1;
        }
        return get_theme_mod('stickyheader', true);
    }

    public static function get_mod_header_cta_btn_text()
    {
        return get_theme_mod('ahura_header_cta_btn_text', __("Let's Start", 'ahura'));
    }

    public static function show_header_cta_btn()
    {
        return get_theme_mod('show_ahura_header_cta_btn', true);
    }

    public static function get_mod_header_cta_btn_url()
    {
        return get_theme_mod('ahura_header_cta_btn_url');
    }

    public static function get_mod_show_header_after_login_cta_btn()
    {
        return get_theme_mod('show_ahura_header_after_login_cta_btn', false);
    }

    public static function get_mod_header_after_login_cta_btn_text()
    {
        return get_theme_mod('ahura_header_after_login_cta_btn_text', __('User Account', 'ahura'));
    }

    public static function get_mod_header_after_login_cta_btn_url()
    {
        return get_theme_mod('ahura_header_after_login_cta_btn_url');
    }

    public static function get_mod_header_cats_menu_title()
    {
        return get_theme_mod('ahura_mega_menu_title', __("Category Menu", 'ahura'));
    }

    public static function get_mod_bg_color()
    {
        return get_theme_mod('bgcolor', 'white');
    }

    public static function get_mod_theme_color()
    {
        return get_theme_mod('themecolor', '#00b0ff');
    }

    public static function get_mod_secondary_color()
    {
        return get_theme_mod('ahura_secondary_color', 'white');
    }

    public static function get_mod_theme_font()
    {
        if (get_bloginfo('language') == 'fa-IR') {
            return get_theme_mod('ahura_theme_font', 'iranyekan');
        } else {
            return get_theme_mod('ahura_en_theme_font', 'default_font');
        }
    }

    public static function get_mod_transparent_header_content_color()
    {
        return get_theme_mod('ahura_header_transparent_content_color');
    }

    public static function get_mod_ahorua_transparent_logo()
    {
        return get_theme_mod('ahorua_transparent_logo');
    }

    public static function get_mod_theme_columns()
    {
        return get_theme_mod('ahura_columns', '2c');
    }

    public static function get_mod_theme_page_columns()
    {
        return get_theme_mod('ahura_page_columns', '2c');
    }

    public static function get_mod_product_columns()
    {
        return get_theme_mod('ahura_product_page_columns', '2c');
    }

    public static function get_mod_shop_columns()
    {
        return get_theme_mod('ahura_shop_columns', '2c');
    }

    public static function get_mod_woocommerce_checkout_order_comments()
    {
        return get_theme_mod('woocommerce_checkout_order_comments') == 'hidden';
    }

    public static function get_mod_ahura_checkout_fields_label()
    {
        return get_theme_mod('ahura_checkout_fields_label', false);
    }

    public static function get_theme_columns()
    {
        $theme_cols = self::get_mod_theme_columns();
        $is_woocommerce_page = woocommerce::is_woocommerce_page();

        if ($is_woocommerce_page) {
            $theme_cols = ($theme_cols != self::get_mod_shop_columns()) ? self::get_mod_shop_columns() : $theme_cols;
        } else {
            $theme_cols = ($theme_cols != self::get_mod_theme_page_columns()) ? self::get_mod_theme_page_columns() : $theme_cols;
        }

        if(woocommerce::is_active()) {
            if(is_product()){
                $theme_cols = ($theme_cols != self::get_mod_product_columns()) ? self::get_mod_product_columns() : $theme_cols;
            }
        }

        if($is_woocommerce_page) {
            if(is_cart() || is_checkout()){
                $theme_cols = '1c';
            }
        } 

        return $theme_cols;
    }

    public static function get_mod_goto_top_btn_position()
    {
        return get_theme_mod('ahura_goto_top_position', 'right');
    }

    public static function get_show_goto_top_button(){
        return self::get_mod_goto_top_btn_position() != 'none';
    }

    public static function get_mod_is_justify_paragraph()
    {
        return get_theme_mod('ahura_paragraph_alignment', true);
    }

    public static function check_is_show_mini_cart_option()
    {
        return woocommerce::is_active();
    }

    public static function mini_cart_hide_content()
    {
        return get_theme_mod('ahura_mini_cart_hide_content', false);
    }

    public static function get_mod_is_active_mini_cart()
    {
        return self::get_mod_is_not_active_custom_header() ? get_theme_mod('ahorua_show_mini_cart') : false;
    }

    public static function get_mod_is_active_mini_cart_count()
    {
        return self::get_mod_is_active_mini_cart() ? get_theme_mod('ahura_show_mini_cart_count') : false;
    }

    public static function check_is_transparent_header_in_single_page()
    {
        $pid = get_the_ID();
        $transparency_state = self::get_page_is_transparent_header($pid);
        return $transparency_state;
    }

    public static function check_is_transparent_header()
    {
        if (!is_customize_preview() && !is_front_page()) {
            $transparency_state = self::check_is_transparent_header_in_single_page();
            if ($transparency_state) {
                return $transparency_state == 1;
            }
        }
        return get_theme_mod('ahura_header_is_transparent');
    }

    public static function check_has_footer_bg()
    {
        $option = get_theme_mod('ahura_footer_bg');
        return $option ? true : false;
    }

    public static function sanitize_select_field($input, $setting)
    {
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control($setting->id)->choices;
        return array_key_exists($input, $choices) ? $input : $setting->default;
    }

    public static function get_mod_logo_alignment()
    {
        return get_theme_mod('ahura_header_logo_alignment', 'right');
    }

    public static function get_mod_header_menu_alignment()
    {
        return get_theme_mod('ahura_menu_alignment', 'left');
    }

    public static function get_mod_header_menu_position()
    {
        return get_theme_mod('ahura_menu_position', 'middle');
    }

    public static function get_mod_sticky_header_menu_position()
    {
        return get_theme_mod('ahura_menu_position_sticky_header', 'middle');
    }

    public static function get_mod_action_btn_alignment()
    {
        return get_theme_mod('ahura_action_btn_alignment', 'left');
    }

    public static function get_mod_mega_menu_alignment()
    {
        return get_theme_mod('ahura_mega_menu_alignment', 'right');
    }

    public static function get_mod_show_mega_menu()
    {
        return self::get_mod_is_not_active_custom_header() ? get_theme_mod('ahura_show_mega_menu', true) : false;
    }

    public static function ahura_mega_menu_dynamic_alignment()
    {
        if (self::get_mod_is_active_custom_header()) {
            return false;
        }
        if (!get_theme_mod('ahura_mega_menu_dynamic_alignment')) {
            return get_theme_mod('ahura_show_mega_menu', true);
        }
        return false;
    }

    public static function get_mod_is_active_mega_menu()
    {
        return self::get_mod_is_not_active_custom_header() ? get_theme_mod('ahura_show_mega_menu', true) : false;
    }

    public static function mega_menu_alignment()
    {
        if (get_theme_mod('ahura_mega_menu_dynamic_alignment')) {
            if (is_rtl()) {
                return 'right';
            } else {
                return 'left';
            }
        }
        return get_theme_mod('ahura_mega_menu_alignment');
    }

    public static function get_mod_header_top_box_background_color()
    {
        return get_theme_mod('ahura_header_top_box_background_color', '#ffffff');
    }

    public static function get_mod_header_bottom_box_background_color()
    {
        return get_theme_mod('ahura_header_bottom_box_background_color', '#ffffff');
    }

    public static function get_mod_header_top_and_bottom_box_text_color()
    {
        return get_theme_mod('ahura_header_top_and_bottom_box_text_color', '#35495C');
    }

    public static function get_mod_mega_menu_wrapper_background_color()
    {
        return get_theme_mod('ahura_mega_menu_wrapper_background_color', '#ffffff');
    }

    public static function get_mod_mega_menu_wrapper_text_color()
    {
        return get_theme_mod('ahura_mega_menu_wrapper_text_color', '#35495C');
    }

    public static function get_mod_mega_menu_item_border_color()
    {
        return get_theme_mod('ahura_mega_menu_item_border_color', '#f6f6f6');
    }

    public static function get_mod_is_show_header_top_border()
    {
        return self::get_mod_is_not_active_custom_header() ? get_theme_mod('ahura_is_show_header_top_border', true) : false;
    }

    public static function get_mod_header_top_border_height()
    {
        return get_theme_mod('ahura_header_top_border_height', 4);
    }

    public static function get_mod_is_active_searhc_box()
    {
        return self::get_mod_is_not_active_custom_header() ? !get_theme_mod('ahura_remove_header_search_box') : false;
    }

    public static function check_is_header_menu_alignment_accessible()
    {
        if (self::get_mod_is_active_custom_header()) {
            return false;
        }
        // when menu position is not in middle
        $menu_position = self::get_mod_header_menu_position();
        return $menu_position !== 'middle';
    }

    public static function check_is_header_top_box_background_color_accessible()
    {
        if (self::get_mod_is_active_custom_header()) {
            return false;
        }
        // when menu position is top
        $menu_position = self::get_mod_header_menu_position();
        return $menu_position == 'top';
    }

    public static function check_is_header_bottom_box_background_color_accessible()
    {
        if (self::get_mod_is_active_custom_header()) {
            return false;
        }
        // when menu position is bottom
        $menu_position = self::get_mod_header_menu_position();
        return $menu_position == 'bottom';
    }

    public static function check_is_header_top_and_bottom_box_text_color_accessible()
    {
        if (self::get_mod_is_active_custom_header()) {
            return false;
        }
        // when menu position is top OR bottom
        $menu_position = self::get_mod_header_menu_position();
        return $menu_position == 'top' || $menu_position == 'bottom';
    }

    public static function get_mod_show_ahura_header_cta_btn()
    {
        return self::get_mod_is_not_active_custom_header() ? get_theme_mod('show_ahura_header_cta_btn', true) : false;
    }

    public static function get_mod_is_show_header_popup_login()
    {
        return self::get_mod_is_not_active_custom_header() ? get_theme_mod('ahorua_header_popup_login', true) : false;
    }


    public static function get_mod_is_show_header_popup_register()
    {
        return self::get_mod_is_not_active_custom_header() ? get_theme_mod('ahura_header_show_popup_login_register_text', false) : false;
    }

    public static function get_mod_is_show_header_popup_register_button()
    {
        return self::get_mod_is_not_active_custom_header() ? get_theme_mod('ahura_header_show_popup_login_register_text', false) : false;
    }
    
    public static function get_mod_header_popup_register_button_text(){
        return get_theme_mod('ahura_header_popup_login_register_text');
    }

    public static function get_mod_header_popup_register_button_link(){
        return get_theme_mod('ahura_header_popup_login_register_link');
    }

    public static function get_mod_use_fa_fonts_status(){
        return get_theme_mod('use_fa_fonts', false);
    }

    public static function get_mod_not_use_fa_fonts_status(){
        return !get_theme_mod('use_fa_fonts');
    }

    public static function get_ahura_fonts($has_empty_option = true)
    {
        $fonts = array();

        if ($has_empty_option){
            $fonts[''] = '';
        }

        if(!is_rtl()) {
            $fonts = [
                'default_font' => 'Default',
                'arial' => 'Arial',
                'cambria' => 'Cambria',
                'candara' => 'Candara',
                'consolas' => 'Consolas',
                'constantia' => 'Constantia',
            ];
        }

        if (is_rtl() || self::get_mod_use_fa_fonts_status()) {
            $fonts = array_merge($fonts, [
                'iranyekan' => __('IranYekan', 'ahura'),
				'iranyekanfn' => __('IranYekan FaNum', 'ahura'),
                'iransans' => __('IranSans', 'ahura'),
				'iransansfanum' => __('IranSans FaNum', 'ahura'),
                'dana' => __('Dana', 'ahura'),
                'danafn' => __('Dana FaNum', 'ahura'),
                'iransansdn' => __('IRANSasn Dast Nevis', 'ahura'),
                'anjoman' => __('Anjoman', 'ahura'),
                'anjomanfn' => __('Anjoman FaNum', 'ahura'),
                'farhang2' => __('Farhang 2', 'ahura'),
                'farhang2fn' => __('Farhang 2 FaNum', 'ahura'),
                'doran' => __('Doran', 'ahura'),
                'doranfn' => __('Doran FaNum', 'ahura'),
            ]);
        }

        $custom_fonts = \ahura\app\Ahura_Custom_Fonts::getFonts();
        $c_fonts = [];
        if ($custom_fonts) {
            foreach ($custom_fonts as $custom_font) {
                $c_fonts["{$custom_font['font_family']}"] = $custom_font['font_family'];
            }
        }
        $all_fonts = array_merge($fonts, $c_fonts);
        return $all_fonts;
    }

    public static function get_mod_is_active_breadcrumb()
    {
        return get_theme_mod('show_breadcrumb');
    }

    public static function get_mod_is_active_relatedpost()
    {
        return get_theme_mod('show_relatedposts');
    }

    public static function get_mod_is_active_show_product_stock_status()
    {
        return get_theme_mod('ahura_shop_show_product_stock_status');
    }

    public static function get_mod_is_active_woo_modified_date()
    {
        return get_theme_mod('ahura_woo_modified_date', false);
    }

    public static function get_mod_isnot_active_show_boxcover_status()
    {
        return self::get_product_item_style() == 1 && !get_theme_mod('ahura_shop_show_boxcover');
    }

    public static function get_mod_is_active_footer_slogan()
    {
        return self::get_mod_is_not_active_custom_footer() ? get_theme_mod('ahura_legend', true) : false;
    }

    public static function get_mod_is_active_custom_header()
    {
        return get_theme_mod('use_custom_header');
    }
    public static function is_ahura_builder_accessible()
    {
        return class_exists('\ahura\app\elementor\Ahura_Elementor_Builder');
    }

    public static function get_mod_is_not_active_custom_header()
    {
        return !self::get_mod_is_active_custom_header();
    }

    public static function get_mod_is_active_custom_footer()
    {
        return get_theme_mod('use_custom_footer');
    }

    public static function get_mod_is_active_user_loggedin_name()
    {
        return get_theme_mod('ahura_show_user_loggedin_name');
    }

    public static function get_mod_is_active_product_related()
    {
        return get_theme_mod('ahura_shop_show_product_related');
    }

    public static function get_mod_is_active_product_related_in_slider()
    {
        return get_theme_mod('ahura_shop_show_product_related_in_slider');
    }

    public static function get_mod_is_active_post_show_update_date()
    {
        return get_theme_mod('show_update_date');
    }

    public static function get_mod_is_active_hidden_mobile_sidebar()
    {
        return get_theme_mod('ahura_hidden_mobile_sidebar');
    }
    
    public static function get_mod_is_not_active_custom_footer()
    {
        return !self::get_mod_is_active_custom_footer();
    }

    public static function get_mod_is_active_shop_alert_settings()
    {
        return is_store_notice_showing();
    }

    public static function get_mod_is_active_email_form_controls()
    {
        return get_theme_mod('ahura_comment_form_controls');
    }

    public static function get_mod_shop_product_title_words_number()
    {
        return get_theme_mod('ahura_shop_product_title_words_number');
    }

    public static function get_mod_show_post_like_box()
    {
        return get_theme_mod('ahura_show_post_like_box');
    }

    public static function get_mod_post_like_save_data_for_user()
    {
        return get_theme_mod('ahura_post_like_save_data_for_user');
    }

    public static function get_mod_post_like_box_title()
    {
        return get_theme_mod('ahura_post_like_box_title');
    }

    public static function get_mod_post_like_button_title()
    {
        return get_theme_mod('ahura_post_like_button_title');
    }

    public static function get_mod_post_dislike_button_title()
    {
        return get_theme_mod('ahura_post_dislike_button_title');
    }

    public static function get_mod_show_related_portfolios()
    {
        return get_theme_mod('ahura_show_related_portfolios', true);
    }

    public static function get_mod_show_portfolio_like_box()
    {
        return get_theme_mod('ahura_show_portfolio_like_box', true);
    }

    public static function get_mod_portfolio_like_box_title()
    {
        return get_theme_mod('ahura_portfolio_like_box_title');
    }

    public static function get_mod_show_portfolio_breadcrumb()
    {
        return get_theme_mod('ahura_show_portfolio_breadcrumb', true);
    }

    public static function get_mod_show_portfolio_archive_breadcrumb()
    {
        return get_theme_mod('ahura_show_portfolio_archive_breadcrumb', true);
    }

    public static function get_mod_show_product_thumbnails_in_slider()
    {
        return get_theme_mod('ahura_shop_show_product_thumbnails_in_slider', false);
    }

    public static function get_mod_show_product_slider_buttons()
    {
        return get_theme_mod('ahura_shop_show_product_slider_buttons', true);
    }
    
    public static function get_mod_is_active_custom_404_page()
    {
        return get_theme_mod('use_custom_404_page', false);
    }

    public static function get_mod_is_not_active_custom_404_page()
    {
        return !self::get_mod_is_active_custom_404_page();
    }

    public static function get_mod_custom_404_page_id()
    {
        return get_theme_mod('custom_404_page');
    }

    public static function get_mod_show_call_for_price_inquery()
    {
        return get_theme_mod('ahura_shop_show_call_for_price_inquery', false);
    }

    public static function get_mod_text_call_for_price_inquery()
    {
        return get_theme_mod('ahura_shop_text_call_for_price_inquery');
    }

    public static function get_mod_call_for_price_inquery_button_text()
    {
        return get_theme_mod('ahura_shop_btn_text_call_for_price_inquery');
    }

    public static function get_mod_call_for_price_inquery_button_url()
    {
        return get_theme_mod('ahura_shop_btn_url_call_for_price_inquery');
    }

    public static function get_mod_is_active_images_lightbox()
    {
        return get_theme_mod('ahura_images_lightbox_status', false);
    }

    public static function get_mod_shop_show_filters_button_toggle()
    {
        return get_theme_mod('shop_show_filters_button_toggle', true);
    }

    public static function get_mod_show_content_types()
    {
        return get_theme_mod('show_content_types', true);
    }
    
    public static function get_mod_show_content_types_in_archive()
    {
        return get_theme_mod('archive_show_content_types', true);
    }

    public static function get_mod_show_page_comment()
    {
        return get_theme_mod('page_comment_status', false);
    }

    public static function get_mod_show_portfolio_excerpt()
    {
        return get_theme_mod('ahura_show_portfolio_excerpt', true);
    }

    public static function get_mod_show_portfolio_description()
    {
        return get_theme_mod('ahura_show_portfolio_description', true);
    }

    public static function get_mod_change_add_to_cart_button_text_status()
    {
        return get_theme_mod('shop_change_add_to_cart_button_text_status', false);
    }

    public static function get_mod_add_to_cart_button_text()
    {
        return get_theme_mod('shop_add_to_cart_button_text');
    }

    public static function get_mod_change_products_add_to_cart_button_text_status()
    {
        return get_theme_mod('shop_products_change_add_to_cart_button_text_status', false);
    }

    public static function get_mod_products_add_to_cart_button_text()
    {
        return get_theme_mod('shop_products_add_to_cart_button_text');
    }

    public static function get_mod_ahura_shop_orderby_status()
    {
        return get_theme_mod('ahura_shop_orderby_status');
    }

    public static function get_mod_show_footer_symbols()
    {
        return get_theme_mod('footer_namad_check', false);
    }

    public static function get_mod_show_footer_symbol1()
    {
        return self::get_mod_show_footer_symbols() && get_theme_mod('show_symbol1', false);
    }

    public static function get_mod_show_footer_symbol2()
    {
        return self::get_mod_show_footer_symbols() && get_theme_mod('show_symbol2', false);
    }

    public static function get_mod_enamad_use_html_code()
    {
        return get_theme_mod('use_enamad_html', false);
    }

    public static function get_mod_not_enamad_use_html_code()
    {
        return !self::get_mod_enamad_use_html_code();
    }
	
	public static function get_mod_show_single_post_title()
    {
        return get_theme_mod('show_single_post_title', true);
    }

	public static function get_mod_mega_menu_more_items_status()
    {
        return get_theme_mod('ahura_mega_menu_more_items_status', false);
    }

	public static function get_mod_ahura_megamenu_menu_height_status()
    {
        return get_theme_mod('ahura_megamenu_menu_height_status', false);
    }

    public static function get_mod_mega_menu_more_items_count()
    {
        return get_theme_mod('ahura_mega_menu_more_items_count', 7);
    }

    public static function get_mod_show_sticky_buttons()
    {
        return get_theme_mod('ahura_show_sticky_buttons', false);
    }

    public static function get_mod_sticky_buttons_places()
    {
        return get_theme_mod('ahura_sticky_buttons_places', false);
    }

    public static function get_mod_product_page_digikala_sharings()
    {
        return get_theme_mod('ahura_product_page_digikala_sharings', false);
    }

    public static function get_mod_product_page_digikala_attributes()
    {
        return get_theme_mod('ahura_product_page_digikala_attributes', 3);
    }

    public static function get_mod_show_first_sticky_button()
    {
        return get_theme_mod('ahura_show_first_btn_sticky', false);
    }

    public static function get_mod_show_sec_sticky_button()
    {
        return get_theme_mod('ahura_show_sec_btn_sticky', false);
    }

    public static function get_mod_first_sticky_button_url()
    {
        return get_theme_mod('ahura_first_btn_sticky_url', '#');
    }

    public static function get_mod_sec_sticky_button_url()
    {
        return get_theme_mod('ahura_sec_btn_sticky_url', '#');
    }

    public static function get_mod_first_sticky_button_icon()
    {
        return get_theme_mod('ahura_first_btn_sticky_icon', 'fab fa-whatsapp');
    }

    public static function get_mod_sec_sticky_button_icon()
    {
        return get_theme_mod('ahura_sec_btn_sticky_icon', 'fab fa-telegram');
    }

    public static function get_mod_show_custom_login_form()
    {
        return get_theme_mod('ahura_show_custom_login_form', false);
    }

    public static function get_mod_auto_login_after_register()
    {
        return get_theme_mod('ahura_auto_login_after_register', false);
    }

    public static function get_mod_show_login_captcha_code()
    {
        return get_theme_mod('ahura_show_captcha_in_login_form', true);
    }

    public static function get_mod_show_titles_helper_box()
    {
        return get_theme_mod('single_post_show_titles_helper_box', false);
    }

    public static function get_mod_is_active_light_fontface()
    {
        return get_theme_mod('ahura_light_font', false);
    }

    public static function get_mod_is_active_ultralight_fontface()
    {
        return get_theme_mod('ahura_ultralight_font', false);
    }

    public static function get_mod_is_active_medium_fontface()
    {
        return get_theme_mod('ahura_medium_font', false);
    }

    public static function get_mod_is_active_bold_fontface()
    {
        return get_theme_mod('ahura_bold_font', false);
    }

    public static function get_mod_is_active_black_fontface()
    {
        return get_theme_mod('ahura_black_font', false);
    }
    
    public static function get_mod_show_widgets_between_post_content()
    {
        return get_theme_mod('ahura_show_widgets_between_post_content', true);
    }

    public static function get_mod_widgets_between_post_content_position()
    {
        return get_theme_mod('ahura_widgets_between_post_content_position', 1);
    }

    public static function get_mod_usage_other_login_forms()
    {
        return get_theme_mod('ahura_usage_other_login_forms', false);
    }

    public static function get_mod_other_login_form_shortcode()
    {
        return get_theme_mod('ahura_other_login_form_shortcode');
    }

    public static function get_mod_is_active_dark_theme()
    {
        return get_theme_mod('theme_dark', false);
    }

    public static function get_mod_show_theme_mode_switcher()
    {
        return get_theme_mod('ahura_show_theme_mode_switcher', false);
    }

    public static function get_mod_show_theme_mode_switcher_titles()
    {
        return get_theme_mod('ahura_show_theme_mode_switcher_titles', true);
    }

    public static function get_mod_default_theme_mode()
    {
        return get_theme_mod('ahura_default_theme_mode', 'dark');
    }

    public static function get_font_weights()
    {
        return [
            'normal' => 'Normal',
            'bold' => 'Bold',
            '100' => '100',
            '200' => '200',
            '300' => '300',
            '400' => '400',
            '500' => '500',
            '600' => '600',
            '700' => '700',
            '800' => '800',
            '900' => '900'
        ];
    }

    public static function is_active_absolute_thumbnail()
    {
        return get_theme_mod('show_single_post_thumbnail') == 'right' || get_theme_mod('show_single_post_thumbnail') == 'left';
    }

    public static function get_open_mobile_menu_from_left()
    {
        return get_theme_mod('ahura_open_mobile_menu_from_left');
    }

    public static function theme_viewport_meta_html()
    {
        if (!self::get_mod_use_meta_data()) return false;

        $max_scale = get_theme_mod('theme_viewport_maximum_scale', 1);
        $user_scalable = get_theme_mod('theme_viewport_user_scalable', false) == true ? 'yes' : 'no';
        echo "<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale={$max_scale}, user-scalable={$user_scalable}'/>";
    }

    public static function get_header_style()
    {
        $mode_id = get_theme_mod('ahura_header_style');
        return !empty($mode_id) ? $mode_id : 1;
    }

    public static function get_footer_style()
    {
        $mode_id = get_theme_mod('ahura_footer_style');
        return !empty($mode_id) ? $mode_id : 1;
    }

    public static function is_active_notification_bar(){
        return self::get_mod_is_not_active_custom_header() && get_theme_mod('ahura_active_alert_box', false);
    }

    public static function is_active_notification_bar_button(){
        return self::is_active_notification_bar() && get_theme_mod('ahura_active_alert_box_button', true);
    }

    public static function is_active_header_style($style_id){
        $current_style = self::get_header_style();

        if(is_array($style_id)){
            return (empty($current_style) && in_array(1, $style_id)) || in_array($current_style, $style_id);
        }

        return (empty($current_style) && $style_id == 1) || $current_style == $style_id;
    }

    public static function is_active_header_box_mode(){
        return self::get_mod_is_not_active_custom_header() && get_theme_mod('ahura_header_box_mode', false);
    }

    public static function get_ahura_upload_dir(){
        $uploads_dir = wp_get_upload_dir()['basedir'];
        $upload_dir = $uploads_dir . '/ahura';

        if(!file_exists($upload_dir)){
            mkdir($upload_dir);
        }

        return is_dir($upload_dir) ? $upload_dir . '/' : '';
    }

    public static function get_product_item_style(){
        return get_theme_mod('ahura_shop_product_loop_style', 1);
    }

    public static function get_single_product_style(){
        return get_theme_mod('ahura_single_product_loop_style');
    }

    public static function get_show_post_sharing(){
        return get_theme_mod('show_post_sharing', false);
    }

    public static function get_post_sharing_title(){
        return get_theme_mod('post_sharing_title');
    }

    public static function get_admin_font_name(){
        return get_theme_mod('ahura_admin_font', 'iransans');
    }

    public static function get_sidebar_mode(){
        return get_theme_mod('ahura_sidebar_mode', 1);
    }

    public static function get_mod_is_active_custom_archive(){
        return get_theme_mod('use_custom_archive', false);
    }

    public static function get_mod_is_not_active_custom_archive(){
        return !self::get_mod_is_active_custom_archive();
    }

    public static function get_header_custom_codes(){
        return self::get_theme_option('ahura_additional_code_in_header', null);
    }

    public static function get_custom_css(){
        return self::get_theme_option('ahura_custom_css_code', null);
    }

    public static function get_tablet_custom_css(){
        return self::get_theme_option('ahura_tablet_custom_css_code', null);
    }

    public static function get_mobile_custom_css(){
        return self::get_theme_option('ahura_mobile_custom_css_code', null);
    }

    public static function get_footer_custom_codes(){
        return self::get_theme_option('ahura_additional_code_in_footer', null);
    }

    public static function get_custom_js(){
        return self::get_theme_option('ahura_custom_js', null);
    }

    public static function get_show_404_page_back_button(){
        return self::get_theme_option('ahura_404_show_go_home', false);
    }

    public static function get_mod_show_preloader(){
        return self::get_theme_option('ahura_show_preloader', false);
    }

    public static function get_mod_use_ready_preloader(){
        return self::get_theme_option('ahura_use_ready_preloader', false);
    }

    public static function show_sticky_buttons(){
        if (!self::get_mod_show_sticky_buttons()) return false;

        $get_sticky_buttons_places = self::get_mod_sticky_buttons_places() ;
        $get_multi_sticky_buttons_places = ! is_array( $get_sticky_buttons_places ) ? explode( ',', $get_sticky_buttons_places ) : $get_sticky_buttons_places;
        $multi_sticky_buttons_places = !empty( $get_multi_sticky_buttons_places ) ? array_map( 'sanitize_text_field', $get_multi_sticky_buttons_places ) : array();

        if (empty($get_sticky_buttons_places)) return true;

        $page_types = array_values($multi_sticky_buttons_places);

        if(in_array('home', $page_types) && is_home() || is_front_page()){
            return true;
        } elseif (in_array('archive', $page_types) && is_archive()){
            return true;
        } elseif (in_array('page', $page_types) && (is_single() || is_page())){
            return true;
        } elseif (in_array('shop', $page_types) && (woocommerce::is_active() && is_shop())){
            return true;
        } elseif (in_array('product', $page_types) && (woocommerce::is_active() && is_product())){
            return true;
        } elseif (in_array('all', $page_types)){
            return true;
        }

        return false;
    }

    public static function get_mod_use_meta_data(){
        return self::get_theme_option('ahura_use_meta_data', true);
    }

    public static function get_custom_header_id(){
        return get_theme_mod('custom_header');
    }

    public static function get_custom_footer_id(){
        return get_theme_mod('custom_footer');
    }

    public static function get_show_information_box(){
        return self::get_theme_option('ah_footer_show_information_box', true);
    }

    public static function get_footer_contact_phone_number(){
        return self::get_theme_option('ah_footer_contact_phone_number', '09123456789');
    }

    public static function get_footer_contact_email(){
        return self::get_theme_option('ah_footer_contact_email', 'info@domain.com');
    }

    public static function get_footer_contact_address(){
        return self::get_theme_option('ah_footer_contact_address', __('Iran, Fars, Shiraz', 'ahura'));
    }

    public static function get_footer_about_us_title(){
        return self::get_theme_option('ah_footer_about_us_title', __('About Us', 'ahura'));
    }

    public static function get_footer_about_us_text(){
        return self::get_theme_option('ah_footer_about_us_text', ahura_get_lorem_ipsum());
    }

    public static function get_footer_icon1(){
        return self::get_theme_option('ah_footer_icon1', mw_assets::get_img('icons.svg.icon-refund', 'svg'));
    }

    public static function get_footer_icon1_title(){
        return self::get_theme_option('ah_footer_icon1_title', __('Refund', 'ahura'));
    }

    public static function get_footer_icon2(){
        return self::get_theme_option('ah_footer_icon2', mw_assets::get_img('icons.svg.icon-warranty', 'svg'));
    }

    public static function get_footer_icon2_title(){
        return self::get_theme_option('ah_footer_icon2_title', __('Product warranty', 'ahura'));
    }

    public static function get_footer_icon3(){
        return self::get_theme_option('ah_footer_icon3', mw_assets::get_img('icons.svg.icon-payout', 'svg'));
    }

    public static function get_footer_icon3_title(){
        return self::get_theme_option('ah_footer_icon3_title', __('Pay on site', 'ahura'));
    }

    public static function get_footer_icon4(){
        return self::get_theme_option('ah_footer_icon4', mw_assets::get_img('icons.svg.icon-support', 'svg'));
    }

    public static function get_footer_icon4_title(){
        return self::get_theme_option('ah_footer_icon4_title', __('Fast support', 'ahura'));
    }

    public static function get_footer_icon5(){
        return self::get_theme_option('ah_footer_icon5', mw_assets::get_img('icons.svg.icon-refund', 'svg'));
    }

    public static function get_footer_icon5_title(){
        return self::get_theme_option('ah_footer_icon5_title', __('Refund', 'ahura'));
    }

    public static function get_footer_icon6(){
        return self::get_theme_option('ah_footer_icon6', mw_assets::get_img('icons.svg.icon-payout', 'svg'));
    }

    public static function get_footer_icon6_title(){
        return self::get_theme_option('ah_footer_icon6_title', __('Pay on site', 'ahura'));
    }

    public static function get_mod_show_product_quick_view(){
        return self::get_theme_option('ahura_shop_show_product_quick_view', false);
    }

    public static function get_mod_move_out_of_stock_products_to_end(){
        return self::get_theme_option('ahura_shop_move_out_of_stock_products_to_end', false);
    }
}
