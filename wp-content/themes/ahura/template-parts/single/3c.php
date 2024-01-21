<?php

use ahura\app\mw_options;
use ahura\app\taxonomies;
$sidebar = \ahura\app\Ahura_Sidebar_Controller::getInstance();

get_header(); ?>
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
 <?php if(get_theme_mod('breadcrumb') == 'one'){
          if(mw_options::page_has_breadcsrumb()){
            include get_template_directory() .'/template-parts/single/bread-crumb.php';
          }
      }
?>

<section class="site-container ahura-3c-column ahura-post-single">
<div class="wrapper">
<section class="post-box content">
<?php $sidebar->col('2cr')->display(); // right sidebar ?>
    <div class="theiaStickySidebar">
  <?php
    if(get_theme_mod('breadcrumb') == 'two'){
      if(mw_options::page_has_breadcsrumb()){
        include get_template_directory() .'/template-parts/single/bread-crumb2.php';
      }
    }
  ?>
<article class="post-entry post-entry-custom post-custom">
<?php if(\ahura\app\mw_options::get_mod_show_single_post_title()): ?>
<header class="post-title">
<h1><?php the_title(); ?></h1>
</header>
<?php endif; ?>
<ul class="post-meta">
  <?php 
  if(\ahura\app\mw_options::get_mod_show_content_types()){
    ahura_html_content_types(get_the_ID());
  }
  ?>
  <?php if ( get_theme_mod( 'single_post_meta_time' ) ) :?>
    <li class="post-date"><i class="fa fa-clock"></i> <?php echo get_the_date('d F Y');?></li>
  <?php endif; ?>
  <?php if ( get_theme_mod( 'show_author' ,true) ) :?>
    <li class="post-author-name"><i class="fa fa-user"></i> <?php the_author(); ?></li>
  <?php endif; ?>
  <?php if ( get_theme_mod( 'show_categories' ,true) ) :?>
    <li class="post-cats"><i class="fa fa-book"></i> <?php the_category(', '); ?></li>
  <?php endif; ?>
  <?php if(get_theme_mod('post-meta-comments') && get_comments_number()): ?>
    <li class="post-comment-count"><i class="fa fa-comments"></i> <?php
    			printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'ahura' ), number_format_i18n( get_comments_number() ) );
    ?></li>
  <?php endif; ?>
  <?php if(get_theme_mod('show_date')):?>
    <li class="post-date"><i class="fa fa-clock"></i> <?php echo get_the_date();?></li>
  <?php endif;?>
  <?php if ( get_theme_mod( 'show_update_date' ) ) :?>
    <li class="post-modified-date">
      <?php if( get_theme_mod( 'post_update_date_text' ) ): ?>
        <i class="<?php echo get_theme_mod( 'post_update_date_icon' ) ? get_theme_mod( 'post_update_date_icon' ) : 'fas fa-history'; ?> pl-1"></i><span class="pl-1"><?php echo get_theme_mod( 'post_update_date_text' ); ?><?php echo the_modified_time('j F Y'); ?></span>
      <?php else: ?>
        <i class="<?php echo get_theme_mod( 'post_update_date_icon' ) ? get_theme_mod( 'post_update_date_icon' ) : 'fas fa-history'; ?> pl-1"></i><?php the_modified_time('j F Y');?>
      <?php endif; ?>
    </li>
  <?php endif; ?>
</ul>
<?php
if ( get_theme_mod('show_star_rating')):
if (empty( get_post_meta( $post->ID, '_post_star_meta', true ))):
$post_rating = 5;
else:
$post_rating = get_post_meta( $post->ID, '_post_star_meta', true );
endif;
$args = array(
   'rating' => $post_rating,
   'type' => 'rating',
   'number' => 1234,
);
require_once( ABSPATH . 'wp-admin/includes/template.php' );
wp_star_rating( $args );
endif;
?>
<?php
if( get_theme_mod('show_single_post_thumbnail') != 'none'):
if(get_post_meta(get_the_ID(),'hide_thumbnail',true) !== 'no' ):
?>
<div class="single-post-thumbnail single-post-thumbnail<?php if( get_theme_mod('show_single_post_thumbnail',true) == 'right'):?>-right<?php elseif ( get_theme_mod('show_single_post_thumbnail',true) == 'left' ): ?>-left<?php elseif ( get_theme_mod('show_single_post_thumbnail',true) == 'center' ): ?>-center<?php elseif ( get_theme_mod('show_single_post_thumbnail',true) == 'wide' ): ?>-wide<?php endif;?>"><?php get_theme_mod('show_single_post_thumbnail',true) != 'wide' ? the_post_thumbnail( 'stthumb' ) : the_post_thumbnail( 'full' );?></div>
<?php
  if(!get_theme_mod('absolute_thumbnail')){
    echo '<div class="clear"></div>';
  }
?>
<?php
endif;
endif;
?>
<?php if (!dynamic_sidebar('ahura_start_content_widget')) : ?>
<?php endif; ?>
<?php 
the_content(''); 
ahura_single_post_like_template(get_the_ID());
?>
<?php if (!dynamic_sidebar('ahura_content_widget')) : ?>
<?php endif; ?>
<?php
if( get_theme_mod('show_post_sharing')):
    include get_template_directory() .'/template-parts/single/share-buttons.php';
endif;
?>
<?php if ( get_theme_mod('show_author',true)):?>
<div class="clear"></div>
<div class="authorbox">
<div class="authorimg">
<?php echo get_avatar( get_the_author_meta('email'), '125' ); ?>
</div>
<div class="authorabout">
  <?php $author_url = get_the_author_meta('url'); ?>
<span><?php the_author(); if($author_url): ?> <a target="_blank" rel="nofollow" href="<?php echo $author_url; ?>"><?php echo __('Website','ahura');?></a><?php endif; ?></span>
<div class="authortxt">
<?php the_author_meta('description'); ?>
</div>
</div>
</div>
<?php endif;?>
<div class="clear"></div>
<?php if ( get_theme_mod('show_tags')):?>
<div id="tags">
<?php the_tags('#',' #',''); ?>
</div>
<?php endif;?>
</article>
<?php if ( get_theme_mod('show_relatedposts')):
  include get_template_directory() .'/template-parts/single/related-post.php'; ?>
<?php endif;?>
<div class="post-entry">
<?php comments_template(); ?>
</div>
</div>
</section>
<?php endwhile; ?>
<?php endif; ?>
<?php $sidebar->col('left')->display(); // left sidebar ?>
<div class="clear"></div>
</section>
<?php get_footer(); ?>
