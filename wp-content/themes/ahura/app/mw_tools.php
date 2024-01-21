<?php
namespace ahura\app;
class mw_tools
{
    static function vd(...$data)
    {
        echo "<pre dir='ltr' style='font-weight: bold'>";
        foreach($data as $dataItem)
        {
            var_dump($dataItem);
        }
        echo "</pre>";
    }
    private static $_theme_data;
    static function get_theme_data()
    {
        if(!self::$_theme_data)
        {
            self::$_theme_data = wp_get_theme('ahura');
        }
        return self::$_theme_data;
    }
    static function get_theme_slug()
    {
        $data = self::get_theme_data();
        return $data->get_template();
    }
    public static function get_theme_version()
    {
        $data = self::get_theme_data();
        return $data->version;
    }
    static function getRemoteServerByLicenseKey($licenseKey)
    {
        return strpos($licenseKey, 'ertano_') === 0 ? 'https://ertano.com/' : 'https://mihanwp.com/';
    }
    static function getRemoteProductId($licenseKey)
    {
        return strpos($licenseKey, 'ertano_') === 0 ? '1029' : '946456';
    }
    static function is_woocommerce_active()
    {
        return class_exists('woocommerce');
    }
    static function is_active_elementor_pro()
    {
        return class_exists('\ElementorPro\Plugin');
    }
    public static function is_active_wpseo(){
        return class_exists('WPSEO_Options');
    }

    public static function is_active_rankmath(){
        return class_exists('RankMath');
    }

    static function admin_referer($action, $query_arg = '_wpnonce', $die_mode=false)
    {
        $admin_url = strtolower(admin_url());
        $refere = strtolower($_SERVER['HTTP_REFERER']);
        $result = isset($_REQUEST[$query_arg]) ? wp_verify_nonce($_REQUEST[$query_arg], $action) : false;
        
        do_action('check_admin_refere', $action, $result);
        if(strpos($refere, $admin_url) !== 0 || !$result)
        {
            if($die_mode)
            {
                wp_nonce_ays($action);
                die;
            }
            return false;
        }
        return $result;
    }
    static function get_header_middle_section_menu_class()
    {
        $logo_alignment = mw_options::get_mod_logo_alignment();
        $action_box_alignment = mw_options::get_mod_action_btn_alignment();
        $middle_menu_alignment = (is_rtl() && $logo_alignment == 'center' && $action_box_alignment == 'left')
                                    ||
                                 (!is_rtl() && $logo_alignment == 'center' && $action_box_alignment == 'right')
                                    ? ''
                                    : 'center';
        return $middle_menu_alignment;
    }
    static function render_woocommerce_price_position_class()
    {
        $position =  get_option('woocommerce_currency_pos');
        
        if($position === 'left_space' || $position === 'left'){
            return 'price-left-position';
        }
        return;
    }

    public static function get_executable_file_content($path = ''){
        if(!empty($path) && file_exists($path)){
            ob_start();
            include $path;
            $content = ob_get_clean();
            return $content;
        }

        return false;
    }

    static function maybe_serialize($data){
        if(is_serialized($data)){
            $data = @unserialize($data);
        }
        return $data;
    }

    static function array_hash_values($array){
        return (is_array($array) && count($array) > 0) ? array_map(function($v){ return md5($v); }, $array) : false;
    }

    public static function number_format($num, $decimals = 0, $decimal_separator = '.', $thousands_separator = ',')
    {
        return number_format((float) $num, $decimals, $decimal_separator, $thousands_separator);
    }

    public static function render_uploader_field($params)
    {
        $label = isset($params['label']) ? $params['label'] : null;
        $type = isset($params['type']) ? $params['type'] : null;
        $value = isset($params['value']) ? $params['value'] : null;
        $field_id = isset($params['id']) ? $params['id'] : null;
        $field_name = isset($params['name']) ? $params['name'] : $field_id;
        $attachment_url = !empty($value) ? wp_get_attachment_url($value) : null;
        ?>
        <div class="form-field form-field-<?php echo $field_name ?>">
            <?php if ($label): ?>
                <label><?php echo $label ?></label>
            <?php endif; ?>
            <div class="ah-uploader-box">
                <div class="ah-uploader-selected" style="display:<?php echo !empty($value) ? 'block' : 'none' ?>">
                    <?php if ($type == 'image'): ?>
                        <img src="<?php echo $attachment_url ?>" alt="selected" class="ah-attachment-source">
                    <?php elseif ($type == 'video'): ?>
                        <video src="<?php echo $attachment_url ?>" preload="none" class="ah-attachment-source"></video>
                    <?php else: ?>
                        <div class="ah-attachment-source"><i class="dashicons dashicons-media-default"></i></div>
                    <?php endif; ?>
                    <button type="button" class="button ah-delete-selected-file-btn"><?php _e('Delete', 'ahura') ?></button>
                </div>
                <div class="ah-select-file-btn" data-type="<?php echo $type ?>" style="display:<?php echo !empty($value) ? 'none' : 'block' ?>">
                    <i class="dashicons dashicons-media-default"></i>
                </div>
                <button type="button" class="button ah-select-file-btn" data-type="<?php echo $type ?>" style="display:<?php echo !empty($value) ? 'none' : 'block' ?>"><?php _e('Select file', 'ahura') ?></button>
                <input type="hidden" name="<?php echo $field_name ?>" id="<?php echo $field_id ?>" value="<?php echo $value ?>">
            </div>
        </div>
    <?php
    }
}