<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class breadcrumb extends \Elementor\Widget_Base
{
    /**
     * breadcrumb constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('breadcrumb_css', mw_assets::get_css('elementor.breadcrumb'));
        if(!is_rtl()){
            mw_assets::register_style('breadcrumb_ltr_css', mw_assets::get_css('elementor.ltr.breadcrumb_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('breadcrumb_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('breadcrumb_ltr_css');
        }
        return $styles;
    }

    public function get_name()
    {
        return 'breadcrumb';
    }

    public function get_title()
    {
        return esc_html__('Breadcrumb', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-progress-tracker';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['breadcrumb', 'bread_crumb', esc_html__('Breadcrumb', 'ahura')];
    }

    public function register_controls()
    {
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
            'box_items_styles',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
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
            'box_items_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#181522',
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-1, .breadcrumb-1 span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_items_link_color',
            [
                'label' => esc_html__('Link Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#181522',
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-1 a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_items_sep_color',
            [
                'label' => esc_html__('Separator Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e7ecf0',
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-1.rtl a::before' => 'border-right-color: {{VALUE}}',
                    '{{WRAPPER}} .breadcrumb-1.ltr a::before' => 'border-left-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_typography',
                'selector' => '{{WRAPPER}} .breadcrumb-1, .breadcrumb-1 span, .breadcrumb-1 a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 400],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
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
            'box_items_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-1 span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_items_link_color_hover',
            [
                'label' => esc_html__('Link Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#5222d0',
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-1 a:hover' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
        /***
         *
         *
         * Box style
         *
         *
         */
        $this->start_controls_section(
            'box_item_styles',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
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
            'box_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-1' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_bg',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .breadcrumb-1',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff']
                ]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .breadcrumb-1',
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
                    'color' => ['default' => '#e7ecf0']
                ]
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .breadcrumb-1',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 25,
                            'spread' => 0,
                            'color' => 'rgb(0 0 0 / 7%)'
                        ]
                    ]
                ],
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

        $dir = (is_rtl() || $settings['box_text_align'] == 'right') ? 'rtl' : 'ltr';
        ?>
        <div class="ahura-breadcrumb">
            <div class="breadcrumb-1 <?php echo $dir; ?>" aria-label="breadcrumbs">
                <?php ahura_breadcrumb(); ?>
            </div>
        </div>
        <?php
    }
}