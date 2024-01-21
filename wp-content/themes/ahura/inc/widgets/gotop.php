<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class gotop extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'ahura_gotop';
    }
    public function get_title()
    {
        return esc_html__('Going Up', 'ahura');
    }
    public function get_icon() {
        return 'eicon-arrow-up';
    }
    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    public function get_keywords()
    {
        return ['ahura_gotop', 'ahuragotop', esc_html__('Going Up', 'ahura')];
    }
    public function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('elementor_gotop', mw_assets::get_css('elementor.gotop'));
    }
    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_gotop')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'btn_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-chevron-up',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__( 'Show Title', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'btn_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Going Up', 'ahura'),
                'condition' => ['show_title' => 'yes']
            ]
        );
        $this->end_controls_section();
        /**
         *
         *
         * Styles
         *
         *
         */
        $this->start_controls_section(
            'btn_styles',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('style_tabs');
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_responsive_control(
            'btn_width',
            [
                'label' => __('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 115,
                    'unit' => 'px'
                ],
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} button' => 'width: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_height',
            [
                'label' => __('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} button' => 'height: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_icon_size',
            [
                'label' => __('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                    'unit' => 'px'
                ],
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 300
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} button svg' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} button i' => 'font-size: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $alignment = array(
            'start' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'end' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ]
        );

        $this->add_control(
            'btn_text_align',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .ahura-element-gotop' => 'justify-content: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'btn_icon_color',
            [
                'label'   => __( 'Icon Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#777777',
                'selectors' => [
                    '{{WRAPPER}} button i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} button svg' => 'fill: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label'   => __( 'Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#777777',
                'selectors' => [
                    '{{WRAPPER}} button' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Typography', 'ahura'),
                'name' => 'btn_typography',
                'selector' => '{{WRAPPER}} button',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ],
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} button',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#ffffff'],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'selector' => '{{WRAPPER}} button',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'default' => '#e5e5e5',
                    ],
                ],
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} button',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'btn_icon_color_hover',
            [
                'label'   => __( 'Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} button:hover svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'btn_text_color_hover',
            [
                'label'   => __( 'Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background_hover',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} button:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border_hover',
                'selector' => '{{WRAPPER}} button:hover',
            ]
        );

        $this->add_control(
            'btn_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} button:hover',
            ]
        );

        $this->add_control(
            'btn_hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $elementClass = 'gotop-btn';
        if ($settings['btn_hover_animation']) {
            $elementClass .= ' elementor-animation-' . $settings['btn_hover_animation'];
        }
        $this->add_render_attribute('btn_class', 'class', $elementClass);
        ?>
        <div class="ahura-element-gotop">
            <button type="button" <?php echo $this->get_render_attribute_string('btn_class'); ?>>
                <?php \Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                <?php if ($settings['show_title'] === 'yes'): ?>
                    <span><?php echo $settings['btn_title'] ?></span>
                <?php endif; ?>
            </button>
        </div>
        <?php
    }
}