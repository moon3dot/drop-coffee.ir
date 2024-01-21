<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined('ABSPATH') or die('No script kiddies please!');

class price_box_12 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_price_box_12';
    }
    function get_title()
    {
        return esc_html__('Price box 12', 'ahura');
    }
    function get_categories()
    {
        return ['ahuraelements', 'ahura_price_box'];
    }
    function get_keywords()
    {
        return ['pricebox12', 'price_box_12', esc_html__('Price box 12', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $price_box_12_css = mw_assets::get_css('elementor.price_box_12');
        mw_assets::register_style('elementor_price_box_12', $price_box_12_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_price_box_12')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'header_content',
            [
                'label' => esc_html__('Header', 'ahura'),
            ]
        );
        $this->add_control(
            'box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Standard', 'ahura'),
                'default' => esc_html__('Standard', 'ahura'),
            ]
        );

        $this->add_control(
            'price_value',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => is_rtl() ? '۹۰۰۰' : 399,
                'default' => is_rtl() ? '۹۰۰۰' : 399,
            ]
        );

        $this->add_control(
            'price_currency',
            [
                'label' => esc_html__('Currency', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. $', 'price_box_element', 'ahura'),
                'default' => esc_html_x('$', 'price_box_element', 'ahura'),
            ]
        );

        $this->add_control(
            'price_suffix',
            [
                'label' => esc_html__('Suffix', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. Monthly', 'price_box_element', 'ahura'),
                'default' => esc_html_x('Monthly', 'price_box_element', 'ahura'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'items_content',
            [
                'label' => esc_html__('Items', 'ahura'),
            ]
        );
        $items = new \Elementor\Repeater();
        $items->add_control(
            'item_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Support in ticket system', 'ahura'),
                'default' => esc_html__('Support in ticket system', 'ahura'),
            ]
        );
        $items->add_control(
            'item_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $items->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_text_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-value',
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
        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'label' => esc_html__('Items', 'ahura'),
                'title_field' => '{{{item_text}}}',
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'item_text' => esc_html__('Documentation of api', 'ahura'),
                    ],
                    [
                        'item_text' => esc_html__('Online meeting with your team', 'ahura'),
                    ],
                    [
                        'item_text' => esc_html__('24/7 supporting your site', 'ahura'),
                    ],
                    [
                        'item_text' => esc_html__('Support in ticket system', 'ahura'),
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_content',
            [
                'label' => esc_html__('Button', 'ahura'),
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Choose plan', 'ahura'),
                'default' => esc_html__('Choose plan', 'ahura'),
            ]
        );
        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'options' => ['url', 'is_external', 'nofollow'],
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // main box
        $this->start_controls_section(
            'main_box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // box background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'main_box_bg',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient'
                    ],
                    'color' => [
                        'default' => '#2c214a'
                    ],
                    'color_b' => [
                        // 'default' => '#B01B43'
                        'default' => '#514377'
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

        $this->add_control(
            'after_main_box_bg_controller_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // box-shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'widget_box_shadow',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12',
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
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12',
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
            'box_border_radius',
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
                            'name' => 'box_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'widget_box_shadow_box_shadow_type',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'main_box_bg_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .ahura_element_price_box_12' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // text alignment
        $alignmentOptions = [
            'left' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
        ];
        if (is_rtl()) {
            $alignmentOptions = array_reverse($alignmentOptions);
        }
        $this->add_control(
            'box_title_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-label' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // color
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-label' => 'color: {{VALUE}};'
                ],
                'default' => '#2C214A',
            ]
        );

        // bg-color
        $this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-label' => 'background-color: {{VALUE}};',
                ],
                'default' => '#fff',
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-label',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 30,
                        ],
                    ],
                    'font_weight' => ['default' => 'bold'],
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-label',
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
            'title_border_radius',
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
                            'name' => 'title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-label' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->start_controls_section(
            'price_style',
            [
                'label' => esc_html__('Price', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // text alignment
        $this->add_control(
            'price_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section' => 'justify-content: {{VALUE}}',
                ],
            ]
        );
        // direction
        $this->add_control(
            'price_section_reverse_flex_direction',
            [
                'label' => esc_html__('Reverse direction', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section' => 'flex-direction: row-reverse',
                ],
            ]
        );

        // gap
        $this->add_control(
            'price_section_items_gap',
            [
                'label' => esc_html__('Items gap', 'ahura'),
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
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_value_typography',
                'label' => esc_html__('Price typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section .ah-price',
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
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_currency_value_typography',
                'label' => esc_html__('Currency typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section .ah-price-currency',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                ],
            ]
        );

        // text color
        $this->add_control(
            'price_value_text_color',
            [
                'label' => esc_html__('Price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section .ah-price' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_control(
            'price_currency_value_text_color',
            [
                'label' => esc_html__('Currency color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section .ah-price-currency' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );

        // bg color
        $this->add_control(
            'price_section_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'price_section_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section',
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
            'price_section_border_radius',
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
                            'name' => 'price_section_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'price_section_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'price_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'price_section_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'price_section_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'price_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '20',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // price suffix
        $this->start_controls_section(
            'price_suffix_style',
            [
                'label' => esc_html__('Price suffix', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // alignment
        $this->add_control(
            'price_suffix_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-suffix' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_suffix_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-suffix',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                    'font_weight' => ['default' => 100],
                ],
            ]
        );

        // text color
        $this->add_control(
            'price_suffix_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-suffix' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );

        // bg-color
        $this->add_control(
            'price_suffix_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-suffix' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'price_suffix_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-suffix',
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
            'price_suffix_border_radius',
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
                            'name' => 'price_suffix_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'price_suffix_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-suffix' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'price_suffix_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-suffix' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'price_suffix_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'price_suffix_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'price_suffix_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-price-suffix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // items
        $this->start_controls_section(
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // alignment
        $this->add_control(
            'items_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html_x('Start', 'price_box_element', 'ahura'),
                        'icon' => is_rtl() ? 'eicon-text-align-right' : 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ahura'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html_x('End', 'price_box_element', 'ahura'),
                        'icon' => is_rtl() ? 'eicon-text-align-left' : 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-items' => 'align-items: {{VALUE}}',
                ],
            ]
        );

        // gap
        $this->add_control(
            'items_item_gap',
            [
                'label' => esc_html__('Items gap', 'ahura'),
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
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-items' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'items_section_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-items',
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
            'items_section_border_radius',
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
                'condition' => [
                    'items_section_border_border!' => '',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-items' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'items_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'items_section_border_border!' => '',
                ],
            ]
        );

        // margin
        $this->add_control(
            'items_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '40',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // buttons
        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // alignment
        $this->add_control(
            'button_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_btn_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a',
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


        $this->start_controls_tabs(
            'button_style_tabs'
        );
        $this->start_controls_tab(
            'button_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        // text color
        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );

        // bg color
        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
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
                        'default' => '#fff',
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'button_border_radius',
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
                            'name' => 'button_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        // text color
        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a:hover' => 'color: {{VALUE}};'
                ],
                'default' => '#2C214A',
            ]
        );

        // bg color
        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a:hover' => 'background-color: {{VALUE}};'
                ],
                'default' => '#fff',
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a:hover',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
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
                        'default' => '#fff',
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'button_border_radius_hover',
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
                            'name' => 'button_bg_color_hover',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_hover_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'button_style_after_hover_tab_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // padding
        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '8',
                    'bottom' => '8',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'button_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_bg_color_hover',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_hover_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_12 .ah-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '50',
                    'bottom' => '30',
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
        <div class="ahura_element_price_box_12">
            <div class="ah-label"><?php echo $settings['box_title']; ?></div>
            <div class="ah-price-section">
                <div class="ah-price"><?php echo $settings['price_value']; ?></div>
                <div class="ah-price-currency"><?php echo $settings['price_currency']; ?></div>
            </div>
            <div class="ah-price-suffix"><?php echo $settings['price_suffix']; ?></div>
            <div class="ah-items">
                <?php foreach ($settings['items'] as $item) : ?>
                    <span class="ah-item elementor-repeater-item-<?php echo $item['_id']; ?>">
                        <span class="ah-value"><?php echo $item['item_text']; ?></span>
                    </span>
                <?php endforeach; ?>
            </div>
            <div class="ah-button">
                <a <?php echo $this->get_render_attribute_string('button_link'); ?>><?php echo $settings['button_text']; ?></a>
            </div>
        </div>
<?php
    }
}
