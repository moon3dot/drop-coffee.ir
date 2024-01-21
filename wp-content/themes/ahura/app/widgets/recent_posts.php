<?php
namespace ahura\app\widgets;

class recent_posts extends \WP_Widget_Recent_Posts
{
    function widget($args, $instance) {

            if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $r = new \WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );
        if ($r->have_posts()) :
        ?>
        <?php echo $args['before_widget']; ?>
        <?php if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        } ?>
        <div class="widget-content">
            <ul class="list-posts-widget">
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                <a href="<?php the_permalink(); ?>">
                    <?php
                    if(has_post_thumbnail()){
                        the_post_thumbnail( 'thumbnail' );
                    }else{
                        echo '<img src="'.get_template_directory_uri().'/img/default.png"/>';
                    }
                    ?>
                <p><?php get_the_title() ? the_title() : the_ID(); ?></p></a>
                <?php if ( $show_date ) : ?>
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                <?php endif; ?>
                </li><div class="clear"></div>
            <?php endwhile; ?>
            </ul>
        </div>
        <?php echo $args['after_widget']; ?>
        <?php
        wp_reset_postdata();
        endif;
    }
}