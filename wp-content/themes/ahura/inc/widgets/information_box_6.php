<?php
namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class information_box_6 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_information_box_6';
    }
    public function get_icon() {
		return 'aicon-svg-information-box-6';
	}
    function get_title()
    {
        return esc_html__('Information Box 6', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['informationbox6', 'information_box_6', esc_html__('Information box 6', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $bannerBox5_css = mw_assets::get_css('elementor.information_box_6');
        mw_assets::register_style('information_box_6', $bannerBox5_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('information_box_6')];
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
                    'value' => 'fab fa-apple'
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'IOS Development', 'ahura' ),
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => __( 'Description', 'ahura' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Description Here', 'ahura' ),
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Content
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

        $this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_information_box_6 .icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ahura_element_information_box_6 .icon svg' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Icon Typography', 'ahura'),
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .icon',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '50',
						]
					]
				]
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

        $this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_information_box_6 .title' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Title Typography', 'ahura'),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .title',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '25',
						]
					],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
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
				'label' => __( 'Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ahura_element_information_box_6 .description p' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Description Typography', 'ahura'),
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .description p',
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
					]
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
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .ahura_element_information_box_6',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#E39D48'
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
            'box_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'right',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_information_box_6' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_information_box_6',
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
                        'max' => 80
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_information_box_6' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_information_box_6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' =>
                    [
                        'isLinked' => false,
                        'top' => '10',
                        'bottom' => '10',
                        'right' => '25',
                        'left' => '25',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_information_box_6',
            ]
        );

        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="ahura_element_information_box_6">
            <div class="icon"><?php \Elementor\Icons_Manager::render_icon($settings['icon'])?></div>
            <div class="title"><?php echo $settings['title']?></div>
            <div class="description"><p><?php echo $settings['description_text']?></p></div>
        </div>
        <?php
    }
}