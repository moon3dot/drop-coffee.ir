<?php

namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');


class post_archive2 extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'postarchive2';
    }

    public function get_title()
    {
        return __('Post Archive 2', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-post-archive-2';
    }

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }
    function get_keywords()
    {
        return ['post_archive2', 'postarchive2', esc_html__('Post Archive 2', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $post_archive2_css = mw_assets::get_css('elementor.post_archive2');
        mw_assets::register_style('post_archive2', $post_archive2_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('post_archive2')];
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
                'multiple' => false,
                'default' => $default
            ]
        );

        $this->add_control(
			'posts_count_number',
			[
				'label' => esc_html__( 'Posts Count', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'default' => 3,
			]
		);

        $this->add_control(
            'use_custom_title',
            [
                'label' => __('Custom Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'no',
                'options' => [
                    'yes' => [
                        'title' => __('Yes', 'ahura'),
                        'icon' => 'eicon-check'
                    ],
                    'no' => [
                        'title' => __('No', 'ahura'),
                        'icon' => 'eicon-close-circle'
                    ],
                ],
                'toggle' => false
            ]
        );
        $this->add_control(
            'custom_title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Blog', 'ahura'),
                'default' => __('Blog', 'ahura'),
                'condition' => [
                    'use_custom_title' => 'yes',
                ],
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

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'stthumb',
            ]
        );

        $this->add_control(
            'item_excerpt_show',
            [
                'label' => esc_html__('Excerpt', 'ahura'),
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
                'default' => 30,
                'condition' => [
                    'item_excerpt_show' => 'yes'
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
            'box_styles',
            [
                'label' => __('Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .ah-post-archive-2-element',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-post-archive-2-element',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-post-archive-2-element',
            ]
        );
        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ah-post-archive-2-element' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_wrap_shadow_box_shadow_type',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ah-post-archive-2-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'widget_title_style',
            [
                'label' => esc_html__('Title style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'widget_box_title_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-post-archive-2-element .ah-widget-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 32,
                        ],
                    ],
                    'font_weight' => ['default' => 'bold'],
                ],
            ]
        );
        // title color
        $this->add_control(
            'box_title_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ah-post-archive-2-element .ah-widget-title' => 'color: {{VALUE}};',
                ],
                'default' => '#35495c',
            ]
        );
        // title bg color
        $this->add_control(
            'box_title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ah-post-archive-2-element .ah-widget-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        // title border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_title_border',
                'selector' => '{{WRAPPER}} .ah-post-archive-2-element .ah-widget-title',
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
                            'right' => is_rtl() ? 5 : 0,
                            'left' => is_rtl() ? 0 : 5,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
            ]
        );
        // title border-radius
        $this->add_control(
            'box_title_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
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
                    '{{WRAPPER}} .ah-post-archive-2-element .ah-widget-title' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // title padding
        $this->add_control(
            'box_title_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ah-post-archive-2-element .ah-widget-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => is_rtl() ? 10 : 0,
                    'left' => is_rtl() ? 0 : 10,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // title margin
        $this->add_control(
            'box_title_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ah-post-archive-2-element .ah-widget-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->start_controls_section(
            'posts_box_style',
            [
                'label' => esc_html__('Posts box style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // bg
        $this->add_control(
            'post_item_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ah-post-archive-2-element .post-archive1' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'post_item_border',
				'selector' => '{{WRAPPER}} .ah-post-archive-2-element .post-archive1',
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
                        'default' => '#F3F3F3',
                    ],
                ],
			]
		);

        // box shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item_box_shadow',
                'selector' => '{{WRAPPER}} .ah-post-archive-2-element .post-archive1',
            ]
        );
        
        // border-radius
        $this->add_control(
			'post_item_border_radius',
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
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .ah-post-archive-2-element .post-archive1' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'post_item_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'post_item_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'post_item_box_shadow_box_shadow_type',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                    ],
                ],
			]
		);

        // padding
        $this->add_control(
			'post_item_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ah-post-archive-2-element .post-archive1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // margin
        $this->add_control(
			'post_item_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ah-post-archive-2-element .post-archive1' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        
        $this->start_controls_section(
            'image_styles',
            [
                'label' => __('Image', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_img_width',
            [
                'label' => esc_html__('Width', 'ahura'),
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
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'mobile_default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-archive1-thumbnail' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_img_height',
            [
                'label' => esc_html__('Height', 'ahura'),
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
                'default' => [
                    'unit' => 'px',
                    'size' => 255
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 180,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 180,
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-archive1-thumbnail' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'img_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
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
                    '{{WRAPPER}} .post-archive1-thumbnail' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'content_styles',
            [
                'label' => __('Content', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
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

        $this->add_control(
            'box_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl() ? 'right' : 'left'),
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .post-archive1-details' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'   => __('Title Color', 'ahura'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ah-post-archive-2-element .post-archive1-details h2' => 'color: {{VALUE}}'
                ],
                'default' => '#35495c',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typography',
                'label' => esc_html__('Title typography', 'ahura'),
                'selector' => '{{WRAPPER}} .post-archive1-details h2',
                'fields_options' =>
                [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ]
                    ],
                    'font_weight' => [
                        'default' => '700'
                    ]
                ]
            ]
        );

        $this->add_control(
            'description_text_color',
            [
                'label'   => __('Excerpt Color', 'ahura'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-archive1-details .ah-excerpt' => 'color: {{VALUE}}'
                ],
                'default' => '#35495c',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_description_typography',
                'label' => esc_html__('Excerpt Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .post-archive1-details .ah-excerpt',
                'fields_options' =>
                [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16
                        ]
                    ],
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'button_styles',
            [
                'label' => __('Button', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btn_align',
            [
                'label' => esc_html__('Position', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .post-archive1-details .btns-wrap' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'label' => __('Link Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .post-archive1-details a',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#fff',
                    ],
                ],
            ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label'   => __('Link Color', 'ahura'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-archive1-details a' => 'color: {{VALUE}}'
                ],
                'default' => '#2171d4',
            ]
        );

        // border
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'read_more_btn_border',
				'selector' => '{{WRAPPER}} .post-archive1-details a',
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
                        'default' => '#2171d4',
                    ],
                ],
			]
		);
        
        $this->add_control(
            'link_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .post-archive1-details a' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                    'size' => 5,
                ]
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
					'{{WRAPPER}} .post-archive1-details a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
        $widgetTitleText = $settings['custom_title_text'] ? $settings['custom_title_text'] : get_cat_name($settings['catsid']);
        $the_query = new \WP_Query(array(
            'posts_per_page' => $settings['posts_count_number'],
            'cat' => $settings['catsid'],
        ));
        ?>
        <div class="ah-post-archive-2-element">
            <?php if ($the_query->have_posts()) : ?>
                <div class="ah-widget-title"><?php echo $widgetTitleText; ?></div>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                    <div class="post-archive1">
                        <div class="post-archive1-thumbnail">
                            <?php the_post_thumbnail($settings['item_cover_size']) ?>
                        </div>
                        <div class="post-archive1-details">
                            <h2><?php the_title() ?></h2>
                            <?php if ($settings['item_excerpt_show'] === 'yes'): ?>
                                <div class="ah-excerpt"><?php
                                    if($chars_num){
                                        echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
                                    } else {
                                        the_excerpt();
                                    }
                                    ?></div>
                            <?php endif; ?>
                            <div class="btns-wrap">
                                <a href="<?php the_permalink() ?>" target="<?php echo $settings['target_link']; ?>">
                                    <?php echo esc_html__('View Post', 'ahura') ?>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
<?php
    }
}
