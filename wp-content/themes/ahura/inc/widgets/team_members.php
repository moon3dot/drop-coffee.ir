<?php
namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class team_members extends \Elementor\Widget_Base
{
    /**
     * team_members constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('team_members_css', mw_assets::get_css('elementor.team_members'));
        if(!is_rtl()){
            mw_assets::register_style('team_members_ltr_css', mw_assets::get_css('elementor.ltr.team_members_ltr'));
        }

        mw_assets::register_script('team_members_js', mw_assets::get_js('elementor.team_members'));
        wp_localize_script(mw_assets::get_handle_name('team_members_js'), 'ahura_data_tmel', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'translate' => [
                'view_more' => __('View More', 'ahura')
            ]
        ]);
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('team_members_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('team_members_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('team_members_js')];
    }

    public function get_name()
    {
        return 'ahura_team_members';
    }

    public function get_title()
    {
        return esc_html__('Team Members', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-person';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['teammembers', 'team_members', esc_html__('Team Members', 'ahura')];
    }

    public function register_controls()
    {
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

        $taxonomies = get_taxonomies(['public' => true, 'name' => 'team_cat'], 'objects');

        $cats = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($term_object = get_terms($key)) {
                    if($term_object){
                        foreach ($term_object as $term) {
                            $cats[$term->term_id] = "{$term->name}";
                        }
                    }
                }
            }
        }

        $repeater->add_control(
            'cat_ids',
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
                'label' => esc_html__('Count', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'min' => 1,
                'max' => 30,
            ]
        );

        $repeater->add_control(
            'show_cats',
            [
                'label' => esc_html__('Categories', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'show_options',
            [
                'label' => esc_html__('Options', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'item_options_box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('SKILLS', 'ahura'),
                'codition' => [
                    'show_options' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'show_bio',
            [
                'label' => esc_html__('Bio', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'item_bio_box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('BIO', 'ahura'),
                'codition' => [
                    'show_bio' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
			'bio_chars_count',
			[
				'label'   => __('Bio Characters', 'ahura'),
				'type'    => Controls_Manager::NUMBER,
				'condition' => [
					'show_bio' => 'yes'
				]
			]
		);

        $repeater->add_control(
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

        $repeater->add_control(
            'show_overlay',
            [
                'label' => esc_html__('Background Image', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'items_overlay',
            [
                'label' => esc_html__('Choose Cover', 'ahura'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
					'show_overlay' => 'yes'
				]
            ]
        );

        $this->add_control(
            'tab_items',
            [
                'label' => esc_html__('Tabs', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{item_title}}}',
                'default' => [
                    [
                        'item_title' => esc_html__('Tab Title', 'ahura'),
                        'item_archive_link' => ['url' => site_url()],
                    ]
                ]
            ]
        );

        $this->add_control('divider1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'label' => esc_html__('Avatar', 'ahura'),
                'name' => 'item_cover',
                'default' => 'full',
            ]
        );
        $this->end_controls_section();
        /**
         * 
         * 
         * 
         * Styles
         * 
         * 
         * 
         */
        $this->start_controls_section(
            'tab_items_style',
            [
                'label' => esc_html__('Tabs', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_tabs_divider_color',
            [
                'label' => esc_html__('Divider Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#7e7e7e',
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs .shadow-line:before' => 'background: linear-gradient(to right, transparent, {{VALUE}});',
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs .shadow-line:after' => 'background: linear-gradient(to left, transparent, {{VALUE}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_tabs_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->start_controls_tabs('style_tabs');
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_tab_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_tab_title_bg_color',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_tab_typo',
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_tab_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 0,
                    'left' => 0,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 0,
                            'left' => 1,
                        ]   
                    ],
                    'color' => ['default' => '#b7b7b7']
                ]
            ]
        );

        $this->add_responsive_control(
            'item_tab_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'item_tab_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a',
            ]
        );
        
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_tab_title_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_tab_title_bg_color_hover',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a:hover',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_tab_typo_hover',
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a:hover',
            ]
        );

        $this->add_control(
            'item_tab_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li a:hover',
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
            'item_tab_title_color_active',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li.active a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_tab_title_bg_color_active',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li.active a',
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'color' => ['default' => 'rgba(254,196,0,1)'],
                    'color_b' => ['default' => 'rgba(254,215,0,1)'],
                    'gradient_angle' => [
                        'default' => [
                        'unit' => 'deg',
                        'size' => 90,
                        ]
                    ],
                ]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_tab_typo_active',
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li.active a',
            ]
        );

        $this->add_control(
            'item_tab_radius_active',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li.active a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border_active',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li.active a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 0,
                            'left' => 1,
                        ]   
                    ],
                    'color' => ['default' => 'transparent']
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow_active',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-element-tabs li.active a',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 2,
                            'blur' => 5,
                            'spread' => 0,
                            'color' => '#0000002e'
                        ]
                    ]
                ],
            ]
        );
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /**
         * 
         * Sub Tabs
         * 
         */
        $this->start_controls_section(
            'subtab_items_style',
            [
                'label' => esc_html__('Sub Tabs', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_subtabs_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'unit' => 'rem',
                    'top' => 2,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0,
                ]
            ]
        );

        $this->start_controls_tabs('style_subtabs');
        
        $this->start_controls_tab(
            'style_normal_subtab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_subtab_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_subtab_title_bg_color',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_subtab_typo',
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_subtab_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_subtab_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 2,
                            'left' => 0,
                        ]   
                    ],
                    'color' => ['default' => 'transparent']
                ]
            ]
        );

        $this->add_responsive_control(
            'item_subtab_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_subtab_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_subtab_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a',
            ]
        );
        
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_subtab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_subtab_title_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_subtab_title_bg_color_hover',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a:hover',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_subtab_typo_hover',
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a:hover',
            ]
        );

        $this->add_control(
            'item_subtab_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_subtab_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_subtab_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li a:hover',
            ]
        );
        
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_active_subtab',
            [
                'label' => esc_html__('Active', 'ahura'),
            ]
        );

        $this->add_control(
            'item_subtab_title_color_active',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li.active a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_subtab_title_bg_color_active',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li.active a',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_subtab_typo_active',
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li.active a',
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

        $this->add_control(
            'item_subtab_radius_active',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li.active a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_subtab_border_active',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li.active a',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 2,
                            'left' => 0,
                        ]   
                    ],
                    'color' => ['default' => '#fed700']
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_subtab_shadow_active',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-sub-tabs li.active a',
            ]
        );
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /**
         * 
         * Items Style
         * 
         */
        $this->start_controls_section(
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'items_spacing',
            [
                'label' => esc_html__('Spacing', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 11,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-tab-content' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-info-box' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'items_first_bg_color',
				'label' => esc_html__('First Background Color', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ahura-team-members-element .team-info-box',
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 0
                        ]
                    ],
                    'color' => ['default' => 'rgb(19 41 90)'],
                    'color_b' => ['default' => 'rgb(12 26 58)'],
                    'color_b_stop' => [
                        'default' => [
                            'unit' => '%',
                            'size' => 60
                        ]
                    ],
                ]
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'items_second_bg_color',
				'label' => esc_html__('Second Background Color', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ahura-team-members-element .team-tab-content > div:nth-child(4n+4) .team-info-box, {{WRAPPER}} .ahura-team-members-element .team-tab-content > div:nth-child(4n+1) .team-info-box, {{WRAPPER}} .ahura-team-members-element .team-tab-content > div:nth-child(8n+4) .team-info-box, {{WRAPPER}} .ahura-team-members-element .team-tab-content > div:nth-child(8n+9) .team-info-box, {{WRAPPER}} .ahura-team-members-element .team-tab-content > div:nth-child(8n+1) .team-info-box, {{WRAPPER}} .ahura-team-members-element .team-tab-content > div:nth-child(8n+5) .team-info-box, {{WRAPPER}} .ahura-team-members-element .team-tab-content > div:nth-child(4n+8) .team-info-box, {{WRAPPER}} .ahura-team-members-element .team-tab-content > div:nth-child(12n+4) .team-info-box',
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'gradient_angle' => [
                        'default' => [
                            'unit' => 'deg',
                            'size' => 0
                        ]
                    ],
                    'color' => ['default' => 'rgb(189 160 0)'],
                    'color_b' => ['default' => 'rgb(62 43 0)'],
                    'color_b_stop' => [
                        'default' => [
                            'unit' => '%',
                            'size' => 60
                        ]
                    ],
                ]
			]
		);

        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-info-box, {{WRAPPER}} .ahura-team-members-element .team-box-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-info-box',
            ]
        );

        $this->add_responsive_control(
            'item_box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-info-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'unit' => 'rem',
                    'top' => 2,
                    'right' => 2.5,
                    'bottom' => 2,
                    'left' => 2.5,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-info-box',
            ]
        );

        $this->add_control(
			'cover_options',
			[
				'label' => esc_html__('Cover', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

        $this->add_responsive_control(
            'items_cover_dimensions',
            [
                'label' => esc_html__('Dimensions', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 170,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-avatar img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'items_cover_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 75,
                    'right' => 75,
                    'bottom' => 75,
                    'left' => 75,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'items_cover_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-avatar img',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 6,
                            'right' => 6,
                            'bottom' => 6,
                            'left' => 6,
                        ]   
                    ],
                    'color' => ['default' => '#fff']
                ]
            ]
        );

        $this->add_responsive_control(
            'items_cover_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-avatar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => -160,
                    'right' => 0,
                    'bottom' => 20,
                    'left' => 0,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_cover_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-avatar img',
            ]
        );

        $this->add_control(
			'more_options',
			[
				'label' => esc_html__('More', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'items_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fed700',
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-name',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '18'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_control(
            'items_subtitle_color',
            [
                'label' => esc_html__('Sub Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-post' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_subtitle_typo',
                'label' => esc_html__('Sub Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-post',
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

        $this->add_control(
			'item_options_more',
			[
				'label' => esc_html__('Options', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'items_options_color',
            [
                'label' => esc_html__('Options Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .main-details li' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_options_typo',
                'label' => esc_html__('Options Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .main-details li',
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

        $this->add_control(
			'bio_more',
			[
				'label' => esc_html__('Bio', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'items_bio_color',
            [
                'label' => esc_html__('Bio Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura-team-members-element .team-bio, {{WRAPPER}} .ahura-team-members-element .team-bio p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_bio_typo',
                'label' => esc_html__('Bio Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-team-members-element .team-bio, {{WRAPPER}} .ahura-team-members-element .team-bio p',
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

        $this->end_controls_section();
        /**
         *
         *
         * item pagination styles
         *
         *
         */
        $this->start_controls_section(
            'item_pagination_styles',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
                'default' => '#000',
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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_pagination_typo',
                'selector' => '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
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

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_pagination_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_pagination_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 2,
                            'blur' => 10,
                            'spread' => 0,
                            'color' => '#0000003b'
                        ]
                    ]
                ],
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
            'item_pagination_buttons_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_pagination_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_pagination_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover',
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
            'item_pagination_buttons_text_color_active',
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
            'item_pagination_buttons_bg_color_active',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_pagination_border_active',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination span.current',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_pagination_shadow_active',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination span.current',
            ]
        );
       
        $this->end_controls_tab();
        $this->end_controls_tabs();
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

        $items = $settings['tab_items'];

        $page = $_GET['page_num'] ?? false;
        $current_page = ($page == 0) ? 1 : $page;
        ?>
        <div class="ahura-team-members-element ahura-team-members-element-<?php echo $wid ?>">
            <div class="team-element-tabs">
                <ul>
                    <?php
                    $i = 0;
                    foreach ($items as $item):
                        $first = ($i === 0);
                        $activeCls = $first ? 'active' : '';
                        $i++;
                        ?>
                        <li class="elementor-repeater-item-<?php echo $item['_id'] . ' ' . $activeCls; ?>">
                            <a href="#" class="tab-item-btn" id="tab-item-<?php echo $item['_id'] ?>" data-wid="<?php echo $wid ?>" data-tab="#tab-content-<?php echo $item['_id'] ?>">
                                <?php echo $item['item_title'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="shadow-line"></div>
            </div>
            <div class="team-tabs-content">
                <?php
                $i = 0;
                foreach ($items as $item):
                    $firstWrap = ($i === 0);
                    $activeCls = $firstWrap ? 'active' : '';
                    $show_cats = $item['show_cats'] == 'yes';
                    $show_options = $item['show_options'] == 'yes';
                    $show_bio = $item['show_bio'] == 'yes';
                    $cat_ids = $item['cat_ids'];
                    $current_cat_ids = $show_cats && isset($cat_ids[0]) ? $cat_ids[0] : $item['cat_ids'];
                    $chars_num = isset($item['bio_chars_count']) && intval($item['bio_chars_count']) ? $item['bio_chars_count'] : false;
                    $options_title = $show_options ? $item['item_options_box_title'] : '';
                    $bio_title = $show_options ? $item['item_bio_box_title'] : '';
                    ?>
                    <div class="team-tab-content-wrap elementor-repeater-item-<?php echo $item['_id'] . ' ' . $activeCls; ?>" id="tab-content-<?php echo $item['_id'] ?>" style="display:<?php echo $firstWrap ? 'block' : 'none' ?>">
                        <div class="team-sub-tabs">
                            <ul>
                                <?php
                                if($show_cats && $cat_ids):
                                    $n = 0;
                                    foreach ($cat_ids as $cat):
                                        if($term = get_term($cat)):
                                            $firstTab = ($n === 0);
                                            $activeTabCls = $firstTab ? 'active' : '';
                                            $data = array(
                                                'post_type' => 'team',
                                                'taxonomy' => 'team_cat',
                                                'category' => $term->term_id,
                                                'show_pagination' => $item['show_pagination'] === 'yes',
                                                'num' => $item['per_page'],
                                                'item_cover_size' => $settings['item_cover_size'],
                                                'show_cats' => $show_cats,
                                                'show_options' => $show_options,
                                                'show_bio' => $show_bio,
                                                'options_title' => $options_title,
                                                'bio_title' => $bio_title,
                                                'item' => $item,
                                            );
                                            $n++;
                                ?>
                                <li class="<?php echo $activeTabCls ?>">
                                    <a href="#" class="team-sub-tab-btn" data-item-id="<?php echo $item['_id'] ?>" data-wid="<?php echo $wid ?>" data-settings="<?php echo base64_encode(json_encode($data)) ?>">
                                        <?php echo $term->name ?>
                                    </a>
                                </li>
                                <?php 
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                        </div>
                        <div class="row team-tab-content">
                            <?php
                                $args = array('post_type' => 'team', 'posts_per_page' => $item['per_page'], 'post_status' => 'publish');

                                if ($current_cat_ids) {
                                    $args['tax_query'] = array(
                                        'tax_query' => [
                                            'relation' => 'OR',
                                            [
                                                'taxonomy' => 'team_cat',
                                                'field' => 'term_id',
                                                'terms' => $current_cat_ids,
                                            ]
                                        ]
                                    );
                                }

                                if ($item['show_pagination'] === 'yes') {
                                    $args['paged'] = $current_page;
                                }

                                $posts = new \WP_Query($args);

                                if ($posts->have_posts()):
                                    $i = 0;
                                    while ($posts->have_posts()): $posts->the_post();
                                        include get_template_directory() . '/template-parts/loop/elementor/team-members-tab-load-ajax.php';
                                        $i++;
                                    endwhile;
                                    wp_reset_query();
                                    wp_reset_postdata();
                                else: ?>
                                    <div class="col-12">
                                        <div class="mw_element_error">
                                            <?php echo esc_html__('Sorry,no team members were found for display.', 'ahura'); ?>
                                        </div>
                                    </div>
                                <?php
                                endif;
                            ?>
                        </div>
                        <?php if($item['show_pagination'] == 'yes' && $posts->found_posts): ?>
                            <div class="ahura-pagination" data-item-id="<?php echo $item['_id'] ?>" data-wid="<?php echo $wid ?>">
                                <?php ahura_custom_pagination($posts->found_posts, $item['per_page'], $current_page, null); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}