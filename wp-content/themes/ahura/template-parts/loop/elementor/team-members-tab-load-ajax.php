<?php
$post = get_post_meta(get_the_ID(), '_team_subtitle', true);
$options = get_post_meta(get_the_ID(), '_team_options', true);
$video_url = get_post_meta(get_the_ID(), '_team_video_url', true);
$excerpt = get_the_excerpt();
$item = (isset($item)) ? $item : $settings['item'];
$chars_num = isset($item['bio_chars_count']) && intval($item['bio_chars_count']) ? $item['bio_chars_count'] : false;
$show_bio = $item['show_bio'] == 'yes';
$options_title = $item['item_options_box_title'];
$bio_title = $item['item_bio_box_title'];
?>
<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
    <div class="team-info-box">
        <?php if($item['show_overlay'] == 'yes'): ?>
            <div class="team-box-overlay" style="background-image:url(<?php echo $item['items_overlay']['url'] ?>)"></div>
        <?php endif; ?>
        <div class="top-details">
            <div class="team-avatar"><?php echo wp_get_attachment_image(get_post_thumbnail_id(), $settings['item_cover_size']) ?></div>
            <div class="team-name"><?php the_title() ?></div>
            <?php if(!empty($post)): ?>
                <div class="team-post"><?php echo $post ?></div>
            <?php endif; ?>
        </div>
        <?php if($item['show_options'] == 'yes' && !empty($options)): ?>
        <div class="main-details">
            <?php if(!empty($video_url)): ?>
                <a href="<?php echo $video_url ?>" target="_blank" class="team-video-link">
                    <?php echo file_get_contents(get_template_directory() . '/img/icons/svg/online-video.svg') ?>
                </a>
            <?php else: ?>
                <div class="hr-centered-text"><?php echo $options_title ?></div>
            <?php endif; ?>
            <ul>
                <?php foreach($options as $option): ?>
                <li>
                    <?php if(isset($option['icon']) && !empty($option['icon'])): ?>
                        <i class="<?php echo $option['icon'] ?>"></i>
                    <?php endif; ?>
                    <?php if(isset($option['label']) && !empty($option['label'])): ?>
                        <span><?php echo $option['label'] ?></span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if($show_bio && !empty($excerpt)): ?>
        <div class="bottom-details">
            <div class="team-bio-content">
                <div class="hr-centered-text"><?php echo $bio_title ?></div>
                <div class="team-bio"><?php 
                    if($chars_num){
                        echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '.') . '</p>';
                    } else {
                        the_excerpt();
                    }
                ?></div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>