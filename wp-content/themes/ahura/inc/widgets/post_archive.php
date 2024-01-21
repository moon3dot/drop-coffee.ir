<?php
namespace ahura\inc\widgets;
// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class post_archive extends \Elementor\Widget_Base {
    /**
     * post_archive constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('post_archive_css', mw_assets::get_css('elementor.post_archive'));
        if (!is_rtl()) {
            mw_assets::register_style('post_archive_ltr_css', mw_assets::get_css('elementor.ltr.post_archive_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('post_archive_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('post_archive_ltr_css');
        }
        return $styles;
    }

	public function get_name() {
		return 'postarchive';
	}

	public function get_title() {
		return __( 'Post Archive', 'ahura' );
	}

    public function get_icon() {
		return 'aicon-svg-post-archive-1';
	}

	public function get_categories() {
		return [ 'ahuraelements', 'ahura_posts' ];
	}
	function get_keywords()
	{
		return ['post_archive', 'postarchive', esc_html__( 'Post Archive' , 'ahura')];
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
			'date',
			[
				'label'   => __( 'Show Date', 'ahura' ),
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
			'author',
			[
				'label'   => __( 'Show Author', 'ahura' ),
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
				'condition' => [
					'excerpt' => 'yes'
				]
			]
		);

		$this->add_control(
			'postcount',
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

		$this->add_control(
			'target_link',
			[
				'label' => __('Open Link in New tab', 'ahura'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => '_self',
				'options' => [
					'_blank' => [
						'title' => __('Yes', 'ahura'),
						'icon' => 'eicon-check'
					],
					'_self' => [
						'title' => __('No', 'ahura'),
						'icon' => 'eicon-close-circle'
					],
				],
				'toggle' => true
			]
		);

		$this->add_control('divider1', ['type' => \Elementor\Controls_Manager::DIVIDER]);

		$this->add_responsive_control(
			'post_columns',
			[
				'label' => esc_html__('Columns', 'ahura'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					12 => sprintf(esc_html__('%d Column', 'ahura'), 1),
					6 => sprintf(esc_html__('%d Column', 'ahura'), 2),
					4 => sprintf(esc_html__('%d Column', 'ahura'), 3),
					3 => sprintf(esc_html__('%d Column', 'ahura'), 4),
					2 => sprintf(esc_html__('%d Column', 'ahura'), 6),
				],
				'default' => 3,
				'desktop_default' => 3,
				'tablet_default' => 4,
				'mobile_default' => 12,
			]
		);

        $this->add_control(
            'box_title_show',
            [
                'label' => esc_html__('Box Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

		$this->add_control(
            'box_custom_title_show',
            [
                'label' => esc_html__('Custom Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
				'condition' => [
					'box_title_show' => 'yes'
				]
            ]
        );

		$this->add_control(
            'box_custom_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'ahura'),
				'condition' => [
					'box_custom_title_show' => 'yes'
				]
            ]
        );

        $this->add_control(
            'archive_btn_show',
            [
                'label' => esc_html__('Button', 'ahura'),
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
                'name' => 'item_cover',
                'default' => 'stthumb',
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
            'box_styles',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'   => __( 'Title Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#66bb6a'
            ]
        );
        // box bg color
        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Box background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .postbox4' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // box border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'main_box_border',
				'selector' => '{{WRAPPER}} .postbox4',
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
        
        // box border-radius
        $this->add_control(
			'main_box_border_radius',
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
				'selectors' => [
					'{{WRAPPER}} .postbox4' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // box padding
        $this->add_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .postbox4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    // 'isLinked' => false,
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'cover_styles',
            [
                'label' => __( 'Cover', 'ahura' ),
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
                    '{{WRAPPER}} .postbox4 article .fimage img' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'box_img_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .postbox4 article .fimage img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 20,
				],
            ]
        );

        $this->end_controls_section();
		$this->start_controls_section(
			'content_styles',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .postbox4 article h3' => 'color: {{VALUE}}',
                ],
                'default' => '#555',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .postbox4 article h3',
            ]
        );

        $this->add_control(
            'item_des_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6b7074',
                'selectors' => [
                    '{{WRAPPER}} .postbox4 article p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_des_typography',
                'selector' => '{{WRAPPER}} .postbox4 article p',
            ]
        );

        $this->add_control(
            'item_meta_color',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#838383',
                'selectors' => [
                    '{{WRAPPER}} .postbox4 article .meta span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_item_background',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .postbox4 article',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_item_border',
                'selector' => '{{WRAPPER}} .postbox4 article',
            ]
        );

        $this->add_control(
            'box_item_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .postbox4 article' => 'border-radius: {{SIZE}}{{UNIT}};',

                ],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 20,
				],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .postbox4 article',
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

		$this->end_controls_section();
		$this->start_controls_section(
			'button_styles',
			[
				'label' => __( 'Button', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
        // typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'items_section_title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .postbox4 .cat-more-link',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
			]
		);

        $this->add_control(
            'button_text_color',
            [
                'label'   => __( 'Text color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                        '{{WRAPPER}} .postbox4 .cat-more-link' => 'color: {{VALUE}}'
                ]
            ]
        );

		$this->add_control(
			'button_color',
			[
				'label'   => __( 'Background Color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#66bb6a',
                'selectors' => [
                    '{{WRAPPER}} .postbox4 .cat-more-link' => 'background-color: {{VALUE}}'
                ]
			]
		);


        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .postbox4 .cat-more-link',
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
					'{{WRAPPER}} .postbox4 .cat-more-link' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // padding
        $this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .postbox4 .cat-more-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '15',
                    'left' => '15',
                    'unit' => 'px',
                    // 'isLinked' => true,
                ],
			]
		);

        // box shadow
        $this->add_control(
			'main_box_button_box_shadow_heading',
			[
				'label' => esc_html__( 'Box shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'main_box_button_box_shadow',
			[
				'label' => esc_html__( 'Box Shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' => [
					'{{WRAPPER}} .postbox4 .cat-more-link' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				],
                'default' => [
                    'horizontal' => 0,
                    'vertical' => 5,
                    'blur' => 20,
                    'spread' => 0,
                    'color' => '#66bb6a80',
                ],
			]
		);
        

        
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$catidd   = $settings['catsid'];
		$first_cat_id = $catidd && is_array($catidd) ? $catidd[0] : $catidd;
		$show_author = $settings['author'];
		$show_date = $settings['date'];
		$show_meta_tag = $show_author == 'yes' || $show_date == 'yes';
		$columns = isset($settings['post_columns']) && intval($settings['post_columns']) ? $settings['post_columns'] : 3;
		$columns_tablet = isset($settings['post_columns_tablet']) && intval($settings['post_columns_tablet']) ? $settings['post_columns_tablet'] : 4;
		$columns_mobile = isset($settings['post_columns_mobile']) && intval($settings['post_columns_mobile']) ? $settings['post_columns_mobile'] : 12;
		$chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
		$custom_title_show = $settings['box_custom_title_show'] == 'yes';
		$box_title = $custom_title_show ? $settings['box_custom_title'] : get_cat_name($first_cat_id);
        $has_excerpt = $settings['excerpt'] == 'yes';
		?>
        <div class="postbox4">
            <?php if($settings['box_title_show'] == 'yes'): ?>
                <h2 style="border-right-color:<?php echo $settings['title_color']; ?>;color:<?php echo $settings['title_color']; ?>" class="cat-name"><?php echo $box_title ?></h2>
            <?php endif; ?>
            <?php if($settings['archive_btn_show'] == 'yes'): ?>
                <a class="cat-more-link" href="<?php echo get_category_link( $first_cat_id ) ?>" target="<?php echo $settings['target_link']; ?>">
                    <?php echo __( 'Show All', 'ahura' ); ?>
                </a>
            <?php endif; ?>
			<?php $postbox4 = new \WP_Query ( array(
				'posts_per_page' => $settings['postcount'],
				'cat'            => $settings['catsid'],
                'order'         =>  $settings['post_order']
			) );
			if ( $postbox4->have_posts() ) : ?>
            <div class="clear"></div>
            <div class="flexed row">
				<?php while ( $postbox4->have_posts() ) : $postbox4->the_post(); ?>
                    <div class="col-<?php echo $columns_mobile ?> col-sm-<?php echo $columns_mobile ?> col-md-<?php echo $columns_tablet ?> col-lg-<?php echo $columns ?>">
                        <article class="post-item-box <?php echo !$has_excerpt ? 'without-excerpt' : '' ?>">
                            <a class="fimage" href="<?php the_permalink(); ?>"><?php the_post_thumbnail($settings['item_cover_size']); ?></a>
                            <a href="<?php the_permalink(); ?>" target="<?php echo $settings['target_link']; ?>">
                                <h3><?php the_title(); ?></h3>
                            </a>
							<?php if ( $has_excerpt ) : ?>
								<div class="excerpt <?php echo $show_meta_tag ? 'has_margin' : ''; ?>">
									<?php 
									if($chars_num){
										echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
									} else {
										the_excerpt();
									}
									?>
								</div>
							<?php endif; ?>
							<?php if($show_meta_tag): ?>
								<div class="meta clearfix">
							<?php endif; ?>
							<?php if ( $show_author == 'yes' ) : ?>
                                <span class="post-author"><?php echo get_avatar( get_the_author_meta( 'ID' ), 48 ); ?><?php the_author(); ?></span>
							<?php endif; ?>
							<?php if ( $show_date == 'yes' ) : ?>
                                <span class="post-meta"><i class="fa fa-clock"></i> <?php echo get_the_date( 'd F Y' ); ?></span>
							<?php endif; ?>
							<?php if($show_meta_tag): ?>
								</div>
							<?php endif; ?>
                        </article>
                    </div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
            </div>
			<?php else:?>
				<div class="mw_element_error">
					<?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
				</div>
			<?php endif; ?>
        </div>
        <div class="clear"></div>
		<?php
	}

}
