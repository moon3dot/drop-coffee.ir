<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class shop_category5 extends \Elementor\Widget_Base {
    /**
     * @param $data
     * @param $args
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        mw_assets::register_style('shop_category6_css', mw_assets::get_css('elementor.shop_category6'));
    }

    public function get_style_depends() {
        $styles = [mw_assets::get_handle_name('shop_category6_css')];
        return $styles;
    }

    public function get_name() {
        return 'shop_category5';
    }

    public function get_title() {
        return __( 'Shop Category 5', 'ahura' );
    }

    public function get_icon() {
        return 'eicon-form-vertical';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['shop_category5', 'shopcategory5', esc_html__( 'Shop Category 5' , 'ahura')];
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
        if (\ahura\app\woocommerce::is_active()) {
            $cats = [];
            foreach ( $categories as $category ) {
                $cats[$category->slug] = $category->name;
            }
            $default = key($cats);
        }

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Item Title', 'ahura'),
            ]
        );

        $repeater->add_control(
            'subtitle',
            [
                'label' => esc_html__('SubTitle', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Item SubTitle', 'ahura'),
            ]
        );

        $repeater->add_control(
            'cat_id',
            [
                'label'    => __( 'Category', 'ahura' ),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $cats,
                'label_block' => true,
                'multiple' => false,
                'default' => $default
            ]
        );

        $repeater->add_control(
            'count', [
                'label'      => __( 'Number of posts', 'ahura' ),
                'type'       => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 16,
                'default' => 4
            ]
        );

        $repeater->add_control(
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

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'placeholder' => site_url(),
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => ['url' => site_url()],
                'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'cats',
            [
                'label' => esc_html__('Categories', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{title}}}',
                'default' => [
                    ['cat_id' => $default],
                    ['cat_id' => $default],
                    ['cat_id' => $default],
                    ['cat_id' => $default],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'settings_section', [
                'label' => __( 'Settings', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'grid_num',
            [
                'label'    => __( 'Columns', 'ahura' ),
                'type'     => Controls_Manager::SELECT,
                'options'  => [
                        1 => __('1 Column', 'ahura'),
                        2 => __('2 Column', 'ahura'),
                        3 => __('3 Column', 'ahura'),
                        4 => __('4 Column', 'ahura'),
                        5 => __('5 Column', 'ahura'),
                ],
                'label_block' => true,
                'multiple' => false,
                'default' => 4
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
            'show_subtitle',
            [
                'label' => esc_html__( 'Show SubTitle', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
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
            'button_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('View', 'ahura'),
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-left',
                    'library' => 'fa-solid',
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
            'content_style_section',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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

        $this->add_control(
            'title_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .cat-title-wrap' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#202020',
                'selectors' => [
                    '{{WRAPPER}} .cat-title h4' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('SubTitle Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#5e5e5e',
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_subtitle' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .cat-title h4',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '18',
                        ]
                    ]
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('SubTitle Typography', 'ahura'),
                'name' => 'subtitle_typo',
                'selector' => '{{WRAPPER}} .subtitle',
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
                'condition' => [
                    'show_subtitle' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_styles',
            [
                'label' => esc_html__('Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .cat-foot' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'btn_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cat-foot a i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .cat-foot a svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Button Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#19bfd3',
                'selectors' => [
                    '{{WRAPPER}} .cat-foot a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'btn_typo',
                'selector' => '{{WRAPPER}} .cat-foot a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 300],
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

        $this->end_controls_section();

        $this->start_controls_section(
            'box_style_section',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_bg',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .cat-item, {{WRAPPER}} .cat-products a, {{WRAPPER}} .cat-products .cat-product.is-empty' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .shop-category5-wrap',
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
                    'color' => ['default' => '#e0e0e6']
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
                    '{{WRAPPER}} .shop-category5-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'inner_border_styles',
            [
                'label' => esc_html__('Inner Border', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'inner_border_color',
            [
                'label' => esc_html__('Border Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f1f2f4',
                'selectors' => [
                    '{{WRAPPER}} .category-items' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .cat-products' => 'background-color: {{VALUE}}',
                ],
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

        $cats = $settings['cats'];
        ?>
        <div class="shop-category5-wrap">
            <div class="category-items use-grid-template grd-<?php echo isset($settings['grid_num']) ? $settings['grid_num'] : 4 ?>">
                <?php
                foreach ($cats as $cat):
                    $has_link = !empty($cat['link']['url']);
                    if ($has_link) {
                        $this->add_link_attributes('link_' . $cat['_id'], $cat['link']);
                    }

                    $args = [
                        'post_type'      => 'product',
                        'post_status'    => 'publish',
                        'posts_per_page' => isset($cat['count']) ? $cat['count'] : 4,
                        'tax_query' => [
                            [
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => [(isset($cat['cat_id']) ? $cat['cat_id'] : 0)],
                            ]
                        ]
                    ];

                    if(isset($cat['only_offer_products']) && $cat['only_offer_products'] == 'yes'){
                        $args = array_merge($args, [
                            'meta_key' 		 => '_sale_price',
                            'meta_value' 	 => '0',
                            'meta_compare'   => '>'
                        ]);
                    }

                    $products = new \WP_Query($args);
                    ?>
                <div class="cat-item">
                    <div class="cat-item-top">
                        <div class="cat-title-wrap">
                            <?php if (isset($settings['show_title']) && $settings['show_title'] == 'yes'): ?>
                                <div class="cat-title">
                                    <h4><?php echo $cat['title'] ?></h4>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($settings['show_subtitle']) && $settings['show_subtitle'] == 'yes'): ?>
                                <p class="subtitle"><?php echo $cat['subtitle'] ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if ($products->have_posts()): ?>
                            <div class="cat-products-wrap">
                                <div class="cat-products cp-<?php echo $products->post_count ?>">
                                    <?php while ($products->have_posts()): $products->the_post(); ?>
                                        <a href="<?php the_permalink() ?>" class="cat-product">
                                    <span class="cp-img">
                                        <?php echo get_the_post_thumbnail(get_the_ID()) ?>
                                    </span>
                                        </a>
                                    <?php
                                    endwhile;
                                    wp_reset_query();
                                    ?>
                                    <div class="cat-product is-empty"></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($settings['show_btn']) && $settings['show_btn'] == 'yes'): ?>
                    <div class="cat-foot">
                        <a <?php echo $this->get_render_attribute_string('link_' . $cat['_id']); ?>>
                            <?php echo $settings['button_text'] ?>
                            <?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
