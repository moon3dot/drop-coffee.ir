<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$this->customizer->add_setting('ahura_logo_text_color', ['default' => '#000000']);
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_logo_text_color', array(
        'label'      => __( 'Logo Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_logo_text_color',
        'active_callback' => function(){
            return !\ahura\app\mw_options::get_mod_logo_option();
        }
    ) )
);

$this->customizer->add_setting('bgcolor');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'bgcolor', array(
        'label'      => __( 'Background Color', 'ahura' ),
        'settings'   => 'bgcolor',
        'section'    => $this->current_section,
    ) )
);

$this->customizer->add_setting('themecolor', ['default' => '#00b0ff']);
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'themecolor', array(
        'label'      => __( 'Main Color', 'ahura' ),
        'settings'   => 'themecolor',
        'section'    => $this->current_section,
    ) )
);
$this->customizer->selective_refresh->add_partial('themecolor',['selector' => '.header-mode-1 .cats-list.isnotfront']);

$this->customizer->add_setting('ahura_secondary_color',['default' => '#fff']);
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer,
        'ahura_secondary_color',
        [
            'label' => __('Secondary Color', 'ahura'),
            'section' => $this->current_section
        ]
    )
);

$this->customizer->add_setting('ahura_background_selctor_color',array('default' => '#3390ff'));
$this->customizer->add_control(
    new WP_Customize_Color_Control( $this->customizer, 'ahura_background_selctor_color',array(
        'label' => __('Background selection color','ahura'),
        'section' => $this->current_section,
        'setting' => 'ahura_background_selctor_color',
    ) )
);

$this->customizer->add_setting('ahura_background_selctor_text_color',array('default' => '#ffffff'));
$this->customizer->add_control(
    new WP_Customize_Color_Control( $this->customizer, 'ahura_background_selctor_text_color',array(
        'label' => __('Background selection text color','ahura'),
        'setting' => 'ahura_background_selctor_text_color',
        'section' => $this->current_section,
    ) )
);

$this->customizer->add_setting('ahura_cat_description_backgroundcolor',array('default' => '#3f3492'));
$this->customizer->add_control(
    new WP_Customize_Color_Control( $this->customizer, 'ahura_cat_description_backgroundcolor',array(
        'label' => __('Category descrtiption background color','ahura'),
        'setting' => 'ahura_cat_description_backgroundcolor',
        'section' => $this->current_section,
    ) )
);