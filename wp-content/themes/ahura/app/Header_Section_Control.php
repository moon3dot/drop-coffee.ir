<?php
namespace ahura\app;

class Header_Section_Control {
    protected array $header_sections;
    protected $section_id;
    protected $section_template;
    protected $positions;
    protected $current_position = 'middle';


    public function __construct() {
        $this->header_sections = array();
        $this->positions = [
            'top' => [],
            'middle' => [],
            'bottom' => [],

            'topCenter' => [],
            'topLeft' => [],
            'topRight' => [],

            'middleCenter' => [],
            'middleLeft' => [],
            'middleRight' => [],

            'bottomCenter' => [],
            'bottomLeft' => [],
            'bottomRight' => [],
        ];
    }

    public function get_sections(){
        return $this->header_sections;
    }

    public function get_section($section_id){
        $this->section_template = isset($this->positions[$this->current_position][$section_id]) ? $this->positions[$this->current_position][$section_id] : null;
        return $this;
    }

    public function print_template(){
        echo $this->section_template;
    }

    public function get_positions(){
        return $this->positions;
    }

    public function set_position($position){
        $this->current_position = $position;
        return $this;
    }

    public function move_section($section_id, $position){
        $section_content = $this->get_section($section_id);
        if($section_content){
            unset($this->positions[$this->current_position][$section_id]);
            $this->positions[$position][$section_id] = $section_content;
        }
    }

    public function start_section($section_id) {
        $this->section_id = $section_id;
        ob_start();
    }

    public function end_section() {
        $section_content = ob_get_clean();
        $position = $this->current_position;
        $section_id = $this->section_id;
        $positions = $this->get_positions();

        if (!empty($section_id)) {
            array_walk_recursive($positions, function (&$value, $currentKey) use ($section_id) {
                if ($currentKey == $section_id) {
                    unset($value);
                }
            });
            $this->positions[$position][$section_id] = $section_content;
        }
    }
}