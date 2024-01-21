<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class ahura_archive_posts extends \ahura\app\elementor\Elementor_Widget_Base {
    private $query;

    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('archive_posts_css', mw_assets::get_css('elementor.archive_posts'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('archive_posts_css')];
        return $styles;
    }

    public function get_name()
    {
        return 'ahura_archive_posts';
    }

    public function get_title()
    {
        return esc_html__('Posts Archive', 'ahura');
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['ahura_archive'];
    }

    public function get_keywords()
    {
        return ['archive', 'posts_acrhive', __('Posts Archive', 'ahura')];
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

        $this->add_responsive_control(
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
                    '{{WRAPPER}} .ah-archive-posts-element > .row' => 'row-gap: {{SIZE}}{{UNIT}}'
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
            'fully_show_title',
            [
                'label'   => __( 'Fully Show Title', 'ahura' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-editor-close' ]
                ],
                'default' => 'yes'
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

        $this->end_controls_section();

        $this->start_controls_section(
            'not_found_settings',
            [
                'label' => esc_html__('Content Not Found', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'not_found_image',
            [
                'label' => __('Choose Image', 'ahura'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \ahura\app\mw_assets::get_img('not-found', 'webp')
                ]
            ]
        );

        $this->add_control(
            'not_found_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Content Not Found', 'ahura'),
            ]
        );

        $this->add_control(
            'not_found_description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__('Sorry, no posts were found for display.', 'ahura'),
            ]
        );

        $this->add_control(
            'show_not_found_btn',
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
            'not_found_btn_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Back to Home', 'ahura'),
                'condition' => [
                    'show_not_found_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'not_found_btn_url',
            [
                'label' => esc_html__( 'Link', 'ahura' ),
                'label_block' => true,
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => site_url(),
                ],
                'condition' => [
                    'show_not_found_btn' => 'yes'
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
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .ah-post-item-content' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .ah-post-item-content .ah-post-title' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .ah-post-item-content .post-metas' => 'text-align: {{VALUE}}',
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
                    '{{WRAPPER}} .ah-post-item-content' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .ah-post-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-post-title',
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
                    '{{WRAPPER}} .ah-post-item-content .post-excerpt, {{WRAPPER}} .ah-archive-posts-element .ah-post-item-content .post-excerpt p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-post-item-content .post-excerpt, {{WRAPPER}} .ah-archive-posts-element .ah-post-item-content .post-excerpt p',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '300'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'item_meta_color',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#b7b7b7',
                'selectors' => [
                    '{{WRAPPER}} .post-metas' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_meta_typography',
                'label' => esc_html__('Meta Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .post-metas',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-post-item-content',
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

        $this->add_control(
            'items_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ah-post-item-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-post-item-content',
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
                    'size' => 200,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 200,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 200,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-cover > img' => 'height: {{SIZE}}{{UNIT}}'
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
                    '{{WRAPPER}} .post-cover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .post-cover > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'default' => '#000000bd',
                'selectors' => [
                    '{{WRAPPER}} .post-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_btn_typography',
                'label' => esc_html__('Button Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .post-btn a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
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
                'default' => '#b7ccdf64',
                'selectors' => [
                    '{{WRAPPER}} .post-btn a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .post-btn a',
            ]
        );

        $this->add_control(
            'box_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .post-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .post-btn a:hover' => 'color: {{VALUE}}',
                ],
                'default' => '#000',
            ]
        );

        $this->add_control(
            'item_button_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-btn a:hover' => 'background-color: {{VALUE}}',
                ],
                'default' => '#b7ccdfb3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .post-btn a:hover',
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

        $this->start_controls_section(
            'not_found_styles',
            [
                'label' => esc_html__('Content Not Found', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'not_found_img_width',
            [
                'label' => esc_html__('Image Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
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
                    'size' => 30,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ah-not-found-content img' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'not_found_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#015a94',
                'selectors' => [
                    '{{WRAPPER}} .ah-not-found-content h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'not_found_title_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-not-found-content h3',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '900'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => '1.5',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'not_found_des_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#83b0cf',
                'selectors' => [
                    '{{WRAPPER}} .ah-not-found-content h4' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'not_found_des_typography',
                'label' => esc_html__('Description Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-not-found-content h4',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '400'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => '1.1',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'not_found_btn_options',
            [
                'label' => esc_html__('Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => ['show_not_found_btn' => 'yes']
            ]
        );

        $this->add_control(
            'not_found_btn_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ah-more-links a' => 'color: {{VALUE}}',
                ],
                'condition' => ['show_not_found_btn' => 'yes']
            ]
        );

        $this->add_control(
            'not_found_btn_bg',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#015a94',
                'selectors' => [
                    '{{WRAPPER}} .ah-more-links a' => 'background-color: {{VALUE}}',
                ],
                'condition' => ['show_not_found_btn' => 'yes']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'not_found_btn_typography',
                'selector' => '{{WRAPPER}} .ah-more-links a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '400'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => '1',
                        ]
                    ]
                ],
                'condition' => ['show_not_found_btn' => 'yes']
            ]
        );

        $this->add_control(
            'not_found_btn_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ah-more-links a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ],
                'condition' => ['show_not_found_btn' => 'yes']
            ]
        );

        $this->end_controls_section();
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

        $show_full_title = $settings['fully_show_title'] == 'yes';

        $chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;
        $page = get_query_var('paged', 1);
        $current_page = ($page == 0) ? 1 : $page;

        $elementClass = 'element-post-content clearfix';
        if ($settings['post_box_hover_animation']) {
            $elementClass .= ' elementor-animation-' . $settings['post_box_hover_animation'];
        }

        $desktop_col = isset($settings['layout_col']) ? $settings['layout_col'] : 3;
        $tablet_col = isset($settings['layout_col_tablet']) ? $settings['layout_col_tablet'] : 4;
        $mobile_col = isset($settings['layout_col_mobile']) ? $settings['layout_col_mobile'] : 12;
        $cls = sprintf('col-%s col-sm-12 col-md-%s col-xs-6 col-lg-%s clearfix ', $mobile_col, $tablet_col, $desktop_col);

        $this->add_render_attribute('wrapper', 'class', $cls . $elementClass);

        $posts = $this->query_posts();
        ?>
            <div class="ah-archive-posts-element ah-archive-posts-element-wrap">
            <?php if ($posts && $posts->found_posts): ?>
                <div class="row">
                    <?php
                    while($posts->have_posts()) : $posts->the_post();
                        $like_count = ahura_get_post_likes(get_the_ID());
                        $like_count = intval($like_count) ? $like_count : '0';
                        $thumb_id = get_post_thumbnail_id();
                        ?>
                        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                            <div class="ah-post-item-content <?php echo !intval($thumb_id) ? ' without-thumb' : '' ?>">
                                <div class="post-content-top">
                                    <div class="post-cover">
                                        <?php
                                        $img = get_the_post_thumbnail(get_the_ID(), $settings['item_cover_size']);
                                        if (!empty($img)){
                                            echo $img;
                                        } else {
                                            $img = mw_assets::get_img('default');
                                            echo "<img src='{$img}' alt='no image'>";
                                        }
                                        ?>
                                    </div>
                                    <div class="post-details">
                                        <div class="post-title-wrap">
                                            <a href="<?php echo esc_attr(get_the_permalink()) ?>" title="<?php echo !$show_full_title ? esc_attr(get_the_title()) : '' ?>">
                                                <h3 class="ah-post-title"><?php echo $show_full_title ? get_the_title() : wp_trim_words( get_the_title(), 6, '...' ); ?></h3>
                                            </a>
                                        </div>
                                        <div class="post-metas">
                                            <?php if($settings['item_author_show'] == 'yes'): ?>
                                                <span class="post-author">
                                                    <i class="fas fa-user"></i>
                                                    <span class="post-author-name"><?php the_author(); ?></span>
                                                </span>
                                            <?php endif; ?>
                                            <?php if($settings['item_likes_show'] == 'yes'): ?>
                                                <span class="post-likes">
                                                    <i class="fas fa-heart"></i>
                                                    <span><?php echo $like_count ?></span>
                                                </span>
                                            <?php endif; ?>
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
                <?php if ($settings['show_pagination'] === 'yes' && $posts->found_posts): ?>
                    <div class="ahura-pagination">
                        <?php ahura_custom_pagination(
                                $posts->found_posts,
                                get_option('posts_per_page'),
                                $current_page,
                                'page/%#%',
                                get_theme_mod('ahura_archive_pagination_prev_text'),
                                get_theme_mod('ahura_archive_pagination_next_text'),
                        ); ?>
                    </div>
                <?php endif; ?>
            <?php else:
                $image = $settings['not_found_image'];
                if (!empty($settings['not_found_btn_url']['url'])) {
                    $this->add_link_attributes('back_link', $settings['not_found_btn_url']);
                }
                ?>
                <div class="ah-not-found-content">
                    <?php if (empty($image['id']) && !empty($image['url'])): ?>
                        <img src="<?php echo $image['url'] ?>" alt="404">
                    <?php else: ?>
                        <?php echo wp_get_attachment_image($image['id'], 'full'); ?>
                    <?php endif; ?>
                    <h3><?php echo $settings['not_found_title']; ?></h3>
                    <h4><?php echo $settings['not_found_description']; ?></h4>
                    <div class="ah-more-links">
                        <?php if ($settings['show_not_found_btn'] == 'yes'): ?>
                        <a <?php echo $this->get_render_attribute_string('back_link'); ?>>
                            <?php echo $settings['not_found_btn_text']; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
    <?php
    }

    public function query_posts() {
        global $wp_query;

        $query_vars = $wp_query->query_vars;

        if (is_admin() || is_single()){
            $this->query = new \WP_Query([
                'post_type' => 'post',
                'posts_per_page' => 12
            ]);
        } elseif ( $query_vars !== $wp_query->query_vars ) {
            $this->query = new \WP_Query( $query_vars );
        } else {
            $this->query = $wp_query;
        }

        return $this->query;
    }
}
