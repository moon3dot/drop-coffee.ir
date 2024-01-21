<?php
namespace ahura\app;

class Post_Tag_Filter{
    public static function get_tag_level($tag = ''){
        $levels = [
            'h1' => 0,
            'h2' => 1,
            'h3' => 2,
            'h4' => 3,
            'h5' => 4,
            'h6' => 5,
        ];

        return !empty($tag) && isset($levels[$tag]) ? $levels[$tag] : 0;
    }

    public static function get_tags($content, $allowed_tags = []){
        $nodes = [];
        $tags = [];
        if(!empty($content) && !empty($allowed_tags) && class_exists('DOMDocument')){
            $dom = new \DOMDocument('1.0', 'utf-8');
            $dom->loadHTML(mb_encode_numericentity($content, [0x80, 0x10FFFF, 0, ~0], 'UTF-8'), LIBXML_NOERROR);
            $dom->preserveWhiteSpace = false;
            if(is_array($allowed_tags) && count($allowed_tags) > 0){
                $data = $dom->getElementsByTagName('*');
                if($data){
                    foreach($data as $tag1){
                        $nodes[] = [$tag1->nodeName, $tag1->nodeValue];
                    }
                }
                if(is_array($nodes) && count($nodes)){
                    foreach($nodes as $key => $value){
                        if(in_array($value[0], $allowed_tags)){
                            $tags[] = ['tag' => $value[0], 'content' => $value[1]];
                        }
                    }
                }
            }
        }
        return (is_array($tags) && count($tags)) ? $tags : false;
    }

    /**
     * 
     *
     *  Filter post content callback
     * 
     * 
     */
    public static function the_content_headings_filter($content){
		$output = '';
        if(is_single() && get_post_type() === 'post'){
            $headings = self::get_tags($content, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6']);

            if (!is_array($headings) || !count($headings)) return $content;

            $output .= "<div class='ahura-post-headings-navigation'>";
            $output .= "<nav class='aphv-items'><ul>";
            $i = 0;
            foreach($headings as $key => $value){
                $title = $value['content'];
                $tag = $value['tag'];
                $href = sanitize_title($title);
                $level = self::get_tag_level($tag);
                $id = md5($href);
                $output .= "<li class='item-level-{$level}'><a href='#{$href}' data-num='{$i}' data-tag='{$tag}' data-id='{$id}' data-name='{$title}'>{$title}</a></li>";
                $i++;
            }
            $output .= "</ul></nav>";
            $output .= "</div>";
			$output .= $content;
        }

        return !empty($output) ? $output : $content;
    }
}