<?php
namespace ahura\app\widgets;

class socials3 extends \ahura\app\Ahura_Widget
{
    public function __construct()
    {
        $this->widget_id = 'ahura_social3';
        $this->widget_name = __( 'Ahura: Social Accounts 3', 'ahura' );
        $this->widget_description = __('Your social accounts link', 'ahura');
        parent::__construct();
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : __('Social Accounts Link', 'ahura');
?>
        <div class="ahura-edit-widget-form">
            <p>
                <label for="<?php echo $this->get_field_id('title') ?>"><?php _e("Title", 'ahura'); ?></label>
                <input value="<?php echo $title; ?>" type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title'); ?>">
            </p>
            <?php for ($i = 0; $i <= 8; $i++) : ?>
                <div class="social-item">
                    <p>
                        <select style="width: 100%;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);" id="<?php echo $this->get_field_id('social3') . '[' . $i . ']'.'[soicalselect]'; ?>" name="<?php echo $this->get_field_name('social3') . '[' . $i . ']'.'[soicalselect]'; ?>" type="text">
                            <option value="select" selected><?php echo __('Please Select Social','ahura');?></option>
                            <option value='Instagram' <?php echo isset($instance['social3'][$i]['soicalselect']) && $instance['social3'][$i]['soicalselect']  == 'Instagram' ? 'selected' : ''; ?>>
                                <?php echo __('Instagram', 'ahura'); ?>
                            </option>
                            <option value='Telegram' <?php echo isset($instance['social3'][$i]['soicalselect']) && $instance['social3'][$i]['soicalselect']  == 'Telegram'? 'selected' : ''; ?>>
                                <?php echo __('Telegram', 'ahura'); ?>
                            </option>
                            <option value='Youtube' <?php echo isset($instance['social3'][$i]['soicalselect'])  && $instance['social3'][$i]['soicalselect'] == 'Youtube' ? 'selected' : ''; ?>>
                                <?php echo __('Youtube', 'ahura'); ?>
                            </option>
                            <option value='Facebook' <?php echo isset($instance['social3'][$i]['soicalselect'])  && $instance['social3'][$i]['soicalselect']  == 'Facebook'? 'selected' : ''; ?>>
                                <?php echo __('Facebook', 'ahura'); ?>
                            </option>
                            <option value='Twitter' <?php echo isset($instance['social3'][$i]['soicalselect'])  && $instance['social3'][$i]['soicalselect'] == 'Twitter' ? 'selected' : ''; ?>>
                                <?php echo __('Twitter', 'ahura'); ?>
                            </option>
                            <option value='Linkedin' <?php echo isset($instance['social3'][$i]['soicalselect'])  && $instance['social3'][$i]['soicalselect']  == 'Linkedin'? 'selected' : ''; ?>>
                                <?php echo __('Linkedin', 'ahura'); ?>
                            </option>
                            <option value='Pinterest' <?php echo isset($instance['social3'][$i]['soicalselect']) && $instance['social3'][$i]['soicalselect'] == 'Pinterest' ? 'selected' : ''; ?>>
                                <?php echo __('Pinterest', 'ahura'); ?>
                            </option>
                            <option value='Aparat' <?php echo isset($instance['social3'][$i]['soicalselect']) && $instance['social3'][$i]['soicalselect']  == 'Aparat' ? 'selected' : ''; ?>>
                                <?php echo __('Aparat', 'ahura'); ?>
                            </option>
                            <option value='Whatsapp' <?php echo isset($instance['social3'][$i]['soicalselect']) && $instance['social3'][$i]['soicalselect']  == 'Whatsapp' ? 'selected' : ''; ?>>
                                <?php echo __('Whatsapp', 'ahura'); ?>
                            </option>
                        </select>
                    </p>
                    <p>
                        <input placeholder="<?php echo __('Address','ahura');?>" value="<?php echo isset($instance['social3'][$i]['url']) ? $instance['social3'][$i]['url'] : '';?>" class="widefat" type="text" name="<?php echo $this->get_field_name('social3') . '[' . $i . '][url]';?>" id="<?php echo $this->get_field_id('social3_url_' . $i)?>">
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('social4_open_in_newtab_' . $i);?>"><?php _e("Open in New Tab", 'ahura');?></label>
                        <input <?php echo isset($instance['social3'][$i]['open_in_newtab']) && $instance['social3'][$i]['open_in_newtab']  == true ? 'checked': '';?> class="widefat" type="checkbox" name="<?php echo $this->get_field_name('social3') . '[' . $i . '][open_in_newtab]';?>" id="<?php echo $this->get_field_id('social3_open_in_newtab_' . $i)?>">
                    </p>
                </div>
            <?php endfor; ?>
            <p>
                <input type="checkbox" name="<?php echo $this->get_field_name('social3_name'); ?>" id="<?php echo $this->get_field_id('social3_name');?>" <?php echo isset($instance['social3_name']) ? 'checked' : '';?>>
                <label for="<?php echo $this->get_field_id('social3_name');?>"><?php echo __('Show Socials Media Name','ahura');?></label>
            </p>
        </div>
    <?php
    }

    public function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        ob_start();

        echo $before_widget;
        if ($title) {
            echo $before_title . $title . $after_title;
        }
        $social = $instance['social3'];
    ?>
        <div class="social3-box widget-content">
            <?php
             $social_name = $instance['social3_name'];
             $social_name_instagram =   $instance['social3_name'] ? '<span>'.__('Instagram','ahura').'</span>' : '';
             $social_name_telegram =    $instance['social3_name'] ? '<span>'.__('Telegram','ahura').'</span>' : '';
             $social_name_youtube =     $instance['social3_name'] ? '<span>'.__('Youtube','ahura').'</span>' : '';
             $social_name_facebook =    $instance['social3_name'] ? '<span>'.__('Facebook','ahura').'</span>' : '';
             $social_name_twitter =     $instance['social3_name'] ? '<span>'.__('Twitter','ahura').'</span>' : '';
             $social_name_linkedin =    $instance['social3_name'] ? '<span>'.__('Linkedin','ahura').'</span>' : '';
             $social_name_pinterest =   $instance['social3_name'] ? '<span>'.__('Pinterest','ahura').'</span>' : '';
             $social_name_aparat =      $instance['social3_name'] ? '<span>'.__('Aparat','ahura').'</span>' : '';
             $social_name_whatsapp =    $instance['social3_name'] ? '<span>'.__('Whatsapp','ahura').'</span>' : '';
                foreach($social as $soc)
                {
                    if($soc['soicalselect'] != 'select'){
                        if($soc['url'] != ''){
                            $in_newtab = isset($soc['open_in_newtab']) && $soc['open_in_newtab']  == true ? 'target="blank"' : '';
                            switch($soc['soicalselect'])
                            {
                                case 'Instagram':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-instagram"><i class="fa fa-instagram"></i>'.$social_name_instagram.'</div></a>';
                                break;
                                case 'Telegram':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-telegram"><i class="fa fa-telegram"></i>'.$social_name_telegram.'</div></a>';
                                break;
                                case 'Youtube':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-youtube"><i class="fa fa-youtube"></i>'.$social_name_youtube.'</div></a>';
                                break;
                                case 'Facebook':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-facebook"><i class="fa fa-facebook"></i>'.$social_name_facebook.'</div></a>';
                                break;
                                case 'Twitter':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-twitter"><i class="fa fa-twitter"></i>'.$social_name_twitter.'</div></a>';
                                break;
                                case 'Linkedin':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-linkedin"><i class="fa fa-linkedin"></i>'.$social_name_linkedin.'</div></a>';
                                break;
                                case 'Pinterest':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-pinterest"><i class="fa fa-pinterest"></i>'.$social_name_pinterest.'</div></a>';
                                break;
                                case 'Aparat':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-aparat">'.$social_name_aparat.'</div></a>';
                                break;
                                case 'Whatsapp':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social3 ahura-social3-whatsapp"><i class="fa fa-whatsapp"></i>'.$social_name_whatsapp.'</div></a>';
                                break;
                            }
                        }
                    }
                }
            ?>
        </div>
    <?php
        echo $after_widget;

        $w_content = ob_get_clean();
        echo $w_content;
    }
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        // $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['social3'] = $new_instance['social3'];
        $instance['social3_name'] = $new_instance['social3_name'];
        return $instance;
    }
}
