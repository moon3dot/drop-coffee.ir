<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class testimonial_carousel7 extends \Elementor\Widget_Base
{
    /**
     * testimonial_carousel7 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('testimonial_carousel7_css', mw_assets::get_css('elementor.testimonial_carousel7'));
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));

        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'), false);
        mw_assets::register_script('testimonial_carousel7_js', mw_assets::get_js('elementor.testimonial_carousel7'));

        if(!is_rtl()){
            mw_assets::register_style('testimonial_carousel7_ltr_css', mw_assets::get_css('elementor.ltr.testimonial_carousel7_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('testimonial_carousel7_css'), mw_assets::get_handle_name('swipercss')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('testimonial_carousel7_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('testimonial_carousel7_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'testimonial_carousel7';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Testimonial Carousel 7', 'ahura');
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
        return ['testimonialcarousel7', 'testimonial_carousel7', esc_html__('Testimonial Carousel 7', 'ahura')];
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
                    '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .content' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_content_typo',
                'selector' => '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .content',
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
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
         * #### End content style
         *
         *
         * Start meta styles
         *
         *
         */
        $this->start_controls_section(
            'meta_content_style',
            [
                'label' => esc_html__('Meta', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'name_content_color',
            [
                'label' => esc_html__('Name Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#979797',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_content_typo',
                'selector' => '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .name',
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
            'name_content_margin',
            [
                'label' => esc_html__('Name Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 18,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
				'separator' => 'after',
            ]
        );

        $this->add_control(
            'position_content_color',
            [
                'label' => esc_html__('Position Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#979797',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .site-name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'position_content_typo',
                'selector' => '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .site-name',
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
            'position_content_margin',
            [
                'label' => esc_html__('Position Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content .site-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 18,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],

            ]
        );

        $this->end_controls_section();
        
        /**
         * End meta style
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
                    '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
			'box_vertical_alignment',
			[
				'label' => esc_html__( 'Box vertical alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'space-between',
				'options' => [
					'start' => esc_html__( 'Start', 'ahura' ),
					'space-between' => esc_html__( 'Space between', 'ahura' ),
					'space-evenly' => esc_html__( 'Space evenly', 'ahura' ),
					'space-around' => esc_html__( 'Space around', 'ahura' ),
					'end' => esc_html__( 'End', 'ahura' ),
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content' => 'justify-content: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'img_vs_content_size',
			[
				'label' => esc_html__( 'Content size relative to image', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Normal', 'ahura' ),
					'2' => esc_html__( 'Big', 'ahura' ),
					'3' => esc_html__( 'Very big', 'ahura' ),
					'4' => esc_html__( 'Enormous', 'ahura' ),
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial-carousel-7 .testimonial-carousel-item-content' => 'flex: {{VALUE}};',
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
        ?>
        <div class="testimonial-carousel testimonial-carousel-7<?php echo $has_paginate ? ' has-paginate-' . $settings['pagination'] : '' ?>">
            <div class="swiper testimonial-carousel-7-<?php echo $wid; ?>">
                <div class="swiper-wrapper">
                <?php
                foreach($items as $item):
                    $name = \ahura\app\mw_options::get_testimonial_username($item['tst_id']);
                    $site_name = \ahura\app\mw_options::get_testimonial_sitename($item['tst_id']);
                    $avatar_url = get_the_post_thumbnail_url($item['tst_id'], 'thumbnail');
                    $content = get_post_field('post_content', $item['tst_id']);
                ?>
                <div class="swiper-slide">
                    <div class="testimonial-carousel-item-wrap">
                        <div class="ahura-testimonial testimonial-carousel-item">
                            <div class="testimonial-carousel-sidebar">
                                <div class="avatar">
                                    <img src="<?php echo $avatar_url ?>" alt="<?php echo $name ?>">
                                </div>
                            </div>
                            <div class="testimonial-carousel-item-content">
                                <div class="content"><?php echo $content ?></div>
                                <div class="testimonial-footer">
                                    <div class="name"><?php echo $name ?></div>
                                    <div class="site-name"><?php echo $site_name ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
                <?php if($has_paginate): ?>
                    <div class="tc-swiper-pagination"></div>
                <?php endif; ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        handleTestimonialCarousel7Element({
                            widgetID: '<?php echo $wid ?>',
                            loop: <?php echo $settings['infinite_loop'] == 'yes' ? 'true' : 'false' ?>,
                            slidesPerView: 1,
                            mobilePerView: 1,
                            tabletPerView: 1,
                            autoPlay: <?php echo $settings['autoplay'] == 'yes' ? 'true' : 'false' ?>,
                            transitionDuration: <?php echo (intval($settings['transition_duration'])) ? $settings['transition_duration'] : 2500 ?>,
                            showPagination: <?php echo $has_paginate ? 'true' : 'false' ?>,
                            paginationType: '<?php echo $settings['pagination'] ?>',
                            navigation: false,
                        });
                    });
                </script>
            </div>
        </div>
        <?php
    }
}