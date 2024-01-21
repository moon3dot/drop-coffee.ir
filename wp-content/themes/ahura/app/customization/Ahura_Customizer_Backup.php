<?php
namespace ahura\app\customization;

final class Ahura_Customizer_Backup {
	/**
	 * An array of core options that shouldn't be imported.
	 *
	 * @var array $core_options
	 */
	static private $core_options = array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);

	/**
	 * Check to see if we need to do an export or import.
	 *
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static public function init($wp_customize)
	{
		if (current_user_can('edit_theme_options')) {
			if (isset($_REQUEST['ahura-customizer-export'])) {
				self::export($wp_customize);
			}
			if (isset($_REQUEST['ahura-customizer-import']) && isset($_FILES['ahura-import-file'])) {
				self::import($wp_customize);
			}
		}
	}

	/**
	 * Export customizer settings.
	 *
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function export($wp_customize)
	{
		if (!wp_verify_nonce($_REQUEST['ahura-customizer-export'], 'ahura-exporting')) {
			return;
		}

		$theme = get_stylesheet();
		$template = get_template();
		$charset = get_option('blog_charset');
		$mods = get_theme_mods();
		$data = array(
            'template' => $template,
            'mods' => $mods ? $mods : array(),
            'options' => array()
        );

		$settings = $wp_customize->settings();

		foreach ($settings as $key => $setting){
			if ('option' == $setting->type) {
				if ('widget_' === substr(strtolower($key), 0, 7 )) {
					continue;
				}
				if ('sidebars_' === substr(strtolower($key), 0, 9 )) {
					continue;
				}
				if (in_array( $key, self::$core_options )) {
					continue;
				}
				$data['options'][ $key ] = $setting->value();
			}
		}

		$option_keys = apply_filters('ahura_export_option_keys', array());

		foreach ($option_keys as $option_key) {
			$data['options'][ $option_key ] = get_option($option_key);
		}

		if(function_exists('wp_get_custom_css_post')) {
			$data['wp_css'] = wp_get_custom_css();
		}

		$save_time = update_option('ahura_settings_export_last_time', time());

        $date = date('Y-m-d');

		header('Content-disposition: attachment; filename=' . $theme . '-export-'. str_replace([' ', ':'], '-', $date) . '--' . time() .'.dat');
		header('Content-Type: application/octet-stream; charset=' . $charset);

		echo serialize($data);

		die();
	}

	/**
	 * Imports uploaded mods and calls WordPress core customize_save actions so
	 * themes that hook into them can act before mods are saved to the database.
	 *
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function import($wp_customize)
	{
		if (!wp_verify_nonce($_REQUEST['ahura-customizer-import'], 'ahura-importing')) {
			return;
		}

		if (!function_exists('wp_handle_upload')) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}

		global $wp_customize;
		global $ahura_error;

		$ahura_error = false;
		$template = get_template();
		$overrides = array('test_form' => false, 'test_type' => false, 'mimes' => array('dat' => 'text/plain'));
		$file = wp_handle_upload($_FILES['ahura-import-file'], $overrides);

		if (isset($file['error'])) {
			$ahura_error = $file['error'];
			return;
		}
		if (!file_exists($file['file'])) {
			$ahura_error = __('Error importing settings! Please try again.', 'ahura');
			return;
		}

		$raw = file_get_contents($file['file']);
		$data = @unserialize($raw);

		unlink($file['file']);

		if ('array' != gettype($data)) {
			$ahura_error = __('Error importing settings! Please check that you uploaded a customizer export file.', 'ahura');
			return;
		}
		if (!isset($data['template']) || !isset( $data['mods'])) {
			$ahura_error = __('Error importing settings! Please check that you uploaded a customizer export file.', 'ahura');
			return;
		}
		if ( $data['template'] != $template ) {
			$ahura_error = __( 'Error importing settings! The settings you uploaded are not for the current theme.', 'ahura' );
			return;
		}

		if (isset($_REQUEST['ahura-import-images'])) {
			$data['mods'] = self::import_images($data['mods']);
		}

		if (isset($data['options'])) {
			foreach ($data['options'] as $option_key => $option_value) {
				$option = new \ahura\app\customization\Ahura_Customizer_Backup_Option($wp_customize, $option_key, array(
					'default'		=> '',
					'type'			=> 'option',
					'capability'	=> 'edit_theme_options'
				) );

				$option->import($option_value);
			}
		}

		if(function_exists('wp_update_custom_css_post') && isset($data['wp_css']) && '' !== $data['wp_css']) {
			wp_update_custom_css_post($data['wp_css']);
		}

		$save_time = update_option('ahura_settings_import_last_time', time());

		do_action('customize_save', $wp_customize);

		foreach ($data['mods'] as $key => $val) {
			do_action('customize_save_' . $key, $wp_customize);
			set_theme_mod($key, $val);
		}

		do_action('customize_save_after', $wp_customize);
	}

	/**
	 * Imports images for settings saved as mods.
	 *
	 * @param array $mods An array of customizer mods.
	 * @return array The mods array with any new import data.
	 */
	static private function import_images($mods)
	{
		foreach ($mods as $key => $val) {
			if (self::is_image_url($val)) {
				$data = self::sideload_image($val);

				if (!is_wp_error($data)) {
					$mods[ $key ] = $data->url;
					if (isset($mods[$key . '_data'])) {
						$mods[$key . '_data'] = $data;
						update_post_meta($data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet());
					}
				}
			}
		}

		return $mods;
	}

	/**
	 * Taken from the core media_sideload_image function and
	 *
	 * @param string $file The image file path.
	 * @return array An array of image data.
	 */
	static private function sideload_image($file)
	{
		$data = new \stdClass();

		if (!function_exists( 'media_handle_sideload')) {
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
		}
		if (!empty($file)) {
			preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches);
			$file_array = array();
			$file_array['name'] = basename($matches[0]);

			$file_array['tmp_name'] = download_url($file);

			if (is_wp_error($file_array['tmp_name'])) {
				return $file_array['tmp_name'];
			}

			$id = media_handle_sideload($file_array, 0);

			if (is_wp_error($id)) {
				@unlink($file_array['tmp_name']);
				return $id;
			}

			$meta = wp_get_attachment_metadata($id);
			$data->attachment_id = $id;
			$data->url = wp_get_attachment_url($id);
			$data->thumbnail_url = wp_get_attachment_thumb_url($id);
			$data->height = $meta['height'];
			$data->width = $meta['width'];
		}

		return $data;
	}

	/**
	 * Checks to see whether a string is an image url or not.
	 *
	 * @param string $string The string to check.
	 * @return bool Whether the string is an image url or not.
	 */
	static private function is_image_url($string = '')
	{
		if (is_string($string)) {
			if (preg_match('/\.(jpg|jpeg|png|gif)/i', $string)) {
				return true;
			}
		}

		return false;
	}
}
