<?php
namespace ahura\app\elementor;

if(!class_exists('\ahura\app\elementor\Ahura_Elementor'))
{
    return false;
}

use ahura\app\Logger;
use Elementor\Core\Files\CSS\Post as Post_CSS;
class Ahura_Elementor_Builder extends \ahura\app\elementor\Ahura_Elementor
{
    protected $content_id = 0;
    private $getInstance;

    public function __construct()
    {
        $this->getInstance = parent::instance();
    }

    /**
     *
     * Get elementor templates by post type
     *
     * @param $post_type
     * @return mixed
     */
    public function getTemplates($post_type = 'section_builder', $params = []){
        $args = array_merge(['post_type' => $post_type], $params);
        $templates = get_posts($args);
        return $templates;
    }

    public function getTemplatesByMeta($params){
        $type = isset($params['type']) ? $params['type'] : null;
        $template = isset($params['template']) ? $params['template'] : null;
        /*if($type){
            if ($type == 'page'){
                if ($template){
                    $params['meta_query'] = array(
                        [
                            'key'   => 'section_builder_template_page',
                            'compare' => '==',
                            'value' => $template,
                        ]
                    );
                }
            } else {
                $params['meta_query'] = array(
                    [
                        'key'   => 'section_builder_type',
                        'compare' => '==',
                        'value' => $type,
                    ]
                );
            }
        }
        if(isset($params['post_id']) && !empty($params['post_id'])){
            $params['post__in'] = $params['post_id'];
        }*/
        return $this->getTemplates('section_builder', $params);
    }

    public function getHeaders($current = 0){
        return $this->getTemplatesByMeta([
            'type' => 'header',
            'post_id' => $current
        ]);
    }

    public function getFooters($current = 0){
        return $this->getTemplatesByMeta([
            'type' => 'header',
            'post_id' => $current
        ]);
    }

    public function getPages($template = '', $current = 0){
        return $this->getTemplatesByMeta([
            'type' => 'page',
            'template' => $template,
            'post_id' => $current,
        ]);
    }

    /**
     *
     * Set content id for build
     *
     * @param $content_id
     */
    public function setContentID($content_id){
        $this->content_id = $content_id;
        return $this;
    }

    /**
     * 
     * Get content id
     * 
     * @return int
     */
    public function getContentID()
    {
        return $this->content_id;
    }

    /**
     * Get content translation id
     *
     * @return int
     */
    public function getContentTranslationID(){
        return ahura_get_content_translation_id($this->content_id);
    }

    /**
     *
     * Build custom element content
     *
     */
    public function build($return_in_ajax = false){
        if(!$return_in_ajax && wp_doing_ajax()) return false;
        echo $this->getInstance->frontend->get_builder_content($this->getContentTranslationID(), $this->getCssPrintMethod());
    }

    /**
     *
     * Build and display element content (with restore edit mode state)
     *
     */
    public function display($return_in_ajax = false){
        if(!$return_in_ajax && wp_doing_ajax()) return false;
        return $this->getInstance->frontend->get_builder_content_for_display($this->getContentTranslationID(), $this->getCssPrintMethod());
    }

    /**
     * Print element inline css
     *
     * @return string
     */
    public function printCss(){
        if(!empty($this->getContentTranslationID()) && intval($this->getContentTranslationID()) && get_post_status($this->getContentTranslationID())){
            $css_file = new Post_CSS($this->getContentTranslationID());
			$css_file->print_css();
		}
    }

    /**
     *
     * Check is elementor preview page (preview is backend)
     *
     * @return boolean
     */
    public function isPreviewMode(){
        return $this->getInstance->preview->is_preview_mode();
    }

    /**
     * 
     * Check page is elementor edit mode
     * 
     * @return boolean
     */
    public function isEditMode(){
        $mode = get_post_meta($this->getContentID(), '_elementor_edit_mode', true);
        return ($mode === 'builder');
    }

    public static function renderPage($pageID){
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($pageID);
    }

    public function getCssPrintMethod(){
        if ('internal' !== get_option('elementor_css_print_method')) {
            return false;
        }
        return true;
    }
}
