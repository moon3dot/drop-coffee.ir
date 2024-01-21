<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class notice extends \Elementor\Widget_Base {
	use \ahura\app\traits\mw_elementor;
	
	public function get_name() {
		return 'ahura_notice';
	}

	public function get_title() {
		return __( 'Notice', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-notice-1';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['notice', esc_html__( 'Notice' , 'ahura')];
	}
	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		$notice_css = mw_assets::get_css('elementor.notice');
		mw_assets::register_style('notice', $notice_css);
	}
	function get_style_depends()
	{
		return [mw_assets::get_handle_name('notice')];
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
			'notice_title',
			[
				'label' => __("Text", 'ahura'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __("Notice Title Here", 'ahura')
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => __("Button Text", 'ahura'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __("Button", 'ahura')
			]
		);

		$this->add_control(
			'bnt_link',
			[
				'label' => __("Url", 'ahura'),
				'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
				'default' => [
					'url' => '#'
				]
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
            'btn_styles',
            [
                'label' => __( 'Button', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => __("Button Text Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fd5e5e',
                'selectors' => [
                    '{{WRAPPER}} .notice_box a.btn' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Text Typography', 'ahura'),
                'name' => 'btn_text_typography',
                'selector' => '{{WRAPPER}} .notice_box a.btn',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'rem',
                                'size' => '1.3',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_bgc',
                'selector' => '{{WRAPPER}} .notice_box a.btn',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#fff'
                        ],
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
                    '{{WRAPPER}} .notice_box a.btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .notice_box a.btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .notice_box a.btn',
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

        $this->add_control(
            'notice_box_color',
            [
                'label' => __("Text Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'white',
                'selectors' => [
                    '{{WRAPPER}} .notice_box .text' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Text Typography', 'ahura'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .notice_box .text',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'rem',
                                'size' => '1.2',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'notice_box_background',
                'selector' => '{{WRAPPER}} .notice_box',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#fd5e5e'
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
                    '{{WRAPPER}} .notice_box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .notice_box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .notice_box',
            ]
        );

        $this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('notice_title', 'none');
		$this->add_inline_editing_attributes('btn_text', 'none');

        if ( ! empty( $settings['bnt_link']['url'] ) ) {
            $this->add_link_attributes( 'bnt_link', $settings['bnt_link'] );
        }
		?>
		<div class="notice_box">
			<div class="text"><?php $this->render_inline_edit_data($settings['notice_title'], 'notice_title');?></div>
            <?php if($settings['btn_text']): ?>
                <a <?php echo $this->get_render_attribute_string( 'bnt_link' ); ?> class="btn">
                    <?php $this->render_inline_edit_data($settings['btn_text'], 'btn_text'); ?>
                </a>
            <?php endif; ?>
		</div>
		<?php
	}

}
