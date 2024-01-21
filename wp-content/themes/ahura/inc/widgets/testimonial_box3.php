<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class testimonial_box3 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ahura_testimonial_box3';
	}

	public function get_title() {
		return __( 'Testimonial Box 3', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-testimonial-box-3';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['testimonial_box3', 'testimonialbox3', esc_html__( 'Testimonial Box 3' , 'ahura')];
	}
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $testimonial_box3_css = mw_assets::get_css('elementor.testimonial_box3');
        mw_assets::register_style('testimonial_box3_css', $testimonial_box3_css);
    }
    
	function get_style_depends()
    {
        return [mw_assets::get_handle_name('testimonial_box3_css'), mw_assets::get_handle_name('swipercss')];
    }

	protected function register_controls() {
		$right_alignment_option = [
			'title' => __('Right', 'ahura'),
			'icon' => 'eicon-text-align-right'
		];
		$left_alignment_option = [
			'title' => __('Left', 'ahura'),
			'icon' => 'eicon-text-align-left'
		];
		$center_alignment_option = [
			'title' => __('Center', 'ahura'),
			'icon' => 'eicon-text-align-center'
		];
		$flex_alignemnt_options = [
			'start' => $right_alignment_option,
			'center' => $center_alignment_option,
			'end' => $left_alignment_option,
		];
		$text_alignment = [
			'right' => $right_alignment_option,
			'center' => $center_alignment_option,
			'left' => $left_alignment_option,
		];
		if(!is_rtl())
		{
			$flex_alignemnt_options['start'] = $left_alignment_option;
			$flex_alignemnt_options['end'] = $right_alignment_option;
			$text_alignment = array_reverse($text_alignment);
		}

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $args = [
            'post_type' => 'testimonial',
            'number' => '-1'
        ];
        $data = new \WP_Query($args);
        $options = [];
        if($data->have_posts())
        {
            while($data->have_posts())
            {
                $data->the_post();
                $options[get_the_ID()] = get_the_title(get_the_ID());
            }
        }
        wp_reset_postdata();
        $default = $options && is_array($options) ? key($options) : false;
        $this->add_control(
            'tst_id',
            [
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label' => __("Testimonial", 'ahura'),
                'label_block' => true,
                'options' => $options,
                'default' => $default
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
			'avatar_section',
			[
				'label' => __( 'Avatar', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$avatar_alignment = $text_alignment;
		unset($avatar_alignment['center']);
        $this->add_responsive_control(
            'avatar_alignment',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => $avatar_alignment,
				'selectors' =>
				[
					'{{WRAPPER}} .avatar' => '{{VALUE}}: 0;',
				]
            ]
        );
        $this->add_control(
            'avatar_transform_y',
            [
                'label' => esc_html__('Margin from top', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
				'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100
                    ],
				],
				'default' => [
					'unit' => '%',
					'size' => '-30',
				],
            ]
        );
        $this->add_control(
            'avatar_transform_x',
            [
                'label' => esc_html__('Margin from side', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
				'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100
                    ],
				],
				'default' => [
					'unit' => '%',
					'size' => '-20',
				],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'avatar_box_shadow',
				'label' => __( 'Box Shadow', 'ahura' ),
				'selector' => '{{WRAPPER}} .testimonial-box3 .avatar',
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
                                    'blur' => 10,
                                    'spread' => 0,
                                    'color' => 'rgba(0,0,0,0.1)'
								]
						]
					]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'name_section',
			[
				'label' => __( 'Name', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'name_bg_color',
			[
				'label' => esc_html__( 'User Name Background Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#2a8ae9',
				'selectors' => [
					'{{WRAPPER}} .name' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'name_text_color',
			[
				'label' => esc_html__( 'User Name Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .name' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
            'name_flex_alignment',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'start',
                'options' => $flex_alignemnt_options,
				'selectors' =>
				[
					'{{WRAPPER}} .name' => 'align-self: {{VALUE}}',
				]
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Typography', 'ahura'),
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .name',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						]
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
        $this->add_responsive_control(
            'content_alignment',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'right',
                'options' => $text_alignment,
				'selectors' =>
				[
					'{{WRAPPER}} .content p' => 'text-align: {{VALUE}}',
				]
            ]
        );
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Text Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#35495C',
				'selectors' => [
					'{{WRAPPER}} .content p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'margin_top',
			[
				'label' => esc_html__( 'Margin Top', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top'],
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '15',
				],
				'selectors' => [
					'{{WRAPPER}} .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Typography', 'ahura'),
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .content p',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
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
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box3' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'box_padding',
            [
                'label' => esc_html__( 'Padding', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'isLinked' => true,
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20'
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '30',
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box3' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __( 'Box shadow', 'ahura' ),
                'selector' => '{{WRAPPER}} .testimonial-box3',
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
                                    'vertical' => 0,
                                    'blur' => 10,
                                    'spread' => 0,
                                    'color' => 'rgba(0,0,0,0.1)'
                                ]
                        ]
                    ]
            ]
        );
        $this->end_controls_section();
	}
	function avatar_additional_style($settings)
	{
		$avatar_transform_x = sprintf('%s%s', $settings['avatar_transform_x']['size'], $settings['avatar_transform_x']['unit']);
		$avatar_transform_y = sprintf('%s%s', $settings['avatar_transform_y']['size'], $settings['avatar_transform_y']['unit']);
		$transform = sprintf('translate(%s, %s)', $avatar_transform_x, $avatar_transform_y);
		$style = sprintf('style="transform: %s;"', $transform);
		return $style;
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$pid = $settings['tst_id'];
		if(!$pid)
		{
			return false;
		}
		$content = get_post_field('post_content', $pid);
		$user_display_name = \ahura\app\mw_options::get_testimonial_username($pid);
		$thumbnail_url = get_the_post_thumbnail_url($pid, 'thumbnail');
		?>
		<div class="testimonial-box3">
			<div <?php echo $this->avatar_additional_style($settings);?> class="avatar"><img src="<?php echo $thumbnail_url?>" alt="<?php printf('%s_testimonial_avatar', $user_display_name);?>"></div>
			<div class="name"><?php echo $user_display_name?></div>
			<div class="content"><p><?php echo $content?></p></div>
		</div>
		<?php
	}

}
