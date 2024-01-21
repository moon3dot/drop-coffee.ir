<div class="sharing ah-share-buttons">
    <div class="box-title">
        <?php
        $title = \ahura\app\mw_options::get_post_sharing_title();
        echo $title ? $title :  '';
        ?>
    </div>
    <div class="share-buttons-list d-flex <?php echo is_rtl() ? 'justify-content-start' : 'justify-content-end'; ?>">
        <?php if(get_theme_mod('show_post_sharing_facebook', true)): ?>
            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url');?>/img/social/facebook.svg" alt="facebook"/></a>
        <?php endif; ?>
        <?php if(get_theme_mod('show_post_sharing_twitter', true)): ?>
            <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url');?>/img/social/twitter.svg" alt="twitter"/></a>
        <?php endif; ?>
        <?php if(get_theme_mod('show_post_sharing_linkedin', true)): ?>
            <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=&source=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url');?>/img/social/linkedin.svg" alt="linkedin"/></a>
        <?php endif; ?>
        <?php if(get_theme_mod('show_post_sharing_telegram', true)): ?>
            <a target="_blank" href="https://telegram.me/share/url?url=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url');?>/img/social/telegram.png" alt="telegram"/></a>
        <?php endif; ?>
        <?php if(get_theme_mod('show_post_sharing_pinterest', true)): ?>
            <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url');?>/img/social/pinterest.svg" alt="pinterest"/></a>
        <?php endif; ?>
        <?php if(get_theme_mod('show_post_sharing_whatsapp', true)): ?>
            <a target="_blank" href="whatsapp://send?text=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url');?>/img/social/whatsapp.svg" alt="whatsapp"/></a>
        <?php endif; ?>
        <?php if(get_theme_mod('show_post_sharing_gmail', true)): ?>
            <a target="_blank" href="mailto:?subject=<?php the_title() ?>&amp;body=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url');?>/img/social/email.svg" alt="email"/></a>
        <?php endif; ?>
    </div>
</div>