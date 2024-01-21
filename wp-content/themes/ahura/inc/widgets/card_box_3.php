<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class card_box_3 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_card_box_3';
    }
    function get_title()
    {
        return esc_html__('Card 3', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['card', 'card_3', 'card_box_3', 'cardbox3', esc_html__('Card 3', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $card_box_css = mw_assets::get_css('elementor.card_box_3');
        mw_assets::register_style('elementor_card_box_3', $card_box_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_card_box_3')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content',
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
                    'value' => 'fa fa-chart-pie',
                    'library' => 'solid',
                ],
            ]
        );
		$this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Statistics', 'ahura'),
                'default' => esc_html__('Statistics', 'ahura'),
            ]
        );
		$this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('Description here', 'ahura'),
                'default' => esc_html__('Growth compared to last month', 'ahura'),
            ]
        );
		$this->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. 1,280', 'card box element', 'ahura'),
                'default' => esc_html_x('1,280', 'card box element', 'ahura'),
            ]
        );
		$this->add_control(
            'second_value',
            [
                'label' => esc_html__('Second value', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. 15%', 'card box element', 'ahura'),
                'default' => esc_html_x('15%', 'card box element', 'ahura'),
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
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#003f56',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3' => 'background-color: {{VALUE}}',
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_card_box_3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
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
			'icon_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_3 .ah-icon',
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
			'icon_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'white',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_text_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_3 .ah-title',
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
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'white',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-description' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_text_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_3 .ah-description',
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
			'description_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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


		$this->start_controls_section(
            'value_style',
            [
                'label' => esc_html__('Value', 'ahura'),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'value_items_gap',
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
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value' => 'gap: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'main_value_heading',
			[
				'label' => esc_html__('Main value', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'value_text_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'white',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-first-value' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'value_bg_color',
			[
				'label' => esc_html__('Background color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-first-value' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'value_text_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-first-value',
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
			'value_border_radius',
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
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-first-value' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'value_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-first-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'second_value_heading',
			[
				'label' => esc_html__('Second value', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'second_value_text_color',
			[
				'label' => esc_html__('Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'green',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-second-value' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'second_value_bg_color',
			[
				'label' => esc_html__('Background color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#eaf4ea',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-second-value' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'second_value_text_typography',
				'selector' => '{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-second-value',
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
			'second_value_border_radius',
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
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-second-value' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'second_value_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_card_box_3 .ah-value .ah-second-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '5',
                    'bottom' => '2',
                    'right' => '10',
                    'left' => '10',
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
        <div class="ahura_element_card_box_3">
            <div class="ah-icon">
				<?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
			</div>
			<div class="ah-title"><?php echo $settings['title']; ?></div>
			<div class="ah-value">
				<span class="ah-first-value"><?php echo $settings['value']; ?></span>
				<span class="ah-second-value"><?php echo $settings['second_value']; ?></span>
			</div>
			<div class="ah-description"><?php echo $settings['description']; ?></div>
        </div>
        <?php
    }
}