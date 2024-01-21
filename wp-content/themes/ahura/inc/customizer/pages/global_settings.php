<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;

$this->customizer->add_setting('page_comment_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'page_comment_status', array(
    'label' => __('Comments', 'ahura'),
    'section' => $this->current_section,
)));