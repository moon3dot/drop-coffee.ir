<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts10 extends \Elementor\Widget_Base
{
    /**
     * grid_posts10 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts10_css', mw_assets::get_css('elementor.grid_posts10'));

        if(!is_rtl()){
            mw_assets::register_style('grid_posts10_ltr_css', mw_assets::get_css('elementor.ltr.grid_posts10_ltr'));
        }

        mw_assets::register_script('grid_posts10_js', mw_assets::get_js('elementor.grid_posts10'));
        mw_assets::localize('grid_posts10_js', 'gp10', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_posts10_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('grid_posts10_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('grid_posts10_js')];
    }

    public function get_name()
    {
        return 'grid_posts10';
    }

    public function get_title()
    {
        return esc_html__('Grid Posts 10', 'ahura');
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }

    public function get_keywords()
    {
        return ['gridposts10', 'grid_posts10', __('Grid Posts 10', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'display_settings',
            [
                'label' => esc_html__('Layout', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Number of Per Page', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 12
            ]
        );

        $this->add_control(
            'layout_col',
            [
                'label' => esc_html__('Columns', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 4,
                'options' => [
                    '12' => 1,
                    '2' => 2,
                    '4' => 3,
                    '3' => 4,
                ]
            ]
        );

        $this->add_responsive_control(
            'layout_spacing',
            [
                'label' => esc_html__('Spacing', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25
                ],
                'selectors' => [
                    '{{WRAPPER}} .posts-list .row' => 'row-gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

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
        if(!is_rtl())
        {
            $alignment = array_reverse($alignment);
        }

        $this->add_control(
            'box_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => $alignment,
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-details' => 'text-align: {{VALUE}}',
                ]
            ]
        );
        $this->end_controls_section();
        /**
         *
         * More Settings
         *
         */
        $this->start_controls_section(
            'display_more_settings',
            [
                'label' => esc_html__('More Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'full',
            ]
        );

        $this->add_control('divider', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'show_filters',
            [
                'label' => esc_html__('Show Filters', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'item_meta_show',
            [
                'label' => esc_html__('Meta', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
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

        $this->add_control(
            'item_btn_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Read more', 'ahura'),
            ]
        );

        $this->end_controls_section();
        
        /**
         *
         *
         * Start styles section
         *
         *
         */

        
        /**
         *
         * Filters style
         *
         */
        $this->start_controls_section(
            'item_filters_styles',
            [
                'label' => esc_html__('Filters', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_filters' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'filters_item_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 120,
                        'max' => 400,
                    ],
                    'em' => [
                        'min' => 8,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 8,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 12,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 250
                ],
                'selectors' => [
                    '{{WRAPPER}} .posts-filter .select-box' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'filters_item_bg',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .posts-filter select' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'filters_item_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#777',
                'selectors' => [
                    '{{WRAPPER}} .posts-filter select' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .posts-filter .select-box::after' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filters_item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .posts-filter select',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => ['default' => '#dfdfdf']
                ]
            ]
        );

        $this->add_control(
            'filters_item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .posts-filter select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );
        $this->end_controls_section();

        /**
         * Image style
         */
        $this->start_controls_section(
            'item_img_styles',
            [
                'label' => esc_html__('Image', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_img_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .post-cover',
            ]
        );

        $this->add_responsive_control(
            'item_img_ration',
            [
                'label' => esc_html__('Image Ration', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 2,
                        'step' => 0.01,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 0.72,
                    'unit' => 'px',
                ],
                'desktop_default' => [
                    'size' => 0.72,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-cover' => 'padding-bottom: calc({{SIZE}} * 100%);'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         * Meta style
         */
        $this->start_controls_section(
            'meta_style',
            [
                'label' => esc_html__('Meta style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'item_meta_show' => 'yes',
                ],
            ]
        );
        
        // color
        $this->add_control(
            'meta_text_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Color', 'ahura'),
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-10 .post-metas' => 'color: {{VALUE}};',
                ],
                'default' => '#b3b3b3',
            ]
        );
        // bg-color
        $this->add_control(
            'meta_bg_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Color', 'ahura'),
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-10 .post-metas' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'meta_text_typography',
                'selector' => '{{WRAPPER}} .grid-posts-10 .post-metas',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 14,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 300,
                    ]
                ]
            ]
        );
        // border radius
        $this->add_control(
			'meta_box_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'condition' => [
                    'meta_bg_color!' => '',
                ],
                'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .grid-posts-10 .post-metas' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

        // padding
        $this->add_responsive_control(
			'meta_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .grid-posts-10 .post-metas' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $this->add_responsive_control(
			'meta_box_margin',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .grid-posts-10 .post-metas' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '10',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);

        $this->end_controls_section();
        
        /**
         * Box style
         */
        $this->start_controls_section(
            'item_box_styles',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('item_box_styles_tabs');

        $this->start_controls_tab(
            'item_box_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_bg_1',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#787878',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-excerpt, {{WRAPPER}} .element-post-content .post-excerpt p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .element-post-content .post-title a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Excerpt Typography', 'ahura'),
                'name' => 'item_excerpt_typography',
                'selector' => '{{WRAPPER}} .element-post-content .post-excerpt, {{WRAPPER}} .element-post-content .post-excerpt p',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'post_box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .element-post-content',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => ['default' => '#f0f0f0']
                ]
            ]
        );

        $this->add_control(
            'post_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .element-post-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .post-cover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
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

        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_box_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_bg_1_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-post-content:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_color_hover',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-post-content:hover .post-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_excerpt_color_hover',
            [
                'label' => esc_html__('Excerpt Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-post-content:hover .post-excerpt, {{WRAPPER}} .element-post-content:hover .post-excerpt p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'post_box_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .element-post-content:hover',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => ['default' => '#fdd439']
                ]
            ]
        );

        $this->add_control(
            'post_box_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .element-post-content:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .element-post-content:hover .post-cover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        
        $this->start_controls_section(
            'item_btn_styles',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'read_more_btn_alignment',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => $alignment,
                'default' => is_rtl() ? 'right' : 'left',
                'toogle' => true,
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .element-post-content-bottom' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $this->start_controls_tabs('item_buttons_styles_tabs');

        $this->start_controls_tab(
            'item_buttons_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_button_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-btn a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_button_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_button_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content:hover .post-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_button_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fdd439',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content:hover .post-btn a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'item_pagination_styles',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('item_pagination_styles_tabs');

        $this->start_controls_tab(
            'item_pagination_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#626262',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_pagination_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, .ahura-pagination span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, .ahura-pagination span:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_pagination_styles_active_tab',
            [
                'label' => esc_html__('Active', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_active_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_active_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     *
     * Render content for display
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();

        $chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
        $page = $_GET['page_num'] ?? false;
        $current_page = ($page == 0) ? 1 : $page;

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['per_page'],
            'post_status' => 'publish',
        );

        $posts = new \WP_Query($args);

        $cats = get_categories();
        if ($posts): ?>
            <div class="grid-posts-10 grid-posts-10-<?php echo $wid ?>" data-wid="<?php echo $wid; ?>">
                <div class="posts-filter" style="display:<?php echo $settings['show_filters'] === 'yes' ? 'block' : 'none' ?>">
                    <div class="select-box">
                        <select name="post_filter_cat_<?php echo $wid ?>" data-before-val="0" id="post-filter-<?php echo $wid ?>" data-wid="<?php echo $wid ?>" data-settings="<?php echo base64_encode(json_encode(array_merge($args, $settings))) ?>">
                            <option value="0"><?php _e('All Posts', 'ahura') ?></option>
                            <?php
                            if ($cats):
                                foreach ($cats as $cat): ?>
                                    <option value="<?php echo $cat->term_id ?>" data-tax="<?php echo $cat->taxonomy ?>"><?php echo $cat->name ?></option>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="posts-list">
                    <div class="row">
                        <?php include get_template_directory() . '/template-parts/loop/elementor/grid-posts10-load-ajax.php'; ?>
                    </div>
                </div>
                <?php if ($settings['show_pagination'] === 'yes'): ?>
                    <div class="ahura-pagination">
                        <?php ahura_custom_pagination($posts->found_posts, $settings['per_page'], $current_page, null, '<i class="fas fa-angle-right"></i>', '<i class="fas fa-angle-left"></i>'); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="mw_element_error">
                <?php echo esc_html__('Sorry, no posts were found for display.', 'ahura'); ?>
            </div>
        <?php
        endif;
    }
}