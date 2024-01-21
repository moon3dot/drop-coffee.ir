<?php
namespace ahura\app\widgets;

class show_posts extends \ahura\app\Ahura_Widget
{
    public function __construct()
    {
        $this->widget_id = 'ahura_posts';
        $this->widget_name = __( 'Ahura: Show Posts', 'ahura' );
        $this->widget_description = __('Ahura Show Posts', 'ahura');
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        // outputs the content of the widget
        extract( $args );
        $title = apply_filters( 'widget_title', (isset($instance['title']) ? $instance['title'] : '') );

        ob_start();

        echo $before_widget;
        if ( $title ) echo $before_title . $title . $after_title;
        $cat = isset($instance['category']) ? $instance['category'] : '';
        $tag = isset($instance['tag']) ? $instance['tag'] : '';
        $count = isset($instance['count']) ? $instance['count'] : '';
        $author = isset($instance['author']) && !empty($instance['author']) ? $instance['author'] : '';
        $date = isset($instance['date']) && !empty($instance['date']) ? $instance['date'] : '';
        $order_asc = isset($instance['order_asc']) && !empty($instance['order_asc']) ? $instance['order_asc'] : '';
        ?>
        <?php
        if( $cat == 'random' ){
        $the_query = new \WP_Query( ['post_type' => 'post', 'orderby' => 'rand', 'posts_per_page' => $count] );
        } else {
            if( $order_asc == 'on' ) {
                $the_query = new \WP_Query( ['tax_query' => ['relation' => 'OR', ['taxonomy' => 'category', 'field' => 'term_id', 'terms' => $cat], ['taxonomy' => 'post_tag', 'field' => 'term_id', 'terms' => $tag]], 'posts_per_page' => $count, 'order' => 'ASC'] );
            } else {
                $the_query = new \WP_Query( ['tax_query' => ['relation' => 'OR', ['taxonomy' => 'category', 'field' => 'term_id', 'terms' => $cat], ['taxonomy' => 'post_tag', 'field' => 'term_id', 'terms' => $tag]], 'posts_per_page' => $count] );
            }
        }
        ?>
        <?php if ( $the_query->have_posts() ) : ?>
            <div class="widget-content">
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="ahura-show-posts">
                    <article>
                        <a class="ahura-show-posts-box" href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="ahura-show-posts-thumbnail"><?php the_post_thumbnail('smthumb'); ?></div>
                            <?php else : ?>
                                <div class="ahura-show-posts-thumbnail"><img width="100" src="<?php bloginfo( 'template_url' ); ?>/img/default.png" alt=""></div>
                            <?php endif ?>
                            <div class="ahura-show-posts-box-details">
                            <span><?php the_title(); ?></span>
                            <?php
                            if ( $author ) {
                                echo '<span class="ahura-show-posts-author"><i class="fa fa-user"></i> : ' . get_the_author() . '</span>';
                            }
                            if ( $date ) {
                                echo '<span class="ahura-show-posts-date"><i class="fa fa-calendar"></i> : ' . get_the_date() . '</span>';
                            }
                            ?>
                        </div>
                        </a>
                        <div class="clear"></div>
                    </article>
                </div>
            <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p><?php echo __( 'Nothing Found!', 'ahura' ); ?></p>
        <?php endif; ?>
    <?php
        echo $after_widget;

        $content = ob_get_clean();
        echo $this->cache_widget( $args, $content );
    }

    public function form($instance) {
        // outputs the options form in the admin
        $title = isset( $instance['title'] ) ? $instance['title'] : __( 'Show Posts', 'ahura' );
        $count = isset( $instance['count'] ) ? $instance['count'] : '';
        $author = isset( $instance['author'] ) ? $instance['author'] : '';
        $date = isset( $instance['date'] ) ? $instance['date'] : '';
        $order_asc = isset( $instance['order_asc'] ) ? $instance['order_asc'] : '';
        ?>
        <div class="ahura-edit-widget-form">
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( "Title", 'ahura' ); ?></label>
                <input value="<?php echo $title; ?>" type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'category' ) ?>"><?php _e( "Category", 'ahura' ); ?></label>
                <select style="width: 100%;" name="<?php echo $this->get_field_name( 'category' );?>" id="<?php $this->get_field_id( 'category' );?>">
                    <option value="none"><?php echo __( 'Please Select','ahura' )?></option>
                    <option <?php echo isset($instance['category']) && $instance['category'] == 'random' ? 'selected' : ''?> value="random"><?php echo __( 'Show Random','ahura' )?></option>
                    <?php foreach ( get_categories() as $name ):?>
                        <option <?php echo isset($instance['category']) && $instance['category'] == $name->term_id ? 'selected' : ''?> value="<?php echo $name->term_id?>"><?php echo $name->name?></option>
                    <?php endforeach;?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'tag' ) ?>"><?php _e( "Tag", 'ahura' ); ?></label>
                <select style="width: 100%;" name="<?php echo $this->get_field_name( 'tag' );?>" id="<?php $this->get_field_id( 'tag' );?>">
                    <option value="none"><?php echo __( 'Please Select','ahura' )?></option>
                    <option <?php echo isset($instance['tag']) && $instance['tag'] == 'random' ? 'selected' : ''?> value="random"><?php echo __( 'Show Random','ahura' )?></option>
                    <?php foreach ( get_tags() as $name ):?>
                        <option <?php echo $instance['tag'] == $name->name ? 'selected' : ''?> value="<?php echo $name->term_id?>"><?php echo $name->name?></option>
                    <?php endforeach;?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'count' ) ?>"><?php _e( "Count", 'ahura' ); ?></label>
                <input min="1" placeholder="<?php echo __( 'Count', 'ahura' ); ?>" value="<?php echo isset( $count ) ? $count : 3; ?>" type="number" class="widefat" id="<?php echo $this->get_field_id( 'count' ) ?>" name="<?php echo $this->get_field_name( 'count' ); ?>">
            </p>
            <p>
                <input type="checkbox" name="<?php echo $this->get_field_name( 'author' ); ?>" id="<?php echo $this->get_field_id( 'author' ); ?>" <?php echo !empty($author) ? 'checked' : ''; ?>>
                <label for="<?php echo $this->get_field_id( 'author' ); ?>"><?php echo __( 'Show Author', 'ahura' ); ?></label>
            </p>
            <p>
                <input type="checkbox" name="<?php echo $this->get_field_name( 'date' ); ?>" id="<?php echo $this->get_field_id( 'date' ); ?>" <?php echo !empty($date) ? 'checked' : ''; ?>>
                <label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php echo __( 'Show Date', 'ahura' ); ?></label>
            </p>
            <p>
                <input type="checkbox" name="<?php echo $this->get_field_name( 'order_asc' ); ?>" id="<?php echo $this->get_field_id( 'order_asc' ); ?>" <?php echo !empty($order_asc) ? 'checked' : ''; ?>>
                <label for="<?php echo $this->get_field_id( 'order_asc' ); ?>"><?php echo __( 'Show ascending', 'ahura' ); ?></label>
            </p>
        </div>
    <?php
    }

    public function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'] ? strip_tags( $new_instance['title'] ) : '';
        $instance['category'] = $new_instance['category'];
        $instance['tag'] = $new_instance['tag'];
        $instance['count'] = $new_instance['count'];
        $instance['author'] = isset($new_instance['author']) ? 'on' : null;
        $instance['date'] = isset($new_instance['date']) ? 'on' : null;
        $instance['order_asc'] = isset($new_instance['order_asc']) ? 'on' : null;
        return $instance;
    }
}
