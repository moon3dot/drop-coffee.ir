<aside class="ahura-sidebar sidebar sticky_sidebar">
    <div class="theiaStickySidebar">
        <?php 
        $sidebar->start()->display(); // append content to start
        if (!dynamic_sidebar('ahura_product_left_widget')) : endif;
        $sidebar->end()->display(); // append content to end
        ?>
    </div>
</aside>