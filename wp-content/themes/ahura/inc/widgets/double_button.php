<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class double_button extends \Elementor\Widget_Base
{
    use \ahura\app\traits\link_utilities;

    /**
     * double_button constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('double_button_css', mw_assets::get_css('elementor.double_button'));
        if(!is_rtl()){
            mw_assets::register_style('double_button_ltr_css', mw_assets::get_css('elementor.ltr.double_button_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('double_button_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('double_button_ltr_css');
        }
        return $styles;
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'ahura_double_button';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Double Button', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-dual-button';
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
        return ['doublebutton', 'double_button', esc_html__('Double Button', 'ahura')];
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
            'btn1_options',
            [
                'label' => esc_html__('Button 1', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'btn1_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Login', 'ahura'),
            ]
        );

        $this->add_control(
            'btn1_link',
            [
                'label' => esc_html__('Button Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'btn1_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'exclude_inline_options' => ['svg'],
                'skin' => 'inline',
                'default' => [
                    'value' => 'fas fa-sign-in-alt',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'btn2_options',
            [
                'label' => esc_html__('Button 2', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'btn2_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Register', 'ahura'),
            ]
        );

        $this->add_control(
            'btn2_link',
            [
                'label' => esc_html__('Button Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'btn2_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'exclude_inline_options' => ['svg'],
                'skin' => 'inline',
                'default' => [
                    'value' => 'fas fa-user-plus',
                    'library' => 'fa-solid',
                ],
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
        $this->start_controls_section(
            'btn1_styles',
            [
                'label' => __('Button 1', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('style_tabs');
		$this->start_controls_tab(
			'style1_normal_tab',
			[
				'label' => esc_html__('Normal', 'ahura'),
			]
		);

        $this->add_control(
            'btn1_icon_size',
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
                    '{{WRAPPER}} .double-button .btn1 i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .double-button .btn1 svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'btn1_icon_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Icon Color', 'ahura'),
                'selectors' => [
                    '{{WRAPPER}} .double-button .btn1 i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .double-button .btn1 svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn1_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Color', 'ahura'),
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .double-button .btn1' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn1_bg_color',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .double-button .btn1',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#8d44ff'],
                ]
            ]
        );

        $this->end_controls_tab();
		$this->start_controls_tab(
			'style1_hover_tab',
			[
				'label' => esc_html__('Hover', 'ahura'),
			]
		);

        $this->add_control(
            'btn1_icon_color_hover',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Icon Color', 'ahura'),
                'selectors' => [
                    '{{WRAPPER}} .double-button .btn1:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .double-button .btn1:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn1_color_hover',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Color', 'ahura'),
                'selectors' => [
                    '{{WRAPPER}} .double-button .btn1:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn1_bg_color_hover',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .double-button .btn1:hover',
            ]
        );

        $this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'btn2_styles',
            [
                'label' => __('Button 2', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('style2_tabs');
		$this->start_controls_tab(
			'style2_normal_tab',
			[
				'label' => esc_html__('Normal', 'ahura'),
			]
		);

        $this->add_control(
            'btn2_icon_size',
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
                    '{{WRAPPER}} .double-button .btn2 i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .double-button .btn2 svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'btn2_icon_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Icon Color', 'ahura'),
                'selectors' => [
                    '{{WRAPPER}} .double-button .btn2 i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .double-button .btn2 svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn2_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .double-button .btn2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn2_bg_color',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .double-button .btn2',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#6e1feb'],
                ]
            ]
        );

        $this->end_controls_tab();
		$this->start_controls_tab(
			'style2_hover_tab',
			[
				'label' => esc_html__('Hover', 'ahura'),
			]
		);

        $this->add_control(
            'btn2_icon_color_hover',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Icon Color', 'ahura'),
                'selectors' => [
                    '{{WRAPPER}} .double-button .btn2:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .double-button .btn2:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn2_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .double-button .btn2:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn2_bg_color_hover',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .double-button .btn2:hover',
            ]
        );

        $this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'box_styles',
            [
                'label' => __('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'box_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .double-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_buttons_typo',
                'selector' => '{{WRAPPER}} .double-button a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'box_radius_width',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .double-button a' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .double-button .btn1' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50
                ],
            ]
        );

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

        $btn1_text = $settings['btn1_text'];
        $btn1_link = $settings['btn1_link'];
        $btn1_icon = $settings['btn1_icon'];

        $btn2_text = $settings['btn2_text'];
        $btn2_link = $settings['btn2_link'];
        $btn2_icon = $settings['btn2_icon'];
        ?>
       <div class="double-button double-button-<?php echo $wid; ?>">
            <a <?php $this->render_link_attrs($btn1_link) ?> class="btn1">
                <?php if(isset($btn1_icon['value']) && !empty($btn1_icon['value'])): ?>
                    <?php \Elementor\Icons_Manager::render_icon($btn1_icon)?>
                <?php endif; ?>
                <?php echo $btn1_text ?>
            </a>
            <a <?php $this->render_link_attrs($btn2_link) ?> class="btn2">
                <?php if(isset($btn2_icon['value']) && !empty($btn2_icon['value'])): ?>
                    <?php \Elementor\Icons_Manager::render_icon($btn2_icon)?>
                <?php endif; ?>
                <?php echo $btn2_text ?>
            </a>
       </div>
        <?php
    }
}