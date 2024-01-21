<?php
namespace ahura\app\widgets;

class contact extends \ahura\app\Ahura_Widget
{
    public function __construct()
    {
        $this->widget_id = 'ahura_contact';
        $this->widget_name = __( 'Ahura: Contact', 'ahura' );
        $this->widget_description = __('Ahura Show Contact info', 'ahura');
        parent::__construct();
    }

    public function widget($args, $instance)
    {
        // outputs the content of the widget
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        ob_start();

        echo $before_widget;
        if ($title) {
            echo $before_title . $title . $after_title;
        }
        $contact = $instance['contact'];
        ?>
        <div class="ahura_contact_widget widget-content">

            <?php
            if(isset($instance['contact']['email']) && $instance['contact']['email'] != ''){
                echo '<div class="ahura_contact_widget_item">';
                echo '<span>' . __('Email Address', 'ahura') . ' :</span>';
                echo '<p>' . $instance['contact']['email'] . '</p>';
                echo '</div>';
            }
            if(isset($instance['contact']['phone1']) && $instance['contact']['phone1'] != ''){
                echo '<div class="ahura_contact_widget_item">';
                echo '<span>' . __('Phone Number 1', 'ahura') . ' :</span>';
                echo '<p>' . $instance['contact']['phone1'] . '</p>';
                echo '</div>'; 
            }
            if(isset($instance['contact']['phone2']) && $instance['contact']['phone2'] != ''){
                echo '<div class="ahura_contact_widget_item">';
                echo '<span>' . __('Phone Number 2', 'ahura') . ' :</span>';
                echo '<p>' . $instance['contact']['phone2'] . '</p>';
                echo '</div>';
            }
            if(isset($instance['contact']['postalcode']) && $instance['contact']['postalcode'] != ''){
                echo '<div class="ahura_contact_widget_item">';
                echo '<span>' . __('Postal Code', 'ahura') . ' :</span>';
                echo '<p>' . $instance['contact']['postalcode'] . '</p>';
                echo '</div>';
            }
            if(isset($instance['contact']['fax']) && $instance['contact']['fax'] != ''){
                echo '<div class="ahura_contact_widget_item">';
                echo '<span>' . __('Fax', 'ahura') . ' :</span>';
                echo '<p>' . $instance['contact']['fax'] . '</p>';
                echo '</div>';
            }
            if(isset($instance['contact']['branch1']) && $instance['contact']['branch1'] != ''){
                echo '<div class="ahura_contact_widget_item">';
                echo '<span>' . __('Branch 1', 'ahura') . ' :</span>';
                echo '<p>' . $instance['contact']['branch1'] . '</p>';
                echo '</div>';
            }
            if(isset($instance['contact']['branch2']) && $instance['contact']['branch2'] != ''){
                echo '<div class="ahura_contact_widget_item">';
                echo '<span>' . __('Branch 2', 'ahura') . ' :</span>';
                echo '<p>' . $instance['contact']['branch2'] . '</p>';
                echo '</div>';
            }
            if(isset($instance['contact']['hours_of_work']) && $instance['contact']['hours_of_work'] != ''){
                echo '<div class="ahura_contact_widget_item">';
                echo '<span>' . __('Hours of work', 'ahura') . ' :</span>';
                echo '<p>' . $instance['contact']['hours_of_work'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    <?php
        echo $after_widget;

        $w_content = ob_get_clean();
        echo $w_content;
    }

    public function form($instance)
    {
        // outputs the options form in the admin
        $title = isset($instance['title']) ? $instance['title'] : __('Contact', 'ahura');
    ?>
        <div class="ahura-edit-widget-form">
            <p>
                <label for="<?php echo $this->get_field_id('title') ?>"><?php _e("Title", 'ahura'); ?></label>
                <input value="<?php echo $title; ?>" type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title'); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('contact') . '[email]'; ?>"><?php echo __("Email Address", 'ahura'); ?></label>
                <input value="<?php echo isset($instance['contact']['email']) ? $instance['contact']['email'] : ''; ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('contact') . '[email]'; ?>" id="<?php echo $this->get_field_id('contact') . '[email]'; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('contact') . '[phone1]'; ?>"><?php echo __("Phone Number 1", 'ahura'); ?></label>
                <input value="<?php echo isset($instance['contact']['phone1']) ? $instance['contact']['phone1'] : ''; ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('contact') . '[phone1]'; ?>" id="<?php echo $this->get_field_id('contact') . '[phone1]'; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('contact') . '[phone2]'; ?>"><?php echo __("Phone Number 2", 'ahura'); ?></label>
                <input value="<?php echo isset($instance['contact']['phone2']) ? $instance['contact']['phone2'] : ''; ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('contact') . '[phone2]'; ?>" id="<?php echo $this->get_field_id('contact') . '[phone2]'; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('contact') . '[postalcode]'; ?>"><?php echo __("Postal Code", 'ahura'); ?></label>
                <input value="<?php echo isset($instance['contact']['postalcode']) ? $instance['contact']['postalcode'] : ''; ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('contact') . '[postalcode]'; ?>" id="<?php echo $this->get_field_id('contact') . '[postalcode]'; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('contact') . '[fax]' ?>"><?php echo __("Fax", 'ahura'); ?></label>
                <input value="<?php echo isset($instance['contact']['fax']) ? $instance['contact']['fax'] : ''; ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('contact') . '[fax]'; ?>" id="<?php echo $this->get_field_id('contact') . '[fax]'; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('contact') . '[branch1]'; ?>"><?php echo __("Branch 1", 'ahura'); ?></label>
                <input value="<?php echo isset($instance['contact']['branch1']) ? $instance['contact']['branch1'] : ''; ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('contact') . '[branch1]'; ?>" id="<?php echo $this->get_field_id('contact') . '[branch1]'; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('contact') . '[branch2]'; ?>"><?php echo __("Branch 2", 'ahura'); ?></label>
                <input value="<?php echo isset($instance['contact']['branch1']) ? $instance['contact']['branch2'] : ''; ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('contact') . '[branch2]'; ?>" id="<?php echo $this->get_field_id('contact') . '[branch2]'; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('contact') . '[hours_of_work]'; ?>"><?php echo __("Hours of work", 'ahura'); ?></label>
                <input value="<?php echo isset($instance['contact']['hours_of_work']) ? $instance['contact']['hours_of_work'] : ''; ?>" class="widefat" type="text" name="<?php echo $this->get_field_name('contact') . '[hours_of_work]'; ?>" id="<?php echo $this->get_field_id('contact') . '[hours_of_work]'; ?>">
            </p>
        </div>
<?php
    }
    public function update($new_instance, $old_instance)
    {
        // processes widget options to be saved
        $instance = [];
        $instance['title'] = $new_instance['title'] ? strip_tags($new_instance['title']) : '';
        $instance['contact'] = $new_instance['contact'];
        return $instance;
    }
}
