<aside class="ahura-sidebar rightsidebar sticky_sidebar shop-right-sidebar">
    <?php 
    $toggle_status = \ahura\app\mw_options::get_mod_shop_show_filters_button_toggle();
    if($toggle_status):
        $text = get_theme_mod('filters_button_toggle_text');
        $text = !empty($text) ? $text : esc_html__('Products filter', 'ahura');
    ?>
    <div class="shop-page-sidebar-toggle">
        <i class="fas fa-filter"></i>
        <span><?php echo $text ?></span>
    </div>
    <?php endif; ?>
    <div class="theiaStickySidebar shop-page-sidebar <?php echo $toggle_status ? ' enabled-toggle' : '' ?>">
        <?php 
        $sidebar->start()->display(); // append content to start
        if (!dynamic_sidebar('ahura_shop_right_widget')) : endif;
        $sidebar->end()->display(); // append content to end
        ?>
    </div>
</aside>