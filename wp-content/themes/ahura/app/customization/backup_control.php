<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class backup_control extends \WP_Customize_Control
    {
        function render_content()
        {
            ?>
            <span class="customize-control-title"><?php _e('Export', 'ahura'); ?></span>
            <span class="description customize-control-description">
                <?php _e('Click the button below to export the customization settings for this theme.', 'ahura'); ?>
            </span>
            <input type="button" class="button" name="ahura-export-button" value="<?php esc_attr_e('Export', 'ahura'); ?>"/>
            <hr class="ahura-hr"/>
            <span class="customize-control-title"><?php _e('Import', 'ahura'); ?></span>
            <span class="description customize-control-description">
                <?php _e('Upload a file to import customization settings for this theme.', 'ahura'); ?>
            </span>
            <div class="ahura-import-controls">
                <input type="file" name="ahura-import-file" class="ahura-import-file"/>
                <label class="ahura-import-images">
                    <input type="checkbox" name="ahura-import-images" value="1"/> <?php _e('Download and import image files?', 'ahura'); ?>
                </label>
                <?php wp_nonce_field('ahura-importing', 'ahura-customizer-import'); ?>
            </div>
            <div class="ahura-uploading"><?php _e('Uploading...', 'ahura'); ?></div>
            <input type="button" class="button" name="ahura-import-button" value="<?php esc_attr_e('Import', 'ahura'); ?>" />
            <?php
        }
    }
}