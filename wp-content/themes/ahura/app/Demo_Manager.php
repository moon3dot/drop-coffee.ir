<?php
namespace ahura\app;

use ahura\app\Logger;

class Demo_Manager {
    public static function getApiUrl($license){
        return strpos($license, 'ertano_') === 0 ? 'https://ertano.com/demo/ahura/wp-json/demo_manager/' : 'https://mihanwp.com/demo/ahura/wp-json/demo_manager/';
        //return 'http://localhost/multiwp/wp-json/demo_manager/';
    }

    public static function getList($license){
        $api_url = self::getApiUrl($license) . 'list';
        return self::client([
            'url' => $api_url,
            'license' => $license
        ]);
    }

    public static function getCategories($license){
        $api_url = self::getApiUrl($license) . 'categories';
        return self::client([
            'url' => $api_url,
            'license' => $license
        ]);
    }

    public static function client($params){
        $args = [
            'timeout' => 350,
            'sslverify' => true,
            'headers' => array(
                'API-KEY' => $params['license'],
            ),
        ];
        $remote = wp_remote_get($params['url'], $args);
        $response = wp_remote_retrieve_body($remote);
        return !is_wp_error($remote) && wp_remote_retrieve_response_code($remote) === 200 && ahura_is_json($response) ? json_decode($response, 1) : false;
    }
}