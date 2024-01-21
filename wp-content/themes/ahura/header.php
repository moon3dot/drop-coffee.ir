<?php
$is_custom_header = \ahura\app\mw_options::get_mod_is_active_custom_header();
$data_theme = ahura_get_current_theme_mode();
$html_class = $data_theme;
?>
<!DOCTYPE html>
<html data-theme="<?php echo $data_theme ?>" <?php language_attributes(); ?> class="<?php echo $html_class ?> no-js">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php
        \ahura\app\mw_options::theme_viewport_meta_html();
        wp_head();
        ?>
    </head>
<body <?php body_class() ?>>
<?php wp_body_open(); ?>
<?php if ($is_custom_header && class_exists('\ahura\app\elementor\Ahura_Elementor_Builder')) : ?>
<div id="ahura-header-main-wrap">
    <header id="topbar" class="<?php echo \ahura\app\mw_options::get_page_is_float_mode_header(get_the_ID()) ? 'float-mode' : ''; ?> <?php echo \ahura\app\mw_options::check_is_transparent_header_in_single_page() ? 'ahura_transparent' : '';?> in_custom_header topbar header-mode-1 header-mode-2 header-mode-3 clearfix">
        <?php echo ahura_render_elementor_builder_content(\ahura\app\mw_options::get_custom_header_id()) ?>
    </header>
</div>
<?php
else:
    (new \ahura\app\Header())->render_template();
endif;
