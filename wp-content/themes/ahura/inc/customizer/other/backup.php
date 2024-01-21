<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\backup_control;
use ahura\app\customization\ios_checkbox;

$this->customizer->add_setting('ahura_backup_setting', array(
    'default' => '',
    'type'	  => 'none'
));

$this->customizer->add_control(new backup_control(
    $this->customizer,
    'ahura_backup_setting',
    array(
        'section'	=> $this->current_section,
        'priority'	=> 1
    )
));

$move_child_params = [
    'label'           => __( 'Transfer settings from ahura main theme to child theme.', 'ahura' ),
    'description' => __( 'The transition is done when the parent template is active and then you want to activate the child template.', 'ahura' ),
    'settings'        => 'ahura_move_customizer_to_child_theme',
    'section'         => $this->current_section,
];

if(is_child_theme()){
    $move_child_params['description'] = __('Child theme is active.', 'ahura');
    $move_child_params['input_attrs']['disabled'] = true;
}

$this->customizer->add_setting( 'ahura_move_customizer_to_child_theme', ['default'  => false] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_move_customizer_to_child_theme',  $move_child_params) );
