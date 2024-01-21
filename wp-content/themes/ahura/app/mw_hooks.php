<?php
namespace ahura\app;
class mw_hooks
{
    static function init()
    {
        add_action('after_setup_theme', ['\ahura\app\mw_config', 'after_setup_theme']);
        add_action('admin_notices', ['\ahura\app\mw_config', '_check_requirements_minimum_version_callback']);
        add_action('admin_notices', ['\ahura\app\mw_config', '_requirements_notice_callback']);
        add_action('admin_footer', ['\ahura\app\mw_config', 'append_to_admin_footer']);
        add_action('ahura_check_license', ['\ahura\app\license', 'check_license_cron_job']);
        add_action('init', ['\ahura\app\mw_post_type', 'init']);
        add_action('init', ['\ahura\app\license', 'init']);
        add_action('init', ['\ahura\app\mw_metabox', 'getInstance']);

        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

        if(mw_options::get_mod_show_titles_helper_box()){
            add_filter('the_content', ['\ahura\app\Post_Tag_Filter', 'the_content_headings_filter'], 1);
        }

        add_action('wp_nav_menu_item_custom_fields', ['\ahura\app\mw_mega_menu', 'add_admin_fields'], 10, 2);
        add_action('wp_update_nav_menu_item', ['\ahura\app\mw_mega_menu', 'update_data'], 10, 3);
        add_action('wp_enqueue_scripts', ['\ahura\app\mw_assets', 'init']);
        add_action('widgets_init', ['\ahura\app\mw_widgets', 'init']);
        add_action('admin_enqueue_scripts', ['\ahura\app\mw_assets', 'load_admin_assets']);

        if(mw_options::get_mod_is_ajax_search())
        {
            add_action('wp_ajax_mw_search_ajax', ['\ahura\app\ajax', 'search_result']);
            add_action('wp_ajax_nopriv_mw_search_ajax', ['\ahura\app\ajax', 'search_result']);
        }

        add_action('elementor/preview/enqueue_styles', ['\ahura\app\mw_assets', 'load_elementor_preview_assets']);
        add_action('elementor/editor/after_enqueue_scripts', ['\ahura\app\mw_assets', 'load_elementor_editor_scripts']);
        add_action('elementor/editor/after_enqueue_styles', ['\ahura\app\mw_assets', 'load_elementor_editor_styles']);

        if(woocommerce::is_active())
        {
            add_action('init', ['\ahura\app\woocommerce\WC_Brand', 'init']);

            if(mw_options::get_mod_move_out_of_stock_products_to_end()){
                add_filter('posts_clauses', ['\ahura\app\woocommerce', 'handle_move_out_of_stock_products_to_end']);
            }

            add_action('woocommerce_before_mini_cart', ['\ahura\app\mw_config', 'before_mini_cart']);
            add_action('woocommerce_after_mini_cart', ['\ahura\app\mw_config', 'after_minicart']);
            add_filter('woocommerce_add_to_cart_fragments', ['\ahura\app\mw_config', 'minicart_fragments']);
            
            add_action('woocommerce_before_shop_loop_item', ['\ahura\app\woocommerce', 'before_shop_loop_item']);
            add_action('woocommerce_before_shop_loop_item_title',['\ahura\app\woocommerce', 'show_product_stock_status'], 10);
            add_filter('loop_shop_columns', ['\ahura\app\woocommerce', 'loop_shop_columns']);
            add_action('wp_enqueue_scripts', ['\ahura\app\woocommerce', 'load_assets'], 9);
            add_filter('woocommerce_cart_item_thumbnail', ['\ahura\app\woocommerce', 'woocommerce_cart_item_thumbnail'], 10, 3);
            add_filter( 'woocommerce_output_related_products_args', ['\ahura\app\woocommerce', 'related_products_args'], 20 );

            add_action('wp_ajax_nopriv_ahura_update_mini_cart_btn', ['\ahura\app\ajax', 'update_mini_cart_btn']);
            add_action('wp_ajax_ahura_update_mini_cart_btn', ['\ahura\app\ajax', 'update_mini_cart_btn']);

            if(!get_theme_mod('ahura_active_woocommerce_element_mini_cart')){
                add_filter('woocommerce_locate_template', ['\ahura\app\mw_config', 'reset_minicart_template_path'], 999, 3);
            }

            add_action('wp_ajax_nopriv_ahura_update_mini_cart2_element', ['\ahura\app\ajax', 'update_mini_cart2_element']);
            add_action('wp_ajax_ahura_update_mini_cart2_element', ['\ahura\app\ajax', 'update_mini_cart2_element']);

            //Change number of products displayed per page
            add_filter( 'loop_shop_per_page', ['\ahura\app\woocommerce', 'change_shop_item_count_per_page'], 20 );

            add_filter('woocommerce_product_single_add_to_cart_text', ['\ahura\app\woocommerce', 'change_single_product_add_to_cart_button_text']);

            add_action('wc_before_add_to_cart_button', ['\ahura\app\woocommerce', 'before_shop_add_to_cart_button'], 10, 1);

            if (mw_options::get_mod_show_product_quick_view()){
                add_action('init', ['\ahura\app\WC_Quick_View', 'init']);

                add_action('wp_ajax_nopriv_ahura_quick_view_product_data', ['\ahura\app\ajax', 'handle_quick_view_product_data']);
                add_action('wp_ajax_ahura_quick_view_product_data', ['\ahura\app\ajax', 'handle_quick_view_product_data']);
            }

            add_action('wp_head', function(){
                if (mw_options::get_mod_show_product_quick_view() && !woocommerce::is_product()){
                    add_action('wc_before_add_to_cart_button', ['\ahura\app\woocommerce', 'handle_add_quick_view_button_before_shop_add_to_cart'], 10, 1);
                }

                if(is_single()){
                    if(\ahura\app\mw_options::get_mod_show_call_for_price_inquery()){
                        add_filter('woocommerce_get_price_html', ['\ahura\app\woocommerce', 'added_inquiry_text_for_without_products'], 10, 2);
                    }

                    if(get_theme_mod('ahura_move_price_after_short_description', false)){
                        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
                        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);
                    }
                }
            });

            add_action('init', function(){
                if(class_exists('\ahura\app\woocommerce\variations\Woocommerce_Attribute_Meta_Backend')){
                    $woo_vars_backend = \ahura\app\woocommerce\variations\Woocommerce_Attribute_Meta_Backend::instance();
                }
                if(class_exists('\ahura\app\woocommerce\variations\Woocommerce_Attribute_Meta_Frontend')){
                    $woo_vars_frontend = \ahura\app\woocommerce\variations\Woocommerce_Attribute_Meta_Frontend::instance();
                }
                if(class_exists('\ahura\app\woocommerce\variations\Woocommerce_Shop_Attribute_Filter')){
                    $woo_vars_filter = \ahura\app\woocommerce\variations\Woocommerce_Shop_Attribute_Filter::instance();
                }
            });
        }
        add_action('wp_head', ['\ahura\app\mw_assets', 'load_head_assets']);
        add_action('customize_controls_enqueue_scripts', ['\ahura\app\mw_assets', 'load_customization_assets']);
        add_action('customize_save_after',['\ahura\app\customization\customizer_save','after_customizer_save']);
        add_action('wp_ajax_ahura_customizer_reset',['\ahura\app\ajax','customizer_reset']);
        add_action('upgrader_process_complete', ['\ahura\app\mw_config', 'handle_upgrader_process_complete'], 10, 2);
        add_action('admin_menu',['\ahura\app\mw_config','add_theme_settings_menu']);
        add_action('admin_menu',['\ahura\app\mw_config','add_theme_settings_sub_menu']);
        add_filter('woocommerce_sale_flash', ['\ahura\app\woocommerce','change_sale_text'], 10, 2);
        add_filter('upload_mimes', ['\ahura\app\mw_config', 'add_custom_upload_mimes']);
        add_filter('wp_check_filetype_and_ext', ['\ahura\app\mw_config', 'enable_upload_ico_file'], 10, 4);

        add_action('wp_ajax_nopriv_ahura_post_grid_tab_ajax', ['\ahura\app\ajax', 'ahura_post_grid_tab_ajax_callback']);
        add_action('wp_ajax_ahura_post_grid_tab_ajax', ['\ahura\app\ajax', 'ahura_post_grid_tab_ajax_callback']);

        add_action('wp_ajax_nopriv_ahura_product_tab_ajax', ['\ahura\app\ajax', 'ahura_product_tab_ajax_callback']);
        add_action('wp_ajax_ahura_product_tab_ajax', ['\ahura\app\ajax', 'ahura_product_tab_ajax_callback']);
        add_action('wp_ajax_nopriv_ahura_load_product_tab_ajax', ['\ahura\app\ajax', 'ahura_load_product_tab_ajax_callback']);
        add_action('wp_ajax_ahura_load_product_tab_ajax', ['\ahura\app\ajax', 'ahura_load_product_tab_ajax_callback']);
        add_action('wp_ajax_nopriv_ahura_element_grid_posts10', ['\ahura\app\ajax', 'grid_posts10_ajax_callback']);
        add_action('wp_ajax_ahura_element_grid_posts10', ['\ahura\app\ajax', 'grid_posts10_ajax_callback']);
        add_action('wp_ajax_nopriv_ahura_gallery_element', ['\ahura\app\ajax', 'gallery_ajax_callback']);
        add_action('wp_ajax_ahura_gallery_element', ['\ahura\app\ajax', 'gallery_ajax_callback']);

        add_action('wp_ajax_nopriv_ahura_post_like', ['\ahura\app\ajax', 'post_like_ajax_callback']);
        add_action('wp_ajax_ahura_post_like', ['\ahura\app\ajax', 'post_like_ajax_callback']);

        add_action('wp_ajax_nopriv_ahura_mailer_lite_subscribe', ['\ahura\app\ajax', 'mailer_lite_user_subscribe']);
        add_action('wp_ajax_ahura_mailer_lite_subscribe', ['\ahura\app\ajax', 'mailer_lite_user_subscribe']);

        add_action('wp_ajax_nopriv_ahura_team_members_tab_ajax', ['\ahura\app\ajax', 'team_members_ajax_callback']);
        add_action('wp_ajax_ahura_team_members_tab_ajax', ['\ahura\app\ajax', 'team_members_ajax_callback']);

        add_action('wp_ajax_ahura_theme_change_license_status', ['\ahura\app\ajax', 'change_license_ajax_callback']);
        add_action('wp_ajax_ahura_create_section_builder_template', ['\ahura\app\ajax', 'createSectionBuilderTemplate']);

        add_filter('template_include', ['\ahura\app\mw_config', 'elementor_builder_default_template_types'], 1, 1);

        if(\ahura\app\mw_options::get_mod_show_custom_login_form()){
            add_action('wp_ajax_ahura_user_login', ['\ahura\app\ajax', 'user_login']);
            add_action('wp_ajax_nopriv_ahura_user_login', ['\ahura\app\ajax', 'user_login']);
            add_action('wp_ajax_ahura_user_register', ['\ahura\app\ajax', 'user_register']);
            add_action('wp_ajax_nopriv_ahura_user_register', ['\ahura\app\ajax', 'user_register']);
            add_action('wp_ajax_ahura_user_resetpass', ['\ahura\app\ajax', 'user_resetpass']);
            add_action('wp_ajax_nopriv_ahura_user_resetpass', ['\ahura\app\ajax', 'user_resetpass']);
        }

        add_action('wp_ajax_ahura_get_sections', ['\ahura\app\ajax', 'get_sections']);
        if(class_exists('LifterLMS')){
            add_filter('llms_get_theme_default_sidebar', ['\ahura\app\mw_config', 'set_lifterlms_default_sidebar']);
        }

        if(class_exists('\ahura\app\Studio_Importer')){
            Studio_Importer::getInstance();
        }

        if(!is_child_theme())
        {
            add_action('wp_ajax_ahura_create_child_theme', ['\ahura\app\ajax', 'createChildTheme']);
        }

        add_filter('template_include', ['\ahura\app\mw_partials', 'handle_change_archive_template_page'], 9999);
    }
}
