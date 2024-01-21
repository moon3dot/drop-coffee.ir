<?php get_header(); ?>
<div class="site-container">
    <div class="edd">
        <div class="edd-products">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="edd-product">
                        <a href="<?php echo get_permalink() ?>">
                            <div class="edd-product-thumbnail">
                                <?php the_post_thumbnail('woocommerce_thumbnail') ?>
                            </div>
                            <h3><?php the_title() ?></h3>
                            <div class="edd-product-meta">
                                <div class="edd-product-cats">
                                    <?php
                                    echo get_the_term_list(get_the_ID(), 'download_category','<span></span>',' - ');
                                    ?>
                                </div>
                            </div>
                        </a>
                        <div class="edd-add-to-cart">
                            <?php echo edd_get_purchase_link(array('download_id' => get_the_ID())); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>