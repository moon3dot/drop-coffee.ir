<?php

namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

defined('ABSPATH') or die('No script kiddies please!');

class information_box_5 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_information_box_5';
    }
    function get_title()
    {
        return esc_html__('Information box 5', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-information-box-5';
	}
    function get_categories()
    {
        return ['ahuraelements'];
    }
    function get_keywords()
    {
        return ['informationbox5', 'information_box_5', esc_html__('Information box 5', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $information_box_5_css = mw_assets::get_css('elementor.information_box_5');
        mw_assets::register_style('information_box_5', $information_box_5_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('information_box_5')];
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
            'background_image',
            [
                'label' => esc_html__('Image', 'ahura'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Title Here', 'ahura')
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura')
            ]
        );

        $this->add_control(
            'icon_vivibility',
            [
                'label' => __( 'Show Icon', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-quote-left',
                    'library' => 'solid',
                ]
            ]
        );

        $this->add_control('div1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'read_more_title',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Read more', 'ahura')
            ]
        );

        $this->add_control(
            'read_more_url',
            [
                'label' => esc_html__('Button Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#',
                ],
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
            'absolute_box_section',
            [
                'label' => esc_html__('Absolute box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'absolute_box_background',
				'label' => __( 'Background', 'ahura' ),
				'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .information-box-5-absolute',
            ]
		);
        $this->add_responsive_control(
            'absolute_box_left',
            [
                'label' => esc_html__('Left', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('For LTR Languages', 'ahura'),
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500
                    ],
				],
				'selectors' => [
					'{{WRAPPER}} .information-box-5-absolute' => 'left: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_responsive_control(
            'absolute_box_top',
            [
                'label' => esc_html__('Top', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500
                    ],
				],
				'selectors' => [
					'{{WRAPPER}} .information-box-5-absolute' => 'top: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_responsive_control(
            'absolute_box_right',
            [
                'label' => esc_html__('Right', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500
                    ],
				],'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .information-box-5-absolute' => 'right: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_responsive_control(
            'absolute_box_bottom',
            [
                'label' => esc_html__('Bottom', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500
                    ],
				],'default' => [
					'unit' => 'px',
					'size' => -30,
				],
				'selectors' => [
					'{{WRAPPER}} .information-box-5-absolute' => 'bottom: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_responsive_control(
            'absolute_box_radius',
            [
                'label' => __('Border radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ]
				],'default' => [
                    'unit' => '%',
                    'size' => 10,
                ],
				'selectors' => [
					'{{WRAPPER}} .information-box-5-absolute' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'title_section',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Title Typography', 'ahura'),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .information-box-5-absolute h4',
                'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						]
                    ],'font_weight' => [
                        'default' => '700'
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
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .information-box-5-absolute h4' => 'color: {{VALUE}}',
				],
            ]
        );
        $this->add_responsive_control(
			'title_alignment',
			[
				'label' => __( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .information-box-5-absolute h4' => 'text-align: {{VALUE}};',
				],
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

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Description Typography', 'ahura'),
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .information-box-5-absolute p',
                'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						]
                    ],'font_weight' => [
                        'default' => '300'
                    ]
				]
			]
		);
        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .information-box-5-absolute p' => 'color: {{VALUE}}',
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

        $this->add_control(
            'box_des_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => is_rtl() ? 'right' : 'left',
                'selectors' => [
                    '{{WRAPPER}} .information-box-5-absolute p' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'read_more_section',
            [
                'label' => esc_html__('Read more', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Read more typography', 'ahura'),
				'name' => 'read_more_typography',
				'selector' => '{{WRAPPER}} .information-box-5-read-more a',
                'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						]
                    ],'font_weight' => [
                        'default' => '400'
                    ]
				]
			]
		);
        $this->add_control(
            'read_more_color',
            [
                'label' => esc_html__('Read more color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .information-box-5-read-more a' => 'color: {{VALUE}}',
				],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .information-box-5-read-more a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 1,
                            'left' => 0,
                        ]   
                    ],
                    'color' => ['default' => '#ffffff']
                ]
            ]
        );

        $this->add_responsive_control(
			'read_more_alignment',
			[
				'label' => __( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .information-box-5-read-more' => 'text-align: {{VALUE}};',
				],
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

        $this->add_responsive_control(
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
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .information-box-5-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .information-box-5-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .information-box-5-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .information-box-5-icon svg' => 'fill: {{VALUE}}',
				],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if ( ! empty( $settings['read_more_url']['url'] ) ) {
            $this->add_link_attributes( 'read_more_url', $settings['read_more_url'] );
        }
    ?>
        <div class="information-box-5">
            <div class="information-box-5-background-image" style="background-image: url(<?php echo $settings['background_image']['url']; ?>)"></div>
            <div class="information-box-5-absolute">
                <div class="information-box-5-icon <?php if(!$settings['icon_vivibility']) echo 'information-box-5-icon-hidden'?>">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                </div>
                <h4 class="title"><?php echo $settings['title']; ?></h4>
                <p class="description">
                    <?php echo $settings['description']; ?>
                </p>
                <div class="information-box-5-read-more">
                    <a <?php echo $this->get_render_attribute_string( 'read_more_url' ); ?>>
                        <?php echo $settings['read_more_title'] ?>
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
}
