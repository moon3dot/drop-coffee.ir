<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class services_box3 extends \Elementor\Widget_Base {
	use \ahura\app\traits\mw_elementor;
	public function get_name() {
		return 'ahoora_services_box3';
	}

	public function get_title() {
		return __( 'Services Box 3', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-services-box-3';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['servicebox3', 'services_box_3', 'services_box3', 'servicesbox3', esc_html__( 'Services Box 3' , 'ahura')];
	}
	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		$services_box3_css = mw_assets::get_css('elementor.services_box3');
		mw_assets::register_style('services_box3', $services_box3_css);
	}
	function get_style_depends()
	{
		return [mw_assets::get_handle_name('services_box3')];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'service_icon',
			[
				'type' => \Elementor\Controls_Manager::ICONS,
				'label' => __('Service Icon', 'ahura'),
				'description' => __('Choose from font library', 'ahura'),
				'skin'	=>	'inline',
				'exclude_inline_options' => ['svg'],
				'default' => [
					'value' => 'fa fa-compass',
					'library' => 'fa-solid'
				]
			]
		);
		$repeater->add_control(
			'icon_color',
			[
				'label' => __('Icon Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .icon_wrapper i' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .icon_wrapper svg' => 'fill: {{VALUE}};'
				],
				'default' => '#35495C'
			]
		);
		$repeater->add_control(
			'background_color',
			[
				'label' => __('Background Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};'
				],
				'default' => '#fff'
			]
		);
		$repeater->add_control(
			'text_color',
			[
				'label' => __('Text Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .title,{{WRAPPER}} {{CURRENT_ITEM}} .description' => 'color: {{VALUE}};'
				],
				'default' => '#35495C'
			]
		);
		$repeater->add_control(
			'hover_background_color',
			[
				'label' => __('Hover Background Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}}; color: {{VALUE}}'
				],
				'default' => '#34aaf0'
			]
		);
		$repeater->add_control(
			'hover_text_color',
			[
				'label' => __('Hover Text Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover .title,{{WRAPPER}} {{CURRENT_ITEM}}:hover .description,{{WRAPPER}} {{CURRENT_ITEM}}:hover .icon_wrapper i' => 'color: {{VALUE}};'
				],
				'default' => '#fff'
			]
		);
		$repeater->add_control(
			'service_title',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __('Title', 'ahura'),
				'default' => __("Service Title", 'ahura'),
			]
		);
		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'service_title_typography',
				'label' => __('Title Typography','ahura'),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .title',
				'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '22'
						]
					]
				]
			]
		);
		$repeater->add_control(
			'service_short_description',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __('Excerpt', 'ahura'),
				'default' => __("Know More", 'ahura')
			]
		);
		$repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'service_desc_typography',
				'label' => __('Description Typography','ahura'),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .description',
				'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16'
						]
					]
				]
			]
		);
		$repeater->add_control(
			'service_url',
			[
				'type' => \Elementor\Controls_Manager::URL,
				'label' => __('Url', 'ahura'),
                'dynamic' => ['active' => true],
				'default' => [
					'url' => '#'
				]
			]
		);
		$box_default_data = [
			'service_title' => __("Service Title", 'ahura')
		];
		$this->add_control(
			'services',
			[
				'type' => \Elementor\Controls_Manager::REPEATER,
				'label' => __("Services Box", 'ahura'),
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{service_title}}}',
				'default' => [
					$box_default_data,
					$box_default_data,
					$box_default_data,
					$box_default_data,
					$box_default_data
				]
			]
		);
		$this->end_controls_section();
	}
	protected function render_link_attrs($url_data, $classes=false)
	{
		$class = $classes ? $classes : false;
		$target = $url_data['is_external'] ? 'target="_blank"' : '';
		$nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
		$cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
		$data = 'class="'.$class.'" href="'.$url_data['url'].'" '.$target.' '.$nofollow.' '.$cu_attr;
		echo $data;
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="services_elem_3">
			<?php foreach($settings['services'] as $service_id => $service):
				$class = 'service_item elementor-repeater-item-' . $service['_id'];
				$repeater_title_key = $this->get_repeater_setting_key('service_title', 'services', $service_id);
				$repeater_description_key = $this->get_repeater_setting_key('service_short_description', 'services', $service_id);
				$this->add_inline_editing_attributes($repeater_title_key, 'none');
				$this->add_inline_editing_attributes($repeater_description_key, 'none');
				?>
				<a <?php $this->render_link_attrs($service['service_url'], $class); ?>>
					<div class="icon_wrapper">
						<?php \Elementor\Icons_Manager::render_icon($service['service_icon']);?>
					</div>
					<h3 class="title"><?php $this->render_inline_edit_data($service['service_title'], $repeater_title_key);?></h3>
					<p class="description"><?php $this->render_inline_edit_data($service['service_short_description'], $repeater_description_key);?></p>
				</a>
			<?php endforeach; ?>
		</div>
		<?php
	}

}
