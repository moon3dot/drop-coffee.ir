<?php
/**
 * 
 * 
 *  Metabox fields for team post type
 * 
 * 
 */
 
$post_id = $post->ID;
$fonticons = ahura_fonticons_array();
$options = get_post_meta($post_id, '_team_options', true);
?>
<div class="ahura-meta-boxs">
    <div class="meta-box-table">
        <table>
            <tbody>
                <tr>
                    <th><?php echo esc_html__('Job/Post', 'ahura') ?></th>
                    <td><input type="text" name="_team_subtitle" value="<?php echo get_post_meta($post_id, '_team_subtitle', true) ?>"></td>
                </tr>
                <tr>
                    <th><?php echo esc_html__('Video Url', 'ahura') ?></th>
                    <td><input type="text" name="_team_video_url" value="<?php echo get_post_meta($post_id, '_team_video_url', true) ?>"></td>
                </tr>
                <tr>
                    <th><?php echo esc_html__('Options', 'ahura') ?></th>
                    <td>
                        <button type="button" class="button team-add-new-option"><?php echo esc_html__('Add New', 'ahura') ?></button>
                        <div class="team-options">
                            <?php 
                            if($options):
                                foreach($options as $key => $option):
                                    $icon = isset($option['icon']) && !empty($option['icon']) ? $option['icon'] : null;
                                    $label = isset($option['label']) && !empty($option['label']) ? $option['label'] : null;
                                ?>
                                <div class="team-meta-option" data-id="<?php echo $key ?>">
                                    <a href="#" class="mw-popup-fonticon-selector-btn primary-selector-btn">
                                        <i class="<?php echo $icon ? $icon : 'dashicons dashicons-arrow-down-alt2' ?>"></i>
                                    </a>
                                    <input type="hidden" value="<?php echo $icon ? $icon : '' ?>" class="icon-field" name="_team_options[<?php echo $key ?>][icon]">
                                    <input type="text" value="<?php echo $label ? $label : '' ?>" name="_team_options[<?php echo $key ?>][label]">
                                    <a href="#" class="team-remove-option">
                                        <i class="dashicons dashicons-no-alt"></i>
                                    </a>
                                </div>
                                <?php 
                                endforeach; 
                            endif; ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="ahura-popup-icons-box mw-fonticon-selector-wrap" style="display:none">
    <?php if($fonticons): ?>
        <div class="font-icons-list-content">
            <span class="mw-popup-fonticon-selector-btn"><i class="dashicons dashicons-no-alt"></i></span>
            <input type="text" class="fonticons-search-input" placeholder="<?php echo esc_attr__('Search', 'ahura') ?>">
            <ul>
                <?php foreach($fonticons as $key => $value): ?>
                    <li data-icon="<?php echo $key ?>" title="<?php echo $value ?>">
                        <i class="<?php echo $key ?>"></i>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>