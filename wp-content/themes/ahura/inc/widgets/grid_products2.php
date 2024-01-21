<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_tools;
use ahura\app\traits\WoocommerceMethods;
use ahura\app\woocommerce;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;

class grid_products2 extends \Elementor\Widget_Base {
    use WoocommerceMethods;

    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_products2_css', mw_assets::get_css('elementor.grid_products2'));
        if(!is_rtl()){
            mw_assets::register_style('grid_products2_ltr_css', mw_assets::get_css('elementor.ltr.grid_products2_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_products2_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('grid_products2_ltr_css');
        }
        return $styles;
    }

    public function get_name() {
        return 'grid_products2';
    }

    public function get_title() {
        return __( 'Grid Products 2', 'ahura' );
    }

    public function get_icon() {
        return 'aicon-svg-grid-products';
    }

    public function get_categories() {
        return [ 'ahuraelements', 'ahura_woocommerce' ];
    }
    function get_keywords()
    {
        return ['gridproducts2', 'grid_products2', esc_html__( 'Grid Products 2' , 'ahura')];
    }

    protected function register_controls() {
        if(!woocommerce::is_active())
        {
            return false;
        }
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $categories = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));
        $cats       = array();
        if($categories){
            foreach ( $categories as $category ) {
                $cats[ $category->slug ] = $category->name;
            }
        }

        $this->add_control(
            'catsid',
            [
                'label'    => __( 'Categories', 'ahura' ),
                'type'     => Controls_Manager::SELECT2,
                'options'  => array_merge(
                    [ 'allproducts'  => esc_html__( 'All Products', 'ahura' ) ],
                    [ 'discountedproducts'  => esc_html__( 'Discounted Products', 'ahura' ) ],
                    [ 'randomproducts'  => esc_html__( 'Random Products', 'ahura' ) ],
                    $cats ),
                'label_block' => true,
                'multiple' => true,
                'default' => 'allproducts'
            ]
        );

        $stock_options = (function_exists('wc_get_product_stock_status_options')) ? wc_get_product_stock_status_options() : [];

        $this->add_control(
            'products_stock_status',
            [
                'label'   => esc_html__('Stock status of products', 'ahura'),
                'type'    => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => array_merge(['none'  => esc_html__('None', 'ahura')], $stock_options),
                'default' => 'instock'
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'   => __( 'Show Title', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => __( 'Yes', 'ahura' ),
                        'icon' => 'eicon-check'
                    ],
                    'no' => [
                        'title' => __( 'No', 'ahura' ),
                        'icon' => 'eicon-editor-close'
                    ]
                ],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'fully_show_title',
            [
                'label'   => __( 'Fully Show Title', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'no',
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'price',
            [
                'label'   => __( 'Show Price', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'count',
            [
                'label'      => __( 'Number of posts', 'ahura' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 10
            ]
        );

        $this->add_control(
            'product_order',
            [
                'label' => __('Sort', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'DESC',
                'options' => [
                    'ASC' => [
                        'title' => __('Ascending', 'ahura'),
                        'icon' => 'eicon-sort-up'
                    ],
                    'DESC' => [
                        'title' => __('Descending', 'ahura'),
                        'icon' => 'eicon-sort-down'
                    ],
                ],
                'toggle' => true
            ]
        );

        $this->add_control(
            'stock_status',
            [
                'label'   => __( 'Show product stock status', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'outofstock_text',
            [
                'label' => __( 'Out of stock text', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'out of stock', 'ahura' ),
            ]
        );

        $this->add_control(
            'sale_price_product',
            [
                'label'   => __( 'Show only discounted products', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes'  => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no' => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'no',
                'condition' => [
                    'catsid!' => 'discountedproducts',
                ],
            ]
        );

        $this->add_control(
            'show_cart',
            [
                'label' => esc_html__( 'Show Buy Button', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'layout_col',
            [
                'label' => esc_html__('Columns', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 5,
                'options' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .products-wrap' => 'grid-template-columns: repeat({{VALUE}},minmax(0,1fr));',
                ],
                'desktop_default' => '5',
                'tablet_default' => '3',
                'mobile_default' => '1',
            ]
        );

        $this->add_responsive_control(
            'object_fit',
            [
                'label' => esc_html__( 'Aspect ratio', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'contain',
                'options' => [
                    'fill' => esc_html__( 'Default', 'ahura' ),
                    'contain' => esc_html__( 'Contain', 'ahura' ),
                    'cover'  => esc_html__( 'Cover', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-cover img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'more_section', [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_box_title',
            [
                'label' => esc_html__( 'Show Title', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'box_icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-percentage',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__( 'Box Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Discounted products', 'ahura' ),
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_btn',
            [
                'label' => esc_html__( 'Show Button', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button Text', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'View All', 'ahura' ),
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'is_external' => false,
                    'url' => site_url()
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'move_btn_to_bottom',
            [
                'label' => esc_html__( 'Move button to bottom in mobile', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'ahura' ),
                'label_off' => esc_html__( 'No', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         *  Styles
         *
         *
         */
        $this->start_controls_section(
            'box_style_section',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .grid-products2-wrap',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#fff'
                            ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .grid-products2-wrap',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => ['default' => '#f1f2f4']
                ]
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-products2-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_title_options',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $alignment = [
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-text-align-left'
            ],
            'center' => [
                'title' => __('Center', 'ahura'),
                'icon' => 'eicon-text-align-center'
            ],
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-text-align-right'
            ]
        ];
        if(is_rtl(  ))
        {
            $alignment = array_reverse($alignment);
        }

        $this->add_responsive_control(
            'box_title_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => $alignment,
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .box-title' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .box-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .box-title svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                  'size' => 15,
                  'unit' => 'px'
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FF0000',
                'selectors' => [
                    '{{WRAPPER}} .box-title i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .box-title svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .box-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'box_title_typo',
                'selector' => '{{WRAPPER}} .box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 500],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ]
                    ]
                ],
                'condition' => [
                    'show_box_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'btn_options',
            [
                'label' => esc_html__( 'Button', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $position = [
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-h-align-left'
            ],
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-h-align-right'
            ]
        ];
        if(is_rtl())
        {
            $position = array_reverse($position);
        }

        $this->add_responsive_control(
            'box_btn_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => $position,
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .box-btn' => '{{VALUE}}: 15px;'
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#5A98DC',
                'selectors' => [
                    '{{WRAPPER}} .box-btn a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'box_btn_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .box-btn a' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_btn_typo',
                'selector' => '{{WRAPPER}} .box-btn a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 400],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ],
                'condition' => [
                    'show_btn' => 'yes'
                ]
            ]
        );
        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'selector' => '{{WRAPPER}} .box-btn a',
                'condition' => [
                    'show_btn' => 'yes'
                ],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#5A98DC',
                    ],
                ],
            ]
        );
        // border-radius
        $this->add_control(
            'box_btn_border_radius',
            [
                'label' => esc_html__( 'Border radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .box-btn a' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // padding
        $this->add_control(
            'box_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .box-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '5',
                    'bottom' => '5',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    // 'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'items_style_section',
            [
                'label' => __( 'Items', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'item_img_radius',
            [
                'label' => esc_html__( 'Cover Border Radius', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-cover img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'selector' => '{{WRAPPER}} .sc-item-content',
                'exclude' => ['image'],
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic',
                            ],
                        'color' =>
                            [
                                'default' => '#fff',
                                'label' => __('Background color', 'ahura'),
                            ]
                    ]
            ]
        );

        $this->add_control(
            'item_border_color',
            [
                'label' => esc_html__('Border Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .products-wrap' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .sc-item-content .product-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .sc-item-content .product-title h3',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 500],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'price_styles',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_price_color',
            [
                'label' => esc_html__('Product regular price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .reg-price-wrap' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_dis_price_color',
            [
                'label' => esc_html__('Product sale price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#B0B0B3',
                'selectors' => [
                    '{{WRAPPER}} .sale-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'cart_style_section',
            [
                'label' => __( 'Add to cart button', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cart_bg',
                'selector' => '{{WRAPPER}} .add-to-cart',
                'exclude' => ['image'],
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'label' => __('Background color', 'ahura'),
                                'default' => '#fff'
                            ]
                    ]
            ]
        );

        $this->add_control(
            'cart_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ef3f55',
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'cart_border',
                'selector' => '{{WRAPPER}} .add-to-cart',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#ef3f55',
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'cart_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .add-to-cart' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( class_exists( 'WooCommerce' ) ) {
            $field_is_term = (is_array($settings['catsid']) && is_numeric($settings['catsid'][0])) || is_int($settings['catsid']);
            $show_box_title = $settings['show_box_title'] === 'yes';
            $show_btn = $settings['show_btn'] === 'yes';

            if ($show_btn && !empty($settings['btn_link']['url'])) {
                $this->add_link_attributes('btn_link', $settings['btn_link']);
            }

            $current_currency_symbol = get_woocommerce_currency_symbol();

            if($settings[ 'catsid' ] == 'allproducts' || ( $settings[ 'catsid' ][ 0 ] == 'allproducts' ) || $settings[ 'catsid' ][ 0 ] == 'randomproducts' ) {
                $args = [
                    'post_type'		 => 'product',
                    'post_status'	 => 'publish',
                    'posts_per_page' => $settings[ 'count' ],
                    'order' 		 => $settings[ 'product_order' ],
                    'orderby' 		 => $settings[ 'catsid' ][ 0 ] == 'randomproducts' ? 'rand' : $settings[ 'product_order' ]
                ];
            } elseif( $settings[ 'catsid' ][ 0 ] == 'discountedproducts' ) {
                $args = [
                    'post_type'		 => 'product',
                    'post_status'	 => 'publish',
                    'posts_per_page' => $settings[ 'count' ],
                    'order' 		 => $settings[ 'product_order' ],
                    'meta_key' 		 => '_sale_price',
                    'meta_value' 	 => '0',
                    'meta_compare'   => '>='
                ];
            } else {
                $args = [
                    'post_type'		 => 'product',
                    'post_status'	 => 'publish',
                    'posts_per_page' => $settings[ 'count' ],
                    'tax_query'		 => [ [
                        'taxonomy'   => 'product_cat',
                        'field'		 => $field_is_term ? 'term_id' : 'slug',
                        'terms'		 => $settings[ 'catsid' ],
                    ] ],
                    'order' 		 => $settings[ 'product_order' ]
                ];
            }

            $products_stock_status = $settings['products_stock_status'];

            if ($products_stock_status && $products_stock_status !== 'none') {
                $args['meta_query'] = array(array(
                    'key' => '_stock_status',
                    'value' => $products_stock_status,
                    'compare' => '==',
                ));
            }

            $wc_query = new \WP_Query($args);
            if ($wc_query->have_posts()) : ?>
                <div class="grid-products2-wrap">
                    <?php if ($show_box_title || $show_btn): ?>
                        <div class="box-head">
                            <?php if ($show_box_title): ?>
                                <div class="box-title">
                                    <?php \Elementor\Icons_Manager::render_icon( $settings['box_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php echo $settings['box_title'] ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($show_btn): ?>
                                <div class="box-btn <?php echo isset($settings['move_btn_to_bottom']) && $settings['move_btn_to_bottom'] == 'yes' ? 'ah-bottom-in-mobile' : '' ?>">
                                    <a <?php echo $this->get_render_attribute_string('btn_link'); ?>>
                                        <?php echo $settings['btn_text'] ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="products-wrap">
                        <?php
                        while ( $wc_query->have_posts() ) : $wc_query->the_post();
                            $sale_percent = $this->get_product_sale_percent();
                            $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
                            $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
                            $sale_days_progress = $this->get_product_sale_progress_percent(get_the_ID());

                            if (empty($sale_price) && $settings['sale_price_product'] == 'yes'){
                                continue;
                            }
                            ?>
                            <div class="products-item-wrap">
                                <div class="products-item">
                                    <div class="sc-item-content">
                                        <div class="sc-items-top">
                                            <div class="product-labels">
                                                <?php
                                                if ( ( $settings['stock_status'] == 'yes' && wc_get_product( get_the_ID() )->get_stock_status() == "outofstock" ) ) {
                                                    echo '<span class="out-stock">' . $settings['outofstock_text'] . '</span>';
                                                }
                                                ?>
                                            </div>
                                            <div class="product-cover">
                                                <?php if($settings['show_cart'] === 'yes'): ?>
                                                <a href="?add-to-cart=<?php echo get_the_ID() ?>" class="add-to-cart">+</a>
                                                <?php endif; ?>
                                                <a class="fimage" href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?>
                                                </a>
                                            </div>
                                            <?php if($settings['show_title'] == 'yes'): ?>
                                                <a href="<?php the_permalink(); ?>" class="product-title">
                                                    <h3><?php echo $settings['fully_show_title'] == 'yes' ? get_the_title() : wp_trim_words( get_the_title(), 6, '...' ); ?></h3>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="sc-items-bottom">
                                            <?php if ( $settings['price'] == 'yes' ) : ?>
                                                <div class="mwprprice">
                                                    <div class="regular_price <?php echo empty($sale_percent) ? ' without-sale' : ''?>">
                                                        <?php if (!empty($sale_percent)): ?>
                                                            <span class="sale-percent"><?php echo $sale_percent ?>%</span>
                                                        <?php endif; ?>
                                                        <div class="reg-price-wrap">
                                                            <?php echo sprintf('%s %s', mw_tools::number_format((!empty($sale_price) ? $sale_price : $this->get_price(get_the_ID()))), "<em>{$current_currency_symbol}</em>") ?>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($sale_price)): ?>
                                                        <div class="sale-price">
                                                            <del><?php echo mw_tools::number_format($regular_price) ?></del>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($sale_days_progress): ?>
                                                <div class="sale-progress">
                                                    <div class="percent" style="width:<?php echo $sale_days_progress ?>%"></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="mw_element_error">
                    <?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
                </div>
            <?php endif; ?>
            <div class="clear"></div>
            <?php
        }
    }

}