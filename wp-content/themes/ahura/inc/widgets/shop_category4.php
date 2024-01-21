<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use ahura\app\traits\WoocommerceMethods;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class shop_category4 extends \Elementor\Widget_Base {
    use WoocommerceMethods;

    /**
     * @param $data
     * @param $args
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_style('shop_category5_css', mw_assets::get_css('elementor.shop_category5'));
        if(!is_rtl()){
            mw_assets::register_style('shop_category5_ltr_css', mw_assets::get_css('elementor.ltr.shop_category5_ltr'));
        }
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'), false);
    }

    public function get_style_depends() {
        $styles = [mw_assets::get_handle_name('swipercss'), mw_assets::get_handle_name('shop_category5_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('shop_category5_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs')];
    }

    public function get_name() {
        return 'shop_category4';
    }

    public function get_title() {
        return __( 'Shop Category 4', 'ahura' );
    }

    public function get_icon() {
        return 'eicon-form-vertical';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['shop_category4', 'shopcategory4', esc_html__( 'Shop Category 4' , 'ahura')];
    }

    protected function register_controls() {
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
        $default = [];

        if (\ahura\app\woocommerce::is_active()) {
            if ($categories){
                foreach ( $categories as $category ) {
                    $cats[$category->slug] = $category->name;
                }
            }
            
            $default = key($cats);

            if(count($cats) >= 4){
                $keys = array_keys($cats);
                $default = [$keys[0], $keys[1], $keys[2], $keys[3]];
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
                'default' => $default
            ]
        );

        $this->add_control(
            'show_cover',
            [
                'label' => esc_html__( 'Show Cover', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
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
            'cover_styles',
            [
                'label' => esc_html__('Image', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_cover' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'cover_border_radius',
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
                    '{{WRAPPER}} .cat-cover' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_cover' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'title_styles',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('style_tabs');

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .cat-title' => 'color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .cat-title',
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
                'name' => 'item_bg',
                'selector' => '{{WRAPPER}} .term-item a',
                'exclude' => ['image'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'item_title_color_hover',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .term-item:hover .cat-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_bg_hover',
                'selector' => '{{WRAPPER}} .term-item:hover a',
                'exclude' => ['image']
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
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
                'selector' => '{{WRAPPER}} .category-list',
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
                'selector' => '{{WRAPPER}} .category-list',
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
                    '{{WRAPPER}} .category-list ' => 'border-radius: {{SIZE}}{{UNIT}};',
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
            'inner_border_width',
            [
                'label' => esc_html__( 'Border Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide:not(:first-child)' => 'border-right-width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-slide .term-item:not(:first-child)' => 'border-top-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'inner_border_color',
            [
                'label' => esc_html__('Border Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f1f2f4',
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide:not(:first-child)' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .swiper-slide .term-item:not(:first-child)' => 'border-color: {{VALUE}}',
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

        $has_navigate = $settings['show_arrows'] == 'yes';

        $cat_ids = (array) $settings['catsid'];
        $ids = [];
        if(!empty($cat_ids)){
            for ($i = 0; $i < count($cat_ids); $i += 2) {
                $ids[] = [$cat_ids[$i], (isset($cat_ids[$i+1]) ? $cat_ids[$i+1] : null)];
            }
        }
        ?>
        <div class="shop-category4-wrap">
            <div class="category-list">
                <div class="swiper shop-category4-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($ids as $cat): ?>
                            <div class="swiper-slide">
                                <?php
                                foreach($cat as $value):
                                    if (empty($value))
                                        continue;

                                    $term = get_term_by('slug', $value, 'product_cat');
                                    if(is_wp_error($term))
                                        continue;

                                    $term_thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                                    $term_link = get_term_link($term->term_id);
                                ?>
                                <div class="term-item">
                                    <a href="<?php echo !is_wp_error($term_link) ? $term_link : '' ?>" class="cat-item">
                                        <?php if ($settings['show_cover'] == 'yes'): ?>
                                        <div class="cat-cover">
                                            <?php echo wp_get_attachment_image($term_thumb_id); ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php if ($settings['show_title'] == 'yes'): ?>
                                        <div class="cat-title">
                                            <?php echo $term->name ?>
                                        </div>
                                        <?php endif; ?>
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
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    var sc4_swiper = new Swiper(".shop-category4-swiper", {
                        slidesPerView: 2,
                        spaceBetween: 0,
                        freeMode: true,
                        <?php if ($has_navigate): ?>
                        navigation: {
                            nextEl: ".swiper-btn-next",
                            prevEl: ".swiper-btn-prev",
                        },
                        <?php endif; ?>
                        rtl: $('body').hasClass('rtl'),
                        breakpoints: {
                            640: {
                                slidesPerView: 3,
                            },
                            768: {
                                slidesPerView: 5,
                            },
                            1024: {
                                slidesPerView: 7,
                            },
                        },
                    });
                });
            </script>
        </div>
        <?php
    }
}
