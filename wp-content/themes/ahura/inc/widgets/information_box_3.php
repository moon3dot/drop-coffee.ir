<?php
namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class information_box_3 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;

    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $information_box_3_css = mw_assets::get_css('elementor.information_box_3');
        mw_assets::register_style('information_box_3', $information_box_3_css);
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('information_box_3')];
    }

    public function get_name()
    {
        return 'ahura_information_box_3';
    }
    public function get_icon() {
		return 'aicon-svg-information-box-3';
	}
    function get_title()
    {
        return esc_html__('Information Box 3', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['informationbox3', 'information_box_3', esc_html__('Information Box 3', 'ahura')];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'library' => 'solid',
                    'value' => 'fas fa-rocket'
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Title', 'ahura'),
                'default' => esc_html__('Title Here', 'ahura'),
            ]
        );

        $this->add_control(
            'description_text',
            [
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Description Here', 'ahura'),
                'label' => esc_html__('Description', 'ahura')
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
            'title_section',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Color', 'ahura'),
                'default' => '#35495c',
                'selectors' =>
                    [
                        '{{WRAPPER}} .title' => 'color: {{VALUE}}'
                    ]
            ]
        );
        $this->add_control(
            'title_alignment',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'ahura'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => __('Center', 'ahura'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => __('Right', 'ahura'),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .title' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .title span',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '20'
                            ]
                        ],
                        'font_weight' => [
                            'default' => 'bold'
                        ]
                    ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'description_section',
            [
                'label' => esc_html__('Description', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Color', 'ahura'),
                'default' => '#35495c',
                'selectors' =>
                    [
                        '{{WRAPPER}} .content p' => 'color: {{VALUE}}'
                    ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .content p',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '16'
                            ]
                        ],
                    ]
            ]
        );

        $alignment = [
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-text-align-left'
            ],
            'center' => [
                'title' => __('Center', 'ahura'),
                'icon' => 'eicon-text-align-center'
            ],
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-text-align-right'
            ]
        ];

        $this->add_control(
            'box_des_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .content p' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_section',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ahura'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 80,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .icon-box .icon-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .icon-box .icon-wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'icon_padding_hr',
			[
				'label' => esc_html__( 'Icon padding horizontal', 'ahura'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .icon-box .icon-wrapper i' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .icon-box .icon-wrapper svg' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .icon-box .icon-wrapper i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .icon-box .icon-wrapper svg' => 'fill: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Icon background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#39ca9d',
                'selectors' => [
                    '{{WRAPPER}} .icon-box .icon-wrapper' => 'background-color: {{VALUE}}; box-shadow: 0 0 10px 0 {{VALUE}}4d;',
                    '{{WRAPPER}} .back-card::before' => 'background-color: {{VALUE}}',
                ]
            ]
        );
        $this->add_control(
            'icon_border_color',
            [
                'label' => esc_html__('Icon border color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .icon-box .icon-wrapper' => 'border-color: {{VALUE}}',
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'box_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_information_box_3' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .back-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_information_box_3' => 'padding: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .ahura_element_information_box_3',
                'fields_options' =>
                [
                    'background' =>
                    [
                        'default' => 'classic'
                    ],
                    'color' => 
                    [
                        'default' => '#ffffff'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'front_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_information_box_3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'front_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_information_box_3',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'back_box_section',
            [
                'label' => esc_html__('Back box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'back_box_bg',
                'selector' => '{{WRAPPER}} .ahura_element_information_box_3 .back-card',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#ffffff'
                            ],
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'back_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_information_box_3 .back-card',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'back_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_information_box_3 .back-card',
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="ahura_element_information_box_3">
            <div class="back-card"></div>
            <div class="icon-box">
                <div class="icon-wrapper">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
                </div>
            </div>
            <div class="title">
                <span><?php echo $settings['title'];?></span>
            </div>
            <div class="content">
                <p><?php echo $settings['description_text']?></p>
            </div>
        </div>
        <?php
    }
}
