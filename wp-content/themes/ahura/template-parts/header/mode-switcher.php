<?php 
$show_mode_switcher = \ahura\app\mw_options::get_mod_show_theme_mode_switcher();

if (\ahura\app\mw_options::get_mod_is_active_dark_theme() && $show_mode_switcher):
    $mode_switcher_titles = \ahura\app\mw_options::get_mod_show_theme_mode_switcher_titles();
?>
<div class="theme-mode-switcher hide-in-sticky <?php echo !$mode_switcher_titles ? 'without-titles' : '' ?>">
    <input type="radio" id="ahura-light-theme" data-mode="ahura-light-theme" name="theme-mode-switch" <?php echo ahura_get_current_theme_mode(true, 'light') ? 'checked' : '' ?>/>
    <label for="ahura-light-theme">
        <span>
            <i class="fa fa-sun"></i>
            <?php if ($mode_switcher_titles): ?>
                <em><?php echo esc_html__('Light', 'ahura'); ?></em>
            <?php endif; ?>
        </span>
    </label>
    <input type="radio" id="ahura-dark-theme" data-mode="ahura-dark-theme" name="theme-mode-switch" <?php echo ahura_get_current_theme_mode(true, 'dark') ? 'checked' : '' ?>/>
    <label for="ahura-dark-theme">
        <span>
            <i class="fa fa-moon"></i>
            <?php if ($mode_switcher_titles): ?>
                <em><?php echo esc_html__('Dark', 'ahura'); ?></em>
            <?php endif; ?>
        </span>
    </label>
    <input type="radio" id="ahura-black-theme" data-mode="ahura-black-theme" name="theme-mode-switch" <?php echo ahura_get_current_theme_mode(true, 'black') ? 'checked' : '' ?>/>
    <label for="ahura-black-theme">
        <span>
            <i class="fa fa-star"></i>
            <?php if ($mode_switcher_titles): ?>
                <em><?php echo esc_html__('Black', 'ahura'); ?></em>
            <?php endif; ?>
        </span>
    </label>
    <span class="slider"></span>
</div>
<?php
endif;