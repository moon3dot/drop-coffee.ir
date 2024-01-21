<?php get_header(); ?>
<div class="ahura-portfolio-archive-wrap">
    <div class="ahura-portfolio-archive">
        <div class="container">
            <div class="page-title-wrap">
                <h1><?php echo ahura_get_archive_title() ?></h1>
                <?php if(\ahura\app\mw_options::get_mod_show_portfolio_archive_breadcrumb()): ?>
                    <div class="ahura-page-breadcrumb">
                        <?php ahura_breadcrumb(); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="portfolio-archive-items">
                <div class="row">
                <?php 
                if(have_posts()):
                    while(have_posts()): the_post();
                ?>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <a href="<?php the_permalink(); ?>" class="portfolio-box">
                        <div class="portfolio-content clearfix">
                            <div class="portfolio-cover clearfix">
                                <div class="portfolio-cats">
                                    <?php
                                    $cat_taxonomy = 'portfolio_cat';
                                    $cats = wp_get_post_terms(get_the_ID(), $cat_taxonomy);
                                    if($cats && (is_array($cats) && count($cats) > 0)):
                                        $i = 0;
                                        foreach ($cats as $cat):
                                            $i++;
                                            if($i == 3) break;
                                            $url = get_term_link($cat, $cat_taxonomy);
                                    ?>
                                    <span class="cat-name"><?php echo $cat->name ?></span>
                                    <?php 
                                        endforeach;
                                    endif; 
                                    ?>
                                </div>
                                <div class="portfolio-cover-hover">
                                    <div class="portfolio-btn-text">
                                        <i class="fa fa-eye"></i>
                                        <?php echo esc_html__('View Portfolio', 'ahura') ?>
                                    </div>
                                </div>
                                <?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
                            </div>
                            <div class="portfolio-title"><?php the_title(); ?></div>
                            <?php if(\ahura\app\mw_options::get_mod_portfolio_like_box_title()): ?>
                            <span class="portfolio-likes-count">
                                <i class="fa fa-heart"></i>
                                <?php echo sprintf(esc_html__('%d people have liked it', 'ahura'), ahura_get_post_likes(get_the_ID())); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
                <?php 
                    endwhile;
                else:
                ?>  
                <div class="col-12"><?php echo \ahura\app\Ahura_Alert::frontNotice(__('Sorry, no portfolio was found to display.', 'ahura'), \ahura\app\Ahura_Alert::ERROR) ?></div>
                <?php endif; ?>
                </div>
            </div>
            <?php if(have_posts()): ?>
            <div class="ahura-pagination"><?php mihanwp_numeric_posts_nav(); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>