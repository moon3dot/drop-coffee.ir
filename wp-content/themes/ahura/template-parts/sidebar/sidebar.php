<?php
// sidebar content

if($is_woocommerce_page){
    if(is_product()){
        if(is_array($col) && in_array($theme_columns, $col) || $col == 'left'){
            $sidebar->product()->left()->display();
        } else {
            $sidebar->product()->right()->display();
        }
    } else {
        if(is_array($col) && in_array($theme_columns, $col) || $col == 'left'){
            $sidebar->shop()->left()->display();
        } else {
            $sidebar->shop()->right()->display();
        }
    }
} else {
    if(is_array($col) && in_array($theme_columns, $col) || $col == 'left'){
        $sidebar->left()->display();
    } else {
        $sidebar->right()->display();
    }
}