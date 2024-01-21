<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class notice_box_3 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_notice_box_3';
    }
    function get_title()
    {
        return esc_html__('Notice box 3', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['notice box 3', 'notice_box_3','notice3', 'notice 3',esc_html__('Notice box 3', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('elementor_notice_box_3', mw_assets::get_css('elementor.notice_box_3'));
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_notice_box_3')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'icon_content',
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
                    'value' => 'fa fa-exclamation',
                    'library' => 'solid',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'main_content',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );
        $this->add_control(
            'title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Type title text here', 'ahura'),
                'default' => esc_html__('Notice text', 'ahura'),
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

        $this->add_control(
			'box_border_line_color',
			[
				'label' => esc_html__( 'Border line color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#5d9f5d',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_notice_box_3::before' => 'background-color: {{VALUE}}',
				],
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .ahura_element_notice_box_3',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => 'white'],
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .ahura_element_notice_box_3',
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
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow',
                'selector' => '{{WRAPPER}} .ahura_element_notice_box_3',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 1,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => '#0003'
                        ]
                    ]
                ],
            ]
        );
        $this->add_control(
			'box_items_gap',
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
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_notice_box_3' => 'gap: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_notice_box_3' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ahura_element_notice_box_3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '25',
                    'left' => '25',
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
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_notice_box_3 .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_notice_box_3 .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#6d8e6d',
            ]
        );
        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Icon background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_notice_box_3 .ah-icon' => 'background-color: {{VALUE}};'
                ],
                'default' => '#cdf0cd',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_notice_box_3 .ah-icon',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 50,
                        ],
                    ],
                ],
			]
		);
        $this->add_control(
			'icon_bg_box_type',
			[
				'label' => esc_html__( 'Box type', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'shield',
				'options' => [
					'shield' => esc_html__( 'Shield', 'ahura' ),
					'circle' => esc_html__( 'Circle', 'ahura' ),
					'square'  => esc_html__( 'Square', 'ahura' ),
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
					'size' => 10,
				],
                'condition' => [
                    'icon_bg_box_type' => 'square',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_notice_box_3 .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'selector' => '{{WRAPPER}} .ahura_element_notice_box_3 .ah-icon',
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
			'icon_width',
			[
				'label' => esc_html__( 'Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
                'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_notice_box_3 .ah-icon' => 'min-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .ahura_element_notice_box_3 .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => '#5d9f5d',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_notice_box_3 .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ]
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
                    '{{WRAPPER}} .ahura_element_notice_box_3 .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_notice_box_3 .ah-description',
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
        $this->end_controls_section();
    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="ahura_element_notice_box_3">
            <div class="ah-icon <?php printf("ah-%s", $settings['icon_bg_box_type'])?>">
                <?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
            </div>
            <div class="ah-content">
                <div class="ah-title"><?php echo $settings['title_text']; ?></div>
                <div class="ah-description"><?php echo $settings['description_text']; ?></div>
            </div>
        </div>
        <?php
    }
}