<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class icon_box_2 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'icon_box_2';
	}
  
	public function get_title() {
		return __( 'Icon Box 2', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-icon-box-2';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['iconbox', 'iconbox2', 'icon_box', 'icon_box_2', esc_html__('Icon Box 2', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $icon_box_2_css = mw_assets::get_css('elementor.icon_box_2');
        mw_assets::register_style('icon_box_2', $icon_box_2_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('icon_box_2')];
    }
	protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-shield-alt',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Security', 'ahura'),
            ]
        );

        $this->add_control(
            'show_des',
            [
                'label' => esc_html__('Show Description', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                'condition' => [
                        'show_des' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_link',
            [
                'label' => esc_html__( 'Box link', 'ahura' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://mihanwp.com/',
                'show_external' => true,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->end_controls_section();
		$this->start_controls_section(
			'icon_section',
			[
				'label' => __( 'Icon', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'icon_font_size',
            [
                'label' => esc_html__('Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => '35',
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_2 .icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ahura_element_icon_box_2 .icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
				]
            ]
        );
		// color
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_2 .icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ahura_element_icon_box_2 .icon svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .ahura_element_icon_box_2 .icon svg > *' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_2 .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Typography', 'ahura'),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ahura_element_icon_box_2 .title',
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
				]
			]
		);

        $this->add_control(
            'des_color',
            [
                'label' => esc_html__( 'Description Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_2 .el-des' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Description Typography', 'ahura'),
                'name' => 'des_typography',
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_2 .el-des',
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

		$this->end_controls_section();
		$this->start_controls_section(
			'box_styles',
			[
				'label' => __( 'Box', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
				'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
					'px' => [
						'min' => 0,
						'max' => 500
					]
				],
				'default' => [
					'unit' => '%',
					'size' => '100',
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_2' => 'width: {{SIZE}}{{UNIT}};'
				]
            ]
        );
        $this->add_control(
            'height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500
					]
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_2' => 'height: {{SIZE}}{{UNIT}};'
				]
            ]
        );
		$this->add_control(
            'box_border_radius',
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
					'size' => '10',
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_2' => 'border-radius: {{SIZE}}{{UNIT}};'
				]
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 1.5,
                    'right' => 1.5,
                    'bottom' => 1.5,
                    'left' => 1.5,
                    'unit' => 'em'
                ]
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box shadow', 'ahura' ),
				'selector' => '{{WRAPPER}} .ahura_element_icon_box_2',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 10,
                            'blur' => 10,
                            'spread' => 0,
                            'color' => 'rgba(158, 71, 198, 0.5)'
                        ]
                    ]
                ]
			]
		);
		$this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_2',
                'fields_options' =>
                [
                    'background' =>
                    [
                        'default' => 'classic'
                    ],
                    'color' => 
                    [
                        'default' => '#9037FF'
                    ],
                ]
            ]
        );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        if (!empty($settings['box_link']['url'])) {
            $this->add_link_attributes('link', $settings['box_link']);
        }
		?>
		<a <?php echo $this->get_render_attribute_string('link'); ?> class="ahura_element_icon_box_2">
			<div class="icon"><?php \Elementor\Icons_Manager::render_icon($settings['icon'])?></div>
			<span class="title"><?php echo $settings['title']?></span>
            <?php if ($settings['show_des'] === 'yes'): ?>
            <div class="el-des"><?php echo $settings['description'] ?></div>
            <?php endif; ?>
		</a>
		<?php
  }
}
