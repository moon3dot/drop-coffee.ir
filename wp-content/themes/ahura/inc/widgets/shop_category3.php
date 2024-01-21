<?php

namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use ahura\app\traits\WoocommerceMethods;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class shop_category3 extends \Elementor\Widget_Base {
    use WoocommerceMethods;

    /**
     * @param $data
     * @param $args
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        mw_assets::register_style('shop_category4_css', mw_assets::get_css('elementor.shop_category4'));
        if(!is_rtl()){
            mw_assets::register_style('shop_category4_ltr_css', mw_assets::get_css('elementor.ltr.shop_category4_ltr'));
        }
    }

    public function get_style_depends() {
        $styles = [mw_assets::get_handle_name('shop_category4_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('shop_category4_ltr_css');
        }
        return $styles;
    }

    public function get_name() {
        return 'shop_category3';
    }

    public function get_title() {
        return __( 'Shop Category 3', 'ahura' );
    }

    public function get_icon() {
        return 'eicon-form-vertical';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['shop_category3', 'shopcategory3', esc_html__( 'Shop Category 3' , 'ahura')];
    }

    protected function register_controls() {
        if(!woocommerce::is_active())
            return false;

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
        foreach ( $categories as $category ) {
            $cats[ $category->slug ] = $category->name;
        }
        $default = key($cats);
        $this->add_control(
            'catsid',
            [
                'label'    => __( 'Category', 'ahura' ),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $cats,
                'label_block' => true,
                'multiple' => false,
                'default' => $default
            ]
        );

        $this->add_control(
            'count', [
                'label'      => __( 'Number of posts', 'ahura' ),
                'type'       => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'default'    => 6
            ]
        );

        $this->add_control(
            'only_offer_products',
            [
                'label'   => __( 'Show only discounted products', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes'  => [
                        'title' => __( 'Yes', 'ahura' ),
                        'icon' => 'eicon-check'
                    ],
                    'no' => [
                        'title' => __( 'No', 'ahura' ),
                        'icon' => 'eicon-editor-close'
                    ]
                ],
                'default' => 'no',
            ]
        );

        $this->add_control(
            'box_image',
            [
                'label' => esc_html__( 'Choose Image', 'ahura' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_template_directory_uri() . '/img/offer-icon.webp',
                ],
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
            'box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Amazing Supermarket', 'ahura'),
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_tag',
            [
                'label' => esc_html__( 'Show Tag', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'box_tag_text',
            [
                'label' => esc_html__('Tag Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Up to 33 percent discount', 'ahura'),
                'condition' => [
                    'show_tag' => 'yes'
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
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => __('More than 100 products', 'ahura'),
                'condition' => [
                        'show_btn' => 'yes'
                ]
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
                'condition' => [
                    'show_btn' => 'yes'
                ]
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
            'content_styles_section', [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#39ae00',
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
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '21',
                        ]
                    ]
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'img_options',
            [
                'label' => esc_html__( 'Images', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'selector' => '{{WRAPPER}} .product-item',
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
            ]
        );

        $this->add_responsive_control(
            'imgs_border_radius',
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
                    'size' => 50
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .product-item img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tag_options',
            [
                'label' => esc_html__( 'Tag', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_tag' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'tag_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .box-tag' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_tag' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tag_bg',
                'selector' => '{{WRAPPER}} .box-tag',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#39ae00'
                        ]
                ],
                'condition' => [
                    'show_tag' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'tag_border_radius',
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
                    'size' => 50
                ],
                'selectors' => [
                    '{{WRAPPER}} .box-tag' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_tag' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_btn_section', [
                'label' => __( 'Button', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#39ae00',
                'selectors' => [
                    '{{WRAPPER}} .archive-link' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_bg',
                'selector' => '{{WRAPPER}} .archive-link',
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
            ]
        );

        $this->add_responsive_control(
            'btn_border_radius',
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
                    'size' => 50
                ],
                'selectors' => [
                    '{{WRAPPER}} .archive-link' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles_section', [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .shop-category4-box',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#eef1f0'
                            ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .shop-category4-box',
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
                    '{{WRAPPER}} .shop-category4-box' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        $url = isset($settings['box_link']) ? $settings['box_link'] : [];

        if (!empty($url['url'])) {
            $this->add_link_attributes('box_link', $url);
        }

        $field_is_term = isset($settings['catsid']) ? (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']) : false;

        $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => isset($settings['count']) ? $settings['count'] : 6,
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => $field_is_term ? 'term_id' : 'slug',
                    'terms' => isset($settings['catsid']) ? $settings['catsid'] : '',
                ]
            ]
        ];

        if(isset($settings['only_offer_products']) && $settings['only_offer_products'] == 'yes'){
            $args = array_merge($args, [
                'meta_key' 		 => '_sale_price',
                'meta_value' 	 => '0',
                'meta_compare'   => '>'
            ]);
        }
        $products = new \WP_Query($args);
        ?>
        <div class="shop-category4-wrap">
            <div class="shop-category4-box">
                <div class="title-box">
                    <?php
                    if(isset($settings['box_image'])){
                        $this->add_render_attribute('image', 'src', $settings['box_image']['url']);
                        $this->add_render_attribute('image', 'alt', \Elementor\Control_Media::get_image_alt($settings['box_image']));
                        echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'full', 'box_image');
                    }
                    ?>
                    <div class="box-title">
                        <?php echo isset($settings['show_title']) && ($settings['show_title'] == 'yes') ? $settings['box_title'] : '' ?>
                        <?php if (isset($settings['show_tag']) && $settings['show_tag'] == 'yes'): ?>
                        <span class="box-tag"><?php echo $settings['box_tag_text'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="items-box">
                    <?php
                    if ($products->have_posts()):
                        while ($products->have_posts()): $products->the_post();
                        $sale_percent = $this->get_product_sale_percent();
                    ?>
                        <a href="<?php the_permalink() ?>" class="product-item">
                            <?php echo get_the_post_thumbnail(get_the_ID()) ?>
                            <?php if($sale_percent): ?>
                            <span class="percent-label"><?php echo $sale_percent ?>%</span>
                            <?php endif; ?>
                        </a>
                        <?php
                        endwhile;
                        endif; ?>
                    <?php if (isset($settings['show_btn']) && $settings['show_btn'] == 'yes'): ?>
                        <a <?php echo $this->get_render_attribute_string('box_link'); ?> class="archive-link">
                            <span><?php echo $settings['btn_text'] ?></span>
                            <i class="fa fa-arrow-<?php echo is_rtl() ? 'left' : 'right' ?>"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
