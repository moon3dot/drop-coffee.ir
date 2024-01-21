<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class sharing_buttons extends \Elementor\Widget_Base {

	use \ahura\app\traits\mw_elementor;

	public function get_name() {
		return 'ahura_sharing_buttons';
	}

	public function get_title() {
		return __( 'Sharing buttons', 'ahura' );
	}

	public function get_icon() {
		return 'eicon-social-icons';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}

	function get_keywords()
	{
		return ['sharing buttons', 'sharing', 'button', esc_html__( 'sharing buttons' , 'ahura')];
	}

	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		$services_box3_css = mw_assets::get_css('elementor.sharing_buttons');
		mw_assets::register_style('sharing_buttons', $services_box3_css);
	}

	function get_style_depends()
	{
		return [mw_assets::get_handle_name('sharing_buttons')];
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
			'share_link',
			[
				'label' => esc_html__( 'Link to share', 'ahura' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => false,
				'default' => [
					'url' => 'https://mihanwp.com/ahura',
				],
			]
		);

		$this->add_control(
			'share_message',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Ahura', 'ahura' ),
			]
		);

		$this->add_control(
			'is_blank',
			[
				'label' => esc_html__( 'Show link in new tab', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'btn_icon',
			[
				'label' => esc_html__( 'Icon', 'ahura' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-facebook-f',
					'library' => 'fa-brands',
				],
			]
		);

		$repeater->add_control(
			'social_share_url',
			[
				'label' => esc_html__( 'Share on', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'https://facebook.com/sharer/sharer.php?u=',
				'options' => [
					'https://telegram.me/share/url?url=' => esc_html__( 'Telegram', 'ahura' ),
					'https://api.whatsapp.com/send?'  => esc_html__( 'WhatApp', 'ahura' ),
					'https://linkedin.com/shareArticle?url=' => esc_html__( 'Linkedin', 'ahura' ),
					'https://twitter.com/intent/tweet?url=' => esc_html__( 'Twitter', 'ahura' ),
					'https://facebook.com/sharer/sharer.php?u=' => esc_html__( 'Facebook', 'ahura' ),
				],
			]
		);
		
        $repeater->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Button Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'color: {{VALUE}}',
				],
			]
		);

        $repeater->add_control(
			'btn_backcolor',
			[
				'label' => esc_html__( 'Button background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
            'buttons_list',
            [
                'label' => esc_html__( 'Buttons', 'ahura' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
					[
						'value' => 'fab fa-facebook-f',
						'library' => 'fa-brands',
					],
                ],
            ]
        );
		
		$this->end_controls_section();$this->start_controls_section(
            'general_style',
            [
                'label' => esc_html__('General', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'btns_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'justify-content-start' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify-content-center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'justify-content-end' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => 'justify-content-center',
				'toggle' => true,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'selector' => '{{WRAPPER}} .sharing-container .btn-holder',
			]
		);
		
		$this->add_responsive_control(
			'btn_width',
			[
				'label' => esc_html__( 'Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'  ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .sharing-container .btn-holder' => 'height: {{SIZE}}px; width: {{SIZE}}px;',
				],
			]
		);
        
        $this->add_responsive_control(
			'btn_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 8,
					'right' => 8,
					'bottom' => 8,
					'left' => 8,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .sharing-container .btn-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'btn_size',
			[
				'label' => esc_html__( 'Font size', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'  ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .sharing-container .btn-holder i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		

		$this->add_control(
			'show_box_shadow',
			[
				'label' => esc_html__( 'Use box shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'box_shadow',
			[
				'label' => esc_html__( 'Box Shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' => [
					'{{SELECTOR}} .sharing-container .btn-holder' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				],
				'condition' => ['show_box_shadow' => 'yes']
			]
		);

        $this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
        $wid      = $this->get_id();
		if ( ! empty( $settings['share_link']['url'] ) ) $this->add_link_attributes( 'share_link', $settings['share_link'] ); ?>
		<div class="sharing-buttons sharing-buttons-<?php echo $wid; ?>">
			<div class="sharing-container d-flex <?php echo $settings['btns_align']; ?>">
				<?php if ( $settings['buttons_list'] ): ?>
					<div class="button-container">
						<?php foreach (  $settings['buttons_list'] as $button ): ?>

							<?php if( str_contains( $button['social_share_url'], 'telegram' ) ): ?>
								<a href="<?php echo $button['social_share_url'] . $settings['share_link']['url'] . '&text=' . $settings['share_message']; ?>" <?php if($settings['is_blank'] == 'yes'): echo 'target="is_blank"'; endif; ?> class="<?php echo 'elementor-repeater-item-' . $button['_id']; ?> btn-holder">

							<?php elseif( str_contains( $button['social_share_url'], 'whatsapp' ) ): ?>
								<a href="<?php echo $button['social_share_url'] . 'text=' . $settings['share_message'] . '&url=' . $settings['share_link']['url']; ?>" <?php if($settings['is_blank'] == 'yes'): echo 'target="is_blank"'; endif; ?> class="<?php echo 'elementor-repeater-item-' . $button['_id']; ?> btn-holder">

							<?php elseif( str_contains( $button['social_share_url'], 'linkedin' ) ): ?>
								<a href="<?php echo $button['social_share_url'] . $settings['share_link']['url'] . '&title=' . $settings['share_message']; ?>" <?php if($settings['is_blank'] == 'yes'): echo 'target="is_blank"'; endif; ?> class="<?php echo 'elementor-repeater-item-' . $button['_id']; ?> btn-holder">

							<?php elseif( str_contains( $button['social_share_url'], 'twitter' ) ): ?>
								<a href="<?php echo $button['social_share_url'] . $settings['share_link']['url'] . '&text=' . $settings['share_message']; ?>" <?php if($settings['is_blank'] == 'yes'): echo 'target="is_blank"'; endif; ?> class="<?php echo 'elementor-repeater-item-' . $button['_id']; ?> btn-holder">

							<?php elseif( str_contains( $button['social_share_url'], 'facebook' ) ): ?>
								<a href="<?php echo $button['social_share_url'] . $settings['share_link']['url']; ?>" <?php if($settings['is_blank'] == 'yes'): echo 'target="is_blank"'; endif; ?> class="<?php echo 'elementor-repeater-item-' . $button['_id']; ?> btn-holder">
							<?php endif; ?>

								<?php \Elementor\Icons_Manager::render_icon( $button['btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

}
