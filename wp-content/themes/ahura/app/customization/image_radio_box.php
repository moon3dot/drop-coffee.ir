<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class image_radio_box extends \WP_Customize_Control
    {
        function enqueue()
        {
            $image_radio_css = get_template_directory_uri() . '/css/customization/image_radio_box.css';
            wp_enqueue_style('ahura_customization_image_check_box', $image_radio_css);
        }
        function render_content()
        {
            if(!$this->choices)
            {
                return false;
            }
            ?>
            <?php if(!empty($this->label)):?>
                <span class="ahura_customize_image_radio_box_title"><?php echo esc_html($this->label)?></span>
            <?php endif;?>
            <?php if(!empty($this->description)):?>
                <span class="ahura_cusomize_controller_description margin_bottom"><?php echo $this->description;?></span>
            <?php endif; ?>
            <div class="ahura_customize_image_radio_box_wrapper">
                <?php foreach($this->choices as $key => $value):?>            
                <span class="ahura_customize_image_radio_box">
                    <label>
                        <input value="<?php echo esc_attr($key)?>" <?php checked($this->value(), esc_attr($key))?> name="_customize-radio-<?php echo esc_attr($this->id);?>" <?php echo $this->link()?> type="radio">
                        <span class="content">
                            <span class="preview">
                                <img src="<?php echo esc_attr($value['image_url']);?>" alt="<?php echo esc_attr($key)?>">
                            </span>
                            <?php if (isset($value['label'])): ?>
                                <span class="title"><?php echo esc_html($value['label']);?></span>
                            <?php endif; ?>
                        </span>
                    </label>
                </span>
                <?php endforeach;?>
            </div>
            <?php
        }
    }
}