<?php
namespace ahura\app\elementor;

if(!class_exists('\ahura\app\elementor\Ahura_Elementor_Builder'))
{
    return false;
}

class Ahura_Elements_Settings
{
    public static $instances = [];
    
    public $elements = [
		[
			'name'       => 'common',
			'section_id' => '_section_style',
			'prefix'     => self::SECTION_PREFIX,
		],
		[
			'name'       => 'section',
			'section_id' => 'section_advanced',
			'prefix'     => self::SECTION_PREFIX,
		],
		[
			'name'       => 'container',
			'section_id' => 'section_layout',
			'prefix'     => self::SECTION_PREFIX,
		],
	];

	const TAB_VISIBILITY = 'ahura-element-visibility';
	const SECTION_PREFIX = 'ahura_element_visibility_';

	public function __construct() {
		add_filter('elementor/widget/render_content', [$this, 'element_content_change'], 999, 2);
		add_filter( 'elementor/frontend/section/before_render', [$this, 'section_content_change'], 999);
		add_filter( 'elementor/frontend/container/before_render', [$this, 'section_content_change'], 999);

		add_action(
			'elementor/element/print_template',
			function ($template, $widget) {
				return $template;
			},
			10,
			2
		);

		// add_filter('elementor/frontend/section/should_render', [ $this, 'item_should_render' ], 99999, 2);
		// add_filter('elementor/frontend/container/should_render', [ $this, 'item_should_render' ], 99999, 2);
		// add_filter('elementor/frontend/widget/should_render', [ $this, 'item_should_render' ], 99999, 2);
		// add_filter('elementor/frontend/repeater/should_render', [ $this, 'item_should_render' ], 99999, 2);

        \Elementor\Controls_Manager::add_tab(
			'ahura-element-visibility',
			esc_html__('Visibility', 'ahura')
		);
	}

    /**
	 * Get instance
	 *
	 * @return mixed
	 */
	public static function instance() {
		$class = static::class;

		if (!isset(self::$instances[$class])) {
			self::$instances[$class] = new $class();
		}

		return self::$instances[$class];
	}

    /**
	 * Register elementor settings
	 *
	 * @param $option_name
	 * @return void
	 */
	public function register_elementor_settings($option_name) {
		foreach($this->elements as $element) {
			if(method_exists($this, 'register_section') && method_exists($this, 'register_controls')){
				add_action("elementor/element/{$element['name']}/{$element['section_id']}/after_section_end", [$this, 'register_section']);
				add_action(
					"elementor/element/{$element['name']}/{$element['prefix']}{$option_name}/before_section_end",
					[$this,'register_controls'],
					10,
					2
				);
			}
		}
	}

	
    /**
     * 
     * Apply change elements content
     * 
     */
    public function element_content_change($content, $widget){
        $settings = $widget->get_settings();
        $options = apply_filters('ahura/elementor/settings/visibility/apply_conditions', [], $settings, $widget);

		if(empty($options) || is_admin() || \Elementor\Plugin::$instance->preview->is_preview_mode()){
			return $content;
		}

        if(isset($options['user_logged_in'])){
            if($options['user_logged_in'] == true){
                return $content;
            }
        } else {
            return $content;
        }
    }

	/**
	 * Render item or not based on conditions
	 *
	 * @param string                 $content
	 * @param \Elementor\Widget_Base $widget
	 *
	 * @return string
	 */
	public function section_content_change( $widget ) {
		$this->element_content_change('', $widget);
	}

	/**
	 * Check if item should render
	 *
	 * @param bool   $should_render
	 * @param object $widget
	 *
	 * @return boolean
	 */
	public function item_should_render($should_render, $widget) {
		$settings = $widget->get_settings();
		$options = apply_filters('ahura/elementor/settings/visibility/apply_conditions', [], $settings, $widget);

		if (in_array($widget->get_name(), ['section', 'container']) && isset($options['user_logged_in']) && $options['user_logged_in'] == true) {
			$should_render = false;
		}

		return $should_render;
	}

	public function get_visibility_option($option_name, $settings){
		$_prefix = 'ahura_element_visibility_';
		return isset($settings[$_prefix . $option_name]) ? $settings[$_prefix . $option_name] : false;
	}
}