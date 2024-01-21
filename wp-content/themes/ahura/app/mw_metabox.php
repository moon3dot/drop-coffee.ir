<?php
namespace ahura\app;
use ahura\app\traits\Singleton;

class mw_metabox
{
    use Singleton;
    public function __construct()
    {
        add_action('add_meta_boxes_testimonial', [$this, 'testimonial_init']);
        add_action('save_post_testimonial', [$this, 'store_testimonial_metabox']);
        add_action('add_meta_boxes_page', [$this, 'pages_init']);
        add_action('add_meta_boxes', [$this, 'posts_init']);
        add_action('save_post_page', [$this, 'store_page_metaboxes_data']);
        add_action('save_post', [$this, 'hide_thumbnail_save'] );
        add_action('save_post', [$this, 'ahura_fonts_variations_box_save'] );
        add_action('save_post', [$this, '_custom_meta_box_save']);
    }

    public function testimonial_init()
    {
        add_meta_box('testimonial_author', __("Author", 'ahura'), [__CLASS__, 'testimonial_author'], 'testimonial', 'side');
    }
    public function pages_init()
    {
        add_meta_box('ahura_header', __('Header Options', 'ahura'), [__CLASS__, 'header_metabox_c'], 'page', 'side');
        add_meta_box('ahura_page_breadcrumb', __("Breadcrumb", 'ahura'), [__CLASS__, 'page_breadcrumb_c'], 'page', 'side');
    }
    public function posts_init()
    {
        add_meta_box('hide_thumbnail_box', __("Hide Thumbnail", 'ahura'), [__CLASS__, 'hide_thumbnail'], 'post');
        add_meta_box('ahura_fonts_variations_box', __("Font Variations", 'ahura'), [__CLASS__, 'ahura_fonts_variations_box'], 'ahura_fonts');
        add_meta_box('portfolio_meta_box', __("Portfolio Information", 'ahura'), [__CLASS__, 'portfolio_meta_box'], 'portfolio');
        add_meta_box('team_member_meta_box', __("Team Member Information", 'ahura'), [__CLASS__, 'team_member_meta_box'], 'team');
    }
    static function testimonial_author($post)
    {
        $username = \ahura\app\mw_options::get_testimonial_username($post->ID);
        $sitename = \ahura\app\mw_options::get_testimonial_sitename($post->ID);
        ?>
        <p>
            <label for="mw_testimonial_username"><?php _e("User Displayname:", 'ahura');?></label>
        </p>
        <p>
            
            <input id="mw_testimonial_username" value="<?php echo $username ? $username : false?>" type="text" placeholder="e.g. John Doe" name="mw_testimonial_username">
        </p>
        <p>
            <label for="mw_testimonial_user_sitename"><?php _e("User Site Name:", 'ahura');?></label>
        </p>
        <p>
            <input type="text" value="<?php echo $sitename ? $sitename : '';?>" id="mw_testimonial_user_sitename" placeholder="e.g. Mihan Wordpress" name="mw_testimonial_user_sitename">
        </p>
        <?php
    }
    static function header_metabox_c($post)
    {
        $pid = $post->ID;
        $is_sticky_mode = mw_options::get_page_is_sticky_header($pid);
        $is_transparent_mode = mw_options::get_page_is_transparent_header($pid);
        $is_float_mode = mw_options::get_page_is_float_mode_header($pid);
        ?>
        <div id="ahura_header_sticky_options">
            <h3><?php esc_html_e('Sticky mode', 'ahura')?></h3>
            <p>
                <input checked type="radio" name="ahura_sticky_header" id="ahura_sticky_header_default" value="0">
                <label for="ahura_sticky_header_default"><?php _e("Default", 'ahura');?></label>
            </p>
            <p>
                <input <?php checked(1, $is_sticky_mode)?> type="radio" name="ahura_sticky_header" id="ahura_sticky_header_active" value="active">
                <label for="ahura_sticky_header_active"><?php _e("Active", 'ahura');?></label>
            </p>
            <p>
                <input <?php checked(2, $is_sticky_mode)?> type="radio" name="ahura_sticky_header" id="ahura_sticky_header_inactive" value="inactive">
                <label for="ahura_sticky_header_inactive"><?php _e("Inactive", 'ahura');?></label>
            </p>
        </div>
        <div id="ahura_header_transparency_options">
            <h3><?php esc_html_e('Transparency', 'ahura')?></h3>
            <p>
                <input checked type="radio" name="ahura_transparent_header" value="0" id="ahura_transparent_header_default">
                <label for="ahura_transparent_header_default"><?php esc_html_e('Default', 'ahura')?></label>
            </p>
            <p>
                <input <?php checked(1, $is_transparent_mode)?> type="radio" name="ahura_transparent_header" id="ahura_transparent_header_active" value="active">
                <label for="ahura_transparent_header_active"><?php _e("Active", 'ahura');?></label>
            </p>
            <p>
                <input <?php checked(2, $is_transparent_mode)?> type="radio" name="ahura_transparent_header" id="ahura_transparent_header_deactive" value="deactive">
                <label for="ahura_transparent_header_deactive"><?php _e("Inactive", 'ahura');?></label>
            </p>
        </div>
        <div id="ahura_header_float_mode">
            <h3><?php esc_html_e('Float Mode', 'ahura')?></h3>
            <p>
                <input <?php checked($is_float_mode, 0);?> type="radio" id="ahura_float_mode_header_inactive" value="0" name="ahura_float_mode_header">
                <label for="ahura_float_mode_header_inactive"><?php esc_html_e('Inactive', 'ahura')?></label>
            </p>
            <p>
                <input <?php checked($is_float_mode, 1);?> type="radio" name="ahura_float_mode_header" id="ahura_float_mode_header_active" value="active">
                <label for="ahura_float_mode_header_active"><?php esc_html_e('Active', 'ahura')?></label>
            </p>
        </div>
        <?php
    }
    static function hide_thumbnail()
    {
        ?>
        <p>
            <input type="checkbox" id="hide_thumbnail" name="hide_thumbnail" value="check_hide_thumbnail" <?php if ( get_post_meta(get_the_ID(),'hide_thumbnail') !== null ){checked( get_post_meta(get_the_ID(),'hide_thumbnail',true), 'no' );} ?> >
            <label for="hide_thumbnail"><?php echo __('Hide Post Thumbnail','ahura')?></label>
        </p>
        <?php
    }
    public function hide_thumbnail_save($post_id) {
        if( isset( $_POST[ 'hide_thumbnail' ] ) ) {
            update_post_meta( $post_id, 'hide_thumbnail', 'no' );
        } else {
            update_post_meta( $post_id, 'hide_thumbnail', 'yes' );
        }
    }
    static function page_breadcrumb_c($post)
    {
        $current = mw_options::get_page_breadcrumb_status($post->ID);
        ?>
        <p>
            <select name="page_breadcrumb" id="page_breadcrumb">
                <option value="0"><?php _e('Default Settings', 'ahura'); ?></option>
                <option <?php selected('show', $current); ?> value="show"><?php _e('Show Breadcrumb', 'ahura'); ?></option>
                <option <?php selected('hide', $current); ?> value="hide"><?php _e('Hide Breadcrumb', 'ahura');?></option>
            </select>
        </p>
        <?php
    }
    static function ahura_fonts_variations_box(){
        $items = get_post_meta(get_the_ID(), 'font_variations');
        ?>
        <div id="variations">
            <?php
            if($items && array_key_exists(0, $items) && is_array($items[0])):
                foreach($items[0] as $key => $item):
                    $woff = $item['woff']['url'] ?? '';
                    $woff2 = $item['woff2']['url'] ?? '';
                    $ttf = $item['ttf']['url'] ?? '';
                    $svg = $item['svg']['url'] ?? '';
                    $eot = $item['eot']['url'] ?? '';
                ?>
            <div class="var-item" data-num="<?= $key ?>">
                <div class="head">
                    <div class="opt">
                        <label for="font_face[<?= $key ?>][font_weight]"><?= esc_html__('Weight', 'ahura') ?></label>
                        <select name="font_face[<?= $key ?>][font_weight]">
                            <option <?php selected($item['font_weight'], 'normal') ?> value="normal"><?= esc_html__('Normal', 'ahura') ?></option>
                            <option <?php selected($item['font_weight'], 'bold') ?> value="bold"><?= esc_html__('Bold', 'ahura') ?></option>
                            <option <?php selected($item['font_weight'], '100') ?> value="100">100</option>
                            <option <?php selected($item['font_weight'], '200') ?> value="200">200</option>
                            <option <?php selected($item['font_weight'], '300') ?> value="300">300</option>
                            <option <?php selected($item['font_weight'], '400') ?> value="400">400</option>
                            <option <?php selected($item['font_weight'], '500') ?> value="500">500</option>
                            <option <?php selected($item['font_weight'], '600') ?> value="600">600</option>
                            <option <?php selected($item['font_weight'], '700') ?> value="700">700</option>
                            <option <?php selected($item['font_weight'], '800') ?> value="800">800</option>
                            <option <?php selected($item['font_weight'], '900') ?> value="900">900</option>
                        </select>
                    </div>
                    <div class="btns">
                        <a href="#" class="var-action" data-type="edit"><span class="dashicons dashicons-edit"></span> <?= esc_html__('Edit', 'ahura') ?></a>
                        <a href="#" class="var-action var-delete" data-type="delete"><span class="dashicons dashicons-trash"></span> <?= esc_html__('Delete', 'ahura') ?></a>
                    </div>
                </div>
                <div class="vars-list" style="display: none">
                    <div class="vars">
                        <div class="item">
                            <input type="hidden" name="font_face[<?= $key ?>][woff][url]" value="<?= $woff ?>">
                            <span class="dashicons dashicons-no-alt empty-var-field" style="display:<?= ($woff) ? 'inline' : 'none' ?>"></span>
                            <button type="button" class="ahura-font-upload <?= ($woff) ? 'success' : '' ?>">
                                <?= esc_html__('Select WOFF File', 'ahura') ?>
                            </button>
                        </div>
                        <div class="item">
                            <input type="hidden" name="font_face[<?= $key ?>][woff2][url]" value="<?= $woff2 ?>">
                            <span class="dashicons dashicons-no-alt empty-var-field" style="display:<?= ($woff2) ? 'inline' : 'none' ?>"></span>
                            <button type="button" class="ahura-font-upload <?= ($woff2) ? 'success' : '' ?>">
                                <?= esc_html__('Select WOFF2 File', 'ahura') ?>
                            </button>
                        </div>
                        <div class="item">
                            <input type="hidden" name="font_face[<?= $key ?>][ttf][url]" value="<?= $ttf ?>">
                            <span class="dashicons dashicons-no-alt empty-var-field" style="display:<?= ($ttf) ? 'inline' : 'none' ?>"></span>
                            <button type="button" class="ahura-font-upload <?= ($ttf) ? 'success' : '' ?>">
                                <?= esc_html__('Select TTF File', 'ahura') ?>
                            </button>
                        </div>
                        <div class="item">
                            <input type="hidden" name="font_face[<?= $key ?>][svg][url]" value="<?= $svg ?>">
                            <span class="dashicons dashicons-no-alt empty-var-field" style="display:<?= ($svg) ? 'inline' : 'none' ?>"></span>
                            <button type="button" class="ahura-font-upload <?= ($svg) ? 'success' : '' ?>">
                                <?= esc_html__('Select SVG File', 'ahura') ?>
                            </button>
                        </div>
                        <div class="item">
                            <input type="hidden" name="font_face[<?= $key ?>][eot][url]" value="<?= $eot ?>">
                            <span class="dashicons dashicons-no-alt empty-var-field" style="display:<?= ($eot) ? 'inline' : 'none' ?>"></span>
                            <button type="button" class="ahura-font-upload <?= ($eot) ? 'success' : '' ?>">
                                <?= esc_html__('Select EOT File', 'ahura') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
                <?php
                endforeach;
            endif; ?>
        </div>
        <button type="button" class="button add-font-variation"><?= esc_html__('Add Font Variation', 'ahura') ?></button>
        <?php
    }
    public function ahura_fonts_variations_box_save($post_id){
        update_post_meta($post_id, 'font_variations', ($_POST['font_face'] ?? ''));
    }
    public function store_testimonial_metabox($post_id)
    {
        $username = isset($_POST['mw_testimonial_username']) && $_POST['mw_testimonial_username'] ? sanitize_text_field($_POST['mw_testimonial_username']) : false;
        $sitename = isset($_POST['mw_testimonial_user_sitename']) && $_POST['mw_testimonial_user_sitename'] ? sanitize_text_field($_POST['mw_testimonial_user_sitename']) : false;
        if($username)
        {
            \ahura\app\mw_options::set_testimonial_username($post_id, $username);
        }else{
            \ahura\app\mw_options::remove_testimonial_username($post_id);
        }
        if($sitename)
        {
            \ahura\app\mw_options::set_testimonial_sitename($post_id, $sitename);
        }else{
            \ahura\app\mw_options::remove_testimonial_sitename($post_id);
        }
    }
    public function store_page_metaboxes_data($pid)
    {
        self::store_page_header_metabox($pid);
        self::store_page_breadcrumb_metabox($pid);
    }
    static function store_page_header_metabox($pid)
    {
        $is_sticky_mode = isset($_POST['ahura_sticky_header']) && $_POST['ahura_sticky_header'] ? $_POST['ahura_sticky_header'] : false;
        if($is_sticky_mode) {
            $is_sticky_mode_status = $is_sticky_mode == 'active' ? 1 : 2;
            mw_options::set_page_is_sticky_header($pid, $is_sticky_mode_status);
        }
        $is_transparent_mode = isset($_POST['ahura_transparent_header']) && $_POST['ahura_transparent_header'] ? $_POST['ahura_transparent_header'] : false;
        if($is_transparent_mode) {
            $transparency_status = $is_transparent_mode == 'active' ? 1 : 2;
            mw_options::set_page_is_transparent_header($pid, $transparency_status);
        }
        $is_float_mode = isset($_POST['ahura_float_mode_header']) && $_POST['ahura_float_mode_header'] ? $_POST['ahura_float_mode_header'] : false;
        if($is_float_mode) {
            mw_options::set_page_is_float_mode_header($pid);
        }
    }
    static function store_page_breadcrumb_metabox($pid)
    {
        $page_breadcrumb = isset($_POST['page_breadcrumb']) ? $_POST['page_breadcrumb'] : false;
        if(!$page_breadcrumb)
        {
            // set deafult mode
            mw_options::remove_page_show_breadcrumb($pid);

        }
        if($page_breadcrumb == 'show')
        {
            mw_options::set_page_show_breadcrumb($pid);
        }elseif($page_breadcrumb == 'hide'){
            mw_options::set_page_hide_breadcrumb($pid);
        }
    }

    /**
     * 
     * Portfolio post type meta box
     * 
     */
    public static function portfolio_meta_box($post){
        $path = get_theme_file_path("template-parts/admin/meta-boxs/portfolio.php");
        if(file_exists($path) && is_readable($path)){
            include($path);
        }
    }

    public static function team_member_meta_box($post){
        $path = get_theme_file_path("template-parts/admin/meta-boxs/team.php");
        if(file_exists($path) && is_readable($path)){
            include($path);
        }
    }

    public function _custom_meta_box_save($post_id){
        $fields = array(
            '_gallery_images',
            '_gallery_videos',
            '_portfolio_customer_name',
            '_portfolio_website',
            '_portfolio_year',

            '_team_subtitle',
            '_team_video_url',
            '_team_options',
        );
        
        if($fields){
            foreach($fields as $field){
                if(isset($_POST[$field])){
                    update_post_meta($post_id, $field, $_POST[$field]);
                }
            }
        }
    }
}