<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class shop_category6 extends \Elementor\Widget_Base {
    /**
     * @param $data
     * @param $args
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        mw_assets::register_style('shop_category7_css', mw_assets::get_css('elementor.shop_category7'));
        if(!is_rtl()){
            mw_assets::register_style('shop_category7_ltr_css', mw_assets::get_css('elementor.ltr.shop_category7_ltr'));
        }
    }

    public function get_style_depends() {
        $styles = [mw_assets::get_handle_name('shop_category7_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('shop_category7_ltr_css');
        }
        return $styles;
    }

    public function get_name() {
        return 'shop_category6';
    }

    public function get_title() {
        return __( 'Shop Category 6', 'ahura' );
    }

    public function get_icon() {
        return 'eicon-form-vertical';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['shop_category6', 'shopcategory6', esc_html__( 'Shop Category 6' , 'ahura')];
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

        $categories = get_terms( [
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ] );
        $cats = [];
        foreach ( $categories as $category ) {
            $cats[$category->slug] = $category->name;
        }
        $default = key($cats);
        $this->add_control(
            'catsid',
            [
                'label'    => __( 'Categories', 'ahura' ),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $cats,
                'label_block' => true,
                'multiple' => true,
                'default' => $default
            ]
        );

        $this->add_control(
            'count', [
                'label'      => __( 'Number of posts', 'ahura' ),
                'type'       => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 40,
                'default' => 8
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

        $this->add_control('divider1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'ahura' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_template_directory_uri() . '/img/ahura-plus.webp',
                ],
            ]
        );

        $this->add_control(
            'box_des',
            [
                'label' => esc_html__( 'Description', 'ahura' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Special services for Ahura Plus members', 'ahura' ),
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
                'default' => esc_html__( 'Register', 'ahura' ),
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
            'btn_icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-arrow-left',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'products_content_section', [
                'label' => __( 'Products Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'box_icon2',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-rocket',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'box_title2',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Free Immediate Shipping', 'ahura' ),
            ]
        );

        $this->add_control(
            'show_btn2',
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
            'btn_text2',
            [
                'label' => esc_html__( 'Button Text', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'View All', 'ahura' ),
                'condition' => [
                    'show_btn2' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_link2',
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
            'btn_icon2',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-angle-left',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_btn2' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Styles
         *
         *
         */
        $this->start_controls_section(
            'details_box_style_section',
            [
                'label' => __( 'Details Box', 'ahura' ),
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

        $this->add_control(
            'd_box_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => (is_rtl() ? 'right' : 'left'),
                'selectors' => [
                    '{{WRAPPER}} .box-details' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'd_box_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .box-details' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .box-details .box-title',
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
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'd_box_bg',
                'selector' => '{{WRAPPER}} .box-details',
                'fields_options' =>
                    [
                        'background' => ['default' => 'classic'],
                        'image' => [
                            'default' => ['url'	=> get_template_directory_uri() . '/img/plus-widget.webp'],
                        ],
                        'size' => ['default' => 'initial'],
                        'position' => ['default' => 'bottom ' . (is_rtl() ? 'left' : 'right')],
                        'repeat' => ['default' => 'no-repeat'],
                        'bg_width' => ['default' => [
                                'unit' => '%',
                                'size' => 95
                        ]],
                    ]
            ]
        );

        $this->add_control('divider2', ['type' => Controls_Manager::DIVIDER]);

        $this->add_responsive_control(
            'd_box_border_radius',
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
                    '{{WRAPPER}} .box-details' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'btn_options',
            [
                'label' => esc_html__( 'Button', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                        'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .box-btns a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .box-btns a',
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'selector' => '{{WRAPPER}} .box-btns a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 400],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ]
                    ]
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
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
                    'size' => 7
                ],
                'selectors' => [
                    '{{WRAPPER}} .box-btns a' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .box-btns a',
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
                    'color' => ['default' => '#fff']
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'products_box_style_section',
            [
                'label' => __( 'Products Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'p_icon_size',
            [
                'label' => esc_html__( 'Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .bp-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .bp-title svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'p_box_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#354ac4',
                'selectors' => [
                    '{{WRAPPER}} .bp-title i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .bp-title svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'p_box_text_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .bp-title h4' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title2_typo',
                'selector' => '{{WRAPPER}} .bp-title h4',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 500],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16',
                        ]
                    ]
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'p_box_bg',
                'selector' => '{{WRAPPER}} .box-products-wrap',
                'fields_options' =>
                    [
                        'background' => ['default' => 'classic'],
                        'color' => [
                            'default' => '#fff',
                        ],
                    ]
            ]
        );

        $this->add_control('divider3', ['type' => Controls_Manager::DIVIDER]);

        $this->add_responsive_control(
            'p_box_border_radius',
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
                    'size' => 8
                ],
                'selectors' => [
                    '{{WRAPPER}} .box-products-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'btn2_options',
            [
                'label' => esc_html__( 'Button', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_btn2' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn2_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#354ac4',
                'selectors' => [
                    '{{WRAPPER}} .bp-btns a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_btn2' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn2_typo',
                'selector' => '{{WRAPPER}} .bp-btns a',
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
                    'show_btn2' => 'yes'
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
                'selector' => '{{WRAPPER}} .shop-category6-wrap',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#354ac4'
                            ]
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
                    '{{WRAPPER}} .shop-category6-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .shop-category6-wrap',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
		if( !\ahura\app\woocommerce::is_active() ) return;

        if ( ! empty( $settings['btn_link']['url'] ) ) {
            $this->add_link_attributes( 'btn_link', $settings['btn_link'] );
        }

        if ( ! empty( $settings['btn_link2']['url'] ) ) {
            $this->add_link_attributes( 'btn_link2', $settings['btn_link2'] );
        }

        $field_is_term = (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);

        $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => isset($settings['count']) ? $settings['count'] : 8,
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => $field_is_term ? 'term_id' : 'slug',
                    'terms' => $settings['catsid'],
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
        <div class="shop-category6-wrap">
            <div class="shop-category6-box">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="box-details">
                            <div class="box-icon">
                                <?php
                                if(isset($settings['image'])){
                                    if(!empty($settings['image']['id'])){
                                        echo wp_get_attachment_image( $settings['image']['id'], 'full' );
                                    } else {
                                        echo '<img src="' . $settings['image']['url'] . '">';
                                    }
                                }
                                ?>
                            </div>
                            <div class="box-title"><?php echo $settings['box_des'] ?></div>
                            <?php if(isset($settings['show_btn']) && $settings['show_btn'] == 'yes'): ?>
                                <div class="box-btns">
                                    <a <?php echo $this->get_render_attribute_string( 'btn_link' ); ?>>
                                        <?php echo $settings['btn_text'] ?>
                                        <?php \Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="box-products-wrap">
                            <div class="bp-title-wrap">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="bp-title text-<?php echo is_rtl() ? 'right' : 'left' ?>">
                                            <?php
                                            if (isset($settings['box_icon2'])){
                                                \Elementor\Icons_Manager::render_icon( $settings['box_icon2'], [ 'aria-hidden' => 'true' ] );
                                            }
                                            ?>
                                            <h4><?php echo $settings['box_title2'] ?></h4>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <?php if(isset($settings['show_btn2']) && $settings['show_btn2'] == 'yes'): ?>
                                            <div class="bp-btns text-<?php echo is_rtl() ? 'left' : 'right' ?>">
                                                <a <?php echo $this->get_render_attribute_string( 'btn_link2' ); ?>>
                                                    <?php echo $settings['btn_text2'] ?>
                                                    <?php \Elementor\Icons_Manager::render_icon( $settings['btn_icon2'], [ 'aria-hidden' => 'true' ] ); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="box-products">
                                <?php if ($products->have_posts()): ?>
                                <div class="row">
                                    <?php while ($products->have_posts()): $products->the_post(); ?>
                                    <div class="col-6 col-md-3">
                                        <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" class="product-item">
                                            <?php echo get_the_post_thumbnail(get_the_ID()) ?>
                                        </a>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                                <?php else: ?>
                                <div class="ahura-element-not-found-msg">
                                    <?php echo __('No products found, select a category.', 'ahura') ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
