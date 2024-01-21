<?php
class Mihan_Walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $mega_state = get_post_meta($item->ID, 'mega_menu_state', true);
        $title = __($item->title);
        $icon_type = $item->mega_menu_icon_type;
        $icon_url = $item->mega_menu_icon ? $item->mega_menu_icon : '';


        $itemTextColor = isset($item->mega_menu_item_text_color) && $item->mega_menu_item_text_color ? $item->mega_menu_item_text_color : false;
        $itemBgColor = isset($item->mega_menu_item_bg_color) && $item->mega_menu_item_bg_color ? $item->mega_menu_item_bg_color : false;
        $itemBgColorStyle = !empty($itemBgColor) ? "background-color:{$itemBgColor};" : '';

        $output .= '<li style="'.$itemBgColorStyle.'" class="mega_menu_hover ' . $mega_state . (is_array($item->classes) ? implode(' ', $item->classes) : '') . '">';
        $attrs = $item->attr_title ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attrs .= $item->target ? ' target="' . esc_attr($item->target) . '"' : '';
        $attrs .= $item->xfn ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attrs .= $item->url ? ' href="' . esc_attr($item->url) . '"' : '';
        $attrs .= $itemTextColor ? ' style="color: ' . esc_attr($itemTextColor) . '; padding: 0 10px;"' : '';

        $menu_item = (isset($args->before) ? $args->before : (isset($args['before']) ? $args['before'] : ''));
        $menu_item .= '<a '.$attrs.' >';
        $item_icon = $icon_url ? '<img alt="'.$title.'" src="'.$icon_url.'"/>' : '';
        $menu_font_icon = (isset($item->menu_font_icon) && !empty($item->menu_font_icon));
        $item_icon = $icon_type === 'icon' || (!empty($item->menu_font_icon) && empty($icon_url)) ? ($menu_font_icon ? "<i class='menu-font-icon {$item->menu_font_icon}'></i>" : '') : $item_icon;
        $lf = (isset($args->link_before) ? $args->link_before : (isset($args['link_before']) ? $args['link_before'] : ''));
        $la = (isset($args->link_after) ? $args->link_after : (isset($args['link_after']) ? $args['link_after'] : ''));
        $menu_item .= $lf . $item_icon . apply_filters('the_title', $title, $item->ID) . $la;
        $menu_item .= '</a>';
        $menu_item .= $item->subtitle;
        $menu_item .= (isset($args->after) ? $args->after : (isset($args['after']) ? $args['after'] : ''));
        // $menu_item = '<a '.$attrs.'>' . $menu_item . ' ' .$description_render .'</a>';
        
        $output .= $menu_item;
        // $output .= apply_filters('walker_nav_menu_start_el', $output, $item, $depth, $args);
    }
    
    function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if ( ! $element ) {
			return;
		}

		$id_field = $this->db_fields['id'];
		$id       = $element->$id_field;

		//display this element
		$this->has_children = ! empty( $children_elements[ $id ] );
		if ( isset( $args[0] ) && is_array( $args[0] ) ) {
			$args[0]['has_children'] = $this->has_children; // Back-compat.
		}

		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( $this, 'start_el' ), $cb_args );

		// descend only when the depth is right and there are childrens for this element
		if ( ( $max_depth == 0 || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {

			foreach ( $children_elements[ $id ] as $child ) {

				if ( ! isset( $newlevel ) ) {
					$newlevel = true;
                    //start the child delimiter
                    // send wrapper menu id to get backgroud image
                    $cb_args = array_merge( array( &$output, $depth ), $args, [$id] );
                    // $cb_args = array_merge($cb_args, [$id]);
					call_user_func_array( array( $this, 'start_lvl' ), $cb_args );
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset( $newlevel ) && $newlevel ) {
			//end the child delimiter
			$cb_args = array_merge( array( &$output, $depth ), $args );
			call_user_func_array( array( $this, 'end_lvl' ), $cb_args );
		}

		//end this element
		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( $this, 'end_el' ), $cb_args );    
    }

    function start_lvl(&$output, $depth = 0, $args = array(), $parent_id='')
    {
        $mega_menu_bg = get_post_meta($parent_id, 'mega_menu_bg', true);
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat( $t, $depth );

        // Default class.
        $classes = array('sub-menu');

        /**
         * Filters the CSS class(es) applied to a menu list element.
         *
         * @since 4.8.0
         *
         * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
         * @param stdClass $args    An object of `wp_nav_menu()` arguments.
         * @param int      $depth   Depth of menu item. Used for padding.
         */
        $class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
        $class_names = $class_names ? esc_attr($class_names) : 'sub-menu';
        $mega_menu_bg = (!empty($mega_menu_bg) ? "background-image:url({$mega_menu_bg})" : '');
        $output .= sprintf("{$n}{$indent}<ul class='%s' style='%s'>{$n}", $class_names, $mega_menu_bg);
    }
}