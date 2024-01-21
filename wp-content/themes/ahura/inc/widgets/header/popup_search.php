<?php

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class Ahura_Popup_Search extends \Elementor\Widget_Base
{
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('popup_search_css', mw_assets::get_css('elementor.popup_search'));
        mw_assets::register_script('ajax_search', mw_assets::get_js('ajax_search'));
        wp_localize_script(mw_assets::get_handle_name('ajax_search'), 'search_data', ['au' => admin_url('admin-ajax.php')]);
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('popup_search_css')];
    }

    function get_script_depends()
    {
        return [mw_assets::get_handle_name('ajax_search')];
    }
    
    public function get_name()
    {
        return 'popupsearch';
    }

    public function get_title()
    {
        return esc_html__('Popup search', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-site-search';
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
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                'label' => esc_html__('Placeholder', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'hide_in_scroll',
            [
                'label' => esc_html__('Hide in scroll', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => false
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
         */
        $this->start_controls_section(
            'box_open_btn_style_section',
            [
                'label' => esc_html__('Open Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'open_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} #action_search' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150
                    ],
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} #action_search' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'open_button_bg_color',
            [
                'label' => esc_html__('Button Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #action_search' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'open_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} #action_search',
            ]
        );

        $this->add_control(
            'open_radius',
            [
                'label' => esc_html__('Open Button Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} #action_search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'open_border_padding',
            [
                'label' => esc_html__('Open Button Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} #action_search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_width',
            [
                'label' => esc_html__('Icon Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} #action_search' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'close_btn_style_section',
            [
                'label' => esc_html__('Close Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'close_icon_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-modal form .close' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'close_icon_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-modal form .close' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'close_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 20
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-modal form .close' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'close_button_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-modal form .close' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'close_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-modal form .close' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'close_button_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .search-modal form .close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * form field styles
         *
         *
         */
        $this->start_controls_section(
            'form_field_section',
            [
                'label' => esc_html__('Search Input', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'field_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .search-modal form' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'field_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .search-modal form input' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150
                    ],
                ],
            ]
        );

        $this->add_control(
            'field_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .search-modal form input' => 'color: {{VALUE}} !important',
                    ]
            ]
        );

        $this->add_control(
            'field_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .search-modal form input' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'field_typo',
                'selector' => '{{WRAPPER}} .search-modal form input',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .search-modal form input',
            ]
        );

        $this->add_control(
            'field_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .search-modal form input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .search-modal form input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'field_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .search-modal form input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .search-modal form input',
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
                'default' => '#fff',
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
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => 'rgba(0,0,0,0.3)'
                        ],
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $placeholder = $settings['placeholder'];
        $post_type = $settings['post_type'];
        $template = $settings['template'];

        if(empty($placeholder)){
            $placeholder = get_theme_mod('ahura_search_box_placeholder') ? get_theme_mod('ahura_search_box_placeholder') : __('Type and Hit Enter...', 'ahura');
        }
        
        if(is_admin()): ?>
        <div class="topbar header-mode-1 header-mode-2 header-mode-3 clearfix">
        <?php endif; ?>
            <div class="ahura-popup-search-btn-wrap <?php echo ($settings['hide_in_scroll']) ? 'hide_in_scroll' : '' ?>">
                <a href="#" id="action_search"><span class="fa fa-search"></span></a>
            </div>
            <div class="ahura-modal-search search-modal">
                <div class="search-modal-overlay close"></div>
                <form class="search-form" action="<?php echo home_url() ?>" data-template="<?php echo $template ?>">
                    <span class="close"><i class="fa fa-times"></i></span>
                    <?php $ajax_search_status = \ahura\app\mw_options::get_mod_is_ajax_search(); ?>
                    <input <?php echo $ajax_search_status ? 'autocomplete="off"' : ''; ?> required type="text" name="s" placeholder="<?php echo $placeholder ?>"/>
                    <?php if($post_type != 'default'): ?>
                        <input type="hidden" name="post_type" value="<?php echo $post_type ?>" class="search_post_type">
                    <?php endif; ?>
                    <?php
                    if (get_theme_mod('ahura_search_in_product')) {
                        echo '<input type="hidden" name="post_type" value="product" />';
                    }
                    ?>
                    <?php if ($ajax_search_status) : ?>
                        <div class="ajax_search_loading" id="ajax_search_loading"><span class="fa fa-spinner fa-spin"></span></div>
                        <div class="ajax_search_res" id="ajax_search_res"></div>
                    <?php endif; ?>
                </form>
            </div>
        <?php if(is_admin()): ?>
        </div>
        <?php
        endif;
    }
}
