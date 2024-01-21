<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;

$this->customizer->add_setting( 'woocommerce_checkout_country_field', [ 'default' => 'optional' ] );
$this->customizer->add_control( 'woocommerce_checkout_country_field', [
    'label'       =>  __( 'Country field', 'ahura' ),
    'section'     => $this->current_section,
    'settings'    => 'woocommerce_checkout_country_field',
    'type'        => 'select',
    'choices'     => [
        'hidden'  => __( 'Hidden', 'ahura' ),
        'optional'=> __( 'Optional', 'ahura' ),
        'required'=> __( 'Required', 'ahura' ),
    ],
    'priority'    => 1,
] );

$this->customizer->add_setting( 'woocommerce_checkout_billing_address_1', [ 'default' => 'optional' ] );
$this->customizer->add_control( 'woocommerce_checkout_billing_address_1', [
    'label'       =>  __( 'Address field', 'ahura' ),
    'section'     => $this->current_section,
    'settings'    => 'woocommerce_checkout_billing_address_1',
    'type'        => 'select',
    'choices'     => [
        'hidden'  => __( 'Hidden', 'ahura' ),
        'optional'=> __( 'Optional', 'ahura' ),
        'required'=> __( 'Required', 'ahura' ),
    ],
    'priority'    => 2,
] );

$this->customizer->add_setting( 'woocommerce_checkout_billing_city', [ 'default' => 'required' ] );
$this->customizer->add_control( 'woocommerce_checkout_billing_city', [
    'label'       =>  __( 'City field', 'ahura' ),
    'section'     => $this->current_section,
    'settings'    => 'woocommerce_checkout_billing_city',
    'type'        => 'select',
    'choices'     => [
        'hidden'  => __( 'Hidden', 'ahura' ),
        'optional'=> __( 'Optional', 'ahura' ),
        'required'=> __( 'Required', 'ahura' ),
    ],
    'priority'    => 3,
] );

$this->customizer->add_setting( 'woocommerce_checkout_billing_state', [ 'default' => 'optional' ] );
$this->customizer->add_control( 'woocommerce_checkout_billing_state', [
    'label'       =>  __( 'State field', 'ahura' ),
    'section'     => $this->current_section,
    'settings'    => 'woocommerce_checkout_billing_state',
    'type'        => 'select',
    'choices'     => [
        'hidden'  => __( 'Hidden', 'ahura' ),
        'optional'=> __( 'Optional', 'ahura' ),
        'required'=> __( 'Required', 'ahura' ),
    ],
    'priority'    => 4,
] );

$this->customizer->add_setting( 'woocommerce_checkout_billing_postcode', [ 'default' => 'optional' ] );
$this->customizer->add_control( 'woocommerce_checkout_billing_postcode', [
    'label'       =>  __( 'Postcode field', 'ahura' ),
    'section'     => $this->current_section,
    'settings'    => 'woocommerce_checkout_billing_postcode',
    'type'        => 'select',
    'choices'     => [
        'hidden'  => __( 'Hidden', 'ahura' ),
        'optional'=> __( 'Optional', 'ahura' ),
        'required'=> __( 'Required', 'ahura' ),
    ],
    'priority'    => 5,
] );

$this->customizer->add_setting( 'woocommerce_checkout_billing_email', [ 'default' => 'required' ] );
$this->customizer->add_control( 'woocommerce_checkout_billing_email', [
    'label'       =>  __( 'Email field', 'ahura' ),
    'section'     => $this->current_section,
    'settings'    => 'woocommerce_checkout_billing_email',
    'type'        => 'select',
    'choices'     => [
        'hidden'  => __( 'Hidden', 'ahura' ),
        'optional'=> __( 'Optional', 'ahura' ),
        'required'=> __( 'Required', 'ahura' ),
    ],
    'priority'    => 6,
] );

$this->customizer->add_setting( 'woocommerce_checkout_order_comments', [ 'default' => 'optional' ] );
$this->customizer->add_control( 'woocommerce_checkout_order_comments', [
    'label'       =>  __( 'Order comments field', 'ahura' ),
    'section'     => $this->current_section,
    'settings'    => 'woocommerce_checkout_order_comments',
    'type'        => 'select',
    'choices'     => [
        'hidden'  => __( 'Hidden', 'ahura' ),
        'optional'=> __( 'Optional', 'ahura' ),
        'required'=> __( 'Required', 'ahura' ),
    ],
    'priority'    => 7,
] );

$this->customizer->add_setting( 'ahura_checkout_columns', [ 'default'  => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_checkout_columns', [
    'label'           => __( 'Two-Columns checkout page in desktop', 'ahura' ),
    'section'         => $this->current_section,
    'settings'        => 'ahura_checkout_columns',
    'priority'        => 8,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_woocommerce_checkout_order_comments' ],
] ) );

$this->customizer->add_setting( 'ahura_checkout_fields_label', [ 'default'  => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_checkout_columns', [
    'label'           => __( 'Change Woocommerce checkout fields label', 'ahura' ),
    'section'         => $this->current_section,
    'settings'        => 'ahura_checkout_fields_label',
] ) );

$this->customizer->add_setting('ahura_checkout_name_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_name_label', [
    'label'           => __('Name label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_lastname_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_lastname_label', [
    'label'           => __('Last name label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_company_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_company_label', [
    'label'           => __('Company label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_country_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_country_label', [
    'label'           => __('Country label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_address_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_address_label', [
    'label'           => __('Address label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_city_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_city_label', [
    'label'           => __('City label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_state_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_state_label', [
    'label'           => __('State label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_postcode_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_postcode_label', [
    'label'           => __('Postcode label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_phone_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_phone_label', [
    'label'           => __('Phone label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_email_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_email_label', [
    'label'           => __('Email label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));

$this->customizer->add_setting('ahura_checkout_comments_label');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_checkout_comments_label', [
    'label'           => __('Order comments label', 'ahura'),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_checkout_fields_label' ],
]));