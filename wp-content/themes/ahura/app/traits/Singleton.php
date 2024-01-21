<?php
namespace ahura\app\traits;

trait Singleton {
    private static $instance = null;

    /**
     * @return null
     */
    public static function getInstance()
    {
        if(null === self::$instance){
            self::$instance  = new self();
        }

        return self::$instance;
    }
}