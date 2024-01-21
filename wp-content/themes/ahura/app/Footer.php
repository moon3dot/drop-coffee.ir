<?php
namespace ahura\app;

use ahura\app\contracts\TemplateModes;

class Footer extends TemplateModes {
    public function __construct()
    {
        $this->templateName = 'footer';
        $this->templateMode = mw_options::get_footer_style();
    }

    public function render_template()
    {
        $has_enamad = get_theme_mod('footer_namad_check');
        $use_enamad_html = mw_options::get_mod_enamad_use_html_code();
        $copyright_reverse = get_theme_mod('change_footer_namad_and_copyright_direction', false);
        $enamad = mw_assets::get_img('enamad');
        $samandehi = mw_assets::get_img('samandehi');
        $enamad_html_code = get_theme_mod('footer_enamad_html_code');
        $show_symbol_1 = get_theme_mod('show_symbol1',true);
        $show_symbol_2 = get_theme_mod('show_symbol2',true);
        $symbol1_url = get_theme_mod('footer_namad1_url');
        $symbol2_url = get_theme_mod('footer_namad2_url');
        $is_set_enamad = $has_enamad && ($show_symbol_1 || $show_symbol_2) && $symbol1_url || $symbol2_url;
        $symbol1_img = (get_theme_mod('footer_namad1') == true ? get_theme_mod('footer_namad1') : $enamad);
        $symbol2_img = (get_theme_mod('footer_namad2') == true ? get_theme_mod('footer_namad2') : $samandehi);

        $copyright_text = get_theme_mod( 'footer-copyright' );
        $copyright2_text = get_theme_mod( 'footer-copyright2' );

        $phone_number = mw_options::get_footer_contact_phone_number();
        $email = mw_options::get_footer_contact_email();
        $address = mw_options::get_footer_contact_address();

        $about_us_title = mw_options::get_footer_about_us_title();
        $about_us_text = mw_options::get_footer_about_us_text();

        $this->data = get_defined_vars();

        parent::render_template();
    }
}