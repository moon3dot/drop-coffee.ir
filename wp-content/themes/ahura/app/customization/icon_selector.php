<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class icon_selector extends ahura_customizer_controller
    {
        function enqueue()
        {
            $icons = get_template_directory_uri() . '/css/fontawesome.css';
            wp_enqueue_style('ahura_customization_icon_selector_icons', $icons);
            $css = get_template_directory_uri() . '/css/customization/icon_selector.css';
            wp_enqueue_style('ahura_customization_icon_selector', $css);
            $js = get_template_directory_uri() . '/js/admin/customization/icon_selector.js';
            wp_enqueue_script('ahura_customization_icon_selector', $js);
        }

        function render_content()
        {
            $font_icons = ahura_fonticons_array();
            ?>
            <label class="customize-control-title" for="_contmize-control-icon-selector_<?php echo esc_attr_e($this->id)?>"><?php echo $this->label;?></label>
            <div class="fonticon-selector-container">
                <div class="fonticon-selector-selected">
                    <?php if(!empty($this->value())): ?>
                        <i class="<?php echo $this->value() ?>"></i>
                    <?php endif; ?>
                    <span><?php echo $this->value() ?></span>
                    <em class="dashicons dashicons-arrow-down-alt2"></em>
                </div>
                <div class="fonticon-selector-items-wrap" style="display:none">
                    <div class="fonticon-selector-items-search">
                        <input type="text" class="font-icon-search" placeholder="<?php echo esc_html__('Search', 'ahura') ?>">
                    </div>
                    <div class="fonticon-selector-items">
                        <?php if($font_icons): ?>
                            <?php foreach($font_icons as $itemKey => $itemValue): ?>
                                <div <?php selected($this->value(), $itemKey) ?> data-icon="<?php echo $itemKey ?>">
                                    <i class="<?php echo $itemKey ?>"></i>
                                </div>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <select <?php $this->link(); $this->input_attrs();?>  name="_contmize-control-icon-selector_<?php esc_attr_e($this->id)?>" id="_contmize-control-icon-selector_<?php echo esc_attr_e($this->id)?>">
                <?php if($font_icons): ?>
                    <?php foreach($font_icons as $itemKey => $itemValue): ?>
                        <option <?php selected($this->value(), $itemKey)?> value="<?php echo $itemKey?>"><?php echo str_replace('-', '', $itemValue)?></option>
                    <?php endforeach;?>
                <?php else: ?>
                    <option value="0" selected disabled><?php esc_html_e('No any items found', 'ahura')?></option>
                <?php endif; ?>
            </select>
            <?php
        }
    }
}