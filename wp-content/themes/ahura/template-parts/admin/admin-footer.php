<div class="ahura-section-builder-container">
    <div class="ah-overlay"></div>
    <div class="ah-wrap">
        <div class="ah-content">
            <div class="box-title">
                <h2><?php echo __('Create New Template', 'ahura') ?></h2>
                <span id="close-btn"><i class="dashicons dashicons-no-alt"></i></span>
            </div>
            <div class="ah-box-fields">
                <form action="/" method="post" id="ah-section-builder-form">
                    <div class="field-wrap">
                        <label for="section_type"><?php echo __('Template Type', 'ahura') ?></label>
                        <select name="section_type" id="section_type" required>
                            <option value=""><?php echo __('Select...', 'ahura') ?></option>
                            <option value="header"><?php echo __('Header', 'ahura') ?></option>
                            <option value="footer"><?php echo __('Footer', 'ahura') ?></option>
                            <option value="page"><?php echo __('Page', 'ahura') ?></option>
                        </select>
                    </div>
                    <div class="field-wrap ah-with-depend ah-for-page" style="display:none;">
                        <label for="template_page"><?php echo __('Select Page', 'ahura') ?></label>
                        <select name="template_page" id="template_page" class="is-required">
                            <option value=""><?php echo __('Select...', 'ahura') ?></option>
                            <optgroup label="<?php echo __('Wordpress', 'ahura') ?>">
                                <option value="error-404"><?php echo __('Page 404', 'ahura') ?></option>
                                <option value="archive"><?php echo __('Archive', 'ahura') ?></option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="field-wrap">
                        <label for="section_title"><?php echo __('Template Name', 'ahura') ?></label>
                        <input type="text" name="section_title" id="section_title" placeholder="<?php echo __('Enter the name...', 'ahura') ?>" required>
                    </div>
                    <div class="field-wrap">
                        <div class="round-check-wrap">
                            <div class="round-check">
                                <input type="checkbox" name="set_default" id="set_default" class="checkbox checkbox-content" value="1">
                                <label for="set_default"></label>
                            </div>
                            <label for="set_default" class="text-label">
                                <span><?php echo __('Choose as default', 'ahura') ?></span>
                            </label>
                        </div>
                    </div>
                    <button type="submit"><?php echo __('Create Template', 'ahura') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>