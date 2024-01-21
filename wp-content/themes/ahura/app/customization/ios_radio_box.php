<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class ios_radio_box extends \WP_Customize_Control
    {
        function enqueue()
        {
            $ios_radio_box_css = get_template_directory_uri() . '/css/customization/ios_radio_box.css';
            wp_enqueue_style('ahura_customization_ios_radio_box', $ios_radio_box_css);
        }
        function render_content()
        {
            if(!$this->choices)
            {
                return false;
            }
            ?>
            <?php if(!empty($this->label)):?>
                <span class="ahura_ios_radio_box_title"><?php echo esc_html($this->label)?></span>
            <?php endif;?>
            <?php if(!empty($this->description)):?>
                <span class="ahura_cusomize_controller_description has_margin"><?php echo $this->description;?></span>
            <?php endif; ?>
            <div class="ahura_customize_ios_radio_box_wrapper">
                <?php foreach($this->choices as $key => $value):?>
                    <div class="ahura_customize_ios_radio_box_item">
                        <input value="<?php echo esc_attr($key)?>" <?php checked($this->value(), esc_attr($key))?> type="radio" name="_customize-radio-ios-<?php echo esc_attr($this->id)?>" <?php $this->link();?>>
                        <label><?php echo $value;?></label>
                    </div>
                <?php endforeach;?>
            </div>
            <?php
        }
    }
}