<?php
/**
 * Template Name: Full Width
 * Template Post Type: section_builder
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title() ?></title>
    <?php wp_head() ?>
    <style type="text/css">html,body{height:100%}</style>
</head>
<body <?php body_class() ?>>
    <?php 
    if(have_posts()){
        while(have_posts()) : the_post();
            the_content();  
        endwhile; 
    }
    ?>
    <div class="clearfix"></div>
<?php wp_footer() ?>
</body>
</html>