<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use \ahura\app\elementor\controls\Control_Jdate_Picker;

class countdown3 extends \Elementor\Widget_Base
{

    // Use prepared methods
    use \ahura\app\traits\mw_elementor;

    /**
     * countdown3 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        \ahura\app\mw_assets::register_style('countdown3_css', \ahura\app\mw_assets::get_css('elementor.countdown3'));
        \ahura\app\mw_assets::register_script('countdown_js', \ahura\app\mw_assets::get_js('countdown'));
        if(!is_rtl()){
            \ahura\app\mw_assets::register_style('countdown3_ltr_css', \ahura\app\mw_assets::get_css('elementor.ltr.countdown3_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [\ahura\app\mw_assets::get_handle_name('countdown3_css')];
        if(!is_rtl()){
            $styles[] = \ahura\app\mw_assets::get_handle_name('countdown3_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [\ahura\app\mw_assets::get_handle_name('countdown_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'countdown3';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Countdown 3', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'aicon-svg-countdown-3';
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
        return ['countdown3', 'countdown_3', esc_html__('Countdown 3', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        /**
         *
         * Start content section
         *
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Deadline for using special discounts', 'ahura')
            ]
        );

        $this->add_control(
            'use_jdate',
            [
                'label' => esc_html__('Use Jalali Date', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => is_rtl() ? 'yes' : 'no',
            ]
        );

        $this->add_control(
            'jdate',
            [
                'label' => esc_html__('Time', 'ahura'),
                'type' => Control_Jdate_Picker::JDATE_TIME,
                'default' => ahura_jdate('Y-m-d H:i', strtotime('+1 month')),
                'condition' => [
                    'use_jdate' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'date',
            [
                'label' => esc_html__('Time', 'ahura'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => gmdate('Y-m-d h:m', strtotime('+1 month') + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS )),
                'condition' => [
                    'use_jdate!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_divider_status',
            [
                'label' => esc_html__('Show Divider', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'end_text',
            [
                'label' => esc_html__('End Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 5,
                'default' => esc_html__('Finished!', 'ahura'),
                'placeholder' => esc_html__('End text...', 'ahura'),
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => esc_html__('Show Date', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'date_title',
            [
                'label' => esc_html__('Date Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Date:', 'ahura'),
                'condition' => [
                    'show_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_buttons_status',
            [
                'label' => esc_html__('Show Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('View all products', 'ahura'),
                'condition' => [
                    'box_buttons_status' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://mihanwp.com',
                'dynamic' => ['active' => true],
                'condition' => [
                    'box_buttons_status' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         *
         * Start styles
         *
         *
         */

        /**
         *
         *
         * Timer styles
         *
         *
         */
        $this->start_controls_section(
            'box_timer_style',
            [
                'label' => esc_html__('Timer', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_timer_num_typo',
                'label' => esc_html__('Number Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .countdown3 .num',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '32'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Title styles
         *
         *
         */
        $this->start_controls_section(
            'box_title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'selector' => '{{WRAPPER}} .countdown3 .title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '18'
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'box_title_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'allowed_dimensions' => ['top', 'bottom'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 14,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Date styles
         *
         *
         */
        $this->start_controls_section(
            'box_date_style',
            [
                'label' => esc_html__('Date', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_date_typo',
                'selector' => '{{WRAPPER}} .countdown3 .date',
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

        $this->add_control(
            'box_date_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'allowed_dimensions' => ['top', 'bottom'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Buttons styles
         *
         *
         */
        $this->start_controls_section(
            'box_button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('box_button_style_tabs');
        $this->start_controls_tab(
            'box_button_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#384bcb',
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .buttons a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .buttons a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_button_typo',
                'selector' => '{{WRAPPER}} .countdown3 .buttons a',
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

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .buttons a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'box_button_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .buttons a' => 'Padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                    'isLinked' => true,
                ]
            ]
        );

        $this->add_control(
            'box_button_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'allowed_dimensions' => ['top', 'bottom'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .buttons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 18,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'box_button_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .buttons a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .buttons a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .buttons a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         *
         *
         * Divider styles
         *
         *
         */

        $this->start_controls_section(
            'box_divider_style',
            [
                'label' => esc_html__('Divider', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'box_divider_status' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_divider_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF36',
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .divider' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_divider_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .divider' => 'width: {{SIZE}}{{UNIT}};',
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

        $this->add_responsive_control(
            'box_divider_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .divider' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2
                ],
            ]
        );

        $this->add_responsive_control(
            'box_divider_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3 .divider' => 'margin: {{SIZE}}{{UNIT}} 0;',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25
                ],
            ]
        );

        $this->end_controls_section();

        /**
         *
         * Box style
         *
         *
         */
        $this->start_controls_section(
            'box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('box_style_tabs');
        $this->start_controls_tab(
            'box_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $alignment = [
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-text-align-left'
            ],
            'center' => [
                'title' => __('Center', 'ahura'),
                'icon' => 'eicon-text-align-center'
            ],
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-text-align-right'
            ]
        ];

        $this->add_control(
            'box_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .countdown3' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .countdown3',
                'fields_options' => [
                    'background' => ['default' => 'gradient'],
                    'color' => ['default' => '#4132c4'],
                    'color_b' => ['default' => '#374dcc'],
                    'gradient_angle' => ['default' => [
                        'unit' => 'deg',
                        'size' => 90,
                    ]],
                ]
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .countdown3 div' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 17,
                    'right' => 17,
                    'bottom' => 17,
                    'left' => 17,
                ]
            ]
        );

        $this->add_control(
            'box_wrap_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .countdown3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_responsive_control(
            'box_min_height',
            [
                'label' => esc_html__('Min Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'devices' => ['desktop', 'tablet', 'mobile'],
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
                'desktop_default' => [
                    'size' => 270,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 200,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 180,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .countdown3' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .countdown3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .countdown3',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 17,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .37)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'box_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg_hover',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .countdown3:hover',
            ]
        );

        $this->add_control(
            'box_text_hover_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .countdown3:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .countdown3:hover div' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_wrap_hover_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .countdown3:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_hover_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .countdown3:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     *
     * Render link (a tag) atts
     *
     * @param $url_data
     */
    protected function render_link_attrs($url_data)
    {
        $target = $url_data['is_external'] ? 'target="_blank"' : '';
        $nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
        $cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
        $data = 'href="' . $url_data['url'] . '" ' . $target . ' ' . $nofollow . ' ' . $cu_attr;
        echo $data;
    }

    /**
     *
     * Render element content (html)
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        if (empty($settings['date']) && empty($settings['jdate'])) return false;

        $is_jdate = ($settings['use_jdate'] === 'yes');

        if($is_jdate){
            $jdate = ($is_jdate) ? explode(' ', $settings['jdate']) : false;
            $jdate_date = explode('-', $jdate['0']);
            $gmtime = ahura_jalali_to_gregorian((int)$jdate_date[0], (int)$jdate_date[1], (int)$jdate_date[2]);
            $gmtime = (is_array($gmtime)) ? "{$gmtime[0]}-{$gmtime[1]}-{$gmtime[2]}" : '';
        }
        ?>
        <div class="countdown3 countdown-<?= $widget_id ?>">
            <div class="counter">
                <div class="countdown-tpl countdown-tpl-<?= $widget_id ?>">
                    <div class="end-content" style="display: none"><?= $settings['end_text'] ?></div>
                </div>
            </div>
            <?php if ($settings['box_divider_status'] === 'yes'): ?>
                <div class="divider-wrap">
                    <div class="divider"></div>
                </div>
            <?php endif; ?>
            <div class="content">
                <div class="title">
                    <?= $settings['title'] ?>
                </div>
                <?php if ($settings['show_date'] === 'yes'): ?>
                    <div class="date">
                       <div class="k"><?= $settings['date_title'] ?></div>
                       <div class="v"><?= $is_jdate ? ahura_jdate('Y/m/d', strtotime($gmtime)) : date('Y/m/d', strtotime($settings['date'])) ?></div>
                    </div>
                <?php endif; ?>
                <?php if ($settings['box_buttons_status'] === 'yes' && !empty($settings['button_text'])): ?>
                    <div class="buttons">
                        <a <?php $this->render_link_attrs($settings['button_link']) ?>><?= $settings['button_text'] ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                let countdown = $('.countdown-<?= $widget_id ?>').ahuraCountdown({
                    time: '<?= $is_jdate ? $gmtime : $settings['date'] ?>',
                    labels: {
                        day: '<?= esc_html__('Day', 'ahura') ?>',
                        hour: '<?= esc_html__('Hour', 'ahura') ?>',
                        minute: '<?= esc_html__('Minute', 'ahura') ?>',
                        second: '<?= esc_html__('Seconds', 'ahura') ?>',
                    }
                });
            });
        </script>
        <?php
    }
}