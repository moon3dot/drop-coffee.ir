<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class information_box extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_information_box';
    }
    function get_title()
    {
        return esc_html__('Information Box', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-information-box-1';
	}
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['information_box', 'informationbox', esc_html__( 'Information Box' , 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $information_box_css = mw_assets::get_css('elementor.information_box');
        mw_assets::register_style('information_box', $information_box_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('information_box')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'box_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'library' => 'fa-solid',
                    'value' => 'fa fa-users',
                ]
            ]
        );
        $repeater->add_control(
            'box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Students Count', 'ahura')
            ]
        );
        $repeater->add_control(
            'box_value',
            [
                'label' => esc_html__('Value', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 1500
            ]
        );
        $repeater->add_control(
            'is_highlight',
            [
                'label' => esc_html__('Highlight', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 1
            ]
        );
        $repeater->add_control(
            'box_background_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.box-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
			'icon_color',
			[
				'label' => __('Icon Color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#339AD9',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .icon svg' => 'fill: {{VALUE}}'
				]
			]
		);
        $repeater->add_control(
			'title_color',
			[
				'label' => __('Title text color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#969696',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .content .description' => 'color: {{VALUE}}'
				]
			]
		);
        $repeater->add_control(
			'value_color',
			[
                'label' => esc_html__('Value text color', 'ahura'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#339AD9',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .content .value' => 'color: {{VALUE}}'
				]
			]
		);
        $this->add_control(
            'boxes',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'label' => esc_html__('Boxes', 'ahura'),
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{box_title}}}',
                'default' => [
                    [],
                    [
                        'is_highlight' => 1,
                        'box_background_color' => '#339AD9',
                        'icon_color' => '#ffffff',
                        'title_color' => '#ffffff',
                        'value_color' => '#ffffff',
                    ],
                    [],
                    [],
                ]
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__('Title typography', 'ahura'),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .content .description',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__('Value typography', 'ahura'),
				'name' => 'value_typography',
				'selector' => '{{WRAPPER}} .content .value',
			]
		);
        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="information_boxes">
            <?php foreach($settings['boxes'] as $box_id => $box):
                $repeater_title_key = $this->get_repeater_setting_key('box_title', 'boxes', $box_id);
                $repeater_description_key = $this->get_repeater_setting_key('box_value', 'boxes', $box_id);
                $this->add_inline_editing_attributes($repeater_title_key, 'none');
                $this->add_inline_editing_attributes($repeater_description_key, 'none');
                $is_highlight_class = $box['is_highlight'] ? 'active' : '';
                ?>
                <div class="box-item elementor-repeater-item-<?php echo $box['_id']; ?> <?php echo $is_highlight_class?>">
                    <div class="icon">
                        <?php \Elementor\Icons_Manager::render_icon($box['box_icon'])?>
                    </div>
                    <div class="content">
                        <div class="value"><?php $this->render_inline_edit_data($box['box_value'], $repeater_description_key) ?></div>
                        <div class="description"><?php $this->render_inline_edit_data($box['box_title'], $repeater_title_key); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}