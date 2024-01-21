<?php

namespace ahura\inc\widgets;

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

defined('ABSPATH') or die('no script kiddies please!');

class timeline extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('timeline_css', mw_assets::get_css('elementor.timeline'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('timeline_css')];
    }

    public function get_icon()
    {
        return 'aicon-svg-timeline';
    }

    public function get_name()
    {
        return 'timeline';
    }

    public function get_title()
    {
        return esc_html__('Timeline', 'ahura');
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['timeline', 'time_line', esc_html__('Timeline', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'timeline_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'timeline_show_title' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'timeline_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 5
            ]
        );

        $repeater->add_control(
            'timeline_show_title',
            [
                'label' => esc_html__('Show Title', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'item_timeline_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .timeline-list {{CURRENT_ITEM}} .timeline-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $repeater->add_control(
            'item_timeline_text_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .timeline-list {{CURRENT_ITEM}} .timeline-text' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'timeline_list',
            [
                'label' => esc_html__('Timeline List', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'timeline_title' => esc_html__('Intelligence Organization', 'ahura'),
                        'timeline_text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'timeline_title' => esc_html__('Basic Economics', 'ahura'),
                        'timeline_text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'timeline_title' => esc_html__('World Tourism', 'ahura'),
                        'timeline_text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                ],
                'title_field' => '{{{timeline_title}}}',
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         *
         * Items style tab
         *
         *
         */
        $this->start_controls_section(
            'timeline_items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('timeline_items_style_tabs');

        $this->start_controls_tab(
            'timeline_items_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'timeline_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0960ff',
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'timeline_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#8d8d8d',
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'timeline_text_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-text' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'timeline_marker_bg_color',
            [
                'label' => esc_html__('Marker Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0960ff',
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-marker:before' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'timeline_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .timeline-list .timeline-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
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
                'name' => 'timeline_text_typo',
                'label' => esc_html__('Content Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .timeline-list .timeline-text',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '17'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
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
            'timeline_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-text' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'timeline_item_content_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'timeline_item_content_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 35,
                    'right' => 35,
                    'bottom' => 35,
                    'left' => 35,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'timeline_item_content_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .timeline-list .timeline-text',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'timeline_items_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'timeline_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-item:hover .timeline-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'timeline_text_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0960ff',
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-item:hover .timeline-text' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'timeline_item_content_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .timeline-list .timeline-item:hover .timeline-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'timeline_item_content_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .timeline-list .timeline-item:hover .timeline-text',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 17,
                            'spread' => 0,
                            'color' => '#0960ff'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $items = $settings['timeline_list'];

        if ($items):
            ?>
            <div class="timeline-wrap">
                <div class="timeline">
                    <ul class="timeline-list">
                        <?php foreach ($items as $item): ?>
                            <li class="timeline-item elementor-repeater-item-<?php echo $item['_id']; ?> clearfix">
                                <?php if ($item['timeline_show_title'] === 'yes'): ?>
                                    <div class="timeline-info">
                                        <h3 class="timeline-title"><?php echo $item['timeline_title'] ?></h3>
                                    </div>
                                <?php endif ?>
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <div class="timeline-text"><?php echo $item['timeline_text'] ?></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php
        endif;
    }
}