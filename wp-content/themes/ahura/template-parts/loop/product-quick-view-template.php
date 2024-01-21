<div id="ah-quick-product-content">
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('ah-quick-product', $product) ?>>
        <div class="ah-quick-product-head">
            <h2><?php _e('Preview', 'ahura') ?></h2>
            <span class="ah-close-quick-product"><i class="fas fa-times"></i></span>
        </div>
        <dov class="ah-quick-product-content-box">
            <div class="ah-product-gallery">
                <div class="ah-thumbnail-image">
                    <div class="swiper ah-quick-product-carousel">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <?php
                                $thumb_img = wp_get_attachment_image($post_thumbnail_id, 'full');
                                if (intval($post_thumbnail_id) && !empty($thumb_img)): ?>
                                    <?php echo $thumb_img; ?>
                                <?php else: ?>
                                    <?php echo wc_placeholder_img(); ?>
                                <?php endif; ?>
                            </div>
                            <?php if ($attachment_ids): ?>
                                <?php foreach ($attachment_ids as $id): ?>
                                    <div class="swiper-slide">
                                        <?php echo wp_get_attachment_image($id) ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($attachment_ids): ?>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    <?php endif; ?>
                </div>
                <?php if ($attachment_ids): ?>
                    <div class="ah-gallery-images">
                        <div thumbsSlider class="swiper ah-quick-product-thumb-carousel">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <?php
                                    $thumb_img = wp_get_attachment_image($post_thumbnail_id);
                                    if (intval($post_thumbnail_id) && !empty($thumb_img)): ?>
                                        <?php echo $thumb_img; ?>
                                    <?php else: ?>
                                        <?php echo wc_placeholder_img(); ?>
                                    <?php endif; ?>
                                </div>
                                <?php foreach ($attachment_ids as $id): ?>
                                    <div class="swiper-slide">
                                        <?php echo wp_get_attachment_image($id) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="ah-product-content">
                <div class="summary entry-summary">
                    <?php do_action('ahura_product_quick_view_summary'); ?>
                </div>
            </div>
        </dov>
    </div>
</div>