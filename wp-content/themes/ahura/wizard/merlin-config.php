<?php
if(!class_exists('\ahura\app\mw_config')){
    include_once get_template_directory() . '/app/mw_config.php';
}
if(!class_exists('\ahura\app\license')){
    include_once get_template_directory() . '/app/license.php';
}

use ahura\app\mw_config;

load_theme_textdomain('ahura', get_template_directory() . '/languages');

function merlin_import_files() {
	if(!\ahura\app\license::is_active()){
		return [];
	}
	
	$license_key = \ahura\app\license::get_license_key();

	if(!$license_key){
		return [];
	}

	return \ahura\app\Studio_Demo::get_demo_list();
}
add_filter( 'merlin_import_files', 'merlin_import_files' );


/**
 * Merlin WP configuration file.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and settings.
 */
add_filter('mw_ahura_edd_remote_api_url', function($server){
	$license_key = get_option('ahura_license_key');
	if($license_key)
	{
        $server = strpos($license_key, 'ertano_') === 0 ? 'https://ertano.com/' : $server;
	}
	return $server;
});

$wizard = new Merlin(
	$config = array(
		'directory'            => 'wizard/merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'ahura-wizard', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => mw_config::getParentMenuSlug(), // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => !defined('AHURA_LICENSE_KEY'), // EDD license activation step.
		'license_required'     => true, // Require the license activation step.
		'license_help_url'     => 'https://mihanwp.com/mwpanel/?tab=3', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => apply_filters('mw_ahura_edd_remote_api_url', 'https://mihanwp.com'), // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => 'ahura', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => 'ahura', // EDD_Theme_Updater_Admin item_slug.
		'child_action_btn_url' => 'https://mihanwp.com/child-theme/',
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup', 'ahura' ),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'ahura' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'ahura' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'ahura' ),

		'btn-skip'                 => esc_html__( 'Skip', 'ahura' ),
		'btn-next'                 => esc_html__( 'Next', 'ahura' ),
		'btn-start'                => esc_html__( 'Start', 'ahura' ),
		'btn-no'                   => esc_html__( 'Cancel', 'ahura' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'ahura' ),
		'btn-child-install'        => esc_html__( 'Install', 'ahura' ),
		'btn-content-install'      => esc_html__( 'Install', 'ahura' ),
		'btn-import'               => esc_html__( 'Import', 'ahura' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'ahura' ),
		'btn-license-skip'         => esc_html__( 'Later', 'ahura' ),

		/* translators: Theme Name */
		'license-header%s'         => esc_html__( 'Activate %s', 'ahura' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'ahura' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'ahura' ),
		'license-label'            => esc_html__( 'License key', 'ahura' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'ahura' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'ahura' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'ahura' ),

		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Welcome to %s', 'ahura' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'ahura' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'ahura' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'ahura' ),

		'child-header'             => esc_html__( 'Install Child Theme', 'ahura' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'ahura' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'ahura' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'ahura' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'ahura' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'ahura' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'ahura' ),

		'plugins-header'           => esc_html__( 'Install Plugins', 'ahura' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'ahura' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'ahura' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'ahura' ),
		'plugins-action-link'      => esc_html__( 'Advanced', 'ahura' ),

		'import-header'            => esc_html__( 'Import Content', 'ahura' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'ahura' ),
		'import-action-link'       => esc_html__( 'Advanced', 'ahura' ),

		'ready-header'             => esc_html__( 'All done. Have fun!', 'ahura' ),

		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'ahura' ),
		'ready-action-link'        => esc_html__( 'Extras', 'ahura' ),
		'ready-big-button'         => esc_html__( 'View your website', 'ahura' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://mihanwp.com', esc_html__( 'Explore MihanWP', 'ahura' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://mihanwp.com/docs/', esc_html__( 'Theme Documentation', 'ahura' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'ahura' ) ),
	)
);


function mihanwp_merlin_after_import_setup() {

}
add_action( 'merlin_after_all_import', 'mihanwp_merlin_after_import_setup' );

//function mihanwp_merlin_unset_default_widgets_args( $widget_areas ) {
//	$widget_areas = array(
//		'sidebar-1' => array(),
//	);
//	return $widget_areas;
//}
//add_filter( 'merlin_unset_default_widgets_args', 'mihanwp_merlin_unset_default_widgets_args' );
