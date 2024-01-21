<?php
$current_filter = current_filter();
if (strpos($current_filter, 'edit_form_fields') !== false):
?>    
    <?php
    foreach($fields as $key => $value):
        $v = get_term_meta($term->term_id, $value['id'], true);
     ?>
    <tr class="form-field">
        <th valign="top" scope="row"><label for="<?php echo $value['id'] ?>"><?php echo esc_html__(($value['label'] ? $value['label'] : ''), 'ahura') ?></label></th>
        <td>

            <?php if($value['type'] == 'color'): ?>
            <input type="text" size="40" class="color-field" value="<?php echo esc_attr($v) ? esc_attr($v) : ''; ?>"  name="<?php echo $value['id'] ?>"><br/>
            <?php endif; ?>
            
        </td>
    </tr>  
    <?php endforeach; ?>

<?php elseif(strpos($current_filter, 'add_form_fields') !== false): ?>

    <?php foreach($fields as $key => $value): ?>
    <div class="form-field">
        <label for="<?php echo $value['id'] ?>"><?php echo esc_html__(($value['label'] ? $value['label'] : ''), 'ahura') ?></label>

        <?php if($value['type'] == 'color'): ?>
        <input type="text" size="40" class="color-field" name="<?php echo $value['id'] ?>">
        <?php endif; ?>

    </div>
    <?php endforeach; ?>

<?php
endif;
