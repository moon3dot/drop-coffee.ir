<?php
namespace ahura\app\widgets;

class contact2 extends \ahura\app\Ahura_Widget
{
    /**
     * contact2 constructor.
     *
     * creating widget
     */
    function __construct()
    {
        $this->widget_id = 'ahura_contact2';
        $this->widget_name = __( 'Ahura: Contact 2', 'ahura' );
        $this->widget_description = __('Ahura Show Contact info', 'ahura');
        parent::__construct();
    }

    /**
     * @param $args
     * @param $instance
     *
     * Display widget front-end
     */
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $items = apply_filters('widget_items', $instance['items']);
        // outputs the content of the widget
        extract($args);

        ob_start();

        echo $before_widget;
        if ($title) {
            echo $before_title . $title . $after_title;
        }
        ?>
        <div class="ahura_contact_widget widget-content">
        <?php
        if($items && isset($items['contacts'])):
            foreach($items['contacts'] as $key => $value):
                ?>
                <div class="ci">
                    <div class="ahura_contact_widget_item">
                        <span><?php echo $value['title'] ?></span>
                        <p><?php echo $value['value'] ?></p>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
        ?>
        </div>
        <?php
        echo $after_widget;

        $w_content = ob_get_clean();
        echo $w_content;
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : esc_html__('Contact', 'ahura');
        $items = isset($instance['items']) ? $instance['items'] : [];
        ?>
        <div class="ahura-edit-widget-form ahura_contact_widget_box">
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget title', 'ahura'); ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
            </p>
            <div class="contact-2-widget-items">
                <?php
                if($items && isset($items['contacts'])):
                    foreach($items['contacts'] as $key => $value):
                    ?>
                        <div class="contact-item" item-id="<?php echo $key ?>">
                            <button class="ahura_contact_item_delete acid" type="button" data-widget-id="<?php echo $this->id ?>"><?php _e('Delete', 'ahura')?></button>
                            <br>
                            <label><?php _e('Title', 'ahura')?></label>
                            <input type="text" value="<?php echo $value['title'] ?>" class="widefat" id="widget-<?php echo $this->id ?>-items-<?php echo $key ?>" name="widget-<?php echo $this->id_base ?>[<?php echo $this->number ?>][items][contacts][<?php echo $key ?>][title]">
                            <label><?php _e('Value', 'ahura')?></label>
                            <input type="text" value="<?php echo $value['value'] ?>" class="widefat" id="widget-<?php echo $this->id ?>-items-<?php echo $key ?>" name="widget-<?php echo $this->id_base ?>[<?php echo $this->number ?>][items][contacts][<?php echo $key ?>][value]">
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <input id="contact_count" type="hidden" value="0"/>
            <button id="ahura_contact_widget_new_info" type="button" data-widget-id="<?php echo $this->id ?>" data-item-name="<?php echo $this->get_field_name('items'); ?>" data-item-id="<?php echo $this->get_field_id('items'); ?>">
                <?php _e('Add new item', 'ahura') ?>
            </button>
        </div>
    <?php }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['items'] = ($new_instance['items']) ? $new_instance['items'] : '';
        return $instance;
    }
}
