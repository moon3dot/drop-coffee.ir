<?php
namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

class grid_posts6 extends \Elementor\Widget_Base
{
    /**
     * grid_posts6 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_post_6_css', mw_assets::get_css('elementor.grid_posts6'));
        if (!is_rtl()) {
            mw_assets::register_style('grid_post_6_ltr_css', mw_assets::get_css('elementor.ltr.grid_posts6_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_post_6_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('grid_post_6_ltr_css');
        }
        return $styles;
    }

    public function get_name()
    {
        return 'gridposts6';
    }

    public function get_title()
    {
        return esc_html__('Grid Posts 6', 'ahura');
    }

	public function get_icon() {
		return 'aicon-svg-grid-post-6';
	}

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }

    public function get_keywords()
    {
        return ['gridposts6', 'grid_posts_6', esc_html__('Grid Posts 6', 'ahura')];
    }

    public function register_controls()
    {
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

        $this->start_controls_section(
            'content_tab',
            [
                'label' => esc_html__('Box', 'ahura'),
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
                $taxs[$taxonomy->name] = $taxonomy->labels->name;
            }
        }
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
                    if ($term_object) {
                        foreach ($term_object as $term) {
                            $cats[$term->term_id] = "{$term->name} - {$taxonomy->labels->name}";
                        }
                    }
                }
            }
        }
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
            'posts_number',
            [
                'label' => esc_html__('Posts Number', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 3,
                'condition' => [
                    'show_title' => 'yes',
                    'show_count' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__('Box Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Interior Decoration', 'ahura'),
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_des',
            [
                'label' => esc_html__('Box Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                'condition' => [
                    'show_des' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'more_options',
            [
                'label' => esc_html__('Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'button_title',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('View All', 'ahura'),
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fa fa-eye',
                    'library' => 'solid',
                ],
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://mihanwp.com',
                'dynamic' => ['active' => true],
                'label_block' => true,
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Settings tab
         *
         */
        $this->start_controls_section(
            'settings_tab',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Box Title', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' => esc_html__('Posts Number', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_title' => 'yes',
                ]
            ]
        );


        $this->add_control(
            'show_des',
            [
                'label' => esc_html__('Box Description', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => esc_html__('Box Button', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'equal_height',
            [
                'label' => esc_html__('Equal Height', 'ahura'),
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
         * Post box settings
         *
         *
         *
         */
        $this->start_controls_section(
            'post_box_settings_tab',
            [
                'label' => esc_html__('Post Box Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'post_box_show_meta',
            [
                'label' => esc_html__('Box Meta', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'post_box_show_title',
            [
                'label' => esc_html__('Box Title', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'post_box_show_des',
            [
                'label' => esc_html__('Box Description', 'ahura'),
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
				'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 30,
				'condition' => [
					'post_box_show_des' => 'yes'
				]
			]
		);

        $this->add_control(
            'post_box_show_button',
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
                    'post_box_show_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'post_box_show_divider',
            [
                'label' => esc_html__('Divider', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'full',
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Start Styles
         *
         *
         */
        $this->start_controls_section(
            'box_des_styles_tab',
            [
                'label' => esc_html__('Box Description', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'box_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-title-content' => 'text-align: {{VALUE}}',
                ],
                'tablet_default' => 'center',
                'mobile_default' => 'center',
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-title-content h2' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_count_color',
            [
                'label' => esc_html__('Posts Number color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#8d8d8d',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-title-content .posts-count' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_des_color',
            [
                'label' => esc_html__('Description color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#8d8d8d',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-title-content .box-des' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_title_bg',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-title-content' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_divider_color',
            [
                'label' => esc_html__('Divider color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#deb57b',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-title::before' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts6 .box-title h2',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
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
                'name' => 'box_count_typo',
                'label' => esc_html__('Posts Count Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts6 .box-title .posts-count',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_des_typo',
                'label' => esc_html__('Description Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts6 .box-des',
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
            'box_des_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-title-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ],
            ]
        );

        $this->add_control(
            'more_options1',
            [
                'label' => esc_html__('Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('des_button_style_tabs');

        $this->start_controls_tab(
            'des_button_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .box-buttons a i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .box-buttons a svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_btn_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-buttons a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .grid-posts6 .box-buttons a i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .grid-posts6 .box-buttons a svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_btn_bg',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#deb57b',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-buttons a' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_btn_typo',
                'label' => esc_html__('Text Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts6 .box-buttons a',
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
            'box_btn_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-buttons a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_responsive_control(
            'box_btn_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-buttons a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 10,
                    'right' => 20,
                    'bottom' => 10,
                    'left' => 20,
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'des_button_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_btn_text_color_hover',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-buttons a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_btn_bg_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .box-buttons a:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /**
         *
         *
         * Post box style
         *
         *
         */
        $this->start_controls_section(
            'post_box_styles_tab',
            [
                'label' => esc_html__('Post Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'post_box_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-wrap' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .grid-posts6 .post-wrap p' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'post_box_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-wrap .post--content div' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .grid-posts6 .post-wrap .post--content p' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .grid-posts6 .post-wrap .post--content span' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'post_box_content_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, .32)',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-wrap .post-content' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_box_meta_typo',
                'label' => esc_html__('Meta Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts6 .post-wrap .post--content .post-meta span',
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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts6 .post-wrap .post--content .post-title h3',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ],
                'condition' => [
                    'post_box_show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_box_des_typo',
                'label' => esc_html__('Description Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts6 .post-wrap .post-excerpt',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ],
                'condition' => [
                    'post_box_show_des' => 'yes'
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
            'post_box_button_styles_tab',
            [
                'label' => esc_html__('Post Box Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'post_box_show_button' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('post_box_button_styles_tabs');

        $this->start_controls_tab(
            'post_box_button_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_responsive_control(
            'post_box_button_align',
            [
                'label' => esc_html__('Button Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-link-box' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'post_box_btn_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .post-link' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'post_box_btn_bg',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#deb57b',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .post-link' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_box_btn_typo',
                'label' => esc_html__('Text Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts6 .post-content .post-link',
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
            'post_box_btn_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .post-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 0,
                    'right' => 15,
                    'bottom' => 0,
                    'left' => 0,
                ]
            ]
        );

        $this->add_responsive_control(
            'post_box_btn_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .post-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 10,
                    'right' => 20,
                    'bottom' => 10,
                    'left' => 20,
                ]
            ]
        );

        $this->add_responsive_control(
            'post_box_btn_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .post-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'post_box_button_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'post_box_btn_text_color_hover',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .post-link:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'post_box_btn_bg_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .post-link:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Post Box Divider
         *
         *
         */
        $this->start_controls_section(
            'post_box_divider_styles_tab',
            [
                'label' => esc_html__('Post Box Divider', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'post_box_show_divider' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'post_box_divider_btn_bg',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .divider span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'post_box_divider_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .divider span' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'post_box_divider_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .divider span' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'post_box_divider_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts6 .post-content .divider' => 'margin: {{SIZE}}{{UNIT}} 0;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function get_query()
    {
        $settings = $this->get_settings_for_display();
        $args = array(
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_number'],
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

        $posts = new \WP_Query($args);
        return ($posts->have_posts()) ? $posts : false;
    }

    public function render_link_attrs($url_data)
    {
        $target = $url_data['is_external'] ? 'target="_blank"' : '';
        $nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
        $cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
        $data = 'href="' . $url_data['url'] . '" ' . $target . ' ' . $nofollow . ' ' . $cu_attr;
        return $data;
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
        $posts = $this->get_query();
        $count = wp_count_posts($settings['post_type']);
        $post_type_link = get_post_type_archive_link($settings['post_type']);
        $equal = $settings['equal_height'] ? 'post-wrap-equal' : '';
        $pb_cls = 'col-12 col-xs-12 col-sm-6 col-md-3 col-lg-3 p-0 m-0 post-item-col ' . $equal;
        $pb_cls .= $settings['post_box_hover_animation'] ? ' elementor-animation-' . $settings['post_box_hover_animation'] : '';
        $this->add_render_attribute('wrapper', 'class', $pb_cls);
        ?>
        <div class="grid-posts6">
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3 ps-3 p-0 m-0 <?php echo $equal ?>">
                    <div class="box-title-content <?php echo (is_rtl()) ? 'pl-3' : 'pr-3'; ?>">
                        <?php if ($settings['show_title'] == 'yes'): ?>
                            <div class="box-title">
                                <h2><?php echo $settings['box_title'] ?></h2>
                                <?php if ($settings['show_count'] == 'yes'): ?>
                                    <div class="posts-count"><?php echo sprintf(esc_html__('Posts Count : %d', 'ahura'), $count->publish ?? 0) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($settings['show_des'] == 'yes'): ?>
                            <div class="box-des"><?php echo $settings['box_des'] ?></div>
                        <?php endif; ?>
                        <?php if ($settings['show_button'] == 'yes'): ?>
                            <div class="box-buttons">
                                <a <?php echo (!empty($settings['button_link'])) ? $this->render_link_attrs($settings['button_link']) : "href='{$post_type_link}'" ?>>
                                    <?php echo $settings['button_title'] ?>
                                    <?php if (!empty($settings['button_icon']['value'])): ?>
                                        <?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                if ($posts):
                    while ($posts->have_posts()): $posts->the_post();
                        $gmdate = get_the_modified_date('F j, Y');
                        $date = $gmdate;
                        ?>
                        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                            <div class="post-wrap">
                                <div class="post-cover" style="background-image:url(<?php esc_attr(the_post_thumbnail_url(get_the_ID(), $settings['item_cover_size'])) ?>)"></div>
                                <div class="post-content row align-items-end p-0 m-0">
                                    <div class="post--content">
                                        <a href="<?php the_permalink() ?>" class="post-link-wrap">
                                            <?php if($settings['post_box_show_meta'] == 'yes'): ?>
                                                <div class="post-meta">
                                                    <span class="post-datetime">
                                                        <i class="fa fa-calendar"></i>
                                                        <?php echo $date ?>
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($settings['post_box_show_title'] == 'yes'): ?>
                                                <div class="post-title"><h3><?php the_title() ?></h3></div>
                                            <?php endif; ?>
                                            <?php if ($settings['post_box_show_divider'] == 'yes'): ?>
                                                <div class="divider"><span></span></div>
                                            <?php endif; ?>
                                            <?php if ($settings['post_box_show_des'] == 'yes'): ?>
                                                <div class="post-excerpt"><?php 
                                                    if($chars_num){
                                                        echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
                                                    } else {
                                                        the_excerpt();
                                                    }
                                                ?></div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <?php if ($settings['post_box_show_button'] == 'yes'): ?>
                                        <div class="post-link-box">
                                            <a href="<?php the_permalink() ?>" class="post-link">
                                                <?php echo $settings['post_box_button_text'] ?>
                                                <i class="fa fa-chevron-<?php echo (is_rtl()) ? 'left' : 'right'; ?>"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                else: ?>
                    <div class="col-9">
                        <div class="mw_element_error">
                            <?php echo esc_html__('Sorry, no content was found for display', 'ahura'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}