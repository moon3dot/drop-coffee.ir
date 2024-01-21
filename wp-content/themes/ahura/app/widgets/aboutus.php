<?php
namespace ahura\app\widgets;

class aboutus extends \ahura\app\Ahura_Widget {

    function __construct() {
        $this->widget_id = 'aboutus';
        $this->widget_name = __( 'Ahura: About Us', 'ahura' );
        parent::__construct();
    }
 
    public $args = [
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    ];
 
    public function widget( $args, $instance ) {
        ob_start();

        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        } 
        echo '<div class="textwidget widget-content">';
        echo esc_html__( $instance['text'], 'ahura' ); 
        echo '</div>';
        echo $args['after_widget'];

        $content = ob_get_clean();
        echo $content;
    }
 
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $text = ! empty( $instance['text'] ) ? $instance['text'] : '';
        ?>
        <div class="ahura-edit-widget-form">
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php printf('%s:', esc_html__('Title', 'ahura')); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'Text' ) ); ?>"><?php printf('%s:', esc_html__( 'Text', 'ahura' )); ?></label>
                <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" cols="30" rows="10"><?php echo esc_attr( $text ); ?></textarea>
            </p>
        </div>
        <?php
    }
 
    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['text'] = ( !empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
        return $instance;
    }
}
