<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use \Elementor\Controls_Manager;

class price_table extends \Elementor\Widget_Base
{

    // Use prepared methods
    use \ahura\app\traits\mw_elementor;

    /**
     * price_table constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        \ahura\app\mw_assets::register_style('price_table_css', \ahura\app\mw_assets::get_css('elementor.price_table'));
    }

    public function get_style_depends()
    {
        return [\ahura\app\mw_assets::get_handle_name('price_table_css')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'price_table';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Price Table 1', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon() {
		return 'aicon-svg-price-table';
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

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['pricetable', 'price_table', esc_html__('Price Table 1', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        /**
         *
         * Start title box content
         *
         */
        $this->start_controls_section(
            'price_table_title_box',
            [
                'label' => esc_html__('Title', 'ahura'),
            ]
        );

        $this->add_control(
            'table_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Monthly account', 'ahura'),
            ]
        );

        $this->add_control(
            'table_title_icon_show',
            [
                'label' => esc_html__('Use Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'table_title_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'table_title_icon_show' => 'yes'
                ],
                'default' => [
                    'value' => 'fa fa-check',
                    'library' => 'solid'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         * Start price box content
         *
         */
        $this->start_controls_section(
            'price_table_price_box',
            [
                'label' => esc_html__('Price', 'ahura'),
            ]
        );

        $this->add_control(
            'table_price',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '148.000',
            ]
        );

        $this->add_control(
            'table_price_currency',
            [
                'label' => esc_html__('Currency', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Toman', 'ahura'),
            ]
        );

        $this->add_control(
            'table_price_special',
            [
                'label' => esc_html__('Special sales', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'table_price_regular',
            [
                'label' => esc_html__('Regular price', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '188.000',
                'condition' => [
                    'table_price_special' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         * Start features box content
         *
         */
        $this->start_controls_section(
            'price_table_features',
            [
                'label' => esc_html__('Features', 'ahura'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title', [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title', 'ahura'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'skin' => 'inline',
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'item_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#30B82C',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .features {{CURRENT_ITEM}} .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price-table-1 .features {{CURRENT_ITEM}} .icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'price_table_items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{item_title}}}',
                'default' => [
                    ['item_title' => esc_html__('24-hour support', 'ahura')],
                    ['item_title' => esc_html__('Half price traffic', 'ahura')],
                    ['item_title' => esc_html__('Online service', 'ahura')],
                    ['item_title' => esc_html__('Global bandwidth speed', 'ahura')],
                ]
            ]
        );
        $this->end_controls_section();

        /**
         *
         * Start button box content
         *
         */
        $this->start_controls_section(
            'price_table_button',
            [
                'label' => esc_html__('Button', 'ahura'),
            ]
        );

        $this->add_control(
            'table_button_show',
            [
                'label' => esc_html__('Button Show', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'table_button_title', [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Order account', 'ahura'),
                'condition' => [
                    'table_button_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'table_button_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://mihanwp.com',
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'condition' => [
                    'table_button_show' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /***
         *
         *
         *
         *
         * Start styles
         *
         *
         *
         */
        /**
         *
         *
         * Start title style
         *
         */
        $this->start_controls_section(
            'table_price_title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

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

        $this->add_control(
            'table_title_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .title' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'table_title_bg',
                'selector' => '{{WRAPPER}} .price-table-1 .title',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#e13427'],
                ]
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .price-table-1 .head .title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'title_shadow',
                'label' => esc_html__('Title Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1 .title',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 6,
                            'blur' => 6,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .20)'
                        ]
                    ]
                ],
            ]
        );

        $this->add_control('divider_hr', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
            'condition' => [
                'table_title_icon_show'
            ]
        ]);

        $this->add_control(
            'table_title_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .title .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price-table-1 .title .icon svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'table_title_icon_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'table_title_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
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
                    '{{WRAPPER}} .price-table-1 .title .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .price-table-1 .title .icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'table_title_icon_show' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();

        /**
         *
         *
         *
         * Start price style
         *
         */
        $this->start_controls_section(
            'table_price_value_box_style',
            [
                'label' => esc_html__('Price', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'price_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .price' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'price_bg',
                'selector' => '{{WRAPPER}} .price-table-1 .price',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#e44f47'],
                ]
            ]
        );

        $this->add_control(
            'price_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .price div' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'regular_price_text_color',
            [
                'label' => esc_html__('Regular Price Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .price .discount' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'table_price_special' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typo',
                'selector' => '{{WRAPPER}} .price-table-1 .price .p',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '27'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_currency_typo',
                'label' => esc_html__('Currency Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1 .price .c',
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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'regular_price_typo',
                'label' => esc_html__('Regular Price Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1 .price .discount',
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
                ],
                'condition' => [
                    'table_price_special' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'price_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'price_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'price_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1 .price',
            ]
        );
        $this->end_controls_section();
        /**
         *
         *
         *
         * items style
         *
         *
         */
        $this->start_controls_section(
            'table_price_items_style',
            [
                'label' => esc_html__('Features', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'price_items_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .features .item' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'price_items_bg',
                'label' => esc_html__('Items Box Background', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1 .content',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
            ]
        );

        $this->add_control(
            'price_items_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_control(
            'price_items_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control('hr', ['type' => \Elementor\Controls_Manager::DIVIDER]);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'price_items_item_bg',
                'label' => esc_html__('Item Background', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1 .features .item',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#f7f7f7'],
                ]
            ]
        );

        $this->add_control(
            'price_features_item_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .features .item' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_features_item_typo',
                'selector' => '{{WRAPPER}} .price-table-1 .features .item',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ]
            ]
        );

        $this->add_control(
            'price_features_item_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
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
                    '{{WRAPPER}} .price-table-1 .features .item .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .price-table-1 .features .item .icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_features_item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .features .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 12,
                    'right' => 12,
                    'bottom' => 12,
                    'left' => 12,
                ]
            ]
        );

        $this->add_control(
            'price_features_item_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'allowed_dimensions' => ['top', 'bottom'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .features .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0,
                ]
            ]
        );

        $this->add_responsive_control(
            'price_features_item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .features .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'price_features_item_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1 .features .item',
            ]
        );
        $this->end_controls_section();

        /**
         *
         *
         *
         * Buttons style
         *
         *
         */

        $this->start_controls_section(
            'table_price_buttons_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'table_button_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'price_buttons_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .buttons a' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_buttons_typo',
                'selector' => '{{WRAPPER}} .price-table-1 .buttons a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 30
                    ],
                ]
            ]
        );

        $this->add_control(
            'price_buttons_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .buttons a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'price_buttons_bg',
                'selector' => '{{WRAPPER}} .price-table-1 .buttons a',
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'color' => ['default' => '#e13427'],
                    'color_b' => ['default' => '#e83446'],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 110
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'price_buttons_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .buttons a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 13,
                    'right' => 13,
                    'bottom' => 13,
                    'left' => 13,
                ]
            ]
        );

        $this->add_control(
            'price_buttons_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'allowed_dimensions' => ['top', 'bottom'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .buttons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 20,
                    'bottom' => 0,
                ]
            ]
        );

        $this->add_responsive_control(
            'price_buttons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1 .buttons a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'price_buttons_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1 .buttons a',
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'table_price_box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'table_price_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .price-table-1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'table_price_content_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price-table-1',
            ]
        );

        $this->end_controls_section();

    }

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
        $items = $settings['price_table_items'];
        ?>
        <div class="price-table price-table-1">
            <div class="head">
                <?php if (!empty($settings['table_title'])): ?>
                    <div class="title">
                        <?php if ($settings['table_title_icon_show'] === 'yes'): ?>
                            <span class="icon">
                                <?php \Elementor\Icons_Manager::render_icon( $settings['table_title_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>
                        <?php echo $settings['table_title'] ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($settings['table_price'])): ?>
                    <div class="price">
                        <?php if ($settings['table_price_special'] === 'yes'): ?>
                            <del class="discount">
                                <?php echo $settings['table_price_regular'] . ' ' . $settings['table_price_currency'] ?>
                            </del>
                        <?php endif; ?>
                        <div class="regular">
                            <div class="p"><?php echo $settings['table_price'] ?></div>
                            <div class="c"><?php echo $settings['table_price_currency'] ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="content">
                <div class="features">
                    <?php if ($items): ?>
                        <ul>
                            <?php foreach ($items as $item): ?>
                                <li class="item elementor-repeater-item-<?php echo $item['_id'] ?>">
                                    <?php if (array_key_exists('value', $item['item_icon'])): ?>
                                        <span class="icon">
                                            <?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span><?php echo $item['item_title'] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <?php if ($settings['table_button_show'] === 'yes'): ?>
                    <div class="foot buttons">
                        <a <?php $this->render_link_attrs($settings['table_button_link']) ?>><?= $settings['table_button_title'] ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}