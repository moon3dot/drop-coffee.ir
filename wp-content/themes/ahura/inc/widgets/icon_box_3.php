<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class icon_box_3 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'icon_box_3';
	}
  
	public function get_title() {
		return __( 'Icon Box 3', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-icon-box-3';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['iconbox', 'iconbox3', 'icon_box', 'icon_box_3', esc_html__('Icon Box 3', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $icon_box_3_css = mw_assets::get_css('elementor.icon_box_3');
        mw_assets::register_style('icon_box_3', $icon_box_3_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('icon_box_3')];
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
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_3 .icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ahura_element_icon_box_3 .icon svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .ahura_element_icon_box_3 .icon svg > *' => 'fill: {{VALUE}}',
				],
			]
		);

		$alignment_option = [
			'right' => [
				'title' => __("Right", 'ahura'),
				'icon' => 'fa fa-align-right'
			],
			'left'	=>	[
				'title' => __('Left', 'ahura'),
				'icon'	=>	'fa fa-align-left'
			]
		];

		$this->add_control(
			'icon_alignment',
			[
				'label' => esc_html__('Alignment', 'ahura'),
				'type' => Controls_Manager::CHOOSE,
				'default' => is_rtl() ? 'right' : 'left',
				'options' => is_rtl() ? $alignment_option : array_reverse($alignment_option)
			]
		);

		$this->add_control(
            'icon_margin',
            [
                'label' => esc_html__('Position', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100
					],
					'%' => [
						'min' => 1,
						'max' => 100
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => '30',
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_3 .icon' => '{{icon_alignment.VALUE}}: {{SIZE}}{{UNIT}};'
				]
            ]
        );

		$this->add_responsive_control(
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
					'{{WRAPPER}} .ahura_element_icon_box_3 .icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ahura_element_icon_box_3 .icon svg' => 'width: {{SIZE}}{{UNIT}};'
				]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'title_section',
			[
				'label' => __( 'Title', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $alignment = array(
            'start' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'end' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ]
        );

        $this->add_responsive_control(
            'title_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_3' => 'justify-content: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_icon_box_3 .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Typography', 'ahura'),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ahura_element_icon_box_3 .title',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'box_section',
			[
				'label' => __( 'Box', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
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
					'{{WRAPPER}} .ahura_element_icon_box_3' => 'width: {{SIZE}}{{UNIT}};'
				]
            ]
        );
        $this->add_responsive_control(
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
				'default' => [
					'unit' => 'px',
					'size' => '80',
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_3' => 'height: {{SIZE}}{{UNIT}};'
				]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .ahura_element_icon_box_3',
                'fields_options' =>
                    [
                        'background' => ['default' => 'gradient'],
                        'color' => ['default' => '#7a95f1'],
                        'color_b' => ['default' => '#1A24A2'],
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
					'size' => '7',
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_icon_box_3' => 'border-radius: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .ahura_element_icon_box_3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box shadow', 'ahura' ),
				'selector' => '{{WRAPPER}} .ahura_element_icon_box_3',
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
		<a <?php echo $this->get_render_attribute_string('link');?> class="ahura_element_icon_box_3">
			<div class="icon"><?php \Elementor\Icons_Manager::render_icon($settings['icon'])?></div>
			<span class="title"><?php echo $settings['title']?></span>
		</a>
		<?php
  }
}
