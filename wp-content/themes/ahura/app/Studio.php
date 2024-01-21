<?php
namespace ahura\app;

class Studio {
    /**
     * Demo Studio page filter tabs
     *
     * @return array
     */
    public static function get_filter_tabs(){
        return Demo_Manager::getCategories(license::get_license_key());
    }

    /**
     * 
     * Get demo api base url
     * 
     * @return string|boolean
     */
    public static function get_base_url(){
        $license_key = license::get_license_key();
        return mw_tools::getRemoteServerByLicenseKey($license_key);
    }

    /**
     *
     * Check is studio page
     *
     * @return boolean
     */
    public static function is_studio(){
        return (isset($_GET['page']) && in_array($_GET['page'], ['studio', 'ahura_studio'])) || isset($_GET['step']) && $_GET['step'] === 'content';
    }
}