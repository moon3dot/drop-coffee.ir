<?php
namespace ahura\app;
class mw_mega_menu
{
    static function get_fields()
    {
        return [
            'mega_menu_icon_type' => [
                'title' => __('Icon Type', 'ahura'),
                'type' => 'select',
                'data' => [
                    'image' => __('Image', 'ahura'),
                    'icon' => __('Font Icon', 'ahura'),
                ]
            ],
            'menu_font_icon' => [
                'title' => __('Font Icon', 'ahura'),
                'type' => 'icon',                
            ],
            'mega_menu_icon' => [
                'title' => __('Icon', 'ahura'),
                'type' => 'media'
            ],
            'mega_menu_state' => [
                'title' => __('Menu Mode', 'ahura'),
                'type' => 'select',
                'data' => [
                    'simple' => __('Simple', 'ahura'),
                    'mega_menu' => __('Mega Menu', 'ahura')
                ]
            ],
            'mega_menu_item_text_color' => [
                'title' => __('Text color', 'ahura'),
                'type' => 'color',
            ],
            'mega_menu_item_bg_color' => [
                'title' => __('Background color', 'ahura'),
                'type' => 'color',
            ],
            'mega_menu_bg' => [
                'title' => __('Mega Menu Background', 'ahura'),
                'type' => 'media',                
            ],
        ];
    }
    static function render_field($item_id, $field_key, $field_data)
    {
        $method = 'render_field_' . $field_data['type'];
        if(!method_exists(__CLASS__, $method)){
            return false;
        }
        self::{$method}($item_id, $field_key, $field_data);
    }
    static function render_field_color($item_id, $field_key, $field_data)
    {
        $value = get_post_meta($item_id, $field_key, true);
        if(!$value && isset($field_data['default']) && $field_data['default'])
        {
            $value = $field_data['default'];
        }
        ?>
            <input
                type="text"
                class="widefat menu-item-color-picker-input color-picker"
                id="<?php echo esc_attr(sprintf('%s-for-%s', $field_key, $item_id))?>"
                name="<?php echo esc_attr($field_key)?>[<?php echo esc_attr( $item_id ); ?>]"
                <?php echo isset($field_data['default']) && $field_data['default'] ? sprintf('data-default-color="%s"', $field_data['default']) : null?>
                value="<?php echo esc_attr( $value ); ?>" />
        <?php
    }
    static function render_field_select($item_id, $field_key, $field_data)
    {
        $value = get_post_meta($item_id, $field_key, true);
        ?>
        <select
            class="widefat mega-menu-select-field"
            name="<?php echo "{$field_key}[{$item_id}]" ?>"
            data-item-id="<?php echo $item_id; ?>"
            id="<?php echo "{$field_key}-for-{$item_id}"; ?>">
            <?php foreach($field_data['data'] as $data_key => $data_value): ?>
                <?php $select_state = $data_key == $value ? 'selected' : false;?>
                <option <?php echo $select_state?> value="<?php echo $data_key?>"><?php echo $data_value?></option>
            <?php endforeach; ?>
        </select>
        <?php
    }
    static function render_field_media($item_id, $field_key, $field_data)
    {
        $value = get_post_meta($item_id, $field_key, true);
        ?>
        <small><a class="mw_upload_media" href="#"><?php _e('Upload'); ?></a></small>
        <input
            class="widefat mw_media_url field-<?php echo esc_attr($field_key)?>"
            type="text"
            name="<?php echo "{$field_key}[$item_id]"; ?>"
            value="<?php echo $value?>">
        <?php
    }
    static function render_field_icon($item_id, $field_key, $field_data){
        $field_value = get_post_meta($item_id, $field_key, true);
        $fonticons = ahura_fonticons_array();
        ?>
     <div class="mw-fonticon-selector-wrap">
        <input
                class="widefat"
                type="text"
                name="<?php echo "{$field_key}[$item_id]"; ?>"
                value="<?php echo $field_value ?>" dir="ltr">
        <div class="font-icons-list-wrap">
            <span class="mw-fonticon-selector-btn">
                <i class="<?php echo (!empty($field_value) && in_array($field_value, array_keys($fonticons))) ? $field_value : 'dashicons dashicons-arrow-down-alt2' ?>"></i>
            </span>
            <?php if($fonticons): ?>
                <div class="font-icons-list-content" style="display:none">
                    <input type="text" class="fonticons-search-input" placeholder="<?php echo esc_attr__('Search', 'ahura') ?>">
                    <ul>
                        <?php foreach($fonticons as $key => $value): ?>
                            <li data-icon="<?php echo $key ?>" title="<?php echo $value ?>" class="<?php echo ($key == $field_value) ? 'selected' : '' ?>">
                                <i class="<?php echo $key ?>"></i>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
     </div>
    <?php
    }
    static function add_admin_fields($item_id, $item)
    {
        $fields = self::get_fields();
        foreach($fields as $field_key => $field_data):
        ?>
        <p class="description description-wide">
            <label for="<?php echo esc_attr($field_key); ?>"><?php echo $field_data['title']; ?></label>
            <?php self::render_field($item_id, $field_key, $field_data); ?>
        </p>
        <?php
        endforeach;
    }
    static function update_data($menu_id, $menu_item_db_id, $menu_item_args)
    {
        if(defined('DOING_AJAX') && DOING_AJAX)
        {
            return false;
        }
        if(!mw_tools::admin_referer('update-nav_menu', 'update-nav-menu-nonce') && !mw_tools::admin_referer('import-wordpress'))
        {
            wp_nonce_ays('mw_theme_menu_data');
            die;
        }
        $fields = self::get_fields();
        foreach($fields as $field_key => $field_data)
        {
            $field = isset($_POST[$field_key][$menu_item_db_id]) && $_POST[$field_key][$menu_item_db_id] ? sanitize_text_field($_POST[$field_key][$menu_item_db_id]) : false;
            if($field)
            {
                // update option
                update_post_meta($menu_item_db_id, $field_key, $field);
            }else{
                // remove option
                delete_post_meta($menu_item_db_id, $field_key);
            }
        }
    }
}