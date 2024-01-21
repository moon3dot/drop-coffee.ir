<?php
namespace ahura\app;
class files
{
    static function get_file($file_name, $extension='php')
    {
        $file_name = str_replace('.', DIRECTORY_SEPARATOR, $file_name);
        $file_name = get_template_directory() . DIRECTORY_SEPARATOR . $file_name . '.' . $extension;
        return file_exists($file_name) && is_readable($file_name) ? $file_name : false;
    }
    static function get_template($template_name, $extension='php')
    {
        $file_name = 'template-parts.' . $template_name;
        return self::get_file($file_name, $extension);
    }
}