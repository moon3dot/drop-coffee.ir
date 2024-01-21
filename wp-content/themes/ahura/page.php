<?php

use ahura\app\mw_options;
use ahura\app\woocommerce;

$theme_columns = mw_options::get_theme_columns();
$sidebar = \ahura\app\Ahura_Sidebar_Controller::getInstance();

get_header(); ?>
<?php $is_woocommerce_page = woocommerce::is_woocommerce_page(); ?>
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
  <?php if ( !$is_woocommerce_page && mw_options::page_has_breadcsrumb()) :?>
    <?php if(get_theme_mod('breadcrumb') == 'one'): ?>
      <?php include get_template_directory() .'/template-parts/single/bread-crumb.php'; ?>
    <?php endif; ?>
  <?php endif; ?>
<section class="site-container ahura-<?php echo $theme_columns;?>-column ahura-post-single ahura-page-single <?php echo is_rtl() ? 'mw_rtl' : 'mw_ltr'; ?>">
<?php 
if ($theme_columns == '2cr'):
  $sidebar->col('2cr')->display(); // right sidebar
endif;
?>
<section class="post-box">
<?php 
if ($theme_columns == '3c'):
  $sidebar->col('3c')->display(); // right sidebar
endif;
?>
  <?php if (!$is_woocommerce_page && mw_options::page_has_breadcsrumb()) :?>
    <?php if(get_theme_mod('breadcrumb') == 'two'): ?>
      <?php include get_template_directory() .'/template-parts/single/bread-crumb2.php'; ?>
    <?php endif; ?>
  <?php endif; ?>
<article class="post-entry post-entry-custom post-custom">
<header class="post-title">
<h1><?php the_title(); ?></h1>
</header>
<?php the_content(''); ?>
</article>
<?php 
  if(\ahura\app\mw_options::get_mod_show_page_comment() && comments_open()){
    echo '<div class="post-entry">';
    comments_template();
    echo '</div>';
  }
?>
</section>
<?php endwhile; ?>
<?php endif; ?>
<?php 
if ($theme_columns == '2c' || $theme_columns == '3c'):
  $sidebar->col(['2c', '3c'])->display(); // left sidebar
endif;
?>
<div class="clear"></div>
</section>
<?php get_footer(); ?>
