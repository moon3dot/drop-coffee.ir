<?php
$cls = sprintf('col-12 col-md-6 col-sm-6 col-xs-6 col-lg-%s clearfix', $settings['layout_col']);
while ($posts->have_posts()):
    $posts->the_post();

    $gmdate = get_the_modified_date('F j, Y');
    $date = $gmdate;
    ?>
    <div class="<?php echo $cls ?>">
        <?php if ($settings['item_meta_show'] === 'yes'): ?>
            <div class="post-metas">
                <div class="ah-meta-item meta-date">
                    <i class="meta-icon meta-icon-calendar"></i>
                    <span><?php the_author() ?></span>
                </div>
                /
                <div class="ah-meta-item meta-date">
                    <i class="meta-icon meta-icon-calendar"></i>
                    <span><?php echo $date ?></span>
                </div>
            </div>
        <?php endif; ?>
        <article class="element-post-content clearfix">
            <div class="element-post-content-top">
                <div class="post-cover clearfix" style="background-image: url(<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['item_cover_size']) ?>)"></div>
                <div class="post-details">
                    <div class="post-title">
                        <h2>
                            <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                <?php the_title() ?>
                            </a>
                        </h2>
                    </div>
                    <?php if ($settings['item_excerpt_show'] === 'yes'): ?>
                        <div class="post-excerpt"><?php
                            if($chars_num){
                                echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
                            } else {
                                the_excerpt();
                            }
                            ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="element-post-content-bottom">
                <div class="post-btn">
                    <a href="<?php echo esc_attr(get_the_permalink()) ?>"><?php echo $settings['item_btn_text']; ?></a>
                </div>
            </div>
        </article>
    </div>
<?php
endwhile;
wp_reset_query();
wp_reset_postdata();
?>