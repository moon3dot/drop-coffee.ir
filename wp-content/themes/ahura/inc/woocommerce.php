<?php

// Woocommerce checkout extra settings
function ahura_override_checkout_fields( $fields ) {

    get_theme_mod( 'ahura_checkout_name_label' ) ? $fields[ 'billing' ][ 'billing_first_name'][ 'label' ] = get_theme_mod( 'ahura_checkout_name_label' ) : '';
    get_theme_mod( 'ahura_checkout_lastname_label' ) ? $fields[ 'billing' ][ 'billing_last_name'][ 'label' ] = get_theme_mod( 'ahura_checkout_lastname_label' ) : '';
    get_theme_mod( 'ahura_checkout_company_label' ) ? $fields[ 'billing' ][ 'billing_company'][ 'label' ] = get_theme_mod( 'ahura_checkout_company_label' ) : '';
    get_theme_mod( 'ahura_checkout_country_label' ) ? $fields[ 'billing' ][ 'billing_country'][ 'label' ] = get_theme_mod( 'ahura_checkout_country_label' ) : '';
    get_theme_mod( 'ahura_checkout_phone_label' ) ? $fields[ 'billing' ][ 'billing_phone'][ 'label' ] = get_theme_mod( 'ahura_checkout_phone_label' ) : '';
    get_theme_mod( 'ahura_checkout_email_label' ) ? $fields[ 'billing' ][ 'billing_email'][ 'label' ] = get_theme_mod( 'ahura_checkout_email_label' ) : '';
    get_theme_mod( 'ahura_checkout_comments_label' ) ? $fields['order']['order_comments']['label'] = get_theme_mod( 'ahura_checkout_comments_label' ) : '';

    switch ( get_theme_mod( 'woocommerce_checkout_billing_email' ) ) {
        case "hidden":
            unset( $fields[ 'billing' ][ 'billing_email' ] );
            break;
        case "optional":
            $fields[ 'billing' ][ 'billing_email'][ 'required' ] = false;
            break;
        case "required":
            $fields[ 'billing' ][ 'billing_email'][ 'required' ] = true;
            break;
    }

    switch ( get_theme_mod( 'woocommerce_checkout_order_comments' ) ) {
        case "hidden":
            unset( $fields[ 'order' ][ 'order_comments' ] );
            break;
        case "optional":
            $fields[ 'order' ][ 'order_comments' ][ 'required' ] = false;
            break;
        case "required":
            $fields[ 'order' ][ 'order_comments' ][ 'required' ] = true;
            break;
    }

	return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'ahura_override_checkout_fields' );


function ahura_override_address_checkout_fields( $fields ) {
    
    get_theme_mod( 'ahura_checkout_address_label' ) ? $fields[ 'address_1' ][ 'label' ] = get_theme_mod( 'ahura_checkout_address_label' ) : '';
    get_theme_mod( 'ahura_checkout_city_label' ) ? $fields[ 'city' ][ 'label' ] = get_theme_mod( 'ahura_checkout_city_label' ) : '';
    get_theme_mod( 'ahura_checkout_state_label' ) ? $fields[ 'state' ][ 'label' ] = get_theme_mod( 'ahura_checkout_state_label' ) : '';
    get_theme_mod( 'ahura_checkout_postcode_label' ) ? $fields[ 'postcode' ][ 'label' ] = get_theme_mod( 'ahura_checkout_postcode_label' ) : '';

    switch ( get_theme_mod( 'woocommerce_checkout_country_field' ) ) {
        case "hidden":
            unset( $fields[ 'country' ] );
            break;
        case "optional":
            $fields[ 'country' ][ 'required' ] = false;
            break;
        case "required":
            $fields[ 'country' ][ 'required' ] = true;
            break;
    }
    switch ( get_theme_mod( 'woocommerce_checkout_billing_address_1' ) ) {
        case "hidden":
            unset( $fields[ 'address_1' ] );
            unset( $fields[ 'address_2' ] );
            break;
        case "optional":
            $fields[ 'address_1' ][ 'required' ] = false;
            $fields[ 'address_2' ][ 'required' ] = false;
            break;
        case "required":
            $fields[ 'address_1' ][ 'required' ] = true;
            $fields[ 'address_2' ][ 'required' ] = true;
            break;
    }
    switch ( get_theme_mod( 'woocommerce_checkout_billing_city' ) ) {
        case "hidden":
            unset( $fields[ 'city' ] );
            break;
        case "optional":
            $fields[ 'city' ][ 'required' ] = false;
            break;
        case "required":
            $fields[ 'city' ][ 'required' ] = true;
            break;
    }
    switch ( get_theme_mod( 'woocommerce_checkout_billing_state' ) ) {
        case "hidden":
            unset( $fields[ 'state' ] );
            break;
        case "optional":
            $fields[ 'state' ][ 'required' ] = false;
            break;
        case "required":
            $fields[ 'state' ][ 'required' ] = true;
            break;
    }
    switch (get_theme_mod('woocommerce_checkout_billing_postcode')) {
        case "hidden":
            unset( $fields[ 'postcode' ] );
            break;
        case "optional":
            $fields[ 'postcode' ][ 'required' ] = false;
            break;
        case "required":
            $fields[ 'postcode' ][ 'required' ] = true;
            break;
    }

    return $fields;
}
add_filter( 'woocommerce_default_address_fields', 'ahura_override_address_checkout_fields', 1000, 1 );


function ahura_change_state_postcode_labels($locale){
    get_theme_mod( 'ahura_checkout_state_label' ) ? $locale[ 'US' ][ 'state' ][ 'label' ] = get_theme_mod( 'ahura_checkout_state_label' ) : '';
    get_theme_mod( 'ahura_checkout_state_label' ) ? $locale[ 'IR' ][ 'state' ][ 'label' ] = get_theme_mod( 'ahura_checkout_state_label' ) : '';
    get_theme_mod( 'ahura_checkout_postcode_label' ) ? $locale[ 'US' ][ 'postcode' ][ 'label' ] = get_theme_mod( 'ahura_checkout_postcode_label' ) : '';
    get_theme_mod( 'ahura_checkout_postcode_label' ) ? $locale[ 'IR' ][ 'postcode' ][ 'label' ] = get_theme_mod( 'ahura_checkout_postcode_label' ) : '';
    return $locale;
}
add_filter('woocommerce_get_country_locale', 'ahura_change_state_postcode_labels');
