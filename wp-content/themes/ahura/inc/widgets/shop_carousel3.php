<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;
class shop_carousel3 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\WoocommerceMethods;

    /**
     * shop_carousel3 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('shop_carousel3_css', mw_assets::get_css('elementor.shop_carousel3'));
        mw_assets::register_script('shop_carousel3_js', mw_assets::get_js('elementor.shop_carousel3'));

        if(!is_rtl()){
            mw_assets::register_style('shop_carousel3_ltr_css', mw_assets::get_css('elementor.ltr.shop_carousel3_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('shop_carousel3_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('shop_carousel3_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('shop_carousel3_js')];
    }

    public function get_name()
    {
        return 'shop_carousel3';
    }

    public function get_title()
    {
        return esc_html__('Shop Carousel 3', 'ahura');
    }

	public function get_icon() {
		return 'aicon-svg-grid-products';
	}

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['shop_carousel3', 'shopcarousel3', __('Shop Carousel 3', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => get_bloginfo('name'),
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_special_title',
            [
                'label' => esc_html__('Special Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Exciting offers', 'ahura'),
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $options = [];

        $products = $this->get_products_array();

        if($products){
            foreach($products as $product) {
                $options[$product['ID']] = $product['post_title'];
            }
        }

        $default = ($options) ? key($options) : 0;

        $repeater->add_control(
            'pid',
            [
                'label' => esc_html__('Product', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => $options,
                'default' => $default
            ]
        );

        $defaults = [['pid' => $default]];

        if(is_array($options) && count($options) > 0){
            $keys = array_keys($options);
            if(isset($keys[1])){
                $defaults[] = ['pid' => $keys[1]];
            }
            if(isset($keys[2])){
                $defaults[] = ['pid' => $keys[2]];
            }
        }

        $this->add_control(
            'products',
            [
                'label' => esc_html__('Products', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $defaults,
                'title_field' => '{{{pid}}}'
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'content_settings',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_box_title',
            [
                'label' => esc_html__('Box Title', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label' => esc_html__('Transition Duration', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3000,
            ]
        );

        $this->end_controls_section();

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

        $this->start_controls_section(
            'products_style',
            [
                'label' => esc_html__('Products', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'items_cover_width',
            [
                'label' => esc_html__('Cover Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
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
                // 'selectors' => [
                //     '{{WRAPPER}} .shop-carousel3 .carousel-cover img' => 'width: {{SIZE}}{{UNIT}}',
                // ]
            ]
        );
        
		$this->add_responsive_control(
            'items_cover_height',
            [
                'label' => esc_html__('Cover Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
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
                // 'selectors' => [
                //     '{{WRAPPER}} .shop-carousel3 .carousel-cover img' => 'height: {{SIZE}}{{UNIT}}',
                // ]
            ]
        );

        $this->add_control(
            'divider_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3 .carousel-details .carousel-item-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-details .carousel-item-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'divider_price1',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_price_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4caf50',
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3 .price-wrap .price > span > bdi' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .shop-carousel3 .price-wrap .price ins span bdi' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price_typography',
                'selector' => '{{WRAPPER}} .shop-carousel3 .price-wrap .price > span > bdi, {{WRAPPER}} .shop-carousel3 .price-wrap .price ins span bdi',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'divider_price_dis',
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
                    '{{WRAPPER}} .shop-carousel3 .price-wrap .price del' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price_dis_typography',
                'selector' => '{{WRAPPER}} .shop-carousel3 .price-wrap .price del',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 300],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'divider_buttons',
            [
                'label' => esc_html__('Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('style_tabs');
		$this->start_controls_tab(
			'buttons_style_normal_tab',
			[
				'label' => esc_html__('Normal', 'ahura'),
			]
		);

        $this->add_control(
            'items_btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00b0ff',
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'items_btn_bg',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'items_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart',
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
                    'color' => ['default' => '#00b0ff']
                ]
            ]
        );

        $this->add_control(
            'items_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart',
            ]
        );

        $this->end_controls_tab();
		$this->start_controls_tab(
			'buttons_style_hover_tab',
			[
				'label' => esc_html__('Hover', 'ahura'),
			]
		);

        $this->add_control(
            'items_btn_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'items_btn_bg_hover',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart:hover',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#00b0ff']
                ]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'items_btn_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart:hover',
            ]
        );

        $this->add_control(
            'items_btn_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_btn_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-details .mw_add_to_cart:hover',
            ]
        );

        $this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * 
         * 
         * Styles
         * 
         * 
         */
        $this->start_controls_section(
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('items_style_tabs');

		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__('Normal', 'ahura'),
			]
		);

        $this->add_control(
            'items_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .carousel-items .carousel-item' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'items_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .carousel-items .carousel-item' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'items_bg',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .carousel-items .carousel-item',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#f0f0f0']
                ]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'items_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .carousel-items .carousel-item',
            ]
        );

        $this->add_control(
            'items_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .carousel-items .carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'items_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .carousel-items .carousel-item',
            ]
        );

        $this->end_controls_tab();
		$this->start_controls_tab(
			'style_active_tab',
			[
				'label' => esc_html__('Active', 'ahura'),
			]
		);

        $this->add_control(
            'items_color_active',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .carousel-items .carousel-item.active' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'items_bg_active',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .carousel-items .carousel-item.active',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_box_shadow_active',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .carousel-items .carousel-item.active',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'inner'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 4,
                            'vertical' => 0,
                            'blur' => 0,
                            'spread' => 0,
                            'color' => '#00b0ff'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_tab();
		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__('Hover', 'ahura'),
			]
		);

        $this->add_control(
            'items_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carousel-items .carousel-item:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'items_bg_hover',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .carousel-items .carousel-item:hover',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .carousel-items .carousel-item:hover',
            ]
        );
        
        $this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'box_wrap_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3 .carousel-box-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_special_title_color',
            [
                'label' => esc_html__('Special Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00b0ff',
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3 .carousel-box-title strong' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_wrap_title_bg',
				'label' => esc_html__('Title Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-box-title',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#f0f0f0']
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'box_wrap_title_typography',
                'selector' => '{{WRAPPER}} .shop-carousel3 .carousel-box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16',
                        ]
                    ],
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_wrap_bg',
				'label' => esc_html__('Box Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .shop-carousel3',
			]
		);

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_wrap_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .shop-carousel3',
            ]
        );

        $this->end_controls_section();
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
        $duration = isset($settings['transition_duration']) && intval($settings['transition_duration']) ? $settings['transition_duration'] : 3000;

        if($settings['products']){
            $ids = array_map(function($p){
                return $p['pid'];
            }, $settings['products']);
        } else {
            $ids = [0];
        }

        if(!\ahura\app\woocommerce::is_active()){
            return false;
        }

        $products = $settings['products'] ? $this->get_products(['post__in' => $ids]) : false;
        ?>
        <div class="shop-carousel3 ahura-items-carousel shop-carousel3-<?php echo $wid ?><?php echo $settings['show_box_title'] == 'yes' ? ' has-box-title' : '' ?>">
            <?php if($settings['show_box_title'] == 'yes'): ?>    
                <div class="carousel-box-title">
                    <span><?php echo $settings['box_title'] ?></span>
                    <strong><?php echo $settings['box_special_title'] ?></strong>
                </div>
            <?php endif; ?>
            <div class="row m-0">
                <div class="col-12 col-sm-12 col-md-8 col-lg-8 p-0 d-flex align-items-center rounded position-relative overflow-hidden">
                    <div class="carousel-contents align-items-center">
                        <?php 
                        if($products):
                            $i = 0;
                            while ($products->have_posts()): $products->the_post();
                            global $product;
                            $percent = $this->get_product_sale_percent();
                            ?>
                            <div class="carousel-content carousel-content-<?php echo $wid . '-' . md5(get_the_ID()); ?> <?php echo $i == 0 ? ' show' : '' ?>">
                                <?php if($product->is_on_sale() && $percent): ?>
                                    <span class="carousel-badge"><span><?php echo sprintf(esc_html__('%s Discount', 'ahura'), $percent . '%'); ?></span></span>
                                <?php endif; ?>
                                <div class="row m-0 p-0 align-items-center">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="carousel-cover">
                                            <?php echo wp_get_attachment_image(get_post_thumbnail_id(), [$settings['items_cover_width']['size'], $settings['items_cover_height']['size']]); ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                        <div class="carousel-details">
                                            <h3 class="carousel-item-title"><?php the_title() ?></h3>
                                            <div class="price-wrap">
                                                <?php woocommerce_template_single_price(); ?>
                                                <?php if($product->is_on_sale() && $percent): ?>
                                                    <span class="price-discounted"><?php echo $percent . '%' ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="add-to-cart-wrap">
                                                <a href="<?php the_permalink() ?>?add-to-cart=<?php the_ID() ?>" class="mw_add_to_cart">
                                                    <?php echo __('Buy Product', 'ahura') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $i++;
                            endwhile;
                            wp_reset_query();
                        endif;
                        ?>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 d-flex align-items-center">
                    <div class="carousel-items">
                        <?php 
                        if($products):
                            $i = 0;
                            while ($products->have_posts()): $products->the_post(); ?>
                            <div class="carousel-item <?php echo $i == 0 ? 'active' : '' ?>" data-content="<?php echo $wid . '-' . md5(get_the_ID()); ?>">
                                <?php the_title() ?>
                            </div>
                            <?php 
                            $i++;
                            endwhile;
                            wp_reset_query();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    handleShopCarousel3Element({
                        widgetID: '<?php echo $wid ?>',
                        duration: <?php echo $duration ?>,
                    });
                });
            </script>
        </div>
        <?php
    }
}