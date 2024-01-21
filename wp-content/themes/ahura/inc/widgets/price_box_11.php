<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class price_box_11 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_price_box_11';
    }
    function get_title()
    {
        return esc_html__('Price box 11', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements', 'ahura_price_box' ];
	}
    function get_keywords()
    {
        return ['pricebox11','price_box_11',esc_html__('Price box 11', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $price_box_11_css = mw_assets::get_css('elementor.price_box_11');
        mw_assets::register_style('elementor_price_box_11', $price_box_11_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_price_box_11')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'header_content',
            [
                'label' => esc_html__('Header', 'ahura'),
            ]
        );
        $this->add_control(
            'title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. Pro', 'price_box_element', 'ahura'),
                'default' => esc_html_x('Pro', 'price_box_element', 'ahura'),
            ]
        );
        $this->add_control(
            'description_text',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Description here', 'ahura'),
                'default' => esc_html__('Professional reporting system.', 'ahura'),
            ]
        );
        $this->add_control(
            'label_text',
            [
                'label' => esc_html__('Label', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. Most ordered', 'price_box_element', 'ahura'),
                'default' => esc_html_x('Most ordered', 'price_box_element', 'ahura'),
            ]
        );
        $this->add_control(
            'price_value',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. $9', 'price_box_element', 'ahura'),
                'default' => esc_html_x('$9', 'price_box_element', 'ahura'),
            ]
        );
        $this->add_control(
            'price_value_suffix',
            [
                'label' => esc_html__('Price suffix', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. / Mo', 'price_box_element', 'ahura'),
                'default' => esc_html_x('/ Mo', 'price_box_element', 'ahura'),
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'items_content',
            [
                'label' => esc_html__('Items', 'ahura'),
            ]
        );
        $this->add_control(
            'items_title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Features', 'ahura'),
                'default' => esc_html__('Features', 'ahura'),
            ]
        );
        $this->add_control(
            'items_description_text',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Description here', 'ahura'),
                'default' => esc_html__('In addition to all the features of the free version.', 'ahura'),
            ]
        );
        $items = new \Elementor\Repeater();
        $items->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-check-circle',
                    'library' => 'solid',
                ],
            ]
        );
        $items->add_control(
            'item_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Support in ticket system', 'ahura'),
                'default' => esc_html__('Support in ticket system', 'ahura'),
            ]
        );
        $items->add_control(
            'item_icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#161a35',
            ]
        );
        $items->add_control(
            'item_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $items->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_icon_typography',
                'label' => esc_html__('Icon Typography', 'ahura'),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon',
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
        $items->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_text_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-value',
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
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'label' => esc_html__('Items', 'ahura'),
                'title_field' => '{{{item_text}}}',
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Documentation of api', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Online meeting with your team', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('24/7 supporting your site', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Support in ticket system', 'ahura'),
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'button_content',
            [
                'label' => esc_html__('Button', 'ahura'),
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Choose plan', 'ahura'),
                'default' => esc_html__('Choose plan', 'ahura'),
            ]
        );
        $this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Link', 'ahura' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'options' => [ 'url', 'is_external', 'nofollow' ],
                'dynamic' => ['active' => true],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
			]
		);
        $this->end_controls_section();
        
        $this->start_controls_section(
            'box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11' => 'background-color: {{VALUE}}',
                ],
                'default' => 'white',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .ahura_element_price_box_11',
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
                        'default' => '#e6e6e6',
                    ],
                ],
			]
		);
        $this->add_control(
			'box_border_radius',
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
					'{{WRAPPER}} .ahura_element_price_box_11' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_price_box_11' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'header_style',
            [
                'label' => esc_html__('Header', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'header_border_color',
            [
                'label' => esc_html__('Border color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-header' => 'border-color: {{VALUE}};'
                ],
                'default' => '#e6e6e6',
            ]
        );
        $this->add_control(
			'header_title_heading',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-title .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-title .ah-value',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                    'font_weight' => ['default' => 'bold'],
                ],
			]
		);

        $this->add_control(
			'header_label_heading',
			[
				'label' => esc_html__( 'Label', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'title_label_color',
            [
                'label' => esc_html__('Label color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-title .ah-label' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_control(
            'title_label_bg_color',
            [
                'label' => esc_html__('Label background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-title .ah-label' => 'background-color: {{VALUE}};'
                ],
                'default' => '#161a35',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_label_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-title .ah-label',
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
			'title_label_border_radius',
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
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-title .ah-label' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'title_label_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-title .ah-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '15',
                    'left' => '15',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
        $this->add_control(
			'title_label_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-title .ah-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);

        $this->add_control(
			'header_subtitle_heading',
			[
				'label' => esc_html__( 'Subtitle', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Subtitle color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-subtitle' => 'color: {{VALUE}};'
                ],
                'default' => '#606060',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-subtitle',
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
			'subtitle_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-title-section .ah-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);

        $this->add_control(
			'price_heading',
			[
				'label' => esc_html__( 'Price', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-price-section .ah-price' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-price-section .ah-price',
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
			'price_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-price-section .ah-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);

        $this->add_control(
			'price_suffix_heading',
			[
				'label' => esc_html__( 'Price suffix', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'price_suffix_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-price-section .ah-price-suffix' => 'color: {{VALUE}};'
                ],
                'default' => '#919191',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_suffix_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-price-section .ah-price-suffix',
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
			'price_section_gap',
			[
				'label' => esc_html__( 'Distance from price', 'ahura' ),
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
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-header .ah-price-section' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
            'items_section_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'items_section_column_number',
			[
				'label' => esc_html__( 'Column number', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1' => 1,
					'2' => 2,
					'3'  => 3,
					'4' => 4,
					'5' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-items' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);
        $this->add_control(
			'items_title_heading',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'items_section_title_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'items_section_title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-title',
                'fields_options' => [
                    // 'font_size' => [
                    //     'default' => [
                    //         'unit' => 'px',
                    //         'size' => 25,
                    //     ],
                    // ],
                    'font_weight' => ['default' => 'bold'],
                ],
			]
		);

        $this->add_control(
			'items_section_description_heading',
			[
				'label' => esc_html__( 'Description', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'items_section_description_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => '#606060',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'items_section_description_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-description',
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
        $this->end_controls_section();

        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'button_section_top_border_color',
            [
                'label' => esc_html__('Separator border color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-button-wrapper' => 'border-color: {{VALUE}};'
                ],
                'default' => '#e6e6e6',
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-button-wrapper > a' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-button-wrapper > a' => 'background-color: {{VALUE}};'
                ],
                'default' => '#161a35',
            ]
        );
        $this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-button-wrapper > a' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-button-wrapper > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
			]
		);
        $this->add_control(
			'button_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_11 .ah-content .ah-button-wrapper > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button_link', $settings['button_link'] );
		}
        ?>
        <div class="ahura_element_price_box_11">
            <div class="ah-header">
                <div class="ah-title-section">
                    <div class="ah-title">
                        <span class="ah-value"><?php echo $settings['title_text']; ?></span>
                        <span class="ah-label"><?php echo $settings['label_text']; ?></span>
                    </div>
                    <div class="ah-subtitle"><?php echo $settings['description_text']; ?></div>
                </div>
                <div class="ah-price-section">
                    <div class="ah-price"><?php echo $settings['price_value']; ?></div>
                    <div class="ah-price-suffix"><?php echo $settings['price_value_suffix']; ?></div>
                </div>
            </div>
            <div class="ah-content">
                <div class="ah-title"><?php echo $settings['items_title_text']; ?></div>
                <div class="ah-description"><?php echo $settings['items_description_text']; ?></div>
                <div class="ah-items">
                    <?php foreach($settings['items'] as $item): ?>
                        <div class="ah-item elementor-repeater-item-<?php echo $item['_id'];?>">
                            <span class="ah-icon">
                                <?php \Elementor\Icons_Manager::render_icon($item['item_icon'])?>
                            </span>
                            <span class="ah-value"><?php echo $item['item_text']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="ah-button-wrapper">
                <a <?php echo $this->get_render_attribute_string( 'button_link' ); ?>><?php echo $settings['button_text']; ?></a>
                </div>
            </div>
        </div>
        <?php
    }
}