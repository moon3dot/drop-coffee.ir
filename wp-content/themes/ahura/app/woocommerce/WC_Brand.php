<?php
namespace ahura\app\woocommerce;

use ahura\app\mw_assets;
use ahura\app\mw_tools;

class WC_Brand
{
    public static function init()
    {
        self::register_taxonomy();
        add_action('product_brand_add_form_fields', [__CLASS__, 'handle_render_add_meta_template']);
        add_action('product_brand_edit_form_fields', [__CLASS__, 'handle_render_update_meta_template']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'handle_load_assets']);
        add_action('created_product_brand', [__CLASS__, 'handle_save_brand_meta']);
        add_action('edited_product_brand', [__CLASS__, 'handle_save_brand_meta']);
        add_action('woocommerce_product_meta_end', [__CLASS__, 'handle_show_product_brand_in_single_page']);
    }

    public static function handle_load_assets()
    {
        mw_assets::load_uploader_assets();
    }

    public static function register_taxonomy()
    {
        $labels = array(
            'name'                       => __( 'Brands', 'ahura' ),
            'singular_name'              => __( 'Brand', 'ahura' ),
            'search_items'               => __( 'Search Brands', 'ahura' ),
            'popular_items'              => __( 'Popular Brands', 'ahura' ),
            'all_items'                  => __( 'All Brands', 'ahura' ),
            'edit_item'                  => __( 'Edit Brand', 'ahura' ),
            'update_item'                => __( 'Update Brand', 'ahura' ),
            'add_new_item'               => __( 'Add New Brand', 'ahura' ),
            'new_item_name'              => __( 'New Brand Name', 'ahura' ),
            'separate_items_with_commas' => __( 'Separate brands with commas', 'ahura' ),
            'add_or_remove_items'        => __( 'Add or remove brand', 'ahura' ),
            'choose_from_most_used'      => __( 'Choose from the most used brands', 'ahura' ),
            'not_found'                  => __( 'No brands found.', 'ahura' ),
            'menu_name'                  => __( 'Brands', 'ahura' ),
        );

        $args = array(
            'hierarchical'          => true,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_in_rest'          => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array('slug' => 'product_brand', 'with_front' => true),
        );

        register_taxonomy('product_brand', 'product', $args);
    }

    public static function handle_render_add_meta_template($taxonomy)
    {?>
        <?php
        mw_tools::render_uploader_field([
            'label' => __('Brand Icon', 'ahura'),
            'name' => 'brand_icon',
            'type' => 'image',
        ]);
        ?>
        <div class="form-field form-field-promotion">
            <label><input type="checkbox" name="promotion" value="1"><?php _e('Promotion Brand', 'ahura') ?></label>
        </div>
    <?php
    }

    public static function handle_render_update_meta_template($term)
    {
        $brand_icon = self::get_brand_icon($term->term_id);
        $is_promotion = self::is_promotion_brand($term->term_id);
        ?>
        <tr class="form-field term-brand-icon-wrap">
            <th scope="row"><label><?php _e('Brand Icon', 'ahura') ?></label></th>
            <td>
                <?php
                mw_tools::render_uploader_field([
                    'name' => 'brand_icon',
                    'type' => 'image',
                    'value' => $brand_icon
                ]);
                ?>
            </td>
        </tr>
        <tr class="form-field term-brand-promotion-wrap">
            <th scope="row"><label for="brand_promotion"><?php _e('Promotion Brand', 'ahura') ?></label></th>
            <td>
                <input type="checkbox" name="promotion" id="brand_promotion" value="1" <?php echo $is_promotion ? 'checked' : '' ?>>
            </td>
        </tr>
    <?php
    }

    public static function handle_save_brand_meta($term_id)
    {
        $brand_icon = isset($_POST['brand_icon']) ? sanitize_text_field($_POST['brand_icon']) : null;

        update_term_meta($term_id, 'brand_icon', $brand_icon);
        update_term_meta($term_id, 'promotion', isset($_POST['promotion']));
    }

    public static function handle_show_product_brand_in_single_page()
    {
        global $product;
        if (empty($product)) return false;

        $brands = get_the_terms($product->get_id(), 'product_brand');

        if (empty($brands)) return false;
        ?>
        <div class="ah-product-brand">
            <span><?php echo __('Brand:', 'ahura') ?></span>
            <div class="ah-product-brand-list">
                <?php
                foreach ($brands as $brand):
                    $brand_icon = WC_Brand::get_brand_icon($brand->term_id);
                    $is_promotion = WC_Brand::is_promotion_brand($brand->term_id);
                    ?>
                    <a href="<?php echo get_term_link($brand->term_id) ?>" title="<?php echo $brand->name ?>">
                        <?php
                        $img = wp_get_attachment_image($brand_icon, 'thumb');
                        if (!empty($img)){
                            echo $img;
                        } else {
                            echo wc_placeholder_img();
                        }
                        ?>
                        <span><?php echo $brand->name ?></span>
                        <?php if ($is_promotion): ?>
                            <em class="brand-promotion">
                                <i class="fas fa-star"></i>
                            </em>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    public static function get_brand_icon($term_id){
        return get_term_meta($term_id, 'brand_icon', true);
    }

    public static function is_promotion_brand($term_id){
        return get_term_meta($term_id, 'promotion', true);
    }
}