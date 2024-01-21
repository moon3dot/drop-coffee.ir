<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_select_box;

$this->customizer->add_setting('theme_dark');
$this->customizer->add_control(
    new ios_checkbox(
        $this->customizer, 'theme_dark', array(
        'label'      => __( 'Dark Mode', 'ahura' ),
        'section'    => $this->current_section,
    ) )
);

$this->customizer->add_setting('ahura_theme_dark_logo');
$this->customizer->add_control(new WP_Customize_Image_Control($this->customizer, 'ahura_theme_dark_logo',array(
    'label' => __('Dark Mode Logo', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_theme_dark_logo',
    'description' => __('Recommended size: 304 X 98px', 'ahura'),
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_not_active_custom_header() && \ahura\app\mw_options::get_mod_is_active_dark_theme();
    },
)));

$this->customizer->get_setting('ahura_theme_dark_logo')->transport = 'postMessage';
$this->customizer->selective_refresh->add_partial('ahura_theme_dark_logo', array(
    'selector' => '.logo',
    'render_callback' => '__return_false',
));

$this->customizer->add_setting('ahura_show_theme_mode_switcher');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_theme_mode_switcher', array(
    'label'      => __('Show theme mode switcher', 'ahura'),
    'section'    => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_active_dark_theme']
)));

$this->customizer->add_setting('ahura_default_theme_mode', ['default' => 'dark']);
$this->customizer->add_control('ahura_default_theme_mode', [
    'section' => $this->current_section,
    'type' => 'select',
    'label' => "Default Theme Mode",
    'choices' => [
        'dark' => __('Dark', 'ahura'),
        'light' => __('Light', 'ahura'),
        'black' => __('Black', 'ahura'),
    ],
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_active_dark_theme() && \ahura\app\mw_options::get_mod_show_theme_mode_switcher();
    }
]);

$this->customizer->add_setting('ahura_show_theme_mode_switcher_titles', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_theme_mode_switcher_titles', array(
    'label'      => __('Show theme mode switcher titles', 'ahura'),
    'section'    => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_active_dark_theme() && \ahura\app\mw_options::get_mod_show_theme_mode_switcher();
    }
)));

$this->customizer->add_setting('ahura_dark_mode_has_scheduler', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_dark_mode_has_scheduler', array(
    'label'      => __('Dark mode has scheduler', 'ahura'),
    'section'    => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_active_dark_theme() && \ahura\app\mw_options::get_mod_show_theme_mode_switcher();
    }
)));

$sch_times = [];

for($i = 1; $i <= 24; $i++) {
    $t = $i <= 9 ? "0{$i}" : (($i == 24) ? '00' : $i);
    $sch_times[$t] = "{$t}:00";
}

$this->customizer->add_setting('ahura_dark_mode_schedule_start_time');
$this->customizer->add_control(new simple_select_box($this->customizer, 'ahura_dark_mode_schedule_start_time', [
    'section' => $this->current_section,
    'label' => __('Dark mode schedule start time', 'ahura'),
    'choices' => $sch_times,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_active_dark_theme() && \ahura\app\mw_options::get_mod_dark_mode_has_scheduler();
    }
]));

$this->customizer->add_setting('ahura_dark_mode_schedule_end_time');
$this->customizer->add_control(new simple_select_box($this->customizer, 'ahura_dark_mode_schedule_end_time', [
    'section' => $this->current_section,
    'label' => __('Dark mode schedule end time', 'ahura'),
    'choices' => $sch_times,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_active_dark_theme() && \ahura\app\mw_options::get_mod_dark_mode_has_scheduler();
    }
]));