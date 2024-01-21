<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class card_box extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_card_box';
    }
    function get_title()
    {
        return esc_html__('Card', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['card', 'card_1', 'card_box', 'cardbox', esc_html__('Card', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $card_box_css = mw_assets::get_css('elementor.card_box');
        mw_assets::register_style('elementor_card_box', $card_box_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_card_box')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'box_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-users',
                    'library' => 'solid',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'box_section',
            [
                'label' => esc_html__('Text', 'ahura'),
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Total users', 'ahura'),
                'default' => esc_html__('Total users', 'ahura'),
            ]
        );
        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Growth in last week', 'ahura'),
                'default' => esc_html__('Growth in last week', 'ahura'),
            ]
        );
        $this->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. 1,980,010', 'ahura'),
                'default' => esc_html__('1,980,010', 'ahura'),
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
                    '{{WRAPPER}} .ahura_element_card_box' => 'background-color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );

        $this->add_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '30',
                    'bottom' => '30',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
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
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'main_box_texts_gap',
			[
				'label' => esc_html__( 'Texts gap', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
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
					'{{WRAPPER}} .ahura_element_card_box .ah-texts' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'main_box_radius',
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
					'{{WRAPPER}} .ahura_element_card_box' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
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
            'icon_box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box .ah-icon-section .ah-icon' => 'background-color: {{VALUE}};'
                ],
                'default' => '#ffe300',
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box .ah-icon-section .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_card_box .ah-icon-section .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
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
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box .ah-icon-section .ah-icon' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ahura_element_card_box .ah-icon-section .ah-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'icon_box_width',
			[
				'label' => esc_html__( 'Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box .ah-icon-section .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'icon_box_radius',
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
                    'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box .ah-icon-section .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
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
            'title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => '#868686',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-title',
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
            'title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-title' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'title_style_more_options' => 'yes',
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
					'{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'condition' => [
                    'title_style_more_options' => 'yes',
                ]
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
                'condition' => [
                    'title_style_more_options' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-title' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
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
            'value_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'value_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-value',
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
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-value' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'value_style_more_options' => 'yes',
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
					'{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'condition' => [
                    'value_style_more_options' => 'yes',
                ]
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
                'condition' => [
                    'value_style_more_options' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-value' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => '#ffe300',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-description',
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
            'description_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-description' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'description_style_more_options' => 'yes',
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
					'{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'condition' => [
                    'description_style_more_options' => 'yes',
                ]
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
                'condition' => [
                    'description_style_more_options' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box .ah-texts .ah-description' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->end_controls_section();
    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        ?>
        <div class="ahura_element_card_box">
            <div class="ah-icon-section">
                <span class="ah-icon">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
                </span>
            </div>
            <div class="ah-texts">
                <span class="ah-title"><?php echo $settings['title']; ?></span>
                <span class="ah-value"><?php echo $settings['value']; ?></span>
                <span class="ah-description"><?php echo $settings['description']; ?></span>
            </div>
        </div>
        <?php
    }
}