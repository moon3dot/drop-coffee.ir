<?php
namespace ahura\app\elementor;

abstract class Elementor_Widget_Base extends \Elementor\Widget_Base
{
    public function fixedEmptyContentInEditor(){
        if (is_admin()){
            echo "<em style='display:inline-block;opacity:0;overflow:hidden;width:0;height:0;color:transparent;' class='fixed-empty'>empty</em>";
        }
    }
}