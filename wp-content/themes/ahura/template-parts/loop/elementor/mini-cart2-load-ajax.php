<?php
global $woocommerce;
$is_admin = is_admin();
if($is_admin){
    wc_load_cart();
}
$cart = $woocommerce->cart;
$cart_items = $cart->get_cart();
$total_price = $cart->get_cart_total();
$total_items = $cart->get_cart_contents_count();

$currency = get_woocommerce_currency_symbol();

$cart_url = wc_get_cart_url();
$checkout_url = wc_get_checkout_url();
?>
<div class="mc2-content">
    <div class="mc2-head">
        <div class="mc2-counter"><?php echo sprintf(__('%d Product', 'ahura'), $total_items) ?></div>
        <div class="mc2-btns1">
            <a href="<?php echo $cart_url ?>"><?php echo __('View Cart', 'ahura') ?> <i class="fas fa-angle-<?php echo is_rtl() ? 'left' : 'right' ?>"></i></a>
        </div>
    </div>
    <div class="mc2-main">
        <?php
        if ($cart_items):
            foreach ($cart_items as $cart_item_key => $item):
                $product_id = $item['product_id'];
                $product = wc_get_product($product_id);
                $item_data = $item['data'];
                $product_price = $product->get_price();
                $is_variable = $product->is_type('variable');
                $product_regular_price = $is_variable ? $product->get_variation_regular_price() : $product->get_regular_price();
                $product_sale_price = $is_variable ? $product->get_variation_sale_price() : $product->get_sale_price();
                $product_sale_price = $product_sale_price !== $product_regular_price ? $product_sale_price : 0;
                $saved_price = $product_regular_price && $product_sale_price ? $product_regular_price - $product_sale_price : 0;
                $variation_attributes = $item['variation'];
                ?>
                <div class="cart-item">
                    <div class="cart-item-image">
                        <a href="<?php echo get_the_permalink($product_id) ?>">
                            <?php echo wp_get_attachment_image(get_post_thumbnail_id($product_id)) ?>
                        </a>
                        <?php if ($product_sale_price): ?>
                            <div class="cart-item-is-sale">
                                <?php echo __('Special Sale', 'ahura') ?>
                            </div>
                        <?php endif; ?>
                        <div class="cart-item-action">
                            <div class="cart-item-action-btn">
                                <div>
                                    <?php echo apply_filters(
                                        'woocommerce_cart_item_remove_link',
                                        sprintf(
                                            '<a href="%s" class="remove" data-product_id="%d" data-item_key="%s" title="%s"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 1200 1200" enable-background="new 0 0 1200 1200" xml:space="preserve"> <g> <path fill="#65676B" d="M592.721,1005.519c17.686,0,32.035-14.348,32.035-32.033V507.301c0-17.685-14.35-32.033-32.035-32.033&#10;&#9;&#9;s-32.032,14.348-32.032,32.033v466.186C560.69,991.171,575.036,1005.519,592.721,1005.519z" style="fill: rgb(239, 64, 86);"/> <path fill="#65676B" d="M766.941,980.869c0.377,0,0.753,0,1.126,0c17.186,0,31.409-13.598,32.032-30.906l14.849-416.843&#10;&#9;&#9;c0.626-17.685-13.22-32.492-30.906-33.159c-16.225-0.376-32.493,13.222-33.158,30.907L736.035,947.71&#10;&#9;&#9;C735.409,965.395,749.255,980.201,766.941,980.869z" style="fill: rgb(239, 64, 86);"/> <path fill="#65676B" d="M417.376,980.869c0.377,0,0.749,0,1.126,0c17.686-0.668,31.532-15.474,30.906-33.159l-14.849-416.843&#10;&#9;&#9;c-0.623-17.685-16.225-31.449-33.158-30.907c-17.686,0.667-31.532,15.474-30.906,33.159l14.849,416.843&#10;&#9;&#9;C385.967,967.271,400.194,980.869,417.376,980.869z" style="fill: rgb(239, 64, 86);"/> <path fill="#65676B" d="M1017.114,206.284H853.978C835.22,117.861,733.929,50,611.825,50&#10;&#9;&#9;c-122.147,0-223.437,67.861-242.195,156.284H182.886c-36.205,0-65.65,29.447-65.65,65.65v54.557c0,36.203,29.445,65.65,65.65,65.65&#10;&#9;&#9;h12.244l70.005,634.733C272.851,1097.071,330.662,1150,399.648,1150h417.844c71.242,0,130.594-57.017,135.14-129.841&#10;&#9;&#9;l39.164-628.017h25.318c36.205,0,65.65-29.447,65.65-65.65v-54.557C1082.764,235.731,1053.319,206.284,1017.114,206.284z&#10;&#9;&#9; M611.825,114.065c83.251,0,155.577,39.916,175.845,92.178H435.938C456.209,153.981,528.531,114.065,611.825,114.065z&#10;&#9;&#9; M888.649,1016.154c-2.421,39.124-33.703,69.78-71.157,69.78H399.648c-36.244,0-66.692-28.404-70.861-66.067l-69.24-627.725h668.06&#10;&#9;&#9;L888.649,1016.154z M1018.697,326.491c0,0.875-0.707,1.584-1.583,1.584l-835.811-1.584l1.583-56.141l835.811,1.584V326.491z" style="fill: rgb(239, 64, 86);"/> </g> </svg></a>',
                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                            $product_id,
                                            $cart_item_key,
                                            __('Remove this item', 'ahura')
                                        ),
                                        $cart_item_key
                                    ); ?>
                                </div>
                                <div class="cart-item-quantity"><?php echo $item['quantity']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="cart-item-content">
                        <div class="cart-item-content-top">
                            <h3><?php echo $item_data->get_name() ?></h3>
                            <?php if (!empty($variation_attributes)): ?>
                                <div class="cart-item-vars">
                                    <?php echo wc_get_formatted_cart_item_data($item); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="cart-item-content-bottom">
                            <?php if(!$is_variable && $product_sale_price && $saved_price > 0): ?>
                            <div class="cart-item-saved-price">
                                <?php echo sprintf(__('%s Discount', 'ahura'), wc_price($saved_price)); ?>
                            </div>
                            <?php endif; ?>
                            <div class="cart-item-price">
                                <?php echo wc_price($item_data->get_price()) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        else: ?>
            <div class="cart-is-empty">
                <img src="<?php echo get_template_directory_uri() . '/img/empty-cart.svg' ?>" alt="<?php echo __('Cart is empty', 'ahura') ?>">
                <p><?php echo __('Your cart is empty.', 'ahura') ?></p>
            </div>
        <?php endif; ?>
    </div>
    <div class="mc2-foot">
        <div class="mc2-total-prices">
            <div><?php echo __('Payable amount', 'ahura') ?></div>
            <div class="total-cart-price">
                <?php echo $total_price ?>
            </div>
        </div>
        <div class="mc2-btns2">
            <a href="<?php echo $checkout_url ?>"><?php echo __('Place an order', 'ahura') ?></a>
        </div>
    </div>
</div>
