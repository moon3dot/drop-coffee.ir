<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');


class special_title extends \Elementor\Widget_Base {

    public function get_name() {
        return 'specialtitle';
    }

    public function get_title() {
        return __('Special title', 'ahura');
    }

    public function get_icon() {
        return 'aicon-svg-special-title';
    }

    function get_keywords() {
        return [ 'title', 'special', 'special title', __( 'title', 'ahura' ), __( 'special', 'ahura' ), __( 'Special title', 'ahura' ) ];
    }

    public function get_categories() {
        return ['ahuraelements'];
    }

    public function __construct( $data=[], $args=null ){
		parent::__construct( $data, $args );
		wp_register_style( 'specialtitle_widget', get_template_directory_uri() .'/css/elementor/specialtitle_widget.css' );		
	}

	public function get_style_depends(){ 
		return [ 'specialtitle_widget' ];
	}

    protected function register_controls() {
        $this->start_controls_section(
			'content_section', [
				'label' => esc_html__('Content', 'ahura'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'special_part', [
				'label' => esc_html__( 'Special text', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Special text', 'ahura' ),
			]
		);

        $this->add_control(
			'regular_part', [
				'label' => esc_html__( 'Regular text', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Regular text', 'ahura' ),
			]
		);

		$this->add_control('divider1', ['type' => \Elementor\Controls_Manager::DIVIDER]);

		$this->add_control(
            'title_html_tag',
            [
                'label' => esc_html__('Title Html Tag', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'span',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                    'P' => 'P',
                ],
            ]
        );

		$this->add_control(
            'text_html_tag',
            [
                'label' => esc_html__('Text Html Tag', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'span',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                    'P' => 'P',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'general_style_section', [
				'label' => esc_html__( 'General style', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'SVG_style', [
				'label' => esc_html__( 'SVG Style', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'M8.1,146.2c0,0,240.6-55.6,479-13.8',
				'options' => [
					'M8.1,146.2c0,0,240.6-55.6,479-13.8'  => esc_html__( 'Style 1', 'ahura' ),
					'M45,160 C214,39 337,236 475,118' => esc_html__( 'Style 2', 'ahura' ),
					'M45,160 C233,130 333,135 466,146' => esc_html__( 'Style 3', 'ahura' ),
					'M50,125 C144,157 357,110 466,146' => esc_html__( 'Style 4', 'ahura' ),
					'M50,125 C138,100 376,111 466,146' => esc_html__( 'Style 5', 'ahura' ),
					'custom_path' => esc_html__( 'Custom Path', 'ahura' ),
				],
			]
		);

        $this->add_control(
			'svg_custom_path', [
				'label' => esc_html__( 'SVG custom path', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'description' => 'M8.1,146.2c0,0,240.6-55.6,479-13.8',
                'condition' => [
                    'SVG_style' => 'custom_path',
                ],
			]
		);
        
        $this->add_control(
			'svg_color', [
				'label' => esc_html__( 'SVG Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffc23a',
				'selectors' => [
					'{{WRAPPER}} .special_text_widget .special_text_area svg path' => 'stroke: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'svg_width', [
				'label' => esc_html__( 'SVG Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 7,
				],
				'selectors' => [
					'{{WRAPPER}} .special_text_widget .special_text_area svg path' => 'stroke-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $alignment = [
            'right' => [
                'title' => __('right', 'ahura'),
                'icon' => 'eicon-text-align-right'
            ],
            'center' => [
                'title' => __('Center', 'ahura'),
                'icon' => 'eicon-text-align-center'
            ],
            'left' => [
                'title' => __('left', 'ahura'),
                'icon' => 'eicon-text-align-left'
            ],
        ];

        $this->add_control(
            'el_alignment', [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .special_text_widget div' => 'text-align: {{VALUE}};'
                ]
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
			'special_style_section', [
				'label' => esc_html__( 'Special text style', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(), [
				'name' => 'special_text_typography',
				'selector' => '{{WRAPPER}} .special_text_widget .special_text',
			]
		);

        $this->add_control(
			'special_text_color', [
				'label' => esc_html__( 'Special text color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#181522',
				'selectors' => [
					'{{WRAPPER}} .special_text_widget .special_text' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'special_text_shadow', [
				'label' => esc_html__( 'Special text shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT_SHADOW,
				'selectors' => [
					'{{WRAPPER}} .special_text_widget .special_text' => 'text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'regular_style_section', [
				'label' => esc_html__( 'Regular text style', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(), [
				'name' => 'regular_text_typography',
				'selector' => '{{WRAPPER}} .special_text_widget .regular_text_area',
			]
		);

        $this->add_control(
			'regular_text_color', [
				'label' => esc_html__( 'Regular text color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#181522',
				'selectors' => [
					'{{WRAPPER}} .special_text_widget .regular_text_area' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'regular_text_shadow', [
				'label' => esc_html__( 'Special text shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT_SHADOW,
				'selectors' => [
					'{{WRAPPER}} .special_text_widget .regular_text_area' => 'text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};',
				],
			]
		);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

		$title_tag = $settings['title_html_tag'] ? $settings['title_html_tag'] : 'span';
		$text_tag = $settings['text_html_tag'] ? $settings['text_html_tag'] : 'span';
    ?>
        <div class="special_text_widget">
            <div>
                <span class="special_text_area">
                    <<?php echo $title_tag ?> class="special_text d-inline-block">
                        <?php echo $settings['special_part']; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
                            <path d="<?php echo $settings['SVG_style'] != 'custom_path' ? $settings['SVG_style'] : $settings['svg_custom_path']; ?>" />
                        </svg>
                    </<?php echo $title_tag ?>>
                </span>
                <<?php echo $text_tag ?> class="regular_text_area d-inline-block"><?php echo $settings['regular_part']; ?></<?php echo $text_tag ?>>
            </div>
        </div>
    <?php
    }
}
