<?php
namespace ahura\app;

use ahura\app\license;

class ajax
{
    static function update_mini_cart_btn()
    {
        $mode = isset($_POST['mode']) && $_POST['mode'] ? $_POST['mode'] : 1;
        $mini_cart_btn = \ahura\app\mini_cart::get_mini_cart_btn_html($mode);
        $res['edit']['#mcart-stotal'] = $mini_cart_btn;
        die(json_encode($res));
    }

    static function update_mini_cart2_element()
    {
        $product_id = $_POST['product_id'];
        $item_key = isset($_POST['item_key']) ? $_POST['item_key'] : null;
        if($product_id && $item_key && isset($_POST['delete_product']) && $_POST['delete_product'] == true){
            \WC()->cart->remove_cart_item($item_key);
        }
        include get_template_directory() . '/template-parts/loop/elementor/mini-cart2-load-ajax.php';
        wp_die();
    }

    static function search_result()
    {
        $template = isset($_POST['template']) && !empty($_POST['template']) ? sanitize_text_field($_POST['template']) : null;
        $show_thumb = isset($_POST['show_thumb']) && !empty($_POST['show_thumb']) ? $_POST['show_thumb'] == true : null;
        $show_price = isset($_POST['show_price']) && !empty($_POST['show_price']) ? $_POST['show_price'] == true : null;

        $keyword = isset($_POST['keyword']) && $_POST['keyword'] ? esc_attr($_POST['keyword']) : false;
        $post_type = isset($_POST['post_type']) && !empty($_POST['post_type']) ? $_POST['post_type'] : null;
        $args = [
            's' => $keyword,
            'posts_per_page' => get_theme_mod('ajax_search_results_number'),
            'post_status' => 'publish'
        ];

        if(get_theme_mod('ahura_search_in_product')){
            $args['post_type'] = 'product';
        }

        if(!in_array($post_type, ['default', 'all']) && !empty($post_type)){
            $args['post_type'] = $post_type;
        }

        $res = new \WP_Query($args);
        if ($res->have_posts()) {
            while ($res->have_posts()) {
                $res->the_post();
                $product = woocommerce::is_active() ? wc_get_product(get_the_ID()) : null;
                $thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                ?>
                <?php if ($template == 2): ?>
                    <div class="search-item">
                        <a href="<?php echo get_the_permalink() ?>">
                            <?php if ($show_thumb && !empty($thumbnail)): ?>
                            <div class="item-cover">
                                <?php echo $thumbnail ?>
                            </div>
                            <?php endif; ?>
                            <div class="item-details">
                                <div class="item-title"><?php echo get_the_title() ?></div>
                                <?php if ($show_price && is_object($product)): ?>
                                    <div class="item-price"><?php echo wc_price($product->get_price()) ?></div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo get_the_permalink() ?>"><?php echo get_the_title() ?></a>
                <?php endif; ?>
            <?php }
        } else {
            echo '<p>' . __("Nothing Found!", "ahura") . '</p>';
        }
        die;
    }


    /**
     *
     *
     * Ajax request callback for product_tab elementor widget
     *
     * Tabs button
     *
     */
    public static function ahura_product_tab_ajax_callback()
    {
        $settings = json_decode(base64_decode($_POST['settings']), 1);
        $args = array('post_type' => 'product', 'posts_per_page' => $settings['num'], 'post_status' => 'publish');

        if ($settings['category']) {
            $args['tax_query'] = array('tax_query' => ['relation' => 'OR', ['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $settings['category']]]);
        }

        $products = new \WP_Query($args);

        if ($products->have_posts()):
            while ($products->have_posts()): $products->the_post();
                global $product;
                include get_template_directory() . '/template-parts/loop/elementor/product-tab-load-ajax.php';
            endwhile;
            wp_reset_query();
            wp_reset_postdata();

        else:
            echo sprintf('<div class="col-12"><div class="mw_element_error">%s</div></div>', esc_html__('Sorry,no products were found for display.', 'ahura'));
        endif;
        wp_die();
    }

    /**
     *
     *
     * Ajax request callback Load products for product_tab elementor widget
     *
     * view all button
     *
     */
    public static function ahura_load_product_tab_ajax_callback()
    {
        $settings = json_decode(base64_decode($_POST['settings']), 1);
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $settings['num'],
            'post_status' => 'publish',
            'paged' => $_POST['paged'],
        );

        if ($settings['category']) {
            $args['tax_query'] = array('tax_query' => ['relation' => 'OR', ['taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $settings['category']]]);
        }

        $products = new \WP_Query($args);

        if ($products->have_posts()):
            while ($products->have_posts()): $products->the_post();
                global $product;
                include get_template_directory() . '/template-parts/loop/elementor/product-tab-load-ajax.php';
            endwhile;
            wp_reset_query();
            wp_reset_postdata();
        endif;
        wp_die();
    }

    static function get_sections(){
        check_ajax_referer('ahura_nonce', 'nonce');
        $cls = new \ahura\app\elementor\Ahura_Elementor_Builder();
        $type = isset($_POST['type']) ? $_POST['type'] : null;
        $template = isset($_POST['template_type']) ? $_POST['template_type'] : null;
        $params = [];
        $sections = null;
        if($type){
            if ($type == 'page'){
                $sections = $cls->getPages($template, $_POST['post_id']);
            } else {
                $sections = $type == 'header' ? $cls->getHeaders($_POST['post_id']) : $cls->getFooters($_POST['post_id']);
            }
        }
        wp_send_json(['items' => $sections, 'count' => ($sections) ? count($sections) : 0, 's' => $_POST]);
    }

    /**
     *
     *
     * Ajax request callback for post_grid_tab (1) elementor widget
     *
     *
     */
    public static function ahura_post_grid_tab_ajax_callback()
    {
        $settings = json_decode(base64_decode($_POST['settings']), 1);
        $items = [];
        $args = array('post_type' => $settings['post_type'], 'posts_per_page' => $settings['num'], 'post_status' => 'publish');

        if ($settings['category']) {
            $args['tax_query'] = array(
                'tax_query' => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => $settings['taxonomy'],
                        'field' => 'term_id',
                        'terms' => $settings['category'],
                    ]
                ]
            );
        }

        $posts = new \WP_Query($args);
        $colors = ['red', 'violet', 'yellow', 'blue'];

        if ($posts->have_posts()) {
            foreach ($posts->get_posts() as $post) {
                $date = get_the_modified_date('', $post->ID);
                $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $settings['thumb']);
                $color = array_rand($colors, 1);
                $selected_color = $colors[$color];
                //unset($colors[$color]);
                $items[$post->ID] = [
                    'thumb' => (isset($img[0])) ? $img[0] : '',
                    'date' => $date,
                    'title' => $post->post_title,
                    'post_link' => get_the_permalink($post->ID),
                    'sm' => $settings['sm'], // show meta option
                    'color' => $selected_color,
                ];
            }

            wp_send_json([
                'status' => 'success',
                'items' => $items
            ]);
        } else {
            wp_send_json([
                'status' => 'error',
                'msg' => __('Sorry,no posts were found for display.', 'ahura')
            ]);
        }
    }

    /**
     *
     *
     *  Customizer reset callback
     *
     *
     */
    static function customizer_reset()
    {
        global $wp_customize, $options;

        if (!$wp_customize->is_preview()) {
            wp_send_json_error('not_preview');
        }

        if (!check_ajax_referer('ahura-customizer-reset', 'nonce', false)) {
            wp_send_json_error('invalid_nonce');
        }

        \ahura\app\customization\Customizer::reset();

        wp_send_json_success();
    }

    /**
     *
     * Posts like
     *
     * @return void
     */
    public static function post_like_ajax_callback(){
        if (!check_ajax_referer('ahura_nonce', 'nonce', false)) {
            wp_send_json_error('invalid_nonce');
        }

        $save_meta = \ahura\app\mw_options::get_mod_post_like_save_data_for_user();
        $user_id = get_current_user_id();

        $post_id = $_POST['pid'];
        $is_like = (bool) $_POST['is_like'];

        if(!intval($post_id) || get_post_status($post_id) !== 'publish'){
            wp_send_json([
                'status' => 'error',
                'msg' => __('Invalid Request!', 'ahura')
            ]);
        }

        if($save_meta && is_user_logged_in()){
            $is_liked = (bool) get_user_meta($user_id, 'post_liked_' . $post_id, true);
            $is_disliked = (bool) get_user_meta($user_id, 'post_disliked_' . $post_id, true);
            if($is_like){
                if($is_liked){
                    wp_send_json([
                        'status' => 'warning',
                        'msg' => __('You have already liked the post.', 'ahura')
                    ]);
                }
            } else {
                if($is_disliked){
                    wp_send_json([
                        'status' => 'warning',
                        'msg' => __('You have already disliked the post.', 'ahura')
                    ]);
                }
            }
        }

        if($is_like){
            $like = ahura_update_post_likes($post_id);
            if($_POST['is_disliked'] == 'true'){
                $dislike = ahura_update_post_dislikes($post_id, '-');
            }

            if($like){
                $result = [
                    'status' => 'success',
                    'msg' => __('You did like the post', 'ahura'),
                    'isLike' => true,
                ];

                if($save_meta){
                    if(is_user_logged_in()){
                        $save_like = update_user_meta($user_id, 'post_liked_' . $post_id, true);
                        $save_dislike = update_user_meta($user_id, 'post_disliked_' . $post_id, false);
                    }
                }
            } else {
                $result = [
                    'status' => 'error',
                    'msg' => __('It has already been done', 'ahura'),
                    'isLike' => true,
                ];
            }
        } else {
            if($_POST['is_liked'] == 'true'){
                $like = ahura_update_post_likes($post_id, '-');
            }
            $dislike = ahura_update_post_dislikes($post_id);

            if($dislike){
                $result = [
                    'status' => 'success',
                    'msg' => __('You did dislike the post', 'ahura'),
                    'isDisLike' => true,
                ];
                if($save_meta){
                    if(is_user_logged_in()){
                        $save_dislike = update_user_meta($user_id, 'post_disliked_' . $post_id, true);
                        $save_like = update_user_meta($user_id, 'post_liked_' . $post_id, false);
                    }
                }
            } else {
                $result = [
                    'status' => 'error',
                    'msg' => __('It has already been done', 'ahura'),
                    'isDisLike' => true,
                ];
            }
        }

        if(isset($result['status']) && $result['status'] === 'success'){
            $likes = ahura_get_post_likes($post_id);
            $dislikes = ahura_get_post_dislikes($post_id);
            $result['likes'] = intval($likes) ? $likes : '0';
            $result['dislikes'] = intval($dislikes) ? $dislikes : '0';
        }

        wp_send_json($result);
    }

    public static function mailer_lite_user_subscribe(){
        $api_key = base64_decode($_POST['k']);
        $mailerlite = new \ahura\app\mailerlite\MailerLite_User_Subscribers($api_key);
        $fields = $_POST['fields'];

        $add_subscriber = $mailerlite->addSubscriber([
            'email' => $fields['email'],
            'fields' => $fields ?? '',
            'status' => 'active'
        ]);

        if($add_subscriber){
            $res = [
                'status' => 'success'
            ];
        } else {
            $res = [
                'status' => 'error'
            ];
        }
        wp_send_json($res);
    }

    /**
     *
     *
     * Ajax request callback for team_members elementor widget
     *
     * Tabs button
     *
     */
    public static function team_members_ajax_callback()
    {
        $settings = json_decode(base64_decode($_POST['settings']), 1);
        $args = array('post_type' => 'team', 'posts_per_page' => $settings['num'], 'post_status' => 'publish');

        if ($settings['category']) {
            $args['tax_query'] = array('tax_query' => ['relation' => 'OR', ['taxonomy' => 'team_cat', 'field' => 'term_id', 'terms' => $settings['category']]]);
        }

        if ($settings['show_pagination'] && (isset($_POST['page_num']) && intval($_POST['page_num']))) {
            $args['paged'] = $_POST['page_num'];
        }

        $teachers = new \WP_Query($args);

        if ($teachers->have_posts()):
            while ($teachers->have_posts()): $teachers->the_post();
                include get_template_directory() . '/template-parts/loop/elementor/team-members-tab-load-ajax.php';
            endwhile;
            wp_reset_query();
            wp_reset_postdata();
            ?>
            <?php if($settings['show_pagination'] && $teachers->found_posts && (isset($_POST['page_num']) && intval($_POST['page_num']))): ?>
            <div class="ahura-pagination aj">
                <?php ahura_custom_pagination($teachers->found_posts, $settings['num'], $_POST['page_num'], null, '<i class="fas fa-angle-right"></i>', '<i class="fas fa-angle-left"></i>'); ?>
            </div>
        <?php endif; ?>
        <?php
        else:
            echo sprintf('<div class="col-12"><div class="mw_element_error">%s</div></div>', esc_html__('Sorry,no team members were found for display.', 'ahura'));
        endif;
        wp_die();
    }

    /**
     *
     *
     * Change theme license status
     *
     *
     */
    public static function change_license_ajax_callback(){
        check_ajax_referer('ahura_nonce', 'ahura_nonce');

        $license_key = isset($_POST['ahura_license_key']) ? sanitize_text_field($_POST['ahura_license_key']) : false;
        $selected_status = isset($_POST['selected_status']) ? intval($_POST['selected_status']) : null;

        if(!empty($license_key)){
            if($selected_status === 1){
                $server_res = license::activate_license_on_server($license_key);
                if($server_res){
                    license::deactivate_license_in_local();
                    license::update_license_key($license_key);
                    license::activate_license_in_local();
                    $result = [
                        'status' => 'success',
                        'msg' => __('License activation was done successfully.', 'ahura')
                    ];
                } else {
                    $result = [
                        'status' => 'error',
                        'log' => 'invalid',
                        'msg' => esc_html__('License key is invalid or the number of activation has exceeded the allowed limit.', 'ahura')
                    ];
                }
            } elseif($selected_status === 0) {
                $server_res = license::deactivate_license_on_server();
                if($server_res){
                    license::deactivate_license_in_local();
                    $result = [
                        'status' => 'success',
                        'msg' => __('License deactivation was done successfully.', 'ahura')
                    ];
                } else {
                    $result = [
                        'status' => 'error',
                        'log' => 'invalid',
                        'msg' => __('An error occurred, check the license and try again.', 'ahura')
                    ];
                }
            } else {
                $result = [
                    'status' => 'error',
                    'msg' => __('An error occurred, check the license and try again.', 'ahura')
                ];
            }
        } else {
            $result = [
                'status' => 'error',
                'log' => 'invalid',
                'msg' => __('The license key is invalid.', 'ahura')
            ];
        }

        wp_send_json($result);
    }

    /**
     *
     *  User ajax login
     *
     */
    public static function user_login(){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(is_user_logged_in()){
            wp_send_json([
                'status' => 'info',
                'msg' => __('You are is logged in.', 'ahura')
            ]);
        }

        if(!username_exists($username)){
            wp_send_json([
                'status' => 'error',
                'msg' => __('Invalid username or password.', 'ahura')
            ]);
        }

        $user = get_user_by('login', $username);

        if($user && !wp_check_password($password, $user->data->user_pass, $user->ID)){
            wp_send_json([
                'status' => 'error',
                'msg' => __('Check the entered data and try again', 'ahura')
            ]);
        }

        $signon = wp_signon([
            'user_login' => $username,
            'user_password' => $password,
            'remember' => true
        ], (function_exists('is_ssl') ? is_ssl() : false));

        if(!is_wp_error($signon)){
            $result = [
                'status' => 'success',
                'msg' => __('Log in, please wait...', 'ahura'),
            ];
        } else {
            $result = [
                'status' => 'error',
                'msg' => __('Invalid username or password.', 'ahura'),
            ];
        }

        wp_send_json($result);
    }

    /**
     *
     * User ajax register
     *
     */
    public static function user_register(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        if(is_user_logged_in()){
            wp_send_json([
                'status' => 'info',
                'msg' => __('You are is logged in.', 'ahura')
            ]);
        }

        if(empty($username) || empty($password) || empty($email)){
            wp_send_json([
                'status' => 'error',
                'msg' => __('Complete all required entries', 'ahura')
            ]);
        }

        if(username_exists($username)){
            wp_send_json([
                'status' => 'error',
                'msg' => __('The username has already been registered.', 'ahura')
            ]);
        }

        if(email_exists($email)){
            wp_send_json([
                'status' => 'error',
                'msg' => __('The email address is already registered.', 'ahura')
            ]);
        }

        $user_data = [
            'user_login' => $username,
            'user_pass' => $password,
            'user_email' => $email,
            'role' => !empty(get_option('default_role')) ? get_option('default_role') : 'subscriber',
            'show_admin_bar_front' => false
        ];

        $user_id = wp_insert_user($user_data);

        if(!is_wp_error($user_id)){
            $result = [
                'status' => 'success',
                'msg' => __('Registration successful.', 'ahura'),
            ];

            if(\ahura\app\mw_options::get_mod_auto_login_after_register()){
                $result['auto_login'] = true;
            }

            do_action('user_register', $user_id, $user_data);
        } else {
            $result = [
                'status' => 'error',
                'msg' => __('An error occurred, check the entries data.', 'ahura')
            ];
        }

        wp_send_json($result);
    }

    /**
     *
     * User ajax reset password
     *
     */
    public static function user_resetpass(){
        $username = $_POST['username'];

        if(!username_exists($username)){
            wp_send_json([
                'status' => 'error',
                'msg' => __('The username entered is invalid.', 'ahura')
            ]);
        }

        $send = retrieve_password($username);

        if($send){
            $result = [
                'status' => 'success',
                'msg' => __('The new password has been sent to the user email.', 'ahura')
            ];
        } else {
            $result = [
                'status' => 'error',
                'msg' => __('Request failed, please try again', 'ahura')
            ];
        }

        wp_send_json($result);
    }

    public static function grid_posts10_ajax_callback(){
        $settings = json_decode(base64_decode($_POST['settings']), 1);
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['posts_per_page'],
            'post_status' => 'publish',
        );

        $chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;

        if ((isset($settings['show_pagination']) && $settings['show_pagination']) && isset($_POST['page_num']) && intval($_POST['page_num'])) {
            $args['paged'] = $_POST['page_num'];
        }

        if($_POST['category'] > 0){
            $args['cat'] = (int) $_POST['category'];
        }

        $posts = new \WP_Query($args);

        if ($posts->have_posts()):
            echo "<div class='row'>";
            include get_template_directory() . '/template-parts/loop/elementor/grid-posts10-load-ajax.php';
            echo "</div>";
            ?>
            <?php if((isset($settings['show_pagination']) && $settings['show_pagination']) && $posts->found_posts): ?>
            <div class="ahura-pagination aj">
                <?php ahura_custom_pagination($posts->found_posts, $settings['posts_per_page'], $_POST['page_num'], null, '<i class="fas fa-angle-right"></i>', '<i class="fas fa-angle-left"></i>'); ?>
            </div>
        <?php endif; ?>
        <?php
        else:
            echo sprintf('<div class="col-12"><div class="mw_element_error">%s</div></div>', esc_html__('Sorry, no posts were found for display.', 'ahura'));
        endif;
        wp_die();
    }

    /**
     *
     *
     * Ajax request callback for gallery elementor widget
     *
     *
     */
    public static function gallery_ajax_callback()
    {
        $settings = json_decode(base64_decode($_POST['settings']), 1);
        $args = array(
            'post_type' => 'attachment',
            'posts_per_page' => $settings['posts_per_page'],
            'post_status' => 'any',
            'post__in' => $settings['post__in'],
        );

        if ((isset($settings['show_pagination']) && $settings['show_pagination']) && isset($_POST['page_num']) && intval($_POST['page_num'])) {
            $args['paged'] = $_POST['page_num'];
        }

        $posts = new \WP_Query($args);

        if ($posts->have_posts()):
            echo "<div class='row'>";
            while ($posts->have_posts()): $posts->the_post();
                include get_template_directory() . '/template-parts/loop/elementor/gallery-load-ajax.php';
            endwhile;
            echo "</div>";
            wp_reset_query();
            wp_reset_postdata();
            ?>
            <?php if((isset($settings['show_pagination']) && $settings['show_pagination']) && $posts->found_posts && (isset($_POST['page_num']) && intval($_POST['page_num']))): ?>
            <div class="ahura-pagination aj">
                <?php ahura_custom_pagination($posts->found_posts, $settings['posts_per_page'], $_POST['page_num'], null, '<i class="fas fa-angle-right"></i>', '<i class="fas fa-angle-left"></i>'); ?>
            </div>
        <?php endif; ?>
        <?php
        else:
            echo sprintf('<div class="col-12"><div class="mw_element_error">%s</div></div>', esc_html__('Sorry,no gallery were found for display.', 'ahura'));
        endif;
        wp_die();
    }
    static function createChildTheme()
    {
        $res = [
            'code' => 400,
            'msg' => __('Has error', 'ahura')
        ];

        set_theme_mod('ahura_move_customizer_to_child_theme', (isset($_POST['move_customizer']) && $_POST['move_customizer'] == true));

        $createChildTheme = child_theme::createChildTheme();
        if(!$createChildTheme)
        {
            $res['msg'] = __('Has problem in creating child theme', 'ahura');
            wp_send_json($res);
        }
        // check is child theme active
        $currentTheme = wp_get_theme()->get_stylesheet();
        if($currentTheme !== 'ahura-child')
        {
            $res['msg'] = __("Child theme created but you must activate it from themes page", 'ahura');
            wp_send_json($res);
        }
        $res['msg'] = __('Child theme successfully generated', 'ahura');
        $res['code'] = 200;
        wp_send_json($res);
    }

    public static function createSectionBuilderTemplate(){
        check_ajax_referer('ahura_nonce', 'nonce');

        $data = $_POST;
        $section_type = $data['section_type'];
        $template_page = $data['template_page'];
        $set_default = isset($data['set_default']) && ($data['set_default'] == 'true' || $data['set_default'] == '1');
        $is_header__footer = in_array($section_type, ['header', 'footer']);

        $insert_id = wp_insert_post([
            'post_title' => $data['section_title'],
            'post_type' => 'section_builder',
            'post_status' => 'publish',
            'meta_input' => [
                'section_builder_type' => $section_type,
                'section_builder_template_page' => $template_page
            ]
        ]);

        if ($insert_id){
            if ($set_default){
                if ($section_type == 'header'){
                    set_theme_mod('use_custom_header', true);
                    set_theme_mod('custom_header', $insert_id);
                } elseif($section_type == 'footer'){
                    set_theme_mod('use_custom_footer', true);
                    set_theme_mod('custom_footer', $insert_id);
                } elseif ($template_page == 'error-404'){
                    set_theme_mod('use_custom_404_page', true);
                    set_theme_mod('custom_404_page', $insert_id);
                } elseif ($template_page == 'archive'){
                    set_theme_mod('use_custom_archive', true);
                    set_theme_mod('custom_archive_page', $insert_id);
                }
            }

            $metas = [
                '_elementor_edit_mode' => 'builder',
                '_wp_page_template' => $is_header__footer ? 'elementor_canvas' : 'elementor_header_footer',
                '_elementor_template_type' => $is_header__footer ? $section_type : 'wp-page',
            ];

            foreach ($metas as $meta_key => $meta_value){
                update_post_meta($insert_id, $meta_key, $meta_value);
            }

            wp_send_json_success([
                    'redirect' => add_query_arg([
                        'action' => 'elementor',
                        'section_type' => $section_type
                    ], remove_query_arg('action', get_edit_post_link($insert_id, null)))
            ]);
        } else {
            wp_send_json_error();
        }
    }

    public static function handle_quick_view_product_data(){
        $product_id = $_POST['product_id'];

        if (!woocommerce::is_active())
            die();

        $query = new \WP_Query([
            'post_type' => ['product', 'product_variation'],
            'post_status' => 'publish',
            'p' => $product_id
        ]);

        if($query->have_posts()){
            while ($query->have_posts()){
                $query->the_post();
                global $product;

                WC_Quick_View::render_template(['product' => $product]);
            }
        }
        wp_reset_postdata();

        wp_die();
    }
}