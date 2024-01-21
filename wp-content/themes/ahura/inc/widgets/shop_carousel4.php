<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_tools;
use ahura\app\traits\WoocommerceMethods;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;

class shop_carousel4 extends \Elementor\Widget_Base {
    use WoocommerceMethods;

    /**
     * shop_carousel4 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_style('shop_carousel4_css', mw_assets::get_css('elementor.shop_carousel4'));
        if(!is_rtl()){
            mw_assets::register_style('shop_carousel4_ltr_css', mw_assets::get_css('elementor.ltr.shop_carousel4_ltr'));
        }
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'), false);
        mw_assets::register_script('shop_carousel4_js', mw_assets::get_js('elementor.shop_carousel4'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('swipercss'), mw_assets::get_handle_name('shop_carousel4_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('shop_carousel4_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('shop_carousel4_js')];
    }

    public function get_name() {
        return 'shopcarousel4';
    }

    public function get_title() {
        return __( 'Products Carousel 4', 'ahura' );
    }

    public function get_icon() {
        return 'aicon-svg-shop-carousel';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['shopcarousel4', 'productscarousel4', 'products_carousel4', 'shop_carousel4', esc_html__( 'Products Carousel 4' , 'ahura')];
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

        $this->add_control(
            'show_title',
            [
                'label'   => __( 'Show Title', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => __( 'Yes', 'ahura' ),
                        'icon' => 'eicon-check'
                    ],
                    'no' => [
                        'title' => __( 'No', 'ahura' ),
                        'icon' => 'eicon-editor-close'
                    ]
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'fully_show_title',
            [
                'label'   => __( 'Fully Show Title', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'no',
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'price',
            [
                'label'   => __( 'Show Price', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
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
                'type'       => Controls_Manager::NUMBER,
                'default'    => 8
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

        $this->add_control(
            'stock_status',
            [
                'label'   => __( 'Show product stock status', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'outofstock_text',
            [
                'label' => __( 'Out of stock text', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'out of stock', 'ahura' ),
            ]
        );

        $this->add_responsive_control(
            'object_fit',
            [
                'label' => esc_html__( 'Aspect ratio', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fill',
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

        $this->end_controls_section();

        $this->start_controls_section(
            'box_content_section',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'box_image',
            [
                'label' => esc_html__( 'Choose Image', 'ahura' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_template_directory_uri() . '/img/offer-box.webp',
                ],
            ]
        );

        $this->add_control(
            'box_link',
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
            ]
        );

        $this->add_control(
            'show_btn1',
            [
                'label' => esc_html__( 'Show Button 1', 'ahura' ),
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
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => __('View All', 'ahura'),
                'condition' => [
                        'show_btn1' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_btn2',
            [
                'label' => esc_html__( 'Show Button 2', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'btn_text2',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => __('View All', 'ahura'),
                'condition' => [
                    'show_btn2' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_link2',
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
                    'show_btn2' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Arrows', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
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
         *  Styles
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

        $this->add_responsive_control(
            'item_img_radius',
            [
                'label' => esc_html__( 'Cover Border Radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'selector' => '{{WRAPPER}} .swiper-slide:not(.sc-first-item-content, .sc-last-item-content) .sc-item-content',
                'exclude' => ['image'],
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

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .sc-item-content .product-title' => 'color: {{VALUE}}',
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
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .sc-item-content .product-title h3',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 500],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'price_styles',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_price_color',
            [
                'label' => esc_html__('Product regular price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .reg-price-wrap' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_dis_price_color',
            [
                'label' => esc_html__('Product sale price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#c3c3ce',
                'selectors' => [
                    '{{WRAPPER}} .sale-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_style_section',
            [
                'label' => __( 'Slider', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_spacing',
            [
                'label' => esc_html__( 'Items Spacing', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 2,
                ],
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
                'selector' => '{{WRAPPER}} .shop-carousel4-wrap',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#ef3f55'
                            ]
                    ]
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
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
                    '{{WRAPPER}} .shop-carousel4-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_btn_color',
            [
                'label' => esc_html__('Button Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sc-first-item-content a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__( 'Archive Button', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_archive_btn_bg',
                'selector' => '{{WRAPPER}} .sc-last-item-content .sc-item-content',
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

        $this->add_control(
            'box_archive_btn_color',
            [
                'label' => esc_html__('Button Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .sc-last-item-content .sc-item-content a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sc-last-item-content .sc-item-content span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_archive_btn_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#19bfd3',
                'selectors' => [
                    '{{WRAPPER}} .sc-last-item-content .sc-item-content i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( class_exists( 'WooCommerce' ) ) {
            $field_is_term = (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);
            $has_navigate = ($settings['show_arrows'] == 'yes');
            $url = $settings['box_link'];
            $url2 = $settings['box_link2'];
            $current_currency_symbol = get_woocommerce_currency_symbol();
            $cats_id = $settings['catsid'];

            if (!empty($url['url'])) {
                $this->add_link_attributes('box_link', $url);
            }

            if (!empty($url2['url'])) {
                $this->add_link_attributes('box_link2', $url2);
            }

            $args = [
                'post_type'		 => 'product',
                'post_status'	 => 'publish',
                'posts_per_page' => $settings[ 'count' ],
                'order' 		 => $settings[ 'product_order' ],
            ];

            if($cats_id == 'allproducts' || ($cats_id[0] == 'allproducts') || $cats_id[0] == 'randomproducts') {
                $args = array_merge($args, [
                    'orderby' => $cats_id[0] == 'randomproducts' ? 'rand' : $settings['product_order']
                ]);
            } elseif($cats_id[0] == 'discountedproducts') {
                $args = array_merge($args, [
                    'meta_key' 		 => '_sale_price',
                    'meta_value' 	 => '0',
                    'meta_compare'   => '>='
                ]);
            } else {
                $args = array_merge($args, [
                    'tax_query'		 => [[
                        'taxonomy'   => 'product_cat',
                        'field'		 => $field_is_term ? 'term_id' : 'slug',
                        'terms'		 => $cats_id,
                    ]],
                ]);
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
            if ($wc_query->have_posts()) : ?>
                <div class="shop-carousel4-wrap">
                    <div class="swiper swiper-shop-carousel4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide sc-first-item-content sc-item-content">
                                <a <?php echo $this->get_render_attribute_string('box_link'); ?>>
                                    <?php
                                    $this->add_render_attribute('image', 'src', $settings['box_image']['url']);
                                    $this->add_render_attribute('image', 'alt', \Elementor\Control_Media::get_image_alt($settings['box_image']));
                                    echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'full', 'box_image');
                                    ?>
                                    <?php if($settings['show_btn1'] === 'yes'): ?>
                                    <div><?php echo $settings['btn_text'] ?><i class="fas fa-angle-<?php echo is_rtl() ? 'left' : 'right' ?>"></i></div>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <?php
                            while ( $wc_query->have_posts() ) : $wc_query->the_post();
                                $sale_percent = $this->get_product_sale_percent();
                                $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
                                $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
                                $sale_days_progress = $this->get_product_sale_progress_percent(get_the_ID());
                                ?>
                                <div class="swiper-slide">
                                    <div class="sc-item-content">
                                        <div class="sc-items-top">
                                            <div class="product-labels">
                                                <?php
                                                if ( ( $settings['stock_status'] == 'yes' && wc_get_product( get_the_ID() )->get_stock_status() == "outofstock" ) ) {
                                                    echo '<span class="out-stock">' . $settings['outofstock_text'] . '</span>';
                                                }
                                                ?>
                                            </div>
                                            <a class="fimage" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?></a>
                                            <?php if($settings['show_title'] == 'yes'): ?>
                                                <a href="<?php the_permalink(); ?>" class="product-title">
                                                    <h3><?php echo $settings['fully_show_title'] == 'yes' ? get_the_title() : wp_trim_words( get_the_title(), 6, '...' ); ?></h3>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="sc-items-bottom">
                                            <?php if ( $settings['price'] == 'yes' ) : ?>
                                                <div class="mwprprice">
                                                    <div class="regular_price <?php echo empty($sale_percent) ? ' without-sale' : ''?>">
                                                        <?php if (!empty($sale_percent)): ?>
                                                            <span class="sale-percent"><?php echo $sale_percent ?>%</span>
                                                        <?php endif; ?>
                                                        <div class="reg-price-wrap">
                                                            <?php echo sprintf('%s %s', mw_tools::number_format((!empty($sale_price) ? $sale_price : $this->get_price(get_the_ID()))), "<em>{$current_currency_symbol}</em>") ?>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($sale_price)): ?>
                                                        <div class="sale-price">
                                                            <del><?php echo mw_tools::number_format($regular_price) ?></del>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($sale_days_progress): ?>
                                                <div class="sale-progress">
                                                    <div class="percent" style="width:<?php echo $sale_days_progress ?>%"></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <?php if($settings['show_btn2'] === 'yes'): ?>
                            <div class="swiper-slide sc-last-item-content">
                                <div class="sc-item-content">
                                    <a <?php echo $this->get_render_attribute_string('box_link2'); ?>>
                                        <i class="fas fa-arrow-<?php echo is_rtl() ? 'left' : 'right' ?>"></i>
                                        <span><?php echo $settings['btn_text2'] ?></span>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if($has_navigate): ?>
                            <div class="swiper-nav-button swiper-btn-prev"><i class="fas fa-angle-right"></i></div>
                            <div class="swiper-nav-button swiper-btn-next"><i class="fas fa-angle-left"></i></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="mw_element_error">
                    <?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
                </div>
            <?php endif; ?>
            <div class="clear"></div>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    handleShopCarousel4Element({
                        navigation: <?php echo $has_navigate ? 'true' : 'false' ?>,
                        spaceBetween: <?php echo isset($settings['item_spacing']['size']) ? $settings['item_spacing']['size'] : 2 ?>,
                    });
                });
            </script>
            <?php
        }
    }
}