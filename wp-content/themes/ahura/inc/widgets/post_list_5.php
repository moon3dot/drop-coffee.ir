<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class post_list_5 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_post_list_5';
    }
    function get_title()
    {
        return esc_html__('Post list 5', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements', 'ahura_posts' ];
	}
    function get_keywords()
    {
        return ['postlist5', 'post list 5','post_list_5',esc_html__('Post list 5', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $post_list_5_css = mw_assets::get_css('elementor.post_list_5');
        mw_assets::register_style('elementor_post_list_5', $post_list_5_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_post_list_5')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'main_content',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );
		$allCategories = get_categories();
        $categoryList = [];
        foreach($allCategories as $item)
        {
            $categoryList[$item->term_id] = $item->name;
        }

        $this->add_control(
			'category_ids',
			[
				'label'    => __( 'Categories', 'ahura' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => $categoryList,
				'label_block' => true,
				'multiple' => true,
				'default' => key($categoryList),
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'posts_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'thumbnail',
			]
		);

        $this->add_control(
            'show_des',
            [
                'label' => esc_html__('Show Description', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_chars_count',
            [
                'label'   => __( 'Excerpt Characters', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
                'condition' => [
                    'show_des' => 'yes'
                ]
            ]
        );

        $this->add_control(
			'posts_count',
			[
				'label'      => __( 'Number of posts', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 4
			]
		);

        $this->add_control(
            'layout_col',
            [
                'label' => esc_html__('Columns', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 1,
                'options' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                ]
            ]
        );

        $this->add_control(
			'posts_order',
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
				'toggle' => false,
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
            'main_style',
            [
                'label' => esc_html__('Main', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .ahura_element_post_list_5 .ah-item',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#f9f9f9'
                            ],
                    ]
            ]
        );

        $this->add_control(
			'items_gap',
			[
				'label' => esc_html__( 'Items gap', 'ahura' ),
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'main_item_thumbnail_and_content_gap',
			[
				'label' => esc_html__( 'Thumbnail and content gap', 'ahura' ),
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
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5 .ah-item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'main_item_border_radius',
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
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5 .ah-item' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5 .ah-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    // 'isLinked' => false,
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'thumbnail_style',
            [
                'label' => esc_html__('Thumbnail', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'post_thumbnail_box_size',
            [
                'label' => esc_html__( 'Thumbnail box size', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'thumbnail_border_radius',
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
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-image' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 18,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                ],
			]
		);
        $this->add_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'excerpt_style',
            [
                'label' => esc_html__('Excerpt', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'excerpt_text_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-content .ah-excerpt' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-content .ah-excerpt',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 15,
                        ],
                    ],
                ],
			]
		);
        $this->add_control(
			'excerpt_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-content .ah-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'meta_style',
            [
                'label' => esc_html__('Meta data', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'meta_label_text_color',
            [
                'label' => esc_html__('Label color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-meta .ah-label' => 'color: {{VALUE}};'
                ],
                'default' => '#ADADAD',
            ]
        );
        $this->add_control(
            'meta_value_text_color',
            [
                'label' => esc_html__('Value color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-meta .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => '#5D5D5D',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'meta_label_typography',
                'label' => esc_html__('Label typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-meta .ah-label',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 15,
                        ],
                    ],
                ],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'meta_value_typography',
                'label' => esc_html__('Value typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-meta .ah-value',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 15,
                        ],
                    ],
                ],
			]
		);

        $this->add_control(
			'meta_items_gap',
			[
				'label' => esc_html__( 'Items gap', 'ahura' ),
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
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-meta' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'meta_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_5 .ah-item .ah-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '20',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
        $this->end_controls_section();
    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
        $categoryIds = $settings['category_ids'];
        $args = [
            'posts_per_page' => $settings['posts_count'] ? $settings['posts_count'] : 3,
            'cat' => $categoryIds,
            'order' => $settings['posts_order'] ? $settings['posts_order'] : 'DESC',
            'post_status' => 'publish',
        ];
        $posts = new \WP_Query($args);
        ?>
        <div class="ahura_element_post_list_5 post-list-5-element cols-<?php echo $settings['layout_col'] ?>">
            <?php if($posts->have_posts()): ?>
                <?php while($posts->have_posts()): $posts->the_post()?>
                    <a href="<?php the_permalink()?>" class="ah-item">
                        <div class="ah-image d-flex justify-content-center align-items-center">
                            <?php echo get_the_post_thumbnail(get_the_ID(), $settings['posts_thumbnail_size'])?>
                        </div>
                        <div class="ah-content">
                            <div class="ah-title"><?php the_title(); ?></div>
                            <?php if($settings['show_des'] === 'yes'): ?>
                                <div class="ah-excerpt"><?php
                                    if($chars_num){
                                        echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
                                    } else {
                                        the_excerpt();
                                    }
                                    ?></div>
                            <?php endif; ?>
                            <div class="ah-meta">
                                <div class="ah-author">
                                    <span class="ah-label"><?php _e('Author', 'ahura')?></span>
                                    <span class="ah-value"><?php the_author()?></span>
                                </div>
                                <div class="ah-date">
                                    <span class="ah-label"><?php _e('Date', 'ahura')?></span>
                                    <span class="ah-value"><?php the_date(get_option('date_format')); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <?php
    }
}