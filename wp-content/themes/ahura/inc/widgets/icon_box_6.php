<?php

namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined('ABSPATH') or die('No script kiddies please!');

class icon_box_6 extends \Elementor\Widget_Base
{
    /**
     * @param $data
     * @param $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('icon_box_6_css', mw_assets::get_css('elementor.icon_box_6'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('icon_box_6_css')];
        return $styles;
    }

    public function get_name()
    {
        return 'ahura_icon_box_6';
    }

    public function get_title()
    {
        return __('Icon Box 6', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-form-vertical';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }
    function get_keywords()
    {
        return ['icon_box_6', 'iconbox6', esc_html__('Icon Box 6', 'ahura')];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // icon
        $this->add_control(
            'box_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-user',
                    'library' => 'solid',
                ],
            ]
        );

        // title text
        $this->add_control(
            'box_title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('Team', 'ahura')),
                'default' => esc_html__('Team', 'ahura'),
            ]
        );

        // description text
        $this->add_control(
            'box_description_text',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__("High quality team", 'ahura')),
                'default' => esc_html__("High quality team", 'ahura'),
            ]
        );

        $this->end_controls_section();

        // STYLE

        $this->start_controls_section(
            'main_box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'main_box_background',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient'
                    ],
                    'color' => [
                        'default' => '#2171d4'
                    ],
                    'color_b' => [
                        'default' => '#2cc4f0'
                    ],

                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => '40',
                        ],
                    ],
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'main_box_border',
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'main_box_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'main_box_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'main_box_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_responsive_control(
            'main_box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '40',
                    'bottom' => '50',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'main_box_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'main_box_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        // ICON
        $this->start_controls_section(
            'box_icon_style',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $alignmentOptions = [
            'right' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'left' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ],
        ];
        if (!is_rtl()) {
            $alignmentOptions = array_reverse($alignmentOptions);
        }

        // alignment
        $this->add_control(
            'box_icon_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        // width
        $this->add_control(
            'box_icon_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_icon_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_icon_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 90,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_icon_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper .ah-icon',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 40,
                        ],
                    ],
                ],
            ]
        );

        // color
        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper .ah-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper .ah-icon svg > *' => 'fill: {{VALUE}}',
                ],
                'default' => '#fff',
            ]
        );

        // background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_icon_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper .ah-icon',
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_icon_border',
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper .ah-icon',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 4,
                            'bottom' => 4,
                            'right' => 4,
                            'left' => 4,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#ffffff54',
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'box_icon_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_icon_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_icon_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_responsive_control(
            'box_icon_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper .ah-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_icon_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_icon_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_responsive_control(
            'box_icon_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        $this->end_controls_section();

        // TITLE
        $this->start_controls_section(
            'box_title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // alignment
        $this->add_control(
            'box_title_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-title' => 'text-align: {{VALUE}}',
                ],
            ]
        );


        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6 .ah-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 30,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                ],
            ]
        );

        // color
        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => '#fffffffc',
            ]
        );

        // background
        $this->add_control(
            'box_title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-title' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_title_border',
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6 .ah-title',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'box_title_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-title' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_responsive_control(
            'box_title_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_responsive_control(
            'box_title_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '35',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        $this->end_controls_section();

        // DESCRIPTION
        $this->start_controls_section(
            'box_description_style',
            [
                'label' => esc_html__('Description', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // alignment
        $this->add_control(
            'box_description_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-description' => 'text-align: {{VALUE}}',
                ],
            ]
        );


        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_description_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6 .ah-description',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 20,
                        ],
                    ],
                ],
            ]
        );

        // color
        $this->add_control(
            'box_description_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => '#ffffffc7',
            ]
        );

        // background
        $this->add_control(
            'box_description_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-description' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_description_border',
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_6 .ah-description',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'box_description_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_description_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_description_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-description' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_responsive_control(
            'box_description_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_description_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_description_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_responsive_control(
            'box_description_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_6 .ah-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '5',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        $this->end_controls_section();


    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['button_link']['url'])) {
            $this->add_link_attributes('button_link', $settings['button_link']);
        }
?>
        <div class="ahura_element_icon_box_6">
            <div class="ah-icon-wrapper">
                <div class="ah-icon">
                    <?php \Elementor\Icons_Manager::render_icon($settings['box_icon']) ?>
                </div>
            </div>
            <div class="ah-title"><?php echo $settings['box_title_text']; ?></div>
            <div class="ah-description"><?php echo $settings['box_description_text']; ?></div>
        </div>
<?php
    }
}
