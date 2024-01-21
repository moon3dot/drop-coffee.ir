<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class circular_box extends \Elementor\Widget_Base {

	public function get_name() {
		return 'circular_box';
	}

	public function get_title() {
		return __( 'Circular Box', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-circular-box';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['circular_box', 'circularbox', esc_html__( 'Circular Box' , 'ahura')];
	}
	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		$circular_box_css = mw_assets::get_css('elementor.circular_box');
		mw_assets::register_style('circular_box', $circular_box_css);
	}
	function get_style_depends()
	{
		return [mw_assets::get_handle_name('circular_box')];
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
			'title',
			[
				'label'    => __( 'Title', 'ahura' ),
				'type'     => \Elementor\Controls_Manager::TEXT,
				'default' => __('Beauty', 'ahura'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'label' => __('Circle shadow', 'ahura'),
				'name' => 'circle_box_shadow',
				'selector' => "{{WRAPPER}} .circle_title"
			]
		);

		$this->add_control(
			'outside_circles_color',
			[
				'label' => __('Outside Circles Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#6EC1E4',
				'selectors' => 
				[
					'{{WRAPPER}} .circle_box_wrapper::before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .circle_box_wrapper::after' => 'background-color: {{VALUE}}',
				]
			]
		);
		$this->add_control(
			'circle_overlay',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => __('Overlay Color', 'ahura'),
				'name' => 'circle_overlay',
				'selectors' => [
					"{{WRAPPER}} .circle_title .overlay" => 'background-color: {{VALUE}}'
				]
			]
			);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'circle_background_mode',
				'selector' => '{{WRAPPER}} .circle_title',
				'fields_options' =>
				[
					'background' =>
					[
						'default' => 'classic'
					],
					'color' => [
						'default' => '#6EC1E4'
						]
				]
			]
		);
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('title', 'none');
		?>
		<div class="circle_box_wrapper">
			<div class="circle_title">
				<h3 <?php echo $this->get_render_attribute_string('title')?>><?php echo $settings['title']; ?></h3>
				<div class="overlay"></div>
			</div>
		</div>
		<?php
	}

}
