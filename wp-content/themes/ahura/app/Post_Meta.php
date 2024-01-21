<?php
namespace ahura\app;

class Post_Meta
{
    public static function get_post_id($post_id = 0){
        return !$post_id && function_exists('get_post_ID') ? get_post_ID() : $post_id;
    }

    public static function get_post_meta($post_id, $key, $single = false){
        return get_post_meta(self::get_post_id($post_id), $key, $single);
    }

    public static function get_section_type($post_id = 0){
        return self::get_post_meta(self::get_post_id($post_id), 'section_builder_type', true);
    }

    public static function get_template_type($post_id = 0){
        return self::get_post_meta(self::get_post_id($post_id), 'section_builder_template_page', true);
    }
}