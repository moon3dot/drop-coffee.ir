<?php
namespace ahura\app\widgets\woocommerce;

use ahura\app\Ahura_Widget;
use ahura\app\woocommerce;

class Filter_Brand_Widget extends Ahura_Widget
{
    public function __construct()
    {
        $this->widget_id = 'ahura_wc_filter_brand';
        $this->widget_name = __( 'Ahura: Woocommerce filter by brand', 'ahura' );
        $this->widget_description = __('Filter shop products by brand', 'ahura');
        parent::__construct();
    }

    public function widget($args, $instance)
    {
        if (!woocommerce::is_active())
            return false;

        ob_start();
        $this->widget_start($args, $instance);

        $brands = get_terms(array(
            'taxonomy'   => 'product_brand',
            'hide_empty' => false,
        ));
        ?>
        <?php if ($brands): ?>
        <ul class="ah-widget-brands-list">
            <?php
            foreach ($brands as $brand):
                $brand_icon = woocommerce\WC_Brand::get_brand_icon($brand->term_id);
                $is_promotion = woocommerce\WC_Brand::is_promotion_brand($brand->term_id);
                ?>
            <li>
                <a href="<?php echo get_term_link($brand->term_id) ?>" title="<?php echo $brand->name ?>">
                    <?php if ($is_promotion): ?>
                        <span class="brand-promotion" title="<?php echo __('Promotion Brand', 'ahura') ?>">
                            <i class="fas fa-star"></i>
                        </span>
                    <?php endif; ?>
                    <?php
                        $img = wp_get_attachment_image($brand_icon, 'full');
                        if (!empty($img)){
                            echo $img;
                        } else {
                            echo wc_placeholder_img();
                        }
                    ?>
                    <div class="brand-title"><?php echo $brand->name ?></div>
                    <div class="clear"></div>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php
        $content = ob_get_clean();
        echo $this->cache_widget($args, $content);
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : __('Brands', 'ahura');
        ?>
        <div class="ahura-edit-widget-form">
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e('Title', 'ahura'); ?></label>
                <input value="<?php echo $title; ?>" type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ); ?>">
            </p>
        </div>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'] ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}