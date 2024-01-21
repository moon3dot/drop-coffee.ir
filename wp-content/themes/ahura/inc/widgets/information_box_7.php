<?php

namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

defined('ABSPATH') or die('No script kiddies please!');

class information_box_7 extends \Elementor\Widget_Base
{
    private const ICON_BOX_DEFAULT_ALIGNMENT_DESKTOP = 'right';
    private const ICON_BOX_DEFAULT_ALIGNMENT_TABLET = 'top';
    private const ICON_BOX_DEFAULT_ALIGNMENT_MOBILE = 'top';

    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_information_box_7';
    }
    public function get_icon() {
		return 'aicon-svg-information-box-7';
	}
    function get_title()
    {
        return esc_html__('Information box 7', 'ahura');
    }
    function get_categories()
    {
        return ['ahuraelements'];
    }
    function get_keywords()
    {
        return ['informationbox7', 'information_box_7', esc_html__('Information box 7', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $information_box_7_css = mw_assets::get_css('elementor.information_box_7');
        mw_assets::register_style('information_box_7', $information_box_7_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('information_box_7')];
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
                'label' => __('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-tags',
                    'library' => 'solid',
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Title Here', 'ahura'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         *
         * Styles
         *
         *
         */
        $this->start_controls_section(
            'icon_section',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_box_alignment',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => self::ICON_BOX_DEFAULT_ALIGNMENT_DESKTOP,
                'tablet_default' => self::ICON_BOX_DEFAULT_ALIGNMENT_TABLET,
                'mobile_default' => self::ICON_BOX_DEFAULT_ALIGNMENT_MOBILE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'ahura'),
                        'icon' => 'eicon-arrow-left',
                    ],
                    'top' => [
                        'title' => __('Top', 'ahura'),
                        'icon' => 'eicon-arrow-up',
                    ],
                    'right' => [
                        'title' => __('Right', 'ahura'),
                        'icon' => 'eicon-arrow-right',
                    ]
                ],
            ]
        );
        $this->add_control(
			'icon_box_background',
			[
				'label' => __('Background Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#3663f9',
				'selectors' => [
					'{{WRAPPER}} .information-box-7-icon::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .information-box-7-item-icon' => 'background-color: {{VALUE}}',
                ]
			]
		);
        $this->add_control(
			'icon_color',
			[
				'label' => __('Icon Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .information-box-7-item-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .information-box-7-item-icon svg' => 'fill: {{VALUE}}',
                ]
			]
		);
        $this->add_control(
            'icon_wrapper_bg_color',
            [
                'label' => __('Wrapper background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .information-box-7 .information-box-7-icon::after' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon size', 'ahura'),
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
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .information-box-7-item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .information-box-7-item-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->add_control(
            'icon_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-7-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .information-box-7-item-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .information-box-7-icon::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .information-box-7-icon::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 100,
                    'right' => 100,
                    'bottom' => 100,
                    'left' => 100,
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_box_margin',
            [
                'label' => esc_html__('Icon Box Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .information-box-7-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' =>
                [
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'content_styles',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .information-box-7 .information-box-7-content span' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Title Typography', 'ahura'),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .information-box-7-content span',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						]
                    ],'font_weight' => [
                        'default' => '600'
                    ],'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '40',
						]
                    ],
				]
			]
		);

        $this->add_control(
            'description_color',
            [
                'label' => __('Description color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .information-box-7 .information-box-7-content p' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Description Typography', 'ahura'),
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .information-box-7-content p',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						]
                    ],'font_weight' => [
                        'default' => '400'
                    ],'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '23',
						]
                    ],
				]
			]
		);

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Description Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .information-box-7-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' =>
                [
                    'isLinked' => false,
                    'right' => '150',
                ],
                'tablet_default' =>
                [
                    'isLinked' => false,
                    'top' => '70',
                ],
                'mobile_default' =>
                [
                    'isLinked' => false,
                    'top' => '70',
                ],
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

        $this->add_responsive_control(
            'box_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'selectors' => [
                    '{{WRAPPER}} .information-box-7-content' => 'text-align: {{VALUE}};'
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

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .information-box-7 .information-box-7-item',
                'fields_options' => [
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

        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-7-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 100,
                    'right' => 100,
                    'bottom' => 100,
                    'left' => 100,
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'ahura' ),
				'selector' => '{{WRAPPER}} .information-box-7-item',
                'fields_options' =>
					[
						'box_shadow_type' =>
                        [ 
                            'default' =>'yes' 
                        ],
						'box_shadow' => [
							'default' =>
								[
									'horizontal' => -6,
                                    'vertical' => 0,
                                    'blur' => 9,
                                    'spread' => 0,
                                    'color' => 'rgba(0,0,0,.1)',
								]
						]
					]
			]
		);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $desktop_alignment = isset($settings['icon_box_alignment']) ? $settings['icon_box_alignment'] : self::ICON_BOX_DEFAULT_ALIGNMENT_DESKTOP;
        $table_alignment = isset($settings['icon_box_alignment_tablet']) ? $settings['icon_box_alignment_tablet'] : self::ICON_BOX_DEFAULT_ALIGNMENT_TABLET;
        $mobile_alignment = isset($settings['icon_box_alignment_mobile']) ? $settings['icon_box_alignment_mobile'] : self::ICON_BOX_DEFAULT_ALIGNMENT_MOBILE;
        $alignment_class = sprintf('desktop-%s tablet-%s mobile-%s', $desktop_alignment, $table_alignment, $mobile_alignment);
        ?>
        <div class="information-box-7">
            <div class="information-box-7-item <?php echo $alignment_class?>">
                <div class="information-box-7-icon">
                    <div class="information-box-7-item-icon">
                        <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                </div>
                <div class="information-box-7-content">
                    <span><?php echo $settings['title'] ?></span>
                    <p><?php echo $settings['description'] ?></p>
                </div>
            </div>
        </div>
    <?php
    }
}
