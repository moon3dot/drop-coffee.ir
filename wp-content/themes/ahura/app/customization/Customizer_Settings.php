<?php
namespace ahura\app\customization;

use ahura\app\Logger;
use ahura\app\mw_options;

class Customizer_Settings
{
    private $customizer;
    private $panel_name_prefix = 'ah_theme_panel_';
    private $section_name_prefix = 'ah_theme_section_';
    private $current_panel;
    private $current_section;

    public function __construct($wp_customize)
    {
        $this->customizer = $wp_customize;
    }

    public function get_panel_name($id)
    {
        return $this->panel_name_prefix . $id;
    }

    public function get_section_name($id, $panel = null)
    {
        return $this->section_name_prefix . (!empty($this->current_panel) ? $panel . '_' : '') . $id;
    }

    private function get_panels()
    {
        $default_description = __('From this section, you can make changes to the %s, note: some tabs and options are visible or hidden according to the changes.', 'ahura');
        $panels = [
            'style' => array(
                'priority' => 1,
                'title' => __( 'Style', 'ahura' ),
            ),
            # layout settings
            'header' => array(
                'priority' => 3,
                'title' => __( 'Header', 'ahura' ),
                'description' => sprintf($default_description, __('header', 'ahura'))
            ),
            'blog' => array(
                'priority' => 4,
                'title' => __( 'Blog', 'ahura' ),
                'description' => sprintf($default_description, __('blog', 'ahura'))
            ),
            'woocommerce' => array(
                'priority' => 5,
                'title' => __( 'Woocommerce', 'ahura' ),
                'description' => sprintf($default_description, __('Woocommerce', 'ahura'))
            ),
            'portfolio' => array(
                'priority' => 6,
                'title' => __( 'Portfolio', 'ahura' ),
                'post_type' => 'portfolio',
                'description' => sprintf($default_description, __('portfolio', 'ahura'))
            ),
            'pages' => array(
                'priority' => 7,
                'title' => __( 'Pages', 'ahura' ),
            ),
            #sidebar
            'footer' => array(
                'priority' => 9,
                'title' => __( 'Footer', 'ahura' ),
                'description' => sprintf($default_description, __('footer', 'ahura'))
            ),
            # global settings
            # admin settings
            # settings backup
        ];
        return apply_filters('ahura_get_customizer_panels', $panels);
    }

    private function get_sections()
    {
        $sections = [
            # style panel
            'style' => array(
                'global_styles' => array(
                    'title'      => __('Global Styles','ahura'),
                    'priority'   => 1,
                ),
                'typography' => array(
                    'title'      => __('Typography','ahura'),
                    'priority'   => 2,
                ),
                'colors' => array(
                    'title'      => __('Colors','ahura'),
                    'priority'   => 3,
                ),
                'custom_css' => array(
                    'title'      => __('Custom CSS','ahura'),
                    'priority'   => 4,
                ),
            ),
            # header panel
            'header' => array(
                'header_modes' => array(
                    'title'      => __('Header Modes','ahura'),
                    'priority'   => 1,
                ),
                'logo' => array(
                    'title'      => __('Logo & Site identity','ahura'),
                    'priority'   => 2,
                ),
                'buttons' => array(
                    'title'      => __('Buttons','ahura'),
                    'priority'   => 3,
                ),
                'search' => array(
                    'title'      => __('Search','ahura'),
                    'priority'   => 4,
                ),
                'main_menu' => array(
                    'title'      => __('Main Menu','ahura'),
                    'priority'   => 5,
                ),
                'mega_menu' => array(
                    'title'      => __('Mega Menu','ahura'),
                    'priority'   => 6,
                ),
                'mobile_menu' => array(
                    'title'      => __('Mobile Menu','ahura'),
                    'priority'   => 7,
                ),
                'sticky_header' => array(
                    'title'      => __('Sticky Header','ahura'),
                    'priority'   => 8,
                ),
                'dark_mode' => array(
                    'title'      => __('Dark Mode','ahura'),
                    'priority'   => 9,
                ),
                'notification_box' => array(
                    'title'      => __('Notification Box','ahura'),
                    'priority'   => 10,
                ),
                'meta_data' => array(
                    'title'      => __('Meta Data','ahura'),
                    'priority'   => 11,
                ),
                'custom_code' => array(
                    'title'      => __('Custom Code','ahura'),
                    'priority'   => 12,
                ),
            ),
            # blog panel
            'blog' => array(
                'archive' => array(
                    'title'      => __('Archive','ahura'),
                    'priority'   => 1,
                ),
                'single' => array(
                    'title'      => __('Single Post','ahura'),
                    'priority'   => 2,
                ),
            ),
            # woocommerce panel
            'woocommerce' => array(
                'shop' => array(
                    'title'      => __('Shop','ahura'),
                    'priority'   => 1,
                ),
                'single' => array(
                    'title'      => __('Single Product','ahura'),
                    'priority'   => 2,
                ),
                'checkout' => array(
                    'title'      => __('Checkout','ahura'),
                    'priority'   => 3,
                ),
                'cart' => array(
                    'title'      => __('Cart','ahura'),
                    'priority'   => 4,
                ),
            ),
            # portfolio panel
            'portfolio' => array(
                'archive' => array(
                    'title'      => __('Archive', 'ahura'),
                    'priority'   => 2,
                    'post_type' => 'portfolio'
                ),
                'single' => array(
                    'title'      => __('Single Portfolio', 'ahura'),
                    'priority'   => 3,
                    'post_type' => 'portfolio'
                ),
            ),
            # pages panel
            'pages' => array(
                'global_settings' => array(
                    'title'      => __('Global Settings', 'ahura'),
                    'priority'   => 1,
                ),
                'page_404' => array(
                    'title'      => __( '404 Settings', 'ahura' ),
                    'priority'   => 2,
                ),
            ),
            # footer panel
            'footer' => array(
                'footer_modes' => array(
                    'title'      => __('Footer Modes', 'ahura'),
                ),
                'footer_top' => array(
                    'title'      => __('Footer Top', 'ahura'),
                ),
                'information_box' => array(
                    'title'      => __('Information Box', 'ahura'),
                ),
                'footer_bottom' => array(
                    'title'      => __('Footer Bottom', 'ahura'),
                ),
                'sticky_buttons' => array(
                    'title'      => __( 'Sticky Buttons', 'ahura' ),
                ),
                'symbol_settings' => array(
                    'title'      => __( 'Trust Symbol Settings', 'ahura' ),
                ),
                'go_up_button' => array(
                    'title'      => __( 'Got To Up Button', 'ahura' ),
                ),
                'preloader' => array(
                    'title'      => __( 'Preloader', 'ahura' ),
                ),
                'custom_code' => array(
                    'title'      => __( 'Custom Code', 'ahura' ),
                ),
            ),
            'layout' => array(
                'title' => __( 'Theme Layout', 'ahura' ),
                'priority' => 2,
            ),
            'sidebar' => array(
                'title' => __( 'Sidebar', 'ahura' ),
                'priority' => 8,
            ),
            'global' => array(
                'title'      => __( 'Global Settings', 'ahura' ),
                'priority'   => 10,
            ),
            'admin' => array(
                'title'      => __( 'Admin Panel', 'ahura' ),
                'priority'   => 11,
            ),
            'backup' => array(
                'title'      => __('Backup', 'ahura'),
                'priority'   => 12,
            ),
        ];
        return apply_filters('ahura_get_customizer_sections', $sections);
    }

    private function register_panels()
    {
        foreach ($this->get_panels() as $id => $params){
            if (isset($params['post_type']) && \ahura\app\mw_post_type::is_disabled_post_type($params['post_type']))
                continue;

            $this->customizer->add_panel($this->get_panel_name($id), $params);
        }
    }

    public function is_exists_panel($panel_id)
    {
        return $this->customizer->get_panel($this->get_panel_name($panel_id));
    }

    private function render_section_options($section_id, $params = null)
    {
        $base = get_template_directory() . '/inc/customizer/';
        $file = $base . "other/{$section_id}.php";
        if (!file_exists($file) && is_array($params)){
            if (isset($params['panel']) && !empty($params['panel'])){
                $panel_id = str_replace($this->panel_name_prefix, '', $params['panel']);
                $file = $base . "{$panel_id}/{$section_id}.php";
            }
        }

        $file = apply_filters('ahura_filter_section_file_path', $file, $section_id);

        if (!file_exists($file)) return false;

        $wp_customize = $this->customizer;

        require_once $file;
    }

    private function customizer_sections_loop_content($id, $params = null)
    {
        $show = true;
        if (is_array($params) && isset($params['post_type']) && \ahura\app\mw_post_type::is_disabled_post_type($params['post_type']))
            $show = false;

        if ($show){
            $this->current_section = $this->get_section_name($id, $this->current_panel);

            $this->customizer->add_section($this->current_section, $params);

            # id = file name
            $this->render_section_options($id, $params);
        }
    }

    private function render_customizer_sections()
    {
        foreach ($this->get_sections() as $id => $params){
            $this->current_panel = '';
            if ($this->is_exists_panel($id) && count($params) > 0 && is_array(array_values($params)[0])){
                foreach ($params as $section_id => $section){
                    $section['panel'] = $this->get_panel_name($id);
                    $this->current_panel = $id;
                    $this->customizer_sections_loop_content($section_id, $section);
                }
            } else {
                $this->customizer_sections_loop_content($id, $params);
            }
        }
    }

    private function active_conditions($conditions, $single = false)
    {
        $count = 0;
        foreach ($conditions as $condition){
            $check = false;

            if(method_exists('ahura\app\mw_options', $condition)){
                $check = mw_options::{$condition}();
            } elseif (function_exists($condition)){
                $check = call_user_func($condition);
            }

            if ($check){
                $count++;
            }
        }
        return $single ? $count > 0 : $count == count($conditions);
    }

    /**
     *
     * Display theme settings in customizer page
     *
     * @return void
     */
    public function render_customizer_options()
    {
        $this->register_panels();
        $this->render_customizer_sections();
    }
}