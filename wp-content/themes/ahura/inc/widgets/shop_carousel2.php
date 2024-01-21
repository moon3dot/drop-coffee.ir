<?php

namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;


class shop_carousel2 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'shop_carousel2';
	}

	public function get_title() {
		return __( 'Products Carousel 2', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-shop-carousel-2';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}

	function get_keywords()
	{
		return ['shop_carousel2', 'shopcarousel2', 'productscarousel2', 'products_carousel_2', esc_html__( 'Products Carousel 2' , 'ahura')];
	}
	
	public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
		mw_assets::register_style('owl_carousel_css', mw_assets::get_css('owl-carousel'));
        mw_assets::register_script('owl_carousel_js', mw_assets::get_js('owl-carousel-min'));
		mw_assets::register_style('shop_carousel2_widget_style', mw_assets::get_css('elementor.shop_carousel2'));
		mw_assets::register_script('shop_carousel2_widget_script', mw_assets::get_js('elementor.shop_carousel2'), [ 'elementor-frontend' ]);
		woocommerce::enqueue_woocommerce_js();
    }
  
    public function get_style_depends() {
        return [ mw_assets::get_handle_name('shop_carousel2_widget_style'), mw_assets::get_handle_name('owl_carousel_css') ];
    }
  
    public function get_script_depends() {
        return ['mw_woocommerce', mw_assets::get_handle_name('owl_carousel_js'), mw_assets::get_handle_name('shop_carousel2_widget_script')];
    }

	protected function register_controls() {
        if (!\ahura\app\woocommerce::is_active())
            return false;

		$this->start_controls_section(
			'content_section', [
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => __( 'Title text', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Fruits', 'ahura' ),
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Button text', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'All products', 'ahura' ),
			]
		);

		$this->add_control(
            'btn_url',
            [
                'label'      => __('Url', 'ahura'),
                'type'       => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#',
                ],
            ]
        );
		
		$categories = get_terms( [
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		] );
		$cats = [];
		foreach ( $categories as $category ) {
			$cats[ $category->slug ] = $category->name;
		}
		$default = key($cats);
		$this->add_control(
			'catsid', [
				'label'    => __( 'Categories', 'ahura' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => $cats,
				'label_block' => true,
				'multiple' => true,
				'default' => $default
			]
		);

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
					null  => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
					'no' => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-close' ]
				],
				'default' => 'no'
			]
		);

		$this->add_control(
			'count', [
				'label'      => __( 'Number of posts', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 8
			]
		);

		$this->add_control(
			'product_order', [
				'label' => __('Sort', 'ahura'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'DESC',
				'options' => [
					'ASC' => [
						'title' => __('Ascending', 'ahura'),
						'icon' => 'eicon-sort-up'
					],
					'DESC' => [
						'title' => __('Descending', 'ahura'),
						'icon' => 'eicon-sort-down'
					],
				],
				'toggle' => true
			]
		);

        $this->add_control(
            'show_slider_btn',
            [
                'label' => esc_html__('Slider Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .owl-carousel .owl-nav' => 'display:block;'
                ]
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'product_section', [
                'label' => __( 'Product', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_subtitle',
            [
                'label' => esc_html__( 'Show Subtitle', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'subtitle_text',
            [
                'label' => __( 'Subtitle text', 'ahura' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Price for 1 kg', 'ahura' ),
                'condition' => [
                        'show_subtitle' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'price', [
                'label'   => __( 'Show Price', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-close' ]
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_qty',
            [
                'label' => esc_html__( 'Choose Quantity', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'stock_status',
            [
                'label'   => __( 'Show product stock status', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-close' ]
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'outofstock_text',
            [
                'label' => __( 'Out of stock text', 'ahura' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'out of stock', 'ahura' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_section',
            [
                'label' => __( 'Slider', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'autoplay_delay',
			[
				'label' => esc_html__( 'Autoplay delay', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 10000,
				'step' => 1,
				'default' => 2500,
                'condition' => ['autoplay' => 'yes']
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'item_styles', [
                'label' => __( 'Item', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_title_color', [
                'label'   => __( 'Title Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-item h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .owl-item h3'
            ]
        );

        $this->add_control(
            'item_price_color', [
                'label'   => __( 'Price Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-item .price span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .owl-item .mwprprice .price, {{WRAPPER}} .owl-item .price span'
            ]
        );

        $this->add_control(
            'item_meta_color', [
                'label'   => __( 'Meta Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-item h5' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .owl-carousel .owl-item h5'
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .carousel-box',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .carousel-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'buy_btn_styles', [
                'label' => __( 'Buy Button', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_btn_color', [
                'label'   => __( 'Text Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop_carousel2 .carousel-box form button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_btn_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .shop_carousel2 .carousel-box form button',
            ]
        );

        $this->add_control(
            'item_btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .shop_carousel2 .carousel-box form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_button_style',
            [
                'label' => esc_html__('Slider button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_slider_btn' => 'yes'
                ]
            ]
        );
        // color
        $this->add_control(
            'slider_btn_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-nav i.fa' => 'color: {{VALUE}};'
                ],
                'default' => '#181522',
            ]
        );

        // bg color
        $this->add_control(
            'slider_btn_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-nav i.fa' => 'background-color: {{VALUE}};'
                ],
                'default' => '#ffffff',
            ]
        );

        // typography
        $this->add_responsive_control(
            'slider_btn_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 23,
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-nav i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'slider_next_btn_border_radius',
            [
                'label' => esc_html__( 'Next button border radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .owl-nav i.fa' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 50,
                    'bottom' => 50,
                    'right' => 50,
                    'left' => 50,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_control(
            'slider_prev_btn_border_radius',
            [
                'label' => esc_html__( 'Previous button border radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .owl-prev i.fa' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 50,
                    'bottom' => 50,
                    'right' => 50,
                    'left' => 50,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles', [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color', [
                'label'   => __( 'Primary Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#66bb6a',
                'selectors' => [
                    '{{WRAPPER}} .shop_carousel2_header a.link' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .carousel-box form button' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .owl-carousel .owl-item .price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .carousel-box .quantity input[type="number"]' => 'color: {{VALUE}} ',
                    '{{WRAPPER}} .carousel-box .mw_qty_btn i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .shop_carousel2_header .title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .shop_carousel2_header .title:before' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_title_color', [
                'label'   => __( 'Title Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .shop_carousel2 .shop_carousel2_header .title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .shop_carousel2 .shop_carousel2_header .title:before' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .shop_carousel2',
            ]
        );

        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .shop_carousel2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_padding',
            [
                'label' => esc_html__( 'Padding', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .shop_carousel2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .shop_carousel2',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => 'rgba(0,0,0, .06)'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'btn_options',
            [
                'label' => esc_html__( 'Button', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'box_btn_color', [
                'label'   => __( 'Text Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .shop_carousel2_header a.link' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_btn_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .shop_carousel2_header a.link',
            ]
        );

        $this->add_control(
            'box_btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .shop_carousel2_header a.link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
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
                'name' => 'wrap_btn_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .shop_carousel2_header a.link',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 7,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => '#49494960'
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

        if ( class_exists( 'WooCommerce' ) ) {
            $cats_id = isset($settings['catsid']) ? $settings['catsid'] : null;
			$field_is_term = (is_array($cats_id) && is_numeric($cats_id[0])) || is_int($cats_id);
            $args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => isset($settings['count']) ? $settings['count'] : 8,
                'tax_query' => [
                    [
                        'taxonomy' => 'product_cat',
                        'field' => $field_is_term ? 'term_id' : 'slug',
                        'terms' => $cats_id,
                    ]
                ],
                'order' => isset($settings['product_order']) ? $settings['product_order'] : 'DESC'
            ];

            $products_stock_status = isset($settings['products_stock_status']) ? $settings['products_stock_status'] : 'instock';

            if ($products_stock_status && $products_stock_status !== 'none') {
                $args['meta_query'] = array(array(
                    'key' => '_stock_status',
                    'value' => $products_stock_status,
                    'compare' => '==',
                ));
            }

            $wc_query = new \WP_Query($args);

			if ( $wc_query->have_posts() ) : ?>
                <div class="shop-carousel2-element shop_carousel2 shop_quantity_selector productcategorybox">
					<div class="shop_carousel2_header">
						<div class="title"><?php echo $settings['title_text'] ?></div>
						<a href="<?php echo $settings['btn_url']['url']; ?>" class="link"><?php echo $settings['btn_text'] ?></a>
					</div>
                    <div class="owl-carousel owl-shop-carousel2">
						<?php while ( $wc_query->have_posts() ) : $wc_query->the_post(); ?>
						<?php if (get_post_meta(get_the_ID(), '_sale_price', true) != $settings['sale_price_product'] ): ?>
                            <div class="carousel-box">
                                <div class="top-content">
                                    <a href="<?php the_permalink(); ?>" class="fimage">
                                        <?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?>
                                    </a>
                                    <a href="<?php the_permalink(); ?>">
                                        <h3><?php echo wp_trim_words( get_the_title(), 8, '...' ); ?></h3>
                                    </a>
                                    <?php if ( $settings['show_subtitle'] == 'yes' ) : ?>
                                        <h5><?php echo $settings['subtitle_text']; ?></h5>
                                    <?php endif; ?>
                                    <?php if ( $settings['price'] == 'yes' ) : ?>
                                        <div class="mwprprice">
                                            <?php echo woocommerce_template_single_price();	?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="bottom-content">
                                    <?php
                                    $show_qty = $settings['show_qty'] === 'yes';
                                    $current_product = wc_get_product( get_the_ID() );

                                    \ahura\app\woocommerce::add_to_cart_button_with_quantity([
                                        'product' => $current_product,
                                        'with_qty' => $show_qty,
                                        'has_button_icon' => true,
                                        'button_text' => __('Order', 'ahura'),
                                        'class' => (!$show_qty ? 'wqty' : ''),
                                    ]);
                                    ?>
                                </div>
								<?php
                                if ( ( $settings['stock_status'] == 'yes' && $current_product -> get_stock_status() == "outofstock" ) ) {
								    echo '<p class="out-of-stock">'.$settings['outofstock_text'].'</p>';
								}
								?>
                            </div>
						<?php endif; ?>
						<?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
					</div>
					<?php endif; ?>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        handleShopCarousel2Element({
                            loop: true,
                            autoplay: <?php echo $settings['autoplay'] == 'yes' ? 'true' : 'false' ?>,
                            autoplayTimeout: <?php echo $settings['autoplay_delay'] ? $settings['autoplay_delay'] : 0; ?>,
                        });
                    });
                </script>
            <div class="clear"></div>
			<?php
		}elseif(is_admin()){
			?>
			<div class="mw_element_error"><?php _e('To use this element you must install woocommerce plugin.', 'ahura'); ?></div>
			<?php
		}
	}

}
