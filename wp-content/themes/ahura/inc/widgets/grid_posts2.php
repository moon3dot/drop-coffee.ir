<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts2 extends \Elementor\Widget_Base {
    /**
     * grid_posts2 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts2_css', mw_assets::get_css('elementor.grid_posts2'));
        if (!is_rtl()) {
            mw_assets::register_style('grid_posts2_ltr_css', mw_assets::get_css('elementor.ltr.grid_posts2_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_posts2_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('grid_posts2_ltr_css');
        }
        return $styles;
    }

	public function get_name() {
		return 'gridposts2';
	}

	public function get_title() {
		return __( 'Grid Posts 2', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-grid-post-2';
	}

	public function get_categories() {
		return [ 'ahuraelements', 'ahura_posts' ];
	}
    function get_keywords()
    {
        return ['gridposts2', 'grid_posts_2', esc_html__('Grid Posts 2', 'ahura')];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
				'type'     => Controls_Manager::SELECT2,
				'options'  => $cats,
				'label_block' => true,
				'multiple' => true,
				'default'	=>	$default
			]
		);

		$this->add_control(
			'author',
			[
				'label'   => __( 'Author', 'ahura' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'time',
			[
				'label'   => __( 'Time', 'ahura' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'post_order',
			[
				'label' => __('Sort', 'ahura'),
				'type' => Controls_Manager::CHOOSE,
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

        $this->add_control(
            'show_posts_overlay',
            [
                'label' => esc_html__('Posts Overlay', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover1',
                'default' => 'full',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'verthumb',
            ]
        );

		$this->end_controls_section();
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
        /**
         *
         *
         * Items style
         *
         *
         */
        $this->start_controls_section(
            'items_style_section',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('items_style_tabs');

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_responsive_control(
            'items_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 240,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 18.8,
                        'max' => 62.5,
                    ],
                    'rem' => [
                        'min' => 18.8,
                        'max' => 62.5,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 520,
                    'unit' => 'px',
                ],
                'desktop_default' => [
                    'size' => 520,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 400,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 .grid-post2-box2' => 'height: calc(({{SIZE}}{{UNIT}} + 145px) / 3)',
                    '{{WRAPPER}} .grid-post2 .grid-post2-box3' => 'height: calc(({{SIZE}}{{UNIT}} + 50px) / 2)',
                    '{{WRAPPER}} .grid-post2 .grid-post2-box4' => 'height: calc(({{SIZE}}{{UNIT}} + 50px) / 2)',
                    '{{WRAPPER}} .grid-post2 .grid-post2-box5' => 'height: calc(({{SIZE}}{{UNIT}} + 145px) / 3)',
                ]
            ]
        );

        $this->add_control(
            'items_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 .grid-information' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'items_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 .grid-information h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'items_meta_color',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 .grid-information span' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'author' => 'yes',
                    'time' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'items_title_typography',
                'selector' => '{{WRAPPER}} .grid-post2 .grid-information h2',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '19',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Meta Typography', 'ahura'),
                'name' => 'items_meta_typography',
                'selector' => '{{WRAPPER}} .grid-post2 .grid-information span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ]
                    ]
                ],
                'condition' => [
                    'author' => 'yes',
                    'time' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'items_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 article' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 .grid-information' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 1.5,
                    'right' => 1.5,
                    'bottom' => 1.5,
                    'left' => 1.5,
                    'unit' => 'em'
                ]
            ]
        );

        $this->add_control(
            'items_cover_color',
            [
                'label' => esc_html__('Cover Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-post a' => 'background-image: linear-gradient(360deg, {{VALUE}} 0%, rgba(12,211,31,0) 40%)',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-post2 article',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'items_title_color_hover',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 article:hover .grid-information h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'items_meta_color_hover',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 article:hover .grid-information span' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'author' => 'yes',
                    'time' => 'yes',
                ]
            ]
        );

        $this->add_responsive_control(
            'items_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post2 article:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'items_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-post2 article:hover',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 20,
                            'blur' => 30,
                            'spread' => 0,
                            'color' => 'rgba(40, 46, 54, 0.30)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
		$settings = $this->get_settings_for_display();
		$catidd   = $settings['catsid'];
		$post_order = $settings['post_order'];
		$postbox1 = new \WP_Query ( array(
			'posts_per_page' => 1,
			'cat'            => $catidd,
            'order'         =>  $post_order
		) );
		$postbox2 = new \WP_Query ( array(
			'posts_per_page' => 1,
			'offset'         => 1,
			'cat'            => $catidd,
            'order'         =>  $post_order
		) );
		$postbox3 = new \WP_Query ( array(
			'posts_per_page' => 1,
			'offset'         => 2,
			'cat'            => $catidd,
            'order'         =>  $post_order
		) );
		$postbox4 = new \WP_Query ( array(
			'posts_per_page' => 1,
			'offset'         => 3,
			'cat'            => $catidd,
            'order'         =>  $post_order
		) );
		$postbox5 = new \WP_Query ( array(
			'posts_per_page' => 1,
			'offset'         => 4,
			'cat'            => $catidd,
            'order'         =>  $post_order
		) );
		if ( $postbox1->have_posts() ) : ?>
            <div class="row grid-post2">
                <div class="col-md-6">
					<?php while ( $postbox1->have_posts() ) : $postbox1->the_post(); ?>
						<?php
						$thumb_id  = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src( $thumb_id, $settings['item_cover1_size'], true );
						?>
                        <article class="grid-post2-box1 grid-post <?php echo ($settings['show_posts_overlay'] == 'yes') ? 'grid-post-red' : '' ?>"
                                 style="background-image:url('<?php echo $thumb_url[0]; ?>');">
                            <a href="<?php the_permalink(); ?>">
                                <div class="grid-information">
                                    <h2><?php the_title(); ?></h2>
									<?php if ( $settings['time'] == 'yes' ): ?>
                                        <span><i class="fa fa-clock"></i> <?php echo get_the_date( 'd F Y' ); ?></span>
									<?php endif; ?>
									<?php if ( $settings['author'] == 'yes' ): ?>
                                        <span class="post-author"><i
                                                    class="fa fa-user"></i> <?php the_author(); ?></span>
									<?php endif; ?>
                                </div>
                            </a>
                        </article>
					<?php endwhile; ?>
                </div>

                <div class="col-md-3">
					<?php while ( $postbox2->have_posts() ) : $postbox2->the_post(); ?>
						<?php
						$thumb_id  = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src( $thumb_id, $settings['item_cover_size'], true );
						?>
                        <article class="mb-4 grid-post grid-post2-box2 <?php echo ($settings['show_posts_overlay'] == 'yes') ? 'grid-post-green' : '' ?> grid-post-small"
                                 style="background-image:url('<?php echo $thumb_url[0]; ?>');">
                            <a href="<?php the_permalink(); ?>">
                                <div class="grid-information">
                                    <h2><?php the_title(); ?></h2>
									<?php if ( $settings['time'] == 'yes' ): ?>
                                        <span><i class="fa fa-clock"></i> <?php echo get_the_date( 'd F Y' ); ?></span>
									<?php endif; ?>
									<?php if ( $settings['author'] == 'yes' ): ?>
                                        <span class="post-author"><i
                                                    class="fa fa-user"></i> <?php the_author(); ?></span>
									<?php endif; ?>
                                </div>
                            </a>
                        </article>
					<?php endwhile; ?>
					<?php while ( $postbox3->have_posts() ) : $postbox3->the_post(); ?>
						<?php
						$thumb_id  = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src( $thumb_id, $settings['item_cover_size'], true );
						?>
                        <article class="grid-post grid-post2-box3 <?php echo ($settings['show_posts_overlay'] == 'yes') ? 'grid-post-purple' : '' ?> grid-post-small"
                                 style="background-image:url('<?php echo $thumb_url[0]; ?>');">
                            <a href="<?php the_permalink(); ?>">
                                <div class="grid-information">
                                    <h2><?php the_title(); ?></h2>
									<?php if ( $settings['time'] == 'yes' ): ?>
                                        <span><i class="fa fa-clock"></i> <?php echo get_the_date( 'd F Y' ); ?></span>
									<?php endif; ?>
									<?php if ( $settings['author'] == 'yes' ): ?>
                                        <span class="post-author"><i
                                                    class="fa fa-user"></i> <?php the_author(); ?></span>
									<?php endif; ?>
                                </div>
                            </a>
                        </article>
					<?php endwhile; ?>
                </div>


                <div class="col-md-3">
					<?php while ( $postbox4->have_posts() ) : $postbox4->the_post(); ?>
						<?php
						$thumb_id  = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src( $thumb_id, $settings['item_cover_size'], true );
						?>
                        <article class="mb-4 grid-post grid-post2-box4 <?php echo ($settings['show_posts_overlay'] == 'yes') ? 'grid-post-orange' : '' ?> grid-post-small"
                                 style="background-image:url('<?php echo $thumb_url[0]; ?>');">
                            <a href="<?php the_permalink(); ?>">
                                <div class="grid-information">
                                    <h2><?php the_title(); ?></h2>
									<?php if ( $settings['time'] == 'yes' ): ?>
                                        <span><i class="fa fa-clock"></i> <?php echo get_the_date( 'd F Y' ); ?></span>
									<?php endif; ?>
									<?php if ( $settings['author'] == 'yes' ): ?>
                                        <span class="post-author"><i
                                                    class="fa fa-user"></i> <?php the_author(); ?></span>
									<?php endif; ?>
                                </div>
                            </a>
                        </article>
					<?php endwhile; ?>
					<?php while ( $postbox5->have_posts() ) : $postbox5->the_post(); ?>
						<?php
						$thumb_id  = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src( $thumb_id, $settings['item_cover_size'], true );
						?>
                        <article class="grid-post grid-post2-box5 <?php echo ($settings['show_posts_overlay'] == 'yes') ? 'grid-post-blue' : '' ?> grid-post-small"
                                 style="background-image:url('<?php echo $thumb_url[0]; ?>');">
                            <a href="<?php the_permalink(); ?>">
                                <div class="grid-information">
                                    <h2><?php the_title(); ?></h2>
									<?php if ( $settings['time'] == 'yes' ): ?>
                                        <span><i class="fa fa-clock"></i> <?php echo get_the_date( 'd F Y' ); ?></span>
									<?php endif; ?>
									<?php if ( $settings['author'] == 'yes' ): ?>
                                        <span class="post-author"><i
                                                    class="fa fa-user"></i> <?php the_author(); ?></span>
									<?php endif; ?>
                                </div>
                            </a>
                        </article>
					<?php endwhile; ?>
                </div>

            </div>
			<?php wp_reset_postdata(); ?>
			<?php else:?>
					<div class="mw_element_error">
						<?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
					</div>
		<?php endif; ?>
        <div class="clear"></div>
		<?php
	}

}
