<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class simple_button extends \WP_Customize_Control{
        function enqueue(){
            $simple_checkbox_css = get_template_directory_uri() . '/css/customization/simple_button.css';
            wp_enqueue_style('ahura_customization_simple_button', $simple_checkbox_css);
        }

        function get_input_attrs(){
            $attrs = [];
            foreach($this->input_attrs as $key => $value) {
                $attrs[] = $key . '="' . esc_attr($value) . '"';
            }
            return implode(' ', $attrs);
        }

        function render_content(){
            ?>
            <div class="ahura_customize_simple_button_wrapper">
                <a <?php echo $this->get_input_attrs() ?> data-id="<?php echo esc_attr($this->id) ?>">
                    <?php echo $this->label ?>
                </a>
            </div>
            <?php if(!empty($this->description)):?>
                <span class="ahura_cusomize_controller_description margin_top"><?php echo $this->description; ?></span>
            <?php endif; ?>
            <?php
        }
    }
}