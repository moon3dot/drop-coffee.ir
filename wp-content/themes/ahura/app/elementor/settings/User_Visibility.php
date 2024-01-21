<?php
namespace ahura\app\elementor\settings;

use Elementor\Controls_Manager;
use ahura\app\elementor\Ahura_Elements_Settings;

class User_Visibility extends Ahura_Elements_Settings
{
	/**
	 * User_Visibility constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->register_elementor_settings('user_conditions_section');

		add_filter('ahura/elementor/settings/visibility/apply_conditions', [$this, 'apply_conditions'], 10, 3);
	}

	/**
	 * Register section
	 *
	 * @param $element
	 *
	 * @return void
	 */
	public function register_section($element) {
		$element->start_controls_section(
			self::SECTION_PREFIX . 'user_conditions_section',
			[
				'tab'   => self::TAB_VISIBILITY,
				'label' => __('User Conditions', 'ahura'),
			]
		);

		$element->end_controls_section();
	}

	/**
	 * @param $element \Elementor\Widget_Base
	 * @param $section_id
	 * @param $args
	 */
	public function register_controls($element, $args) {
		if(!in_array($element->get_name(), ['section', 'container'])){
			$element->add_control(
				self::SECTION_PREFIX . 'enabled',
				[
					'label'          => __('Enable Visibility Logic', 'ahura'),
					'type'           => Controls_Manager::SWITCHER,
					'label_on'       => __( 'Yes', 'ahura' ),
					'label_off'      => __( 'No', 'ahura' ),
					'return_value'   => 'yes',
					'prefix_class'   => 'ahura-condition-',
					'style_transfer' => false,
				]
			);
	
			$element->add_control(
				self::SECTION_PREFIX . 'condition_type',
				[
					'label'          => __('Condition Type', 'ahura'),
					'type'           => Controls_Manager::SELECT2,
					'options'        => [
						'all' => __('All', 'ahura'), 
						'logged_in' => __('User is logged in', 'ahura'),
						'not_logged' => __('User not logged in', 'ahura'),
					],
					'default' => 'all',
					'condition' => [
						self::SECTION_PREFIX . 'enabled' => 'yes',
					],
					'style_transfer' => false,
				]
			);
		} else {
			$element->add_control(
				'only_for_widgets_important_note',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => esc_html__('Conditions is only for widgets.', 'ahura'),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}
	}

	/**
	 * Apply conditions
	 *
	 * @param array                   $options
	 * @param array                   $settings
	 * @param \Elementor\Element_Base $item
	 *
	 * @return array
	 */
	public function apply_conditions($options, $settings, $item) {
		$settings = $item->get_settings_for_display();
        $condition_enabled = $this->get_visibility_option('enabled', $settings) == 'yes';
        $condition_type = $this->get_visibility_option('condition_type', $settings);
		
        if(!$condition_enabled || !$condition_type || empty($condition_type) || $condition_type == 'all'){
            return $options;
        }

		$user = wp_get_current_user();
		$is_guest     = false;
		$is_logged_in = false;

		if($condition_type == 'logged_in' && is_user_logged_in()){
			$is_logged_in = $user->ID;
		} elseif($condition_type == 'not_logged' && !is_user_logged_in()) {
			$is_guest = !$user->ID;
		}

		$options['user_logged_in'] = $is_logged_in || $is_guest;

		return $options;
	}
}
