<?php
namespace ahura\app;

class Number{
    private static $fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    private static $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /**
     *
     * Convert fa number to en
     *
     * @param $chr
     * @return array|string|string[]
     */
    public static function faToEN($chr){
        return str_replace(self::$fa, self::$en, $chr);
    }

    /**
     * Change fa number to en or reverse
     *
     * @param $chr
     * @return array|string|string[]
     */
    public static function numByLang($chr)
    {
        return is_rtl() ? str_replace(self::$en, self::$fa, $chr) : self::faToEN($chr);
    }
}