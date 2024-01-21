<?php
namespace ahura\app\traits;

trait WoocommerceMethods {
    /**
     *
     * Get products result
     *
     * @param array $params
     * @return false|object
     */
    public function get_products($params = [])
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => (isset($params['per_page'])) ? $params['per_page'] : -1,
            'post_status' => 'publish',
        );

        if (isset($params['cat_id']) && !empty($params['cat_id'])) {
            $args['tax_query'] = array(
                'tax_query' => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $params['cat_id'],
                    ]
                ]
            );
        }

        $products = new \WP_Query(array_merge($args, $params));
        return $products;
    }

    public function get_products_array(){
        global $wpdb;
        $sql = "SELECT ID,post_title FROM {$wpdb->prefix}posts WHERE post_type=%s AND post_status=%s";
        $stmt = $wpdb->get_results($wpdb->prepare($sql, 'product', 'publish'), ARRAY_A);
        return $stmt;
    }

    /**
     * Get discounted products result
     *
     * @param array $params
     * @return false|object
     */
    public function get_discounted_products($params = []){
        $params['meta_query'] = [
            array(
                'key'           => '_sale_price',
                'value'         => 0,
                'compare'       => '>',
                'type'          => 'numeric'
            )
        ];
        return $this->get_products($params);
    }

    /**
     *
     * Check is new product
     *
     * @return bool
     */
    public function is_new_product($days = 5)
    {
        global $product;
        $created = strtotime($product->get_date_created());
        return ((time() - (60 * 60 * 24 * $days)) < $created);
    }

    /**
     * Get product labels
     *
     * @param boolean $html if true = return html labels
     * @return array|string
     */
    public function get_product_labels($html = false){
        global $product;
        $labels = [];

        if ($this->is_new_product()):
            $label['new'] = '<span class="new">' . esc_html__('New', 'ahura') . '</span>';
        endif;

        if (!$product->is_in_stock()):
            $labels['sold_out'] = apply_filters('woocommerce_product_is_in_stock', '<span class="soldout">' . esc_html__('Sold Out!', 'ahura') . '</span>', $product, $product);
        elseif ($product->is_on_sale()):
            $labels['on_sale'] = apply_filters('woocommerce_sale_flash', '<span class="sale">' . esc_html__('On Sale', 'ahura') . '</span>', $product, $product);
            if($this->get_product_sale_percent()){
                $labels['on_sale_percent'] = '<span class="sale-percent">' . $this->get_product_sale_percent() . '%</span>';
            }
        endif;

        return ($html == true) ? implode('', $labels) : $labels;
    }

    /**
     * Display product attributes list
     *
     * @param integer $num
     * @return string
     */
    public static function product_html_attributes($num = 5){
        global $product;
        $attributes = $product->get_attributes();

        $i = 0;
        if($attributes){
            echo '<ul class="product-attributes-list">';
            foreach ($attributes as $attribute) {
                if ($attribute->get_variation()) {
                    continue;
                }
                $i++;

                if(intval($num) && $i == $num) break;

                echo '<li>';
                $name = $attribute->get_name();
                if ($attribute->is_taxonomy()) {
                    $terms = wp_get_post_terms($product->get_id(), $name, 'all');
                    $cwtax = $terms[0]->taxonomy;
                    $cw_object_taxonomy = get_taxonomy($cwtax);
                    if (isset ($cw_object_taxonomy->labels->singular_name)) {
                        $tax_label = $cw_object_taxonomy->labels->singular_name;
                    } elseif (isset($cw_object_taxonomy->label)) {
                        $tax_label = $cw_object_taxonomy->label;
                        if (0 === strpos($tax_label, 'Product ')) {
                            $tax_label = substr($tax_label, 8);
                        }
                    }
                    echo $tax_label . ': ';
                    $tax_terms = array();
                    foreach ($terms as $term) {
                        $single_term = esc_html($term->name);
                        array_push($tax_terms, $single_term);
                    }
                    echo implode(', ', $tax_terms);
                } else {
                    echo $name . ': ';
                    echo esc_html(implode(', ', $attribute->get_options()));
                }
                echo '</li>';
            }
            echo '</ul>';
        }
    }

    /**
     * Get product on sale percent
     *
     * @return integer
     */
    public function get_product_sale_percent(){
        global $product;
        $percent_cal = $product->is_on_sale() && $product->get_regular_price() ? (($product->get_regular_price() - $product->get_price()) * 100) / $product->get_regular_price() : 0;
        $percent = $percent_cal ? ceil($percent_cal) : 0;

        return $percent;
    }

    /**
     *
     * Get product buyers with id
     *
     */
    public function get_product_customers($product_id, $number = -1){
        global $wpdb;
        $statuses = array_map('esc_sql', wc_get_is_paid_statuses());
        $sql = "
            SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
            INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
            INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
            INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
            WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
            AND pm.meta_key IN ( '_billing_email' )
            AND im.meta_key IN ( '_product_id', '_variation_id' )
            AND im.meta_value = $product_id
        ";
        if(intval($number) && $number > 0){
            $sql .= ' LIMIT ' . $number;
        }
        $customers = $wpdb->get_col($sql);
        return ($customers) ? $customers : false;
    }

    /**
     *
     * Progress percentage of sales days
     *
     * @param $product_id
     * @return float|int
     */
    public function get_product_sale_progress_percent($product_id){
        $start_date = (int) get_post_meta($product_id, '_sale_price_dates_from', true);
        $end_date = (int) get_post_meta($product_id, '_sale_price_dates_to', true);
        if (empty($start_date) || empty($end_date))
            return 0;
        $progress_percent = round(((time() - $start_date) / ($end_date - $start_date)) * 100);
        return $progress_percent > 0 && $progress_percent <= 100 ? $progress_percent : 0;
    }

    public function get_price($product_id)
    {
        $product = wc_get_product($product_id);
        $regular_price = get_post_meta($product_id, '_regular_price', true);
        $sale_price = get_post_meta($product_id, '_sale_price', true);
        if($product->is_type('variable')){
            $prices = $product->get_variation_prices();

            $regular_price = current($prices['price']);
            //$regular_price = end($prices['price']);
        }
        return !empty($sale_price) ? $sale_price : $regular_price;
    }
}