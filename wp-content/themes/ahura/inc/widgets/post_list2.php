<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class post_list2 extends \Elementor\Widget_Base {
    /**
     * post_list2 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('post_list2_css', mw_assets::get_css('elementor.post_list2'));
        if (!is_rtl()) {
            mw_assets::register_style('post_list2_ltr_css', mw_assets::get_css('elementor.ltr.post_list2_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('post_list2_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('post_list2_ltr_css');
        }
        return $styles;
    }

	public function get_name() {
		return 'postlist2';
	}

	public function get_title() {
		return __( 'Post List 1 Col', 'ahura' );
	}

    public function get_icon() {
		return 'aicon-svg-post-list2';
	}

	public function get_categories() {
		return [ 'ahuraelements', 'ahura_posts' ];
	}

    function get_keywords()
	{
		return ['post_list_2', 'postlist2', esc_html__( 'Post List 2' , 'ahura'), __( 'Post List 1 Col', 'ahura' )];
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
			'postcount',
			[
				'label'      => __( 'Number of posts', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 4
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
            'show_box_title',
            [
                'label' => esc_html__( 'Show Title', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
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
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'verthumb',
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
                    '{{WRAPPER}} .list-post img' => 'object-fit: {{VALUE}};',
                ],
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
				'label' => __( 'Box', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_box_title' => 'yes'
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
		$this->add_control(
			'color',
			[
				'label'   => __( 'Border Color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cat-name' => 'border-color: {{VALUE}}',
                ],
				'default' => '#66bb6a'
			]
		);

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cat-name' => 'color: {{VALUE}}',
                ],
                'default' => '#66bb6a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'box_title_typography',
                'selector' => '{{WRAPPER}} .cat-name',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '24'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '700'
                    ]
                ],
            ]
        );

        $this->add_control(
			'widget_box_style_heading',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        // bg-color
        $this->add_control(
            'widget_box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-list-2-widget' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'widget_box_border',
				'selector' => '{{WRAPPER}} .post-list-2-widget',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
			]
		);

        // border-radius
        $this->add_control(
			'widget_box_border_radius',
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
					'size' => '0',
				],
				'selectors' => [
					'{{WRAPPER}} .post-list-2-widget' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // padding
        $this->add_control(
			'widget_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .post-list-2-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // box-shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'widget_box_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .post-list-2-widget',
                'fields_options' => [
                    // 'box_shadow_type' => ['default' => 'yes'],
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

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .cat-more-link' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_color',
                'label' => __( 'Button Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .cat-more-link',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#66BB6A'
                            ],
                    ]
            ]
        );

        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'widget_button_border',
                'selector' => '{{WRAPPER}} .cat-more-link',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
			]
		);

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .cat-more-link' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
					'unit' => 'px',
					'size' => '5',
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
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .cat-more-link',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => '#66BB6A'
                        ]
                    ]
                ]
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
            'box_img_width',
            [
                'label' => esc_html__('Cover Width', 'ahura'),
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
                    '{{WRAPPER}} .post-list-2-widget .list-post a img' => 'width: {{SIZE}}{{UNIT}}',
                ]
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
                    '{{WRAPPER}} .post-list-2-widget .list-post a img' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'cover_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    '{{WRAPPER}} .list-post a img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
					'unit' => 'px',
					'size' => '10',
				],
            ]
        );
        
        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'post_cover_image_border',
				'selector' => '{{WRAPPER}} .list-post a img',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
			]
		);

        $this->end_controls_section();
        $this->start_controls_section(
            'item_styles',
            [
                'label' => __( 'Item', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .list-post-2 h3' => 'color: {{VALUE}}',
                ],
                'default' => '#555',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .list-post-2 h3',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => '1.2'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
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
                'selector' => '{{WRAPPER}} .list-post',
                'fields_options' =>
                    [
                        'background' => ['default' => 'classic'],
                        'color' => ['default' => '#ffffff']
                    ]
            ]
        );

        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'post_item_border',
				'selector' => '{{WRAPPER}} .list-post',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
			]
		);

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .list-post' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'size' => '10',
				],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .list-post',
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
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$catidd   = $settings['catsid'];
		$first_cat_id = $catidd && is_array($catidd) ? $catidd[0] : $catidd;
		$postbox1 = new \WP_Query ( array(
			'posts_per_page' => $settings['postcount'],
			'cat'            => $catidd,
            'order'         =>  $settings['post_order']
		) );
		if ( $postbox1->have_posts() ) : ?>
            <div class="post-list-2-widget">
                <?php if ($settings['show_box_title'] === 'yes'): ?>
                    <h2 class="cat-name"><?php echo get_cat_name( $first_cat_id ) ?></h2>
                <?php endif; ?>
                <?php if ($settings['show_btn'] === 'yes'): ?>
                    <a class="cat-more-link" href="<?php echo get_category_link( $first_cat_id ) ?>">
                        <?php echo __( 'Show All', 'ahura' ); ?>
                    </a>
                <?php endif; ?>
                <div class="clear"></div>
                <div class="post-list row">
					<?php while ( $postbox1->have_posts() ) : $postbox1->the_post(); ?>
                        <div class="col-lg-12">
                            <article class="list-post list-post-2 row">
                                <div class="col-md-4">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $settings['item_cover_size'] ); ?></a>
                                </div>
                                <div class="col-md-8">
                                    <a href="<?php the_permalink(); ?>">
                                        <h3><?php echo wp_trim_words( get_the_title(), 8, '...' ); ?></h3>
                                    </a>
                                </div>
                            </article>
                        </div>
					<?php endwhile; ?>
                </div>
            </div>
			<?php wp_reset_postdata(); ?>
			<?php else: ?>
                <div class="mw_element_error">
                    <?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
                </div>
            <?php endif; ?>
        <div class="clear"></div>
		<?php
	}

}
