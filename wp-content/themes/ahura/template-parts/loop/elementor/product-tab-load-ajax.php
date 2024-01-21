<div class="col-12 col-sm-12 col-md-4 col-lg-3">
    <div <?php wc_product_class('product-item', $product) ?>>
        <div class="pt-overly">
            <div class="o-content">
                <a href="<?php echo get_the_permalink() ?>">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['basket_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <div class="pt-o-title"><?php echo esc_html__('View Product', 'ahura'); ?></div>
                </a>
            </div>
        </div>
        <div class="product-details">
            <div class="pt-top">
                <div class="row p-0 m-0">
                    <div class="col-10 p-0">
                        <a href="<?php echo get_the_permalink() ?>">
                            <h2 class="product-title"><?php the_title(); ?></h2>
                        </a>
                    </div>
                    <div class="col-2 p-0">
                        <div class="float-buttons">
                            <div class="share-btns">
                                <div class="share-btn">
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['ُshare_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </div>
                                <div class="btns">
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink() ?>&source=<?php echo site_url() ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink() ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/intent/tweet?text=<?php echo get_the_permalink() ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 p-0">
                        <div class="price-wrap <?php echo $item['item_dis_price_show'] != 'yes' ? 'del-dis-price' : '' ?>">
                            <?php woocommerce_template_single_price(); ?>
                        </div>
                    </div>
                    <div class="col-2 p-0">
                        <div class="float-buttons">
                            <?php if (in_array('yith-woocommerce-wishlist/init.php', apply_filters('active_plugins', get_option('active_plugins')))): ?>
                                <div class="fav-btns"><?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-bottom">
                <div class="product-cover">
                    <a href="<?php echo get_the_permalink() ?>">
                        <?php echo wp_get_attachment_image(get_post_thumbnail_id(), $settings['item_cover_size']) ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>