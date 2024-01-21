<?php
namespace ahura\app\woocommerce\variations;

class Woocommerce_Product_Variation{
    protected $fields;
    protected $taxonomy;
    protected $post_type;
    protected $term;

    public function __construct($taxonomy, $post_type, $fields = array()){
        $this->fields = $fields;
        $this->taxonomy = $taxonomy;
        $this->post_type = $post_type;
        
        add_action('delete_term', [$this, 'delete_term'], 5, 4);
        add_action($this->taxonomy . '_add_form_fields', [$this, 'register_variation'], 10, 1);
        add_action($this->taxonomy . '_edit_form_fields', [$this, 'register_variation'], 10, 1);
        add_action('created_term', [$this, 'save_variation'], 10, 3);
        add_action('edit_term', [$this, 'save_variation'], 10, 3);

        add_filter("manage_edit-{$this->taxonomy}_columns", [$this, 'taxonomy_columns']);
        add_filter("manage_{$this->taxonomy}_custom_column", [$this, 'taxonomy_column_preview'], 10, 3);
    }

    public function taxonomy_columns($columns) {
        $new_columns = array();
        
        if (isset($columns['cb' ])) {
            $new_columns['cb'] = $columns['cb'];
        }
        
        $new_columns['ahura-attribute-meta-preview'] = '';
        
        if (isset($columns['cb'])) {
            unset($columns['cb']);
        }
        
        return array_merge($new_columns, $columns);
    }

    public function get_attribute_taxonomy($attribute_name) {
                
        $taxonomy_attributes = wc_get_attribute_taxonomies();
        
        $attribute_name = str_ireplace('pa_', '', wc_sanitize_taxonomy_name($attribute_name));
        
        foreach ( $taxonomy_attributes as $attribute ) {
            if ( false === stripos( $attribute->attribute_name, $attribute_name ) ) {
                continue;
            }
            
            return $attribute;
        }
        
        return false;
    }

    public function color_preview($attribute_type, $term_id, $key) {
        if ('color_var' === $attribute_type) {
            $primary_color = sanitize_hex_color(get_term_meta($term_id, $key, true));
                        
            printf( '<div class="ahura-attr-preview ahura-color-preview" style="background-color:%s;width:30px;height:30px;border-radius:5px;border:1px solid #f0f0f0;"></div>', esc_attr($primary_color));
        }
    }

    public function preview($attribute_type, $term_id, $fields) {
        $meta_key = $fields[0]['id'];
        
        $this->color_preview( $attribute_type, $term_id, $meta_key );
    }

    public function taxonomy_column_preview($columns, $column, $term_id) {
        if ('ahura-attribute-meta-preview' !== $column) {
            return $columns;
        }
        
        $attribute = $this->get_attribute_taxonomy($this->taxonomy);
        
        $attribute_type = $attribute->attribute_type;
        
        $this->preview( $attribute_type, $term_id, $this->fields);
        
        return $columns;
    }

    public function register_variation($term){
        $this->term = $term;

        $this->variation_fields_template();
    }

    public function save_variation($term_id, $tt_id = '', $taxonomy = '') {
        if ($taxonomy == $this->taxonomy) {
            foreach ($this->fields as $field) {
                foreach ($_POST as $post_key => $post_value) {
                    if ($field['id'] == $post_key) {
                        switch ($field['type']) {
                            case 'text':
                            case 'color_var':
                                $post_value = esc_html( $post_value );
                                break;
                            case 'url':
                                $post_value = esc_url( $post_value );
                                break;
                            case 'textarea':
                                $post_value = esc_textarea( $post_value );
                                break;
                            case 'editor':
                                $post_value = wp_kses_post( $post_value );
                                break;
                            case 'select':
                            case 'select2':
                                $post_value = sanitize_key( $post_value );
                                break;
                            case 'checkbox':
                                $post_value = sanitize_key( $post_value );
                                break;
                            default:
                                do_action('ahura_product_variation_save_term_meta', $term_id, $field, $post_value, $taxonomy);
                                break;
                        }
                        update_term_meta($term_id, $field['id'], $post_value);
                    }
                }
            }
            do_action('ahura_product_variation_after_term_meta_saved', $term_id, $taxonomy);
        }
    }

    public function delete_term( $term_id, $tt_id, $taxonomy, $deleted_term ) {
        global $wpdb;
        
        $term_id = absint($term_id);

        if ($term_id and $taxonomy == $this->taxonomy) {
            $wpdb->delete($wpdb->termmeta, array('term_id' => $term_id), array('%d'));
        }
    }

    public function variation_fields_template(){
        $screen = get_current_screen();

        if ($screen->post_type != $this->post_type || $screen->taxonomy != $this->taxonomy) {
            return false;
        }

        $fields = $this->fields;
        $term = $this->term;
        $field = apply_filters('ahura_product_variation_term_meta_field', $fields, false);
        include_once(get_template_directory() . '/template-parts/admin/meta-boxs/product-variations.php');
    }
}