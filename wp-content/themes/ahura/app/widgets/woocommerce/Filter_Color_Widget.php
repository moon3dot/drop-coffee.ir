<?php
namespace ahura\app\widgets\woocommerce;

use ahura\app\Ahura_Widget;
use ahura\app\woocommerce;

class Filter_Color_Widget extends Ahura_Widget
{
    public function __construct()
    {
        $this->widget_id = 'ahura_wc_filter_color';
        $this->widget_name = __( 'Ahura: Woocommerce filter by color', 'ahura' );
        $this->widget_description = __('Filter shop products by color', 'ahura');
        parent::__construct();
    }

    public function widget($args, $instance)
    {
        if (!woocommerce::is_active())
            return false;

        ob_start();
        $this->widget_start($args, $instance);

        $attributes = wc_get_attribute_taxonomies();
        $color_attributes = array_filter($attributes, function ($attribute) {
            return in_array($attribute->attribute_type, ['color_var']);
        });

        echo '<ul class="ah-widget-ul-type ah-widget-wc-filter-colors">';
        $current_color = isset($_GET['filter_color']) ? $_GET['filter_color'] : null;
        foreach ($color_attributes as $attribute):
            $attribute_name = $attribute->attribute_name;
            $tax_name = wc_attribute_taxonomy_name($attribute_name);
            if (!taxonomy_exists($tax_name))
                continue;

            $terms = get_terms($tax_name, 'orderby=name&hide_empty=0');
            if (!$terms)
                continue;

            foreach ($terms as $term):
                $color = get_term_meta($term->term_id, '_product_attribute_color', true);
                $term_slug = urldecode($term->slug);
                if (empty($color))
                    continue;
            ?>
                <li class="<?php echo $term_slug == $current_color ? 'current' : '' ?>">
                    <a href="<?php echo ahura_get_current_page_url(); ?>?filter_<?php echo $attribute_name ?>=<?php echo $term_slug ?>&query_type_<?php echo $attribute_name ?>=or">
                        <div class="ah-color-label">
                            <i class="ah-color" style="background-color:<?php echo $color ?>"></i>
                            <span class="ah-filter-color"><?php echo $term->name ?></span>
                        </div>
                        <em class="count"><?php echo $term->count ?></em>
                    </a>
                </li>
            <?php
            endforeach;
        endforeach;
        echo '</ul>';
        $this->widget_end($args);

        $content = ob_get_clean();
        echo $this->cache_widget($args, $content);
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : __('Filter by color', 'ahura');
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