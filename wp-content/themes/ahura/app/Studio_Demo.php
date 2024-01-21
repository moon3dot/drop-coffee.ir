<?php
namespace ahura\app;

use ahura\app\Logger;

class Studio_Demo extends Studio {
    protected $demo_name = 'demo';
    private $demo_id = 0;

    /**
     * 
     * Generate demo screenshot url
     * 
     * @param string $path
     * @return string
     * 
     */
    public static function generate_screenshot_url($path){
        $base_url = self::get_base_url();
        $demo_base_url = $base_url . 'demo/ahura/wp-content/uploads/';
        return $demo_base_url . $path;
    }

    /**
     * 
     * 
     * Get demo list
     *
     * @return array
     * 
     */
    public static function get_demo_list(){
        $license_key = \ahura\app\license::get_license_key();

        $demos = Demo_Manager::getList($license_key);

        $demos = apply_filters('ahura_studio_get_demo_list', $demos);

        return $demos;
    }

    public static function get_demo_options(){
        $options = array(
            'options' => __('Options', 'ahura'),
            'widgets' => __('Widgets', 'ahura'),
			'media' => __('Media', 'ahura'),
            'content' => __('Content', 'ahura'),
            'after_import' => __('After Import', 'ahura'),
        );
        $options = apply_filters('ahura_studio_get_demo_options', $options);
        return $options;
    }

    public function set_demo_id($demo_id = 0){
        $this->demo_id = $demo_id;
        return $this;
    }

    public function get_demo_id(){
        return $this->demo_id;
    }

    /**
     *
     * Get demo content from api
     *
     * @return boolean|array|object
     */
    public function get_demo_from_api(){
        $demos = self::get_demo_list();

        $demo_id = $this->get_demo_id();

        $demo_name = isset($demos[$demo_id]) ? $demos[$demo_id]['slug'] : false;

        if (!$demo_name)
            return false;

        $base_url = self::get_base_url();
        $license_key = license::get_license_key();

        if (empty($demo_name) || empty($license_key))
            return false;

        $base_url = $base_url . 'api/v2/' . $license_key . '/demo/get/?product_id=' . MW_AHURA_UPDATER_ITEM_ID;
        $demo_url = $base_url . "&demo={$demo_name}";
        $args = ['timeout' => 60, 'sslverify' => true];
        $remote = wp_remote_get($demo_url, $args);
        $json = !is_wp_error($remote) && wp_remote_retrieve_response_code($remote) === 200 ? wp_remote_retrieve_body($remote) : false;
        return !is_wp_error($json) && ahura_is_json($json) ? $json : false;
    }

    /**
     *
     * Get demo content path
     *
     * @return string
     */
    public function get_demo_path(){
        $path = wp_upload_dir();
        $dir = $path['basedir'] . '/ahura-import-demo/';
        if(!is_dir($dir)){
            mkdir($dir, 0755, true);
        }
        return $dir;
    }

    /**
     *
     * Get demo file path
     *
     * @return string
     */
    public function get_demo_file_path($ext = 'json'){
        return $this->get_demo_path() . $this->demo_name . '.' . $ext;
    }

    /**
     *
     * Get demo content
     *
     * @return false|mixed
     */
    public function get_demo_content(){
        $file = $this->get_demo_file_path();
        $content = file_exists($file) && is_readable($file) ? file_get_contents($file) : false;
        return $content && ahura_is_json($content) ? json_decode($content, true) : false;
    }

    /**
     *
     * Get demo content from api and save to server
     *
     * @return void
     */
    public function generate_demo_file(){
        $this->remove_demo_file();
        $json = $this->get_demo_from_api();
        if($json){
            $data = json_decode($json, true);

            $network_url = $data['extra']['network_url'];
            $home_url = $data['extra']['home_url'];
            $site_upload_url = isset($data['extra']['site_upload_url']) ? $data['extra']['site_upload_url'] : '';
            $upload_url = $data['extra']['upload_url'];

            $data = $this->replace_urls_recursive($data, [
                'site_upload_url' => $site_upload_url,
                'upload_url' => $upload_url,
                'home_url' => $home_url,
                'network_url' => $network_url,
            ]);

            $json = json_encode($data);

            do_action('ahura_before_generate_demo_import_file', $json);
            file_put_contents($this->get_demo_file_path(), $json);
        }
    }

    /**
     * @param $data
     * @param $urls
     * @return mixed
     */
    function replace_urls_recursive($data, $urls) {
        foreach ($data as $key => $value) {
            if ($key === 'guid')
                continue;

            $json = is_string($value) ? json_decode($value, true, 512, JSON_BIGINT_AS_STRING) : false;
            $value = $json !== null && $json != false ? $json : $value;
            if (is_array($value)) {
                $data[$key] = $this->replace_urls_recursive($value, $urls);
            } elseif (is_string($value)) {
                $upload = wp_upload_dir();
                if (isset($urls['site_upload_url']) && !empty($urls['site_upload_url'])){
                    $value = str_replace($urls['site_upload_url'], $upload['baseurl'], $value);
                }
                $value = str_replace($urls['upload_url'], $upload['baseurl'], $value);
                $value = str_replace($urls['home_url'], get_home_url(), $value);
                $value = str_replace($urls['network_url'], site_url('/'), $value);
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     *
     * Remove demo content file
     *
     * @return void
     */
    public function remove_demo_file(){
        $path = $this->get_demo_file_path();
        if(file_exists($path)){
            unlink($path);
        }
    }
}
