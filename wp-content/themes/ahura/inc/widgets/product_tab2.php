<?php
namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

class product_tab2 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\WoocommerceMethods, \ahura\app\traits\link_utilities;

    /**
     * product_tab2 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('product_tab2_css', mw_assets::get_css('elementor.product_tab2'));
        mw_assets::register_script('product_tab2_js', mw_assets::get_js('elementor.product_tab2'));

        if(!is_rtl()){
            mw_assets::register_style('product_tab2_ltr_css', mw_assets::get_css('elementor.ltr.product_tab2_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('product_tab2_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('product_tab2_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('product_tab2_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'product_tab2';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Product Tab 2', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'aicon-svg-product-tab';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraelements'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['producttab2', 'product_tab2', esc_html__('Product Tab 2', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        /**
         *
         *
         * Start content
         *
         */
        $this->start_controls_section(
            'tabs_content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Tab Title', 'ahura'),
            ]
        );

        $repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
            ]
        );

        $taxonomies = get_taxonomies([
            'public' => true,
            'name' => 'product_cat',
        ], 'objects');

        $cats = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($term_object = get_terms($key)) {
                    if($term_object){
                        foreach ($term_object as $term) {
                            $cats[$term->term_id] = "{$term->name} - {$taxonomy->labels->name}";
                        }
                    }
                }
            }
        }
        $repeater->add_control(
            'cat_id',
            [
                'label' => esc_html__('Categories', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $cats,
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $repeater->add_control(
            'per_page',
            [
                'label' => esc_html__('Products Count', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
            ]
        );

        $repeater->add_control(
            'item_dis_price_show',
            [
                'label' => esc_html__('Discounted Price', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'item_more_options',
            [
                'label' => esc_html__('More Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'item_more_btn_show',
            [
                'label' => esc_html__('Button Show', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'item_more_btn_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('View All', 'ahura'),
                'condition' => [
                    'item_more_btn_show' => 'yes',
                ]
            ]
        );

        $repeater->add_control(
            'item_archive_link',
            [
                'label' => esc_html__('Archive Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'placeholder' => site_url(),
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'item_more_btn_show' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'tab_items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{item_title}}}',
                'default' => [
                    [
                        'item_title' => esc_html__('All Products', 'ahura'),
                        'item_archive_link' => ['url' => site_url()],
                    ],
                    [
                        'item_title' => esc_html__('Mobile', 'ahura'),
                        'item_archive_link' => ['url' => site_url()],
                    ],
                    [
                        'item_title' => esc_html__('Accessories', 'ahura'),
                        'item_archive_link' => ['url' => site_url()],
                    ],
                ]
            ]
        );

        $this->add_control('divider1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'full',
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

        $this->add_control(
            'items_qty_show',
            [
                'label' => esc_html__('Quantity', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'tabs_centered_icon',
            [
                'label' => esc_html__('Tabs Centered Icon', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        /**
         *
         *
         * Start Styles
         *
         */
        $this->start_controls_section(
            'tab_items_style',
            [
                'label' => esc_html__('Tabs', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $alignment = array(
            'right' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'left' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ]
        );

        $this->start_controls_tabs('style_tabs');
		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__('Normal', 'ahura'),
			]
		);

        $this->add_responsive_control(
            'box_tabs_align',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'tabs_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items ul li a i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items ul li a svg' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'item_tab_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#a7a7a7',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#a7a7a7',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_tab_typo',
                'selector' => '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'item_tab_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_tab_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 15,
                    'bottom' => 10,
                    'left' => 15,
                ]
            ]
        );

        $this->add_responsive_control(
            'item_tab_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn',
            ]
        );

        $this->end_controls_tab();
		$this->start_controls_tab(
			'style_hover_tab_hover',
			[
				'label' => esc_html__('Hover', 'ahura'),
			]
		);

        $this->add_control(
            'item_tab_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn:hover i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .pt-item-btn:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
		$this->start_controls_tab(
			'style_active_tab',
			[
				'label' => esc_html__('Active', 'ahura'),
			]
		);

        $this->add_control(
            'item_tab_icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .active .pt-item-btn i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_color_active',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .active .pt-item-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_bg_color_active',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tab-items .active .pt-item-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
        /**
         *
         *
         * Products styles
         *
         *
         */
        $this->start_controls_section(
            'products_item_style',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'product_item_cover_height',
            [
                'label' => esc_html__('Cover Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 700
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 230,
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-cover img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'product_item_bg_color',
            [
                'label' => esc_html__('Background', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'product_item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-item .product-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'product_item_price_color',
            [
                'label' => esc_html__('Price Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1daf3c',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-item .price .amount, {{WRAPPER}} .product-tab-2 .product-item .price ins bdi' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'product_item_dis_price_color',
            [
                'label' => esc_html__('Discount Price Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#a9a9a9',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-item .price del span.amount' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_item_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-2 .product-item .product-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_item_price_typo',
                'label' => esc_html__('Price Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-2 .product-item .price .amount, {{WRAPPER}} .product-tab-2 .product-item .price ins bdi',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '18'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '500'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_item_dis_price_typo',
                'label' => esc_html__('Discounted Price Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-2 .product-item .price del span.amount',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ]
            ]
        );

        $this->add_control(
            'product_btn_color',
            [
                'label' => esc_html__('Button Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-item .button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'product_btn_bg_color',
            [
                'label' => esc_html__('Button Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#3daf2f',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-item .button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'items_border',
				'label' => esc_html__('Border', 'ahura'),
				'selector' => '{{WRAPPER}} .product-tab-2 .product-item',
			]
		);

        $this->add_responsive_control(
            'product_item_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .product-tab-2 .product-item .product-cover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .product-tab-2 .product-item .pt-overly' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_responsive_control(
            'product_item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-2 .product-item',
            ]
        );

        $this->add_control(
            'divider2',
            [
                'label' => esc_html__('More Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'box_tabs_foot_align',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .tab-foot' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'content_btn_archive_color',
            [
                'label' => esc_html__('Button Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .tab-foot a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'content_btn_archive_bg_color',
            [
                'label' => esc_html__('Button Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .tab-foot a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'content_btn_archive_border',
				'label' => esc_html__('Border', 'ahura'),
				'selector' => '{{WRAPPER}} .product-tab-2 .tab-foot a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 3,
                            'right' => 3,
                            'bottom' => 3,
                            'left' => 3,
                        ]   
                    ],
                    'color' => ['default' => '#f0f0f0']
                ]
			]
		);

        $this->add_control(
            'content_btn_archive_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .tab-foot a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ],
            ]
        );

        $this->end_controls_section();
        /**
         * 
         * Quantity input style
         * 
         */
        $this->start_controls_section(
            'products_qty_item_style',
            [
                'label' => esc_html__('Quantity', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'items_qty_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'product_item_qty_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .quantity .mw_qty_btn, {{WRAPPER}} .product-tab-2 .quantity input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'product_item_qty_btns_bg_color',
            [
                'label' => esc_html__('Buttons Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .quantity .mw_qty_btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'product_item_qty_input_bg_color',
            [
                'label' => esc_html__('Input Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .quantity input' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Box styles
         *
         *
         */
        $this->start_controls_section(
            'tab_box_wrap_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tabs_wrap_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tabs-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-2 .box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '24'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'tabs_wrap_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_wrap_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_wrap_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-2 .pt-tabs-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 20,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tabs_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-2 .pt-tabs-content',
            ]
        );

        $this->end_controls_section();
    }

    /**
     *
     * Render element content (html)
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        $items = $settings['tab_items'];

        if(!\ahura\app\woocommerce::is_active()){
            return false;
        }

        if ($items):
            ?>
            <div class="product-tab-2-wrap product-tab-2-wrap-<?php echo $wid ?>">
                <div class="product-tab-2">
                    <div class="pt-tab-items <?php echo $settings['tabs_centered_icon'] == 'yes' ? ' centered-icons' : '' ?>">
                        <ul>
                            <?php
                            $i = 0;
                            foreach ($items as $item):
                                $tab_id = !empty($item['_id']) ? $item['_id'] : uniqid();
                                $first = ($i === 0);
                                $activeCls = $first ? 'active' : '';
                                $i++;
                                ?>
                                <li class="elementor-repeater-item-<?php echo $tab_id . ' ' . $activeCls; ?>">
                                    <a href="#" class="pt-item-btn" id="tab-item-<?php echo $tab_id ?>" data-wid="<?php echo $wid ?>" data-tab="#tab-content-<?php echo $tab_id ?>">
                                        <?php if($item['item_icon']['value']): ?>
                                            <?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        <?php endif; ?>
                                        <?php echo $item['item_title'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="pt-tabs-content">
                        <?php
                        $i = 0;
                        foreach ($items as $item):
                            $tab_id = !empty($item['_id']) ? $item['_id'] : uniqid();
                            $firstWrap = ($i === 0);
                            $activeCls = $firstWrap ? 'active' : '';
                            $i++;
                            ?>
                            <div class="pt-tab-content-wrap elementor-repeater-item-<?php echo $tab_id . ' ' . $activeCls; ?>" id="tab-content-<?php echo $tab_id ?>" style="display:<?php echo $firstWrap ? 'block' : 'none' ?>">
                                <div class="row pt-tab-content">
                                    <?php
                                        $products = $this->get_products($item);

                                        if ($products):
                                            while ($products->have_posts()): $products->the_post();
                                                global $product;
                                                ?>
                                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 d-flex">
                                                    <div class="product-item">
                                                        <div class="item-top-section">
                                                            <div class="product-cover">
                                                                <a href="<?php echo get_the_permalink() ?>">
                                                                    <?php echo wp_get_attachment_image(get_post_thumbnail_id(), $settings['item_cover_size']) ?>
                                                                </a>
                                                            </div>
                                                            <a href="<?php echo get_the_permalink() ?>">
                                                                <h2 class="product-title"><?php the_title(); ?></h2>
                                                            </a>
                                                            <?php woocommerce_template_single_price(); ?>
                                                        </div>
                                                        <div class="product-details">
                                                            <?php \ahura\app\woocommerce::add_to_cart_button_with_quantity(['with_qty' => ($settings['items_qty_show'] == 'yes')]) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php 
                                            endwhile;
                                            wp_reset_query();
                                            wp_reset_postdata();
                                        else: ?>
                                            <div class="col-12">
                                                <div class="mw_element_error">
                                                    <?php echo esc_html__('Sorry,no products were found for display.', 'ahura'); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                </div>
                                <?php if($products && $item['item_more_btn_show'] == 'yes'): ?>
                                <div class="tab-foot">
                                    <a <?php $this->render_link_attrs($item['item_archive_link']) ?> class="tab-archive-btn">
                                        <span><?php echo $item['item_more_btn_text']; ?></span>
                                        <i class="fas fa-chevron-<?php echo is_rtl() ? 'left' : 'right' ?>"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
    }
}