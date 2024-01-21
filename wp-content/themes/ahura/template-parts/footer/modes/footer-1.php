<div class="footer-center<?php echo get_theme_mod('remove_footer_border_top') != true ? ' footer-center-border-top' : '' ?><?php echo $copyright_reverse ? ' copyright-reverse-direction' : '' ?>">
    <div class="row">
        <?php if ( is_active_sidebar( 'ahura_footer_widget' ) ) : ?>
            <?php dynamic_sidebar( 'ahura_footer_widget' ); ?>
        <?php endif; ?>
        <div class="clear"></div>
        <div class="<?php echo !$has_enamad && empty($copyright2_text) ? 'footer-end-100' : 'footer-end' ?>">
            <?php if ( $copyright_text ) : ?>
                <p class="<?php echo (empty($copyright2_text)) ? 'footer-copyright-fullwidth': 'footer-copyright'; ?>">
                    <?php echo $copyright_text; ?>
                </p>
            <?php endif;?>
        </div>
        <?php if ( $copyright2_text || $has_enamad ) : ?>
            <div class="footer-copyright2-section">
                <?php if($has_enamad): ?>
                    <div class="footer-namad <?php echo $use_enamad_html ? ' footer-namad-html' : '' ?>">
                        <?php if($use_enamad_html): ?>
                            <?php echo $enamad_html_code ?>
                        <?php else:?>
                            <?php if($show_symbol_1):?>
                                <a href="<?php echo $symbol1_url; ?>" target="_blank">
                                    <img width="70" height="70" src="<?php echo $symbol1_img; ?>" alt="<?php echo __('Enamad', 'ahura') ?>">
                                </a>
                            <?php endif;?>
                            <?php if($show_symbol_2):?>
                                <a href="<?php echo $symbol2_url; ?>" target="_blank">
                                    <img width="70" height="70" src="<?php echo $symbol2_img; ?>" alt="<?php echo __('Samandehi', 'ahura') ?>">
                                </a>
                            <?php endif;?>
                        <?php endif;?>
                    </div>
                <?php endif;?>
                <p class="footer-copyright2">
                    <?php echo $copyright2_text; ?>
                </p>
            </div>
        <?php endif;?>
        <div class="clear"></div>
    </div>
</div>