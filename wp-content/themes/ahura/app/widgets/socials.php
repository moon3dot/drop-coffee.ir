<?php
namespace ahura\app\widgets;

class socials extends \ahura\app\Ahura_Widget
{
    public function __construct() {
        $this->widget_id = 'ahura_social';
        $this->widget_name = __( 'Ahura: Social Accounts', 'ahura' );
        $this->widget_description = __('Your social accounts link', 'ahura');
        parent::__construct();
    }
 
    public function widget( $args, $instance ) {
        // outputs the content of the widget
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        ob_start();

        echo $before_widget;
        if($title)
        {
            echo $before_title . $title . $after_title;
        }
        $social = isset($instance['social']) ? $instance['social'] : '';
        if($social):
        ?>
        <div class="ahura_social_widget widget-content">
            <?php foreach($social as $item): if($item['icon']):?>
                <a <?php echo isset($item['open_in_newtab']) && $item['open_in_newtab'] == true ? 'target="blank"' : '';?> href="<?php echo isset($item['url']) && $item['url'] ? $item['url'] : ''; ?>"><img src="<?php echo $item['icon']; ?>" alt="#"></a>
            <?php endif; endforeach; ?>
        </div>
        <?php
        endif;
        echo $after_widget;

        $w_content = ob_get_clean();
        echo $w_content;
    }
 
    public function form( $instance ) {
        // outputs the options form in the admin
        $title = isset($instance['title']) ? $instance['title'] : __('Social Accounts Link', 'ahura');
        ?>
        <div class="ahura-edit-widget-form">
            <p>
                <label for="<?php echo $this->get_field_id('title')?>"><?php _e("Title", 'ahura');?></label>
                <input value="<?php echo $title;?>" type="text" class="widefat" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title');?>">
            </p>
            <?php for($i=1; $i <= 4; $i++): ?>
                <div class="social-item">
                    <p>
                        <label for="<?php echo $this->get_field_id('social_icon_' . $i);?>"><span><?php _e("Social Account Icon", 'ahura');?></span><a class="ahura_social_upload" href="#"><?php _e("Upload media", 'ahura');?></a></label>
                        <input value="<?php echo isset($instance['social'][$i]['icon']) ? $instance['social'][$i]['icon'] : '';?>" class="widefat" type="text" name="<?php echo $this->get_field_name('social') . '['.$i.'][icon]'?>" id="<?php echo $this->get_field_id('social_icon_' . $i)?>">
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('social_url_' . $i);?>"><?php _e("Social Account URL", 'ahura');?></label>
                        <input value="<?php echo isset($instance['social'][$i]['url']) ? $instance['social'][$i]['url'] : '';?>" class="widefat" type="text" name="<?php echo $this->get_field_name('social') . '[' . $i . '][url]';?>" id="<?php echo $this->get_field_id('social_url_' . $i)?>">
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('social_open_in_newtab_' . $i);?>"><?php _e("Open in New Tab", 'ahura');?></label>
                        <input <?php echo isset($instance['social'][$i]['open_in_newtab']) && $instance['social'][$i]['open_in_newtab']  == true ? 'checked': '';?> class="widefat" type="checkbox" name="<?php echo $this->get_field_name('social') . '[' . $i . '][open_in_newtab]';?>" id="<?php echo $this->get_field_id('social_open_in_newtab_' . $i)?>">
                    </p>
                </div>
            <?php endfor; ?>
        </div>
    <?php }
 
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = [];
        $instance['title'] = $new_instance['title'] ? strip_tags($new_instance['title']) : '';
        $instance['social'] = $new_instance['social'];
        return $instance;
    }
}