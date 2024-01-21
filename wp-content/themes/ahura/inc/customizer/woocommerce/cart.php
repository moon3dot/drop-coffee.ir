<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\ios_checkbox;

$this->customizer->add_setting('ahura_show_productimg_rescart');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_productimg_rescart', [
    'label' => __('Show product image on responsive cart page', 'ahura'),
    'section' => $this->current_section
]));