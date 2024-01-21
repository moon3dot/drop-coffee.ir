<?php

namespace ahura\app\customization;

class customizer_save
{
    public static function get_css()
    {
        ob_start();
        include get_template_directory().'/inc/css.php';
        $css = ob_get_clean();
        return $css;
    }

    public static function generate()
    {
        $uploads_dir = wp_get_upload_dir()['basedir'];

        if(!file_exists($uploads_dir . '/ahura')){
            mkdir($uploads_dir . '/ahura');
        }

        if(class_exists('\ahura\app\Fonts')){
            \ahura\app\Fonts::generate_fonts_style_file();
        }

        self::updateVersion();

        return file_put_contents($uploads_dir . '/ahura/customizer.css', self::get_css());
    }

    public static function after_customizer_save()
    {
        return self::generate();
    }

    public static function get_customizer_css_file()
    {
        $upload_directory = wp_get_upload_dir();
        if(!file_exists($upload_directory['basedir'].'/ahura/customizer.css')){
            if(!\ahura\app\customization\customizer_save::generate()){
                return false;
            }
        }
        $base_url = $upload_directory['baseurl'];
        $base_url = is_ssl() ? str_replace('http://', 'https://', $base_url) : $base_url;
        return $base_url . '/ahura/customizer.css';
    }

    public static function updateVersion()
    {
        return update_option('ahura_customizer_file_version',time());
    }

    public static function getVersion()
    {
        return get_option('ahura_customizer_file_version');
    }
}
