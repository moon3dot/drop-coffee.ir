<?php
/**
 * 
 * 
 *  Metabox fields for portfolio post type
 * 
 * 
 */

 
$post_id = $post->ID;
$images_str = get_post_meta($post_id, '_gallery_images', true);
$images = (!empty($images_str)) ? explode(',', $images_str) : false;
$videos_str = get_post_meta($post_id, '_gallery_videos', true);
$videos = (!empty($videos_str)) ? explode(',', $videos_str) : false;
?>
<div class="ahura-meta-boxs">
    <div class="meta-box-gallery">
        <label class="post-attributes-label">
            <?php echo esc_html__('Images', 'ahura') ?>
            <a href="#" class="ahura-gallery-upload button" data-type="image"><?php echo esc_html__('Upload Image', 'ahura') ?></a>
        </label>
        <div class="gallery-images">
            <input type="hidden" name="_gallery_images" value="<?php echo $images_str ?>">
            <div class="items">
                <?php 
                if($images):
                    foreach($images as $image):
                 ?>
                    <div class="gallery-item gallery-image-item gallery-item-<?php echo $image ?>" data-id="<?php echo $image ?>" data-type="image">
                        <div class="remove-item gallery-remove-item"><i class="dashicons dashicons-no-alt"></i></div>
                        <img src="<?php echo wp_get_attachment_url($image) ?>">
                    </div>
                <?php 
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
    <div class="meta-box-gallery">
        <label class="post-attributes-label">
            <?php echo esc_html__('Videos', 'ahura') ?>
            <a href="#" class="ahura-gallery-upload button" data-type="video"><?php echo esc_html__('Upload Video', 'ahura') ?></a>
        </label>
        <div class="gallery-videos">
            <input type="hidden" name="_gallery_videos" value="<?php echo $videos_str ?>">
            <div class="items">
                <?php 
                if($videos):
                    foreach($videos as $video):
                 ?>
                    <div class="gallery-item gallery-video-item gallery-item-<?php echo $video ?>" data-id="<?php echo $video ?>" data-type="video">
                        <div class="remove-item gallery-remove-item"><i class="dashicons dashicons-no-alt"></i></div>
                        <video>
                            <source src="<?php echo wp_get_attachment_url($video) ?>">
                        </video>
                    </div>
                <?php 
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
    <div class="meta-box-table">
        <table>
            <tbody>
                <tr>
                    <th><?php echo esc_html__('Customer Name', 'ahura') ?></th>
                    <td><input type="text" name="_portfolio_customer_name" value="<?php echo get_post_meta($post_id, '_portfolio_customer_name', true) ?>"></td>
                </tr>
                <tr>
                    <th><?php echo esc_html__('Website', 'ahura') ?></th>
                    <td><input type="text" name="_portfolio_website" value="<?php echo get_post_meta($post_id, '_portfolio_website', true) ?>"></td>
                </tr>
                <tr>
                    <th><?php echo esc_html__('Year of the Project', 'ahura') ?></th>
                    <td><input type="text" name="_portfolio_year" value="<?php echo get_post_meta($post_id, '_portfolio_year', true) ?>"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>