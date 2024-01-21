<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined('ABSPATH') or die('No script kiddies please!');

class faq_4 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_faq_4';
    }
    function get_title()
    {
        return esc_html__('FAQ 4', 'ahura');
    }
    function get_categories()
    {
        return ['ahuraelements'];
    }
    function get_keywords()
    {
        return ['frequentaly asked question 4', 'frequentaly_asked_question_4', 'faq4', 'faq 4', esc_html__('FAQ 4', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('elementor_faq_4', mw_assets::get_css('elementor.faq_4'));
        mw_assets::register_script('elementor_faq_4', mw_assets::get_js('elementor.faq_4'));
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_faq_4')];
    }
    function get_script_depends()
    {
        return [mw_assets::get_handle_name('elementor_faq_4')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'items_content',
            [
                'label' => esc_html__('Items', 'ahura'),
            ]
        );

        $items = new \Elementor\Repeater();

        $items->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Support in ticket system', 'ahura'),
                'default' => esc_html__('How can i submit new ticket?', 'ahura'),
            ]
        );
        $items->add_control(
            'item_description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Write description text here', 'ahura'),
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
            ]
        );

        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'label' => esc_html__('Items', 'ahura'),
                'title_field' => '{{{item_title}}}',
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'item_title' => esc_html__('How can i submit new ticket?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_title' => esc_html__('How can I track my order?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_title' => esc_html__('Can I pay my order in installments (credit)?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_title' => esc_html__('How is the shipping cost calculated?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_title' => esc_html__('What are the terms for buying and returning goods?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_title' => esc_html__('What are the conditions for using the discount code for the first purchase?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        // ICONS
        $this->start_controls_section(
            'icons_content',
            [
                'label' => esc_html__('Icons', 'ahura'),
            ]
        );
        $this->add_control(
            'item_icon_for_open',
            [
                'label' => esc_html_x('Open icon', 'faq_element', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-plus',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'item_icon_for_close',
            [
                'label' => esc_html_x('Close icon', 'faq_element', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-minus',
                    'library' => 'solid',
                ],
            ]
        );

        $this->end_controls_section();

        // STYLES

        // Main Box
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
                'selector' => '{{WRAPPER}} .ahura_element_faq_4',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#080d27'
                    ],
                ],
            ]
        );

        // box-shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'main_widget_box_shadow',
                'selector' => '{{WRAPPER}} .ahura_element_faq_4',
                'fields_options' => [
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .06)'
                        ]
                    ]
                ]
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'main_box_border',
                'selector' => '{{WRAPPER}} .ahura_element_faq_4',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
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
                            'name' => 'main_widget_box_shadow_box_shadow_type',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'main_box_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    // 'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // Items
        $this->start_controls_section(
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'items_style_tabs'
        );
        $this->start_controls_tab(
            'items_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );
        // background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'items_item_background',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'items_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        // border-color
        $this->add_control(
            'items_item_border_color',
            [
                'label' => esc_html__('Border color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open::before' => 'background-color: {{VALUE}};',
                ],
                'default' => '#80bde1',
            ]
        );

        // background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'items_item_background_hover',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover, {{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient'
                    ],
                    'color' => [
                        'default' => '#213170'
                    ],
                    'color_b' => [
                        'default' => '#42518a'
                    ],

                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 130,
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'item_style_after_hover_tab_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // border-radius
        $this->add_control(
            'items_item_border_radius',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'items_item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '25',
                    'left' => '25',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        // margin
        $this->add_control(
            'items_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // Items Number
        $this->start_controls_section(
            'items_number_style',
            [
                'label' => esc_html_x('Numbers', 'faq_element', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_number_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-number',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 12,
                        ],
                    ],
                    'font_weight' => ['default' => 'bold'],
                ],
            ]
        );

        // start tabs
        $this->start_controls_tabs(
            'item_number_style_tabs'
        );
        $this->start_controls_tab(
            'item_number_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        // color
        $this->add_control(
            'item_number_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-number' => 'color: {{VALUE}};',
                ],
                'default' => '#ccb58c',
            ]
        );

        // bg-color
        $this->add_control(
            'item_number_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_number_border',
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-number',
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
            'item_number_border_radius',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'item_number_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_number_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-number' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_number_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        // color
        $this->add_control(
            'item_number_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-number' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-number' => 'color: {{VALUE}};',
                ],
                'default' => '#80bde1',
            ]
        );

        // bg-color
        $this->add_control(
            'item_number_bg_color_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-number' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_number_border_hover',
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-number, {{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-number',
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
            'item_number_border_radius_hover',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'item_number_bg_color_hover',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_number_border_hover_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-number' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-number' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'item_number_style_after_hover_tab_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        // padding
        $this->add_control(
            'item_number_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'item_number_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_number_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_number_bg_color_hover',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_number_border_hover_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'item_number_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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


        // Title
        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title .ah-title-value',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 18,
                        ],
                    ],
                ],
            ]
        );

        // start tabs
        $this->start_controls_tabs(
            'item_title_style_tabs'
        );
        $this->start_controls_tab(
            'item_title_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        // color
        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title .ah-title-value' => 'color: {{VALUE}};',
                ],
                'default' => '#fff',
            ]
        );

        // bg-color
        $this->add_control(
            'item_title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title .ah-title-value' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_title_border',
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title .ah-title-value',
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

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_title_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        // color
        $this->add_control(
            'item_title_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-title .ah-title-value' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-title .ah-title-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        // bg-color
        $this->add_control(
            'item_title_bg_color_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-title .ah-title-value' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-title .ah-title-value' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_title_border_hover',
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-title .ah-title-value, {{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-title .ah-title-value',
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

        $this->end_controls_tab();
        $this->end_controls_tabs();
        // end tabs

        $this->add_control(
            'item_title_style_after_hover_tab_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // border-radius
        $this->add_control(
            'item_title_border_radius',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'item_title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_title_bg_color_hover',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_title_border_hover_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title .ah-title-value' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'item_title_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title .ah-title-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'item_title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_title_bg_color_hover',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_title_border_hover_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'item_title_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title .ah-title-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // Description
        $this->start_controls_section(
            'description_style',
            [
                'label' => esc_html__('Description', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_description_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-description',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );

        // color
        $this->add_control(
            'item_description_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-description' => 'color: {{VALUE}};',
                ],
                'default' => '#ffffffa3',
            ]
        );

        // margin
        $this->add_control(
            'item_description_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // Icons
        $this->start_controls_section(
            'icons_style',
            [
                'label' => esc_html__('Icons', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // width
        $this->add_control(
            'item_tool_icon_width',
            [
                'label' => esc_html__('Width', 'ahura'),
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
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title-section .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title-section .ah-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // start tabs
        $this->start_controls_tabs(
            'item_tool_icon_style_tabs'
        );
        $this->start_controls_tab(
            'item_tool_icon_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        // color
        $this->add_control(
            'item_tool_icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title-section .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title-section .ah-icon svg' => 'fill: {{VALUE}};',
                ],
                'default' => '#fff',
            ]
        );

        // bg-color
        $this->add_control(
            'item_tool_icon_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title-section .ah-icon' => 'background-color: {{VALUE}};',
                ],
                'default' => '#162055',
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_tool_icon_border',
                'selector' => '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title-section .ah-icon',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 2,
                            'bottom' => 2,
                            'right' => 2,
                            'left' => 2,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#2c3879',
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_tool_icon_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        // color
        $this->add_control(
            'item_tool_icon_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-title-section .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-title-section .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-title-section .ah-icon svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-title-section .ah-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // bg-color
        $this->add_control(
            'item_tool_icon_bg_color_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-title-section .ah-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-title-section .ah-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // border-color
        $this->add_control(
            'item_tool_icon_border_color_hover',
            [
                'label' => esc_html__('Border color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item:hover .ah-title-section .ah-icon' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item.ah-open .ah-title-section .ah-icon' => 'border-color: {{VALUE}};',
                ],
                'default' => '#2c3879',
                'condition' => [
                    'item_tool_icon_border_border!' => '',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'item_tool_icon_style_after_hover_tab_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // border-radius
        $this->add_control(
            'item_tool_icon_border_radius_hover',
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
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'item_tool_icon_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_tool_icon_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_tool_icon_bg_color_hover',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title-section .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'item_tool_icon_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq_4 .ah-items .ah-item .ah-title-section .ah-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'item_tool_icon_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_tool_icon_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_tool_icon_bg_color_hover',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="ahura_element_faq_4">
            <div class="ah-items">
                <?php $counter = 1;
                foreach ($settings['items'] as $item) : ?>
                    <div class="ah-item <?php printf('elementor-repeater-item-%s', $item['_id']) ?>">
                        <div class="ah-title-section">
                            <div class="ah-title">
                                <div class="ah-number"><?php printf("%02d", $counter); ?></div>
                                <div class="ah-title-value"><?php echo $item['item_title']; ?></div>
                            </div>
                            <div class="ah-icon ah-for-open">
                                <?php \Elementor\Icons_Manager::render_icon($settings['item_icon_for_open']) ?>
                            </div>
                            <div class="ah-icon ah-for-close">
                                <?php \Elementor\Icons_Manager::render_icon($settings['item_icon_for_close']) ?>
                            </div>
                        </div>
                        <div class="ah-description"><?php echo $item['item_description']; ?></div>
                    </div>
                <?php $counter++;
                endforeach; ?>
            </div>
        </div>
<?php
    }
}
