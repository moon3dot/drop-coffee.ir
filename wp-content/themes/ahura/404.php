<?php get_header(); ?>
<?php 
if(\ahura\app\mw_options::get_mod_is_active_custom_404_page()):
    $page_id = \ahura\app\mw_options::get_mod_custom_404_page_id();
    echo ahura_render_elementor_builder_content($page_id);
else:
?>
    <section class="site-container page-404">
        <section style="width:100%"  class="post-box">
        <article class="post-entry">
        <header class="post-title">
        <?php if(get_theme_mod('ahura_404_show_text',true)):?>
        <h2><a href="#"><?php echo get_theme_mod('ahura_404_text') ? get_theme_mod('ahura_404_text') : __('Page Not Found!','ahura');?></a></h2>
        <?php endif;?>
        </header>
        <?php if(get_theme_mod('ahura_404_show_image',true)):?>
        <img src="<?php echo get_theme_mod('ahura_404_image') ? get_theme_mod('ahura_404_image') : get_template_directory_uri() . '/img/404.svg'?>" alt="404">
        <?php endif;?>
        <?php if(get_theme_mod('ahura_404_show_go_home')):?>
        <div class="clear"></div>
        <a class="go-home-404" href="<?php echo get_theme_mod('ahura_404_go_home_url') ? get_theme_mod('ahura_404_go_home_url') : '#';?>"><?php echo get_theme_mod('ahura_404_go_home_text');?></a>
        <?php endif;?>
        </article>
        </section>
        <div class="clear"></div>
    </section>
<?php 
endif;
get_footer();