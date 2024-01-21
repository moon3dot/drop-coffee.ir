<div class="related-posts">
    <span class="related-posts-title"><?php echo __( 'Related Articles', 'ahura' ); ?></span>
    <div class="postbox1posts row">
        <?php
        $related_onCat = get_posts( ['category__in' => wp_get_post_categories( $post->ID ), 'numberposts' => 4, 'post__not_in' => [$post->ID]] );
        $related_onTag = get_posts( ['tax_query' => [['taxonomy' => 'post_tag', 'field' => 'id', 'terms' => wp_get_post_tags( $post->ID, ['fields' => 'ids'] ) ]], 'numberposts' => 4, 'post__not_in' => [$post->ID] ] );
        if(get_theme_mod('show_relatedposts')) {
            get_theme_mod('show_relatedposts_ontags') ? $related = $related_onTag : $related = $related_onCat;
        }
        if ( $related ): 
            foreach ( $related as $post ) {
            setup_postdata($post); ?>
            <?php
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src( $thumb_id, 'verthumb', true );
            ?>
            <div class="col-md-3">
                <article class="grid-post grid-post-grey" style="background-image:url( '<?php echo isset($thumb_url[0]) ? $thumb_url[0] : ''; ?>' );">
                    <a href="<?php the_permalink(); ?>">
                        <span><?php the_title(); ?></span>
                    </a>
                </article>
            </div>
        <?php 
        }
        wp_reset_postdata();
        else:
        ?>
        <div class="col-12">
            <?php \ahura\app\Ahura_Alert::frontNotice(__('Sorry, related posts could not be found.', 'ahura'), \ahura\app\Ahura_Alert::WARNING); ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>
</div>
