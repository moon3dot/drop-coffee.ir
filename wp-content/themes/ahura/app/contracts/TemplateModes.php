<?php
namespace ahura\app\contracts;

abstract class TemplateModes implements TemplateModesInterface
{
    protected $templateName;
    protected $templateMode = 1;
    protected $data;

    protected function get_dir()
    {
        $dir = get_template_directory() . "/template-parts/{$this->templateName}/modes/";
        return apply_filters("ahura_get_{$this->templateName}_dir", $dir);
    }

    protected function get_file_path()
    {
        $dir = $this->get_dir();
        $file_path = $dir . "{$this->templateName}-{$this->templateMode}" . '.php';
        return apply_filters("ahura_get_{$this->templateName}_file_path", $file_path, $this->templateMode);
    }

    public function render_template()
    {
        if (!empty($this->data) && is_array($this->data)){
            extract($this->data);
        }

        $dir = $this->get_dir();
        $file_path = $this->get_file_path();

        $default_path = $dir . $this->templateName . '-1.php';

        if(file_exists($file_path)){
            include_once $file_path;
        } elseif(file_exists($default_path)) {
            include_once $default_path;
        }
    }
}