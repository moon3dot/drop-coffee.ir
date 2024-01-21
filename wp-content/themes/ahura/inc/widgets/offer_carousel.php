<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;
use ahura\app\Ahura_Alert;

class offer_carousel extends \Elementor\Widget_Base
{
    use \ahura\app\traits\WoocommerceMethods;

    /**
     * offer_carousel constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('offer_carousel_css', mw_assets::get_css('elementor.offer_carousel'));
        mw_assets::register_script('offer_carousel_js', mw_assets::get_js('elementor.offer_carousel'));
		mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'), false);
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));

        if(!is_rtl()){
            mw_assets::register_style('offer_carousel_ltr_css', mw_assets::get_css('elementor.ltr.offer_carousel_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('swipercss'), mw_assets::get_handle_name('offer_carousel_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('offer_carousel_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('offer_carousel_js')];
    }

    public function get_name()
    {
        return 'offer_carousel';
    }

    public function get_title()
    {
        return esc_html__('Offer Carousel', 'ahura');
    }

	public function get_icon() {
		return 'eicon-post-slider';
	}

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['offer_carousel', 'offercarousel', __('Offer Carousel', 'ahura')];
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

        $this->add_control(
            'products',
            [
                'label' => esc_html__('Products', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'pid' => $default
                    ]
                ],
                'title_field' => '{{{pid}}}',
                'condition' => [
                    'only_discounted_products!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'only_discounted_products',
            [
                'label' => esc_html__('Only Discounted Products', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'items_num',
            [
                'label' => esc_html__('Products Number', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'condition' => [
                    'only_discounted_products' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'end_timer_text',
            [
                'label' => esc_html__('Countdown End Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('The discount has ended.', 'ahura'),
                'condition' => [
                    'only_discounted_products' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_timer',
            [
                'label' => esc_html__('Timer', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'only_discounted_products' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'timer_important_note',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__('Only for products with timed discounts.', 'ahura'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition' => [
                    'show_timer' => 'yes',
                    'only_discounted_products' => 'yes'
                ]
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
            'transition_duration',
            [
                'label' => esc_html__('Transition Duration', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'default' => 3000,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'shop_catalog',
            ]
        );

        $this->add_responsive_control(
            'object_fit',
            [
                'label' => esc_html__( 'Aspect ratio', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'contain',
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

        $this->end_controls_section();
        /**
         * 
         * 
         *  Styles
         * 
         */
        $this->start_controls_section(
            'box_styles',
            [
                'label' => esc_html__('Product', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'product_item_cover_height',
            [
                'label' => esc_html__('Cover Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 700
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .product-cover img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .product' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'items_border',
				'label' => esc_html__('Border', 'ahura'),
				'selector' => '{{WRAPPER}} .offer-carousel-1 .product',
			]
		);

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1, {{WRAPPER}} .offer-carousel-1 .product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .offer-carousel-1',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 21,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .10)'
                        ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'title_more_options',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .product .product-title h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .offer-carousel-1 .product .product-title h2',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '19'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ]
            ]
        );

        $this->add_control(
            'price_more_options',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_price_color',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ed0000',
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .product .price-wrap .price > span > bdi' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .offer-carousel-1 .product .price-wrap .price ins span bdi' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price_typography',
                'selector' => '{{WRAPPER}} .offer-carousel-1 .product .price-wrap .price > span > bdi, {{WRAPPER}} .offer-carousel-1 .product .price-wrap .price ins span bdi',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '400'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '22',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_price_dis_color',
            [
                'label' => esc_html__('Product sale price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#b7b7b7',
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .product .price-wrap .price del' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price_dis_typography',
                'selector' => '{{WRAPPER}} .offer-carousel-1 .product .price-wrap .price del span bdi',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '300'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ]
                    ],
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'timer_styles',
            [
                'label' => esc_html__('Timer', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'progress_bar_bg_color',
            [
                'label' => esc_html__('Progress Bar Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ed0000',
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .slider-duration-line' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'timer_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .product-discount-timer-wrap' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'show_timer' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'timer_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .product-discount-timer-wrap .countdown-time > div' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .offer-carousel-1 .product-discount-timer-wrap .time-end' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_timer' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'timer_nums_color',
            [
                'label' => esc_html__('Numbers Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4ebd47',
                'selectors' => [
                    '{{WRAPPER}} .offer-carousel-1 .product-discount-timer-wrap .countdown-time > div .num' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_timer' => 'yes'
                ]
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
        $only_discounted = ($settings['only_discounted_products'] == 'yes');
        $show_timer = ($settings['show_timer'] == 'yes');

        if(isset($settings['products']) && is_array($settings['products'])){
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

        if($only_discounted){
            $products = $this->get_discounted_products(['per_page' => ($settings['items_num'] ? $settings['items_num'] : -1)]);
        }
        ?>
        <div class="ahura-offer-carousel offer-carousel-<?php echo $wid ?>">
            <?php if($products): ?>
            <div class="swiper offer-carousel-1 <?php echo $only_discounted ? ' only-dis' : ' not-dis'; ?> <?php echo $only_discounted && $show_timer ? ' with-timer' : ''; ?>">
                <div class="swiper-wrapper">
                    <?php 
                    while($products->have_posts()): $products->the_post();
                        global $product;
                        $sale_end_date = get_post_meta(get_the_ID(), '_sale_price_dates_to', true);
                     ?>
                        <div class="swiper-slide">
                            <article <?php wc_product_class('', $product) ?>>
                                <div class="product-slide-content clearfix">
                                    <div class="product-cover">
                                        <div class="product-label">
                                            <?php
                                            # product html labels array
                                            $labels = $this->get_product_labels();

                                            if(isset($labels['on_sale_percent'])){
                                                echo $labels['on_sale_percent'];
                                            }
                                            ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo wp_get_attachment_image(get_post_thumbnail_id(), $settings['item_cover_size']); ?>
                                        </a>
                                    </div>
                                    <div class="product-title">
                                        <a href="<?php echo get_the_permalink() ?>">
                                            <h2>
                                                <?php the_title(); ?>
                                            </h2>
                                        </a>
                                    </div>
                                    <div class="product-details">
                                        <div class="price-wrap">
                                            <?php woocommerce_template_single_price(); ?>
                                        </div>
                                    </div>
                                    <?php if($products->found_posts > 1): ?>
                                    <div class="slider-duration-progress clearfix">
                                        <div class="slider-duration-line"></div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php if($show_timer && $only_discounted && intval($sale_end_date) && $product->is_on_sale()): ?>
                                <div class="product-discount-timer-wrap product-discount-timer-wrap-<?php echo md5(get_the_ID()); ?>" data-id="<?php echo md5(get_the_ID()); ?>" data-time="<?php echo date('Y/m/d', $sale_end_date) ?>">
                                    <div class="countdown-time">
                                        <div class="days">
                                            <span class="num">0</span>
                                            <span><?php _e('Days', 'ahura') ?></span>
                                        </div>
                                        <div class="hours">
                                            <span class="num">0</span>
                                            <span><?php _e('Hours', 'ahura') ?></span>
                                        </div>
                                        <div class="minutes">
                                            <span class="num">0</span>
                                            <span><?php _e('Minutes', 'ahura') ?></span>
                                        </div>
                                        <div class="seconds">
                                            <span class="num">0</span>
                                            <span><?php _e('Seconds', 'ahura') ?></span>
                                        </div>
                                    </div>
                                    <div class="time-end" style="display:none">
                                        <?php echo $settings['end_timer_text'] ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </article>
                        </div>
                    <?php 
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    handleOfferCarouselElement({
                        widgetID: '<?php echo $wid ?>',
                        autoPlayDelay: <?php echo $duration; ?>,
                    });
                });
            </script>
            <?php 
			else: 
				Ahura_Alert::frontNotice(__('Sorry, no products were found for display.', 'ahura'), Ahura_Alert::ERROR);
			endif; 
			?>
        </div>
        <?php
    }
}