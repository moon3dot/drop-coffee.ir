<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined('ABSPATH') or die('No script kiddies please!');

class post_list_6 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_post_list_6';
    }
    function get_title()
    {
        return esc_html__('Post list 6', 'ahura');
    }
    function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }
    function get_keywords()
    {
        return ['postlist6', 'post list 6', 'post_list_6', esc_html__('Post list 6', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $post_list_6_css = mw_assets::get_css('elementor.post_list_6');
        mw_assets::register_style('elementor_post_list_6', $post_list_6_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_post_list_6')];
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
                'default' => 'thumbnail',
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
                'default' => 80,
                'condition' => [
                    'item_excerpt_show' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'general_style',
            [
                'label' => esc_html__('General style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // flex-direction
        $this->add_responsive_control(
            'post_item_flex_direction',
            [
                'type' => Controls_Manager::CHOOSE,
                'label' => esc_html__('Direction', 'ahura'),
                'desktop_default' => 'row',
                'tablet_default' => 'column',
                'mobile_default' => 'column',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item' => 'flex-direction: {{VALUE}}',
                ],
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'ahura'),
                        'icon' => 'eicon-navigation-horizontal',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'ahura'),
                        'icon' => 'eicon-navigation-vertical',
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'thumbnail_style',
            [
                'label' => esc_html__('Thumbnail style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // width
        $this->add_responsive_control(
			'image_box_width',
			[
				'label' => esc_html__( 'Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 350,
				],
                'tablet_default' => [
					'unit' => 'px',
					'size' => 320,
				],
                'mobile_default' => [
					'unit' => 'px',
					'size' => 320,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // height
        $this->add_control(
			'image_box_height',
			[
				'label' => esc_html__( 'Height', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 350,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // border-radius
        $this->add_control(
			'image_box_border_radius',
			[
				'label' => esc_html__( 'Height', 'ahura' ),
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
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-image' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'image_box_border',
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-image',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 2,
                            'bottom' => 2,
                            'right' => 2,
                            'left' => 2,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#E9E9E9',
                    ],
                ],
			]
		);
        // box-shadow
        $this->add_control(
			'image_box_box_shadow_active',
			[
				'label' => esc_html__( 'Box shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Active', 'ahura' ),
				'label_off' => esc_html__( 'Deactive', 'ahura' ),
				'return_value' => 'yes',
			]
		);
        $this->add_control(
			'image_box_box_shadow',
			[
				'label' => esc_html__( 'Box Shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
                'condition' => [
                    'image_box_box_shadow_active' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-image' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'category_style',
            [
                'label' => esc_html__('Category style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'category_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-category',
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
        
        // color
        $this->add_control(
            'category_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-category' => 'color: {{VALUE}};'
                ],
                'default' => "#888",
            ]
        );

        // bg color
        $this->add_control(
            'category_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-category' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        
        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'category_border',
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-category',
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
			'category_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'category_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'category_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-category' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // padding
        $this->add_control(
			'category_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        // margin
        $this->add_control(
			'category_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'title_style',
            [
                'label' => esc_html__('Title style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'name' => 'title_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 22,
                        ],
                    ],
                ],
			]
		);
        // color
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => '#3F3FBD',
            ]
        );

        // bg-color
        $this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-title' => 'background-color: {{VALUE}};'
                ],
                'default' => '#fff',
            ]
        );
        // line-height
        $this->add_control(
			'title_line_height',
			[
				'label' => esc_html__( 'Line height', 'ahura' ),
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
                    'size' => 40,
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-title-section .ah-title' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // margin
        $this->add_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-title-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->start_controls_section(
            'excerpt_style',
            [
                'label' => esc_html__('Excerpt style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'name' => 'excerpt_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-excerpt',
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
        // color
        $this->add_control(
            'excerpt_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-excerpt' => 'color: {{VALUE}};'
                ],
                'default' => "#4f4f4f",
            ]
        );
        // bg-color
        $this->add_control(
            'excerpt_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-excerpt' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'excerpt_border',
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-excerpt',
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
			'excerpt_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'excerpt_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'excerpt_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-excerpt' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // padding
        $this->add_control(
			'excerpt_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        // margin
        $this->add_control(
			'excerpt_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'meta_data_style',
            [
                'label' => esc_html__('Meta data style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // items gap
        $this->add_control(
			'meta_data_justify_content',
			[
				'label' => esc_html__( 'Justify content', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'space-between',
				'options' => [
					'start' => esc_html_x( 'Start', 'post_list_element', 'ahura' ),
					'end' => esc_html__( 'End', 'ahura' ),
					'space-between' => esc_html__( 'Space between', 'ahura' ),
					'space-around'  => esc_html__( 'Space around', 'ahura' ),
					'space-evenly' => esc_html__( 'Space evenly', 'ahura' ),
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta' => 'justify-content: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'meta_data_items_gap',
			[
				'label' => esc_html__( 'Items Gap', 'ahura' ),
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
					'size' => 0,
				],
                'condition' => [
                    'meta_data_justify_content!' => 'space-between',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // margin
        $this->add_control(
			'meta_data_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '30',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    // 'isLinked' => false,
                ],
			]
		);
        
        // author
        $this->add_control(
			'author_style_heading',
			[
				'label' => esc_html__( 'Author', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'name' => 'author_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-author',
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
        // color
        $this->add_control(
            'author_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-author' => 'color: {{VALUE}};'
                ],
                'default' => '#888',
            ]
        );
        // bg-color
        $this->add_control(
            'author_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-author' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'author_border',
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-author',
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
			'author_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'author_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'author_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-author' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // padding
        $this->add_control(
			'author_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        

        // date
        $this->add_control(
			'date_style_heading',
			[
				'label' => esc_html__( 'Date', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'name' => 'date_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-date',
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
        // color
        $this->add_control(
            'date_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-date' => 'color: {{VALUE}};'
                ],
                'default' => '#888',
            ]
        );
        // bg-color
        $this->add_control(
            'date_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-date' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'date_border',
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-date',
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
			'date_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'date_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'date_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-date' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // padding
        $this->add_control(
			'date_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-meta .ah-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'read_more_btn_style',
            [
                'label' => esc_html__('Button style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // typography
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'read_more_btn_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-read-more',
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
        
        // color
        $this->add_control(
            'read_more_btn_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-read-more' => 'color: {{VALUE}};'
                ],
                'default' => "white",
            ]
        );

        // bg color
        $this->add_control(
            'read_more_btn_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-read-more' => 'background-color: {{VALUE}};'
                ],
                'default' => '#31a5d2',
            ]
        );
        
        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'read_more_btn_border',
				'selector' => '{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-read-more',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'read_more_btn_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'read_more_btn_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-read-more' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        // padding
        $this->add_control(
			'read_more_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        // margin
        $this->add_control(
			'read_more_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_post_list_6 .ah-item .ah-content .ah-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $tags_id = $settings['tags_ids'];
        $taxQuery = [];

        if ($categoryIds) {
            $taxQuery[] = [
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $categoryIds,
            ];
        }
        if ($tags_id) {
            $taxQuery[] = [
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tags_id,
            ];
        }
        if (!empty($taxQuery)) {
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
        <div class="ahura_element_post_list_6">
            <?php if ($posts->have_posts()) : ?>
                <?php while ($posts->have_posts()) : $posts->the_post() ?>
                    <?php
                    $categories = get_the_category();
                    $postCategory = $categories[0]->name;
                    $postCategory = strtoupper($postCategory);
                    ?>
                    <a href="<?php the_permalink() ?>" class="ah-item">
                        <div class="ah-image">
                            <?php echo get_the_post_thumbnail(get_the_ID(), $settings['posts_thumbnail_size']) ?>
                        </div>
                        <div class="ah-content">
                            <div class="ah-category"><?php echo $postCategory; ?></div>
                            <div class="ah-title-section">
                                <h3 class="ah-title"><?php the_title(); ?></h3>
                            </div>
                            <?php if ($settings['item_excerpt_show'] === 'yes'): ?>
                                <div class="ah-excerpt"><?php
                                    if($chars_num){
                                        echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
                                    } else {
                                        the_excerpt();
                                    }
                                    ?></div>
                            <?php endif; ?>
                            <div class="ah-meta">
                                <div class="ah-author"><?php the_author() ?></div>
                                <div class="ah-date"><?php echo get_the_date(get_option('date_format')); ?></div>
                            </div>
                            <div class="ah-read-more"><?php echo $settings['read_more_btn_text']; ?></div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else : ?>
                <p><?php _e('Sorry,no posts were found for display.', 'ahura') ?></p>
            <?php endif; ?>
        </div>
<?php
    }
}
