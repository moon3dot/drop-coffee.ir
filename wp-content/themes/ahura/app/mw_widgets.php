<?php
namespace ahura\app;
class mw_widgets
{
    static function init()
    {
        self::change_recent_post_widget();
        register_widget('\ahura\app\widgets\socials');
        /*Ahura Socials 2*/
        register_widget('\ahura\app\widgets\socials2');
        /*Ahura Socials 3*/
        register_widget('\ahura\app\widgets\socials3');
        /*Show Posts*/
        register_widget('\ahura\app\widgets\show_posts');
        /*Contact*/
        register_widget('\ahura\app\widgets\contact');
        /*Contact2*/
        register_widget('\ahura\app\widgets\contact2');
        /*About Us*/
        register_widget('\ahura\app\widgets\aboutus');

        self::register_wc_widgets();
    }

    public static function register_wc_widgets(){
        register_widget('\ahura\app\widgets\woocommerce\Filter_Color_Widget');
        register_widget('\ahura\app\widgets\woocommerce\Filter_Rating_Widget');
        register_widget('\ahura\app\widgets\woocommerce\Filter_Brand_Widget');
    }

    static function change_recent_post_widget()
    {
        unregister_widget('WP_Widget_Recent_Posts');
        register_widget('\ahura\app\widgets\recent_posts');
    }
}
