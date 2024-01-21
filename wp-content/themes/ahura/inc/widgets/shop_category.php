<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\woocommerce;

defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class shop_category extends \Elementor\Widget_Base
{
    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('owl_carousel_css', mw_assets::get_css('owl-carousel'));
        mw_assets::register_script('owl_carousel_js', mw_assets::get_js('owl-carousel-min'));
        mw_assets::register_style('shop_category_css', mw_assets::get_css('elementor.shop_category'));
        mw_assets::register_script('shop_category_js', mw_assets::get_js('elementor.shop_category'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('shop_category_css'), mw_assets::get_handle_name('owl_carousel_css')];
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('owl_carousel_js'), mw_assets::get_handle_name('shop_category_js')];
    }

    public function get_name()
    {
        return 'shopcategory';
    }

    public function get_title()
    {
        return __('Products Category List', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-shop-category';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['shopcategory', 'productscategory', 'products_category', __('Products Category', 'ahura')];
    }

    protected function register_controls()
    {
        if (!woocommerce::is_active()) {
            return false;
        }
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'display_type',
            [
                'label' => esc_html__('Display Type', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 1,
                'options' => [
                    '1' => esc_html__('Latest Products', 'ahura'),
                    '2' => esc_html__('Discounted products', 'ahura'),
                ]
            ]
        );

        $categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));
        $cats = array();
        foreach ($categories as $category) {
            $cats[$category->slug] = $category->name;
        }
        $default = key($cats);
        $this->add_control(
            'catsid',
            [
                'label' => __('Categories', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $cats,
                'label_block' => true,
                'multiple' => true,
                'default' => $default
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => __('Show Price', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => ['title' => __('Yes', 'ahura'), 'icon' => 'eicon-check'],
                    'no' => ['title' => __('No', 'ahura'), 'icon' => 'eicon-close']
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'count',
            [
                'label' => __('Number of posts', 'ahura'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 8
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Image', 'ahura'),
                'type' => \Elementor\Controls_Manager::MEDIA
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
            'direction',
            [
                'label' => __('Image Direction', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'DESC',
                'options' => [
                    'left' => [
                        'title' => __('Left', 'ahura'),
                        'icon' => 'eicon-arrow-left'
                    ],
                    'right' => [
                        'title' => __('Right', 'ahura'),
                        'icon' => 'eicon-arrow-right'
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .productcategorybox section' => 'float: {{VALUE}}',
                ],
                'toggle' => true
            ]
        );

        $this->add_control(
            'stock_status',
            [
                'label' => __('Show product stock status', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => ['title' => __('Yes', 'ahura'), 'icon' => 'eicon-check'],
                    'no' => ['title' => __('No', 'ahura'), 'icon' => 'eicon-close']
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'outofstock_text',
            [
                'label' => __('Out of stock text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('out of stock', 'ahura'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('All Products', 'ahura'),
            ]
        );

        $this->add_control(
            'use_btn_custom_link',
            [
                'label' => esc_html__('Custom Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Button link', 'ahura' ),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'show_external' => true,
                'condition' => [
                        'use_btn_custom_link' => 'yes'
                ]
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
            'product_style_section',
            [
                'label' => __('Product', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'p_title_color',
            [
                'label' => __('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#555555',
                'selectors' => [
                    '{{WRAPPER}} .owl-item h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .owl-item h3',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '16'
                            ]
                        ],
                        'font_weight' => [
                            'default' => '400'
                        ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'p_box_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .owl-item ',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->add_control(
            'pro_box_price_color',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#555555',
                'selectors' => [
                    '{{WRAPPER}} .price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price ins' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .price del' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pro_box_dis_price_color',
            [
                'label' => esc_html__('Price by Discount Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#555555',
                'selectors' => [
                    '{{WRAPPER}} .price del' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Price Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .price span',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '16'
                            ]
                        ],
                        'font_weight' => [
                            'default' => '400'
                        ]
                    ]
            ]
        );

        $this->add_control(
            'outofstock_background_color',
            [
                'label' => esc_html__('Of of stock background color', 'ahura'),
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
                'label' => esc_html__('Of of stock color', 'ahura'),
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

        $this->end_controls_section();

        $this->start_controls_section(
            'des_content_style_section',
            [
                'label' => __('Description Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => __('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#66bb6a'
            ]
        );

        $this->add_control(
            'des_title_color',
            [
                'label' => __('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .prcatboxtitle h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'des_btn_color',
            [
                'label' => __('Button Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .prcatboxtitle a' => 'color: {{VALUE}};border-color: {{VALUE}};',
                ],
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
            'content_style_section',
            [
                'label' => __('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .productcategorybox, {{WRAPPER}} .productcategorybox .owl-carousel',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->add_responsive_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .productcategorybox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .productcategorybox',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => 'rgb(0 0 0 / 6%)'
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        if (!\ahura\app\woocommerce::is_active()) {
            if(is_admin()) {
                ?>
                <div class="productcategorybox mw_elem_empty_box"><h3><?php _e('To use this element you must install woocommerce plugin.', 'ahura'); ?></h3></div>
                <?php
            }
            return false;
        }
        
        $settings = $this->get_settings_for_display();
        $use_custom_link = $settings['use_btn_custom_link'] === 'yes';

        if ($use_custom_link && !empty($settings['button_link']['url'])) {
            $this->add_link_attributes( 'btn_link', $settings['button_link'] );
        }

        if (class_exists('WooCommerce')) {
            $field_is_term = (is_array($settings['catsid']) && isset($settings['catsid'][0]) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);
            $type = $settings['display_type'];
            $arg = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => $settings['count'],
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => $field_is_term ? 'term_id' : 'slug',
                        'terms' => $settings['catsid'],
                    )
                ),
                'order' => $settings['product_order']
            );
            if ($type == 2) {
                $arg['meta_query'] = array(
                    'relation' => 'OR',
                    array(
                        'key' => '_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    ),
                    array(
                        'key' => '_min_variation_sale_price',
                        'value' => 0,
                        'compare' => '>',
                        'type' => 'numeric'
                    )
                );
            }
            $wc_query = new \WP_Query($arg);
            $first_cat_id = is_array($settings['catsid']) && isset($settings['catsid'][0]) ? $settings['catsid'][0] : $settings['catsid'];
            if ($wc_query->have_posts()) : ?>
                <div class="shop-category-element productcategorybox">
                    <section style="background-color:<?php echo $settings['color']; ?>" class="prcatboxtitle">
                        <img src="<?php echo $settings['image']['url']; ?>"/>
                        <h2>
                            <?php 
                            $term = get_term_by($field_is_term ? 'id' : 'slug', $first_cat_id, 'product_cat');
                            if($term){
                                echo $term->name;
                            }
                            ?>
                        </h2>
                        <?php if($use_custom_link): ?>
                            <a <?php echo $this->get_render_attribute_string('btn_link'); ?>><?php echo $settings['button_text']; ?></a>
                        <?php elseif($term): ?>
                            <a href="<?php echo get_term_link($term); ?>"><?php echo $settings['button_text']; ?></a>
                        <?php endif; ?>
                        <div class="clear"></div>
                    </section>
                    <div class="owl-carousel owl-shop-category w-80">
                        <?php
                        while ($wc_query->have_posts()): $wc_query->the_post();
                            $product = wc_get_product(get_the_ID());
                        ?>
                            <div>
                                <a class="fimage" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('woocommerce_thumbnail'); ?></a>
                                <a href="<?php the_permalink(); ?>">
                                    <h3><?php echo wp_trim_words(get_the_title(), 8, '...'); ?></h3></a>
                                <?php if ($settings['price'] == 'yes') : ?>
                                    <div class="mwprprice">
                                        <?php
                                        $price = woocommerce_template_single_price();
                                        echo $price;
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <?php
                                if (($settings['stock_status'] == 'yes' && $product->get_stock_status() == "outofstock")) {
                                    echo '<p class="out-of-stock">' . $settings['outofstock_text'] . '</p>';
                                }
                                ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
                <?php if (is_admin()): ?>
                    <script>
                        jQuery(document).ready(function ($) {
                            handleShopCategoryElement();
                        });
                    </script>
                <?php endif; ?>
            <?php else: ?>
                <div class="mw_element_error">
                    <?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.', 'ahura'); ?>
                </div>
            <?php endif; ?>
            <div class="clear"></div>
            <?php
        } elseif (is_admin()) {
            ?>
            <div class="mw_element_error"><?php _e('To use this element you must install woocommerce plugin.', 'ahura'); ?></div>
            <?php
        }
    }

}
