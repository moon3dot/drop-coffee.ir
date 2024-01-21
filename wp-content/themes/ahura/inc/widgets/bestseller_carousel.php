<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\woocommerce;
use ahura\app\mw_assets;
use Elementor\Controls_Manager;


class bestseller_carousel extends \Elementor\Widget_Base {

	function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('bestseller_carousel_css', mw_assets::get_css('elementor.bestseller_carousel'));
    }
    
	function get_style_depends()
    {
        return [mw_assets::get_handle_name('bestseller_carousel_css')];
    }

	public function get_name() {
		return 'bestsellercarousel';
	}

	public function get_title() {
		return __( 'Best Seller Products', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-best-seller-carousel';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['best_seller_carousel', 'bestseller_carousel', 'bestsellercarousel', esc_html__('Best Seller Products', 'ahura')];
	}

	public function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'count',
			[
				'label'      => __( 'Number of products', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 8
			]
		);

		$this->add_control(
			'stockstatus',
			[
				'label'   => __( 'Exclude outofstock products', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
					'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-close' ]
				],
				'default' => 'yes'
			]
		);

		$this->add_control(
			'price',
			[
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
			'show_img',
			[
				'label' => __( 'Show Image', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-close' ]
				],
				'default' => 'yes',
			]
		);

        $this->add_control(
			'desktop_column',
			[
				'label' => esc_html__( 'Desktop column', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'12' => esc_html__( '1', 'ahura' ),
					'6' => esc_html__( '2', 'ahura' ),
					'4' => esc_html__( '3', 'ahura' ),
					'3' => esc_html__( '4', 'ahura' ),
					'2' => esc_html__( '6', 'ahura' ),
				],
			]
		);

        $this->add_control(
			'mobile_column',
			[
				'label' => esc_html__( 'Mobile column', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '6',
				'options' => [
					'12' => esc_html__( '1', 'ahura' ),
					'6' => esc_html__( '2', 'ahura' ),
					'4' => esc_html__( '3', 'ahura' ),
					'3' => esc_html__( '4', 'ahura' ),
					'2' => esc_html__( '6', 'ahura' ),
				],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'cover_styles',
            [
                'label' => __( 'Cover', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                        'show_img' => 'yes'
                ]
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
                'condition' => [
                    'price' => 'yes'
                ]
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
                'condition' => [
                    'price' => 'yes'
                ]
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
                'condition' => [
                    'price' => 'yes'
                ]
            ]
        );

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
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        $settings['stockstatus'] == 'yes' ? $stock_status_arr = [['key' => '_stock_status', 'value' => 'instock']] : $stock_status_arr = [];

		if ( class_exists( 'WooCommerce' ) ) {
			$wc_query = new \WP_Query( [
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => $settings['count'],
                'ignore_sticky_posts' => true,
                'meta_key'   => 'total_sales',
                'orderby'    => 'meta_value_num',
                'order'      => 'DESC',
                'meta_query' => $stock_status_arr
			] );
			if ( $wc_query->have_posts() ) : ?>
                <div class="ahura-element-bestseller-carousel">
                    <div class="row">
                        <?php while ( $wc_query->have_posts() ) : $wc_query->the_post(); ?>
                            <div class="col-<?php echo $settings['mobile_column'] ?> col-md-4 col-lg-<?php echo $settings['desktop_column'] ?>">
                                <div class="p-item">
                                    <?php if ( $settings['show_img'] === 'yes' ): ?>
                                        <a class="fimage" href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <h3><?php echo wp_trim_words( get_the_title(), 6, '...' ); ?></h3>
                                    </a>
                                    <?php if ( $settings['price'] == 'yes' ) : ?>
                                        <div class="mwprprice">
                                            <?php echo woocommerce_template_single_price(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
				<?php wp_reset_postdata(); ?>
			<?php else: ?>
					<div class="mw_element_error">
						<?php echo __( 'Nothing found. Edit the page with Elementor and select a category for this section.','ahura' );?>
					</div>
			<?php endif; ?>
            <div class="clear"></div>
			<?php
		} elseif( is_admin() ) {
			?>
			<div class="productcategorybox mw_elem_empty_box"><h3><?php _e( 'To use this element you must install woocommerce plugin.', 'ahura' ); ?></h3></div>
			<?php
		}
	}

}
