<?php
namespace ahura\app;
class taxonomies
{
    private static $_taxonomies = ['content_types'];
    static function init()
    {
        add_action('init', [__CLASS__, 'register_taxonomy_team_cat']);
        add_action('init', [__CLASS__, 'register_taxonomy_portfolio_cat']);
        add_action('init', [__CLASS__, 'register_taxonomy_portfolio_skills']);
        add_action('init', [__CLASS__, 'register_taxonomy_testimonial']);

        foreach(self::$_taxonomies as $taxonomy)
        {
            $register_method = [__CLASS__, 'register_' . $taxonomy];
            $new_form_field_method = [__CLASS__, 'new_form_field_' . $taxonomy];
            $edit_form_field_method = [__CLASS__, 'edit_form_field_' . $taxonomy];
            $create_and_edit_handler_method = [__CLASS__, 'save_handler_' . $taxonomy];
            $column_modification = [__CLASS__, $taxonomy . '_column_modification'];
            $column_modification_content = [__CLASS__, $taxonomy . '_column_modification_content'];

            if(method_exists(...$register_method))
            {
                add_action('init', [$register_method[0], $register_method[1]]);
            }
            if(method_exists(...$new_form_field_method))
            {
                add_action("{$taxonomy}_add_form_fields", [$new_form_field_method[0], $new_form_field_method[1]]);
            }
            if(method_exists(...$edit_form_field_method))
            {
                add_action("{$taxonomy}_edit_form_fields", [$edit_form_field_method[0], $edit_form_field_method[1]]);
            }
            if(method_exists(...$create_and_edit_handler_method))
            {
                add_action("create_{$taxonomy}", [$create_and_edit_handler_method[0], $create_and_edit_handler_method[1]]);
                add_action("edit_{$taxonomy}", [$create_and_edit_handler_method[0], $create_and_edit_handler_method[1]]);
            }
            if(method_exists(...$column_modification))
            {
                add_filter("manage_edit-{$taxonomy}_columns", [$column_modification[0], $column_modification[1]]);
            }
            if(method_exists(...$column_modification_content))
            {
                add_filter("manage_{$taxonomy}_custom_column", [$column_modification_content[0], $column_modification_content[1]], 10, 3);
            }
        }
    }
    static function load_admin_assets($current_taxonomy)
    {
        foreach(self::$_taxonomies as $taxonomy)
        {
            if($taxonomy == $current_taxonomy)
            {
                call_user_func([__CLASS__, 'enqueue_script_' . $taxonomy]);
            }
        }
    }
    static function register_content_types()
    {
        $labels = array(
            'name'              => __( 'Content Types', 'ahura' ),
            'singular_name'     => __( 'Content Type', 'ahura' ),
            'search_items'      => __( 'Search Content Types', 'ahura' ),
            'all_items'         => __( 'All Content Types', 'ahura' ),
            'parent_item'       => __( 'Parent Content Type', 'ahura' ),
            'parent_item_colon' => __( 'Parent Content Type:', 'ahura' ),
            'edit_item'         => __( 'Edit Content Type', 'ahura' ),
            'update_item'       => __( 'Update Content Type', 'ahura' ),
            'add_new_item'      => __( 'Add New Content Type', 'ahura' ),
            'new_item_name'     => __( 'New Content Type Name', 'ahura' ),
            'menu_name'         => __( 'Content Type', 'ahura' ),
        );

        $args = [
            'labels' => $labels,
            'show_in_nav_menus' => false,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'rewrite' => ['slug' => 'content_types'],
        ];
        register_taxonomy('content_types', 'post', $args);
    }
    static function new_form_field_content_types()
    {
        ?>
        <div class="form-field">
            <label for="term_meta[icon]"><?php esc_html_e('Icon', 'ahura')?></label>
            <a id="term_meta_choose_icon" href="#" class="button button-primary"><?php esc_html_e('Choose', 'ahura')?></a>
            <a style="display:none;" id="term_meta_remove_icon" class="button danger-button" href="#"><?php esc_html_e('Remove', 'ahura')?></a>
            <input type="hidden" name="term_meta[icon]" >
            <div style="overflow: hidden;display: inline-block; background-color: #d4d4d4; width: 50px; height: 50px; border-radius: 5px;" id="icon-preview"></div>
            <p><?php echo __('The best size is 20px in 20px','ahura');?></p>
        </div>
        <?php
    }
    static function get_term_meta($id, $key, $single=true)
    {
        return get_term_meta($id, 'ahura_' . $key, $single);
    }
    static function update_term_meta($id, $key, $value)
    {
        return update_term_meta($id, 'ahura_' . $key, $value);
    }
    static function delete_term_meta($id, $key)
    {
        return delete_term_meta($id, 'ahura_' . $key);
    }
    static function edit_form_field_content_types($term)
    {
        $t_id = $term->term_id;
        $icon_id = self::get_term_meta($t_id, 'icon');
        $icon = wp_get_attachment_url($icon_id);
        ?>
        <tr class="form-field">
            <th scope="row">
                <label for="term_meta[icon]"><?php esc_html_e('Icon', 'ahura')?></label>
            </th>
            <td>
                <a id="term_meta_choose_icon" href="#" class="button button-primary"><?php esc_html_e('Choose', 'ahura')?></a>
                <a <?php echo !$icon_id ? 'style="display:none;"' : '';?> id="term_meta_remove_icon" class="button danger-button" href="#"><?php esc_html_e('Remove', 'ahura')?></a>
                <input value="<?php echo $icon_id ? $icon_id : ''?>" type="hidden" name="term_meta[icon]" >
                <div style="overflow: hidden;display: inline-block; background-color: #d4d4d4; width: 50px; height: 50px; border-radius: 5px;" id="icon-preview">
                    <?php if($icon):?>
                        <img style="width: 100%;" src="<?php echo $icon?>" />
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php
    }
    static function save_handler_content_types($term_id)
    {
        $white_list = ['icon'];
        if(isset($_POST['term_meta']))
        {
            $fields = array_keys($_POST['term_meta']);
            $fields = is_array($_POST['term_meta']) ? $_POST['term_meta'] : false;
            foreach($fields as $key => $value)
            {
                if(!$key || !in_array($key, $white_list))
                {
                    continue;
                }
                $value ? self::update_term_meta($term_id, $key, $value) : self::delete_term_meta($term_id, $key);
            }
        }
    }
    static function content_types_column_modification($columns)
    {
        $cb = array_shift($columns);
        $new = ['icon' => esc_html__('Icon', 'ahura')];
        $columns = array_merge(['cb' => $cb], $new, $columns);
        return $columns;
    }
    static function content_types_column_modification_content($content, $column_name, $term_id)
    {
        if($column_name !== 'icon')
        {
            return $content;
        }
        $icon_id = self::get_term_meta($term_id, 'icon');
        if(!$icon_id)
        {
            return $content;
        }
        $icon_url = wp_get_attachment_url($icon_id);
        if(!$icon_url)
        {
            return $content;
        }
        $content = "<div style='overflow: hidden; width: 50px; height: 50px;'><img style='width: 100%;' src='{$icon_url}' /></div>";
        return $content;
    }
    static function enqueue_script_content_types()
    {
        mw_assets::load_media_uploader();
        mw_assets::enqueue_script('taxonomy_content_types', mw_assets::get_js('admin.taxonomy-content_types'));
    }

    /**
     * 
     * 
     * Register portfolio_cat for portfolio post type
     * 
     *
     * @return void
     */
    public static function register_taxonomy_portfolio_cat(){
        $labels = array(
            'name' => _x('Portfolio Categories', 'Portfolio Categories', 'ahura'),
            'singular_name' => _x('Portfolio Category', 'Portfolio Category', 'ahura'),
            'search_items' => __('Search Portfolios', 'ahura'),
            'all_items' => __('All Portfolios', 'ahura'),
            'parent_item' => __('Parent Portfolio', 'ahura'),
            'parent_item_colon' => __('Parent Portfolio:', 'ahura'),
            'edit_item' => __('Edit Portfolio', 'ahura'),
            'update_item' => __('Update Portfolio', 'ahura'),
            'add_new_item' => __('Add New Portfolio', 'ahura'),
            'new_item_name' => __('New Portfolio Name', 'ahura'),
            'menu_name' => __('Categories', 'ahura'),
        );
     
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'portfolio_cat'),
        );
     
        register_taxonomy('portfolio_cat', array('portfolio'), $args);
    }

    public static function register_taxonomy_portfolio_skills(){
        $labels = array(
            'name' => _x('Portfolio Skills', 'Portfolio Skills', 'ahura'),
            'singular_name' => _x('Portfolio Skill', 'Portfolio Skill', 'ahura'),
            'search_items' => __('Search Skills', 'ahura'),
            'all_items' => __('All Skills', 'ahura'),
            'parent_item' => __('Parent Skill', 'ahura'),
            'parent_item_colon' => __('Parent Skill:', 'ahura'),
            'edit_item' => __('Edit Skill', 'ahura'),
            'update_item' => __('Update Skill', 'ahura'),
            'add_new_item' => __('Add New Skill', 'ahura'),
            'new_item_name' => __('New Skill Name', 'ahura'),
            'menu_name' => __('Skills', 'ahura'),
        );
     
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'portfolio_skills'),
        );
     
        register_taxonomy('portfolio_skills', array('portfolio'), $args);
    }

    public static function register_taxonomy_team_cat(){
        $labels = array(
            'name' => _x('Team Categories', 'Team Categories', 'ahura'),
            'singular_name' => _x('Team Category', 'Team Category', 'ahura'),
            'search_items' => __('Search Categories', 'ahura'),
            'all_items' => __('All Categories', 'ahura'),
            'parent_item' => __('Parent Category', 'ahura'),
            'parent_item_colon' => __('Parent Category:', 'ahura'),
            'edit_item' => __('Edit Category', 'ahura'),
            'update_item' => __('Update Category', 'ahura'),
            'add_new_item' => __('Add Team Category', 'ahura'),
            'new_item_name' => __('New Team Category Name', 'ahura'),
            'menu_name' => __('Categories', 'ahura'),
        );
     
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'team_cat'),
        );
     
        register_taxonomy('team_cat', array('team'), $args);
    }

    public static function register_taxonomy_testimonial() {
        $labels = array(
            'name' => _x('Team Categories', 'Team Categories', 'ahura'),
            'singular_name' => _x('Team Category', 'Team Category', 'ahura'),
            'search_items' => __('Search Categories', 'ahura'),
            'all_items' => __('All Categories', 'ahura'),
            'parent_item' => __('Parent Category', 'ahura'),
            'parent_item_colon' => __('Parent Category:', 'ahura'),
            'edit_item' => __('Edit Category', 'ahura'),
            'update_item' => __('Update Category', 'ahura'),
            'add_new_item' => __('Add Team Category', 'ahura'),
            'new_item_name' => __('New Team Category Name', 'ahura'),
            'menu_name' => __('Categories', 'ahura'),
        );
     
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'testimonial_cat'),
        );
     
        register_taxonomy('testimonial_cat', array('testimonial'), $args);
    }
}
