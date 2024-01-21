<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class post_carousel extends \Elementor\Widget_Base {
    /**
     * post_carousel constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
		mw_assets::register_style('owl_carousel_css', mw_assets::get_css('owl-carousel'));
        mw_assets::register_script('owl_carousel_js', mw_assets::get_js('owl-carousel-min'));
        mw_assets::register_style('post_carousel_css', mw_assets::get_css('elementor.post_carousel'));
        mw_assets::register_script('post_carousel_js', mw_assets::get_js('elementor.post_carousel'));
        if (!is_rtl()) {
            mw_assets::register_style('post_carousel_ltr_css', mw_assets::get_css('elementor.ltr.post_carousel_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('post_carousel_css'), mw_assets::get_handle_name('owl_carousel_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('post_carousel_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('owl_carousel_js'), mw_assets::get_handle_name('post_carousel_js')];
    }

	public function get_name() {
		return 'postcarousel';
	}

	public function get_title() {
		return __( 'Post Carousel', 'ahura' );
	}

    public function get_icon() {
		return 'aicon-svg-post-carousel';
	}

	public function get_categories() {
		return [ 'ahuraelements', 'ahura_posts' ];
	}

	function get_keywords()
    {
        return ['postcarousel', 'post_carousel', esc_html__('Post Carousel', 'ahura')];
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
                'default' => 30,
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

		$this->add_control('divider1', ['type' => \Elementor\Controls_Manager::DIVIDER]);

		$this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

		$this->add_control(
            'show_btn',
            [
                'label' => esc_html__('Show Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
		// button text
		$this->add_control(
			'button_text',
            [
                'label' => esc_html__('Button text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Show all', 'ahura'),
                'default' => __('Show all', 'ahura'),
				'condition' => [
					'show_btn' => 'yes'
				]
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'stthumb',
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
			'content_styles',
			[
				'label' => __( 'Content', 'ahura' ),
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
                    '{{WRAPPER}} .fimage img' => 'height: {{SIZE}}{{UNIT}}',
                ]
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

		// typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ah-slider-post-1 .cat-name',
				'condition' => [
					'show_title' => 'yes'
				],
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 24,
                        ],
                    ],
                    'font_weight' => ['default' => 'bold'],
                ],
			]
		);
		
		$this->add_control(
			'title_color',
			[
				'label'   => __( 'Title Color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#66bb6a',
				'condition' => [
					'show_title' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-name' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_bg_color',
			[
				'label'   => __( 'Background color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'show_title' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-name' => 'background-color: {{VALUE}};',
				],
			]
		);

		// border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'widget_title_border',
				'selector' => '{{WRAPPER}} .ah-slider-post-1 .cat-name',
				'condition' => [
					'show_title' => 'yes'
				],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 0,
                            'bottom' => 0,
                            'right' => is_rtl() ? 4 : 0,
                            'left' => is_rtl() ? 0 : 4,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#66bb6a',
                    ],
                ],
			]
		);
		
		// border-radius
		$this->add_control(
			'widget_title_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'show_title' => 'yes'
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
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-name' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// padding
		$this->add_control(
			'widget_title_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'show_title' => 'yes'
				],
                'default' => [
                    'top' => 0,
                    'bottom' => 0,
                    'right' => is_rtl() ? 1 : 0,
                    'left' => is_rtl() ? 0 : 1,
                    'unit' => 'em',
                    // 'isLinked' => false,
                ],
			]
		);

		// margin
		$this->add_control(
			'widget_title_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'show_title' => 'yes'
				],
                'default' => [
                    'top' => 0,
                    'bottom' => 0,
                    'right' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'button_styles',
			[
				'label' => __( 'Button', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_btn' => 'yes'
				]
			]
		);

		// color
		$this->add_control(
			'button_text_color',
			[
				'label'   => __( 'Color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-more-link' => 'color: {{VALUE}};',
				],
			]
		);

		// bg-color
		$this->add_control(
			'button_color',
			[
				'label'   => __( 'Background color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#66bb6a',
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-more-link' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		// typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ah-slider-post-1 .cat-more-link',
                'fields_options' => [
					'typography' => ['default' => 'yes',],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
			]
		);

		// border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .ah-slider-post-1 .cat-more-link',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
			]
		);
		
		// border-radius
		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-more-link' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// box-shadow
		// box-shadow:0 5px 20px <?php echo $settings['button_color']; 80

		// padding
		$this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-more-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => 5,
                    'bottom' => 5,
                    'right' => 15,
                    'left' => 15,
                    'unit' => 'px',
                    // 'isLinked' => false,
                ],
			]
		);

		// margin
		$this->add_control(
			'button_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-1 .cat-more-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => 0,
                    'bottom' => 0,
                    'right' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
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
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
		$catidd   = $settings['catsid'];
		$default_cat_id = is_array($catidd) ? reset($catidd) : $catidd;
		$postbox5 = new \WP_Query ( array(
			'posts_per_page' => $settings['count'],
			'cat'            => $catidd,
            'order'         =>  $settings['post_order']
		) );
		if ( $postbox5->have_posts() ) : ?>
            <div class="ah-slider-post-1 postbox5 post-carousel-element">
				<?php if($settings['show_title'] === 'yes'): ?>
				<h2 class="cat-name">
					<?php echo get_cat_name( $default_cat_id ) ?>
				</h2>
				<?php endif; ?>
				<?php if($settings['show_btn'] === 'yes'): ?>
				<a class="cat-more-link" href="<?php echo get_category_link( $default_cat_id ) ?>"><?php echo $settings['button_text']; ?></a>
				<?php endif; ?>
				<div class="clear"></div>
                <div class="owl-carousel owl-post-carousel">
					<?php while ( $postbox5->have_posts() ) : $postbox5->the_post(); ?>
                        <div class="post-c-item">
                            <a class="fimage" href="<?php the_permalink(); ?>"><?php the_post_thumbnail($settings['item_cover_size']); ?></a>
                            <a href="<?php the_permalink(); ?>">
                                <h3><?php echo wp_trim_words( get_the_title(), 8, '...' ); ?></h3></a>
							<?php if ( $settings['excerpt'] == 'yes' ) : ?>
								<?php
									if($chars_num){
										echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
									} else {
										the_excerpt();
									}
								?>
							<?php endif; ?>
                        </div>
					<?php endwhile; ?>
				</div>
            </div>
			<?php wp_reset_postdata(); ?>
            <?php if (is_admin()): ?>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        handlePostCarouselElement();
                    });
                </script>
			<?php endif; ?>
			<?php endif; ?>
            <div class="clear"></div>
		<?php
	}

}
