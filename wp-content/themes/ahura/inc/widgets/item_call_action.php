<?php
namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class item_call_action extends \Elementor\Widget_Base {
	use \ahura\app\traits\mw_elementor;
	
	public function get_name() {
		return 'item_call_action';
	}

	public function get_title() {
		return __( 'Call to Action', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-item-call-action';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['item_call_action', 'itemcallaction', esc_html__( 'Call to Action' , 'ahura')];
	}
    
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
		$ctaStyle = mw_assets::get_css('elementor.call_to_action');
		mw_assets::register_style('cta_widget_style', $ctaStyle);
    }
 
    public function get_style_depends() {
		return [mw_assets::get_handle_name('cta_widget_style')];
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
            'cta_image',
            [
                'label' => esc_html__( 'Choose Image', 'ahura' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $this->add_control(
			'cta_title', [
				'label' => __( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'title' , 'ahura' ),
				'label_block' => true,
			]
		);
        
        $this->add_control(
			'cta_desc', [
				'label' => __( 'Description', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Description' , 'ahura' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'btn_section',
			[
				'label' => __( 'button', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'show_btn',
			[
				'label' => __('Show button', 'ahura'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'yes',
				'options' => [
					'yes' => [
						'title' => __('yes', 'ahura'),
						'icon' => 'eicon-check'
					],
					'no' => [
						'title' => __('no', 'ahura'),
						'icon' => 'eicon-close'
					],
				],
				'toggle' => true
			]
		);

        $this->add_control(
			'btn_text', [
				'label' => __( 'Button text', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Text' , 'ahura' ),
				'label_block' => true,
			]
		);

        $this->add_control(
			'btn_link',
			[
				'label' => __( 'Button link', 'ahura' ),
				'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
					'custom_attributes' => '',
				],
			]
		);
        
        $this->end_controls_section();
        /*
         *
         *
         * Styles
         *
         *
         */
        $this->start_controls_section(
            'content_styles',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Title color', 'ahura'),
                'default' => '#fff',
                'selectors' =>
                    [
                        '{{WRAPPER}} .call_to_action .cta_content .cta_title' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title typography', 'ahura'),
                'selector' => '{{WRAPPER}} .call_to_action .cta_content .cta_title',
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

        $this->add_control(
            'desc_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Description color', 'ahura'),
                'default' => '#fff',
                'selectors' =>
                    [
                        '{{WRAPPER}} .call_to_action .cta_content .cta_desc' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => __('Description typography', 'ahura'),
                'selector' => '{{WRAPPER}} .call_to_action .cta_content .cta_desc',
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

        $this->add_control(
            'text_direction',
            [
                'label' => __('Texts direction', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'right' => [
                        'title' => __('right', 'ahura'),
                        'icon' => 'eicon-h-align-right'
                    ],
                    'center' => [
                        'title' => __('center', 'ahura'),
                        'icon' => 'eicon-h-align-center'
                    ],
                    'left' => [
                        'title' => __('left', 'ahura'),
                        'icon' => 'eicon-h-align-left'
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                        '{{WRAPPER}} .call_to_action .cta_content' => 'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();

        // button style
        $this->start_controls_section(
            'btn_styles',
            [
                'label' => __( 'Button', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'btn_title_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Button title color', 'ahura'),
                'default' => '#444',
                'selectors' =>
                    [
                        '{{WRAPPER}} .call_to_action .cta_content .cta_btn a' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn_title_typography',
                'label' => __('Button title typography', 'ahura'),
                'selector' => '{{WRAPPER}} .call_to_action .cta_content .cta_btn a',
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

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_back_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .cta_btn a',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .cta_btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .cta_btn a',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'btn_hover_title_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Button title hover color', 'ahura'),
                'default' => '#000',
                'selectors' =>
                    [
                        '{{WRAPPER}} .call_to_action .cta_content .cta_btn a:hover' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_hover_back_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .cta_btn a:hover',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
            ]
        );

        $this->add_control(
            'btn_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .cta_btn a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .cta_btn a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        // image styles
        $this->start_controls_section(
            'img_styles',
            [
                'label' => __( 'Image', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'fit_image',
            [
                'label' => __('Fit image', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'cover',
                'options' => [
                    'cover' => [
                        'title' => __('yes', 'ahura'),
                        'icon' => 'eicon-check'
                    ],
                    'initial' => [
                        'title' => __('no', 'ahura'),
                        'icon' => 'eicon-close'
                    ],
                ],
                'toggle' => true
            ]
        );

        $this->add_control(
            'image_position',
            [
                'label' => __( 'Images Position', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'initial',
                'options' => [
                    'initial'  => __( 'initial', 'ahura' ),
                    'left' => __( 'left', 'ahura' ),
                    'right' => __( 'right', 'ahura' ),
                    'top' => __( 'top', 'ahura' ),
                    'bottom' => __( 'bottom', 'ahura' ),
                    'center' => __( 'center', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .cta_image' => 'background-position: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_effect',
            [
                'label' => esc_html__('Image effect', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 100,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => ['unit' => '%', 'size' => 100],
                'selectors' => [
                    '{{WRAPPER}} .cta_image' => 'filter: brightness({{SIZE}}%)',
                ]
            ]
        );
        $this->end_controls_section();

        // box styles
        $this->start_controls_section(
            'box_styles',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => ['unit' => 'px', 'size' => 400],
                'selectors' => [
                    '{{WRAPPER}} .cta_image' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .cta_image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .cta_image',
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

        if ( ! empty( $settings['btn_link']['url'] ) ) {
            $this->add_link_attributes( 'btn_link', $settings['btn_link'] );
        }
        ?>
        <div class="call_to_action">
            <div class="container-fluid">
                <div class="row">
                    <div class="cta_image" style="background-image: url(<?php echo $settings['cta_image']['url']; ?>);background-size:<?php echo $settings['fit_image']; ?>;"></div>
                    <div class="cta_content">
                        <div class="cta_title"><?php echo $settings['cta_title']; ?></div>
                        <div class="cta_desc"><?php echo $settings['cta_desc']; ?></div>
                        <?php if($settings['show_btn'] === 'yes'): ?>
                            <div class="cta_btn"><a <?php echo $this->get_render_attribute_string( 'btn_link' ); ?>><?php echo $settings['btn_text']; ?></a></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php
	}
}
