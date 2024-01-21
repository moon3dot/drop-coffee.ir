<?php
namespace ahura\app\traits;
trait link_utilities
{
	protected function render_link_attrs($url_data, $is_url = true, $object = false)
    {
        if($is_url) {
			$attrs = '';
			$target = isset($url_data['is_external']) && $url_data['is_external'] == 'on' ? ' target="_blank"' : '';
			$nofollow = isset($url_data['nofollow']) && $url_data['nofollow'] == 'on' ? ' rel="nofollow"' : '';
			$cu_attr = isset($url_data['custom_attributes']) && !empty($url_data['custom_attributes']) ? explode(',', $url_data['custom_attributes']) : '';
			if(is_array($cu_attr) && count($cu_attr)){
				foreach($cu_attr as $attr){
					$attr = explode('|', $attr);
					$attrs .= $attr[0] . '=' . '"' . $attr[1] . '"';
				}
			}
			$url = isset($url_data['url']) ? ' href="' . $url_data['url'] . '"' : 'href="#"';
			$data = $url . $target . $nofollow . ' ' . $attrs;
			echo $data;
        } else {
            echo 'href="#"';
        }
    }
}