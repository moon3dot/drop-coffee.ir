<aside class="ahura-sidebar sidebar sticky_sidebar">
    <div class="theiaStickySidebar">
        <?php
        $sidebar->start()->display(); // append content to start
        if(get_theme_mod('ahura_llms_sidebar_position') == 'left'){
            if (!dynamic_sidebar('ahura_llms_primary_sidebar')) : endif;
        }
        if (!dynamic_sidebar('ahura_leftsidebar_widget')) : endif; 
        $sidebar->end()->display(); // append content to end
        ?>
    </div>
</aside>