<div class="ahura-child-page-wrapper">
    <h2><?php _e('Ahura child theme', 'ahura')?></h2>
    <?php if(!is_child_theme()): ?>
        <span class="description"><?php _e('You can automaically generate child theme for ahura', 'ahura')?></span>
        <span class="result-msg"></span>
        <div class="child-theme-options">
            <input type="checkbox" name="move_customizer" id="move_customizer" value="1" <?php echo get_theme_mod('ahura_move_customizer_to_child_theme') ? ' checked' : '' ?>>
            <label for="move_customizer"><?php echo __('Transfer settings from ahura main theme to child theme.', 'ahura') ?></label>
        </div>
        <a class="start-btn" href="#"><?php _e('Create child theme', 'ahura')?></a>
    <?php else: ?>
        <span class="result-msg error show"><?php _e("You can't create new child theme when child theme is already active.", 'ahura')?></span>
    <?php endif; ?>
</div>