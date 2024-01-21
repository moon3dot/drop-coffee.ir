<?php
namespace ahura\app\widgets\woocommerce;

use ahura\app\Ahura_Widget;
use ahura\app\woocommerce;

class Filter_Rating_Widget extends Ahura_Widget
{
    public function __construct()
    {
        $this->widget_id = 'ahura_wc_filter_rating';
        $this->widget_name = __( 'Ahura: Woocommerce filter by rating', 'ahura' );
        $this->widget_description = __('Filter shop products by rating', 'ahura');
        parent::__construct();
    }

    public function widget($args, $instance)
    {
        if (!woocommerce::is_active())
            return false;

        ob_start();
        $this->widget_start($args, $instance);

        $query_args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_wc_average_rating',
                    'value'   => array( 0, 5 ),
                    'type'    => 'NUMERIC',
                    'compare' => 'BETWEEN',
                ),
            ),
        );

        $products_query = new \WP_Query($query_args);
        $rating_counts = array(
            '0-1' => 0,
            '1-2' => 0,
            '2-3' => 0,
            '3-4' => 0,
            '4-5' => 0,
        );

        if ( $products_query->have_posts() ) {
            while ( $products_query->have_posts() ) {
                $products_query->the_post();
                $product = wc_get_product(get_the_ID());
                $average_rating = $product->get_average_rating();

                if ( $average_rating >= 1 && $average_rating <= 1 ) {
                    $rating_counts['0-1']++;
                } elseif ( $average_rating >= 1 && $average_rating < 2 ) {
                    $rating_counts['1-2']++;
                } elseif ( $average_rating >= 2 && $average_rating < 3 ) {
                    $rating_counts['2-3']++;
                } elseif ( $average_rating >= 3 && $average_rating < 4 ) {
                    $rating_counts['3-4']++;
                } elseif ( $average_rating >= 4 && $average_rating <= 5 ) {
                    $rating_counts['4-5']++;
                }
            }
        }
        wp_reset_query();

        $current_rate = isset($_GET['rating_filter']) ? $_GET['rating_filter'] : null;

        if ($rating_counts):
            echo '<ul class="ah-widget-ul-type ah-widget-wc-filter-rating">';
            $i = 0;
            foreach ($rating_counts as $range => $count):
                $i++;
                $ranges = explode('-', $range);
                if (empty($count))
                    continue;
                ?>
                <li class="rate-<?php echo $range ?> <?php echo $i == $current_rate ? 'current' : '' ?>">
                    <a href="<?php echo ahura_get_current_page_url() ?>?rating_filter=<?php echo $i ?>">
                        <div class="ah-li-label">
                            <i class="fas fa-star <?php echo (1 <= $ranges[1]) ? 'active' : '' ?>"></i>
                            <i class="fas fa-star <?php echo (2 <= $ranges[1]) ? 'active' : '' ?>"></i>
                            <i class="fas fa-star <?php echo (3 <= $ranges[1]) ? 'active' : '' ?>"></i>
                            <i class="fas fa-star <?php echo (4 <= $ranges[1]) ? 'active' : '' ?>"></i>
                            <i class="fas fa-star <?php echo (5 <= $ranges[1]) ? 'active' : '' ?>"></i>
                        </div>
                        <em><?php echo $count ?></em>
                    </a>
                </li>
            <?php
            endforeach;
            echo '</ul>';
        endif;

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