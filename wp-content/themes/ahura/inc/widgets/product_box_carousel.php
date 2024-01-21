<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

class product_box_carousel extends \Elementor\Widget_Base
{
    /**
     * product_box_carousel constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('product_box_carousel_css', mw_assets::get_css('elementor.product_box_carousel'));
        if(!is_rtl()){
            mw_assets::register_style('product_box_carousel_ltr_css', mw_assets::get_css('elementor.ltr.product_box_carousel_ltr'));
        }
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'));
        mw_assets::register_script('product_box_carousel_js', mw_assets::get_js('elementor.product_box_carousel'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('product_box_carousel_css'), mw_assets::get_handle_name('swipercss')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('product_box_carousel_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('product_box_carousel_js'), mw_assets::get_handle_name('swiperjs')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'product_box_carousel';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Product Box Carousel', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'aicon-svg-product-box-carousel';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraelements'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['productboxcarousel', 'product_box_carousel', esc_html__('Product Box Carousel', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        /**
         *
         *
         * Start content
         *
         */

        $this->start_controls_section(
            'content_settings',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Apple Laptops', 'ahura'),
            ]
        );

        $this->add_control(
            'box_des',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
            ]
        );

        $this->add_control(
            'box_btn_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'default' => ['url' => site_url()],
                'placeholder' => site_url(),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $alignment = array(
            'right' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'left' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ]
        );

        $this->add_responsive_control(
            'box_det_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .box-details' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control('divider1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'show_btn',
            [
                'label' => esc_html__('Archive Button', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_slider_btn',
            [
                'label' => esc_html__('Slider Button', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_slider_social',
            [
                'label' => esc_html__('Social Button', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_features',
            [
                'label' => esc_html__('Features', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'display_settings',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $taxonomies = get_taxonomies([
            'public' => true,
            'name' => 'product_cat',
        ], 'objects');

        $cats = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($term_object = get_terms($key)) {
                    if($term_object){
                        foreach ($term_object as $term) {
                            $cats[$term->term_id] = "{$term->name} - {$taxonomy->labels->name}";
                        }
                    }
                }
            }
        }
        $default = ($cats) ? key($cats) : 0;
        $this->add_control(
            'cat_id',
            [
                'label' => esc_html__('Categories', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $cats,
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Posts Count', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 3,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'full',
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
         *
         * Product box style
         *
         *
         *
         */
        $this->start_controls_section(
            'product_box_styles',
            [
                'label' => esc_html__('Product Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'pro_box_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .product' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .product .pbc-before.f' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pro_box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .title-wrap h2' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .features h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pro_box_meta_color',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ababab',
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .product-metas div' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pro_box_price_color',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#01b369',
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .product .price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .product .price ins' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .product .price del' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .product-box-carousel-1 .product .price del' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'pro_box_features_color',
            [
                'label' => esc_html__('Features Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#7F7F7F',
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .product .features li' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pro_box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-box-carousel-1 .product .title-wrap h2',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '17'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'pro_box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .product-box-carousel-1 .product',
            ]
        );

        $this->add_control(
            'pro_box_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
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
                'name' => 'pro_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-box-carousel-1 .product',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 10,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.09)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Box buttons style
         *
         *
         */
        $this->start_controls_section(
            'box_btns_styles',
            [
                'label' => esc_html__('Box Buttons', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'archive_btn_style',
            [
                'label' => esc_html__('Archive Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_btn' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_btn_typo',
                'selector' => '{{WRAPPER}} .product-box-carousel-1 .box-more-link',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ],
                'condition' => [
                    'show_btn' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'box_btn_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .box-more-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ],
                'condition' => [
                    'show_btn' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'box_btn_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .box-more-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 5,
                    'right' => 15,
                    'bottom' => 5,
                    'left' => 15,
                ],
                'condition' => [
                    'show_btn' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'slider_btn_style',
            [
                'label' => esc_html__('Slider Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_slider_btn' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_btn_slide_typo',
                'selector' => '{{WRAPPER}} .product-box-carousel-1 .pbc-slider-btn',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ],
                'condition' => [
                    'show_slider_btn' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'box_btn_slide_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .pbc-slider-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ],
                'condition' => [
                    'show_slider_btn' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'box_btn_slide_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .pbc-slider-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 5,
                    'right' => 13,
                    'bottom' => 5,
                    'left' => 13,
                ],
                'condition' => [
                    'show_slider_btn' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Box Styles
         *
         *
         */
        $this->start_controls_section(
            'box_styles',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_pri_color',
            [
                'label' => esc_html__('Primary Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#6c92f7',
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .box-title:before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .box-more-link' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .pbc-slider-btn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .share-btn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .yith-wcwl-add-button a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .product-foot a' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .product-box-carousel-1 .features li:before' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .product-box-carousel-1' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .product-box-carousel-1 .box-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_des_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#A5A5A5',
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1 .box-excerpt' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-box-carousel-1 .box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_des_typo',
                'label' => esc_html__('Description Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-box-carousel-1 .box-excerpt',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ]
            ]
        );

        $this->add_control(
            'box_wrap_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_wrap_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-box-carousel-1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 40,
                    'right' => 25,
                    'bottom' => 40,
                    'left' => 25,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-box-carousel-1',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .15)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     *
     * Get products result
     *
     * @param array $params
     * @return false
     */
    public function get_products($params = [])
    {
        $settings = $this->get_settings_for_display();
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $settings['per_page'],
            'post_status' => 'publish',
        );

        if ($settings['cat_id']) {
            $args['tax_query'] = array(
                'tax_query' => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $settings['cat_id'],
                    ]
                ]
            );
        }

        $posts = new \WP_Query(array_merge($args, $params));
        return ($posts->have_posts()) ? $posts : false;
    }

    protected function render_link_attrs($url_data)
    {
        $target = $url_data['is_external'] ? 'target="_blank"' : '';
        $nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
        $cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
        $data = 'href="' . $url_data['url'] . '" ' . $target . ' ' . $nofollow . ' ' . $cu_attr;
        echo $data;
    }

    /**
     *
     * Render element content (html)
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        $has_features = $settings['show_features'] === 'yes';

        if(!\ahura\app\woocommerce::is_active()){
            return false;
        }

        $products = $this->get_products();

        if(!$products){
            return false;
        }
        ?>
        <div class="product-box-carousel-1-wrap">
            <div class="product-box-carousel-1">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="box-details">
                            <div><h2 class="box-title"><?php echo $settings['box_title'] ?></h2></div>
                            <div class="box-excerpt"><?php echo $settings['box_des'] ?></div>
                            <div class="box-foot">
                                <div class="row p-0 m-0">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0 m-0">
                                        <?php if ($settings['show_btn'] === 'yes'): ?>
                                            <a <?php $this->render_link_attrs($settings['box_btn_link']) ?> class="box-more-link">
                                                <?php echo esc_html__('View All', 'ahura') ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <?php if($settings['show_slider_btn'] === 'yes'): ?>
                                            <div class="pbc-button-next pbc-slider-btn"><i class="fas fa-chevron-right"></i></div>
                                            <div class="pbc-button-prev pbc-slider-btn"><i class="fas fa-chevron-left"></i></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                        <div class="swiper box-products">
                            <div class="swiper-wrapper">
                            <?php
                            while ($products->have_posts()):
                                $products->the_post();
                                $product = wc_get_product(get_the_ID());
                                $attributes = $product->get_attributes();
                                ?>
                                    <div class="swiper-slide">
                                        <article <?php wc_product_class((!$attributes || !$has_features ? 'without-f' : ''), $product) ?>>
                                            <div class="product-cover">
                                                <div class="float-buttons">
                                                    <?php if($settings['show_slider_social'] === 'yes'): ?>
                                                    <div class="share-btns">
                                                        <div class="share-btn"><i class="fas fa-share-alt"></i></div>
                                                        <div class="btns">
                                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink() ?>&source=<?php echo site_url() ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink() ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                                            <a href="https://twitter.com/intent/tweet?text=<?php echo get_the_permalink() ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if (in_array('yith-woocommerce-wishlist/init.php', apply_filters('active_plugins', get_option('active_plugins')))): ?>
                                                        <div class="fav-btns"><?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php echo wp_get_attachment_image(get_post_thumbnail_id(), $settings['item_cover_size']); ?>
                                                </a>
                                            </div>
                                            <div class="pbc-before f">
                                                <div class="title-wrap">
                                                    <a href="<?php echo get_the_permalink() ?>" title="<?php echo get_the_title() ?>">
                                                        <h2><?php the_title(); ?></h2>
                                                    </a>
                                                </div>
                                                <div class="product-metas">
                                                    <?php
                                                    $cats = get_the_terms(get_the_ID(), 'product_cat');
                                                    if ($cats) { ?>
                                                        <div class="product-cats">
                                                            <span><?php printf('%s :', esc_html__('Category', 'ahura')) ?></span>
                                                            <?php
                                                            $n = 0;
                                                            foreach ($cats as $cat) {
                                                                $n++;
                                                                $output = "<span>{$cat->name}</span>";
                                                                echo $output;
                                                                if ($n === 1){
                                                                    break;
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="price-wrap">
                                                    <?php woocommerce_template_single_price(); ?>
                                                </div>
                                            </div>
                                            <?php if ($has_features && $attributes): ?>
                                            <div class="pbc-after pri" style="display:none">
                                                <div class="features">
                                                    <h3><?php echo esc_html__('Features', 'ahura') ?></h3>
                                                    <ul>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($attributes as $attribute) {
                                                            if ($attribute->get_variation()) {
                                                                continue;
                                                            }
                                                            $i++;

                                                            if($i == 5) break;

                                                            echo '<li>';
                                                            $name = $attribute->get_name();
                                                            if ($attribute->is_taxonomy()) {
                                                                $terms = wp_get_post_terms($product->get_id(), $name, 'all');
                                                                $cwtax = $terms[0]->taxonomy;
                                                                $cw_object_taxonomy = get_taxonomy($cwtax);
                                                                if (isset ($cw_object_taxonomy->labels->singular_name)) {
                                                                    $tax_label = $cw_object_taxonomy->labels->singular_name;
                                                                } elseif (isset($cw_object_taxonomy->label)) {
                                                                    $tax_label = $cw_object_taxonomy->label;
                                                                    if (0 === strpos($tax_label, 'Product ')) {
                                                                        $tax_label = substr($tax_label, 8);
                                                                    }
                                                                }
                                                                echo $tax_label . ': ';
                                                                $tax_terms = array();
                                                                foreach ($terms as $term) {
                                                                    $single_term = esc_html($term->name);
                                                                    array_push($tax_terms, $single_term);
                                                                }
                                                                echo implode(', ', $tax_terms);
                                                            } else {
                                                                echo $name . ': ';
                                                                echo esc_html(implode(', ', $attribute->get_options()));
                                                            }
                                                            echo '</li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="pbc-after b" style="display:none">
                                                <div class="product-foot">
                                                    <a href="<?php echo get_the_permalink() ?>"><?php echo esc_html__('View Product', 'ahura') ?></a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                            <?php
                            endwhile;
                            wp_reset_query();
                            wp_reset_postdata();
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (is_admin()): ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        handleProductBoxCarouselElement();
                    });
                </script>
            <?php endif; ?>
        </div>
        <?php
    }
}
