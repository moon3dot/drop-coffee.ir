<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined('ABSPATH') or die('No script kiddies please!');

class timeline_2 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'timeline_2';
    }
    function get_title()
    {
        return esc_html__('Timeline 2', 'ahura');
    }
    function get_categories()
    {
        return ['ahuraelements'];
    }
    function get_keywords()
    {
        return ['timeline2', 'timeline_2', esc_html__('Timeline 2', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $timeline_2_css = mw_assets::get_css('elementor.timeline_2');
        mw_assets::register_style('timeline_2', $timeline_2_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('timeline_2')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'items_content',
            [
                'label' => esc_html__('Items', 'ahura'),
            ]
        );
        $items = new \Elementor\Repeater();
        $items->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-bookmark',
                    'library' => 'solid',
                ],
            ]
        );
        // size
        $items->add_control(
            'item_icon_size',
            [
                'label' => esc_html__('Icon size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $items->add_control(
            'item_title_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Support in ticket system', 'ahura'),
                'default' => esc_html__('Support in ticket system', 'ahura'),
            ]
        );
        $items->add_control(
            'item_description_text',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__('ex. Support in ticket system', 'ahura'),
                'default' => esc_html__('Support in ticket system', 'ahura'),
            ]
        );
        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'label' => esc_html__('Items', 'ahura'),
                'title_field' => '{{{item_title_text}}}',
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'item_icon' => ['value' => 'far fa-bookmark', 'library' => 'regular'],
                        'item_title_text' => esc_html__('First step', 'ahura'),
                        'item_description_text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-bookmark', 'library' => 'solid'],
                        'item_title_text' => esc_html__('Second step', 'ahura'),
                        'item_description_text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_title_text' => esc_html__('Final step', 'ahura'),
                        'item_description_text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        // general
        $this->start_controls_section(
            'general_style',
            [
                'label' => esc_html__('General style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // box border style
        $this->add_control(
            'items_border_line_style',
            [
                'label' => esc_html__('Border Style', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'dashed',
                'options' => [
                    'none' => esc_html__('None', 'ahura'),
                    'solid'  => esc_html__('Solid', 'ahura'),
                    'dashed' => esc_html__('Dashed', 'ahura'),
                    'dotted' => esc_html__('Dotted', 'ahura'),
                    'double' => esc_html__('Double', 'ahura'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item:not(:last-of-type) .ah-dash-line' => 'border-right-style: {{VALUE}};',
                ],
            ]
        );
        // box broder color
        $this->add_control(
            'items_border_line_color',
            [
                'label' => esc_html__('Border color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item:not(:last-of-type) .ah-dash-line' => 'border-color: {{VALUE}};'
                ],
                'default' => '#284f8c',
                'condition' => [
                    'items_border_line_style!' => 'none',
                ],
            ]
        );
        // items border line width
        $this->add_control(
            'items_border_line_width',
            [
                'label' => esc_html__('Border line width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item:not(:last-of-type) .ah-dash-line' => 'border-right-width: {{SIZE}}{{UNIT}}; right: calc({{icon_box_width.SIZE}}{{icon_box_width.UNIT}} / 2 - {{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );
        // items gap
        $this->add_control(
            'items_padding',
            [
                'label' => esc_html__('Items gap', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item' => 'padding: {{SIZE}}{{UNIT}} 0;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon style', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_box_text_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#ffffff',
            ]
        );
        $this->add_control(
            'icon_box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon' => 'background-color: {{VALUE}};'
                ],
                'default' => '#284f8c',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'icon_box_border',
                'selector' => '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
            ]
        );
        $this->add_control(
            'icon_box_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
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
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon::after' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_box_width',
            [
                'label' => esc_html__('Box width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'icon_outerbox_heading',
            [
                'label' => esc_html__('Outer box', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'icon_outerbox_width',
            [
                'label' => esc_html__('Box width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 70,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_outerbox_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon::after' => 'background-color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'icon_outerbox_border',
                'selector' => '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-icon::after',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 2,
                            'bottom' => 2,
                            'right' => 2,
                            'left' => 2,
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#7687A5',
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'content_box_style',
            [
                'label' => esc_html__('Content box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // content box bg-color
        $this->add_control(
            'content_box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-content' => 'background-color: {{VALUE}}',
                ],
                'default' => 'white',
            ]
        );

        $this->add_control(
            'content_box_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-content' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'content_box_border',
                'selector' => '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-content',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
            ]
        );
        // content box padding
        $this->add_control(
            'content_box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    // 'isLinked' => false,
                ],
            ]
        );
        $this->add_control(
            'content_box_title_heading',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        // title color
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-content .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        // title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-content .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 18,
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'content_box_description_heading',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        // description color
        $this->add_control(
            'description_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-content .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => '#626262',
            ]
        );
        // description typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_timeline_2 .ah-items .ah-item .ah-content .ah-description',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );
        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="ahura_element_timeline_2">
            <div class="ah-items">
                <?php foreach ($settings['items'] as $item) : ?>
                    <div class="ah-item elementor-repeater-item-<?php echo $item['_id']; ?>">
                        <span class="ah-dash-line"></span>
                        <span class="ah-icon">
                            <?php \Elementor\Icons_Manager::render_icon($item['item_icon']) ?>
                        </span>
                        <div class="ah-content">
                            <div class="ah-title"><?php echo $item['item_title_text'] ?></div>
                            <div class="ah-description"><?php echo $item['item_description_text'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }
}
