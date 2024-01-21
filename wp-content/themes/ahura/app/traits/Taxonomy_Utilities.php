<?php
namespace ahura\app\traits;
trait Taxonomy_Utilities
{
    protected function get_taxonomies($taxonomy_name = ''){
        $args = ['public' => true];
        if(!empty($taxonomy_name)){
            $args['name'] = $taxonomy_name;
        }
        $taxonomy = get_taxonomies($args, 'objects');

        return $taxonomy;
    }

	protected function get_taxonomy_ids($taxonomy_name)
    {
        $taxonomies = $this->get_taxonomies($taxonomy_name);

        $cats = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($term_object = get_terms($key)) {
                    if($term_object){
                        foreach ($term_object as $term) {
                            $cats[$term->term_id] = "{$term->name}";
                        }
                    }
                }
            }
        }

        return $cats;
    }

    protected function get_taxonomies_name(){
        $taxonomies = $this->get_taxonomies();

        $taxs = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($taxonomy->public) {
                    $taxs[$taxonomy->name] = $taxonomy->labels->name;
                }
            }
        }

        return $taxs;
    }

    protected function get_terms($taxonomy, $ids = []){
        $taxs = array();

        if(is_array($ids) && count($ids)){
            foreach($ids as $id){
                $taxs[] = get_term_by('id', $id, $taxonomy);
            }
        } else {
            $taxs = get_terms($taxonomy);
        }

        return (object)$taxs;
    }
}