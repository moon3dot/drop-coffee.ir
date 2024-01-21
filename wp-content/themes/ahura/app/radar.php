<?php
namespace ahura\app;
class radar
{
    private const BASE_SERVER_URL = 'https://mihanwp.com/';

    static function init()
    {
        add_action('switch_theme', [__CLASS__, 'afterDeactivateTheme']);
        add_action('after_switch_theme', [__CLASS__, 'sendBaseData']);

        add_action('after_setup_theme', [__CLASS__, 'afterSetupTheme']);
        add_action('ahura_start_check_license_status_schedule', [__CLASS__, 'sendBaseData']);
    }
    static function getActivePluginsList()
    {
        $activePlugins = get_option('active_plugins');
        foreach($activePlugins as $item)
        {
            $plugin_name = explode('/', $item);
            $pluginsList[] = reset($plugin_name);
        }
        return $pluginsList;
    }
    static function afterDeactivateTheme()
    {
        delete_option('ahura_theme_version');
        self::sendDeactivationRequest();
    }
    static function afterSetupTheme()
    {
        $currentVersion = \ahura\app\mw_tools::get_theme_version();
        $dbVersion = get_option('ahura_theme_version');
        if(!$dbVersion || version_compare($dbVersion, $currentVersion, '<'))
        {
            self::sendBaseData();
            update_option('ahura_theme_version', $currentVersion);
        }
    }
    static function sendDeactivationRequest()
    {
        $domain = get_home_url();
        if(self::isFromLocalhost($domain))
        {
            return false;
        }
        $wpVersion = get_bloginfo('version');
        $productID = MW_AHURA_UPDATER_ITEM_ID;
        $productVersion = mw_tools::get_theme_version();
        $pluginsList = self::getActivePluginsList();
        $licenseKey = license::get_license_key();
        if(!$licenseKey)
        {
            $licenseKey = 'license';
        }
        $url = self::BASE_SERVER_URL . 'api/v2/'.$licenseKey.'/radar/deactivate_product/';
        $args = [
            'timeout' => 1000,
            'method' => 'POST',
            'body' => [
                'wp_version' => $wpVersion,
                'product_id' => $productID,
                'product_version' => $productVersion,
                'active_plugins_list' => $pluginsList,
            ],
        ];
        wp_remote_post($url, $args);
    }
    static function sendBaseData()
    {
        // send domain, wp_version, product_id, product_version, plugins_list
        $domain = get_home_url();
        if(self::isFromLocalhost($domain))
        {
            return false;
        }
        $wpVersion = get_bloginfo('version');
        $productID = MW_AHURA_UPDATER_ITEM_ID;
        $productVersion = mw_tools::get_theme_version();
        $pluginsList = self::getActivePluginsList();
        $licenseKey = license::get_license_key();
        if(!$licenseKey)
        {
            $licenseKey = 'license';
        }
        $url = self::BASE_SERVER_URL . 'api/v2/'. $licenseKey .'/radar/base_data/';
        $args = [
            'timeout' => 1000,
            'method' => 'POST',
            'body' => [
                'wp_version' => $wpVersion,
                'product_id' => $productID,
                'product_version' => $productVersion,
                'active_plugins_list' => $pluginsList,
            ],
        ];
        wp_remote_post($url, $args);
    }
    private static function getDomainInstance($domain)
    {
        $domain = filter_var($domain, FILTER_VALIDATE_URL);
        if(!$domain)
        {
            return false;
        }
        $search = [
            'https://www.',
            'http://www.',
            'https://',
            'http://',
        ];
        $domain = str_replace($search, '', $domain);
        $domain = trim($domain);
        $domain = trailingslashit($domain);
        return $domain;
    }
    static function isFromLocalhost($domain)
    {
        $domain = self::getDomainInstance($domain);
        return strpos($domain, 'localhost') === 0;
    }
}