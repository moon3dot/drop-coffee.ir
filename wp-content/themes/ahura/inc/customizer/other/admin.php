<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\simple_notice;

if (is_rtl()){
    $this->customizer->add_setting('ahura_admin_font', ['default' => 'iransans']);
    $this->customizer->add_control('ahura_admin_font', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => __('Admin Panel Font', 'ahura'),
        'choices' => \ahura\app\mw_options::get_ahura_fonts()
    ]);
} else {
    $this->customizer->add_setting( 'ahura_admin_font_notice', [ 'default' => '' ] );
    $this->customizer->add_control( new simple_notice( $this->customizer, 'ahura_admin_font_notice',[
            'description' => __( 'Font change is only available in RTL languages.', 'ahura' ),
            'section' => $this->current_section,
        ]
    ) );
}