<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_select_box;

$theme_post_types = \ahura\app\mw_post_type::get_post_types();
$types = array();
if($theme_post_types){
    foreach ($theme_post_types as $key => $value) {
        if(is_array($value) && isset($value['is_public'])){
            if($value['is_public'] == true){
                $types[$key] = $value['labels']['singular_name'];
            }
        }
    }
}

$this->customizer->add_setting('ahura_disabled_post_types');
$this->customizer->add_control(new simple_select_box($this->customizer, 'ahura_disabled_post_types', [
    'section' => $this->current_section,
    'label' => __('Disabled post types', 'ahura'),
    'choices' => $types,
    'input_attrs' => [
        'multiple' => true,
        'class' => 'ahura-select'
    ],
]));

$this->customizer->add_setting('ahura_convert_dates_to_jalali');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_convert_dates_to_jalali', array(
    'label'      => __('Convert Dates to Jalali', 'ahura'),
    'section'    => $this->current_section,
)));

$this->customizer->add_setting('ahura_allow_upload_svg');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_allow_upload_svg', array(
    'label'      => __('Allow Upload SVG File', 'ahura'),
    'section'    => $this->current_section,
    'description' => __('Uploading this type of file is not safe, temporarily enable it.', 'ahura')
)));

$this->customizer->add_setting('ahura_allow_upload_json');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_allow_upload_json', array(
    'label'      => __('Allow Upload JSON File', 'ahura'),
    'section'    => $this->current_section,
    'description' => __('Uploading this type of file is not safe, temporarily enable it.', 'ahura')
)));

$this->customizer->add_setting('ahura_allow_upload_webp');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_allow_upload_webp', array(
    'label'      => __('Allow Upload WEBP File', 'ahura'),
    'section'    => $this->current_section,
)));

$this->customizer->add_setting('ahura_allow_upload_ico');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_allow_upload_ico', array(
    'label'      => __('Allow Upload ICO File', 'ahura'),
    'section'    => $this->current_section,
)));

$this->customizer->add_setting('ahura_images_lightbox_status');
$this->customizer->add_control(new ios_checkbox( $this->customizer, 'ahura_images_lightbox_status', [
    'section' => $this->current_section,
    'label' => __('Enable images lightbox', 'ahura'),
    'description' => __('This feature is activated only on the single post and products.', 'ahura'),
]));