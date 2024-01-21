<?php
namespace ahura\inc\widgets;

use \Elementor\Controls_Manager;
use ahura\app\mw_assets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class alert_box extends \Elementor\Widget_Base
{
    public function __construct($data=[], $args=[])
    {
        parent::__construct($data, $args);
        mw_assets::register_style('alert_box', mw_assets::get_css('elementor.alert_box'));
        if(!is_rtl()){
            mw_assets::register_style('alert_box_ltr', mw_assets::get_css('elementor.ltr.alert_box_ltr'));
        }
        mw_assets::register_script('alert_box_js', mw_assets::get_js('elementor.alert_box'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('alert_box')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('alert_box_ltr');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('alert_box_js')];
    }

    public function get_name()
    {
        return 'ahura_alert_box';
    }

    public function get_title()
    {
        return esc_html__('Alert Box', 'ahura');
    }

    public function get_icon() {
		return 'eicon-alert';
	}

    public function get_categories() {
		return ['ahuraelements'];
	}

    public function get_keywords()
    {
        return ['alert_box', 'alertbox', esc_html__('Alert Box' , 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'alert_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Write the alert text...', 'ahura')
            ]
        );

        $this->add_control(
            'close_btn',
            [
                'label' => esc_html__('Close Button', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'content_styles',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $alignment = [
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-text-align-left'
            ],
            'center' => [
                'title' => __('Center', 'ahura'),
                'icon' => 'eicon-text-align-center'
            ],
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-text-align-right'
            ]
        ];

        $this->add_control(
            'box_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => is_rtl() ? 'right' : 'left',
                'selectors' => [
                    '{{WRAPPER}} .ahura-alert-box-content' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ahura-alert-box',
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'color' => ['default' => '#6600ff'],
                    'color_b' => ['default' => '#e200ff'],
                    'gradient_angle' => ['default' => [
                        'unit' => 'deg',
                        'size' => 90,
                    ]],
                ]
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-alert-box-content' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_content_typo',
                'selector' => '{{WRAPPER}} .ahura-alert-box-content',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-alert-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-alert-box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-alert-box',
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        $close_btn = $settings['close_btn'] == 'yes';
        $content = $settings['alert_text'];
        ?>
        <div class="ahura-alert-box ahura-alert-box-<?php echo $wid ?>">
            <?php if($close_btn): ?>
                <span class="close-alert-box"><i class="fa fa-times"></i></span>
            <?php endif; ?>
            <div class="ahura-alert-box-content"><?php echo $content; ?></div>
        </div>
        <?php
    }
}