<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined('ABSPATH') or die('No script kiddies please!');

class grid_posts_12 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_grid_posts_12';
    }
    function get_title()
    {
        return esc_html__('Grid posts 12', 'ahura');
    }
    function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }
    function get_keywords()
    {
        return ['gridposts12', 'grid_posts_12', esc_html__('Grid posts 12', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $grid_posts_12_css = mw_assets::get_css('elementor.grid_posts_12');
        mw_assets::register_style('elementor_grid_posts_12', $grid_posts_12_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_grid_posts_12')];
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
        foreach ($allCategories as $item) {
            $categoryList[$item->term_id] = $item->name;
        }

        $this->add_control(
            'category_ids',
            [
                'label'    => __('Categories', 'ahura'),
                'type'     => \Elementor\Controls_Manager::SELECT2,
                'options'  => $categoryList,
                'label_block' => true,
                'multiple' => true,
                'default' => key($categoryList),
            ]
        );

        $allTags = get_terms([
            'taxonomy' => 'post_tag',
            'hide_empty' => false,
        ]);
        $tagsList = [];
        if ($allTags) {
            foreach ($allTags as $item) {
                $tagsList[$item->term_id] = $item->name;
            }
        }

        $this->add_control(
            'tags_ids',
            [
                'label'    => __('Taxonomy', 'ahura'),
                'type'     => \Elementor\Controls_Manager::SELECT2,
                'options'  => $tagsList,
                'label_block' => true,
                'multiple' => true,
            ]
        );
        
        
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'posts_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => ['custom'],
                'include' => [],
                'default' => 'medium_large',
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
                    '{{WRAPPER}} .ah-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'posts_count',
            [
                'label'      => __('Number of posts', 'ahura'),
                'type'       => \Elementor\Controls_Manager::NUMBER,
                'default'    => 4
            ]
        );
        $this->add_control(
			'posts_column_number',
			[
				'label' => esc_html__( 'Column number', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => 1,
					'2' => 2,
					'3'  => 3,
					'4' => 4,
					'5' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-items' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
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
                        'icon' => 'fa fa-arrow-up'
                    ],
                    'DESC' => [
                        'title' => __('Descending', 'ahura'),
                        'icon' => 'fa fa-arrow-down'
                    ],
                ],
                'toggle' => false,
            ]
        );
        $this->add_control(
            'read_more_btn_text',
            [
                'label' => esc_html__('Read more button text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Read more', 'ahura'),
                'default' => __('Read more', 'ahura'),
            ]
        );

        $this->add_control(
            'item_excerpt_show',
            [
                'label' => esc_html__('Excerpt', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
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
                'type'    => Controls_Manager::NUMBER,
                'default' => 30,
                'condition' => [
                    'item_excerpt_show' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_box_style',
            [
                'label' => esc_html__('Content Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'content_box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box' => 'background-color: {{VALUE}}',
                ],
                'default' => 'white',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'content_box_border',
				'selector' => '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box',
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
        $this->add_control(
			'content_box_border_radius',
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
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'content_box_top_margin',
			[
				'label' => esc_html__( 'Position', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 90,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box.ah-up' => 'margin-top: -{{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'content_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'meta_data_style',
            [
                'label' => esc_html__('Meta data', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'metadata_section_items_gap',
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
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-meta-data' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'category_style_heading',
			[
				'label' => esc_html__( 'Category', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'category_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-meta-data .ah-category' => 'color: {{VALUE}};'
                ],
                'default' => "#2072bb",
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'category_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-meta-data .ah-category',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 14,
                        ],
                    ],
                ],
			]
		);
        $this->add_control(
			'date_style_heading',
			[
				'label' => esc_html__( 'Date', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'date_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-meta-data .ah-date' => 'color: {{VALUE}};'
                ],
                'default' => "#a4a4a4",
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'date_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-meta-data .ah-date',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 14,
                        ],
                    ],
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'content_style',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'title_style_heading',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => "black",
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 20,
                        ],
                    ],
                    'font_weight' => ['default' => 'bold'],
                ],
			]
		);
        $this->add_control(
			'title_line_height',
			[
				'label' => esc_html__( 'Line height', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 35,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-title' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);

        $this->add_control(
			'excerpt_style_heading',
			[
				'label' => esc_html__( 'Excerpt', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'excerpt_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-excerpt' => 'color: {{VALUE}};'
                ],
                'default' => "black",
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-excerpt',
                'fields_options' => [
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
			'excerpt_line_height',
			[
				'label' => esc_html__( 'Line height', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-excerpt' => 'line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'read_more_button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs('read_more_btn_style_tab');

        $this->start_controls_tab(
            'read_more_btn_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );
        $this->add_control(
            'read_more_btn_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-read-more' => 'color: {{VALUE}}',
                ],
                'default' => 'black',
            ]
        );
        $this->add_control(
            'read_more_btn_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-read-more' => 'background-color: {{VALUE}}',
                ],
                'default' => 'white',
            ]
        );
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'read_more_btn_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );
        $this->add_control(
            'read_more_btn_text_color_hover_mode',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-items .ah-item:hover .ah-content-box .ah-read-more' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'read_more_btn_bg_color_hover_mode',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-items .ah-item:hover .ah-content-box .ah-read-more' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
			'divider_items_hover_bg_color',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'read_more_btn_border',
				'selector' => '{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-read-more',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
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
                        'default' => '#f4f4f4',
                    ],
                ],
			]
		);

        $this->add_control(
			'read_more_btn_border_radius',
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
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-read-more' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'read_more_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    // 'isLinked' => false,
                ],
			]
		);
        $this->add_control(
			'read_more_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_grid_posts_12 .ah-content-box .ah-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
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
        $tags_id = $settings['tags_ids'];
        $taxQuery = [];
        if($categoryIds)
        {
            $taxQuery[] = [
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $categoryIds,
            ];
        }
        if($tags_id)
        {
            $taxQuery[] = [
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tags_id,
            ];
        }
        if(!empty($taxQuery))
        {
            $taxQuery['relation'] = 'AND';
        }
        $args = [
            'post_status' => 'publish',
            'posts_per_page' => $settings['posts_count'] ? $settings['posts_count'] : 4,
            'order' => $settings['posts_order'] ? $settings['posts_order'] : 'DESC',
            'tax_query' => $taxQuery,
        ];
        $posts = new \WP_Query($args);
        ?>
        <div class="ahura_element_grid_posts_12">
            <div class="ah-items">
                <?php if ($posts->have_posts()) : ?>
                    <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                        <?php
                        $categories = get_the_category();
                        $postCategory = $categories[0]->name;
                        $postDate = get_the_date(get_option('date_format'));
                        $postImage = get_the_post_thumbnail(get_the_ID(), $settings['posts_thumbnail_size']);

                        ?>
                        <a href="<?php the_permalink() ?>" class="ah-item">
                            <div class="ah-image"><?php echo $postImage; ?></div>
                            <div class="ah-content-box <?php echo has_post_thumbnail() ? 'ah-up' : ''; ?>">
                                <div class="ah-meta-data">
                                    <div class="ah-category"><?php echo $postCategory; ?></div>
                                    <div class="ah-date"><?php echo $postDate ?></div>
                                </div>
                                <div class="ah-title"><?php the_title() ?></div>
                                <?php if ($settings['item_excerpt_show'] === 'yes'): ?>
                                    <div class="ah-excerpt"><?php
                                        if($chars_num){
                                            echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
                                        } else {
                                            the_excerpt();
                                        }
                                        ?></div>
                                <?php endif; ?>
                                <div class="ah-read-more"><?php echo $settings['read_more_btn_text']; ?></div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p><?php _e('Sorry,no posts were found for display.', 'ahura')?></p>
                <?php endif; ?>
            </div>
        </div>
<?php
        wp_reset_postdata();
    }
}
