<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\image_radio_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_range;
use ahura\app\customization\simple_text;
use ahura\app\mw_options;

$this->customizer->add_setting('ahura_action_btn_alignment', ['default' => 'left']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_action_btn_alignment', [
    'label' => __("Action buttons alignment", 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'radio',
    'choices' => [
        'right' => [
            'label' => __('Right', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/action_box_alignment_right.png',
        ],
        'left' => [
            'label' => __("Left", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/action_box_alignment_left.png',
        ],
    ],
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(1);
    }
]));


$this->customizer->add_setting('show_ahura_header_cta_btn',['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_ahura_header_cta_btn', [
    'label' => __("Show Button", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));
$this->customizer->add_setting('ahura_header_cta_btn_text', ['default' => __("Let's Start", 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_header_cta_btn_text', [
    'label' => __("Button Text", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_ahura_header_cta_btn'],
]));
$this->customizer->selective_refresh->add_partial('ahura_header_cta_btn_text',[
    'selector' => '.topbar .panel_menu_wrapper .cta_button, .topbar .action-box #action_link'
]);
$this->customizer->add_setting('ahura_header_cta_btn_url', [
    'default' => '#'
]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_header_cta_btn_url', [
    'label' => __("Button Url", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_ahura_header_cta_btn'],
]));
$this->customizer->add_setting('show_ahura_header_after_login_cta_btn',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_ahura_header_after_login_cta_btn', [
    'label' => __("Show After Login Button", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::show_header_cta_btn();
    }
]));
$this->customizer->add_setting('ahura_header_after_login_cta_btn_text', ['default' => __('User Account', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_header_after_login_cta_btn_text', [
    'label' => __("After Login Button Text", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_header_after_login_cta_btn'],
]));
$this->customizer->add_setting('ahura_header_after_login_cta_btn_url', ['default' => '#']);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_header_after_login_cta_btn_url', [
    'label' => __('After Login Button Url', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_header_after_login_cta_btn'],
]));
$this->customizer->add_setting('ahura_cta_widget_radius', ['default' => 50]);
$this->customizer->add_control(
    new simple_range( $this->customizer, 'ahura_cta_widget_radius',array(
        'label' => __('Header button border radius','ahura'),
        'section' => $this->current_section,
        'input_attrs' => array(
            'min' => 0,
            'max' => 100,
        ),
        'active_callback' => function(){
            return $this->active_conditions(['get_mod_is_not_active_custom_header', 'show_header_cta_btn']);
        }
    ) )
);
$this->customizer->add_setting('ahura_header_cta_btn_text_color',['default'=>'#354ac4']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_header_cta_btn_text_color', [
    'label' => __('Button Text Color', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_ahura_header_cta_btn'],
]));
$this->customizer->add_setting('ahura_header_cta_btn_bg',['default'=>'#e5e8ff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_header_cta_btn_bg', [
    'label' => __("Button Background", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_ahura_header_cta_btn'],
]));
$this->customizer->add_setting('ahura_header_after_login_cta_btn_text_color',['default'=>'#35c454']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_header_after_login_cta_btn_text_color', [
    'label' => __("After Login Button Text Color", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_header_after_login_cta_btn'],
]));
$this->customizer->add_setting('ahura_header_after_login_cta_btn_bg',['default'=>'#e8ffe5']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_header_after_login_cta_btn_bg', [
    'label' => __("After Login Button Background", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_header_after_login_cta_btn'],
]));

$this->customizer->add_setting('ahorua_show_mini_cart');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahorua_show_mini_cart', [
    'label' => __("Show Mini Cart", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));
$this->customizer->add_setting('ahura_mini_cart_hide_content');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_mini_cart_hide_content', [
    'label' => __("Mini cart hide content", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_mini_cart']
]));
// minicart icon color
$this->customizer->add_setting('ahura_mini_cart_icon_color', ['default' => '#35495C']);
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_mini_cart_icon_color', array(
        'label'      => __( 'Mini Cart icon color', 'ahura' ),
        'section'    => $this->current_section,
        'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_mini_cart']
    ) )
);

$this->customizer->add_setting('ahura_mini_cart_icon_bgcolor');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_mini_cart_icon_bgcolor', array(
        'label'      => __( 'Mini Cart icon background color', 'ahura' ),
        'section'    => $this->current_section,
        'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_mini_cart']
    ) )
);

$this->customizer->add_setting('ahura_show_mini_cart_count');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_mini_cart_count', [
    'label' => __("Show Mini Cart Count", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_mini_cart']
]));
$this->customizer->add_setting('ahura_mini_cart_count_background_color', ['default' => '#00b0ff']);
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_mini_cart_count_background_color', array(
        'label'      => __( 'Mini Cart Count Background Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_mini_cart_count_background_color',
        'active_callback'   =>  ['ahura\app\mw_options','get_mod_is_active_mini_cart_count']
    ) )
);
$this->customizer->add_setting('ahura_mini_cart_count_color', ['default' => '#ffffff']);
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_mini_cart_count_color', array(
        'label'      => __( 'Mini Cart Count Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_mini_cart_count_color',
        'active_callback'   =>  ['ahura\app\mw_options','get_mod_is_active_mini_cart_count']
    ) )
);
$this->customizer->add_setting('ahura_mini_cart_checkout_btn_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_mini_cart_checkout_btn_color', array(
        'label'      => __( 'Mini Cart Checkout Button Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_mini_cart_checkout_btn_color',
        'active_callback'   =>  ['ahura\app\mw_options','get_mod_is_active_mini_cart']
    ) )
);
$this->customizer->add_setting('ahura_mini_cart_checkout_btn_text_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_mini_cart_checkout_btn_text_color', array(
        'label'      => __( 'Mini Cart Checkout Button Text Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_mini_cart_checkout_btn_text_color',
        'active_callback'   =>  ['ahura\app\mw_options','get_mod_is_active_mini_cart']
    ) )
);
$this->customizer->add_setting('ahura_mini_cart_basket_btn_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_mini_cart_basket_btn_color', array(
        'label'      => __( 'Mini Cart Basket Button Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_mini_cart_basket_btn_color',
        'active_callback'   =>  ['ahura\app\mw_options','get_mod_is_active_mini_cart']
    ) )
);

$this->customizer->add_setting('ahura_mini_cart_basket_btn_text_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_mini_cart_basket_btn_text_color', array(
        'label'      => __( 'Mini Cart Basket Button Text Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_mini_cart_basket_btn_text_color',
        'active_callback'   =>  ['ahura\app\mw_options','get_mod_is_active_mini_cart']
    ) )
);
$this->customizer->add_setting('ahorua_header_popup_login', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahorua_header_popup_login', [
    'label' => __("Show Header Popup Login", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header'],
]));
$this->customizer->add_setting('ahura_usage_other_login_forms', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_usage_other_login_forms', [
    'label' => __("Usage other login form", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_show_header_popup_login'],
]));
$this->customizer->add_setting('ahura_other_login_form_shortcode');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_other_login_form_shortcode', [
    'label' => __("Other login form shortcode", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_usage_other_login_forms'],
]));
$this->customizer->add_setting('ahura_show_custom_login_form', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_custom_login_form', [
    'label' => __("Show Custom Login Form", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_show_header_popup_login() && !\ahura\app\mw_options::get_mod_usage_other_login_forms();
    },
]));
$this->customizer->add_setting('ahura_auto_login_after_register', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_auto_login_after_register', [
    'label' => __("Auto Login After Register", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_show_custom_login_form() && !\ahura\app\mw_options::get_mod_usage_other_login_forms();
    },
]));
$this->customizer->add_setting('ahura_show_captcha_in_login_form', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_captcha_in_login_form', [
    'label' => __("Show Security Code", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_show_custom_login_form() && !\ahura\app\mw_options::get_mod_usage_other_login_forms();
    },
]));
$this->customizer->add_setting('ahura_popup_login_color');
$this->customizer->add_control('ahura_popup_login_color', [
    'section' => $this->current_section,
    'type' => 'color',
    'label' => __('Popup Login Color', 'ahura'),
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_show_header_popup_login'],
]);

$this->customizer->add_setting('ahura_popup_login_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_popup_login_font_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Popup Login Font Size', 'ahura'),
    'active_callback' => function(){
        return mw_options::get_mod_is_show_header_popup_login() && !mw_options::is_active_header_style(2);
    }
]));

$this->customizer->add_setting('ahorua_header_popup_login_link');
$this->customizer->add_control(new simple_text($this->customizer, 'ahorua_header_popup_login_link', [
    'label' => __("Header Popup Login URL", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_show_header_popup_login'],
]));
$this->customizer->add_setting('ahura_header_show_popup_login_register_text');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_header_show_popup_login_register_text', [
    'label' => __("Show Header Popup Login Register Text", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_show_header_popup_login() && !\ahura\app\mw_options::get_mod_show_custom_login_form();
    },
]));
$this->customizer->add_setting('ahura_header_popup_login_register_text', ['default' => __('Register', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_header_popup_login_register_text', [
    'label' => __("Popup Login Restister Text", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_show_header_popup_register_button'],
]));
$this->customizer->add_setting('ahura_header_popup_login_register_link', ['default' => wp_registration_url()]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_header_popup_login_register_link', [
    'label' => __("Popup Login Restister Link", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_show_header_popup_register_button'],
]));
$this->customizer->add_setting('ahura_header_popup_login_register_text_dir', ['default' => 'right']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_header_popup_login_register_text_dir', [
    'label' => __("Popup Login Restister Text Direction", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_show_header_popup_login() && !\ahura\app\mw_options::get_mod_show_custom_login_form();
    },
    'type'  =>  'radio',
    'choices' => [
        'right' =>
            [
                'label' => __('Right', 'ahura'),
                'image_url' => get_template_directory_uri() . '/img/customization/header/register_link_alignment_right.png',
            ],
        'left' =>
            [
                'label' => __("Left", 'ahura'),
                'image_url' => get_template_directory_uri() . '/img/customization/header/register_link_alignment_left.png',
            ],
    ],
]));
$this->customizer->add_setting('ahura_header_popup_login_link_to_url');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_header_popup_login_link_to_url', [
    'label' => __("Link to a URL (No Popup)", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_show_header_popup_login'],
]));
$this->customizer->add_setting('ahura_header_popup_login_show_log_out');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_header_popup_login_show_log_out', [
    'label' => __("Show Log Out When User Login", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header'],
]));


$this->customizer->add_setting( 'ahura_show_user_loggedin_name', [ 'default'  => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_show_user_loggedin_name', [
    'label'           => __( 'Show logged in user\'s display name', 'ahura' ),
    'section'         => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options', 'get_mod_is_not_active_custom_header' ],
] ) );
$this->customizer->add_setting( 'ahura_user_loggedin_text' );
$this->customizer->add_control( new simple_text( $this->customizer, 'ahura_user_loggedin_text', [
    'label' => __( 'User loggedin message', 'ahura' ),
    'description' => __( 'use "d_name" as display name placeholder. example: Welcome! d_name', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_active_user_loggedin_name() && mw_options::is_active_header_style(1);
    },
]));

$this->customizer->add_setting( 'ahura_user_loggedin_name_color');
$this->customizer->add_control( new WP_Customize_Color_Control( $this->customizer, 'ahura_user_loggedin_name_color', [
    'label'   => __( 'User display name color','ahura' ),
    'section' => $this->current_section,
    'setting' => 'ahura_user_loggedin_name_color',
    'active_callback' => [ '\ahura\app\mw_options', 'get_mod_is_active_user_loggedin_name' ],
] ) );

$this->customizer->add_setting( 'ahura_user_loggedin_name_backcolor', ['default' => '#555'] );
$this->customizer->add_control( new WP_Customize_Color_Control( $this->customizer, 'ahura_user_loggedin_name_backcolor', [
    'label'   => __( 'User display name background color','ahura' ),
    'section' => $this->current_section,
    'setting' => 'ahura_user_loggedin_name_backcolor',
    'active_callback' => function(){
        return mw_options::get_mod_is_active_user_loggedin_name() && mw_options::is_active_header_style(1);
    },
] ) );