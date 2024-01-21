<aside class="ahura-sidebar rightsidebar sticky_sidebar">
    <div class="theiaStickySidebar">
    <?php 
        $sidebar->start()->display(); // append content to start
        if (!dynamic_sidebar('ahura_product_right_widget')) : endif;
        $sidebar->end()->display(); // append content to end
        ?>
    </div>
</aside>