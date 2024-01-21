<?php
namespace ahura\app;

class Ahura_Sidebar_Controller {
    private static $params = [];
    private static $col;

    private static $instance = null;

    public static function getInstance(){
        if(static::$instance == null){
            static::$instance = clone new self();
        }

        return static::$instance;
    }

    /**
     * Get sidebar without printing
     *
     * @param string $sidebar_id
     * @return string
     */
    public static function getSidebarContent($sidebar_id = ''){
        if (is_active_sidebar($sidebar_id)){
            ob_start();
            dynamic_sidebar($sidebar_id);
            $the_sidebar = ob_get_contents();
            ob_end_clean();
            return $the_sidebar;
        }

        return false;
    }

    /**
     * Display sidebar if exists
     *
     * @return void
     */
    public function display(){
        $params = $this->getSidebar();
        $name = (is_array($params) && count($params) > 0) ? '-' . implode('-', $params) : '';
        $sidebar_file = "sidebar{$name}";
        $col = static::$col;
        $this->clearSidebars();
        $theme_columns = \ahura\app\mw_options::get_theme_columns();
        $is_woocommerce_page = \ahura\app\woocommerce::is_woocommerce_page();
        $sidebar = static::getInstance();
        $path = get_theme_file_path("template-parts/sidebar/{$sidebar_file}.php");
        if(file_exists($path) && is_readable($path)){
            include($path);
        }
    }

    /**
     * Set sidebar col
     *
     * @param string $col
     * @return object
     */
    public function col($col = ''){
        static::$col = $col;
        return clone static::$instance;
    }

    /**
     * Get sidebar
     *
     * @param string $key
     * @return void
     */
    public function getSidebar(){
        return static::$params;
    }

    /**
     * Clear all sidebar names
     *
     * @return void
     */
    private function clearSidebars(){
        static::$params = [];
    }

    /**
     * 
     * Set sidebar name with class instance dynamic methods
     * 
     * sample: Ahura_Sidebar_Controller::getInstance()->sticky()->left()->display() : sidebar-sticky-left.php
     * 
     */
    public function __call($root, $params){
        static::$params[] = $root;
        return clone static::$instance;
    }
}