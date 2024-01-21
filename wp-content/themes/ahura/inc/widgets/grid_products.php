<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class grid_products extends \Elementor\Widget_Base
{
    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_products_css', mw_assets::get_css('elementor.grid_products'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('grid_products_css')];
    }

    public function get_name()
    {
        return 'grid_products';
    }

    public function get_title()
    {
        return esc_html__('Grid Products', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-grid-products';
    }

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_woocommerce'];
    }

    public function get_keywords()
    {
        return ['girdproducts', 'grid_products', __('Grid Products', 'ahura')];
    }


    public function register_controls()
    {
        $this->start_controls_section(
            'display_settings',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $categories = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));
        $cats = [];
        if (\ahura\app\woocommerce::is_active()) {
            if($categories){
                foreach ( $categories as $category ) {
                    $cats[ $category->slug ] = $category->name;
                }
            }
        }

        $this->add_control(
            'catsid',
            [
                'label'    => __( 'Categories', 'ahura' ),
                'type'     => Controls_Manager::SELECT2,
                'options'  => array_merge(
                    [ 'allproducts'  => esc_html__( 'All Products', 'ahura' ) ],
                    $cats ),
                'label_block' => true,
                'multiple' => true,
                'default' => 'allproducts'
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Number of Per Page', 'ahura'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 12
            ]
        );

        $this->add_responsive_control(
            'layout_col',
            [
                'label' => esc_html__('Columns', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
                'options' => [
                    '1' => 12,
                    '2' => 6,
                    '3' => 4,
                    '4' => 3,
                    '6' => 2,
                    '12' => 1,
                ]
            ]
        );

        $this->add_responsive_control(
            'layout_spacing',
            [
                'label' => esc_html__('Spacing', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35
                ],
                'selectors' => [
                    '{{WRAPPER}} .products-list .row' => 'row-gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $alignment = array(
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
            ]
        );
        if (!is_rtl()) {
            $alignment = array_reverse($alignment);
        }

        $this->add_control(
            'box_text_alignment',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignment,
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .products-list .product' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover_size',
                'default' => 'shop_catalog',
            ]
        );

        $this->add_responsive_control(
            'object_fit',
            [
                'label' => esc_html__( 'Aspect ratio', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'fill' => esc_html__( 'Default', 'ahura' ),
                    'contain' => esc_html__( 'Contain', 'ahura' ),
                    'cover'  => esc_html__( 'Cover', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-cover img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control('divider', ['type' => \Elementor\Controls_Manager::DIVIDER]);

        $stock_options = (function_exists('wc_get_product_stock_status_options')) ? wc_get_product_stock_status_options() : [];

        $this->add_control(
            'products_stock_status',
            [
                'label'   => esc_html__('Stock status of products', 'ahura'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'options' => array_merge(['none'  => esc_html__('None', 'ahura')], $stock_options),
                'default' => 'instock'
            ]
        );

        $this->add_control(
            'sale_price_product',
            [
                'label'   => __( 'Show only discounted products', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'yes'  => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no' => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        /**
         *
         * More Settings
         *
         */
        $this->start_controls_section(
            'display_more_settings',
            [
                'label' => esc_html__('More Settings', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'show_badge',
            [
                'label' => esc_html__('Badge', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_html_tag',
            [
                'label' => esc_html__('Title Html Tag', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                    'P' => 'P',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_cart_button',
            [
                'label' => esc_html__('Cart Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();


        /**
         *
         *
         * Start Item style
         *
         */
        $this->start_controls_section(
            'item_styles',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('item_styles_tabs');

        $this->start_controls_tab(
            'item_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .products-list .product',
            ]
        );

        $this->add_responsive_control(
			'item_border_radius',
			[
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
					'unit' => 'px',
					'size' => 35,
				],
                'tablet_default' => [
                    'unit' => 'px',
					'size' => 35,
                ],
                'mobile_default' => [
                    'unit' => 'px',
					'size' => 35,
                ],

				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

        $this->add_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'item_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .products-list .product',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .07)'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'item_entrance_animation',
            [
                'label' => esc_html__('Entrance Animation', 'ahura'),
                'type' => \Elementor\Controls_Manager::ANIMATION,
                'prefix_class' => 'animated ',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .products-list .product:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        
        /**
         *
         *
         * Start image style
         *
         *
         */
        $this->start_controls_section(
            'item_img_styles',
            [
                'label' => esc_html__('Image', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_img_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .products-list .product .product-cover img',
            ]
        );

        $this->add_responsive_control(
			'item_img_border_radius',
			[
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-cover img' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
					'unit' => 'px',
					'size' => 30,
				],
                'tablet_default' => [
                    'unit' => 'px',
					'size' => 30,
                ],
                'mobile_default' => [
                    'unit' => 'px',
					'size' => 30,
                ],

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
			]
		);

        $this->add_responsive_control(
            'item_img_min_height',
            [
                'label' => esc_html__('Min Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 100,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 200,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 150,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-cover img' => 'min-height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_img_spacing',
            [
                'label' => esc_html__('Spacing', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-cover' => 'margin-bottom: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Start title style
         *
         *
         */
        $this->start_controls_section(
            'item_title_styles',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#686868',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .title-wrap a *' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_color_hover',
            [
                'label' => esc_html__('Hover Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .products-list .product:hover .title-wrap a *' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .products-list .product .title-wrap a *',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'item_title_spacing',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .title-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        /**
         *
         * Start price style
         *
         */
        $this->start_controls_section(
            'item_price_styles',
            [
                'label' => esc_html__('Price', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_price' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'item_price_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495c',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .price-wrap .price > span > bdi' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .products-list .product .price-wrap .price ins span bdi' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .products-list .product .price-wrap .price .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_price_color_hover',
            [
                'label' => esc_html__('Hover Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .products-list .product:hover .price-wrap .price > span > bdi' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .products-list .product:hover .price-wrap .price ins span bdi' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .products-list .product:hover .price-wrap .price .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_price_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .price-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 20,
                    'left' => 0,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price_typography',
                'selector' => '{{WRAPPER}} .products-list .product .price-wrap .price > span > bdi, {{WRAPPER}} .products-list .product .price-wrap .price ins span bdi',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '18',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'divider_price',
            [
                'label' => esc_html__('Sale Price', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_price_dis_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#b7b7b7',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .price-wrap .price del' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .products-list .product .price-wrap .price del .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_price_dis_color_hover',
            [
                'label' => esc_html__('Hover Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .products-list .product:hover .price-wrap .price del' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .products-list .product:hover .price-wrap .price del .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_price_dis_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .price-wrap .price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 0,
                    'right' => 7,
                    'bottom' => 0,
                    'left' => 7,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price_dis_typography',
                'selector' => '{{WRAPPER}} .products-list .product .price-wrap .price del span bdi',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '300'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ],
                ]
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Start badge styles
         *
         */
        $this->start_controls_section(
            'item_badge_styles',
            [
                'label' => esc_html__('Badge', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_badge' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_badge_typo',
                'selector' => '{{WRAPPER}} .products-list .product .product-label span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_badge_padding',
            [
                'label' => esc_html__('padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-label span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 3,
                    'right' => 13,
                    'bottom' => 3,
                    'left' => 13,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_badge_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .products-list .product .product-label span',
            ]
        );

        $this->add_responsive_control(
			'item_badge_border_radius',
			[
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-label span' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
					'unit' => 'px',
					'size' => 7,
				],
                'tablet_default' => [
                    'unit' => 'px',
					'size' => 7,
                ],
                'mobile_default' => [
                    'unit' => 'px',
					'size' => 7,
                ],

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
			]
		);

        $this->add_control(
            'divider_badge1',
            [
                'label' => esc_html__('New', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_badge_new_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-label .new' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_badge_new_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00b0ff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-label .new' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'divider_badge2',
            [
                'label' => esc_html__('Not In Stock', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_badge_soldout_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-label .soldout' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_badge_soldout_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#c00',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-label .soldout' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'divider_badge3',
            [
                'label' => esc_html__('On Sale', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_badge_onsale_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-label .onsale' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_badge_onsale_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffb93a',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-label .onsale' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Item button styles
         *
         */
        $this->start_controls_section(
            'item_buttons_styles',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart_button' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('item_buttons_styles_tabs');

        $this->start_controls_tab(
            'item_buttons_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_responsive_control(
            'item_button_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'devices' => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_button_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_button_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .products-list .product .product-foot a',
            ]
        );

        $this->add_responsive_control(
			'item_button_border_radius',
			[
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
					'unit' => 'px',
					'size' => 50,
				],
                'tablet_default' => [
                    'unit' => 'px',
					'size' => 50,
                ],
                'mobile_default' => [
                    'unit' => 'px',
					'size' => 50,
                ],

				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

        $this->add_responsive_control(
            'item_button_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'isLinked' => false,
                    'top' => 7,
                    'right' => 30,
                    'bottom' => 7,
                    'left' => 30,
                ],
                'desktop_default' => [
                    'isLinked' => false,
                    'top' => 7,
                    'right' => 30,
                    'bottom' => 7,
                    'left' => 30,
                ],
                'tablet_default' => [
                    'isLinked' => false,
                    'top' => 7,
                    'right' => 15,
                    'bottom' => 7,
                    'left' => 15,
                ],
                'mobile_default' => [
                    'isLinked' => false,
                    'top' => 7,
                    'right' => 15,
                    'bottom' => 7,
                    'left' => 15,
                ],
            ]
        );

        $this->add_responsive_control(
            'item_buttons_wrap_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'isLinked' => false,
                    'top' => 0,
                    'right' => 0,
                    'bottom' => -32,
                    'left' => 0,
                ]
            ]
        );

        $this->add_control(
            'item_view_cart_button_div',
            [
                'label' => esc_html__('View Cart Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_button_cart_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a.added_to_cart' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_button_cart_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#46c780',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a.added_to_cart' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_button_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_button_cart_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_button_cart_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .products-list .product .product-foot a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_button_cart_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .products-list .product .product-foot a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         *
         *
         * item pagination styles
         *
         *
         */
        $this->start_controls_section(
            'item_pagination_styles',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('item_pagination_styles_tabs');

        $this->start_controls_tab(
            'item_pagination_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#626262',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_pagination_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, .ahura-pagination span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, .ahura-pagination span:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_pagination_styles_active_tab',
            [
                'label' => esc_html__('Active', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_active_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_active_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00b0ff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     *
     * Check is new product
     *
     * @return bool
     */
    public function is_new_product()
    {
        global $product;
        $days = 5;
        $created = strtotime($product->get_date_created());
        return ((time() - (60 * 60 * 24 * $days)) < $created);
    }

    /**
     *
     * Get products result
     *
     * @param array $params
     * @return false
     */
    public function get_products($params = [])
    {
        $settings = $this->get_settings_for_display();
        $field_is_term = (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);

        if( $settings[ 'catsid' ] == 'allproducts' || ( $settings[ 'catsid' ][ 0 ] == 'allproducts' ) ) {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $settings['per_page'],
                'post_status' => 'publish',
            );

        } else {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $settings['per_page'],
                'post_status' => 'publish',
                'tax_query'		 => [ [
                    'taxonomy'   => 'product_cat',
                    'field'		 => $field_is_term ? 'term_id' : 'slug',
                    'terms'		 => $settings[ 'catsid' ],
                ] ],
            );
        }

        $term = (array) get_queried_object();

        if (is_array($term) && isset($term['term_id']) && isset($term['slug'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $term['taxonomy'],
                    'field'    => 'slug',
                    'terms'    => $term['slug'],
                ),
            );
        }

        $products_stock_status = $settings['products_stock_status'];

        if ($products_stock_status && $products_stock_status !== 'none') {
            $args['meta_query'] = array(array(
                'key' => '_stock_status',
                'value' => $products_stock_status,
                'compare' => '==',
            ));
        }

        if($settings['sale_price_product'] === 'yes'){
            $args = array_merge($args, [
                'order' 		 => $settings['product_order'],
                'meta_key' 		 => '_sale_price',
                'meta_value' 	 => '0',
                'meta_compare'   => '>='
            ]);
        }

        $products = new \WP_Query(array_merge($args, $params));
        return ($products->have_posts()) ? $products : false;
    }

    /**
     *
     * Render content for display
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        $page = $_GET['page_num'] ?? false;
        $current_page = ($page == 0) ? 1 : $page;
        $args = [];
        if ($settings['show_pagination'] === 'yes') {
            $args['paged'] = $current_page;
        }

        if (!\ahura\app\woocommerce::is_active()) {
            if(is_admin()) {
                ?>
                <div class="productcategorybox mw_elem_empty_box"><h3><?php _e('To use this element you must install woocommerce plugin.', 'ahura'); ?></h3></div>
                <?php
            }
            return false;
        }

        $products = $this->get_products($args);

        $layout_col = $settings['layout_col'];
        $tablet_layout_col = isset($settings['layout_col_tablet']) ? $settings['layout_col_tablet'] : null;
        $mobile_layout_col = isset($settings['layout_col_mobile']) ? $settings['layout_col_mobile'] : null;
        $cls = sprintf('col-%s col-sm-12 col-md-%s col-xs-12 col-lg-%s', (!empty($mobile_layout_col) ? $mobile_layout_col : 12), (!empty($tablet_layout_col) ? $tablet_layout_col : 4), $layout_col);
        if ($products) : ?>
            <div class="grid-products grid-products-<?php echo $wid ?>">
                <div class="products-list">
                    <div class="row">
                        <?php
                        while ($products->have_posts()) :
                            $products->the_post();
                            global $product;
                        ?>
                            <div class="<?php echo $cls . ' ' . esc_attr($settings['item_entrance_animation']) ?>">
                                <article <?php wc_product_class('', $product) ?>>
                                    <div class="product-cover">
                                        <?php if ($settings['show_badge'] === 'yes') : ?>
                                            <div class="product-label">
                                                <?php
                                                if ($this->is_new_product()) :
                                                    echo '<span class="new">' . esc_html__('New', 'ahura') . '</span>';
                                                endif;
                                                if (!$product->is_in_stock()) :
                                                    echo apply_filters('woocommerce_product_is_in_stock', '<span class="soldout">' . esc_html__('Sold Out!', 'ahura') . '</span>', $product, $product);
                                                elseif ($product->is_on_sale()) :
                                                    echo apply_filters('woocommerce_sale_flash', '<span class="sale">' . esc_html__('On Sale', 'ahura') . '</span>', $product, $product);
                                                endif;
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo wp_get_attachment_image(get_post_thumbnail_id(), $settings['item_cover_size_size']); ?>
                                        </a>
                                    </div>
                                    <?php if ($settings['show_title'] === 'yes') : ?>
                                        <div class="title-wrap">
                                            <a href="<?php echo get_the_permalink() ?>">
                                                <<?php echo $settings['title_html_tag'] ?>>
                                                    <?php the_title(); ?>
                                                </<?php echo $settings['title_html_tag'] ?>>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($settings['show_price'] === 'yes') : ?>
                                        <div class="price-wrap">
                                            <?php woocommerce_template_single_price(); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($settings['show_cart_button'] === 'yes') : ?>
                                        <div class="product-foot">
                                            <a href="<?php the_permalink() ?>?add-to-cart=<?php the_ID() ?>" class="mw_add_to_cart">
                                                <?php echo __('Buy', 'ahura') ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </article>
                            </div>
                        <?php
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <?php if ($settings['show_pagination'] === 'yes') : ?>
                    <div class="ahura-pagination">
                        <?php ahura_custom_pagination($products->found_posts, $settings['per_page'], $current_page); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="mw_element_error">
                <?php echo esc_html__('Sorry, no products were found for display.', 'ahura'); ?>
            </div>
<?php
        endif;
    }
}
