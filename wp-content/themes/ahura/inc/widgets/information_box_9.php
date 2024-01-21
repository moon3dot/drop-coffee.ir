<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class information_box_9 extends \Elementor\Widget_Base
{
    /**
     * information_box_9 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('information_box_9_css', mw_assets::get_css('elementor.information_box_9'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('information_box_9_css')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'information_box_9';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Information Box 9', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-icon-box';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraelements'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['informationbox9', 'information_box_9', esc_html__('Information Box 9', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        $alignment = [
            'left' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left'
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center'
            ],
            'right' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right'
            ]
        ];

        /**
         *
         * Start content section
         *
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-camera',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Photography', 'ahura'),
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'item_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                'condition' => [
                    'show_text' => 'yes'
                ]
            ]
        );

        $this->add_control('divider1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_text',
            [
                'label' => esc_html__('Show Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
        /*
         *
         *
         *
         * Start style section
         *
         */
        $this->start_controls_section(
            'box_icon_style',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2F61FF',
                'selectors' => [
                    '{{WRAPPER}} .information-box-9-wrap .box-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .information-box-9-wrap .box-icon svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .information-box-9-wrap .box-icon svg path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'box_icon_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .information-box-9-wrap .box-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .information-box-9-wrap .box-circle' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-9-wrap .box-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .information-box-9-wrap .box-icon svg' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50
                ],
            ]
        );

        $this->add_responsive_control(
            'box_dimension_size',
            [
                'label' => esc_html__('Dimensions', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-9-wrap .box-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .information-box-9-wrap .box-circle' => 'width: {{SIZE}}{{UNIT}};height: calc({{SIZE}}{{UNIT}} / 2)',
                ],
                'range' => [
                    'px' => [
                        'min' => 90,
                        'max' => 400
                    ],
                    'rem' => [
                        'min' => 5.3
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100
                ],
            ]
        );

        $this->add_control(
            'box_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-9-wrap .box-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
                    '{{WRAPPER}} .information-box-9-wrap .box-circle' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 70,
                    'right' => 70,
                    'bottom' => 70,
                    'left' => 70,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow',
                'selector' => '{{WRAPPER}} .information-box-9 .box-circle',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 1,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => '#0003'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         *
         *
         * Start details styles
         *
         */
        $this->start_controls_section(
            'box_content_style',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('box_content_style_tabs');
        $this->start_controls_tab(
            'box_content_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_content_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .information-box-9 .box-details' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'box_content_bg',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .information-box-9' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2F61FF',
                'selectors' => [
                    '{{WRAPPER}} .information-box-9 .box-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#A1A1A1',
                'selectors' => [
                    '{{WRAPPER}} .information-box-9 .box-text' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_text' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'box_title_typo',
                'selector' => '{{WRAPPER}} .information-box-9 .box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '25'
                        ]
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => '2.3'
                        ]
                    ],
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Text Typography', 'ahura'),
                'name' => 'box_text_typo',
                'selector' => '{{WRAPPER}} .information-box-9 .box-text',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '24'
                        ]
                    ],
                ],
                'condition' => [
                    'show_text' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-9' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_control(
            'box_content_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-9 .box-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 3,
                    'right' => 3,
                    'bottom' => 3,
                    'left' => 3,
                    'unit' => 'rem',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_details_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .information-box-9',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow_position' => ['default' => 'inset'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 11,
                            'blur' => 19,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.14)'
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'box_content_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_title_color_hover',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .information-box-9:hover .box-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_text_color_hover',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .information-box-9:hover .box-text' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_text' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_content_bg_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .information-box-9:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     *
     * Render element content (html)
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();

        $icon = $settings['item_icon']['value'];
        ?>
        <div class="information-box-9-wrap">
            <?php if ($icon): ?>
                <div class="box-icon-wrap">
                    <div class="box-icon">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="information-box-9">
                <?php if ($icon): ?>
                    <div class="box-circle"></div>
                <?php endif; ?>
                <div class="box-details">
                    <?php if ($settings['show_title'] === 'yes'): ?>
                        <div class="box-title"><?php echo $settings['item_title'] ?></div>
                    <?php endif; ?>
                    <?php if ($settings['show_text'] === 'yes'): ?>
                        <div class="box-text"><?php echo $settings['item_text'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}