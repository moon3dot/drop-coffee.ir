<?php
namespace ahura\app;

abstract class Ahura_Widget extends \WP_Widget {
    /**
     * Widget ID.
     *
     * @var string
     */
    public $widget_id;

    /**
     * CSS class.
     *
     * @var string
     */
    public $widget_cssclass;

    /**
     * Widget description.
     *
     * @var string
     */
    public $widget_description;

    /**
     * Widget name.
     *
     * @var string
     */
    public $widget_name;

    /**
     * Settings.
     *
     * @var array
     */
    public $settings;

    public function __construct() {
        $widget_ops = array(
            'classname'                   => $this->widget_cssclass,
            'description'                 => $this->widget_description,
            'customize_selective_refresh' => true,
            'show_instance_in_rest'       => true,
        );

        parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );
    }

    protected function get_instance_title( $instance ) {
        if ( isset( $instance['title'] ) ) {
            return $instance['title'];
        }

        return '';
    }

    public function widget_start( $args, $instance ) {
        echo isset($args['before_widget']) ? $args['before_widget'] : '';

        $title = apply_filters('widget_title', $this->get_instance_title($instance), $instance, $this->id_base);

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $this->before_content();
    }


    public function widget_end( $args ) {
        $this->after_content();
        echo isset($args['after_widget']) ? $args['after_widget'] : '';
    }

    protected function before_content(){
        echo apply_filters('ah_before_widget_content', '<div class="ah-widget-content widget-content">');
    }

    protected function after_content(){
        echo apply_filters('ah_after_widget_content', '</div>');
    }

    public function get_cached_widget( $args ) {
        if ( empty( $args['widget_id'] ) ) {
            return false;
        }

        $cache = wp_cache_get( $this->get_widget_id_for_cache( $this->widget_id ), 'widget' );

        if ( ! is_array( $cache ) ) {
            $cache = array();
        }

        if ( isset( $cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ] ) ) {
            echo $cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ];
            return true;
        }

        return false;
    }

    public function cache_widget( $args, $content ) {
        if ( empty( $args['widget_id'] ) ) {
            return $content;
        }

        $cache = wp_cache_get( $this->get_widget_id_for_cache( $this->widget_id ), 'widget' );

        if ( ! is_array( $cache ) ) {
            $cache = array();
        }

        $cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ] = $content;

        wp_cache_set( $this->get_widget_id_for_cache( $this->widget_id ), $cache, 'widget' );

        return $content;
    }

    public function flush_widget_cache() {
        foreach ( array( 'https', 'http' ) as $scheme ) {
            wp_cache_delete( $this->get_widget_id_for_cache( $this->widget_id, $scheme ), 'widget' );
        }
    }

    protected function get_widget_id_for_cache( $widget_id, $scheme = '' ) {
        if ( $scheme ) {
            $widget_id_for_cache = $widget_id . '-' . $scheme;
        } else {
            $widget_id_for_cache = $widget_id . '-' . ( is_ssl() ? 'https' : 'http' );
        }

        return apply_filters( 'ahura_cached_widget_id', $widget_id_for_cache );
    }
}