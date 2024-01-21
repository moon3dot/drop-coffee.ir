<?php
/**
 *
 * Block direct access to the main plugin file.
 *
 */
defined('ABSPATH') or die('No script kiddies please!');
final class Ahura_Elementor_Init {
    const VERSION = '1';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.4';

    private $widgets = [];
    private $namespace = 'widget';
    private $widgets_manager;

    private static $_instance = null;

    /**
     *
     *
     * Ahura_Elementor_Init singleton
     *
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     *
     *
     * Ahura_Elementor_Init construction
     *
     */
    public function __construct()
    {
        add_action('admin_notices', [$this, '_check_requirements_minimum_version']);

        add_action('elementor/widgets/register', [$this, 'widgets_registered']);

        $this->load_settings();
    }

    /**
     * Elements settings
     *
     * @return void
     */
    private function load_settings(){
        $settings = [
            'User_Visibility'
        ];

        if($settings){
            foreach($settings as $setting){
                $base_path = '/app/elementor/';
                $namespace = '\ahura\app\elementor\settings';
                $cls_name = $namespace . '\\' . $setting;

                if(!class_exists('\ahura\app\elementor\Ahura_Elements_Settings')){
                    $class_path = get_parent_theme_file_path($base_path . 'Ahura_Elements_Settings.php');
                    if(file_exists($class_path) && is_readable($class_path)){
                        require_once($class_path);
                    }
                }

                if(!class_exists($cls_name)){
                    $class_path = get_parent_theme_file_path('/app/elementor/settings/' . $setting . '.php');
                    if(file_exists($class_path) && is_readable($class_path)){
                        require_once($class_path);
                    }
                }

                if(class_exists($cls_name)){
                    $cls_name::instance();
                }
            }
        }
    }

    /**
     * Elementor register widgets
     *
     * @return void
     */
    private function register_widgets(){
        /**
         * Section Global widgets
         */
        $this->register_widget('grid_icons');
        $this->register_widget('grid_posts');
        $this->register_widget('grid_posts2');
        $this->register_widget('grid_posts3');
        $this->register_widget('grid_posts4');
        $this->register_widget('grid_posts5');
        $this->register_widget('grid_posts6');
        $this->register_widget('grid_posts7');
        $this->register_widget('grid_posts8');
        $this->register_widget('grid_posts9');
        $this->register_widget('grid_posts10');
        $this->register_widget('grid_posts11');
        $this->register_widget('grid_posts_12');
        $this->register_widget('grid_products');
        $this->register_widget('grid_products2');
        $this->register_widget('grid_products3');
        $this->register_widget('blog_box_posts');
        $this->register_widget('blog_box_posts2');
        $this->register_widget('item_portfolio');
        $this->register_widget('post_archive');
        $this->register_widget('post_archive2');
        $this->register_widget('post_carousel');
        $this->register_widget('post_carousel2');
        $this->register_widget('post_carousel3');
        $this->register_widget('post_carousel_4');
        $this->register_widget('post_list');
        $this->register_widget('post_list2');
        $this->register_widget('post_list3');
        $this->register_widget('post_list4');
        $this->register_widget('post_list_5');
        $this->register_widget('post_list_6');
        $this->register_widget('post_grid_tab');
        $this->register_widget('product_pricebox_1');
        $this->register_widget('shop_carousel');
        $this->register_widget('shop_carousel2');
        $this->register_widget('shop_carousel3');
        $this->register_widget('shop_carousel4');
        $this->register_widget('shop_carousel5');
        $this->register_widget('bestseller_carousel');
        $this->register_widget('shop_category');
        $this->register_widget('shop_category1');
        $this->register_widget('shop_category2');
        $this->register_widget('shop_category3');
        $this->register_widget('shop_category4');
        $this->register_widget('shop_category5');
        $this->register_widget('shop_category6');
        $this->register_widget('iconbox');
        $this->register_widget('icon_box_2');
        $this->register_widget('icon_box_3');
        $this->register_widget('icon_box_4');
        $this->register_widget('icon_box_5');
        $this->register_widget('icon_box_6');
        $this->register_widget('item_videobox');
        $this->register_widget('img_hotspot');
        $this->register_widget('imgbox');
        $this->register_widget('imgbox2');
        $this->register_widget('imgbox3');
        $this->register_widget('item_call_action');
        $this->register_widget('shop_countdown');
        $this->register_widget('charts');
        $this->register_widget('countdown');
        $this->register_widget('countdown3');
        $this->register_widget('search_input');
        $this->register_widget('services_box');
        $this->register_widget('services_box2');
        $this->register_widget('services_box3');
        $this->register_widget('special_title');
        $this->register_widget('sharing_buttons');
        $this->register_widget('circular_box');
        $this->register_widget('banner_box_1');
        $this->register_widget('banner_box_2');
        $this->register_widget('banner_box_3');
        $this->register_widget('banner_box_4');
        $this->register_widget('banner_box_5');
        $this->register_widget('notice');
        $this->register_widget('notice_box_2');
        $this->register_widget('notice_box_3');
        $this->register_widget('typewriter');
        $this->register_widget('colorful_title');
        $this->register_widget('colorful_title2');
        $this->register_widget('radio_post');
        $this->register_widget('suggestion_posts');
        $this->register_widget('introduction_box');
        $this->register_widget('mailer_lite');
        $this->register_widget('mailer_lite2');
        $this->register_widget('price_table');
        $this->register_widget('service_price_box');
        $this->register_widget('price_box_2');
        $this->register_widget('price_box_3');
        $this->register_widget('price_box_4');
        $this->register_widget('price_box_5');
        $this->register_widget('price_box_6');
        $this->register_widget('price_box_7');
        $this->register_widget('price_box_8');
        $this->register_widget('price_box_9');
        $this->register_widget('price_box_10');
        $this->register_widget('price_box_11');
        $this->register_widget('price_box_12');
        $this->register_widget('price_box_13');
        $this->register_widget('price_box_14');
        $this->register_widget('price_box_15');
        $this->register_widget('php_snippet');
        $this->register_widget('image_box');
        $this->register_widget('information_box');
        $this->register_widget('information_box_2');
        $this->register_widget('information_box_3');
        $this->register_widget('information_box_4');
        $this->register_widget('information_box_5');
        $this->register_widget('information_box_6');
        $this->register_widget('information_box_7');
        $this->register_widget('information_box_8');
        $this->register_widget('information_box_9');
        $this->register_widget('information_box_10');
        $this->register_widget('table');
        $this->register_widget('testimonial_box1');
        $this->register_widget('testimonial_box2');
        $this->register_widget('testimonial_box3');
        $this->register_widget('testimonial_box4');
        $this->register_widget('testimonial_box5');
        $this->register_widget('testimonial_box6');
        $this->register_widget('testimonial_carousel');
        $this->register_widget('testimonial_carousel2');
        $this->register_widget('testimonial_carousel3');
        $this->register_widget('testimonial_carousel4');
        $this->register_widget('testimonial_carousel5');
        $this->register_widget('testimonial_carousel6');
        $this->register_widget('testimonial_carousel7');
        $this->register_widget('category_box');
        $this->register_widget('items_carousel');
        $this->register_widget('video_carousel');
        $this->register_widget('video_carousel2');
        $this->register_widget('video_post_grid');
        $this->register_widget('timeline');
        $this->register_widget('timeline_2');
        $this->register_widget('navbar');
        $this->register_widget('navbar2');
        $this->register_widget('navbar3');
        $this->register_widget('news_ticker');
        $this->register_widget('product_tab');
        $this->register_widget('product_tab2');
        $this->register_widget('product_box_carousel');
        $this->register_widget('product_customers');
        $this->register_widget('breadcrumb');
        $this->register_widget('sound_player');
        $this->register_widget('video_player');
        $this->register_widget('offer_carousel');
        $this->register_widget('image_slider');
        $this->register_widget('image_slider2');
        $this->register_widget('image_slider3');
        $this->register_widget('templates_carousel');
        $this->register_widget('mapbox_1');
        $this->register_widget('neshan_map');
        $this->register_widget('alert_box');
        $this->register_widget('double_button');
        $this->register_widget('before_after');
        $this->register_widget('product_intro');
        $this->register_widget('products_category');
        $this->register_widget('products_category2');
        $this->register_widget('team_members');
        $this->register_widget('gallery');
        $this->register_widget('story');
        $this->register_widget('brands');
        $this->register_widget('card_box');
        $this->register_widget('card_box_2');
        $this->register_widget('card_box_3');
        $this->register_widget('card_box_4');
        $this->register_widget('modal_video');
        $this->register_widget('faq');
        $this->register_widget('faq_2');
        $this->register_widget('faq_3');
        $this->register_widget('faq_4');
        $this->register_widget('lottie');
        $this->register_widget('tabs');
        $this->register_widget('gotop');
    }

    public function register_section_builder_elements(){
        $widgets = [
            'page_title' => '\ahura_page_title',
        ];

        $base = __DIR__ . '/widgets/section-builder/';

        $this->register_widgets_by_loop($base, $widgets);
    }

    public function register_header_widgets(){
        $widgets = [
            'logo' => '\Elementor_ahura_logo',
            'logo_svg' => '\Elementor_ahura_logo_svg',
            'popup_search' => '\Ahura_Popup_Search',
            'search' => '\Ahura_Search',
            'menu' => '\Ahura_Menu',
            'menu2' => '\Ahura_Menu2',
            'main_menu' => '\Ahura_Main_Menu',
            'mega_menu' => '\Ahura_Mega_Menu',
            'mega_menu2' => '\Ahura_Mega_Menu2',
            'mobile_menu' => '\Ahura_Mobile_Menu',
            'mobile_menu2' => '\Ahura_Mobile_Menu2',
            'mini_cart' => '\Ahura_Mini_Cart',
            'mini_cart2' => '\Ahura_Mini_Cart2',
            'popup_login' => '\Ahura_Popup_Login',
            'theme_mode_button' => '\Ahura_Theme_Mode_Button',
        ];

        $base = __DIR__ . '/widgets/header/';

        $this->register_widgets_by_loop($base, $widgets);
    }

    public function register_archive_widgets(){
        $widgets = [
            'archive_posts' => '\ahura_archive_posts',
        ];

        $base = __DIR__ . '/widgets/archive/';

        $is_archive = is_archive();

        if (!$is_archive){
            $post_id = get_the_ID();
            $page_type = \ahura\app\Post_Meta::get_template_type($post_id);
            if ($page_type === 'archive'){
                $is_archive = true;
            }
        }

        if (!$is_archive && isset($_GET['section_type']) && $_GET['section_type'] == 'archive'){
            $is_archive = true;
        }

        if (!$is_archive) return false;

        $this->register_widgets_by_loop($base, $widgets);
    }

    private function register_widgets_by_loop($base, $widgets){
        foreach ($widgets as $filename => $class){
            $path = $base . "{$filename}.php";

            $this->widgets['other'][] = ['file' => $filename, 'class' => $class];

            if (!file_exists($path))
                continue;

            require_once($path);

            if (!class_exists($class))
                continue;

            $obj = new $class();

            if ($this->widgets_manager){
                $this->widgets_manager->register($obj);
            }
        }
    }

    /**
     * Registered widgets append to elementor
     *
     * @return void
     */
    public function widgets_registered($widgets_manager){
        $this->widgets_manager = $widgets_manager;

        $widgets = $this->get_widgets();

        if($widgets && is_array($widgets) && isset($widgets['global'])){
            foreach($widgets['global'] as $widget){
                $class_name = $widget['namespace'] . '\\' . $widget['widget'];
                $post_type = !empty($widget['post_type']) ? $widget['post_type'] : '';
                $check_disabled = ($widget['check_disabled'] == true);

                if(class_exists($class_name)){
                    $class = new $class_name();

                    if($post_type){
                        if($check_disabled && post_type_exists($post_type) && !\ahura\app\mw_post_type::is_disabled_post_type($post_type)){
                            $widgets_manager->register($class);
                        } elseif(post_type_exists($post_type)){
                            $widgets_manager->register($class);
                        }
                    } else {
                        $widgets_manager->register($class);
                    }
                }
            }
        }
    }

    /**
     * Elements namespaces
     *
     * @return string
     */
    private function get_namespace(){
        $base = 'ahura\inc\widgets';
        $namespaces = array(
            'widget' => $base,
            'builder' => $base . '\section_builder',
            'header' => $base . '\header',
        );

        return (!empty($this->namespace) && isset($namespaces[$this->namespace])) ? $namespaces[$this->namespace] : $this->namespace;
    }

    /**
     * Set widget class namespace
     *
     * @param string $namespace
     * @return object
     */
    private function namespace($namespace = 'widget'){
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Register a widget
     *
     * @param string $widget
     * @param string $post_type
     * @param boolean $check_disabled_post_type
     * @return void
     */
    private function register_widget($widget, $post_type = '', $check_disabled_post_type = false){
        $this->widgets['global'][] = ['namespace' => $this->get_namespace(), 'widget' => $widget, 'post_type' => $post_type, 'check_disabled' => $check_disabled_post_type];
    }

    /**
     * Get registered widgets
     *
     * @return array
     */
    public function get_widgets(){
        $this->register_section_builder_elements();
        $this->register_header_widgets();
        $this->register_archive_widgets();
        $this->register_widgets();
        return $this->widgets;
    }

    /**
     * Elementor minimum version check notice
     *
     * @return string
     */
    public function _check_requirements_minimum_version(){
        echo \ahura\app\mw_config::_notice_minimum_version('Elementor', self::MINIMUM_ELEMENTOR_VERSION, get_option('elementor_version'));
    }
}

Ahura_Elementor_Init::instance();

function register_elementor_controls($controls_manager)
{
    /**
     *
     * Controls class name
     *
     */
    $controls = [
        'Control_Jdate_Picker',
    ];
    if ($controls) {
        foreach ($controls as $control) {
            $class = '\ahura\app\elementor\controls' . '\\' . $control;
            if (class_exists($class) && method_exists($class, 'get_type')) {
                $class = new $class();
                $controls_manager->register($class);
            }
        }
    }
}

add_action('elementor/controls/register', 'register_elementor_controls');

function add_elementor_ahura_widget_categories($elements_manager)
{
    $elements_manager->add_category(
        'ahura_archive',
        [
            'title' => __('Ahura Archive Elements', 'ahura'),
            'icon' => 'fa fa-plug',
        ]
    );

    $elements_manager->add_category(
        'ahuraelements',
        [
            'title' => __('Ahura Elements', 'ahura'),
            'icon' => 'fa fa-plug',
        ]
    );
    $elements_manager->add_category(
        'ahura_posts',
        [
            'title' => __("Ahura Posts", 'ahura'),
        ]
    );
    $elements_manager->add_category(
        'ahura_woocommerce',
        [
            'title' => __("Ahura Woocommerce", 'ahura'),
        ]
    );
    $elements_manager->add_category(
        'ahura_price_box',
        [
            'title' => __("Ahura Price Box", 'ahura'),
        ]
    );
    $elements_manager->add_category(
        'ahurabuilder',
        [
            'title' => __('Ahura Builder', 'ahura'),
            'icon' => 'fa fa-plug',
        ]
    );
    $elements_manager->add_category(
        'ahuraheader',
        [
            'title' => __('Ahura Header', 'ahura'),
            'icon' => 'fa fa-plug',
        ]
    );
    $elements_manager->add_category(
        'ahuranavbar',
        [
            'title' => __('Ahura Navbar Elements', 'ahura'),
            'icon' => 'fa fa-plug',
        ]
    );
}

add_action('elementor/elements/categories_registered', 'add_elementor_ahura_widget_categories');