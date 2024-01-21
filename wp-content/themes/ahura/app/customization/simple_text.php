<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class simple_text extends \WP_Customize_Control
    {
        function enqueue()
        {
            $simple_text_css = get_template_directory_uri() . '/css/customization/simple_text.css';
            wp_enqueue_style('ahura_customization_simple_text', $simple_text_css);
        }
        function get_input_attrs()
        {
            $attrs = [];
            foreach($this->input_attrs as $key => $value)
            {
                $attrs[] = $key . '="' . esc_attr($value) . '"';
            }
            return implode(' ', $attrs);
        }
        function render_field()
        {
            $type = $this->type;
            $type_white_list = ['text', 'email', 'number'];
            $open_tag = '';
            $close_tag = '';
            $field_id = 'ahura_customization_field_simple_text_' . $this->id;
            $value = $this->value();
            $data_attrs = [
                'id' => $field_id,
                'value' => $value,
                'oninput' => "this.setAttribute('value', this.value)",
            ];
            if($type == 'textarea')
            {
                $open_tag = '<textarea';
                $close_tag = esc_textarea($value) . '</textarea>';
            }else{
                $open_tag = '<input';
                $field_type = in_array($type, $type_white_list) ? $type : 'text';
                $data_attrs['type'] = $field_type;
            }
            $this->input_attrs = array_merge($this->input_attrs, $data_attrs);
            $open_tag .= ' ' . $this->get_input_attrs() . ' ' . $this->get_link() . '>';
            $label_el = '<label for="'.esc_attr($field_id).'">'.esc_html($this->label).'</label>';
            $input_el = $open_tag . $close_tag;
            $res = $label_el . $input_el;
            echo $res;
        }
        function render_content()
        {
            ?>
            <div class="ahura_customize_simple_text_wrapper <?php echo is_rtl() ? 'ahura_rtl_mode' : 'ahura_ltr_mode'; ?>">
            <?php $this->render_field();?>
            <?php if(!empty($this->description)):?>
                <span class="ahura_cusomize_controller_description margin_top"><?php echo $this->description;?></span>
            <?php endif; ?>
            </div>
            <?php
        }
    }
}