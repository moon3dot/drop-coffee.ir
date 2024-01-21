<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class price_box_9 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_price_box_9';
    }
    function get_title()
    {
        return esc_html__('Price box 9', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements', 'ahura_price_box' ];
	}
    function get_keywords()
    {
        return ['pricebox9','price_box_9',esc_html__('Price box 9', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $price_box_9_css = mw_assets::get_css('elementor.price_box_9');
        mw_assets::register_style('elementor_price_box_9', $price_box_9_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_price_box_9')];
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
            'label_text',
            [
                'label' => esc_html__('Label text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. Pro', 'price_box_element', 'ahura'),
                'default' => esc_html_x('Pro', 'price_box_element', 'ahura'),
            ]
        );
        $this->add_control(
			'use_icon_title',
			[
				'label' => esc_html__( 'Use icon', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
                'default' => 'no',
			]
		);
        $this->add_control(
            'title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. $9', 'price_box_element', 'ahura'),
                'default' => esc_html_x('$9', 'price_box_element', 'ahura'),
                'condition' => [
                    'use_icon_title!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'far fa-comment',
                    'library' => 'regular',
                ],
                'condition' => [
                    'use_icon_title' => 'yes',
                ],
            ]
        );
        
        
        
        $this->add_control(
            'description_text',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Type description here', 'ahura'),
                'default' => esc_html__('The world is full of magic things patiently waiting for our senses to grow sharper.', 'ahura'),
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
			'use_icon_in_button',
			[
				'label' => esc_html__( 'Use icon', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
                'default' => 'yes',
			]
		);

        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-check',
                    'library' => 'solid',
                ],
                'condition' => [
                    'use_icon_in_button' => 'yes',
                ],
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
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
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
                'placeholder' => esc_html_x('ex. Includes', 'price_box_element', 'ahura'),
                'default' => esc_html_x('Includes', 'price_box_element', 'ahura'),
            ]
        );

        $items = new \Elementor\Repeater();
        $items->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-check',
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
                'default' => '#190B28',
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
                        'item_icon' => ['value' => 'fa fa-check', 'library' => 'solid'],
                        'item_text' => esc_html__('Documentation of api', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check', 'library' => 'solid'],
                        'item_text' => esc_html__('Online meeting with your team', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check', 'library' => 'solid'],
                        'item_text' => esc_html__('24/7 supporting your site', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check', 'library' => 'solid'],
                        'item_text' => esc_html__('Support in ticket system', 'ahura'),
                    ],
                ],
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
                    '{{WRAPPER}} .ahura_element_price_box_9' => 'background-color: {{VALUE}}',
                ],
                'default' => 'white',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9',
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
                        'default' => '#f0f0f0',
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
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_price_box_9' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '30',
                    'bottom' => '50',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'label_style',
            [
                'label' => esc_html__('Label', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'label_text_color',
            [
                'label' => esc_html__('Label color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-label' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_control(
            'label_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-label' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-label',
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
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'label_border',
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-label',
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
                        'default' => '#e1e1e1',
                    ],
                ],
			]
		);
        $this->add_control(
			'label_border_radius',
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
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-label' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'label_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'label_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $AlignmentOptions = [
            'left' => [
                'title' => esc_html__( 'Left', 'ahura' ),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__( 'Center', 'ahura' ),
                'icon' => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => esc_html__( 'Right', 'ahura' ),
                'icon' => 'eicon-text-align-right',
            ],
        ];
        if(is_rtl())
        {
            $AlignmentOptions = array_reverse($AlignmentOptions);
        }
        $this->add_control(
			'title_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => $AlignmentOptions,
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-title' => 'text-align: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 40,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                ],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-title',
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
			'title_border_radius',
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
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-title' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $this->add_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '40',
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
            'description_style',
            [
                'label' => esc_html__('Description', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'description_text_color',
            [
                'label' => esc_html__('Description color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => '#848484',
            ]
        );
        $this->add_control(
            'description_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-description' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
			'description_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => $AlignmentOptions,
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-description' => 'text-align: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-description',
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
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'description_border',
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-description',
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
			'description_border_radius',
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
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-description' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'description_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $this->add_control(
			'description_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Button color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-button a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-button svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#ffffff',
            ]
        );
        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-button a' => 'background-color: {{VALUE}};',
                ],
                'default' => '#190B28',
            ]
        );
        $this->add_control(
			'button_is_full_width',
			[
				'label' => esc_html__( 'Full width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-button a' => 'flex: auto',
                ],
			]
		);
        $this->add_control(
			'button_justify_content',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => $AlignmentOptions,
				'default' => 'center',
				'toggle' => false,
                'condition' => [
                    'button_is_full_width!' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-button' => 'justify-content: {{VALUE}}',
				],
			]
		);
        $this->add_control(
			'button_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => $AlignmentOptions,
				'default' => 'center',
				'toggle' => false,
                'condition' => [
                    'button_is_full_width' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-button a' => 'text-align: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-button a',
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
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-button a',
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
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-button a' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
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
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '30',
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
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        
        $this->add_control(
			'items_section_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->start_controls_tabs(
            'items_style_tabs'
        );

        $this->start_controls_tab(
            'items_style_label_tab',
            [
                'label' => esc_html__( 'Label', 'ahura' ),
            ]
        );

        $this->add_control(
            'items_label_text_color',
            [
                'label' => esc_html__('Label color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_control(
            'items_label_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
			'item_label_is_fit_content',
			[
				'label' => esc_html__( 'Fit content', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'items_label_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'items_label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title' => 'width: fit-content;',
                ],
			]
		);
        $selfAlignmentOptions = [
            'start' => [
                'title' => is_rtl() ? esc_html__( 'Right', 'ahura' ) : esc_html__( 'Left', 'ahura' ),
                'icon' => is_rtl() ? 'eicon-text-align-right' : 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__( 'Center', 'ahura' ),
                'icon' => 'eicon-text-align-center',
            ],
            'end' => [
                'title' => is_rtl() ? esc_html__( 'Left', 'ahura' ) : esc_html__( 'Right', 'ahura' ),
                'icon' => is_rtl() ? 'eicon-text-align-left' : 'eicon-text-align-right',
            ],
        ];
        $this->add_control(
			'item_label_self_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => $selfAlignmentOptions,
				'default' => is_rtl() ? 'start' : 'left',
				'toggle' => false,
                'condition' => [
                    'item_label_is_fit_content' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title' => 'align-self: {{VALUE}}',
				],
			]
		);
        
        $this->add_control(
			'items_label_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => $AlignmentOptions,
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
                'condition' => [
                    'item_label_is_fit_content!' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title' => 'text-align: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'items_label_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title',
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
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'items_label_border',
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title',
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
			'items_label_border_radius',
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
                            'name' => 'items_label_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'items_label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'items_label_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        
        $this->add_control(
			'items_label_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $this->end_controls_tab();

        $this->start_controls_tab(
            'items_style_item_tab',
            [
                'label' => esc_html__( 'Items', 'ahura' ),
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'items_item_border',
				'selector' => '{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items .ah-item',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 0,
                            'bottom' => 1,
                            'right' => 0,
                            'left' => 0,
                            'isLinked' => false,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#ececec',
                    ],
                ],
			]
		);
        $this->add_control(
			'items_section_item_icon_and_text_gap',
			[
				'label' => esc_html__( 'Horizontal gap', 'ahura' ),
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
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items .ah-item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'items_item_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_9 .ah-items-wrapper .ah-items .ah-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button_link', $settings['button_link'] );
		}
        ?>
        <div class="ahura_element_price_box_9">
            <div class="ah-label"><?php echo $settings['label_text']; ?></div>

            <div class="ah-title">
                <?php if(isset($settings['use_icon_title']) && $settings['use_icon_title'] == 'yes'): ?>
                    <span class="ah-icon">
                        <?php \Elementor\Icons_Manager::render_icon($settings['title_icon'])?>
                    </span>
                <?php else: ?>
                    <span class="ah-text"><?php echo $settings['title_text']; ?></span>
                <?php endif; ?>
            </div>
            <div class="ah-description"><?php echo $settings['description_text']; ?></div>
            <div class="ah-button">
                <a <?php echo $this->get_render_attribute_string( 'button_link' ); ?>>
                    <?php if($settings['use_icon_in_button']): ?>
                        <span class="ah-icon">
                            <?php \Elementor\Icons_Manager::render_icon($settings['button_icon'])?>
                        </span>
                    <?php endif; ?>
                    <span class="ah-text"><?php echo $settings['button_text']; ?></span>
                </a>
            </div>

            <div class="ah-items-wrapper">
                <div class="ah-items-title"><?php echo $settings['items_title_text']; ?></div>
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
            </div>
        </div>
        <?php
    }
}