<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class simple_select_box extends ahura_customizer_controller
    {
        function render_content()
        {
            ?>
            <label class="customize-control-title" for="_contmize-control-simple-select-box_<?php echo esc_attr($this->id) ?>"><?php echo $this->label; ?></label>
            <select <?php $this->link(); $this->input_attrs();?>  name="_contmize-control-simple-select-box_<?php esc_attr_e($this->id) ?>" id="_contmize-control-simple-select-box_<?php echo esc_attr($this->id)?>">
                <?php if($this->choices):?>
                    <?php foreach($this->choices as $itemKey => $itemValue):
                        $selected = is_array($this->value()) ? (in_array($itemKey, $this->value()) ? 'selected' : '') : selected($this->value(), $itemKey, false);
                        ?>
                        <option <?php echo $selected ?> value="<?php echo $itemKey ?>"><?php echo $itemValue ?></option>
                    <?php endforeach;?>
                <?php else: ?>
                    <option value="0" selected disabled><?php esc_html_e('No any items found', 'ahura')?></option>
                <?php endif; ?>
            </select>
            <button type="button" class="ajax-load"><i class="dashicons dashicons-update-alt"></i></button>
            <?php
            $this->show_link();
        }
    }
}