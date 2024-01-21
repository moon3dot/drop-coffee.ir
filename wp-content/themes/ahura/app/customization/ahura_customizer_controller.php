<?php
namespace ahura\app\customization;
if(class_exists('WP_Customize_Control'))
{
    class ahura_customizer_controller extends \WP_Customize_Control
    {
        private $_args;
        function __construct($manager, $id, $args=[])
        {
            parent::__construct($manager, $id, $args);
            $this->_args = $args;
        }
        function show_link()
        {
            if(!$this->_args || !isset($this->_args['links']) || !is_array($this->_args['links']) || !$this->_args['links'])
            {
                return false;
            }
            echo '<div class="ahura-customizer-controller-link-wrapper">';
            foreach($this->_args['links'] as $item)
            {
                $url = isset($item['url']) ? $item['url'] : false;
                $title = isset($item['title']) ? $item['title'] : false;
                $target = isset($item['target']) ? 'target="'.$item['target'].'"' : false;
                $class = isset($item['class']) ? 'class="'.$item['class'].'"' : false;
                echo "<span><a {$target} {$class} href='{$url}'>{$title}</a></span>";
            }
            echo '</div>';
        }
    }
}