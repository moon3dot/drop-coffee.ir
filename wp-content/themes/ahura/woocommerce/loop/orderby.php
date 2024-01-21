<?php

if (!defined('ABSPATH')) exit;

if( get_theme_mod( 'ahura_shop_orderby_status' ) ):
    $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', [
        'menu_order' => __( 'Default', 'ahura' ),
        'popularity' => __( 'Popularity', 'ahura' ),
        'rating'     => __( 'Average rating', 'ahura' ),
        'price'      => __( 'Price: low to high', 'ahura' ),
        'price-desc' => __( 'Price: high to low', 'ahura' )
    ] );

    if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' ) unset( $catalog_orderby_options[ 'rating' ] );
    if ( get_theme_mod( 'ahura_shop_orderby_default_status' ) ) unset( $catalog_orderby_options[ 'menu_order' ] );
    if ( get_theme_mod( 'ahura_shop_orderby_popularity_status' ) ) unset( $catalog_orderby_options[ 'popularity' ] );
    if ( get_theme_mod( 'ahura_shop_orderby_rating_status' ) ) unset( $catalog_orderby_options[ 'rating' ] );
    if ( get_theme_mod( 'ahura_shop_orderby_price_status' ) ) unset( $catalog_orderby_options[ 'price' ] );
    if ( get_theme_mod( 'ahura_shop_orderby_pricedesc_status' ) ) unset( $catalog_orderby_options[ 'price-desc' ] );

    if($catalog_orderby_options): ?>
        <form class="woocommerce-ordering" method="get">
            <div class="orderby-list-area">
                <label for="orderby-dropdown-list"><?php echo __( 'Shop order: ', 'ahura' ); ?></label>
                <ul class="orderby-dropdown-list">
                    <?php foreach ( $catalog_orderby_options as $id => $name ) echo '<li><a href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '?orderby=' . $id . '" >' . esc_attr( $name ) . '</a></li>'; ?>
                </ul>
            </div>
        </form>
    <?php endif; ?>
<?php else: ?>
    <form class="woocommerce-ordering" method="get">
        <select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
            <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="paged" value="1" />
        <?php wc_query_string_form_fields( null, [ 'orderby', 'submit', 'paged', 'product-page' ] ); ?>
    </form>
<?php endif; ?>
