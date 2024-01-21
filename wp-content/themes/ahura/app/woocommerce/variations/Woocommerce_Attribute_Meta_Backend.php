<?php
namespace ahura\app\woocommerce\variations;

class Woocommerce_Attribute_Meta_Backend{
    protected static $_instance = null;

    public function __construct(){
        add_action('admin_init', [$this, 'add_attribute_meta']);
        add_filter('product_attributes_type_selector', [$this, 'register_attribute_types'], 10, 1);
        add_action('woocommerce_product_option_terms', [$this, 'product_option_terms'], 10, 3);
    }

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    public function attribute_types(){
        return \ahura\app\woocommerce\variations\Woocommerce_Attribute_Data::attribute_types();
    }

    public function register_attribute_types($options) {
        $post_id = isset($_GET['post']) && intval($_GET['post']) ? $_GET['post'] : 0;
		if($post_id || wp_doing_ajax()) return false;
        $types = $this->attribute_types();
        return (is_array($options) && count($options) > 0) ? array_merge($types, $options) : $types;
    }

    public function attribute_meta_fields(){
        $fields = array();
                
        $fields['color_var'] = array(
            [
                'label' => esc_html__('Color', 'ahura'),
                'desc'  => esc_html__('Choose a color', 'ahura'),
                'id'    => '_product_attribute_color',
                'type'  => 'color'
            ]
        );
        
        return $fields;
    }

    public function add_attribute_meta(){
        $fields = $this->attribute_meta_fields();
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        if($attribute_taxonomies) {
            foreach ($attribute_taxonomies as $taxonomy) {
                $attribute_name = wc_attribute_taxonomy_name($taxonomy->attribute_name);
                $attribute_type = $taxonomy->attribute_type;
                if (in_array($attribute_type, array_keys($fields))) {
                    new Woocommerce_Product_Variation($attribute_name, 'product', $fields[$attribute_type]);
                }
            }
        }
    }
                
    public function product_option_terms( $attribute_taxonomy, $i, $attribute ) {
        if ('default' !== $attribute_taxonomy->attribute_type && in_array($attribute_taxonomy->attribute_type, array_keys($this->attribute_types()))) {    
        $name = sprintf('attribute_values[%s][]', esc_attr($i));
        ?>
        <select multiple="multiple" data-placeholder="<?php esc_attr_e('Select terms', 'woocommerce'); ?>" class="multiselect attribute_values wc-enhanced-select" name="<?php echo esc_attr($name) ?>">
            <?php
                $args      = array(
                    'orderby'    => ! empty( $attribute_taxonomy->attribute_orderby ) ? $attribute_taxonomy->attribute_orderby : 'name',
                    'hide_empty' => 0,
                );
                $all_terms = get_terms( $attribute->get_taxonomy(), apply_filters( 'woocommerce_product_attribute_terms', $args ) );
                if ( $all_terms ) {
                    foreach ( $all_terms as $term ) {
                        $options = $attribute->get_options();
                        $options = ! empty( $options ) ? $options : array();
                        echo '<option value="' . esc_attr( $term->term_id ) . '"' . wc_selected( $term->term_id, $options ) . '>' . esc_html( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
                    }
                }
            ?>
        </select>
        <button class="button plus select_all_attributes"><?php esc_html_e('Select all', 'woocommerce'); ?></button>
        <button class="button minus select_no_attributes"><?php esc_html_e('Select none', 'woocommerce'); ?></button>
        <button class="button fr plus add_new_attribute"><?php esc_html_e('Add new', 'woocommerce'); ?></button>
        <?php
        }
    }
}