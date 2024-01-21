<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Setting')){
    final class Ahura_Customizer_Backup_Option extends \WP_Customize_Setting {
        /**
         * Import an option value for this setting.
         *
         * @param mixed $value The option value.
         * @return void
         */
        public function import($value) 
        {
            $this->update($value);	
        }
    }
}