<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class Ahura_Theme_Mode_Button extends \ahura\app\elementor\Elementor_Widget_Base
{
    public function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('theme_mode_button_css', mw_assets::get_css('elementor.theme_mode_button'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('theme_mode_button_css')];
    }

    public function get_name()
    {
        return 'ahura_theme_mode_buttons';
    }

    public function get_title()
    {
        return __('Theme Mode Button', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-theme-style';
    }

    public function get_categories()
    {
        return ['ahuraheader'];
    }

    public function get_keywords() {
        return ['dark_mode', 'theme_buttons', __('Theme Mode Button', 'ahura')];
    }

    protected function register_controls(){
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'important_note',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__('The content of this element is displayed only if the dark mode button feature is enabled (Customization > Header).', 'ahura'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );

        $this->add_control(
            'hide_in_scroll',
            [
                'label'   => esc_html__( 'Hide in scroll', 'ahura' ),
                'type'    => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="ahura-theme-mode-button-element <?php echo $settings['hide_in_scroll'] == 'yes' ? 'hide_in_scroll' : '' ?>">
            <?php
            $this->fixedEmptyContentInEditor();
            $content = \ahura\app\mw_tools::get_executable_file_content(get_template_directory() . '/template-parts/header/mode-switcher.php');
            echo $content;
            ?>
        </div>
    <?php
    }
}
