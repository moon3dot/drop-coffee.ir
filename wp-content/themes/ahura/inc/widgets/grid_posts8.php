<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts8 extends \Elementor\Widget_Base
{
    /**
     * grid_posts8 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts8_css', mw_assets::get_css('elementor.grid_posts8'));

        if(!is_rtl()){
            mw_assets::register_style('grid_posts8_ltr_css', mw_assets::get_css('elementor.ltr.grid_posts8_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_posts8_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('grid_posts8_ltr_css');
        }
        return $styles;
    }

    public function get_name()
    {
        return 'grid_posts8';
    }

    public function get_title()
    {
        return esc_html__('Grid Posts 8', 'ahura');
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
        return ['gridposts8', 'grid_posts8', __('Grid Posts 8', 'ahura')];
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
                    'size' => 25
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts-8 .row' => 'row-gap: {{SIZE}}{{UNIT}}'
                ]
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

        $this->add_control(
            'text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-details' => 'text-align: {{VALUE}}',
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
                    '{{WRAPPER}} .post-cover img' => 'object-fit: {{VALUE}};',
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
            'item_meta_show',
            [
                'label' => esc_html__('Meta', 'ahura'),
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
                'default' => 30,
				'condition' => [
					'item_excerpt_show' => 'yes'
				]
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
            'item_author_img_show',
            [
                'label' => esc_html__('Author Avatar', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'item_author_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_button',
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
                    'show_button' => 'yes'
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
            'item_img_styles',
            [
                'label' => esc_html__('Image', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_img_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .post-cover img',
            ]
        );

        $this->add_control(
            'item_img_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .post-cover img, {{WRAPPER}} .post-cover:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 30,
                    'right' => 30,
                    'bottom' => 30,
                    'left' => 30,
                ]
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
                'desktop_default' => [
                    'size' => 200,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 200,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 150,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-cover img' => 'min-height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'item_author_styles',
            [
                'label' => esc_html__('Author', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'item_author_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'item_author_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .post-author .post-author-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_author_posts_count_color',
            [
                'label' => esc_html__('Subtitle Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ba96cf',
                'selectors' => [
                    '{{WRAPPER}} .post-author .post-author-det' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'item_btn_styles',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_button' => 'yes'
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
                'default' => '#d5a2f2',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-btn a' => 'background-color: {{VALUE}}',
                ],
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
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content:hover .post-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_button_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#6d0cff',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content:hover .post-btn a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
       
        $this->start_controls_section(
            'item_box_styles',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'item_bg_1',
            [
                'label' => esc_html__('Background Primary', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content-top' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_bg_2',
            [
                'label' => esc_html__('Background Secondary', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6e6ff',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-title h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#787878',
                'selectors' => [
                    '{{WRAPPER}} .element-post-content .post-excerpt, {{WRAPPER}} .element-post-content .post-excerpt p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'post_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .element-post-content-top, {{WRAPPER}} .element-post-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 30,
                    'right' => 30,
                    'bottom' => 30,
                    'left' => 30,
                ]
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
            'item_pagination_styles',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#626262',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
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
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
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
                'type' => \Elementor\Controls_Manager::COLOR,
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
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00b0ff',
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
        return ($posts->have_posts()) ? $posts : false;
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
        $show_btn = $settings['show_button'] == 'yes';
        $show_author = $settings['item_author_show'] == 'yes';
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
		$this->add_render_attribute('wrapper', 'class', $elementClass);

        $cls = sprintf('col-12 col-md-4 col-sm-12 col-xs-12 col-lg-%s clearfix', $settings['layout_col']);

        $posts = $this->get_posts($args);
        if ($posts): ?>
            <div class="grid-posts-8 grid-posts-8-<?php echo $wid ?>">
                <div class="posts-list">
                    <div class="row">
                        <?php
                        while ($posts->have_posts()):
                            $posts->the_post();
                            $like_count = ahura_get_post_likes(get_the_ID());
                            $like_count = intval($like_count) ? $like_count : '0';

                            $thumb_id = get_post_thumbnail_id();

                            $gmdate = get_the_modified_date('F j, Y');
                            $date = $gmdate;
                            ?>
                            <div class="<?php echo $cls . ' ' . esc_attr($settings['post_box_hover_animation']) ?><?php echo (!intval($thumb_id)) ? ' without-thumb' : '' ?>">
                                <article <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                                    <div class="element-post-content-top">
                                        <div class="post-cover clearfix">
                                            <?php echo wp_get_attachment_image($thumb_id, $settings['item_cover_size']) ?>
                                            <?php if ($settings['item_meta_show'] === 'yes'): ?>
                                            <div class="post-metas">
                                                <div class="post-meta meta-like">
                                                    <i class="meta-icon meta-icon-heart"></i>
                                                    <span><?php echo $like_count ?></span>
                                                </div>
                                                <div class="post-meta meta-comment">
                                                    <i class="meta-icon meta-icon-comment"></i>
                                                    <span><?php echo get_comments_number() ?></span>
                                                </div>
                                                <div class="post-meta meta-date">
                                                    <i class="meta-icon meta-icon-calendar"></i>
                                                    <span><?php echo $date ?></span>
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
                                    <?php if($show_author || $show_btn): ?>
                                    <div class="element-post-content-bottom">
                                        <div class="post-bottom-cols <?php echo !$show_author || !$show_btn ? 'post-bottom-cols-single' : '' ?>">
                                            <div class="post-bottom-col">
                                                <?php if($show_author): ?>
                                                    <div class="post-author">
                                                        <?php
                                                        if($settings['item_author_img_show'] == 'yes'){
                                                            echo get_avatar(get_the_author_meta('email'), '60');
                                                        }
                                                        ?>
                                                        <div class="post-author-name"><?php the_author(); ?></div>
                                                        <div class="post-author-det"><?php echo sprintf(esc_html__('Posts %d', 'ahura'), count_user_posts(get_the_author_meta('ID'))) ?></div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($show_btn): ?>
                                            <div class="post-bottom-col">
                                                <div class="post-btn">
                                                    <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                                        <?php echo $settings['post_box_button_text']; ?>
                                                        <i class="fa fa-arrow-<?php echo is_rtl() ? 'left' : 'right' ?>"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </article>
                            </div>
                        <?php
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                        ?>
                    </div>
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