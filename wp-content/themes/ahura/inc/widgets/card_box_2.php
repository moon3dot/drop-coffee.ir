<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class card_box_2 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_card_box_2';
    }
    function get_title()
    {
        return esc_html__('Card 2', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['card', 'card_2', 'card_box_2', 'cardbox2', esc_html__('Card 2', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $card_box_css = mw_assets::get_css('elementor.card_box_2');
        mw_assets::register_style('elementor_card_box_2', $card_box_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_card_box_2')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'top_section_content',
            [
                'label' => esc_html__('Top section', 'ahura'),
            ]
        );
        $this->add_control(
            'pre_title',
            [
                'label' => esc_html__('Pre title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Targeting', 'ahura'),
                'default' => esc_html__('Targeting', 'ahura'),
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Long-Term', 'ahura'),
                'default' => esc_html__('Long-Term', 'ahura'),
            ]
        );
        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('The world is full of magic things patiently waiting for our senses to grow sharper.', 'ahura'),
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'bottom_section_content',
            [
                'label' => esc_html__('Bottom section', 'ahura')
            ]
        );
        $this->add_control(
            'pre_value',
            [
                'label' => esc_html_x('Pre value', 'card box 2 element', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Annual growth', 'ahura'),
                'default' => esc_html__('Annual growth', 'ahura'),
            ]
        );
        $this->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. 22.3%', 'ahura'),
                'default' => esc_html__('22.3%', 'ahura'),
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-chevron-left',
                    'library' => 'solid',
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
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#F2E899',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'middle_line_color',
			[
				'label' => esc_html__('Middle line color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#CFC98F',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-line' => 'border-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'main_box_items_gap',
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
					'{{WRAPPER}} .ahura_element_card_box_2' => 'gap: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_card_box_2' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'box_style_more_options',
			[
				'label' => esc_html__( 'More options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_2',
                'condition' => [
                    'box_style_more_options' => 'yes',
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
					'{{WRAPPER}} .ahura_element_card_box_2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'box_style_more_options' => 'yes',
                ],
			]
		);
        $this->end_controls_section();
        
        $this->start_controls_section(
            'pre_title_style',
            [
                'label' => esc_html__('Pre title', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'pre_title_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#88856b',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-title' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pre_title_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-title',
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
			'pre_title_style_more_options',
			[
				'label' => esc_html__( 'More options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $this->add_control(
			'pre_title_is_fit_content',
			[
				'label' => esc_html__( 'Fit content', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition' => [
                    'pre_title_style_more_options' => 'yes',
                ],
			]
		);

        $alignmentOptions = [
            'right' => [
                'title' => esc_html__( 'Right', 'ahura' ),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => esc_html__( 'Center', 'ahura' ),
                'icon' => 'eicon-text-align-center',
            ],
            'left' => [
                'title' => esc_html__( 'Left', 'ahura' ),
                'icon' => 'eicon-text-align-left',
            ],
        ];
        if(!is_rtl())
        {
            $alignmentOptions = array_reverse($alignmentOptions);
        }
        $this->add_control(
			'pre_title_text_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
                'condition' => [
                    'pre_title_style_more_options' => 'yes',
                    'pre_title_is_fit_content!' => 'yes',
                ],
				'options' => $alignmentOptions,
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-title' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'pre_title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#15131324',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-title' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'pre_title_style_more_options' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
			'pre_title_box_border_radius',
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
					'size' => 5,
				],
                'condition' => [
                    'pre_title_style_more_options' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-title' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'pre_title_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'pre_title_style_more_options' => 'yes',
                ]
			]
		);
        $this->add_control(
			'pre_title_box_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'condition' => [
                    'pre_title_style_more_options' => 'yes',
                ]
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
			'title_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'black',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-title' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_2 .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                ],
			]
		);
        $this->add_control(
			'title_style_more_options',
			[
				'label' => esc_html__( 'More options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $this->add_control(
			'title_is_fit_content',
			[
				'label' => esc_html__( 'Fit content', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition' => [
                    'title_style_more_options' => 'yes',
                ],
			]
		);
        
        $this->add_control(
			'title_text_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
                'condition' => [
                    'title_style_more_options' => 'yes',
                    'title_is_fit_content!' => 'yes',
                ],
				'options' => $alignmentOptions,
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-title' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#15131324',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_2 .ah-title' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'title_style_more_options' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
			'title_box_border_radius',
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
					'size' => 5,
				],
                'condition' => [
                    'title_style_more_options' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-title' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'title_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'title_style_more_options' => 'yes',
                ]
			]
		);
        $this->add_control(
			'title_box_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'title_style_more_options' => 'yes',
                ]
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
			'description_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'black',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-description' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_2 .ah-description',
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
			'description_style_more_options',
			[
				'label' => esc_html__( 'More options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $this->add_control(
			'description_is_fit_content',
			[
				'label' => esc_html__( 'Fit content', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
                'condition' => [
                    'description_style_more_options' => 'yes',
                ],
			]
		);
        
        $this->add_control(
			'description_text_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
                'condition' => [
                    'description_style_more_options' => 'yes',
                ],
				'options' => $alignmentOptions,
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-description' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'description_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#15131324',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_2 .ah-description' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'description_style_more_options' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
			'description_box_border_radius',
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
					'size' => 5,
				],
                'condition' => [
                    'description_style_more_options' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-description' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'description_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'description_style_more_options' => 'yes',
                ]
			]
		);
        $this->add_control(
			'description_box_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'description_style_more_options' => 'yes',
                ]
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'pre_value_style',
            [
                'label' => esc_html_x('Pre value', 'card box 2 element', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'pre_value_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#88856b',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-value' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pre_value_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-value',
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
			'pre_value_style_more_options',
			[
				'label' => esc_html__( 'More options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $this->add_control(
			'pre_value_is_fit_content',
			[
				'label' => esc_html__( 'Fit content', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
                'condition' => [
                    'pre_value_style_more_options' => 'yes',
                ],
			]
		);
        
        $this->add_control(
			'pre_value_text_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
                'condition' => [
                    'pre_value_style_more_options' => 'yes',
                    'pre_value_is_fit_content!' => 'yes',
                ],
				'options' => $alignmentOptions,
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-value' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'pre_value_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#15131324',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-value' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'pre_value_style_more_options' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
			'pre_value_box_border_radius',
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
					'size' => 5,
				],
                'condition' => [
                    'pre_value_style_more_options' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-value' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'pre_value_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'pre_value_style_more_options' => 'yes',
                ]
			]
		);
        $this->add_control(
			'pre_value_box_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-pre-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'pre_value_style_more_options' => 'yes',
                ]
			]
		);
        $this->end_controls_section();



		$this->start_controls_section(
            'value_style',
            [
                'label' => esc_html__('Value', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'value_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'black',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-value' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'value_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-value',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 30,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                ],
			]
		);
        $this->add_control(
			'value_style_more_options',
			[
				'label' => esc_html__( 'More options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
            'value_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#15131324',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-value' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'value_style_more_options' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
			'value_box_border_radius',
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
					'size' => 5,
				],
                'condition' => [
                    'value_style_more_options' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-value' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'value_box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '0',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'value_style_more_options' => 'yes',
                ]
			]
		);
        $this->add_control(
			'value_box_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'allowed_dimensions' => ['right', 'left'],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'value_style_more_options' => 'yes',
                ]
			]
		);
        $this->end_controls_section();

		$this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'black',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => 'white',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-icon' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        
		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
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
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'icon_box_size',
			[
				'label' => esc_html__( 'Box size', 'ahura' ),
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
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
        $this->add_control(
			'icon_box_border_radius',
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
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_control(
			'icon_box_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'allowed_dimensions' => ['right', 'left'],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_2 .ah-value-section .ah-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $this->end_controls_section();
    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        ?>
        <div class="ahura_element_card_box_2">
            <div class="ah-top">
                <div class="ah-pre-title <?php echo isset($settings['pre_title_is_fit_content']) && $settings['pre_title_is_fit_content'] == 'yes' ? 'ah-fit-content' : '';?>"><?php echo $settings['pre_title']; ?></div>
                <div class="ah-title <?php echo isset($settings['title_is_fit_content']) && $settings['title_is_fit_content'] == 'yes' ? 'ah-fit-content' : '';?>"><?php echo $settings['title']; ?></div>
                <div class="ah-description"><?php echo $settings['description']; ?></div>
            </div>
            <hr class="ah-line">
            <div class="ah-bottom">
                <div class="ah-pre-value <?php echo isset($settings['pre_value_is_fit_content']) && $settings['pre_value_is_fit_content'] == 'yes' ? 'ah-fit-content' : '';?>"><?php echo $settings['pre_value']; ?></div>
                <div class="ah-value-section">
                    <div class="ah-value"><?php echo $settings['value']; ?></div>
                    <div class="ah-icon">
                        <?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}