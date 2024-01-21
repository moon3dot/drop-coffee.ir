<?php
// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class Ahura_Mega_Menu2 extends \Elementor\Widget_Base
{
    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('mega_menu2_css', mw_assets::get_css('elementor.mega_menu2'));
        if(!is_rtl()){
            mw_assets::register_style('mega_menu2_ltr_css', mw_assets::get_css('elementor.ltr.mega_menu2_ltr'));
        }

        mw_assets::register_script('mega_menu2_js', mw_assets::get_js('elementor.mega_menu2'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('mega_menu2_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('mega_menu2_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('mega_menu2_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'ahura_mega_menu2';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Mega Menu 2', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraheader'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['megamenu2', 'mega_menu2', esc_html__('Mega Menu 2', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Categories of products', 'ahura'),
            ]
        );

        $this->add_control(
            'box_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-list',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'hide_in_scroll',
            [
                'label' => __('Hide in scroll', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control('div1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'show_mobile_title',
            [
                'label' => esc_html__('Show Mobile Title', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'mobile_title',
            [
                'label' => esc_html__('Mobile Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Categories of products', 'ahura'),
                'condition' => ['show_mobile_title' => 'yes']
            ]
        );

        $this->add_control(
            'mobile_icon',
            [
                'label' => esc_html__('Mobile Button Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-bars',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'show_side_logo',
            [
                'label' => esc_html__('Show Mobile Menu Logo', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'logo',
            [
                'label' => esc_html__( 'Logo', 'ahura' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_template_directory_uri() . '/img/ahura-logo.png',
                ],
                'condition' => [
                    'show_side_logo' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Styles
         *
         *
         */
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
            'btn_styles_section',
            [
                'label' => __('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'btn_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 270
                ],
                'mobile_default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'tablet_default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('style_tabs');
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_responsive_control(
            'btn_align',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .mm2-button' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'btn_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mm2-button i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mm2-button svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mm2-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'selector' => '{{WRAPPER}} .mm2-button',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'selector' => '{{WRAPPER}} .mm2-button',
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_shadow',
                'selector' => '{{WRAPPER}} .mm2-button',
            ]
        );

        $this->add_control(
            'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 8,
                    'right' => 8,
                    'bottom' => 8,
                    'left' => 8,
                    'unit' => 'px',
                    'isLinked' => true,
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'btn_line_color_hover',
            [
                'label' => esc_html__( 'Line Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mm2-button:after' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_icon_color_hover',
            [
                'label' => esc_html__( 'Icon Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mm2-button:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mm2-button:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_text_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mm2-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-button:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border_hover',
                'selector' => '{{WRAPPER}} .mm2-button:hover',
            ]
        );

        $this->add_control(
            'btn_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_shadow_hover',
                'selector' => '{{WRAPPER}} .mm2-button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         *
         * Items style
         *
         */
        $this->start_controls_section(
            'items_styles_section',
            [
                'label' => __('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('items_style_tabs');
        $this->start_controls_tab(
            'items_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_responsive_control(
            'item_align',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .mm2-content .menu > li > a' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mm2-content .menu > li > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_typo',
                'selector' => '{{WRAPPER}} .mm2-content .menu > li > a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-content .menu > li > a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .mm2-content .menu > li > a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 0,
                            'bottom' => 1,
                            'left' => 0,
                        ]
                    ],
                    'color' => ['default' => '#00000000']
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'selector' => '{{WRAPPER}} .mm2-content .menu > li > a',
            ]
        );

        $this->add_control(
            'item_padding',
            [
                'label' => esc_html__( 'Padding', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-content .menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 13,
                    'right' => 13,
                    'bottom' => 13,
                    'left' => 13,
                    'unit' => 'px',
                    'isLinked' => true,
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'items_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'item_text_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mm2-content .menu > li > a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-content .menu > li > a:hover',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#f9f9f9'
                            ],
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border_hover',
                'selector' => '{{WRAPPER}} .mm2-content .menu > li > a:hover',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 0,
                            'bottom' => 1,
                            'left' => 0,
                        ]
                    ],
                    'color' => ['default' => '#f0f0f0']
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_hover',
                'selector' => '{{WRAPPER}} .mm2-content .menu > li > a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'items_style_active_tab',
            [
                'label' => esc_html__( 'Active', 'ahura' ),
            ]
        );

        $this->add_control(
            'item_text_color_active',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mm2-content .menu > li.current-menu-item > a, {{WRAPPER}} .mm2-content .menu > li.active-menu-item > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_background_active',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-content .menu > li.current-menu-item > a, {{WRAPPER}} .mm2-content .menu > li.active-menu-item > a',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#f9f9f9'
                            ],
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border_active',
                'selector' => '{{WRAPPER}} .mm2-content .menu > li.current-menu-item > a, {{WRAPPER}} .mm2-content .menu > li.active-menu-item > a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 0,
                            'bottom' => 1,
                            'left' => 0,
                        ]
                    ],
                    'color' => ['default' => '#f0f0f0']
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_active',
                'selector' => '{{WRAPPER}} .mm2-content .menu > li.current-menu-item > a, {{WRAPPER}} .mm2-content .menu > li.active-menu-item > a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         *
         * Sub Items style
         *
         */
        $this->start_controls_section(
            'sub_items_styles_section',
            [
                'label' => __('Sub Menus', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('sub_items_style_tabs');
        $this->start_controls_tab(
            'sub_items_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_responsive_control(
            'sub_item_align',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .mm2-sub-items ul li' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'primary_item_options',
            [
                'label' => esc_html__( 'Primary Item', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'p_sub_item_text_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mm2-sub-items ul li.menu-item-has-children > a, {{WRAPPER}} .mm2-sub-items ul li.menu-item-first > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'p_sub_item_typo',
                'selector' => '{{WRAPPER}} .mm2-sub-items ul li.menu-item-has-children > a, {{WRAPPER}} .mm2-sub-items ul li.menu-item-first > a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '700'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'p_sub_item_border',
                'selector' => '{{WRAPPER}} .mm2-sub-items ul li.menu-item-has-children > a, {{WRAPPER}} .mm2-sub-items ul li.menu-item-first > a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 0,
                            'right' => 2,
                            'bottom' => 0,
                            'left' => 0,
                        ]
                    ],
                    'color' => ['default' => '#e72828']
                ]
            ]
        );

        $this->add_control(
            'other_item_options',
            [
                'label' => esc_html__( 'Other Items', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'o_sub_item_text_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mm2-sub-items ul li a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'o_sub_item_typo',
                'selector' => '{{WRAPPER}} .mm2-sub-items ul li a',
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
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'o_sub_item_border',
                'selector' => '{{WRAPPER}} .mm2-sub-items ul li a',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'sub_items_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'primary_item_options_hover',
            [
                'label' => esc_html__( 'Primary Item', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'p_sub_item_text_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mm2-sub-items ul li.menu-item-has-children > a:hover, {{WRAPPER}} .mm2-sub-items ul li.menu-item-first > a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'p_sub_item_border_hover',
                'selector' => '{{WRAPPER}} .mm2-sub-items ul li.menu-item-has-children > a:hover, {{WRAPPER}} .mm2-sub-items ul li.menu-item-first > a:hover',
            ]
        );

        $this->add_control(
            'other_item_options_hover',
            [
                'label' => esc_html__( 'Other Items', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'o_sub_item_text_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mm2-sub-items ul li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'o_sub_item_border_hover',
                'selector' => '{{WRAPPER}} .mm2-sub-items ul li a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'sub_items_style_active_tab',
            [
                'label' => esc_html__( 'Active', 'ahura' ),
            ]
        );

        $this->add_control(
            'primary_item_options_active',
            [
                'label' => esc_html__( 'Primary Item', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'p_sub_item_text_color_active',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mm2-sub-items ul li.menu-item-has-children.current-menu-item > a, {{WRAPPER}} .mm2-sub-items ul li.menu-item-first.current-menu-item > a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'p_sub_item_border_active',
                'selector' => '{{WRAPPER}} .mm2-sub-items ul li.menu-item-has-children.current-menu-item > a:hover, {{WRAPPER}} .mm2-sub-items ul li.menu-item-first.current-menu-item > a:hover',
            ]
        );

        $this->add_control(
            'other_item_options_active',
            [
                'label' => esc_html__( 'Other Items', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'o_sub_item_text_color_active',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mm2-sub-items ul li.current-menu-item a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'o_sub_item_border_active',
                'selector' => '{{WRAPPER}} .mm2-sub-items ul li.current-menu-item a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         *
         * Box style
         *
         */
        $this->start_controls_section(
            'box_styles_section',
            [
                'label' => __('Mega Menu', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $position = [
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-h-align-right'
            ],
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-h-align-left'
            ],
        ];

        $this->add_responsive_control(
            'box_position',
            [
                'label' => esc_html__('Position', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $position : array_reverse($position),
                'default' => is_rtl() ? 'right' : 'left',
                'selectors' => [
                    '{{WRAPPER}} .mm2-container' => '{{VALUE}}: 0;'
                ],
            ]
        );

        $this->add_control(
            'box_width',
            [
                'label' => esc_html__( 'Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1140,
                ],
                'selectors' => [
                    '.mega-menu2-element .mm2-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_height',
            [
                'label' => esc_html__( 'Height', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '.mega-menu2-element .mm2-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-content',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .mm2-content',
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
                    'color' => ['default' => '#f0f0f0']
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'selector' => '{{WRAPPER}} .mm2-content',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 8,
                            'blur' => 10,
                            'spread' => 0,
                            'color' => '#00000038'
                        ]
                    ]
                ],

            ]
        );

        $this->end_controls_section();

        /**
         *
         * Side menu
         *
         */
        $this->start_controls_section(
            'mbtn_styles_section',
            [
                'label' => __('Mobile Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'mm_btn_width',
            [
                'label' => esc_html__( 'Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mm_btn_height',
            [
                'label' => esc_html__( 'Height', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-button' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mm_btn_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-button i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mm2-side-button svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'mm_btn_color',
            [
                'label' => esc_html__( 'Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-button, {{WRAPPER}} .mm2-side-button span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mm_btn_title_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .mm2-side-button span',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ]
                ],
                'condition' => ['show_mobile_title' => 'yes']
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mm_btn_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-side-button',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mm_btn_border',
                'selector' => '{{WRAPPER}} .mm2-side-button',
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
                    'color' => ['default' => '#f0f0f0']
                ]
            ]
        );

        $this->add_control(
            'mm_btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mm_btn_shadow',
                'selector' => '{{WRAPPER}} .mm2-side-button',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'side_styles_section',
            [
                'label' => __('Mobile Menu', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'side_width',
            [
                'label' => esc_html__( 'Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 5000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-side-content',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'side_items_styles_section',
            [
                'label' => __('Mobile Menu Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('side_items_style_tabs');
        $this->start_controls_tab(
            'side_items_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_item_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-content ul li a, {{WRAPPER}} .mm2-side-content ul li > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'side_item_typo',
                'selector' => '{{WRAPPER}} .mm2-side-content ul li a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_item_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-side-content ul li a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_item_border',
                'selector' => '{{WRAPPER}} .mm2-side-content ul li a',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'side_items_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_item_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-content ul li a:hover, {{WRAPPER}} .mm2-side-content ul li:hover > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_item_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-side-content ul li a:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_item_border_hover',
                'selector' => '{{WRAPPER}} .mm2-side-content ul li a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'side_items_style_active_tab',
            [
                'label' => esc_html__( 'Active', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_item_color_active',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-content ul li:is(.is-toggled, .current-menu-item) > a, {{WRAPPER}} .mm2-side-content ul li:is(.is-toggled, .current-menu-item) > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_item_background_active',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-side-content ul li:is(.is-toggled, .current-menu-item) > a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_item_border_active',
                'selector' => '{{WRAPPER}} .mm2-side-content ul li:is(.is-toggled, .current-menu-item) > a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'side_sub_items_styles_section',
            [
                'label' => __('Mobile Sub Menu Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('side_sub_items_style_tabs');
        $this->start_controls_tab(
            'side_sub_items_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_sub_item_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'side_sub_item_typo',
                'selector' => '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_sub_item_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li a',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#f0f0f0']
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_sub_item_border',
                'selector' => '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li a',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'side_sub_items_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_sub_item_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li a:hover, {{WRAPPER}} .mm2-side-content ul ul.sub-menu li:hover > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_sub_item_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li a:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_sub_item_border_hover',
                'selector' => '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'side_sub_items_style_active_tab',
            [
                'label' => esc_html__( 'Active', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_sub_item_color_active',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li:is(.is-toggled, .current-menu-item) > a, {{WRAPPER}} .mm2-side-content ul ul.sub-menu li:is(.is-toggled, .current-menu-item) a > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_sub_item_background_active',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li:is(.is-toggled, .current-menu-item) > a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_sub_item_border_active',
                'selector' => '{{WRAPPER}} .mm2-side-content ul ul.sub-menu li:is(.is-toggled, .current-menu-item) > a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
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
        $logo = $settings['logo'];
        $hide_in_scroll = ($settings['hide_in_scroll'] === 'yes') ? ' hide_in_scroll' : '';
        $show_mobile_title = $settings['show_mobile_title'] == 'yes';
        ?>
        <div class="mega-menu2-element mega-menu2-<?php echo $wid; ?> in_custom_header <?php echo $hide_in_scroll ?>">
            <div class="mm2-side-wrapper">
                <div class="mm2-side-button <?php echo $show_mobile_title ? 'has-mm-title' : '' ?>">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['mobile_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php if($show_mobile_title): ?>
                        <span><?php echo $settings['mobile_title'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="mm2-side-container" style="opacity:0;">
                    <div class="mm2-side-content">
                        <?php if ($settings['show_side_logo'] === 'yes'): ?>
                        <div class="mm2-side-head">
                            <a href="<?php echo site_url() ?>">
                                <?php
                                if(!empty($logo['id'])){
                                    echo wp_get_attachment_image( $logo['id'], 'full' );
                                } else {
                                    echo '<img src="' . $logo['url'] . '" alt="'. get_bloginfo('name') .'">';
                                }
                                ?>
                            </a>
                        </div>
                        <?php endif; ?>
                        <?php render_mega_menu(); ?>
                    </div>
                    <div class="mm2-side-overlay"></div>
                </div>
            </div>
            <div class="mm2-wrapper">
                <div class="mm2-button">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['box_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <span><?php echo $settings['title'] ?></span>
                </div>
                <div class="mm2-container" style="display: none">
                    <div class="mm2-content">
                        <div class="mm2-items">
                            <?php render_mega_menu(); ?>
                        </div>
                        <div class="mm2-sub-items"></div>
                    </div>
                </div>
            </div>
            <div class="mm2-overlay"></div>
        </div>
        <?php
    }
}