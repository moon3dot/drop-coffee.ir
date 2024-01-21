<?php
namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class brands extends \Elementor\Widget_Base
{
    /**
     * brands constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_style('brands_css', mw_assets::get_css('elementor.brands'));
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'));
        mw_assets::register_script('brands_js', mw_assets::get_js('elementor.brands'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('swipercss'), mw_assets::get_handle_name('brands_css')];
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('brands_js')];
    }

    public function get_name()
    {
        return 'ahura_brands';
    }

    public function get_title()
    {
        return esc_html__('Brands', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-carousel';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['brands', esc_html__('Brands', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
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
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Brands', 'ahura'),
                'condition' => [
                        'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'brand_logo',
            [
                'label' => esc_html__('Choose Logo', 'ahura'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'website_link',
            [
                'label' => esc_html__( 'Link', 'ahura' ),
                'type' => Controls_Manager::URL,
                'placeholder' => site_url(),
                'dynamic' => ['active' => true],
                'options' => ['url', 'is_external', 'nofollow'],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'brands',
            [
                'label' => esc_html__('Brands', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'brand_logo' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    [
                        'brand_logo' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    [
                        'brand_logo' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ],
            ]
        );

        
        $this->add_responsive_control(
            'slides_per_view',
            [
                'label' => esc_html__('Slides per view', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                ],
                'default' => 3,
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Pagination', 'ahura'),
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

        $this->start_controls_tabs('style_tabs');

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'item_border_color',
            [
                'label' => esc_html__('Border Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide' => 'border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'brand_css_filters',
                'selector' => '{{WRAPPER}} .brand-item img',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'brand_css_filters_hover',
                'selector' => '{{WRAPPER}} .swiper-slide:hover img',
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
                'selector' => '{{WRAPPER}} .ahura-brands-wrap',
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
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .ahura-brands-wrap',
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
                    '{{WRAPPER}} .ahura-brands-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_options',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#323232',
                'selectors' => [
                    '{{WRAPPER}} .brands-title' => 'color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .brands-title',
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
            'icon_options',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffbd44',
                'selectors' => [
                    '{{WRAPPER}} .brands-title i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .brands-title :is(svg, path)' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .brands-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .brands-title svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_title' => 'yes'
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

        $has_paginate = ($settings['show_pagination'] == 'yes');
        $brands = $settings['brands'];
        ?>
        <div class="ahura-brands-wrap">
            <div class="brands-title">
                <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                <span><?php echo $settings['title'] ?></span>
            </div>
            <div class="brands-list-<?php echo $wid; ?><?php echo $has_paginate ? ' has-paginate' : '' ?>"">
                <div class="swiper brands-list-swiper">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($brands as $brand):
                            $has_link = !empty($brand['website_link']['url']);
                            if ($has_link) {
                                $this->add_link_attributes('website_link_' . $brand['_id'], $brand['website_link']);
                            }
                            ?>
                            <div class="swiper-slide">
                                <div class="brand-item">
                                    <?php if ($has_link): ?>
                                    <a <?php echo $this->get_render_attribute_string('website_link_' . $brand['_id']); ?>>
                                    <?php endif; ?>
                                        <?php
                                        $logo = $brand['brand_logo'];
                                        if(!empty($logo['id']) && !empty(wp_get_attachment_url($logo['id']))){
                                            echo wp_get_attachment_image($logo['id'], 'full');
                                        } else { ?>
                                            <img src="<?php echo $logo['url'] ?>" alt="<?php _e('Brand', 'ahura') ?>">
                                        <?php } ?>
                                    <?php if ($has_link): ?>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if($has_paginate): ?>
                        <div class="swiper-pagination"></div>
                    <?php endif; ?>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    handleBrandsElement({
                        widgetID: '<?php echo $wid; ?>',
                        desktopPerView: <?php echo (isset($settings['slides_per_view']) && intval($settings['slides_per_view'])) ? $settings['slides_per_view'] : 3 ?>,
                        tabletPerView: <?php echo (isset($settings['slides_per_view_tablet']) && intval($settings['slides_per_view_tablet'])) ? $settings['slides_per_view_tablet'] : 2 ?>,
                        mobilePerView: <?php echo (isset($settings['slides_per_view_mobile']) && intval($settings['slides_per_view_mobile'])) ? $settings['slides_per_view_mobile'] : 1 ?>,
                        pagination: <?php echo $has_paginate ? 'true' : 'false' ?>,
                    });
                });
            </script>
        </div>
        <?php
    }
}