<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;

class post_list3 extends \Elementor\Widget_Base
{
    /**
     * post_list3 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('post_list3_css', mw_assets::get_css('elementor.post_list3'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('post_list3_css')];
    }

	public function get_name()
	{
		return 'postlist3';
	}

	public function get_title()
	{
		return __('Post List 3', 'ahura');
	}

    public function get_icon() {
		return 'aicon-svg-post-list3';
	}

	public function get_categories()
	{
		return ['ahuraelements', 'ahura_posts'];
	}

	function get_keywords()
	{
		return ['post_list_3', 'postlist3', esc_html__( 'Post List 3' , 'ahura')];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'ahura'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$categories = get_categories();
		$cats       = array();
		foreach ($categories as $category) {
			$cats[$category->term_id] = $category->name;
		}
		$default = key($cats);
		$this->add_control(
			'catsid',
			[
				'label'    => __('Categories', 'ahura'),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => $cats,
				'label_block' => true,
				'multiple' => true,
				'default' => $default
			]
		);

		$this->add_control(
            'show_date',
            [
                'label' => esc_html__('Date', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
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
		 *  Styles
		 * 
		 * 
		 */
		$this->start_controls_section(
			'image_styles',
			[
				'label' => __('Image', 'ahura'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
            'img_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-3 img' => 'width: {{SIZE}}{{UNIT}};',
                ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
					'em' => [
                        'min' => 0,
                        'max' => 100
                    ],
					'rem' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
            ]
        );

		$this->add_responsive_control(
            'img_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-3 img' => 'height: {{SIZE}}{{UNIT}};',
                ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
					'em' => [
                        'min' => 0,
                        'max' => 100
                    ],
					'rem' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
            ]
        );

		$this->add_responsive_control(
            'img_opacity',
            [
                'label' => esc_html__('Opacity', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-3 img' => 'opacity: {{SIZE}};',
                ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
						'step' => 0.1
                    ],
					'%' => [
                        'min' => 0,
                        'max' => 1,
						'step' => 0.1
                    ],
                ],
            ]
        );

		$this->add_control(
            'img_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-3 img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .post-list-3 img',
            ]
        );

		$this->end_controls_section();
		$this->start_controls_section(
			'title_styles',
			[
				'label' => __('Title', 'ahura'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'direction',
			[
				'label' => __('Alignment', 'ahura'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => __('Right', 'ahura'),
						'icon' => 'eicon-text-align-right',
					],
					'left' => [
						'title' => __('Left', 'ahura'),
						'icon' => 'eicon-text-align-left',
					]
				],
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => true,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Title Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#181F25',
				'selectors' => [
					'{{WRAPPER}} .post-list-3-title' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'metas_color',
			[
				'label' => __('Meta Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#AAAAAA',
				'selectors' => [
					'{{WRAPPER}} .post-list-3-title .metas span' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .post-list-3 .post-list-3-title' => 'background-color: {{VALUE}}',
                ]
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __('Title Typography','ahura'),
				'selector' => '{{WRAPPER}} .post-list-3-title',
				'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '19'
						]
					]
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'metas_typography',
				'label' => __('Meta Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .post-list-3-title .metas span',
				'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '15'
						]
					]
				]
			]
		);

		$this->add_control(
            'title_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-3 .post-list-3-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'title_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .post-list-3 .post-list-3-title',
            ]
        );

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$catidd   = $settings['catsid'];
		$first_cat_id = $catidd && is_array($catidd) ? $catidd[0] : $catidd;
		$postbox1 = new \WP_Query(array(
			'posts_per_page' => 1,
			'cat'            => $catidd,
		));
		if ($postbox1->have_posts()) : ?>
			<?php 
			while ($postbox1->have_posts()) : $postbox1->the_post();
				$gmdate = get_the_date('F j, Y');
                $date = $gmdate;
			?>
				<div class="post-list-3 post-list-3-<?php echo $settings['direction']; ?>">
					<div class="post-list-3-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail($settings['item_cover_size']); ?>
						</a>
						<a href="<?php the_permalink(); ?>" class="post-list-3-title">
							<?php the_title(); ?>
							<?php if ( $settings['show_date'] == 'yes' ) : ?>
								<div class="metas">
									<span><i class="fa fa-clock"></i> <?php echo $date; ?></span>
								</div>
							<?php endif; ?>
						</a>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<div class="mw_element_error">
				<?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.', 'ahura'); ?>
			</div>
		<?php endif; ?>
		<div class="clear"></div>
<?php
	}
}
