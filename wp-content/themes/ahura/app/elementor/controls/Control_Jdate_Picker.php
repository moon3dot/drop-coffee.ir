<?php

namespace ahura\app\elementor\controls;

defined('ABSPATH') or die('No script kiddies please!');

use \Elementor\Base_Data_Control;

class Control_Jdate_Picker extends Base_Data_Control
{
    const JDATE_TIME = 'jdate_picker';

    /**
     * Set control type.
     */
    public function get_type()
    {
        return self::JDATE_TIME;
    }

    /**
     * Enqueue control scripts and styles.
     */
    public function enqueue()
    {
        wp_register_style('persian_datepicker', get_template_directory_uri() . '/css/persianDatepicker.css', null, '0.6.0');
        wp_enqueue_style('persian_datepicker');

        wp_register_script('persian_datepicker', get_template_directory_uri() . '/js/persianDatepicker.js', null, '0.1.0', true);
        wp_enqueue_script('persian_datepicker');
        wp_register_script('jdate_picker', get_template_directory_uri() . '/js/jdate-picker.js', null, '1.0.0', true);
        wp_enqueue_script('jdate_picker');
    }

    /**
     * Set default settings
     */
    protected function get_default_settings()
    {
        return [
            'label_block' => true,
        ];
    }

    public function content_template()
    {
        ?>
        <div class="elementor-control-field">
            <label for="<?php $this->print_control_uid(); ?>" class="elementor-control-title">{{{data.label}}}</label>
            <div class="elementor-control-input-wrapper">
                <input id="<?php $this->print_control_uid(); ?>" placeholder="{{view.getControlPlaceholder()}}" type="text" dir="ltr" class="elementor-jdate-time-picker jdate-picker-input" data-setting="{{data.name}}" readonly="readonly">
            </div>
        </div>
        <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{data.description}}}</div>
        <# } #>
        <?php
    }
}