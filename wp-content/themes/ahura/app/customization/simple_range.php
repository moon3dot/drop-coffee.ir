<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class simple_range extends \WP_Customize_Control
    {
        function enqueue()
        {
            $simple_range_css = get_template_directory_uri() . '/css/customization/simple_range.css';
            wp_enqueue_style('ahura_customization_simple_range', $simple_range_css);
        }
        function render_content()
        {
            ?>
            <?php if(!empty($this->label)):?>
                <span class="ahura_customize_simple_range_title"><?php echo esc_html($this->label)?></span>
            <?php endif;?>
            <div class="ahura_customize_simple_range_wrapper">
                <input oninput="this.setAttribute('value', this.value)" value="<?php echo $this->value();?>" type="range" <?php $this->link(); $this->input_attrs();?> name="<?php echo esc_attr($this->id);?>">
            </div>
            <?php if(!empty($this->description)):?>
                <span class="ahura_cusomize_controller_description margin_top"><?php echo $this->description;?></span>
            <?php endif; ?>
            <?php
        }
    }
}