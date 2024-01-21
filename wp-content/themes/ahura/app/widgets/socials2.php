<?php
namespace ahura\app\widgets;

class socials2 extends \ahura\app\Ahura_Widget
{
    public function __construct()
    {
        $this->widget_id = 'ahura_social2';
        $this->widget_name = __( 'Ahura: Social Accounts 2', 'ahura' );
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
                        <select style="width: 100%;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);" id="<?php echo $this->get_field_id('social2') . '[' . $i . ']'.'[soicalselect]'; ?>" name="<?php echo $this->get_field_name('social2') . '[' . $i . ']'.'[soicalselect]'; ?>" type="text">
                            <option value="select" selected><?php echo __('Please Select Social','ahura');?></option>
                            <option value='Instagram' <?php echo isset($instance['social2'][$i]['soicalselect']) && $instance['social2'][$i]['soicalselect']  == 'Instagram' ? 'selected' : ''; ?>>
                                <?php echo __('Instagram', 'ahura'); ?>
                            </option>
                            <option value='Telegram' <?php echo isset($instance['social2'][$i]['soicalselect']) && $instance['social2'][$i]['soicalselect']  == 'Telegram'? 'selected' : ''; ?>>
                                <?php echo __('Telegram', 'ahura'); ?>
                            </option>
                            <option value='Youtube' <?php echo isset($instance['social2'][$i]['soicalselect'])  && $instance['social2'][$i]['soicalselect'] == 'Youtube' ? 'selected' : ''; ?>>
                                <?php echo __('Youtube', 'ahura'); ?>
                            </option>
                            <option value='Facebook' <?php echo isset($instance['social2'][$i]['soicalselect'])  && $instance['social2'][$i]['soicalselect']  == 'Facebook'? 'selected' : ''; ?>>
                                <?php echo __('Facebook', 'ahura'); ?>
                            </option>
                            <option value='Twitter' <?php echo isset($instance['social2'][$i]['soicalselect'])  && $instance['social2'][$i]['soicalselect'] == 'Twitter' ? 'selected' : ''; ?>>
                                <?php echo __('Twitter', 'ahura'); ?>
                            </option>
                            <option value='Linkedin' <?php echo isset($instance['social2'][$i]['soicalselect'])  && $instance['social2'][$i]['soicalselect']  == 'Linkedin'? 'selected' : ''; ?>>
                                <?php echo __('Linkedin', 'ahura'); ?>
                            </option>
                            <option value='Pinterest' <?php echo isset($instance['social2'][$i]['soicalselect']) && $instance['social2'][$i]['soicalselect'] == 'Pinterest' ? 'selected' : ''; ?>>
                                <?php echo __('Pinterest', 'ahura'); ?>
                            </option>
                            <option value='Aparat' <?php echo isset($instance['social2'][$i]['soicalselect']) && $instance['social2'][$i]['soicalselect']  == 'Aparat' ? 'selected' : ''; ?>>
                                <?php echo __('Aparat', 'ahura'); ?>
                            </option>
                            <option value='Whatsapp' <?php echo isset($instance['social2'][$i]['soicalselect']) && $instance['social2'][$i]['soicalselect']  == 'Whatsapp' ? 'selected' : ''; ?>>
                                <?php echo __('Whatsapp', 'ahura'); ?>
                            </option>
                        </select>
                    </p>
                    <p>
                        <input placeholder="<?php echo __('Address','ahura');?>" value="<?php echo isset($instance['social2'][$i]['url']) ? $instance['social2'][$i]['url'] : '';?>" class="widefat" type="text" name="<?php echo $this->get_field_name('social2') . '[' . $i . '][url]';?>" id="<?php echo $this->get_field_id('social2_url_' . $i)?>">
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('social2_open_in_newtab_' . $i);?>"><?php _e("Open in New Tab", 'ahura');?></label>
                        <input <?php echo isset($instance['social2'][$i]['open_in_newtab']) && $instance['social2'][$i]['open_in_newtab']  == true ? 'checked': '';?> class="widefat" type="checkbox" name="<?php echo $this->get_field_name('social2') . '[' . $i . '][open_in_newtab]';?>" id="<?php echo $this->get_field_id('social2_open_in_newtab_' . $i)?>">
                    </p>
                </div>
            <?php endfor; ?>
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
        $social = $instance['social2'];
    ?>
        <div class="social2-box widget-content">
            <?php
                foreach($social as $soc)
                {
                    if($soc['soicalselect'] != 'select'){
                        if($soc['url'] != ''){
                            $in_newtab = isset($soc['open_in_newtab']) && $soc['open_in_newtab']  == true ? 'target="blank"' : '';
                            switch($soc['soicalselect'])
                            {
                                case 'Instagram':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-instagram"><i class="fa fa-instagram"></i></div></a>';
                                break;
                                case 'Telegram':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-telegram"><i class="fa fa-telegram"></i></div></a>';
                                break;
                                case 'Youtube':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-youtube"><i class="fa fa-youtube"></i></div></a>';
                                break;
                                case 'Facebook':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-facebook"><i class="fa fa-facebook"></i></div></a>';
                                break;
                                case 'Twitter':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-twitter"><i class="fa fa-twitter"></i></div></a>';
                                break;
                                case 'Linkedin':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-linkedin"><i class="fa fa-linkedin"></i></div></a>';
                                break;
                                case 'Pinterest':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-pinterest"><i class="fa fa-pinterest"></i></div></a>';
                                break;
                                case 'Aparat':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-aparat"></div></a>';
                                break;
                                case 'Whatsapp':
                                    echo '<a '.$in_newtab.' href="'.$soc['url'].'"><div class="ahura-social2 ahura-social2-whatsapp"><i class="fa fa-whatsapp"></i></div></a>';
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
        $instance['social2'] = $new_instance['social2'];
        return $instance;
    }
}
