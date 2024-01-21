<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\simple_range;

$this->customizer->add_setting('ahura_content_radius', ['default' => 10]);
$this->customizer->add_control(new simple_range( $this->customizer, 'ahura_content_radius',array(
        'label' => __('Content border radius','ahura'),
        'section' => $this->current_section,
        'input_attrs' => array(
            'min' => 0,
            'max' => 100,
        ),
    ) )
);

$this->customizer->add_setting('ahura_content_shadow', ['default' => 10]);
$this->customizer->add_control(new simple_range( $this->customizer, 'ahura_content_shadow',array(
        'label' => __('Content box shadow','ahura'),
        'section' => $this->current_section,
        'input_attrs' => array(
            'min' => 0,
            'max' => 100,
        ),
    ) )
);

$this->customizer->add_setting('ahura_sidebar_widget_radius', ['default' => 10]);
$this->customizer->add_control(new simple_range( $this->customizer, 'ahura_sidebar_widget_radius',array(
        'label' => __('Widget box border radius','ahura'),
        'section' => $this->current_section,
        'input_attrs' => array(
            'min' => 0,
            'max' => 100,
        ),
    ) )
);