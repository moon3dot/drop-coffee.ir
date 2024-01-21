<?php
/**
 * 
 * Usage in action ahura_post_like_template
 * 
 * @uses ahura_post_like_template($post_id, $title)
 * 
 */
$box_title = (!empty($title)) ? $title : \ahura\app\mw_options::get_mod_post_like_box_title();
$like_title = \ahura\app\mw_options::get_mod_post_like_button_title();
$dislike_title = \ahura\app\mw_options::get_mod_post_dislike_button_title();

$likes = ahura_get_post_likes($post_id);
$dislikes = ahura_get_post_dislikes($post_id);
?>
<div class="ahura-post-like">
    <div class="ahura-post-like-msg ahura-post-like-msg-<?php echo $post_id ?>"></div>
    <div class="row align-items-center">
        <div class="col">
            <h3 class="post-like-title"><?php echo $box_title ?></h3>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="post-like-buttons">
                <a href="#" class="btn-post-like-action btn-post-like" data-like="1" data-post-id="<?php echo $post_id ?>">
                    <i class="icon-post-like"></i>
                    <span class="btn-title"><?php echo $like_title ?></span>
                    <span class="counter"><?php echo intval($likes) ? $likes : '0' ?></span>
                </a>
                <a href="#" class="btn-post-like-action btn-post-dislike" data-like="0" data-post-id="<?php echo $post_id ?>">
                    <i class="icon-post-dislike"></i>
                    <span class="btn-title"><?php echo $dislike_title ?></span>
                    <span class="counter"><?php echo intval($dislikes) ? $dislikes : '0' ?></span>
                </a>
            </div>
        </div>
    </div>
</div>