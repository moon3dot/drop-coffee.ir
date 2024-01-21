<?php get_header(); ?>

<?php if(!get_theme_mod('blog_archive_hide_title_box')): ?>
    <div class="cat-description">
        <section class="site-container">
            <h1><?php single_cat_title(''); ?></h1>
            <?php
            if(!get_theme_mod('blog_archive_hide_description')){
                the_archive_description( '<div class="cat-description-inner">', '</div>' );
            }
            ?>
        </section>
    </div>
<?php endif; ?>

<section class="site-container">

<div class="postbox4 post-index">

<div class="clear"></div>

<div class="flexed row">

<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

  <div class="col-<?php echo get_theme_mod('ahura_archive_column_mobile') ? get_theme_mod('ahura_archive_column_mobile') : 12 ; ?> col-sm-<?php echo get_theme_mod('ahura_archive_column_tablet') ? get_theme_mod('ahura_archive_column_tablet') : 4 ; ?> col-md-<?php echo get_theme_mod('ahura_archive_column') ? get_theme_mod('ahura_archive_column') : 3 ; ?>">
  <article class="clearfix">
  <?php
    $is_new = ahura_is_new_post();
    $content_types = get_the_terms(get_the_ID(), 'content_types');
    if($content_types && !is_wp_error($content_types) || $is_new):?>
      <span class="post-content-types">
        <?php if(get_theme_mod('ahura_new_posts_label_status') && $is_new): ?>
          <span class="new"><?php echo esc_html__('New', 'ahura') ?></span>
        <?php endif; ?>
        <?php 
        if(\ahura\app\mw_options::get_mod_show_content_types_in_archive() && $content_types):
        foreach($content_types as $type):
          $icon_id = \ahura\app\taxonomies::get_term_meta($type->term_id, 'icon');
          $icon_url = wp_get_attachment_url($icon_id);
          ?>
          <span class="type">
              <?php if(!empty($icon_url)): ?>
                <span class="icon"><img src="<?php echo $icon_url?>" alt="type_icon_<?php echo get_the_title()?>"></span>
              <?php endif; ?>
            <span class="name"><?php echo $type->name?></span>
          </span>
        <?php 
      endforeach;
    endif;
      ?>
      </span>
    <?php endif; ?>
    <a class="fimage" href="<?php the_permalink();?>"><?php the_post_thumbnail( 'stthumb' );?></a>
    <a href="<?php the_permalink();?>"><h3><?php the_title();?></h3></a>
    <?php if(!get_theme_mod('cat_box_desc')):?>
    <div class="excerpt has_margin">
      <?php the_excerpt();?>
    </div>
    <?php endif;?>
    <div class="meta">
      <?php if(get_theme_mod('post-meta-author',true)):?>
      <span class="post-author"><?php echo get_avatar( get_the_author_meta( 'ID' ) , 48 ); ?><?php the_author(); ?></span>
      <?php endif;?>
      <?php if(get_theme_mod('post-meta-time',true)):?>
      <span class="post-meta"><i class="fa fa-clock"></i> <?php echo get_the_date('d F Y');?></span>
      <?php endif;?>
    </div>
  </article></div>

<?php endwhile; ?>

<?php else:?>
<article style="width:100%;padding:30px;" class="post-entry">
<header class="post-title">
<h2><a href="#"><?php echo __('Posts Not Found!','ahura');?></a></h2>
</header>
<div class="error404">404</div>
</article>
<?php endif; ?>

</div>

<div class="clear"></div>

<?php mihanwp_numeric_posts_nav(); ?>

</div>

<div class="clear"></div>

</section>

<?php get_footer(); ?>
