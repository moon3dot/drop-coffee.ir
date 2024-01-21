<?php
namespace ahura\app;
class license
{
    private static $_license_status_option_name = 'ahura_license_key_status';
    private static $_license_key_option_name = 'ahura_license_key';
    // private static $_base_api_server = 'https://mihanwp.com/api/v2/';

    private static function getBaseApiServer($license_key)
    {
        $server = mw_tools::getRemoteServerByLicenseKey($license_key);
        return $server . 'api/v2/';
    }
    static function init()
    {
        if(!self::is_active())
        {
            self::show_license_messages();
        }
        if(defined('AHURA_LICENSE_KEY'))
        {
            add_action('admin_init', [__CLASS__, 'handle_once_check_license']);
            add_action('switch_theme', [__CLASS__, 'afterDeactivateTheme']);
            add_action('after_switch_theme', [__CLASS__, 'afterActivateTheme']);
            return;
        }
        add_filter('merlin_ajax_activate_license', [__CLASS__, 'handle_license_in_merlin']);
    }

    public static function handle_once_check_license(){
        if (!self::is_active()){
            self::afterActivateTheme();
        }
    }

    /**
     * Used in another methods
     *
     * @return void
     */
    static function afterActivateTheme()
    {
        $result = self::activate_license_on_server();
        if($result)
        {
            self::activate_license_in_local();
        }
    }

    static function afterDeactivateTheme()
    {
        $result = self::deactivate_license_on_server();
        if($result)
        {
            self::deactivate_license_in_local();
        }
    }
    static function handle_license_in_merlin($license_key)
    {
        $result['success'] = self::activate_license_on_server($license_key);
        if($result['success'])
        {
            self::activate_license_in_local();
            $result['message'] = esc_html__('Successfully activated.', 'ahura');
        }else{
            $result['message'] = esc_html__('Has error in license activation', 'ahura');
        }
        return $result;
    }

    static function license_submit_action()
    {
        $res = [];
        if(isset($_POST['ahura_license_activate'])){
            check_admin_referer('ahura_nonce', 'ahura_nonce');
            self::deactivate_license_in_local();
            $license_key = isset($_POST['ahura_license_key']) ? sanitize_text_field($_POST['ahura_license_key']) : false;
            self::update_license_key($license_key);
            $server_res = self::activate_license_on_server();
            if($server_res)
            {
                self::activate_license_in_local();
            }else{
                $res['status'] = false;
                $res['msg'] = esc_html__('License key is invalid or the number of activation has exceeded the allowed limit.', 'ahura');
            }
        } elseif(isset($_POST['ahura_license_deactivate'])) {
            check_admin_referer('ahura_nonce', 'ahura_nonce');
            $server_res = self::deactivate_license_on_server();
            if($server_res)
            {
                self::deactivate_license_in_local();
            }
        }
        return $res;
    }
    static function license_menu_c()
    {
        //self::check_license();
        //$res = self::license_submit_action();
        $license_key = self::get_license_key();
        $is_license_active = self::is_active();
        $submit_btn_args = [];
        $license_status_args = [];
        if($is_license_active)
        {
            $submit_btn_args = [
                'name' => 'ahura_license_deactivate',
                'title' => esc_html__('Deactivate License','ahura'),
            ];
            $license_status_args = [
                'text' => esc_html__('License is active.', 'ahura'),
                'bg_color' => '#2aba5f35',
                'color' => '#2aba5f'
            ];
        }else{
            $submit_btn_args = [
                'name' => 'ahura_license_activate',
                'title' => esc_html__('Activate License','ahura')
            ];
            $license_status_args = [
                'text' => esc_html__('License is not active.', 'ahura'),
                'bg_color' => '#ba2a2a35',
                'color' => '#ba2a3e'
            ];
        }
        ?>
        <div class="wrap ahura-license-page">
            <h1 class="screen-hidden hidden"></h1>
            <hr class="wp-header-end">
            <div style="width:50%;box-shadow:0 0 40px rgba(0,0,0,0.1);border-radius:20px;margin:30px auto;background:#fff;padding:40px">
                <h2 class="title" style="font-size:30px"><i class="dashicons dashicons-privacy"></i><?php echo esc_html__('Theme License', 'ahura') ?></h2>
                <form method="post" id="ahura-change-license-status-form">
                    <input style="background:#fff;border:1px solid #ddd;box-shadow:0 0 20px rgba(0,0,0,0.05);border-radius:4px;height:50px;line-height:50px;width:70%;" id="ahura_license_key" name="ahura_license_key" type="text" placeholder="<?php _e('Enter License Code Here...','ahura'); ?>" class="regular-text" value="<?php echo esc_attr( $license_key ); ?>" <?php echo $is_license_active ? ' readonly' : '' ?>/>
                    <?php wp_nonce_field( 'ahura_nonce', 'ahura_nonce' );?>
                    <input style="width:29%;text-decoration: none; line-height: 45px; background: #00C178; background-image: linear-gradient(135deg,#01e08c,#00C178); color: #fff; border:none; display: inline-block; border-radius:4px; box-shadow: 0 5px 15px #00C17890; transition-duration: 0.2s;cursor:pointer;" type="submit" name="<?php echo $submit_btn_args['name']; ?>" value="<?php echo esc_attr($submit_btn_args['title']) ?>"/>
                    <p><a style="margin-bottom:20px" target="blank" href="https://mihanwp.com/mwpanel/?tab=3"><?php _e('Dont have your License Key?','ahura');?></a></p>
                    <p style="margin-top:20px;background-color: <?php echo $license_status_args['bg_color']; ?>;color: <?php echo $license_status_args['color']; ?>;padding:6px 10px;border-radius: 4px">
                        <?php echo $license_status_args['text']; ?>
                    </p>
                </form>
            </div>
        </div>
        <?php
    }
    static function check_license_status(){
        do_action('ahura_start_check_license_status_schedule');
        $license_key = self::get_license_key();
        if(!$license_key)
        {
            self::deactivate_license_in_local();
            return false;
        }
        $api_url = self::getBaseApiServer($license_key);
        $api_url .= $license_key . '/license/status';
        $args = [
            'timeout' => 1000,
            'sslverify' => true,
            'body' => [
                'product_id' => MW_AHURA_UPDATER_ITEM_ID
            ]
        ];
        $remote = wp_remote_get($api_url, $args);
        if(is_wp_error($remote) || wp_remote_retrieve_response_code($remote) != 200)
        {
            self::deactivate_license_in_local();
            return false;
        }
        $response = json_decode(wp_remote_retrieve_body($remote));
        if(!$response)
        {
            self::deactivate_license_in_local();
            return false;
        }
        if(!isset($response->result) || !$response->result)
        {
            self::deactivate_license_in_local();
            return false;
        }
        return self::activate_license_in_local();
    }
    static function check_license()
    {
        if(!self::is_active()){
            return self::check_license_status();
        }
        self::activate_license_in_local();
        return true;
    }
    static function check_license_cron_job(){
        return self::check_license_status();
    }
    static function activate_license_in_local()
    {
        return update_option(self::$_license_status_option_name, 'valid');
    }
    static function deactivate_license_in_local()
    {
        return delete_option(self::$_license_status_option_name);
    }
    static function activate_license_on_server($license_key=null)
    {
        if(!$license_key)
        {
            $license_key = self::get_license_key();
        }else{
            self::update_license_key($license_key);
        }
        if(!$license_key)
        {
            return false;
        }
        $api = self::getBaseApiServer($license_key);
        $api .= $license_key . '/license/activate';
        $args = [
            'timeout' => 1000,
            'sslverify' => true,
            'body' => [
                'product_id' => MW_AHURA_UPDATER_ITEM_ID,
            ]
        ];
        $remote = wp_remote_get($api, $args);
        if(is_wp_error($remote) || wp_remote_retrieve_response_code($remote) != 200)
        {
            return false;
        }
        $response = json_decode(wp_remote_retrieve_body($remote));
        if(!$response)
        {
            return false;
        }
        return isset($response->message->success) && $response->message->success && isset($response->message->activated);
    }
    static function deactivate_license_on_server()
    {
        $license_key = self::get_license_key();
        if(!$license_key)
        {
            return false;
        }
        $api = self::getBaseApiServer($license_key);
        $api .= $license_key . '/license/deactivate';
        $args = [
            'timeout' => 1000,
            'sslverify' => true,
            'body' => [
                'product_id' => MW_AHURA_UPDATER_ITEM_ID,
            ]
        ];
        $remote = wp_remote_get($api, $args);
        if(is_wp_error($remote) || wp_remote_retrieve_response_code($remote) != 200)
        {
            return false;
        }
        $response = json_decode(wp_remote_retrieve_body($remote));
        if(!$response)
        {
            return false;
        }
        return isset($response->message->success) && $response->message->success && isset($response->message->deactivated);
    }
    static function update_license_key($license_key)
    {
        return update_option(self::$_license_key_option_name, sanitize_key($license_key));
    }
    static function is_active()
    {
        return get_option(self::$_license_status_option_name) == 'valid';
    }
    static function get_license_key()
    {
        return defined('AHURA_LICENSE_KEY') ? AHURA_LICENSE_KEY : get_option(self::$_license_key_option_name);
    }
    static function show_license_messages()
    {
        add_action('admin_notices', [__CLASS__, 'inactive_license_message_box']);
        add_action('customize_controls_enqueue_scripts', [__CLASS__, 'enqueue_customizer_notification']);
    }
    static function inactive_license_message_box()
    {
        if(isset($_GET['page']) && $_GET['page'] == 'ahura-license')
        {
            return false;
        }
        ?>
        <div class="wrap">
            <div style="margin: 50px 0;width: 98%;max-width:100%;font-family:IRANSans;background: #6e54ff;color: white;font-size: 18px !important;padding: 50px;box-sizing: border-box;border-radius: 10px;box-shadow: 0 0 30px #6e54ff90;font-weight: 100;">
                <?php echo __('Welcome to ahura! Please activate your license.','ahura');?> <a style="margin-right:30px;color:white;color:#6e54ff;background:#fff;border-radius:10px;text-decoration:none;border-radius:5px;padding:10px 20px;" href="admin.php?page=ahura-wizard"><?php echo __('Get Started','ahura');?></a>
            </div>
        </div>
        <?php
    }
    static function enqueue_customizer_notification()
    {
        $customizer_notification = get_template_directory_uri() . '/js/customizer_notification.js';
        wp_enqueue_script('ahura_customizer_notification', $customizer_notification, ['customize-controls'], 'version', true);
        wp_localize_script('ahura_customizer_notification', 'mw_license_data', ['msg' => __("Settings will appear after activate theme.", 'ahura')]);
    }
}
