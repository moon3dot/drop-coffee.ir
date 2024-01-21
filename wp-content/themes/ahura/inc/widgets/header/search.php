<?php

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class Ahura_Search extends \Elementor\Widget_Base
{
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('search_css', mw_assets::get_css('elementor.search'));
        $js = mw_assets::get_js('ajax_search');
        mw_assets::register_script('ajax_search', $js);
        wp_localize_script(mw_assets::get_handle_name('ajax_search'), 'search_data', ['au' => admin_url('admin-ajax.php')]);
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('search_css')];
    }

    function get_script_depends()
    {
        return [mw_assets::get_handle_name('ajax_search')];
    }

    public function get_name()
    {
        return 'search';
    }

    public function get_title()
    {
        return __('Search', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-search';
    }

    public function get_categories()
    {
        return ['ahuraheader'];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => esc_html__( 'Post Type', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => array_merge(['default' => __('Default', 'ahura')], get_post_types(['public' => true])),
            ]
        );

        $this->add_control(
            'template',
            [
                'label' => esc_html__( 'Template', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [
                    1 => __('Default', 'ahura'),
                    2 => __('Template (2)', 'ahura')
                ],
                'condition' => ['post_type' => 'product']
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label'   => esc_html__('Placeholder', 'ahura'),
                'type'    => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'show_btn',
            [
                'label'   => esc_html__( 'Show Button', 'ahura' ),
                'type'    => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-search',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                        'show_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'hide_in_scroll',
            [
                'label'   => esc_html__( 'Hide in scroll', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::SWITCHER,
                'default' => false
            ]
        );

        $this->end_controls_section();
        /*
         *
         * Field styles
         *
         */
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_btn' => 'yes'
                ]
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
            'btn_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $position : array_reverse($position),
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} button' => '{{VALUE}}: 0;'
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem','%'],
                'selectors' => [
                    '{{WRAPPER}} button' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} button svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 19
                ]
            ]
        );

        $this->add_control(
            'btn_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9e9fb1',
                'selectors' =>
                    [
                        '{{WRAPPER}} button' => 'color: {{VALUE}}',
                        '{{WRAPPER}} button svg' => 'fill: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9e9fb1',
                'selectors' =>
                    [
                        '{{WRAPPER}} button' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'selector' => '{{WRAPPER}} button',
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} button',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'field_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'field_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form input' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'   => esc_html__('Background Color', 'ahura'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                [
                    '{{WRAPPER}} form input' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'color',
            [
                'label'   => esc_html__('Color', 'ahura'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                [
                    '{{WRAPPER}} form input' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} form input::placeholder' => 'color: {{VALUE}} !important',
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'color',
				'label' => esc_html__('Font size','ahura'),
				'selector' => '{{WRAPPER}} form input',
				'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '15'
						]
					]
				]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} form input',
            ]
        );

        $this->add_control(
            'field_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} form input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'field_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} form input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ahura' ),
				'selector' => '{{WRAPPER}} form input',
                'fields_options' =>
                [
                    'box_shadow_type' =>
                    [ 
                        'default' =>'yes' 
                    ],
                    'box_shadow' => [
                        'default' =>
                            [
                                'horizontal' => 0,
                                'vertical' => 7,
                                'blur' => 35,
                                'spread' => 0,
                                'color' => 'rgba(0,0,0,0.1)'
                            ]
                    ]
                ]
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'result_styles_section',
            [
                'label' => esc_html__('Search Result', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('style_tabs');
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' )
            ]
        );

        $this->add_control(
            'res_text_color',
            [
                'label'   => __( 'Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} #ajax_search_res a' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Typography', 'ahura'),
                'name' => 'res_typography',
                'selector' => '{{WRAPPER}} #ajax_search_res a',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '15',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'res_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} #ajax_search_res',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#fff'
                        ],
                ]
            ]
        );

        $this->add_control(
            'res_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} #ajax_search_res' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'res_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} #ajax_search_res',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'res_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} #ajax_search_res',
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
            'res_text_color_hover',
            [
                'label'   => __( 'Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} #ajax_search_res a:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'res_background_hover',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} #ajax_search_res a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $post_type = $settings['post_type'];
        $show_btn = $settings['show_btn'] === 'yes';
        $template = $settings['template'];

        if(is_admin()): ?>
        <div class="topbar header-mode-1 header-mode-2 header-mode-3 clearfix">
        <?php endif; ?>
        <form action="<?php bloginfo('url'); ?>" method="get" data-template="<?php echo $template ?>" class="ahura-search-form-element <?php echo $show_btn ? ' with-btn' : '' ?> search-form in_custom_header<?php echo $settings['hide_in_scroll'] ? ' hide_in_scroll' : '' ?>">
            <?php $ajax_search_status = \ahura\app\mw_options::get_mod_is_ajax_search(); ?>
            <input <?php echo $ajax_search_status ? 'autocomplete="off"' : ''; ?> required type="text" name="s" placeholder="<?php echo $settings['placeholder'] ? $settings['placeholder'] : __('Type and Hit Enter...', 'ahura'); ?>" />
            <?php if($show_btn): ?>
                <button type="submit">
                <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </button>
            <?php endif; ?>
            <?php if($post_type != 'default'): ?>
                <input type="hidden" name="post_type" value="<?php echo $post_type ?>" class="search_post_type">
            <?php endif; ?>
            <?php if ($ajax_search_status) : ?>
                <div id="ajax_search_loading"><span class="fa fa-spinner fa-spin"></span></div>
                <div id="ajax_search_res"></div>
            <?php endif; ?>
        </form>
        <?php if(is_admin()): ?>
        </div>
        <?php
        endif;
    }
}
