<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class card_box_4 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_card_box_4';
    }
    function get_title()
    {
        return esc_html__('Card 4', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['cardbox4','card_box_4',esc_html__('Card 4', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $card_box_4_css = mw_assets::get_css('elementor.card_box_4');
        mw_assets::register_style('elementor_card_box_4', $card_box_4_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_card_box_4')];
    }
    protected function register_controls()
    {

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
        if(is_rtl()) {
            $AlignmentOptions = array_reverse($AlignmentOptions);
        }
        
        $this->start_controls_section(
            'main_content',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-leaf',
                    'library' => 'regular',
                ],
            ]
        );
        $this->add_control(
            'label_text',
            [
                'label' => esc_html__('Label', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Label text', 'ahura'),
                'default' => esc_html__('Special Support', 'ahura'),
            ]
        );
        $this->add_control(
            'main_value_text',
            [
                'label' => esc_html__('Value', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Unlimited', 'ahura'),
                'default' => esc_html__('Unlimited', 'ahura'),
            ]
        );
        $this->add_control(
            'title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Type title text here', 'ahura'),
                'default' => esc_html__('The world is full of magic things patiently waiting for our senses to grow sharper.', 'ahura'),
            ]
        );
        $this->add_control(
            'description_text',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Type description here', 'ahura'),
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
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
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'color' => ['default' => '#fdbb2d'],
                    'color_b' => ['default' => '#22c1c3'],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 80,
                        ],
                    ],
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4',
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
			'main_box_before_border_radius',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_4' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_card_box_4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '40',
                    'bottom' => '40',
                    'right' => '40',
                    'left' => '40',
                    'unit' => 'px',
                    // 'isLinked' => false,
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
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-icon',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                ],
			]
		);
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_4 .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_card_box_4 .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'icon_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-icon',
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'color' => ['default' => '#ecb643'],
                    'color_b' => ['default' => '#1e9ea0'],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 120,
                        ],
                    ],
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-icon',
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
			'icon_border_radius',
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
                            'name' => 'icon_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'icon_border_border',
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
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'icon_width',
			[
				'label' => esc_html__( 'Width', 'ahura' ),
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
                            'name' => 'icon_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'icon_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-label-wrapper .ah-label',
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
			'label_width',
			[
				'label' => esc_html__( 'Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 115,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-label-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'label_position',
			[
				'label' => esc_html__( 'Position', 'ahura' ),
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
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-label-wrapper' => is_rtl() ? 'left: {{SIZE}}{{UNIT}};' : 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
            'label_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_4 .ah-label-wrapper .ah-label' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'label_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-label-wrapper',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'color' => ['default' => '#aa8535'],
                    'color_b' => ['default' => '#1e9ea0'],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 100,
                        ],
                    ],
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'label_border',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-label-wrapper',
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
			'label_before_border_radius',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'label_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-label-wrapper' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-label-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '15',
                    'bottom' => '15',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'value_style',
            [
                'label' => esc_html__('Value Style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'value_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_4 .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => '#333c39',
            ]
        );
        
        $this->add_control(
			'value_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => $AlignmentOptions,
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-value' => 'text-align: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'value_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-value',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 60,
                        ],
                    ],
                ],
			]
		);
        $this->add_control(
			'value_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'title_style',
            [
                'label' => esc_html__('Title Style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_4 .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_control(
			'title_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => $AlignmentOptions,
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-title' => 'text-align: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 18,
                        ],
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
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'description_style',
            [
                'label' => esc_html__('Description Style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'description_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_card_box_4 .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
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
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-description' => 'text-align: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_card_box_4 .ah-description',
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
			'description_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_4 .ah-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        ?>
        <div class="ahura_element_card_box_4">
            <div class="ah-label-wrapper">
                <?php if(isset($settings['label_text'])): ?>
                    <div class="ah-label"><?php echo $settings['label_text']; ?></div>                
                <?php endif; ?>
            </div>
            <div class="ah-icon">
                <?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
            </div>
            <div class="ah-value"><?php echo $settings['main_value_text']; ?></div>
            <div class="ah-title"><?php echo $settings['title_text']; ?></div>
            <div class="ah-description"><?php echo $settings['description_text']; ?></div>
        </div>
        <?php
    }
}