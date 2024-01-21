<?php
$is_custom_footer = \ahura\app\mw_options::get_mod_is_active_custom_footer();
?>
<footer class="website-footer footer-template-<?php echo $is_custom_footer ? 'custom' : \ahura\app\mw_options::get_footer_style() ?>">
    <?php
    if ($is_custom_footer && class_exists('\ahura\app\elementor\Ahura_Elementor_Builder')):
        echo ahura_render_elementor_builder_content(\ahura\app\mw_options::get_custom_footer_id());
    else: ?>
        <?php if (get_theme_mod('ahura_legend')) : ?>
            <section class="footer-legend">
                <div class="footer-legend-inner">
                    <h5><?php echo get_theme_mod( 'ahura_legend_text' );?></h5>
                    <a href="<?php echo get_theme_mod( 'ahura_legend_ctalink' );?>" target="_blank"><?php echo get_theme_mod( 'ahura_legend_ctatext' );?></a>
                    <div class="clear"></div>
                </div>
            </section>
        <?php endif; ?>
        <?php (new \ahura\app\Footer())->render_template(); ?>
    <?php endif; ?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
