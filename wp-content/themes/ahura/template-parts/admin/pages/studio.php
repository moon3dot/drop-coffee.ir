<?php
use ahura\app\license;
use ahura\app\Ahura_Alert;

$tabs = \ahura\app\Studio::get_filter_tabs();
$demos = \ahura\app\Studio_Demo::get_demo_list();
$demo_options = \ahura\app\Studio_Demo::get_demo_options();
$demo_base_url = \ahura\app\Studio::get_base_url();
$license_status = license::check_license();
$has_error = !$license_status || !$demos || !$tabs;
?>
<div class="wrap">
    <div class="studio-content">
        <?php if (!$has_error): ?>
            <?php if($license_status): ?>
            <div class="ahura-filter-tabs">
                <div class="filters-top">
                    <div class="search-wrap">
                        <input type="text" placeholder="<?php _e('Search...', 'ahura') ?>">
                    </div>
                    <ul>
                        <li class="active"><a href="#" data-filter=".all-items"><?php echo esc_attr__('All', 'ahura') ?></a></li>
                        <?php
                        foreach($tabs as $key => $value):
                            if ($value['is_active'] !== 'true') continue;
                            ?>
                            <li>
                                <a href="#" data-filter=".<?php echo $value['slug'] ?>">
                                    <span><?php echo !is_rtl() && isset($value['en_title']) && !empty($value['en_title']) ? $value['en_title'] : $value['title'] ?></span>
                                    <?php if(isset($value['count'])): ?>
                                        <em class="item-count"><?php echo $value['count'] ?></em>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="filters-bottom">
                    <div class="buttons">
                        <form action="" method="post" class="<?php echo esc_attr( $multi_import ); ?>">
                            <footer class="merlin__content__footer">
                                <a id="close" href="<?php echo esc_url( $this->step_next_link() ); ?>" class="merlin__button merlin__button--skip merlin__button--closer merlin__button--proceed"><?php echo esc_html( $skip ); ?></a>
                                <a id="skip" href="#" data-href="<?php echo esc_url( $this->step_next_link() ); ?>" class="merlin__button merlin__button--skip merlin__button--proceed"><?php echo esc_html( $skip ); ?></a>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
            <?php if (!\ahura\app\mw_config::has_minimum_php_version()): ?>
                <div class="ah-notice ah-error">
                    <p><?php echo sprintf(__('The required PHP version of the theme is %s, please change the PHP version through the host to use the demo installer.', 'ahura'), \ahura\app\mw_config::MINIMUM_PHP_VER) ?></p>
                </div>
            <?php else: ?>
                <div class="ahura-filter-tab-items ahura-studio-filter-tab-items">
                    <a href="#" class="aside-btn"><?php _e('Categories', 'ahura') ?></a>
                   <div class="items-list">
                       <?php if($demos): ?>
                           <?php
                           $i = 0;
                           foreach($demos as $demo):
                               $title = !is_rtl() && isset($demo['en_title']) && !empty($demo['en_title']) ? $demo['en_title'] : $demo['title'];
                               $cat = isset($demo['category']) ? $demo['category'] : '';
                               $name = isset($demo['slug']) ? $demo['slug'] : '';
                               $demo_slug = isset($demo['id']) ? $demo['id'] : $name;
                               $demo_img = isset($demo['screenshot']) ? $demo['screenshot'] : '';
                               ?>
                               <div class="filter-item <?php echo $cat ?>" data-cat="<?php echo $cat ?>">
                                   <div class="filter-item-content-wrap">
                                       <div class="filter-item-content">
                                           <div class="filter-item-cover" data-demo-preview-url="<?php echo $demo_img ?>">
                                               <?php if($demo_options): ?>
                                                   <div class="filter-item-options">
                                                       <ul class="merlin__drawer merlin__drawer--import-content js-merlin-drawer-import-content">
                                                           <?php foreach ($demo_options as $key => $value): ?>
                                                               <li class="merlin__drawer--import-content__list-item status status--Pending" data-content="<?php echo $key ?>">
                                                                   <div class="round-check-wrap">
                                                                       <div class="round-check">
                                                                           <input type="checkbox" name="default_content[<?php echo $key ?>]" class="checkbox checkbox-<?php echo $key ?>" id="default_content_<?php echo $key ?>_<?php echo $demo_slug ?>" value="1" checked>
                                                                           <label for="default_content_<?php echo $key ?>_<?php echo $demo_slug ?>"></label>
                                                                       </div>
                                                                       <label for="default_content_<?php echo $key ?>_<?php echo $demo_slug ?>" class="text-label">
                                                                           <span><?php echo $value ?></span>
                                                                       </label>
                                                                   </div>
                                                               </li>
                                                           <?php endforeach; ?>
                                                       </ul>
                                                   </div>
                                                   <div class="float-options">
                                                       <span class="float-item show-demo-options"><i class="dashicons dashicons-screenoptions"></i></span>
                                                       <a href="<?php echo site_url() ?>" target="_blank" class="float-item home-link"><i class="dashicons dashicons-admin-home"></i></a>
                                                   </div>
                                               <?php endif; ?>
                                               <div class="filter-item-cover-loading">
                                                   <div class="loader-dots">
                                                       <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                                                   </div>
                                               </div>
                                               <div class="clear"></div>
                                           </div>
                                           <h3 class="filter-item-title"><?php echo $title ?></h3>
                                           <div class="filter-item-btns">
                                               <a href="<?php echo $demo['site_url'] ?>" class="studio-preview-demo" target="_blank"><?php echo esc_html__('Preview', 'ahura') ?></a>
                                               <a href="#" class="studio-install-demo" data-callback="install_content" data-demo-title="<?php echo $title ?>" data-demo-id="<?php echo $i ?>" data-demo-slug="<?php echo $demo_slug ?>">
                                                   <div class="btn-progress" style="width:0"></div>
                                                   <span><?php echo esc_html__('Import Demo', 'ahura') ?></span>
                                               </a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <?php
                               $i++;
                           endforeach; ?>
                       <?php endif; ?>
                   </div>
                </div>
            <?php endif; ?>
            <?php
            else:
                Ahura_Alert::adminNotice(esc_html__('Please active ahura theme license.', 'ahura'), Ahura_Alert::WARNING);
            endif;
            ?>
        <?php else: ?>
            <div class="studio-error">
                <div class="msg-content">
                    <span class="notice-icon dashicons dashicons-warning"></span>
                    <p class="notice-message">
                        <?php
                        if (!$demos || !$tabs){
                            echo esc_html__('Failed to get demo list.', 'ahura');
                        } elseif(!$license_status) {
                            echo esc_html__('Please active ahura theme license.', 'ahura');
                        } else {
                            echo esc_html__('An unknown error occurred.', 'ahura');
                        }
                        ?>
                        <?php if ($license_status): ?>
                            <br>
                            <span>(<?php echo esc_html__('Try again in a few minutes.', 'ahura'); ?>)</span>
                        <?php endif; ?>
                    </p>
                    <a href="<?php echo admin_url() ?>"><?php echo esc_html__('Back to dashboard', 'ahura') ?></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>