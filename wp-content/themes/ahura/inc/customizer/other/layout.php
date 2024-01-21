<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_options;
use ahura\app\woocommerce;
use ahura\app\customization\image_radio_box;
use ahura\app\customization\simple_notice;

$layout_dir_url = get_template_directory_uri() . '/img/customization/layout/';

$ahura_columns_items = [];

if(is_rtl()) {
  $ahura_columns_items = [
    '2cr' => [
      'label' => __( 'Right Sidebar', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_right.png',
    ],
    '2c' => [
      'label' => __( 'Left Sidebar', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_left.png',
    ],
    '3c' => [
      'label' => __( '3 Columns', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_3c.png',
    ],
    '1c' => [
      'label' => __( 'Full Width', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_full_width.png',
    ],
    '1cc' => [
      'label' => __( 'Full Width And Center Content', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_full_width_center.png',
    ],
  ];
} else {
  $ahura_columns_items = [
    '2c' => [
      'label' => __( 'Left Sidebar', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_left.png',
    ],
    '2cr' => [
      'label' => __( 'Right Sidebar', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_right.png',
    ],
    '3c' => [
      'label' => __( '3 Columns', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_3c.png',
    ],
    '1c' => [
      'label' => __( 'Full Width', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_full_width.png',
    ],
    '1cc' => [
      'label' => __( 'Full Width And Center Content', 'ahura' ),
      'image_url' => $layout_dir_url . 'site_columns_full_width_center.png',
    ],
  ];
}

$this->customizer->add_setting('ahura_columns', ['default' => '2c']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_columns',array(
  'label' => __( 'Website Columns', 'ahura' ),
  'section' => $this->current_section,
  'choices' => $ahura_columns_items
)));

$this->customizer->add_setting('ahura_page_columns', ['default' => '2c']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_page_columns',array(
  'label' => __( 'Page Columns', 'ahura' ),
  'section' => $this->current_section,
  'choices' => $ahura_columns_items
)));

if(woocommerce::is_active()){
    $this->customizer->add_setting('ahura_shop_columns', ['default' => '2c']);
    $this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_shop_columns',array(
        'label' => __( 'Woocommerce pages columns', 'ahura' ),
        'type' => 'radio',
        'section' => $this->current_section,
        'choices' => $ahura_columns_items
    )));

    $this->customizer->add_setting('ahura_product_page_columns', ['default' => '2c']);
    $this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_product_page_columns',array(
        'label' => __( 'Woocommerce single page columns', 'ahura' ),
        'section' => $this->current_section,
        'choices' => $ahura_columns_items,
        'active_callback' => function(){
          return mw_options::get_single_product_style() != 'digikala';
        },
    )));

    $this->customizer->add_setting('ahura_product_page_notice');
    $this->customizer->add_control( new simple_notice( $this->customizer, 'ahura_product_page_notice',[
        'description' => __( 'Product page columns aren\'t available, when you chooses Style 1 product page style option', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => function(){
            return mw_options::get_single_product_style() == 'digikala';
        },
      ]
    ));
}