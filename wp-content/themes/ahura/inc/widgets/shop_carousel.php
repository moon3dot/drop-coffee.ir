<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\woocommerce;
use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class shop_carousel extends \Elementor\Widget_Base {
    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
		mw_assets::register_style('owl_carousel_css', mw_assets::get_css('owl-carousel'));
        mw_assets::register_style('shop_carousel_css', mw_assets::get_css('elementor.shop_carousel'));

        mw_assets::register_script('owl_carousel_js', mw_assets::get_js('owl-carousel-min'));
        mw_assets::register_script('shop_carousel_js', mw_assets::get_js('elementor.shop_carousel'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('owl_carousel_css'), mw_assets::get_handle_name('shop_carousel_css')];
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('owl_carousel_js'), mw_assets::get_handle_name('shop_carousel_js')];
    }

	public function get_name() {
		return 'shopcarousel';
	}

	public function get_title() {
		return __( 'Products Carousel', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-shop-carousel';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['shopcarousel', 'productscarousel', 'products_carousel', 'shop_carousel', esc_html__( 'Products Carousel' , 'ahura')];
	}

	protected function register_controls() {
		if(!woocommerce::is_active())
		{
			return false;
		}
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$categories = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		));
		$cats       = array();
		foreach ( $categories as $category ) {
			$cats[ $category->slug ] = $category->name;
		}
		$default = key($cats);
		$this->add_control(
			'catsid',
			[
				'label'    => __( 'Categories', 'ahura' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => array_merge(
					[ 'allproducts'  => esc_html__( 'All Products', 'ahura' ) ],
					[ 'discountedproducts'  => esc_html__( 'Discounted Products', 'ahura' ) ],
					[ 'randomproducts'  => esc_html__( 'Random Products', 'ahura' ) ],
					$cats ),
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
            'fully_show_title',
            [
                'label'   => __( 'Fully Show Title', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'no'
            ]
        );

		$this->add_control(
			'price',
			[
				'label'   => __( 'Show Price', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
					'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
				],
				'default' => 'yes'
			]
		);

		$this->add_control(
			'count',
			[
				'label'      => __( 'Number of posts', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 8
			]
		);

		$this->add_control(
			'product_order',
			[
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
			'outofstock_text',
			[
				'label' => __( 'Out of stock text', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'out of stock', 'ahura' ),
			]
		);

		$this->add_control(
			'stock_status',
			[
				'label'   => __( 'Show product stock status', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
					'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
				],
				'default' => 'yes'
			]
		);

		$this->add_control(
			'sale_price_product',
			[
				'label'   => __( 'Show only discounted products', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					null  => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
					'no' => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
				],
				'default' => 'no',
				'condition' => [
					'catsid!' => 'discountedproducts',
				],
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
            'item_section',
            [
                'label' => __( 'Item', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title Typography', 'ahura'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .owl-item h3',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '16',
                            ]
                        ],
                        'font_weight' => [
                            'default' => '400'
                        ],
                    ],
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Price Typography', 'ahura'),
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .mwprprice .price span',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '17',
                            ]
                        ],
                        'font_weight' => [
                            'default' => '400'
                        ],
                    ],
            ]
        );

		// start tabs
		$this->start_controls_tabs(
			'item_style_tabs',
		);

		// start normal tab
		$this->start_controls_tab(
			'item_style_normal_tab',
			[
				'label' => __('Normal', 'ahura')
			]
		);
		$this->add_control(
            'item_style_normal_mode_heading',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
		$this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#555',
                'selectors' => [
                    '{{WRAPPER}} .owl-item h3' => 'color: {{VALUE}}',
                ],
            ]
        );
		
        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#555',
                'selectors' => [
                    '{{WRAPPER}} .mwprprice .price span' => 'color: {{VALUE}}',
                ],
            ]
        );

		// border line color
		$this->add_control(
            'border_line_color',
            [
                'label' => esc_html__('Border line color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00000014',
                'selectors' => [
                    '{{WRAPPER}} .owl-item h3' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .owl-item',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#fff'
                            ],
                    ]
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .owl-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'name' => 'post_item_box_shadow',
				'selector' => '{{WRAPPER}} .owl-item',
				'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
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
		// hover => 0 10px 30px rgba(40, 46, 54, 0.2)

		$this->end_controls_tab();

		// start hover tab
		$this->start_controls_tab(
			'item_style_hover_tab',
			[
				'label' => __('Hover', 'ahura')
			]
		);
		$this->add_control(
            'item_style_hover_mode_heading',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#555',
                'selectors' => [
                    '{{WRAPPER}} .owl-item:hover h3' => 'color: {{VALUE}}',
                ],
            ]
        );
		
        $this->add_control(
            'price_color_hover',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#555',
                'selectors' => [
                    '{{WRAPPER}} .owl-item:hover .mwprprice .price span' => 'color: {{VALUE}}',
                ],
            ]
        );

		// border line color
		$this->add_control(
            'border_line_color_hover',
            [
                'label' => esc_html__('Border line color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00000014',
                'selectors' => [
                    '{{WRAPPER}} .owl-item:hover h3' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_bg_hover',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .owl-item:hover',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#fff'
                            ],
                    ]
            ]
        );

        $this->add_control(
            'item_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .owl-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'name' => 'post_item_box_shadow_hover',
				'selector' => '{{WRAPPER}} .owl-item:hover',
				'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 10,
                            'blur' => 30,
                            'spread' => 0,
                            'color' => 'rgba(40, 46, 54, 0.2)'
                        ]
                    ]
                ]
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

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
			'style_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'outofstock_color',
			[
				'label' => esc_html__( 'Of of stock color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'white',
				'selectors' => [
					'{{WRAPPER}} .out-of-stock' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'outofstock_background_color',
			[
				'label' => esc_html__( 'Of of stock background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'red',
				'selectors' => [
					'{{WRAPPER}} .out-of-stock' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        $has_price = isset($settings['price']) && $settings['price'] == 'yes';

		if ( class_exists( 'WooCommerce' ) ) {
			$field_is_term = (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);

			if( ( $settings[ 'catsid' ][ 0 ] == 'allproducts' ) || $settings[ 'catsid' ][ 0 ] == 'randomproducts' ) {
				$args = [
					'post_type'		 => 'product',
					'post_status'	 => 'publish',
					'posts_per_page' => $settings[ 'count' ],
					'order' 		 => $settings[ 'product_order' ],
					'orderby' 		 => $settings[ 'catsid' ][ 0 ] == 'randomproducts' ? 'rand' : $settings[ 'product_order' ]
				];
			} elseif( $settings[ 'catsid' ][ 0 ] == 'discountedproducts' ) {
				$args = [
					'post_type'		 => 'product',
					'post_status'	 => 'publish',
					'posts_per_page' => $settings[ 'count' ],
					'order' 		 => $settings[ 'product_order' ],
					'meta_key' 		 => '_sale_price',
					'meta_value' 	 => '0',
					'meta_compare'   => '>='
				];
			} else {
				$args = [
					'post_type'		 => 'product',
					'post_status'	 => 'publish',
					'posts_per_page' => $settings[ 'count' ],
					'tax_query'		 => [ [
						'taxonomy'   => 'product_cat',
						'field'		 => $field_is_term ? 'term_id' : 'slug',
						'terms'		 => $settings[ 'catsid' ],
					] ],
					'order' 		 => $settings[ 'product_order' ]
				];
			}

            $products_stock_status = $settings['products_stock_status'];

            if ($products_stock_status && $products_stock_status !== 'none') {
                $args['meta_query'] = array(array(
                    'key' => '_stock_status',
                    'value' => $products_stock_status,
                    'compare' => '==',
                ));
            }

			$wc_query = new \WP_Query($args);
			if ( $wc_query->have_posts() ) : ?>
                <div class="shop-carousel-element <?php echo !$has_price ? 'without-price' : '' ?>">
                    <div class="owl-carousel owl-theme owl-shop-carousel">
                        <?php while ( $wc_query->have_posts() ) : $wc_query->the_post(); ?>
                            <?php if (get_post_meta(get_the_ID(), '_sale_price', true) != $settings['sale_price_product'] ): ?>
                                <div class="sc-item-content">
                                    <div class="sc-items-top">
                                    <a class="fimage" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?></a>
                                    <a href="<?php the_permalink(); ?>">
                                        <h3><?php echo $settings['fully_show_title'] == 'yes' ? get_the_title() : wp_trim_words( get_the_title(), 6, '...' ); ?></h3></a>
                                    </div>
                                    <div class="sc-items-bottom">
                                    <?php if ( $has_price ) : ?>
                                        <div class="mwprprice">
                                            <?php echo woocommerce_template_single_price(); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                        if ( ( $settings['stock_status'] == 'yes' && wc_get_product( get_the_ID() )->get_stock_status() == "outofstock" ) ) {
                                        echo '<p class="out-of-stock">'.$settings['outofstock_text'].'</p>';
                                        }
                                    ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                </div>
                <?php endif; ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        handleShopCarouselElement({
                            loop: true,
                            autoplay: <?php echo $settings['autoplay'] == 'yes' ? 'true' : 'false' ?>,
                            autoplayTimeout: <?php echo $settings['autoplay_delay'] ? $settings['autoplay_delay'] : 0; ?>,
                        });
                    });
                </script>
                <div class="clear"></div>
			<?php
		} elseif(is_admin()) {
			?>
			<div class="productcategorybox mw_elem_empty_box"><h3><?php _e('To use this element you must install woocommerce plugin.', 'ahura'); ?></h3></div>
			<?php
		}
	}
}
