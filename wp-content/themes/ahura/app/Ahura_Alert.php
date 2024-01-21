<?php

namespace ahura\app;

class Ahura_Alert {
    const SUCCESS = 1;
    const WARNING = 2;
    const ERROR = 3;
    const INFO = 4;

    private static function getTypeClass($type)
    {
        if ($type === self::WARNING) {
            $class = 'warning mw_element_warning';
        } elseif ($type === self::ERROR) {
            $class = 'error mw_element_error';
        } elseif ($type === self::INFO) {
            $class = 'info mw_element_info';
        } else {
            $class = 'success mw_element_success';
        }
        return $class;
    }

    public static function frontNotice($msg, $type = self::SUCCESS)
    {
        $class = self::getTypeClass($type);
        echo "<div class='alert ahura-alert alert-{$class}'>{$msg}</div>";
    }

    public static function adminNotice($msg, $type = self::SUCCESS)
    {
        $class = self::getTypeClass($type);
        echo "<div class='notice ahura-notice notice-{$class} is-dismissible'><p>{$msg}</p></div>";
    }
}