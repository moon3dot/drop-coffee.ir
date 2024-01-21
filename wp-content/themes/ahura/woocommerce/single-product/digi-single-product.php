<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

 $all_sharing_btns = strpos(\ahura\app\mw_options::get_mod_product_page_digikala_sharings(), 'all') ? true : false;

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('d-flex flex-column product-page-digi-style', $product); ?>>
    <div class="d-flex flex-wrap product-page-digi-main">
        <div class="d-flex product-page-gallery-container">
            <ul class="product-page-share-btns">
                <?php if((strpos(\ahura\app\mw_options::get_mod_product_page_digikala_sharings(), 'telegram') !== false) || $all_sharing_btns): ?>
                    <li><a href="https://telegram.me/share/url?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i aria-hidden="true" class="fab fa-telegram-plane"></i></a></li>
                <?php endif; ?>
                <?php if((strpos(\ahura\app\mw_options::get_mod_product_page_digikala_sharings(), 'whatsapp') !== false) || $all_sharing_btns): ?>
                    <li><a href="https://api.whatsapp.com/send?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>" target="_blank"><i aria-hidden="true" class="fab fa-whatsapp"></i></a></li>
                <?php endif; ?>
                <?php if((strpos(\ahura\app\mw_options::get_mod_product_page_digikala_sharings(), 'facebook') !== false) || $all_sharing_btns): ?>
                    <li><a href="ttps://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i aria-hidden="true" class="fab fa-facebook-f"></i></a></li>
                <?php endif; ?>
                <?php if((strpos(\ahura\app\mw_options::get_mod_product_page_digikala_sharings(), 'twitter') !== false) || $all_sharing_btns): ?>
                    <li><a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i aria-hidden="true" class="fab fa-twitter"></i></a></li>
                <?php endif; ?>
                <?php if((strpos(\ahura\app\mw_options::get_mod_product_page_digikala_sharings(), 'linkedin') !== false) || $all_sharing_btns): ?>
                    <li><a href="https://linkedin.com/shareArticle?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><i aria-hidden="true" class="fab fa-linkedin-in"></i></a></li>
                <?php endif; ?>
            </ul>
            <div class="gallery-section">
                <?php do_action('woocommerce_before_single_product_summary'); ?>
            </div>
        </div>
        <div class="product-page-summary-container">
            <div class="d-flex flex-column justify-content-center align-items-start product-page-header mb-2">
                <div class="product-cat-header">
                    <?php
                    $cats_list = wc_get_product_term_ids($product->get_id(), 'product_cat');
                    $cats_delimiter = ' / ';
                    foreach ($cats_list as $index => $cat_id) {
                        if (count($cats_list) - 1 == $index) $cats_delimiter = '';
                        echo "<a href=" . get_category_link($cat_id) . " class='cat-name'>" . get_term_by('id', $cat_id, 'product_cat')->name . '</span><span class="cat-delimiter">' . $cats_delimiter . '</span></a>';
                    }
                    ?>
                </div>
                <h1 class="product-title"><?php woocommerce_template_single_title(); ?></h1>
            </div>
            <div class="d-flex product-page-attributes">
                <div class="product-page-main">
                    <div class="product-extra-meta">
                        <span class="product-sku">
                            <span class="sku-title"><?php echo __('SKU value: ', 'ahura'); ?></span>
                            <span class="sku-value">
                                <?php if ($product->get_sku()) : ?>
                                    <?php echo $product->get_sku(); ?>
                                <?php else : ?>
                                    <?php echo __('It doesn\'t exist', 'ahura') ?>
                                <?php endif; ?>
                            </span>
                        </span>
                        <?php echo do_action( 'woocommerce_product_meta_end' ); ?>
                    </div>
                    <?php $product_attributes = $product->get_attributes(); ?>
                    <div class="product-attributes-list pt-5">
                        <h4 class="attributes-title pb-2">
                            <?php echo __('Product Attributes', 'ahura'); ?>
                        </h4>
                        <?php if ($product_attributes) : ?>
                            <ul class="woocommerce-product-attributes shop_attributes">
                                <?php $attribute_count = 0;
                                $show_all_attributes = false;
                                if((\ahura\app\mw_options::get_mod_product_page_digikala_attributes() < 1) || (\ahura\app\mw_options::get_mod_product_page_digikala_attributes() > count($product_attributes))) {
                                    $selected_hidden_attributes = count($product_attributes);
                                    $show_all_attributes = true;
                                } else {
                                    $selected_hidden_attributes = \ahura\app\mw_options::get_mod_product_page_digikala_attributes();
                                }
                                foreach ($product_attributes as $product_attribute_key => $product_attribute) : ?>
                                    <?php $attribute_count++; ?>
                                    <?php if ($attribute_count <= $selected_hidden_attributes) : ?>
                                        <li class="d-flex justify-content-start align-items-center woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr($product_attribute_key); ?> pb-1">
                                            <span class="woocommerce-product-attributes-item__label pl-1">
                                                <?php echo wc_attribute_label(wp_kses_post($product_attribute['name'])) . ':'; ?>
                                            </span>
                                            <span class="woocommerce-product-attributes-item__value">
                                                <?php echo $product->get_attribute(wp_kses_post($product_attribute['name'])); ?>
                                            </span>
                                        </li>
                                    <?php else : ?>
                                        <input id="more-attributes-toggle" type="checkbox">
                                        <div id="more-attributes-expand">
                                            <section>
                                                <?php $inner_attributes_count = 0; ?>
                                                <?php foreach ($product_attributes as $product_attribute_key => $product_attribute) : ?>
                                                    <?php $inner_attributes_count++; ?>
                                                    <?php if ($product_attribute['value'] && ($inner_attributes_count > $selected_hidden_attributes)) : ?>
                                                        <ul class="woocommerce-product-attributes shop_attributes inner-attributes">
                                                            <li class="d-flex justify-content-start align-items-center woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr($product_attribute_key); ?> pb-1">
                                                                <span class="woocommerce-product-attributes-item__label pl-1">
                                                                    <?php echo wp_kses_post($product_attribute['name']) . ':'; ?>
                                                                </span>
                                                                <span class="woocommerce-product-attributes-item__value">
                                                                    <?php echo wp_kses_post($product_attribute['value']); ?>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </section>
                                        </div>
                                        <?php if(!$show_all_attributes): ?>
                                            <label for="more-attributes-toggle" class="more"><?php echo __('More Items', 'ahura'); ?></label>
                                            <label for="more-attributes-toggle" class="less" style="display:none;"><?php echo __('Less Items', 'ahura'); ?></label>
                                            <?php break; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="no-attributes">
                                <?php echo __('This product does not have any attributes', 'ahura'); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="product-page-box">
                    <div class="d-flex align-items-center product-page-item-box product-page-rating-box">
                        <i aria-hidden="true" class="fas fa-store"></i>
                        <div class="item-box-content rating-box-content">
                            <h4 class="rating-box-title">
                                <?php echo __('User Rating', 'ahura'); ?>
                            </h4>
                            <p class="rating-box-description">
                                <?php if ($product->get_rating_counts()) : ?>
                                    <?php echo __('Product rating ', 'ahura') . $product->get_average_rating() . __(' of 5', 'ahura') . ' | ' . (($product->get_average_rating() * 100) / 5) . '%' . __(' satisfied customers rate', 'ahura'); ?>
                                <?php else : ?>
                                    <?php echo __('No reviews', 'ahura'); ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center product-page-item-box product-page-availability-box">
                        <i aria-hidden="true" class="fas fa-shipping-fast"></i>
                        <div class="item-box-content availability-box-content">
                            <h4 class="availability-box-title">
                                <?php if ($product->get_stock_status() == 'instock') : ?>
                                    <?php echo __('Product is available', 'ahura'); ?>
                                <?php else : ?>
                                    <?php echo __('Product isn\'t available', 'ahura'); ?>
                                <?php endif; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="product-page-item-box product-page-addtocart-box">
                        <?php woocommerce_template_single_price(); ?>
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column product-page-digi-related">
        <?php woocommerce_output_related_products(); ?>
    </div>
    <div class="d-flex flex-column">
        <?php woocommerce_output_product_data_tabs(); ?>
    </div>
</div>