<?php
namespace ahura\app\elementor;

use Elementor\Plugin;
use Elementor\Widget_Base;

class Elementor_Frontend extends \Elementor\Core\Files\CSS\Post {
    public function __construct($post_id = 0)
    {
        $this->post_id = empty($post_id) ? get_the_ID() : $post_id;

        parent::__construct( static::FILE_PREFIX . $post_id . '.css' );
    }

    public function convert_copy_data($data){
        if(!$data) return false;

        $data['isInner'] = false;
        $obj = ['type' => 'elementor', 'siteurl' => get_rest_url(), 'elements' => [$data]];
        return json_encode($obj);
    }

    private function replace_repeater_ids(&$item, $key) {
        if ($key === '_id') {
            $item = uniqid();
        }
    }

    private function fixed_element_repeater_items_id($settings){
        array_walk_recursive($settings, [$this, 'replace_repeater_ids']);
        return $settings;
    }

    private function render_element_content($element_data, $return_raw = false) {
        if ('widget' === $element_data['elType']) {
            $widget = Plugin::$instance->elements_manager->create_element_instance($element_data);

            if ($widget) {
                $raw = $widget->get_raw_data();

                $raw['settings'] = $this->fixed_element_repeater_items_id($widget->get_settings()); // if has a warning: change value to $widget->get_settings_for_display()
                $widget->set_settings($raw['settings']);
                $widget->parse_dynamic_settings($widget->get_settings()); // get values: $widget->get_parsed_dynamic_settings()

                $this->render_styles($widget);

                if($return_raw){
                    return $raw;
                } else {
                    $widget->print_element();
                }
            }
        }

        if ( ! empty( $element_data['elements'] ) ) {
            foreach ( $element_data['elements'] as $element ) {
                $this->render_element_content($element);
            }
        }
    }

    public function render_widgets($params){
        $category = isset($params['category']) ? $params['category'] : null;
        $element = isset($params['element']) ? $params['element'] : null;
        $count = isset($params['count']) ? $params['count'] : 20;
        $return = isset($params['return']) ? $params['return'] : false;

        $elementor_instance = Plugin::instance();
        $documents = $elementor_instance->documents;
        $widgets = $elementor_instance->widgets_manager->get_widget_types();
        $loaded_elements = isset($GLOBALS['ahura_render_elements']) && !empty($GLOBALS['ahura_render_elements']) ? $GLOBALS['ahura_render_elements'] : false;

        if(!$widgets || empty($category)){
            return false;
        }

        if($return){
            ob_start();
        }

        echo "<div class='custom-render-widgets-container'>";
        $i = 0;
        foreach ($widgets as $widget) {
            if(in_array($category, $widget->get_categories())){
                if (empty($element)){
                    if($loaded_elements && in_array($widget->get_name(), $loaded_elements)){
                        continue;
                    }
                } else {
                    if ($widget->get_name() != $element){
                        continue;
                    }
                }
                $GLOBALS['ahura_render_elements'][] = $widget->get_name();

                $is_builder_section = $category == 'ahurabuilder';

                $element_params = [
                    'elType' => 'widget',
                    'widgetType' => $widget->get_name(),
                    'id' => rand(100, 1000000),
                ];

                $element_raw_data = $this->render_element_content($element_params, true);
                ?>

                <?php if($is_builder_section): ?>
                    <div id="topbar" class="header-mode-1 header-mode-2 header-mode-3 clearfix">
                <?php endif; ?>

                <div class="ahura-element-render-head">
                    <div class="ah-right">
                        <h3 class='render-elementor-widget-title'><?php echo $widget->get_title() ?></h3>
                    </div>
                    <div class="ah-left">
                        <a href="#" class="ahura-copy-element" data-values='<?php echo $this->convert_copy_data($element_raw_data) ?>' data-nocopy-text="<?php echo __('Could not copy.', 'ahura') ?>" data-copy-text="<?php echo __('Copy Element', 'ahura') ?>" data-copied-text="<?php echo __('Copied.', 'ahura') ?>">
                            <?php echo __('Copy Element', 'ahura') ?>
                        </a>
                    </div>
                </div>

                <div class="elementor-post-0 <?php echo !empty($this->post_id) ? 'elementor-post-' . $this->post_id : '' ?> css">
                    <?php $this->render_element_content($element_params); ?>
                </div>

                <?php if($is_builder_section): ?>
                    </div>
                <?php endif; ?>

                <?php
                if($i == $count){
                    break;
                }
                $i++;
            }
        }
        echo '</div>';

        $styles = $this->get_stylesheet()->__toString();
        $styles_str = !empty($styles) ? "<style id='custom-render-elements-style'>{$styles}</style>" : '';
        echo $styles_str;

        if($return){
            return ob_get_clean();
        }
    }
}