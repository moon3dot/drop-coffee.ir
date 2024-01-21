<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts3 extends \Elementor\Widget_Base
{
    /**
     * grid_posts3 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts3_css', mw_assets::get_css('elementor.grid_posts3'));
        if (!is_rtl()) {
            mw_assets::register_style('grid_posts3_ltr_css', mw_assets::get_css('elementor.ltr.grid_posts3_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_posts3_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('grid_posts3_ltr_css');
        }
        return $styles;
    }

    public function get_name() {
		return 'gridposts3';
	}

	public function get_title() {
		return __( 'Grid Posts 3', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-grid-post-3';
	}

	public function get_categories() {
		return [ 'ahuraelements', 'ahura_posts' ];
	}
    function get_keywords()
    {
        return ['gridposts3', 'grid_posts_3', esc_html__('Grid Posts 3', 'ahura')];
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
				'default' => $default
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

        $this->add_control(
            'h1_options',
            [
                'label'    => __( 'Large Image Size', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover1',
                'default' => 'full',
            ]
        );

        $this->add_control(
            'h2_options',
            [
                'label'    => __( 'Other Image Size', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
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

        $this->start_controls_tabs('style_tabs');

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
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 8,
                        'max' => 300,
                    ],
                    'rem' => [
                        'min' => 8,
                        'max' => 300,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 250,
                    'unit' => 'px',
                ],
                'desktop_default' => [
                    'size' => 250,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 200,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 200,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-post3 .item' => 'min-height: {{SIZE}}{{UNIT}}'
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
                    '{{WRAPPER}} .grid-post3 .item a' => 'text-align: {{VALUE}}',
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
                    '{{WRAPPER}} .grid-post3 .item h3' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .grid-post3 .item a .post-meta span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .grid-post3 .item h3',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '18',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Meta Typography', 'ahura'),
                'name' => 'item_meta_typography',
                'selector' => '{{WRAPPER}} .grid-post3 .item a .post-meta span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 300],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'items_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post3 .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'items_padding',
            [
                'label' => esc_html__('padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post3 .item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-post3 .item',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 2,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.5)'
                        ]
                    ]
                ],
            ]
        );

        $this->add_control(
			'show_post_cover_control',
			[
				'label' => esc_html__( 'Custom colored post cover', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
            'items_post1_cover',
            [
                'label' => esc_html__('Post 1\'s colored cover', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(183, 28, 28, 0.77)',
                'selectors' => [
                    '{{WRAPPER}} .grid-post3 .item:nth-of-type(1) a' => 'background-image: linear-gradient(360deg, {{VALUE}} -20%, rgba(12, 211, 31, 0) 70%)',
                ],
                'condition' => [
                    'show_post_cover_control' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'items_post2_cover',
            [
                'label' => esc_html__('Post 2\'s colored cover', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(104, 159, 56, 0.5)',
                'selectors' => [
                    '{{WRAPPER}} .grid-post3 .item:nth-of-type(2) a' => 'background-image: linear-gradient(360deg, {{VALUE}} -20%, rgba(12, 211, 31, 0) 70%)',
                ],
                'condition' => [
                    'show_post_cover_control' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'items_post3_cover',
            [
                'label' => esc_html__('Post 3\'s colored cover', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(81, 45, 168, 0.77)',
                'selectors' => [
                    '{{WRAPPER}} .grid-post3 .item:nth-of-type(3) a' => 'background-image: linear-gradient(360deg, {{VALUE}} -20%, rgba(12, 211, 31, 0) 70%)',
                ],
                'condition' => [
                    'show_post_cover_control' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'items_post4_cover',
            [
                'label' => esc_html__('Post 4\'s colored cover', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(230, 81, 0, 0.77)',
                'selectors' => [
                    '{{WRAPPER}} .grid-post3 .item:nth-of-type(4) a' => 'background-image: linear-gradient(360deg, {{VALUE}} -20%, rgba(12, 211, 31, 0) 70%)',
                ],
                'condition' => [
                    'show_post_cover_control' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'items_post5_cover',
            [
                'label' => esc_html__('Post 5\'s colored cover', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(13, 71, 161, 0.77)',
                'selectors' => [
                    '{{WRAPPER}} .grid-post3 .item:nth-of-type(5) a' => 'background-image: linear-gradient(360deg, {{VALUE}} -20%, rgba(12, 211, 31, 0) 70%)',
                ],
                'condition' => [
                    'show_post_cover_control' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-post3 .item:hover',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 2,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.13)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$catidd   = $settings['catsid'];
		$post_order = $settings['post_order'];
		$postbox1 = new \WP_Query ( array(
			'posts_per_page' => 5,
			'cat'            => $catidd,
            'order'         =>  $post_order
		) );
		if ( $postbox1->have_posts() ) : ?>
		<div class="grid-post3">
			<?php
            $i=1;
            while($postbox1->have_posts()): $postbox1->the_post();
                $bg_size = $i==5 ? $settings['item_cover1_size'] : $settings['item_cover_size'];
            ?>
				<article style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), $bg_size);?>')" class="item <?php echo ($settings['show_posts_overlay'] != 'yes') ? 'none-cover-overlay' : '' ?>">
					<a href="<?php the_permalink(get_the_ID()); ?>">
						<h3><?php echo get_the_title(); ?></h3>
						<div class="post-meta">
							<?php if($settings['time']): ?>
								<span class="post-date"><i class="fa fa-clock"></i> <?php echo get_the_date('d F Y'); ?></span>
							<?php endif; if($settings['author']):?>
								<span class="post-author"><i class="fa fa-user"></i> <?php the_author() ?></span>
							<?php endif; ?>
						</div>
					</a>
				</article>
			<?php $i++;endwhile; ?>
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
