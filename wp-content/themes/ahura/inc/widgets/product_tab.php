<?php


namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

class product_tab extends \Elementor\Widget_Base
{
    /**
     * product_tab constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('product_tab_css', mw_assets::get_css('elementor.product_tab'));
        mw_assets::register_script('product_tab_js', mw_assets::get_js('elementor.product_tab'));
        wp_localize_script(mw_assets::get_handle_name('product_tab_js'), 'ahura_data', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'translate' => [
                'view_product' => __('View Product', 'ahura')
            ]
        ]);
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('product_tab_css')];
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('product_tab_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'product_tab';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Product Tab', 'ahura');
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
        return ['producttab', 'product_tab', esc_html__('Product Tab', 'ahura')];
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

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Latest Products', 'ahura'),
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
                'default' => 8,
                'min' => 1,
            ]
        );

        $repeater->add_control(
            'item_color',
            [
                'label' => esc_html__('Primary Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f30808',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-1 .pt-tab-items {{CURRENT_ITEM}}.active a' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .product-tab-1 .pt-tab-items {{CURRENT_ITEM}} .ahura-loader-ring:after' => 'border-color: {{VALUE}} transparent {{VALUE}} transparent;',
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content {{CURRENT_ITEM}} .ahura-loader-ring:after' => 'border-color: {{VALUE}} transparent {{VALUE}} transparent;',
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content {{CURRENT_ITEM}} .share-btn i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content {{CURRENT_ITEM}} .share-btns .btns a' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content {{CURRENT_ITEM}} .fav-btns i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content {{CURRENT_ITEM}} .tab-archive-btn i' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content {{CURRENT_ITEM}} .pt-overly i' => 'color: {{VALUE}};',
                ]
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
            'item_more_btn_use_link',
            [
                'label' => esc_html__('Use Link', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'item_more_btn_show' => 'yes',
                    'item_more_btn_ajax!' => 'yes',
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
                    'item_more_btn_use_link' => 'yes',
                    'item_more_btn_ajax!' => 'yes',
                ]
            ]
        );

        $repeater->add_control(
            'item_more_btn_ajax',
            [
                'label' => esc_html__('Ajax Load New Products', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
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
                        'item_title' => esc_html__('All', 'ahura'),
                        'item_archive_link' => ['url' => site_url()],
                    ]
                ]
            ]
        );

        $this->add_control('divider1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
			'basket_icon',
			[
				'label' => esc_html__( 'Basket icon', 'ahura' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-shopping-basket',
					'library' => 'fa-solid',
				],
			]
		);

        $this->add_control(
			'ُshare_icon',
			[
				'label' => esc_html__( 'Share icon', 'ahura' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-share-alt',
					'library' => 'fa-solid',
				],
			]
		);

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
			'item_image_position',
			[
				'label' => esc_html__( 'Thumbnail Position', 'ahura' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'bottom',
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'ahura' ),
						'icon' => 'eicon-sort-up'
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ahura' ),
						'icon' => 'eicon-sort-down'
					],
				],
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

        $this->add_responsive_control(
            'box_tabs_align',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'left' : 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-1 .pt-tab-items' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tab_icon_size',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 15
                ],
                'selectors' => [
                    '{{WRAPPER}} .pt-item-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pt-item-btn svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .product-tab-1 .pt-tab-items .pt-item-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-1 .pt-tab-items .pt-item-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_tab_typo',
                'selector' => '{{WRAPPER}} .product-tab-1 .pt-tab-items .pt-item-btn',
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
                    '{{WRAPPER}} .product-tab-1 .pt-tab-items .pt-item-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .product-tab-1 .pt-tab-items .pt-item-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .product-tab-1 .pt-tab-items li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-1 .pt-tab-items .pt-item-btn',
            ]
        );

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
                    '{{WRAPPER}} .product-tab-1 .product-cover' => 'height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .product-tab-1 .product-item' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .product-tab-1 .product-item .product-title' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .product-tab-1 .product-item .price-wrap .price' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .product-tab-1 .product-item .price-wrap .price del' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'product_item_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-1 .product-item .product-title',
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
                'selector' => '{{WRAPPER}} .product-tab-1 .product-item .price-wrap .price',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'product_item_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-tab-1 .product-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .product-tab-1 .product-item .product-cover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .product-tab-1 .product-item .pt-overly' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .product-tab-1 .product-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_responsive_control(
            'box_wrap_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-1 .box-title' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'tabs_wrap_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .product-tab-1 .box-title',
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
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .product-tab-1 .pt-tabs-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .product-tab-1 .pt-tabs-content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render_link_attrs($url_data, $status)
    {
        if($status == 'yes') {
            $target = $url_data['is_external'] ? 'target="_blank"' : '';
            $nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
            $cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
            $data = 'href="' . $url_data['url'] . '" ' . $target . ' ' . $nofollow . ' ' . $cu_attr;
            echo $data;
        } else {
            echo 'href="#"';
        }
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
		
		$thumb_reverse_position = $settings['item_image_position'] == 'top';

        if ($items):
            ?>
            <div class="product-tab-1-wrap product-tab-1-wrap-<?php echo $wid ?> <?php echo $thumb_reverse_position ? ' reverse-details' : '' ?>">
                <div class="product-tab-1">
                    <div class="box-head">
                        <div class="row align-items-center">
                            <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="box-title">
                                    <?php echo $settings['box_title'] ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                                <div class="pt-tab-items">
                                    <ul>
                                        <?php
                                        $i = 0;
                                        foreach ($items as $item):
                                            $first = ($i === 0);
                                            $activeCls = $first ? 'active' : '';
                                            $data = array('category' => $item['cat_id'], 'num' => $item['per_page']);
                                            $i++;
                                            ?>
                                            <li class="elementor-repeater-item-<?php echo $item['_id'] . ' ' . $activeCls; ?>">
                                                <a href="#" class="pt-item-btn" id="tab-item-<?php echo $item['_id'] ?>" data-wid="<?php echo $wid ?>" data-tab="#tab-content-<?php echo $item['_id'] ?>" data-settings="<?php echo base64_encode(json_encode($data)) ?>">
                                                    <?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                                    <?php echo $item['item_title'] ?>
                                                    <div class="ahura-loader-ring"></div>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-tabs-content">
                        <?php
                        $i = 0;
                        foreach ($items as $item):
                            $firstWrap = ($i === 0);
                            $activeCls = $firstWrap ? 'active' : '';
                            $i++;
                            ?>
                            <div class="pt-tab-content-wrap elementor-repeater-item-<?php echo $item['_id'] . ' ' . $activeCls; ?>" id="tab-content-<?php echo $item['_id'] ?>" style="display:<?php echo $firstWrap ? 'block' : 'none' ?>">
                                <div class="row pt-tab-content">
                                    <?php
                                    if ($firstWrap):
                                        $args = array('post_type' => 'product', 'posts_per_page' => $item['per_page'], 'post_status' => 'publish');

                                        if ($item['cat_id']) {
                                            $args['tax_query'] = array(
                                                'tax_query' => [
                                                    'relation' => 'OR',
                                                    [
                                                        'taxonomy' => 'product_cat',
                                                        'field' => 'term_id',
                                                        'terms' => $item['cat_id'],
                                                    ]
                                                ]
                                            );
                                        }

                                        $products = new \WP_Query($args);

                                        if ($products->have_posts()):
                                            while ($products->have_posts()): $products->the_post();
                                                global $product;
                                                include get_template_directory() .'/template-parts/loop/elementor/product-tab-load-ajax.php';
                                            endwhile;
                                            wp_reset_query();
                                            wp_reset_postdata();
                                        else: ?>
                                            <div class="col-12">
                                                <div class="mw_element_error">
                                                    <?php echo esc_html__('Sorry,no products were found for display.', 'ahura'); ?>
                                                </div>
                                            </div>
                                        <?php
                                        endif;
                                    endif;
                                    ?>
                                </div>
                                <?php if($products && $item['item_more_btn_show'] == 'yes'): ?>
                                <div class="tab-foot">
                                    <?php
                                    $ajax = $item['item_more_btn_ajax'] == 'yes';
                                    $cls = $ajax ? 'tab-load-archive-btn' : '';
                                    $data = array('category' => $item['cat_id'], 'num' => $item['per_page'], 'item_cover_size' => $settings['item_cover_size']);
                                    $atts = $ajax ? 'data-wid="' . $wid . '" data-tab="#tab-content-' . $item['_id'] . '" data-settings="' . base64_encode(json_encode($data)) . '" data-page="2"' : '';
                                    ?>
                                        <a <?php $this->render_link_attrs($item['item_archive_link'], $item['item_more_btn_use_link']) ?> <?php echo $atts ?> class="tab-archive-btn <?php echo $cls ?>">
                                            <span><?php echo $item['item_more_btn_text']; ?></span>
                                            <i class="fas fa-chevron-<?php echo $ajax ? 'down' : (is_rtl() ? 'left' : 'right') ?>"></i>
                                            <div class="ahura-loader-ring"></div>
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
