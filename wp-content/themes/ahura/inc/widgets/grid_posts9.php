<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts9 extends \Elementor\Widget_Base
{
    /**
     * grid_posts9 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts9_css', mw_assets::get_css('elementor.grid_posts9'));

        if(!is_rtl()){
            mw_assets::register_style('grid_posts9_ltr_css', mw_assets::get_css('elementor.ltr.grid_posts9_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_posts9_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('grid_posts9_ltr_css');
        }
        return $styles;
    }

    public function get_name()
    {
        return 'grid_posts9';
    }

    public function get_title()
    {
        return esc_html__('Grid Posts 9', 'ahura');
    }

	public function get_icon() {
		return 'eicon-posts-grid';
	}

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }

    public function get_keywords()
    {
        return ['gridposts9', 'grid_posts9', __('Grid Posts 9', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'display_settings',
            [
                'label' => esc_html__('Layout', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $post_types = get_post_types(array('public' => true), 'objects');
        unset($post_types['attachment']);
        $types = array();
        foreach ($post_types as $post_type) {
            $types[$post_type->name] = $post_type->labels->singular_name;
        }

        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Type', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $types,
            ]
        );

        $taxonomies = get_taxonomies(['public' => true], 'objects');

        $taxs = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($taxonomy->public) {
                    $taxs[$taxonomy->name] = $taxonomy->labels->name;
                }
            }
        }
        $default = ($taxs) ? key($taxs) : 0;
        $this->add_control(
            'tax_name',
            [
                'label' => esc_html__('Taxonomy', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $taxs,
                'label_block' => true,
            ]
        );

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
        $default = ($cats) ? key($cats) : 0;
        $this->add_control(
            'cat_id',
            [
                'label' => esc_html__('Categories', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $cats,
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Number of Per Page', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 12
            ]
        );

        $this->add_control(
            'layout_col',
            [
                'label' => esc_html__('Columns', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 3,
                'options' => [
                    '12' => 1,
                    '6' => 2,
                    '4' => 3,
                    '3' => 4,
                ]
            ]
        );

        $this->add_responsive_control(
            'layout_spacing',
            [
                'label' => esc_html__('Spacing', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
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
                    'size' => 20
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 > .row' => 'row-gap: {{SIZE}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();
        /**
         *
         * More Settings
         *
         */
        $this->start_controls_section(
            'display_more_settings',
            [
                'label' => esc_html__('More Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
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
                'default' => 'cover',
                'options' => [
                    'fill' => esc_html__( 'Default', 'ahura' ),
                    'contain' => esc_html__( 'Contain', 'ahura' ),
                    'cover'  => esc_html__( 'Cover', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-cover > img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control('divider', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'item_excerpt_show',
            [
                'label' => esc_html__('Excerpt', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
			'excerpt_chars_count',
			[
				'label'   => __( 'Excerpt Characters', 'ahura' ),
				'type'    => Controls_Manager::NUMBER,
                'default' => 20,
				'condition' => [
					'item_excerpt_show' => 'yes'
				]
			]
		);

        $this->add_control(
            'item_likes_show',
            [
                'label' => esc_html__('Likes Box', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'item_author_show',
            [
                'label' => esc_html__('Author', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'item_btn_show',
            [
                'label' => esc_html__('Button', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'post_box_button_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('More...', 'ahura'),
                'condition' => [
                    'item_btn_show' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();
        /**
         *
         *
         * Start styles
         *
         *
         */
                
         $this->start_controls_section(
            'item_post_styles',
            [
                'label' => esc_html__('Box', 'ahura'),
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
        if(!is_rtl())
        {
            $alignment = array_reverse($alignment);
        }

        $this->add_control(
            'box_text_alignment',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => $alignment,
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .grid-post-content' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'item_bg',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .grid-post-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0b0c40',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .post-title h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts-9 .post-title h2',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '700'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => '1.2',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'item_excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#8d8d8d',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .grid-post-content .post-excerpt, {{WRAPPER}} .grid-posts-9 .grid-post-content .post-excerpt p' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts-9 .grid-post-content .post-excerpt p',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '400'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'items_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .grid-post-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts-9 .grid-post-content',
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
                        'default' => '#F6F6F6',
                    ],
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts-9 .grid-post-content',
            ]
        );

        $this->add_control(
            'post_box_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'ahura'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'item_post_img_styles',
            [
                'label' => esc_html__('Image', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_img_min_height',
            [
                'label' => esc_html__('Min Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 320,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 320,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .post-cover > img' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'post_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .post-cover > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'item_btn_styles',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'item_btn_show' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('item_buttons_styles_tabs');

        $this->start_controls_tab(
            'item_buttons_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_button_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0b0c40',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .post-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_btn_typography',
                'label' => esc_html__('Button Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts-9 .post-btn a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'item_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .post-btn a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts-9 .post-btn a',
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
                    'color' => ['default' => '#8f8fa1']
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_button_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_button_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .post-btn a:hover' => 'color: {{VALUE}}',
                ],
                'default' => '#fff',
            ]
        );

        $this->add_control(
            'item_button_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-9 .post-btn a:hover' => 'background-color: {{VALUE}}',
                ],
                'default' => '#0b0c40',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts-9 .post-btn a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
       
        $this->start_controls_section(
            'item_pagination_styles',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('item_pagination_styles_tabs');

        $this->start_controls_tab(
            'item_pagination_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4c4c4c',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_pagination_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0b0c40',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_pagination_styles_active_tab',
            [
                'label' => esc_html__('Active', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_active_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_active_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0b0c40',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     *
     * Get posts result
     *
     * @param array $params
     * @return false
     */
    public function get_posts($params = [])
    {
        $settings = $this->get_settings_for_display();
        $args = array(
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['per_page'],
            'post_status' => 'publish',
        );

        if ($settings['cat_id']) {
            $args['tax_query'] = array(
                'tax_query' => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => $settings['tax_name'],
                        'field' => 'term_id',
                        'terms' => $settings['cat_id'],
                    ]
                ]
            );
        }

        $posts = new \WP_Query(array_merge($args, $params));
        return $posts;
    }

    /**
     *
     * Render content for display
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();

        $chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
        $page = $_GET['page_num'] ?? false;
        $current_page = ($page == 0) ? 1 : $page;

        $args = [];

        if ($settings['show_pagination'] === 'yes') {
            $args['paged'] = $current_page;
        }

        $elementClass = 'element-post-content clearfix';
		if ($settings['post_box_hover_animation']) {
			$elementClass .= ' elementor-animation-' . $settings['post_box_hover_animation'];
		}

        $cls = sprintf('col-12 col-sm-12 col-md-4 col-xs-6 col-lg-%s clearfix ', $settings['layout_col']);
        
		$this->add_render_attribute('wrapper', 'class', $cls . $elementClass);

        $posts = $this->get_posts($args);
        if ($posts): ?>
            <div class="grid-posts-9 grid-posts-9-wrap">
                <div class="row">
                    <?php 
                    while($posts->have_posts()) : $posts->the_post(); 
                        $like_count = ahura_get_post_likes(get_the_ID());
                        $like_count = intval($like_count) ? $like_count : '0';
                        $thumb_id = get_post_thumbnail_id();
                    ?>
                    <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                        <div class="grid-post-content <?php echo !intval($thumb_id) ? ' without-thumb' : '' ?>">
                            <div class="post-content-top">
                                <div class="post-cover">
                                    <?php if($settings['item_likes_show'] == 'yes' && intval($like_count)): ?>
                                        <div class="post-likes"><i class="fas fa-heart"></i><span><?php echo $like_count ?></span></div>
                                    <?php endif; ?>
                                    <?php echo get_the_post_thumbnail(get_the_ID(), $settings['item_cover_size']) ?>
                                    <?php if($settings['item_author_show'] == 'yes'): ?>
                                    <div class="post-author-box">
                                        <div class="post-author">
                                            <?php echo get_avatar(get_the_author_meta('email'), '60'); ?>
                                            <span class="post-author-name"><?php the_author(); ?></span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="post-details">
                                    <div class="post-title">
                                        <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                            <h2><?php the_title() ?></h2>
                                        </a>
                                    </div>
                                    <?php if ($settings['item_excerpt_show'] === 'yes'): ?>
                                        <div class="post-excerpt"><?php 
                                            if($chars_num){
                                                echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
                                            } else {
                                                the_excerpt();
                                            }
                                        ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="post-content-bottom">
                                <?php if ($settings['item_btn_show'] === 'yes'): ?>
                                <div class="post-btn">
                                    <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                        <?php echo $settings['post_box_button_text']; ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php if ($settings['show_pagination'] === 'yes'): ?>
                <div class="ahura-pagination">
                    <?php ahura_custom_pagination($posts->found_posts, $settings['per_page'], $current_page); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="mw_element_error">
                <?php echo esc_html__('Sorry, no posts were found for display.', 'ahura'); ?>
            </div>
        <?php
        endif;
    }
}