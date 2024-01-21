<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

class price_box_4 extends \Elementor\Widget_Base
{

    // Use prepared methods
    use \ahura\app\traits\mw_elementor;

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('ahura_price_box_4_widget_style', mw_assets::get_css('elementor.price_box_4'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('ahura_price_box_4_widget_style')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'ahura_price_box_4';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Price box 4', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon() {
		return 'aicon-svg-price-box-4';
	}

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraelements', 'ahura_price_box'];
    }

    public function get_keywords(){
        return ['pricebox4', 'price_box_4', esc_html__('Price box 4', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        /***
         *
         * Start content section
         *
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'library' => 'fa-solid',
                    'value' => 'fa fa-tags',
                ]
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
            'icon_alignment',
            [
                'label' => esc_html__('Icon Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .head .icon' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Conference ticket reservation', 'ahura')
            ]
        );
        $this->add_control(
            'title_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .head .title' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'show_price',
            [
                'label' => esc_html__('Show Price', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'price_text',
            [
                'label' => esc_html__('Price text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '169.000',
                'condition' => [
                    'show_price' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'currency_text',
            [
                'label' => esc_html__('Currency Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Toman', 'ahura'),
                'condition' => [
                    'show_price' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();
        /**
         *
         * #### End Content Section
         *
         *
         *
         * Start Items Section
         *
         */

        $this->start_controls_section(
            'items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $items_repeater = new \Elementor\Repeater();
        $items_repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Item title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Type your text', 'ahura')
            ]
        );
        $items_repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'library' => 'solid',
                    'value' => 'fa fa-circle'
                ]
            ]
        );
        $items_repeater->add_control(
            'item_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .price_box_4 .items {{CURRENT_ITEM}} .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price-box-wrap .price_box_4 .items {{CURRENT_ITEM}} .icon svg' => 'fill: {{VALUE}}'
                ]
            ]
        );
        $items_repeater->add_control(
            'item_icon_color_hover',
            [
                'label' => esc_html__('Color hover mode', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4 .items {{CURRENT_ITEM}} .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4 .items {{CURRENT_ITEM}} .icon svg' => 'fill: {{VALUE}}'
                ]
            ]
        );
        $default_item = [
            ['item_title' => esc_html__('Special Support', 'ahura')],
            ['item_title' => esc_html__('Access to all products', 'ahura')],
            ['item_title' => esc_html__('Fast download', 'ahura')],
            ['item_title' => esc_html__('Receive after-sales service', 'ahura')]
        ];
        $this->add_control(
            'box_items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $items_repeater->get_controls(),
                'title_field' => '{{{item_title}}}',
                'default' => $default_item
            ]
        );
        $this->end_controls_section();
        /**
         *
         *
         * #### End Items Section
         *
         *
         * Start button section
         *
         */
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'show_button',
            [
                'label' => esc_html__('Show Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Book a Ticket', 'ahura'),
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'button_link',
            [
                'label' => __('Button link', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://mihanwp.com/',
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();
        /**
         *
         * ### End button section
         *
         * */
        /**
         *
         *
         * Start title style tab
         *
         *
         */

        $this->start_controls_section(
            'box_title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('title_style_tabs');
        $this->start_controls_tab(
            'title_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#7d7d7d',
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .head .title' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo_style',
                'selector' => '{{WRAPPER}} .price_box_4 .head .title',
                'devices' => ['desktop', 'tablet'],
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '23'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 800
                    ],
                ]
            ]
        );
        $this->add_responsive_control(
            'box_title_margin',
            [
                'label' => esc_html__('Title Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .head .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => '10',
                    'right' => '0',
                    'bottom' => '30',
                    'left' => '0',
                ]
            ]
        );
        $this->add_responsive_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .head .icon i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .price_box_4 .head .icon svg' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 65
                ],
            ]
        );
        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#7d7d7d',
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .head .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price_box_4 .head .icon svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_icon_color_hover',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4 .head .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4 .head .icon svg' => 'fill: {{VALUE}}',
                ]
            ]
        );
        $this->add_control(
            'box_title_color_hover',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4 .head .title' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         *
         *
         * #### End title style tab
         *
         *
         *
         *  Start items style tab
         */

        $this->start_controls_section(
            'box_items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('items_style_tabs');
        $this->start_controls_tab(
            'items_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'items_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'right',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .price_box_4 .items .item' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'box_items_color',
            [
                'label' => esc_html__('Items color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#7a7a7a',
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .content .items .item' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_items_typo_style',
                'selector' => '{{WRAPPER}} .price_box_4 .content .items .item',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'items_box_margin',
            [
                'label' => esc_html__('Items Box Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => '20',
                    'right' => '0',
                    'bottom' => '30',
                    'left' => '0',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_items_margin',
            [
                'label' => esc_html__('Items Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .content .items .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => '7',
                    'right' => '0',
                    'bottom' => '7',
                    'left' => '0',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_items_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .items .item .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_items_icon_margin',
            [
                'label' => esc_html__('Items icon margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['right', 'left'],
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .content .items .item .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '10',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'items_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_items_color_hover',
            [
                'label' => esc_html__('Items color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4 .content .items .item' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         *
         *
         *
         * #### End items style tab
         *
         *
         *
         * Start price style tab
         *
         */

        $this->start_controls_section(
            'box_price_style',
            [
                'label' => esc_html__('Price', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_price' => 'yes'
                ]
            ]
        );
        $this->start_controls_tabs('price_style_tabs');
        $this->start_controls_tab(
            'price_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_price_alignment',
            [
                'label' => esc_html__('Price Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .price-wrap' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'price_wrap_margin',
            [
                'label' => esc_html__('Price margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .price-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => '10',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                ]
            ]
        );

        $this->add_control(
            'box_price_color',
            [
                'label' => esc_html__('Price color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#7a7a7a',
                'selectors' => [
                    '{{WRAPPER}} .price_box_4 .price-wrap div' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_price_typo_style',
                'label' => esc_html__('Price Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .price_box_4 .price-wrap',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '32'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 800
                    ],
                ]
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_price_currency_typo_style',
                'label' => esc_html__('Currency Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .price_box_4 .price-wrap .currency',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '22'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'price_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_price_color_hover',
            [
                'label' => esc_html__('Price color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4 .price-wrap div' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         *
         *
         * #### End price style tab
         *
         *
         *
         * Start button style tab
         *
         */


        $this->start_controls_section(
            'box_button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );
        $this->start_controls_tabs('button_style_tabs');
        $this->start_controls_tab(
            'button_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_button_alignment',
            [
                'label' => esc_html__('Button Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .box-buttons a' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'buttons_padding',
            [
                'label' => esc_html__('Button padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .box-buttons a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => '14',
                    'right' => '0',
                    'bottom' => '14',
                    'left' => '0',
                ]
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Button Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fe0000',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .box-buttons a' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .box-buttons a' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typo_style',
                'selector' => '{{WRAPPER}} .price-box-wrap .box-buttons a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '18'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 500
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price-box-wrap .box-buttons a',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' =>
                            [
                                'horizontal' => 0,
                                'vertical' => 7,
                                'blur' => 30,
                                'spread' => 0,
                                'color' => 'rgba(0, 0, 0, 0.14)'
                            ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'button_box_zindex',
            [
                'label' => esc_html__('Z index', 'ahura'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .box-buttons' => 'z-index: {{VALUE}}'
                ],
                'min' => 5,
                'default' => 500,
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'button_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__('Button Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .box-buttons a:hover' => 'color: {{VALUE}}'
                ]
            ]
        );


        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => esc_html__('background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap .box-buttons a:hover' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price-box-wrap .box-buttons a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /*
       *
        * Start Box style tab
        *
        */
        $this->start_controls_section(
            'box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('style_tabs');
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );
        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Box background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .price_box_4' => 'background-color: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .price_box_4',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => ['default' => '#f0f0f0']
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
                    '{{WRAPPER}} .price_box_4' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => ['isLinked' => true]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price_box_4',
            ]
        );
        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .price_box_4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 25,
                    'right' => 25,
                    'bottom' => 25,
                    'left' => 25,
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );
        /**
         *
         *
         * Start Hover
         *
         */
        $this->add_control(
            'box_bg_color_hover',
            [
                'label' => esc_html__('Box background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fe0000',
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4' => 'background-color: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .price-box-wrap:hover .price_box_4',
            ]
        );
        $this->add_control(
            'box_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .price-box-wrap:hover .price_box_4' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => ['isLinked' => true]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price-box-wrap:hover .price_box_4',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' =>
                            [
                                'horizontal' => 0,
                                'vertical' => 0,
                                'blur' => 25,
                                'spread' => 0,
                                'color' => '#fe0000'
                            ]
                    ]
                ],
            ]
        );
        /**
         *
         *
         * ## End hover
         *
         */
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     *
     * Render link attributes
     *
     */
    protected function render_link_attrs($url_data)
    {
        $target = $url_data['is_external'] ? 'target="_blank"' : '';
        $nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
        $cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
        $data = 'href="' . $url_data['url'] . '" ' . $target . ' ' . $nofollow . ' ' . $cu_attr;
        echo $data;
    }

    /**
     *
     * Render element content (html)
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $items = $settings['box_items'];
        ?>
        <div class="price-box-wrap">
            <div class="price_box_4">
                <div class="head">
                    <div class="title"><?php echo $settings['title'] ?></div>
                    <div class="icon"><?php \Elementor\Icons_Manager::render_icon($settings['icon']) ?></div>
                </div>
                <?php if ($items): ?>
                    <div class="content">
                        <div class="items">
                            <?php foreach ($items as $item): ?>
                                <div class="elementor-repeater-item-<?php echo $item['_id']; ?> item">
                                    <span class="icon">
                                        <?php \Elementor\Icons_Manager::render_icon($item['item_icon']); ?>
                                    </span>
                                    <span class="item-title"><?php echo $item['item_title'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($settings['show_price'] === 'yes'): ?>
                    <div class="foot">
                        <div class="price-wrap">
                            <div class="price"><?php echo $settings['price_text']; ?></div>
                            <div class="currency"><?php echo $settings['currency_text']; ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($settings['show_button'] === 'yes' && !empty($settings['button_text'])): ?>
                <div class="box-buttons">
                    <a <?php $this->render_link_attrs($settings['button_link']); ?>><?php echo $settings['button_text']; ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}