<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class ios_checkbox extends \WP_Customize_Control
    {
        function enqueue()
        {
            $ios_checkbox_css = get_template_directory_uri() . '/css/customization/ios_checkbox.css';
            wp_enqueue_style('ahura_customization_ios_checkbox', $ios_checkbox_css);
        }
        function render_content()
        {
            ?>
            <div class="ahura_customize_ios_checkbox_wrapper">
                <input <?php $this->input_attrs();?> value="1" <?php checked($this->value(), true)?> type="checkbox" name="<?php echo esc_attr($this->id)?>" <?php $this->link();?>>
                <label><?php echo $this->label;?></label>
            </div>
            <?php if(!empty($this->description)):?>
                <span class="ahura_cusomize_controller_description margin_top"><?php echo $this->description;?></span>
            <?php endif; ?>
            <?php
        }
    }
}