<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_tools;
use ahura\app\traits\WoocommerceMethods;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;

class grid_products3 extends \Elementor\Widget_Base {
    use WoocommerceMethods;

    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_products3_css', mw_assets::get_css('elementor.grid_products3'));
        if(!is_rtl()){
            mw_assets::register_style('grid_products3_ltr_css', mw_assets::get_css('elementor.ltr.grid_products3_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_products3_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('grid_products3_ltr_css');
        }
        return $styles;
    }

    public function get_name() {
        return 'grid_products3';
    }

    public function get_title() {
        return __( 'Grid Products 3', 'ahura' );
    }

    public function get_icon() {
        return 'aicon-svg-grid-products';
    }

    public function get_categories() {
        return [ 'ahuraelements', 'ahura_woocommerce' ];
    }
    function get_keywords()
    {
        return ['gridproducts3', 'grid_products3', esc_html__( 'Grid Products 3' , 'ahura')];
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
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $categories = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => false ] );
        $cats = [];
        if( $categories ){
            foreach ( $categories as $category ) {
                $cats[ $category->slug ] = $category->name;
            }
        }

        $this->add_control(
            'catsid',
            [
                'label'    => __( 'Categories', 'ahura' ),
                'type'     => Controls_Manager::SELECT2,
                'options'  => array_merge(
                    [ 'allproducts'  => esc_html__( 'All Products', 'ahura' ) ],
                    [ 'discountedproducts'  => esc_html__( 'Discounted Products', 'ahura' ) ],
                    [ 'randomproducts'  => esc_html__( 'Random Products', 'ahura' ) ],
                    $cats ),
                'label_block' => true,
                'multiple' => true,
                'default' => 'allproducts'
            ]
        );

        $stock_options = (function_exists('wc_get_product_stock_status_options')) ? wc_get_product_stock_status_options() : [];

        $this->add_control(
            'products_stock_status',
            [
                'label'   => esc_html__('Stock status of products', 'ahura'),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => array_merge(['none'  => esc_html__('None', 'ahura')], $stock_options),
                'default' => 'instock'
            ]
        );

        $this->add_responsive_control(
            'layout_col',
            [
                'label' => esc_html__('Columns', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 33.333,
                'options' => [
                    '100' => 1,
                    '50' => 2,
                    '33.333' => 3,
                    '25' => 4,
                    '20' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid_products3-box ' => 'width:{{VALUE}}%',
                ],
                'desktop_default' => '33.333',
                'tablet_default' => '50',
                'mobile_default' => '100',
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'large',
			]
		);

        $this->add_control(
			'rating_icon',
			[
				'label' => esc_html__( 'Icon', 'ahura' ),
				'type' => \Elementor\Controls_Manager::ICONS,
			]
		);

        $this->add_control(
			'show_description',
			[
				'label' => esc_html__( 'Show description', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'show_rating',
			[
				'label' => esc_html__( 'Show rating', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'trim_title_status',
			[
				'label' => esc_html__( 'Trim title status', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'trim_title',
			[
				'label' => esc_html__( 'Trim title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 10,
				'condition' => [
					'trim_title_status' => 'yes'
				]
			]
		);

        $this->add_control(
			'trim_description',
			[
				'label' => esc_html__( 'Trim description', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 1000,
				'step' => 1,
				'default' => 77,
			]
		);

        $this->add_control(
            'count',
            [
                'label'      => __( 'Number of posts', 'ahura' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 10
            ]
        );

        $this->add_control(
			'outofstock_text',
			[
				'label' => esc_html__( 'OutofStock text', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Sold out!', 'ahura' ),
			]
		);

        $this->add_control(
            'product_order',
            [
                'label' => __('Sort', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
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

        $this->end_controls_section();

        /**
         *
         *
         *  Styles
         *
         *
         */
        $this->start_controls_section(
            'box_style_section',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'img_border_radius',
            [
                'label' => esc_html__( 'Image border radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .grid_products3-box .fimage img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_border_radius',
            [
                'label' => esc_html__( 'Content border radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .grid_products3-box .content-area' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_title_section',
            [
                'label' => __( 'Title', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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
        if(is_rtl(  ))
        {
            $alignment = array_reverse($alignment);
        }

        $this->add_responsive_control(
            'box_title_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => $alignment,
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} h3' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'box_title_typo',
                'selector' => '{{WRAPPER}} h3',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 500],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'btn_section',
            [
                'label' => __( 'Button', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a[role="button"]' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_btn_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a[role="button"]' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_outofstock_color',
            [
                'label' => esc_html__('OutofStock color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a[role="button"].outofstock' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'box_outofstock_bg_color',
            [
                'label' => esc_html__('OutofStock background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a[role="button"].outofstock' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_btn_typo',
                'selector' => '{{WRAPPER}} a[role="button"]',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 400],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'btn_border_radius',
            [
                'label' => esc_html__( 'Button border radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} a[role="button"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'description_section',
            [
                'label' => __( 'Description', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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

        if(is_rtl())
        {
            $alignment = array_reverse($alignment);
        }

        $this->add_responsive_control(
            'box_description_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => $alignment,
                'selectors' => [
                    '{{WRAPPER}} .head .content' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'box_description_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .head .content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Description Typography', 'ahura'),
                'name' => 'box_description_typo',
                'selector' => '{{WRAPPER}} .head .content',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'rate_section',
            [
                'label' => __( 'Rating', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'rate_icon_size',
			[
				'label' => esc_html__( 'Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rating i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rating svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rating i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .rating svg path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'price_section',
            [
                'label' => __( 'Price', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_price_color',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .regular_price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Price typography', 'ahura'),
                'name' => 'box_price_typo',
                'selector' => '{{WRAPPER}} .regular_price',
            ]
        );

        $this->add_control(
            'box_saleprice_color',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sale-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Sale price typography', 'ahura'),
                'name' => 'box_saleprice_typo',
                'selector' => '{{WRAPPER}} .sale-price',
            ]
        );

        $this->end_controls_section();
        
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( class_exists( 'WooCommerce' ) ) {
            $field_is_term = (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);
            $current_currency_symbol = get_woocommerce_currency_symbol();

            if($settings[ 'catsid' ] == 'allproducts' || ( $settings[ 'catsid' ][ 0 ] == 'allproducts' ) || $settings[ 'catsid' ][ 0 ] == 'randomproducts' ) {
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
            $i = 0;
            if ($wc_query->have_posts()) :
                ?>
                <div class="grid_products3-area d-flex flex-wrap">
                <?php
                while ( $wc_query->have_posts() ) : $wc_query->the_post();
                    $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
                    $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
                    $average_rating = get_post_meta( get_the_id(), '_wc_average_rating', true );
                    $stock_status = get_post_meta( get_the_id(), '_stock_status', true );
                ?>
                <div class="grid_products3-box">
                    <div class="img-container">
                        <a class="fimage d-flex justify-content-center align-content-center" href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( $settings['thumbnail_size'] ); ?>
                        </a>
                    </div>
                    <div class="content-area">
                        <div class="head">
                            <div class="d-flex justify-content-between align-items-center meta mb-2">
                                <a href="<?php the_permalink(); ?>" class="title">
                                    <h3>
                                        <?php if($settings['trim_title_status'] == 'yes'): ?>
                                            <?php echo $settings['trim_title'] ? wp_trim_words( get_the_title(), $settings['trim_title'], '...' ) : wp_trim_words( get_the_title(), 5, '...' )  ?>
                                        <?php else: ?>
                                            <?php echo get_the_title(); ?>
                                        <?php endif; ?>
                                    </h3>
                                </a>
                                <?php if ($average_rating && ($settings['show_rating'] == 'yes')) : ?>
                                    <div class="d-flex align-items-center rating">
                                        <?php if( $settings['rating_icon']['value'] ): ?>
                                            <?php \Elementor\Icons_Manager::render_icon( $settings['rating_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        <?php else: ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="#ffb020" d="m234.5 114.38l-45.1 39.36l13.51 58.6a16 16 0 0 1-23.84 17.34l-51.11-31l-51 31a16 16 0 0 1-23.84-17.34l13.49-58.54l-45.11-39.42a16 16 0 0 1 9.11-28.06l59.46-5.15l23.21-55.36a15.95 15.95 0 0 1 29.44 0L166 81.17l59.44 5.15a16 16 0 0 1 9.11 28.06Z"/></svg>
                                        <?php endif; ?><span class="pt-1 <?php echo is_rtl() ? 'pr-2' : 'pl-2'; ?>"><?php echo $average_rating; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($settings['show_description'] == 'yes') : ?>
                                <div class="content mb-4">
                                    <?php echo $settings['trim_description'] ? wp_trim_words( get_the_excerpt(), $settings['trim_description'], '...' ) : wp_trim_words( get_the_excerpt(), 77, '...' )  ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between align-items-center footer">
                            <div class="mwprprice">
                                <div class="regular_price">
                                    <div class="reg-price-wrap">
                                        <?php echo sprintf('%s %s', mw_tools::number_format((!empty($sale_price) ? $sale_price : $this->get_price(get_the_ID()))), "{$current_currency_symbol}") ?>
                                    </div>
                                </div>
                                <?php if (!empty($sale_price)): ?>
                                    <div class="sale-price">
                                        <del><?php echo mw_tools::number_format($regular_price) ?></del>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <a href="?add-to-cart=<?php echo get_the_ID() ?>" class="<?php echo $stock_status == 'outofstock' ? 'outofstock' : ''; ?>" role="button">
                                <?php if($stock_status == 'instock'): ?>
                                <?php echo __('Has Discount', 'ahura') ?>
                                <?php elseif($stock_status == 'outofstock'): ?>
                                <?php echo __('Sold Out!', 'ahura') ?>
                                <?php else: ?>
                                <?php echo __('Pre Sale', 'ahura') ?>
                                <?php endif; ?>
                            </a>
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
        }
    }

}