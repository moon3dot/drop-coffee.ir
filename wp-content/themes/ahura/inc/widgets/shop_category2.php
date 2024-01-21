<?php
namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

class shop_category2 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'shop_category2';
	}

	public function get_title() {
		return __( 'Shop Category 2', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-shop-category-2';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['shop_category2', 'shopcategory2', esc_html__( 'Shop Category 2' , 'ahura')];
	}

	public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

		mw_assets::register_style('shop_category3_widget_style', mw_assets::get_css('elementor.shop_category3'));
    }
  
    public function get_style_depends() {
        return [ mw_assets::get_handle_name('shop_category3_widget_style') ];
    }

	protected function register_controls() {
        if (!woocommerce::is_active()) return false;

		$this->start_controls_section(
			'content_section', [
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$categories = get_terms( [
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		] );
		$cats = [];
		if($categories){
            foreach ( $categories as $category ) {
                $cats[ $category->slug ] = $category->name;
            }
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

		$this->add_control(
			'count', [
				'label'      => __( 'Number of posts', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 8
			]
		);

        $this->add_control(
            'el_style',
            [
                'label' => esc_html__( 'Element Style', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'style-1 mb-2',
                'options' => [
                    'style-1 mb-2'  => esc_html__( 'Style 1', 'ahura' ),
                    'style-2' => esc_html__( 'Style 2', 'ahura' ),
                ],
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
                    '{{WRAPPER}} .fimage img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'el_column',
            [
                'label' => esc_html__( 'Product column', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'col-md-6',
                'options' => [
                    'col-md-12'  => esc_html__( 'Full width', 'ahura' ),
                    'col-md-6' => esc_html__( '2 Column', 'ahura' ),
                    'col-md-4' => esc_html__( '3 Column', 'ahura' ),
                ],
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__( 'Show Excerpt', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'no',
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
                'selector' => '{{WRAPPER}} .fimage img',
            ]
        );

        $this->add_responsive_control(
			'item_img_border_radius',
			[
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .fimage img' => 'border-radius: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .fimage' => 'margin-left: {{SIZE}}{{UNIT}}'
                ]
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
            'main_color', [
                'label'   => __( 'Main color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#66bb6a',
                'selectors' => [
                    '{{WRAPPER}} .cat-box form button' => 'background-color: {{VALUE}};box-shadow: 0px 0px 10px {{VALUE}}',
                    '{{WRAPPER}} .cat-box .mw_qty_btn i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control('div1', ['type' => \Elementor\Controls_Manager::DIVIDER]);

        $this->add_control(
            'title_color', [
                'label'   => __( 'Title color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .cat-box .title' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label'    => __( 'Product title typography', 'ahura' ),
				'selector' => '{{WRAPPER}} .cat-box .title',
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_size' => ['default' => ['size' => 20]],
				],
			]
		);

        $this->add_control(
            'des_color', [
                'label'   => __( 'Description color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#636363',
                'selectors' => [
                    '{{WRAPPER}} .cat-box .description' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_excerpt' => 'yes'
                ]
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label'    => __( 'Product description typography', 'ahura' ),
				'selector' => '{{WRAPPER}} .cat-box .description',
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_size' => ['default' => ['size' => 14]],
				],
                'condition' => [
                        'show_excerpt' => 'yes'
                ]
			]
		);

		$this->add_control(
			'price_color', [
				'label'   => __( 'Price color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#66bb6a',
				'selectors' => [
					'{{WRAPPER}} .cat-box .price' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(), [
				'name' => 'price_typography',
				'label'    => __( 'Price typography', 'ahura' ),
				'selector' => '{{WRAPPER}} .cat-box .price',
				'fields_options' => [
					'typography' => ['default' => 'yes'],
					'font_size' => ['default' => ['size' => 18]],
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .cat-box',
                'condition' => [
                        'el_style' => 'style-1 mb-2'
                ]
            ]
        );

		$this->end_controls_section();
        $this->start_controls_section(
            'btn_styles', [
                'label' => __( 'Button', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btn_text_color', [
                'label'   => __( 'Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .cat-box form button' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .cat-box form button',
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .cat-box form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
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
                'name' => 'btn_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .cat-box form button',
            ]
        );

        $this->end_controls_section();
	}
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( class_exists( 'WooCommerce' ) ) {
			$field_is_term = (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);
			$wc_query = new \WP_Query( [
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => $settings['count'],
				'tax_query' => [ [
					'taxonomy' => 'product_cat',
					'field' => $field_is_term ? 'term_id' : 'slug',
					'terms' => $settings['catsid'],
				] ]
			] );
			if ( $wc_query->have_posts() ) : ?>
                <div class="shop_category3 d-flex flex-wrap shop_quantity_selector">
					<?php while ( $wc_query->have_posts() ) : $wc_query->the_post(); ?>
						<div class="outer-box col-sm-12 <?php echo $settings['el_column']; ?> px-0">
							<div class="d-flex cat-box <?php echo $settings['el_style']; ?> mr-2">
								<a class="d-flex flex-column justify-content-center p-1 fimage" href="<?php the_permalink(); ?>">
                                    <?php echo wp_get_attachment_image(get_post_thumbnail_id(), $settings['item_cover_size_size']); ?>
                                </a>
								<div class="d-flex flex-column justify-content-center w-100 cat_content pl-3">
									<a href="<?php the_permalink(); ?>">
										<p class="title"><?php echo wp_trim_words( get_the_title(), 8, '...' ); ?></p>
									</a>
                                    <?php if ($settings['show_excerpt'] === 'yes'): ?>
									    <span class="description"><?php echo the_excerpt(); ?></span>
                                    <?php endif; ?>
									<?php echo woocommerce_template_single_price(); ?>
									<?php
										$current_product = wc_get_product( get_the_ID() );
                                        $show_qty = $settings['show_qty'] === 'yes';

                                        \ahura\app\woocommerce::add_to_cart_button_with_quantity([
                                            'product' => $current_product,
                                            'with_qty' => $show_qty,
                                            'has_button_icon' => true,
                                            'button_text' => __('Order', 'ahura'),
                                            'class' => (!$show_qty ? 'wqty' : ''),
                                        ]);

                                        if ( ( $settings['stock_status'] == 'yes' && $current_product -> get_stock_status() == "outofstock" ) ) {
											echo '<p class="out-of-stock">'.$settings['outofstock_text'].'</p>';
										}
									?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
                </div>
				<?php wp_reset_postdata(); ?>
			<?php else: ?>
					<div class="mw_element_error">
						<?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
					</div>
			<?php endif; ?>
            <div class="clear"></div>
			<?php
		}elseif(is_admin()){
			?>
			<div class="mw_element_error"><?php _e('To use this element you must install woocommerce plugin.', 'ahura'); ?></div>
			<?php
		}
	}
}
