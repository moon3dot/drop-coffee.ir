<?php
// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * 
 * Register customizer export/import action
 * 
 */
add_action('customize_register', '\ahura\app\customization\Ahura_Customizer_Backup::init', 999999);

/**
 * Register customizer tabs
 *
 * @param object $wp_customize
 * @return void
 */
add_action('customize_register', function ($wp_customize){
    $customizer = new \ahura\app\customization\Customizer_Settings($wp_customize);
    $customizer->render_customizer_options();
});
