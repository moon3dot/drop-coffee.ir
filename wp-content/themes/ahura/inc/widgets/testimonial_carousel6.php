<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class testimonial_carousel6 extends \Elementor\Widget_Base
{
    /**
     * testimonial_carousel6 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('testimonial_carousel6_css', mw_assets::get_css('elementor.testimonial_carousel6'));
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));

        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'), false);
        mw_assets::register_script('testimonial_carousel6_js', mw_assets::get_js('elementor.testimonial_carousel6'));

        if(!is_rtl()){
            mw_assets::register_style('testimonial_carousel6_ltr_css', mw_assets::get_css('elementor.ltr.testimonial_carousel6_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('testimonial_carousel6_css'), mw_assets::get_handle_name('swipercss')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('testimonial_carousel6_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('testimonial_carousel6_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'testimonial_carousel6';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Testimonial Carousel 6', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-testimonial-carousel';
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
    public function get_keywords()
    {
        return ['testimonialcarousel6', 'testimonial_carousel6', esc_html__('Testimonial Carousel 6', 'ahura')];
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
         * Start content section
         *
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'testimonial_bycat_byids',
			[
				'label' => esc_html__( 'Testimonial query by', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'byids',
				'options' => [
					'byids' => esc_html__( 'By Ids', 'ahura' ),
					'bycat' => esc_html__( 'By Category', 'ahura' ),
				],
			]
		);

        $testimonial_cats = get_categories(['taxonomy' => 'testimonial_cat', 'orderby' => 'name', 'order' => 'ASC']);
        
        $testimonial_cats_options = [];
        if ($testimonial_cats) {
            foreach ($testimonial_cats as $item) {
                $testimonial_cats_options[$item->term_id] = $item->cat_name;
            }
        }

        $this->add_control(
			'testimonial_bycat',
			[
				'label' => esc_html__( 'Select category', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $testimonial_cats_options,
                'condition' => [
                    'testimonial_bycat_byids' => 'bycat',
                ],
			]
		);

        $repeater = new \Elementor\Repeater();

        $items = get_posts(['post_type' => 'testimonial', 'numberposts' => -1]);
        $options = [];
        if ($items) {
            foreach ($items as $item) {
                $options[$item->ID] = $item->post_title;
            }
        }

        $default = ($options && is_array($options)) ? key($options) : false;

        $repeater->add_control(
            'tst_id',
            [
                'type' => Controls_Manager::SELECT2,
                'label' => esc_html__('Select', 'ahura'),
                'label_block' => true,
                'options' => $options,
                'default' => $default
            ]
        );

        $repeater->add_control(
            'show_rate',
            [
                'label' => esc_html__('Show Rate', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'rate',
            [
                'label' => esc_html__('Rate', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 0.1,
                'default' => 5,
                'condition' => [
                    'show_rate' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'show_rate_num',
            [
                'label' => esc_html__('Show Number', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
			'testimonials',
			[
				'label' => esc_html__('Testimonial', 'ahura'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tst_id' => $default,
                        'rate' => 5
					],
				],
				'title_field' => '{{{tst_id}}}',
                'condition' => [
                    'testimonial_bycat_byids' => 'byids',
                ],
			]
		);

        $this->end_controls_section();
        
        $this->start_controls_section(
            'content_settings',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
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
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                ],
                'default' => 3,
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

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'ahura'),
                    'default' => esc_html__('Dots', 'ahura'),
                    'fraction' => esc_html__('Fraction', 'ahura'),
                    'progressbar' => esc_html__('Progress', 'ahura'),
                ],
                'default' => 'default',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label' => esc_html__('Transition Duration', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 2500,
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label' => esc_html__('Infinite Loop', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
        /*
         *
         *
         *
         * Start style section
         *
         */

        $this->start_controls_section(
            'box_avatar_style',
            [
                'label' => esc_html__('Avatar', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'box_avatar_size',
            [
                'label' => esc_html__('Avatar Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .head .avatar img' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 74
                ],
            ]
        );

        $this->add_control(
            'box_avatar_radius',
            [
                'label' => esc_html__('Avatar Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .head .avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_avatar_shadow',
                'label' => esc_html__('Avatar Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .head .avatar img',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 17,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.13)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_head_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_title_padding',
            [
                'label' => esc_html__('Title Box Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 0,
                    'right' => 10,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px'
                ]
            ]
        );

        $this->add_control(
            'box_stars_color',
            [
                'label' => esc_html__('Stars color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff9d00',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .meta .rate .stars span.checked' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_untracked_stars_color',
            [
                'label' => esc_html__('Untracked Stars color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0E0E0',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .meta .rate .stars span' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .head .name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_subtitle_color',
            [
                'label' => esc_html__('SubTitle color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#bfbfbf',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .head .site-name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .head .name',
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
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_subtitle_typo',
                'label' => esc_html__('SubTitle Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .head .site-name',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * #### End title style
         *
         *
         * Start content styles
         *
         *
         */
        $this->start_controls_section(
            'box_content_style',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_content_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#979797',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .content' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_content_typo',
                'selector' => '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .content',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ]
            ]
        );

        $this->add_control(
            'box_content_margin',
            [
                'label' => esc_html__('Content Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'allowed_dimensions' => ['top', 'bottom'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 18,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ]
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Start box style
         *
         */


        $this->start_controls_section(
            'box_wrap_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_wrap_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 17,
                    'right' => 17,
                    'bottom' => 17,
                    'left' => 17,
                ]
            ]
        );

        $this->add_control(
            'box_wrap_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 23,
                    'right' => 23,
                    'bottom' => 23,
                    'left' => 23,
                ]
            ]
        );

        $this->add_control('hr', ['type' => \Elementor\Controls_Manager::DIVIDER,]);

        $this->add_responsive_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 15,
                        'max' => 70
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40
                ],
            ]
        );

        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff9d00',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .icon svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_icon_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-6 .testimonial-carousel-item-content .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .testimonial-carousel-item-content',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'default' => '#f0f0f0',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'box_navigation_style',
            [
                'label' => esc_html__('Navigation', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'nav_options',
			[
				'label' => esc_html__('Navigation', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'box_nav_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel .tc-swiper-button-next, {{WRAPPER}} .testimonial-carousel .tc-swiper-button-prev' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
			'paginate_options',
			[
				'label' => esc_html__('Pagination', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'box_paginate_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00000087',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel .tc-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .testimonial-carousel .tc-swiper-pagination.swiper-pagination-progressbar' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_paginate_active_color',
            [
                'label' => esc_html__('Active Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel .tc-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet-active' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .testimonial-carousel .tc-swiper-pagination.swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
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
        $items_byids = $settings['testimonials'];
        $rare_items_bycat = $settings['testimonial_bycat'];

        $items_bycat = [];

        $posts_bycat = get_posts( [
            'posts_per_page'    => -1,
            'post_type'         => 'testimonial',
            'tax_query'         => [['taxonomy' => 'testimonial_cat', 'field' => 'term_id', 'terms' => $rare_items_bycat]]
        ]);

        if($items_byids) {
            $items = $items_byids;
        }

        if($rare_items_bycat){
            foreach($posts_bycat as $index => $post) {
                $items_bycat[$index]['tst_id'] = $post->ID;
                $items_bycat[$index]['show_rate'] = 'no';
                $items_bycat[$index]['rate'] = 5;
            }
            $items = $items_bycat;
        }

        if (!$items) {
            return false;
        }

        $has_paginate = ($settings['pagination'] == 'yes' || $settings['pagination'] != 'none');
        $has_navigate = ($settings['show_arrows'] == 'yes');
        ?>
        <div class="testimonial-carousel testimonial-carousel-6<?php echo $has_paginate ? ' has-paginate-' . $settings['pagination'] : '' ?><?php echo $has_navigate ? ' has-navigate' : '' ?>">
            <div class="swiper testimonial-carousel-6-<?php echo $wid; ?>">
                <div class="swiper-wrapper">
                <?php
                foreach($items as $item):
                    $name = \ahura\app\mw_options::get_testimonial_username($item['tst_id']);
                    $site_name = \ahura\app\mw_options::get_testimonial_sitename($item['tst_id']);
                    $avatar_url = get_the_post_thumbnail_url($item['tst_id'], 'thumbnail');
                    $content = get_post_field('post_content', $item['tst_id']);

                    $star_rate = $item['rate'];
                ?>
                <div class="swiper-slide">
                    <div class="testimonial-carousel-item-wrap">
                        <div class="ahura-testimonial testimonial-carousel-item">
                            <div class="testimonial-carousel-item-content">
                            <div class="icon">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0" fill="none" width="24" height="24"/>
                                    <g>
                                        <path d="M11.192 15.757c0-.88-.23-1.618-.69-2.217-.326-.412-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.1-1.956.76-3.022.66-1.065 1.515-1.867 2.558-2.403L9.373 5c-.8.396-1.56.898-2.26 1.505-.71.607-1.34 1.305-1.9 2.094s-.98 1.68-1.25 2.69-.346 2.04-.217 3.1c.168 1.4.62 2.52 1.356 3.35.735.84 1.652 1.26 2.748 1.26.965 0 1.766-.29 2.4-.878.628-.576.94-1.365.94-2.368l.002.003zm9.124 0c0-.88-.23-1.618-.69-2.217-.326-.42-.77-.692-1.327-.817-.56-.124-1.074-.13-1.54-.022-.16-.94.09-1.95.75-3.02.66-1.06 1.514-1.86 2.557-2.4L18.49 5c-.8.396-1.555.898-2.26 1.505-.708.607-1.34 1.305-1.894 2.094-.556.79-.97 1.68-1.24 2.69-.273 1-.345 2.04-.217 3.1.165 1.4.615 2.52 1.35 3.35.732.833 1.646 1.25 2.742 1.25.967 0 1.768-.29 2.402-.876.627-.576.942-1.365.942-2.368v.01z"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="head">
                                <div class="avatar">
                                    <img src="<?php echo $avatar_url ?>" alt="<?php echo $name ?>">
                                </div>
                                <div class="meta">
                                    <div class="name"><?php echo $name ?></div>
                                    <div class="site-name"><?php echo $site_name ?></div>
                                    <?php if ($item['show_rate'] === 'yes' && $star_rate): ?>
                                        <div class="rate">
                                            <?php if($items_byids && $item['show_rate_num'] === 'yes'): ?>
                                                <div class="num"><?php echo $star_rate ?></div>
                                            <?php endif; ?>
                                            <div class="stars">
                                                <?php
                                                for ($i = 0; $i <= $star_rate; $i++) {
                                                    if ($i >= 5) {
                                                        break;
                                                    }
                                                    $checked = ($i < 5 && $i < $star_rate) ? 'checked' : '';
                                                    if ($checked) {
                                                        echo '<span class="fa fa-star ' . $checked . '"></span>';
                                                    }
                                                }
                                                if ($i <= 5) {
                                                    for ($n = 1; $n <= 5 - $star_rate; $n++) {
                                                        echo '<span class="fa fa-star"></span>';
                                                    }
                                                } ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="content"><?php echo $content ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
                <?php if($has_paginate): ?>
                    <div class="tc-swiper-pagination"></div>
                <?php endif; ?>
                <?php if($has_navigate): ?>
                    <div class="swiper-nav-button tc-swiper-button-prev"><i class="fas fa-angle-right"></i></div>
                    <div class="swiper-nav-button tc-swiper-button-next"><i class="fas fa-angle-left"></i></div>
                <?php endif; ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        handleTestimonialCarousel6Element({
                            widgetID: '<?php echo $wid ?>',
                            loop: <?php echo $settings['infinite_loop'] == 'yes' ? 'true' : 'false' ?>,
                            slidesPerView: <?php echo (isset($settings['slides_per_view']) && intval($settings['slides_per_view'])) ? $settings['slides_per_view'] : 3 ?>,
                            mobilePerView: <?php echo (isset($settings['slides_per_view_mobile']) && intval($settings['slides_per_view_mobile'])) ? $settings['slides_per_view_mobile'] : 1 ?>,
                            tabletPerView: <?php echo (isset($settings['slides_per_view_tablet']) && intval($settings['slides_per_view_tablet'])) ? $settings['slides_per_view_tablet'] : 2 ?>,
                            autoPlay: <?php echo $settings['autoplay'] == 'yes' ? 'true' : 'false' ?>,
                            transitionDuration: <?php echo (intval($settings['transition_duration'])) ? $settings['transition_duration'] : 2500 ?>,
                            showPagination: <?php echo $has_paginate ? 'true' : 'false' ?>,
                            paginationType: '<?php echo $settings['pagination'] ?>',
                            navigation: <?php echo $has_navigate ? 'true' : 'false' ?>,
                        });
                    });
                </script>
            </div>
        </div>
        <?php
    }
}