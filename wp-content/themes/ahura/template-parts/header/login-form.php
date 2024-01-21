<?php
$users_can_register = intval(get_option('users_can_register'));
$show_captcha = \ahura\app\mw_options::get_mod_show_login_captcha_code();
?>
<div class="ahura-tabs">
    <span class="tab-item active" data-target="#user-login-tab"><?php echo esc_html__('Login', 'ahura') ?></span>
    <?php if($users_can_register ): ?>
        <span class="tab-item" data-target="#user-register-tab"><?php echo esc_html__('Register', 'ahura') ?></span>
    <?php endif; ?>
    <span class="tab-item" data-target="#user-resetpass-tab"><?php echo esc_html__('Reset Password', 'ahura') ?></span>
</div>
<div class="ahura-tabs-content">
    <div class="ahura-tab-content active" id="user-login-tab">
        <form class="form cform" id="ahura-login-form">
            <div class="f_row">
                <label><?php echo esc_html__('Username', 'ahura') ?></label>
                <input type="text" name="username" class="input-field" required>
            </div>
            <div class="f_row">
                <label><?php echo esc_html__('Password', 'ahura') ?></label>
                <input type="password" name="password" class="input-field" required>
            </div>
            <?php if($show_captcha): ?>
                <div class="f_row">
                    <label><?php echo esc_html__('Security Code', 'ahura') ?></label>
                    <div class="captcha-field-group">
                        <input type="text" name="security_code" class="input-field security-code" autocomplete="off" required>
                        <div class="captcha-code reload-captcha" id="ahura-login-captcha"></div>
                    </div>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn"><?php echo esc_html__('Login', 'ahura') ?></button>
        </form>
    </div>
    <?php if($users_can_register ): ?>
    <div class="ahura-tab-content" id="user-register-tab" style="display:none">
        <form class="form cform" id="ahura-register-form">
            <div class="f_row">
                <label><?php echo esc_html__('Username', 'ahura') ?></label>
                <input type="text" name="username" class="input-field" required>
            </div>
            <div class="f_row">
                <label><?php echo esc_html__('Email', 'ahura') ?></label>
                <input type="email" name="email" class="input-field" required>
            </div>
            <div class="f_row">
                <label><?php echo esc_html__('Password', 'ahura') ?></label>
                <input type="password" name="password" class="input-field" required>
            </div>
            <?php if($show_captcha): ?>
                <div class="f_row">
                    <label><?php echo esc_html__('Security Code', 'ahura') ?></label>
                    <div class="captcha-field-group">
                        <input type="text" name="security_code" class="input-field security-code" autocomplete="off" required>
                        <div class="captcha-code reload-captcha" id="ahura-register-captcha"></div>
                    </div>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn"><?php echo esc_html__('Register', 'ahura') ?></button>
        </form>
    </div>
    <?php endif; ?>
    <div class="ahura-tab-content" id="user-resetpass-tab" style="display:none">
        <form class="form cform" id="ahura-resetpass-form">
            <div class="f_row">
                <label><?php echo esc_html__('Username', 'ahura') ?></label>
                <input type="text" name="username" class="input-field" required>
            </div>
            <?php if($show_captcha): ?>
                <div class="f_row">
                    <label><?php echo esc_html__('Security Code', 'ahura') ?></label>
                    <div class="captcha-field-group">
                        <input type="text" name="security_code" class="input-field security-code" autocomplete="off" required>
                        <div class="captcha-code reload-captcha" id="ahura-resetpwd-captcha"></div>
                    </div>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn"><?php echo esc_html__('Reset Password', 'ahura') ?></button>
        </form>
    </div>
</div>