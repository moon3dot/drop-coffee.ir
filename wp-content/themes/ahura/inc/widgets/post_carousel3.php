<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class post_carousel3 extends \Elementor\Widget_Base {
	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		mw_assets::register_style('owl_carousel_css', mw_assets::get_css('owl-carousel'));
        mw_assets::register_script('owl_carousel_js', mw_assets::get_js('owl-carousel-min'));
        $post_carousel3_css = mw_assets::get_css('elementor.post_carousel3');
		mw_assets::register_style('post_carousel3', $post_carousel3_css);
        mw_assets::register_script('post_carousel3_js', mw_assets::get_js('elementor.post_carousel3'));
        if (!is_rtl()) {
            mw_assets::register_style('post_carousel3_ltr_css', mw_assets::get_css('elementor.ltr.post_carousel3_ltr'));
        }
    }

	function get_style_depends()
	{
        $styles = [mw_assets::get_handle_name('post_carousel3'), mw_assets::get_handle_name('owl_carousel_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('post_carousel3_ltr_css');
        }
        return $styles;
	}

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('owl_carousel_js'), mw_assets::get_handle_name('post_carousel3_js')];
    }

    public function get_name() {
        return 'postcarousel3';
    }

    public function get_title() {
        return __( 'Post Carousel 3', 'ahura' );
    }

    public function get_icon() {
        return 'aicon-svg-post-carousel-3';
    }

    public function get_categories() {
        return [ 'ahuraelements', 'ahura_posts' ];
    }
    function get_keywords()
    {
        return ['post_carousel3', 'postcarousel3', esc_html__( 'Post Carousel 3' , 'ahura')];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$categories = get_categories();
		$cats       = array();
		foreach ( $categories as $category ) {
			$cats[ $category->term_id ] = $category->name;
		}
		$default = key($cats);
		$this->add_control(
			'catsid',
			[
				'label'    => __( 'Categories', 'ahura' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => $cats,
				'label_block' => true,
				'multiple' => true,
				'default' => $default
			]
		);
        $this->add_control(
			'use_custom_title',
			[
                'label' => __('Custom Title', 'ahura'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $this->add_control(
            'custom_title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Blog', 'ahura'),
                'default' => __('Blog', 'ahura'),
                'condition' => [
                    'use_custom_title' => 'yes',
                ],
            ]
        );

		$this->add_control(
			'description',
			[
				'label' => __("Description", 'ahura'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura')
			]
		);

		$this->add_control(
			'excerpt',
			[
				'label'   => __( 'Show Excerpt', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
                    'yes' => [
                        'title' => __( 'Yes', 'ahura' ),
                        'icon'  => 'eicon-check'
                    ],
                    'no'  => [
                        'title' => __( 'No', 'ahura' ),
                        'icon'  => 'eicon-close'
                    ]
				],
				'default' => 'yes'
			]
		);

		$this->add_control(
			'excerpt_chars_count',
			[
				'label'   => __( 'Excerpt Characters', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
                'default'    => 20,
				'condition' => [
					'excerpt' => 'yes'
				]
			]
		);

		$this->add_control(
			'count',
			[
				'label'      => __( 'Number of posts', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 8
			]
		);

		$this->add_control(
			'post_order',
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

		$this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'stthumb',
            ]
        );

        $this->add_responsive_control(
            'object_fit',
            [
                'label' => esc_html__( 'Aspect ratio', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'fill' => esc_html__( 'Default', 'ahura' ),
                    'contain' => esc_html__( 'Contain', 'ahura' ),
                    'cover'  => esc_html__( 'Cover', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-item img' => 'object-fit: {{VALUE}};',
                ],
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
		/**
		 * 
		 * 
		 * Styles
		 * 
		 *
		 */
        $this->start_controls_section(
            'item_styles',
            [
                'label' => __( 'Item', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_img_height',
            [
                'label' => esc_html__('Cover Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .img img' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-item h3' => 'color: {{VALUE}}',
                ],
                'default' => '#555',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .owl-item h3',
                'fields_options' => [
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
            'item_des_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6b7074',
                'selectors' => [
                    '{{WRAPPER}} .owl-item p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_des_typography',
                'selector' => '{{WRAPPER}} .owl-item p',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .owl-item',
                'fields_options' =>
                    [
                        'background' => ['default' => 'classic'],
                        'color' => ['default' => '#ffffff']
                    ]
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .owl-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 10,
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
			'content_styles',
			[
				'label' => __( 'Box', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'widget_title_style_heading',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'color',
			[
				'label'   => __( 'Primary Color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#66bb6a',
				'selectors' =>
				[
					'{{WRAPPER}} .description::before' => 'border-color: {{VALUE}}'
				]
			]
		);

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .info_box .title' => 'color: {{VALUE}}',
                ],
                'default' => '#333',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title typography', 'ahura'),
                'name' => 'box_title_typography',
                'selector' => '{{WRAPPER}} .info_box .title',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'rem',
                            'size' => '2'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ]
                ]
            ]
        );

        $this->add_control(
			'widget_description_style_heading',
			[
				'label' => esc_html__( 'Description', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'box_des_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#777',
                'selectors' => [
                    '{{WRAPPER}} .info_box .description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Description typography', 'ahura'),
                'name' => 'box_des_typography',
                'selector' => '{{WRAPPER}} .info_box .description',
                'fields_options' => [
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
			'widget_box_style_heading',
			[
				'label' => esc_html__( 'Box', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .post-carousel-3',
                'fields_options' =>
                    [
                        'background' => ['default' => 'classic'],
                        'color' => ['default' => '#ffffff']
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .post-carousel-3',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .06)'
                        ]
                    ]
                ]
            ]
        );
        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .post-carousel-3' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 5,
				],
            ]
        );
        $this->add_control(
			'widget_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .post-carousel-3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
		$catidd   = $settings['catsid'];
        $has_excerpt = $settings['excerpt'] == 'yes';
		$default_cat_id = is_array($catidd) ? reset($catidd) : $catidd;
		$count = $settings['count'];
		$posts = new \WP_Query ( array(
			'posts_per_page' => $count,
			'cat'            => $settings['catsid'],
			'order'         =>  $settings['post_order'],
		) );
        $widgetTitleText = $settings['custom_title_text'] ? $settings['custom_title_text'] : get_cat_name($default_cat_id);
		if($posts->have_posts()): ?>
			<div class="post-carousel-3">
				<div class="info_box">
					<h3 class="title"><?php echo $widgetTitleText; ?></h3>
					<p class="description"><?php echo $settings['description']; ?></p>
				</div>
				<div class="slide_box">
					<div class="owl-carousel owl-slider-wrap">
						<?php while($posts->have_posts()): $posts->the_post();?>
							<a href="<?php the_permalink(get_the_ID()); ?>" class="item <?php echo !$has_excerpt ? 'without-excerpt' : '' ?>">
								<div class="img">
									<?php the_post_thumbnail($settings['item_cover_size']); ?>
								</div>
								<h3><?php the_title(); ?></h3>
								<?php if($has_excerpt):?>
								<span><?php 
									if($chars_num){
										echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
									} else {
										the_excerpt();
									}
								?></span>
								<?php endif;?>
							</a>
						<?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
					</div>
					<?php endif;?>
				</div>
			</div>
            <?php if(is_admin()): ?>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    handlePostCarouse3();
                });
            </script>
            <?php endif; ?>
		<?php
	}

}