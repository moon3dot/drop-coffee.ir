<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

class shop_category1 extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'shopcategory1';
	}

	public function get_title()
	{
		return __('Products Category 1', 'ahura');
	}

	public function get_icon()
	{
		return 'aicon-svg-shop-category-1';
	}

	public function get_categories()
	{
		return ['ahuraelements'];
	}
	function get_keywords()
	{
		return ['shop_category1', 'shopcategory1', 'productscategory1', 'products_category_1', esc_html__( 'Products Category 1' , 'ahura')];
	}
	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		$shop_category1_css = mw_assets::get_css('elementor.shop_category1');
		mw_assets::register_style('shop_category1', $shop_category1_css);
	}
	function get_style_depends()
	{
		return [mw_assets::get_handle_name('shop_category1')];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'ahura'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$categories = get_terms(array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		));

        $cats = [];
        if (\ahura\app\woocommerce::is_active()) {
            $cats       = array();
            if($categories){
                foreach ($categories as $category) {
                    $cats[$category->slug] = $category->name;
                }
            }
        }

		$default = key($cats);
		$this->add_control(
			'catsid',
			[
				'label'    => __('Categories', 'ahura'),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => $cats,
				'label_block' => true,
				'multiple' => false,
				'default' => $default
			]
		);

        $this->add_control(
            'show_box_title',
            [
                'label'   => __('Show Title', 'ahura'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => ['title' => __('Yes', 'ahura'), 'icon' => 'eicon-check'],
                    'no'  => ['title' => __('No', 'ahura'), 'icon' => 'eicon-close']
                ],
                'default' => 'yes'
            ]
        );

		$this->add_control(
			'price',
			[
				'label'   => __('Show Price', 'ahura'),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'yes' => ['title' => __('Yes', 'ahura'), 'icon' => 'eicon-check'],
					'no'  => ['title' => __('No', 'ahura'), 'icon' => 'eicon-close']
				],
				'default' => 'yes'
			]
		);

		$this->add_control(
			'count',
			[
				'label'      => __('Number of posts', 'ahura'),
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
            'cover_styles',
            [
                'label' => __( 'Cover', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'cover_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
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
                    'unit' => '%',
                    'size' => 100
                ],
                'selectors' => [
                    '{{WRAPPER}} .p-item img' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'cover_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
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
                    'size' => 260
                ],
                'selectors' => [
                    '{{WRAPPER}} .p-item img' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'cover_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .p-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'item_styles',
            [
                'label' => __( 'Item', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .p-item',
            ]
        );

        $this->add_control(
            'title-color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .p-item h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .p-item h3',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '19',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control('div1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'pro_box_price_color',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#01b369',
                'selectors' => [
                    '{{WRAPPER}} .price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price ins' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pro_box_dis_price_color',
            [
                'label' => esc_html__('Price by Discount Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#cdcdcd',
                'selectors' => [
                    '{{WRAPPER}} .price del' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Price Typography', 'ahura'),
                'name' => 'item_price_typography',
                'selector' => '{{WRAPPER}} .price, {{WRAPPER}} .price span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '17',
                        ]
                    ]
                ],
            ]
        );

        $this->add_control('div2', ['type' => Controls_Manager::DIVIDER]);

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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(), [
                'label' => esc_html__( 'Out of Stock typography', 'ahura' ),
                'name' => 'outofstock_text_typography',
                'selector' => '{{WRAPPER}} .out-of-stock',
            ]
        );

        $this->add_control('div3', ['type' => Controls_Manager::DIVIDER]);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'items_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .p-item',
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .p-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .p-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .p-item',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'box_styles',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'      => __('Border Color', 'ahura'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'default'    => '#444',
                'selectors' => [
                    '{{WRAPPER}} .mw_shop_cat_title_box b' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label'      => __('Title Color', 'ahura'),
                'type'       => \Elementor\Controls_Manager::COLOR,
                'default'    => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mw_shop_cat h2' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if (class_exists('WooCommerce')) {
			$field_is_term = (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);
			$wc_query = new \WP_Query(array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => $settings['count'],
				'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'field' => $field_is_term ? 'term_id' : 'slug',
						'terms' => $settings['catsid'],
					)
				),
				'order'         =>  $settings['product_order']
			));
			$first_cat_id = is_array($settings['catsid']) ? $settings['catsid'][0] : $settings['catsid'];
			if ($wc_query->have_posts()) : ?>
				<div class="mw_shop_cat">
                    <?php if($settings['show_box_title'] === 'yes'): ?>
					<div class="mw_shop_cat_title_box">
						<b></b>
						<h2><?php $term = get_term_by( $field_is_term ? 'id' : 'slug', $first_cat_id, 'product_cat' );echo $term->name; ?></h2>
						<b></b>
					</div>
                    <?php endif; ?>
					<?php while ($wc_query->have_posts()) : $wc_query->the_post(); ?>
						<a href="<?php the_permalink(); ?>" class="mw_shop_cat_item p-item">
							<?php if(get_post_meta(get_the_ID(), '_sale_price', true) != null) : ?>
								<div class="mw_shop_cat_item_off_over">
									<i class="fa fa-star"></i>
								</div>
							<?php endif; ?>
							<div class="mw_shop_cat_item_pic">
								<?php the_post_thumbnail('woocommerce_thumbnail'); ?>
							</div>
							<div class="mw_shop_cat_item_data">
								<h3><?php the_title(); ?></h3>
								<?php if ($settings['price'] == 'yes') : ?>
									<div class="mw_shop_cat_item_price">
										<?php
										$price = woocommerce_template_single_price(); 
										echo '<span class="mw_shop_cat_item_price">'.$price.'</span>';
										?>
									</div>
								<?php endif;
								 if (($settings['stock_status'] === 'yes' && wc_get_product(get_the_ID())-> get_stock_status() == "outofstock")) {
									echo '<p class="out-of-stock">'.$settings['outofstock_text'].'</p>';
								 }
								?>
							</div>
						</a>
					<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
				<?php else:?>
					<div class="mw_element_error">
						<?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
					</div>
			<?php endif; ?>
			<div class="clear"></div>
<?php
		}
	}
}
