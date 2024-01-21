<?php

$column = \ahura\app\mw_options::get_mod_theme_columns();

$filename =  \ahura\app\files::get_template('single.'.$column);
if(!$filename){
  $filename = \ahura\app\files::get_template('single.1c');
}
include_once $filename;