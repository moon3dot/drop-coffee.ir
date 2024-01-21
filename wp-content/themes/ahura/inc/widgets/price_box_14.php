<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined('ABSPATH') or die('No script kiddies please!');

class price_box_14 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_price_box_14';
    }
    function get_title()
    {
        return esc_html__('Price box 14', 'ahura');
    }
    function get_categories()
    {
        return ['ahuraelements', 'ahura_price_box'];
    }
    function get_keywords()
    {
        return ['pricebox14', 'price_box_14', esc_html__('Price box 14', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $price_box_14_css = mw_assets::get_css('elementor.price_box_14');
        mw_assets::register_style('elementor_price_box_14', $price_box_14_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_price_box_14')];
    }
    protected function register_controls()
    {
        // icon
        $this->start_controls_section(
            'header_content',
            [
                'label' => esc_html__('Header', 'ahura'),
            ]
        );
        $this->add_control(
            'box_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-cloud',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'box_label_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('Standard', 'ahura')),
                'default' => esc_html__('Standard', 'ahura'),
            ]
        );

        // price value
        $this->add_control(
            'price_value',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => is_rtl() ? '۷۹' : 79,
                'default' => is_rtl() ? '۷۹' : 79,
            ]
        );

        // price currency
        $this->add_control(
            'price_currency',
            [
                'label' => esc_html__('Currency', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html_x('$', 'price_box_element', 'ahura')),
                'default' => is_rtl() ? esc_html_x('Hezar Toman', 'price_box_element', 'ahura') : esc_html_x('$', 'price_box_element', 'ahura'),
            ]
        );

        // box description
        $this->add_control(
            'box_description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('Most popular plan', 'ahura')),
                'default' => esc_html__('Most popular plan', 'ahura'),
            ]
        );

        $this->end_controls_section();

        // items section
        $this->start_controls_section(
            'items_content',
            [
                'label' => esc_html__('Items', 'ahura'),
            ]
        );
        $items = new \Elementor\Repeater();

        // item icon
        $items->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-check-circle',
                    'library' => 'solid',
                ],
            ]
        );
        // icon color
        $items->add_control(
            'item_icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#304088',
            ]
        );

        // icon bg-color
        $items->add_control(
            'item_icon_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // icon typography
        $items->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_icon_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes',
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );

        // icon border
        $items->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_icon_border',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon',
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
                        'default' => '#222a4f',
                    ],
                ],
            ]
        );

        // icon box size
        $items->add_control(
            'icon_box_width',
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
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // icon border-radius
        $items->add_control(
            'icon_box_border_radius',
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
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // items text heading
        $items->add_control(
            'items_content_item_text_heading',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // item text
        $items->add_control(
            'item_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Support in ticket system', 'ahura'),
                'default' => esc_html__('Support in ticket system', 'ahura'),
            ]
        );


        // text color
        $items->add_control(
            'item_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => '#d5d5d5',
            ]
        );

        // item text typography
        $items->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
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
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Documentation of api', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Online meeting with your team', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('24/7 supporting your site', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Support in ticket system', 'ahura'),
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // button section
        $this->start_controls_section(
            'button_content',
            [
                'label' => esc_html__('Button', 'ahura'),
            ]
        );

        // button text
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Choose plan', 'ahura'),
                'default' => esc_html__('Choose plan', 'ahura'),
            ]
        );

        // button link
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

        // box footer
        $this->start_controls_section(
            'footer_content',
            [
                'label' => esc_html__('Footer', 'ahura'),
            ]
        );

        // is active
        $this->add_control(
            'show_box_footer_text',
            [
                'label' => esc_html__('Show footer text', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // text
        $this->add_control(
            'box_footer_text',
            [
                'label' => esc_html__('Footer text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html_x('Try 14 day free trial', 'price_box_element', 'ahura')),
                'default' => esc_html_x('Try 14 day free trial', 'price_box_element', 'ahura'),
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // style tab
        // header box style
        $this->start_controls_section(
            'header_style',
            [
                'label' => esc_html__('Header', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        // header background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'main_box_header_bg',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-header',
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
        $this->add_control(
            'box_header_style_after_bg_controller',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // border-radius
        $this->add_control(
            'box_header_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '17',
                    'bottom' => '0',
                    'right' => '17',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'main_box_header_bg_background!' => '',
                ],
            ]
        );


        // padding
        $this->add_control(
            'box_header_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        
        $this->end_controls_section();

        
        // main box style
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
                'name' => 'main_box_body_bg',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient'
                    ],
                    'color' => [
                        'default' => '#1a2453'
                    ],
                    'color_b' => [
                        'default' => '#1c2137'
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
            'main_box_style_after_bg_controller',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        
        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'main_box_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 3,
                            'bottom' => 3,
                            'right' => 3,
                            'left' => 3,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#31417d',
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
                            'name' => 'main_box_body_bg_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();

        // icon section
        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // color
        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-icon-wrapper .ah-icon' => 'color: {{VALUE}};'
                ],
                'default' => '#b4db76',
            ]
        );

        // bg-color
        $this->add_control(
            'box_icon_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-icon-wrapper .ah-icon' => 'background-color: {{VALUE}};'
                ],
                'default' => '#212c57',
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_icon_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-icon-wrapper .ah-icon',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 35,
                        ],
                    ],
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
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-icon-wrapper .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_icon_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-icon-wrapper .ah-icon',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 3,
                            'bottom' => 3,
                            'right' => 3,
                            'left' => 3,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#354480',
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
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-icon-wrapper .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_icon_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_icon_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-icon-wrapper .ah-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'box_icon_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_icon_border_border',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '-40',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        
        $this->end_controls_section();

        // label section
        $this->start_controls_section(
            'label_style',
            [
                'label' => esc_html__('Label', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // text alignment
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
            'box_label_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-label-wrapper' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_label_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-label-wrapper .ah-label',
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
            'box_label_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-label-wrapper .ah-label' => 'color: {{VALUE}};'
                ],
                'default' => '#b4db76',
            ]
        );

        // bg-color
        $this->add_control(
            'box_label_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-label-wrapper .ah-label' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_label_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-label-wrapper .ah-label',
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
                        'default' => '#b4db76',
                    ],
                ],
            ]
        );
        
        // border-radius
        $this->add_control(
            'box_label_border_radius',
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
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-label-wrapper .ah-label' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_label_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        
        // padding
        $this->add_responsive_control(
            'box_label_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-label-wrapper .ah-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '3',
                    'bottom' => '3',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_label_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_responsive_control(
            'box_label_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-label-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // price section
        $this->start_controls_section(
            'price_section_style',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section' => 'justify-content: {{VALUE}}',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section' => 'flex-direction: row-reverse',
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
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // price typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_value_typography',
                'label' => esc_html__('Price typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section .ah-price-value',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 70,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],

                ],
            ]
        );

        // currency typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_currency_value_typography',
                'label' => esc_html__('Currency typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section .ah-price-currency',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                ],
            ]
        );

        // price text color
        $this->add_control(
            'price_value_text_color',
            [
                'label' => esc_html__('Price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section .ah-price-value' => 'color: {{VALUE}};'
                ],
                'default' => '#b4db76',
            ]
        );

        // currency text color
        $this->add_control(
            'price_currency_value_text_color',
            [
                'label' => esc_html__('Currency color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section .ah-price-currency' => 'color: {{VALUE}};'
                ],
                'default' => '#b4db76',
            ]
        );

        // bg color
        $this->add_control(
            'price_section_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'price_section_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-price-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // description section
        $this->start_controls_section(
            'box_description_style',
            [
                'label' => esc_html__('Description', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // alignment
        $this->add_control(
            'box_description_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-description' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_description_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-description',
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

        // text color
        $this->add_control(
            'box_description_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-description' => 'color: {{VALUE}};'
                ],
                'default' => '#d5d5d5',
            ]
        );

        // bg-color
        $this->add_control(
            'box_description_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-description' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_description_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-description',
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
                            'name' => 'box_description_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_description_border_border',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-description' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'box_description_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'box_description_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_description_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'box_description_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // items section
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
                'default' => 'start',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-items' => 'align-items: {{VALUE}}',
                ],
            ]
        );


        // direction
        $this->add_control(
            'items_item_reverse_flex_direction',
            [
                'label' => esc_html__('Reverse direction', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-items .ah-item' => 'flex-direction: row-reverse',
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
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-items' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'items_section_item_icon_and_text_gap',
            [
                'label' => esc_html__('Horizontal gap', 'ahura'),
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-items .ah-item' => 'gap: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '40',
                    'left' => '40',
                    'unit' => 'px',
                    'isLinked' => false,
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // button section

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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a',
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

        // normal mode
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a' => 'color: {{VALUE}};'
                ],
                'default' => '#fff',
            ]
        );

        // background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient'
                    ],
                    'color' => [
                        'default' => '#232f60'
                    ],
                    'color_b' => [
                        'default' => '#1d2648'
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
            'button_style_normal_background_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a',
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
                        'default' => '#2f3c6c',
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
                            'name' => 'button_bg_background',
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
                    'size' => '10',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        
        // hover mode
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a:hover' => 'color: {{VALUE}};'
                ],
                'default' => '#232f60',
            ]
        );

        // background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg_hover',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'gradient'
                    ],
                    'color' => [
                        'default' => '#fff'
                    ],
                    'color_b' => [
                        'default' => '#fff'
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

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a:hover',
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
                        'default' => '#2f3c6c',
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
                            'name' => 'button_bg_hover_background',
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
                    'size' => '10',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'button_bg_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_bg_hover_background',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '30',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // footer section
        $this->start_controls_section(
            'footer_style',
            [
                'label' => esc_html__('Footer', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
            ]
        );

        // footer alignment
        $this->add_control(
            'box_footer_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-footer' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_footer_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-footer',
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 12,
                        ],
                    ],
                ],
            ]
        );

        // text color
        $this->add_control(
            'box_footer_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-footer' => 'color: {{VALUE}};'
                ],
                'default' => '#b4db76',
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
            ]
        );

        // bg-color
        $this->add_control(
            'box_footer_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-footer' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_footer_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-footer',
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
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
            'box_footer_border_radius',
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
                            'name' => 'box_footer_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_footer_border_border',
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
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-footer' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'box_footer_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                            'name' => 'box_footer_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_footer_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'box_footer_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_14 .ah-box-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
                'default' => [
                    'top' => '30',
                    'bottom' => '20',
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
        <div class="ahura_element_price_box_14">
            <div class="ah-header">
                <div class="ah-icon-wrapper">
                    <div class="ah-icon">
                        <?php \Elementor\Icons_Manager::render_icon($settings['box_icon']) ?>
                    </div>
                </div>

                <div class="ah-label-wrapper">
                    <div class="ah-label"><?php echo $settings['box_label_text']; ?></div>
                </div>
                <div class="ah-price-section">
                    <span class="ah-price-value"><?php echo $settings['price_value']; ?></span>
                    <span class="ah-price-currency"><?php echo $settings['price_currency']; ?></span>
                </div>
                <div class="ah-box-description"><?php echo $settings['box_description']; ?></div>
            </div>
            <div class="ah-items">
                <?php foreach ($settings['items'] as $item) : ?>
                    <div class="ah-item elementor-repeater-item-<?php echo $item['_id']; ?>">
                        <span class="ah-icon">
                            <?php \Elementor\Icons_Manager::render_icon($item['item_icon']) ?>
                        </span>
                        <span class="ah-value"><?php echo $item['item_text']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="ah-button">
                <a <?php echo $this->get_render_attribute_string('button_link'); ?>><?php echo $settings['button_text']; ?></a>
            </div>
            <?php if ($settings['show_box_footer_text'] == 'yes') : ?>
                <div class="ah-box-footer"><?php printf('- %s -', $settings['box_footer_text']) ?></div>
            <?php endif; ?>
        </div>
<?php
    }
}
