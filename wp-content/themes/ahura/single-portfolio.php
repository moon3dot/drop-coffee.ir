<?php get_header(); ?>
<div class="ahura-portfolio-single-wrap">
    <div class="ahura-single-portfolio">
        <div class="container">
            <?php
            if(\ahura\app\mw_options::get_mod_show_portfolio_breadcrumb()){
                include get_template_directory() .'/template-parts/single/bread-crumb2.php';
            }
  
            $post_id = get_queried_object_id();
            $cat_taxonomy = 'portfolio_cat';
            $skills_taxonomy = 'portfolio_skills';

            if(have_posts()):
                while(have_posts()) : the_post();
                $images_str = get_post_meta($post_id, '_gallery_images', true);
                $images = (!empty($images_str)) ? explode(',', $images_str) : false;
                $videos_str = get_post_meta($post_id, '_gallery_videos', true);
                $videos = (!empty($videos_str)) ? explode(',', $videos_str) : false;
                $customer_name = get_post_meta($post_id, '_portfolio_customer_name', true);
                $year = get_post_meta($post_id, '_portfolio_year', true);
                $website = get_post_meta($post_id, '_portfolio_website', true);
            ?>
            <div class="portfolio-top-section">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                        <div class="swiper portfolios-slider portfolios-slider-images">
                            <div class="swiper-wrapper">
                                <?php 
                                if($images_str):
                                    foreach($images as $image):
                                        $src = wp_get_attachment_url($image);
                                        $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
                                 ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo $src ?>" alt="<?php echo $image_alt ? $image_alt : get_the_title(); ?>">
                                </div>
                                <?php 
                                    endforeach;
                                else: ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php echo get_the_title() ?>">
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <?php if(!empty($videos_str)): ?>
                            <button type="button" class="portfolio-slider-toggle portfolio-show-videos" data-type="videos"><?php echo esc_html__('View Videos', 'ahura') ?></button>
                            <?php endif; ?>
                        </div>
                        <div class="swiper portfolios-slider portfolios-slider-videos" style="display: <?php echo (!empty($images_str)) ? 'none' : 'block' ?>">
                            <div class="swiper-wrapper">
                                <?php 
                                if($videos_str):
                                    foreach($videos as $video):
                                        $src = wp_get_attachment_url($video);
                                 ?>
                                <div class="swiper-slide">
                                    <video controls>
                                        <source src="<?php echo $src ?>"/>
                                    </video>
                                </div>
                                <?php 
                                    endforeach;
                                endif; ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <?php if(!empty($images_str) && !empty($videos_str)): ?>
                            <button type="button" class="portfolio-slider-toggle portfolio-show-images" data-type="images"><?php echo esc_html__('View Images', 'ahura') ?></button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="portfolio-details">
                            <h2 class="post-title"><?php the_title(); ?></h2>
                            <?php 
                            $cats = wp_get_post_terms($post_id, $cat_taxonomy);
                            if($cats && (is_array($cats) && count($cats) > 0)):
                            ?>
                                <div class="portfolio-cats">
                                <?php
                                foreach ($cats as $cat):
                                    $url = get_term_link($cat, $cat_taxonomy);
                                ?>
                                    <a href="<?php echo $url ?>" title="<?php echo $cat->name ?>" class="cat-name"><?php echo $cat->name ?></a>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if(\ahura\app\mw_options::get_mod_show_portfolio_excerpt()): ?>
                                <div class="post-excerpt"><?php the_excerpt(); ?></div>
                            <?php endif; ?>
                            <div class="post-metas">
                                <div class="post-meta">
                                    <?php echo sprintf(esc_html__('Customer Name: %s', 'ahura'), $customer_name) ?>
                                </div>
                                <div class="post-meta">
                                    <?php echo sprintf(esc_html__('Year of the Project: %s', 'ahura'), $year) ?>
                                </div>
                                <?php 
                                $cats = wp_get_post_terms($post_id, $skills_taxonomy);
                                if($cats && (is_array($cats) && count($cats) > 0)):
                                ?>
                                <div class="post-meta">
                                    <div class="portfolio-skills portfolio-cats">
                                    <?php
                                    foreach ($cats as $cat):
                                        $url = get_term_link($cat, $skills_taxonomy);
                                    ?>
                                        <a href="<?php echo $url ?>" title="<?php echo $cat->name ?>" class="cat-name"><?php echo $cat->name ?></a>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if(!empty($website)): ?>
                                    <div class="post-meta">
                                        <a href="<?php echo $website ?>" class="view-website" target="_blank"><i class="fa fa-eye"></i><?php echo esc_html__('View Project', 'ahura') ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portfolio-mid-section">
                <?php
                $content = get_the_content();
                if(\ahura\app\mw_options::get_mod_show_portfolio_description() && $content):
                ?>
                <div class="wrap-title">
                    <h3><?php echo esc_html__('Additional details of the portfolio', 'ahura') ?></h3>
                </div>
                <div class="post-content-wrap">
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php 
                if(\ahura\app\mw_options::get_mod_show_portfolio_like_box()){
                    ahura_post_like_template($post_id, \ahura\app\mw_options::get_mod_portfolio_like_box_title());
                }
                ?>
            </div>
            <?php 
                endwhile;
            endif;
            ?>
            <div class="portfolio-bottom-section">
                <?php
                if(\ahura\app\mw_options::get_mod_show_related_portfolios()):
				$number = get_theme_mod('ahura_related_portfolios_number', 3);
                $relateds = new WP_Query(['post_type' => 'portfolio', 'posts_per_page' => $number, 'post__not_in' => [$post_id]]);
                    if($relateds->have_posts()): ?>
                    <div class="wrap-title">
                        <h3><?php echo esc_html__('Our other portfolio', 'ahura') ?></h3>
                    </div>
                    <div class="portfolios-related">
                        <div class="row">
                            <?php 
                            while($relateds->have_posts()): $relateds->the_post();
                            $bg = get_the_post_thumbnail_url(get_the_ID());
                            ?>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                <a href="<?php the_permalink(); ?>" class="portfolio-related <?php echo !empty($bg) ? ' with-bg' : '' ?>" style="background-image: url('<?php echo $bg ?>')">
                                    <div class="related-content">
                                        <div class="related-cats">
                                            <?php
                                            $cats = wp_get_post_terms(get_the_ID(), $cat_taxonomy);
                                            if($cats && (is_array($cats) && count($cats) > 0)):
                                            ?>
                                                <span class="cat-name"><?php echo $cats[0]->name ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="related-title"><?php the_title(); ?></div>
                                        <span class="permalink">
                                            <?php echo esc_html__('View Portfolio', 'ahura') ?>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <?php endwhile; ?>  
                        </div>
                    </div>
                    <?php
                    wp_reset_query();
                    endif; 
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();