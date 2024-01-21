<div class="footer-center">
    <div class="row my-3">
        <?php if ($about_us_title || $about_us_text): ?>
        <div class="col-12 col-sm-<?php echo $has_enamad ? 9 : 12 ?>">
            <div class="foot-about-widget">
                <?php if ($about_us_title): ?>
                    <h3 class="footer-widget-title foot-widget-title"><?php echo $about_us_title ?></h3>
                <?php endif; ?>
                <?php if ($about_us_text): ?>
                    <div class="foot-widget-content"><?php echo $about_us_text ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if($has_enamad): ?>
        <div class="col-12 col-sm-3">
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
        </div>
        <?php endif;?>
    </div>
    <div class="row footer-widgets-list">
        <?php if ( is_active_sidebar( 'ahura_footer_widget' ) ) : ?>
            <?php dynamic_sidebar( 'ahura_footer_widget' ); ?>
        <?php endif; ?>
    </div>
    <?php
    $information_icons = [];
    for ($i=1;$i<=6;$i++){
        $icon_method = 'get_footer_icon' . $i;
        $icon_title_method = 'get_footer_icon'. $i .'_title';

        if (!method_exists('\ahura\app\mw_options', $icon_method) || !method_exists('\ahura\app\mw_options', $icon_title_method))
            continue;

        $icon_src = \ahura\app\mw_options::{$icon_method}();
        $icon_title = \ahura\app\mw_options::{$icon_title_method}();

        if (empty($icon_src)) continue;

        $information_icons[] = ['icon' => $icon_src, 'title' => $icon_title];
    }
    ?>
    <?php if (\ahura\app\mw_options::get_show_information_box()): ?>
    <div class="foot-contact-box">
        <div class="row align-items-center">
            <div class="col-12 col-sm-6 col-lg-3">
                <?php if ($phone_number): ?>
                <div class="c-item">
                    <span><?php echo __('Phone', 'ahura') ?></span>
                    <span>
                        <?php echo $phone_number ?>
                        <i class="fas fa-phone"></i>
                    </span>
                </div>
                <?php endif;?>
                <?php if ($email): ?>
                <div class="c-item">
                    <span><?php echo __('Email', 'ahura') ?></span>
                    <span>
                        <?php echo $email ?>
                        <i class="fas fa-at"></i>
                    </span>
                </div>
                <?php endif;?>
                <?php if ($address): ?>
                <div class="c-item">
                    <span><?php echo __('Address', 'ahura') ?></span>
                    <span>
                        <?php echo $address ?>
                        <i class="fas fa-map-pin"></i>
                    </span>
                </div>
                <?php endif;?>
            </div>
            <?php if (!empty($information_icons)): ?>
            <div class="col-12 col-sm-6 col-lg-9">
                <div class="trust-icons">
                    <?php foreach ($information_icons as $data): ?>
                    <div class="trust-icon">
                        <img src="<?php echo $data['icon'] ?>" width="70" height="70" alt="trust icon">
                        <?php if ($data['title']): ?>
                            <div><?php echo $data['title'] ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($copyright_text || $copyright2_text): ?>
    <div class="footer-bottom">
        <div class="row align-items-center">
            <div class="col-12 col-sm-6 text-right">
                <?php echo $copyright_text; ?>
            </div>
            <div class="col-12 col-sm-6 text-left">
                <?php echo $copyright2_text; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
