<?php
$theme_columns = (get_theme_mod('ahura_single_product_loop_style') == "digikala") && is_single() ? 'full-width-container' : \ahura\app\mw_options::get_theme_columns();
$sidebar = \ahura\app\Ahura_Sidebar_Controller::getInstance();

get_header(); ?>
<section class="site-container ahura-<?php echo $theme_columns; ?>-column ahura-post-single woocommerce <?php echo is_rtl() ? 'mw_rtl' : 'mw_ltr'; ?>">
  <div class="wrapper">
    <?php
    if ($theme_columns == '2cr') :
      $sidebar->col('2cr')->display(); // right sidebar
    endif;
    ?>
    <section class="post-box<?php echo (get_theme_mod('ahura_single_product_loop_style') == "digikala") && is_single() ? ' product-page-digikala-container' : ''; ?>">
      <?php
      if ($theme_columns == '3c') :
        $sidebar->col('3c')->display(); // right sidebar
      endif;
      ?>
      <div class="content">
        <div class="theiaStickySidebar">
          <div class="ahura_woocommerce_content_wrapper">
            <?php if(is_single() && get_theme_mod('show_single_product_breadcrumb')): ?>
                <div class="<?php echo get_theme_mod('ahura_single_product_loop_style') == 'digikala' ? 'breadcrumb-digi pb-4' : 'bread-crumb2' ?>">
                  <?php woocommerce_breadcrumb(); ?>
                </div>
            <?php endif; ?>
            <?php if(!is_single() && get_theme_mod('show_woocommerce_breadcrumb')): ?>
                <div class="bread-crumb2">
                  <?php woocommerce_breadcrumb(); ?>
                </div>
            <?php endif; ?>
            <?php woocommerce_content(); ?>
          </div>
        </div>
      </div>
    </section>
    <?php
    if ($theme_columns == '2c' || $theme_columns == '3c') :
      $sidebar->col(['2c', '3c'])->display(); // left sidebar
    endif;
    ?>
    <div class="clear"></div>
  </div>
</section>
<?php get_footer(); ?>