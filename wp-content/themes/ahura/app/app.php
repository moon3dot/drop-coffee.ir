<?php

use ahura\app\mw_hooks;
use ahura\app\radar;
use ahura\app\taxonomies;

class mw_ahura_theme
{
    private static $_instance;
    static function get_instance()
    {
        if(!self::$_instance)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    function __construct()
    {
        self::defines();
        spl_autoload_register([__CLASS__, 'autoload']);
        mw_hooks::init();
        taxonomies::init();
        radar::init();
        self::handleUpdater();
    }
    static function handleUpdater()
    {
        $licenseKey = \ahura\app\license::get_license_key();
        $remotePID = \ahura\app\mw_tools::getRemoteProductId($licenseKey);
        define('MW_AHURA_UPDATER_ITEM_ID', $remotePID);
        $updaterArgs = [
            // 'base_api_server' => 'https://mihanwp.com/',
            'base_api_server' => \ahura\app\mw_tools::getRemoteServerByLicenseKey($licenseKey),
            'license_key' => $licenseKey,
            'item_id' => MW_AHURA_UPDATER_ITEM_ID,
            'current_version' => \ahura\app\mw_tools::get_theme_version(),
            'theme_slug' => \ahura\app\mw_tools::get_theme_slug()
        ];
        \ahura\app\mihanwpUpdater::init($updaterArgs);
    }
    static function autoload($class_name)
    {
        if(strpos($class_name, 'ahura') !== false)
        {
            $class_name = str_replace('ahura\\', '', $class_name);
            // $class_name = strtolower($class_name);
            $class_name = str_replace('.', DIRECTORY_SEPARATOR, $class_name);
            $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
            $class_path = get_template_directory() . DIRECTORY_SEPARATOR . $class_name . '.php';
            if(file_exists($class_path) && is_readable($class_path))
            {
                include $class_path;
            }
        }
    }
    static function defines()
    {
        define('AHURA_DB_VERSION', 1);
    }
}
mw_ahura_theme::get_instance();
