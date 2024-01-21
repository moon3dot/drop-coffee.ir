<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class notice_box_2 extends \Elementor\Widget_Base {
	use \ahura\app\traits\mw_elementor;
	use \ahura\app\traits\link_utilities;
	
	public function get_name() {
		return 'ahura_notice_box_2';
	}

	public function get_title() {
		return __( 'Notice Box 2', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-notice-box-2';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['notice_2', 'notice_box_2', esc_html__('Notice Box 2', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $notice_box_2_css = mw_assets::get_css('elementor.notice_box_2');
        mw_assets::register_style('notice_box_2_css', $notice_box_2_css);
    }
    
	function get_style_depends()
    {
        return [mw_assets::get_handle_name('notice_box_2_css'), mw_assets::get_handle_name('swipercss')];
    }
	
	protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon',
            [
                'type' => Controls_Manager::ICONS,
                'label' => esc_html__('Icon', 'ahura'),
                'default' => [
                    'library' => 'solid',
                    'value' => 'fas fa-tags',
                ]
            ]
        );

        $this->add_control(
            'title_text',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Title', 'ahura'),
                'default' => __('Title Here', 'ahura'),
            ]
        );

        $this->add_control(
            'subtitle_text',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Sub title', 'ahura'),
                'default' => esc_html__('Sub title here', 'ahura'),
            ]
        );

        $this->add_control(
            'show_btn',
            [
                'label' => esc_html__('Button', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'type' => Controls_Manager::TEXT,
                'default' => __('Link', 'ahura'),
                'label' => __('Button Text', 'ahura'),
                'condition' => ['show_btn' => 'yes']
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => esc_html__( 'Button link', 'ahura' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'condition' => ['show_btn' => 'yes']
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
			'icon_styles',
			[
				'label' => __( 'Icon', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Color', 'ahura'),
				'default' => '#0344b3',
				'selectors' => [
					'{{WRAPPER}} .notice_box_2 .icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .notice_box_2 .icon svg' => 'fill: {{VALUE}}'
				],
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
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .notice_box_2 .icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .notice_box_2 .icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg_color',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .notice_box_2 .icon',
				'fields_options' => 
				[
					'background' => [
						'default' => 'classic'
					],
					'color' => [
						'default' => '#ffffff'
					],
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'content_styles',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __('Title color', 'ahura'),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .notice_box_2 .content .title' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title Typography', 'ahura'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .notice_box_2 .content .title',
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
                        'default' => 'bold'
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
			'sub_title_text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __('Sub title color', 'ahura'),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .notice_box_2 .content .sub-title' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Subtitle Typography', 'ahura'),
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .notice_box_2 .content .sub-title',
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
                        ],
                        'font_weight' => [
                            'default' => '400'
                        ],
                    ]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'button_styles',
			[
				'label' => __( 'Button', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_btn' => 'yes']
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __('Color', 'ahura'),
				'default' => '#0344b3',
				'selectors' => [
					'{{WRAPPER}} .notice_box_2 .content .link' => 'color: {{VALUE}}'
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Text Typography', 'ahura'),
                'name' => 'btn_text_typography',
                'selector' => '{{WRAPPER}} .notice_box_2 .content .link',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '15',
                            ]
                        ],
                    ]
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_bg_color',
				'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .notice_box_2 .content .link',
				'fields_options' => 
				[
					'background' => [
						'default' => 'classic'
					],
					'color' => [
						'default' => '#ffffff'
					],
				]
			]
		);

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 50
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '30',
                ],
                'selectors' => [
                    '{{WRAPPER}} .notice_box_2 .content .link' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .notice_box_2 .content .link',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .notice_box_2 .content .link',
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
			'box_styles',
			[
				'label' => __( 'Box', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .notice_box_2 .content',
                'fields_options' =>
                    [
                        'background' => [
                            'default' => 'gradient'
                        ],
                        'color' => [
                            'default' => '#0344b3'
                        ],
                        'color_b' => [
                            'default' => '#5213d2'
                        ],
                        'gradient_angle' =>
                            [
                                'default' =>
                                    [
                                        'unit' => 'deg',
                                        'size' => 150
                                    ]
                            ]
                    ]
            ]
        );

        $this->add_control(
            'notice_box_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 100
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '50',
                ],
                'selectors' => [
                    '{{WRAPPER}} .notice_box_2' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .notice_box_2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'notice_box_shadow',
                'label' => __( 'Box Shadow', 'ahura' ),
                'selector' => '{{WRAPPER}} .notice_box_2',
                'fields_options' =>
                    [
                        'box_shadow_type' =>
                            [
                                'default' =>'yes'
                            ],
                        'box_shadow' => [
                            'default' =>
                                [
                                    'horizontal' => 0,
                                    'vertical' => 5,
                                    'blur' => 15,
                                    'spread' => 0,
                                    'color' => 'rgba(82, 19, 210, 0.5)'
                                ]
                        ]
                    ]
            ]
        );
		
		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();

        if ( ! empty( $settings['button_url']['url'] ) ) {
            $this->add_link_attributes( 'button_url', $settings['button_url'] );
        }
		?>
		<div class="notice_box_2">
			<div class="icon"><?php \Elementor\Icons_Manager::render_icon($settings['icon'])?></div>
			<div class="content">
				<div class="title-section">
					<div class="title"><?php echo $settings['title_text']?></div>
					<div class="sub-title"><?php echo $settings['subtitle_text']?></div>
				</div>
                <?php if ($settings['show_btn'] === 'yes'): ?>
				    <a <?php echo $this->get_render_attribute_string( 'button_url' ); ?> class="link"><?php echo $settings['button_text']?></a>
                <?php endif; ?>
			</div>
		</div>
		<?php
	}

}
