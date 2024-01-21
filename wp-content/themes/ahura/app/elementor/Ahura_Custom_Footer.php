<?php
namespace ahura\app\elementor;

if(!class_exists('\ahura\app\elementor\Ahura_Elementor_Builder'))
{
    return false;
}
class Ahura_Custom_Footer extends \ahura\app\elementor\Ahura_Elementor_Builder
{
    /**
     * Ahura_Custom_Footer constructor.
     */
    public function __construct()
    {
        $this->content_id = get_theme_mod('custom_footer');
    }
}