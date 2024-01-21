<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class modal_video extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_modal_video';
    }
    function get_title()
    {
        return esc_html__('Modal video', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['modalvideo', 'modal_video', esc_html__('Modal video', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $modalVideoCss = mw_assets::get_css('elementor.modal_video');
        mw_assets::register_style('elementor_modal_video', $modalVideoCss);
		mw_assets::register_script('elementor_modal_video', mw_assets::get_js('elementor.modal_video'));
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_modal_video')];
    }
	function get_script_depends()
	{
		return [mw_assets::get_handle_name('elementor_modal_video')];
	}
    protected function register_controls()
    {
        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );
		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Whatch the video now!', 'ahura' ),
				'placeholder' => esc_html__( 'Type your title here', 'ahura' ),
			]
		);
		$this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-play',
                    'library' => 'solid',
                ],
            ]
        );

		$this->add_control(
			'video',
			[
				'label' => esc_html__('Choose Video', 'ahura'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_type' => 'video',
				'default' => [
					'url' => 'https://file-examples.com/storage/fe59cbbb63645c19f9c3014/2017/04/file_example_MP4_1280_10MG.mp4',
				],
			]
		);

        $this->add_control(
            'video_cover',
            [
                'label' => esc_html__('Choose Cover', 'ahura'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'image',
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn' => 'background-color: {{VALUE}};'
                ],
                'default' => '#d1f9d1',
            ]
        );
		$this->add_control(
			'button_fit_content',
			[
				'label' => esc_html__( 'Fit content', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'button_items_gap',
			[
				'label' => esc_html__( 'Items gap', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'button_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
                    'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '10',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
		
        $this->end_controls_section();

		$this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon', 'ahura'),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-icon svg' => 'fill: {{VALUE}};'
				],
				'default' => '#ffffff',
            ]
        );
		$this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-icon::after' => 'background-color: {{VALUE}};'
                ],
                'default' => '#65ca6b',
            ]
        );

		$this->add_control(
			'icon_pulse_animation',
			[
				'label' => esc_html__( 'Pulse animation', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Active', 'ahura' ),
				'label_off' => esc_html__( 'Deactive', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
            'icon_pulse_bg_color',
            [
                'label' => esc_html__('Pulse background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-icon.ah-pulse::before' => 'background-color: {{VALUE}};'
                ],
                'default' => '#9aea9e',
				'condition' => [
					'icon_pulse_animation' => 'yes',
				]
            ]
        );

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon size', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-icon' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-icon svg' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_control(
			'icon_box_size',
			[
				'label' => esc_html__( 'Box size', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
            'text_style',
            [
                'label' => esc_html__('Text', 'ahura'),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-text' => 'color: {{VALUE}};'
				],
				'default' => 'black',
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-video-btn .ah-text',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
			]
		);
        $this->end_controls_section();

		$this->start_controls_section(
            'modal_style',
            [
                'label' => esc_html__('Modal', 'ahura'),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'modal_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_elementor_modal_video_wrapper .ah-modal-box' => 'background-color: {{VALUE}};'
                ],
                'default' => '#000000cc',
            ]
        );
        $this->end_controls_section();

    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $cover = $settings['video_cover'];
        $video = $settings['video'];
        ?>
        <div class="ahura_elementor_modal_video_wrapper">
			<a href="#" class="ah-modal-video-btn <?php echo isset($settings['button_fit_content']) && $settings['button_fit_content'] == 'yes' ? 'ah-fit-content' : '';?>">
				<div class="ah-icon <?php echo isset($settings['icon_pulse_animation']) && $settings['icon_pulse_animation'] == 'yes' ? 'ah-pulse' : ''; ?>">
					<?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
				</div>
				<div class="ah-text"><?php echo $settings['btn_text']; ?></div>
			</a>
			<div class="ah-modal-box"></div>
			<div class="ah-video">
				<video width="320" height="240" controls poster="<?php echo !empty($cover['url']) ? $cover['url'] : '' ?>">
					<source src="<?php echo !empty($video['url']) ? $video['url'] : ''; ?>">
					<?php esc_html_e('Your browser does not support the video tag.', 'ahura')?>
				</video>
			</div>
        </div>
        <?php
    }
}