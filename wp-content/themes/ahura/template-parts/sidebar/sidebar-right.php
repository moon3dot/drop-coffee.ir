<aside class="ahura-sidebar rightsidebar sticky_sidebar">
    <div class="theiaStickySidebar">
        <?php
        $sidebar->start()->display(); // append content to start
        if(get_theme_mod('ahura_llms_sidebar_position') == 'right'){
            if (!dynamic_sidebar('ahura_llms_primary_sidebar')) : endif;
        }
        if (!dynamic_sidebar('ahura_rightsidebar_widget')) : endif;
        $sidebar->end()->display(); // append content to end
        ?>
    </div>
</aside>