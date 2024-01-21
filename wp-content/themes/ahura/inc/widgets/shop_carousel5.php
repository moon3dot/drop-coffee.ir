<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use ahura\app\Number;
use ahura\app\traits\WoocommerceMethods;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class shop_carousel5 extends \Elementor\Widget_Base {
    use WoocommerceMethods;

    /**
     * @param $data
     * @param $args
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_style('shop_carousel5_css', mw_assets::get_css('elementor.shop_carousel5'));
        if(!is_rtl()){
            mw_assets::register_style('shop_carousel5_ltr_css', mw_assets::get_css('elementor.ltr.shop_carousel5_ltr'));
        }
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'), false);
        mw_assets::register_script('shop_carousel5_js', mw_assets::get_js('elementor.shop_carousel5'));
    }

    public function get_style_depends() {
        $styles = [mw_assets::get_handle_name('swipercss'), mw_assets::get_handle_name('shop_carousel5_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('shop_carousel5_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('shop_carousel5_js')];
    }

    public function get_name() {
        return 'shop_carousel5';
    }

    public function get_title() {
        return __( 'Shop Carousel5', 'ahura' );
    }

    public function get_icon() {
        return 'eicon-form-vertical';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['shop_carousel5', 'shopcarousel5', esc_html__( 'Shop Carousel 5' , 'ahura')];
    }

    protected function register_controls() {
        if(!woocommerce::is_active())
            return false;

        $this->start_controls_section(
            'content_section', [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'ahura' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'options' => [
                        'all' => esc_html__('All Products', 'ahura'),
                        'top' => esc_html__('Best selling products', 'ahura'),
                        'offer' => esc_html__('Discounted products', 'ahura'),
                ],
                'default' => 'top',
            ]
        );
        if (\ahura\app\woocommerce::is_active()) {
            $categories = get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ));
            $cats       = array();
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
                'options'  => $cats,
                'label_block' => true,
                'multiple' => true,
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

        $this->add_control(
            'cols',
            [
                'label' => esc_html__( 'Columns', 'ahura' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'step' => 1,
                'default' => 4,
            ]
        );

        $this->add_control(
            'count',
            [
                'label' => esc_html__( 'Number of posts', 'ahura' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'step' => 1,
                'default' => 18,
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'more_section', [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__( 'Show Title', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'box_icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__( 'Box Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Best selling products', 'ahura' ),
                'condition' => [
                        'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_btn',
            [
                'label' => esc_html__( 'Show Button', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button Text', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'View All', 'ahura' ),
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'is_external' => false,
                    'url' => site_url()
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'move_btn_to_bottom',
            [
                'label' => esc_html__( 'Move button to bottom in mobile', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'ahura' ),
                'label_off' => esc_html__( 'No', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__( 'Show Arrows', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_number',
            [
                'label' => esc_html__( 'Show Numbers', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
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
        /**
         *
         * Styles
         *
         *
         */
        $this->start_controls_section(
            'items_style_section',
            [
                'label' => __( 'Items', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_border_color',
            [
                'label' => esc_html__('Border Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00000012',
                'selectors' => [
                    '{{WRAPPER}} .product-item-wrap:not(:last-child):before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_options',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#5a5a5a',
                'selectors' => [
                    '{{WRAPPER}} .product-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .product-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 400],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'number_options',
            [
                'label' => esc_html__( 'Number', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                        'show_number' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'item_num_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#19bfd3',
                'selectors' => [
                    '{{WRAPPER}} .pnum' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_number' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Number Typography', 'ahura'),
                'name' => 'item_num_typo',
                'selector' => '{{WRAPPER}} .pnum',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 800],
                    'font_size' => [
                        'default' => [
                            'unit' => 'rem',
                            'size' => '1.7',
                        ]
                    ]
                ],
                'condition' => [
                    'show_number' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_style_section',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .shop-carousel5-wrap',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#fff'
                            ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .shop-carousel5-wrap',
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
                    'color' => ['default' => '#f1f2f4']
                ]
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16
                ],
                'selectors' => [
                    '{{WRAPPER}} .shop-carousel5-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_title_options',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                        'show_title' => 'yes'
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

        $this->add_responsive_control(
            'box_title_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .box-title' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20
                ],
                'selectors' => [
                    '{{WRAPPER}} .box-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .box-title svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FF9800',
                'selectors' => [
                    '{{WRAPPER}} .box-title i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .box-title svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .box-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'box_title_typo',
                'selector' => '{{WRAPPER}} .box-title',
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
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_options',
            [
                'label' => esc_html__( 'Button', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $position = [
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-h-align-left'
            ],
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-h-align-right'
            ]
        ];

        $this->add_responsive_control(
            'box_btn_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $position : array_reverse($position),
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .box-btn' => '{{VALUE}}: 15px;'
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#19bfd3',
                'selectors' => [
                    '{{WRAPPER}} .box-btn a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_btn_typo',
                'selector' => '{{WRAPPER}} .box-btn a',
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
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'navigation_options',
            [
                'label' => esc_html__( 'Navigation', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_arrows' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'slider_nav_btn_bg',
                'selector' => '{{WRAPPER}} .swiper-nav-button',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#fff'
                        ]
                ],
                'condition' => [
                    'show_arrows' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'slider_btn_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#464646',
                'selectors' => [
                    '{{WRAPPER}} .swiper-nav-button' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_arrows' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!\ahura\app\woocommerce::is_active()) {
            if(is_admin()) {
                ?>
                <div class="productcategorybox mw_elem_empty_box"><h3><?php _e('To use this element you must install woocommerce plugin.', 'ahura'); ?></h3></div>
                <?php
            }
            return false;
        }

        $has_navigate = isset($settings['show_arrows']) && $settings['show_arrows'] == 'yes';
        $show_title = isset($settings['show_title']) && $settings['show_title'] === 'yes';
        $show_btn = isset($settings['show_btn']) && $settings['show_btn'] === 'yes';
        $show_number = isset($settings['show_number']) && $settings['show_number'] === 'yes';
        $type = $settings['type'];

        if ($show_btn && !empty($settings['btn_link']['url'])) {
            $this->add_link_attributes('btn_link', $settings['btn_link']);
        }

        $cats = $settings['catsid'];
        $field_is_term = (is_array($cats) && isset($cats[0]) && is_numeric($cats[0])) || is_int($cats);

        $args = [
            'post_type'		 => 'product',
            'post_status'	 => 'publish',
            'posts_per_page' => isset($settings['count']) ? $settings['count'] : 18,
        ];

        if($type === 'top'){
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } elseif($type === 'offer') {
            $args['meta_key'] = '_sale_price';
            $args['meta_value'] = '0';
            $args['meta_compare'] = '>';
        }

        if(!empty($cats)){
            $args['tax_query'][] = [
                'taxonomy'   => 'product_cat',
                'field'		 => $field_is_term ? 'term_id' : 'slug',
                'terms'		 => $cats,
            ];
        }

        $products_stock_status = isset($settings['products_stock_status']) ? $settings['products_stock_status'] : 'instock';

        if ($products_stock_status && $products_stock_status !== 'none') {
            $args['meta_query'] = array(array(
                'key' => '_stock_status',
                'value' => $products_stock_status,
                'compare' => '==',
            ));
        }

        $query = new \WP_Query($args);

        $ids = [];
        $counter = 0;
        $current_group = [];

        if($query->have_posts()){
            while ($query->have_posts()) {
                $query->the_post();
                $current_group[] = get_post(get_the_ID());
                $counter++;

                if ($counter % 3 === 0) {
                    $ids[] = $current_group;
                    $current_group = [];
                }
            }

            if (!empty($current_group)) {
                $ids[] = $current_group;
            }
            wp_reset_postdata();
        }
        ?>
        <div class="shop-carousel5-wrap">
            <?php if ($show_title || $show_btn): ?>
            <div class="box-head">
                <?php if ($show_title): ?>
                <div class="box-title">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['box_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php echo $settings['box_title'] ?>
                </div>
                <?php endif; ?>
                <?php if ($show_btn): ?>
                <div class="box-btn <?php echo isset($settings['move_btn_to_bottom']) && $settings['move_btn_to_bottom'] == 'yes' ? 'ah-bottom-in-mobile' : '' ?>">
                    <a <?php echo $this->get_render_attribute_string('btn_link'); ?>>
                        <?php echo $settings['btn_text'] ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="products-list">
                <?php if (!empty($ids)): ?>
                <div class="swiper shop-carousel5-swiper">
                    <div class="swiper-wrapper">
                        <?php $num = 0; foreach ($ids as $items): ?>
                            <div class="swiper-slide">
                                <?php foreach($items as $product): $num++; ?>
                                    <div class="product-item-wrap">
                                        <a href="<?php echo get_the_permalink($product->ID) ?>" class="product-item <?php echo !$show_number ? ' without-num' : ''?>">
                                            <div class="product-cover">
                                                <?php echo wp_get_attachment_image(get_post_thumbnail_id($product->ID)); ?>
                                            </div>
                                            <?php if($show_number): ?>
                                            <div class="pnum">
                                                <?php echo Number::numByLang($num) ?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="product-title">
                                                <?php echo $product->post_title ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($has_navigate): ?>
                        <div class="swiper-nav-button swiper-btn-prev"><i class="fas fa-angle-right"></i></div>
                        <div class="swiper-nav-button swiper-btn-next"><i class="fas fa-angle-left"></i></div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                    <div class="ahura-element-not-found-msg">
                        <?php echo __('Sorry, no products found.', 'ahura') ?>
                    </div>
                <?php endif; ?>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    handleShopCarousel5Element({
                        cols: <?php echo isset($settings['cols']) ? $settings['cols'] : 4 ?>,
                        navigation: <?php echo $has_navigate ? 'true' : 'false' ?>,
                        loop: true,
                        autoplay: <?php echo $settings['autoplay'] == 'yes' ? 'true' : 'false' ?>,
                        autoplayTimeout: <?php echo $settings['autoplay_delay'] ? $settings['autoplay_delay'] : 0; ?>,
                    });
                });
            </script>
        </div>
        <?php
    }
}
