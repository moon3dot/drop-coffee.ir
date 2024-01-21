<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined('ABSPATH') or die('No script kiddies please!');

class price_box_15 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_price_box_15';
    }
    function get_title()
    {
        return esc_html__('Price box 15', 'ahura');
    }
    function get_categories()
    {
        return ['ahuraelements', 'ahura_price_box'];
    }
    function get_keywords()
    {
        return ['pricebox14', 'price_box_15', esc_html__('Price box 15', 'ahura')];
    }
    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $price_box_15_css = mw_assets::get_css('elementor.price_box_15');
        mw_assets::register_style('elementor_price_box_15', $price_box_15_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_price_box_15')];
    }
    protected function register_controls()
    {
        // HEADER
        $this->start_controls_section(
            'header_content',
            [
                'label' => esc_html__('Header', 'ahura'),
            ]
        );

        // label
        // is active
        $this->add_control(
            'show_box_label',
            [
                'label' => esc_html__('Show label', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'box_label_text',
            [
                'label' => esc_html__('Label text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('Recommended', 'ahura')),
                'default' => esc_html__('Recommended', 'ahura'),
                'condition' => [
                    'show_box_label' => 'yes',
                ],
            ]
        );

        // title
        $this->add_control(
            'box_title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('Standard', 'ahura')),
                'default' => esc_html__('Standard', 'ahura'),
            ]
        );

        // title suffix
        $this->add_control(
            'box_title_suffix_text',
            [
                'label' => esc_html__('Title suffix', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html_x('3 Project & 1 Editor', 'price_box_element', 'ahura')),
                'default' => esc_html_x('3 Project & 1 Editor', 'price_box_element', 'ahura'),
            ]
        );


        // price
        $this->add_control(
            'price_value',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => is_rtl() ? '۷۹۰۰۰' : 79,
                'default' => is_rtl() ? '۷۹۰۰۰' : 79,
            ]
        );

        // currency
        $this->add_control(
            'price_currency',
            [
                'label' => esc_html__('Currency', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html_x('$', 'price_box_element', 'ahura')),
                'default' => esc_html_x('$', 'price_box_element', 'ahura'),
            ]
        );


        // price suffix
        $this->add_control(
            'price_value_suffix',
            [
                'label' => esc_html__('Price suffix', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html_x('/ Mo', 'price_box_element', 'ahura')),
                'default' => esc_html_x('/ Mo', 'price_box_element', 'ahura'),
            ]
        );

        // description
        $this->add_control(
            'box_description_text',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('For regular teams', 'ahura')),
                'default' => esc_html__('For regular teams', 'ahura'),
            ]
        );

        $this->end_controls_section();

        // ITEMS
        $this->start_controls_section(
            'items_content',
            [
                'label' => esc_html__('Items', 'ahura'),
            ]
        );
        $items = new \Elementor\Repeater();


        // item icon
        $items->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-check-circle',
                    'library' => 'solid',
                ],
            ]
        );
        // icon color
        $items->add_control(
            'item_icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#0CCE54',
            ]
        );

        // icon typography
        $items->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_icon_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes',
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );

        // items text heading
        $items->add_control(
            'items_content_item_text_heading',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        // item text
        $items->add_control(
            'item_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('Support in ticket system', 'ahura')),
                'default' => esc_html__('Support in ticket system', 'ahura'),
            ]
        );
        // text color
        $items->add_control(
            'item_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => '#282828',
            ]
        );

        // item text typography
        $items->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-value',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );


        // label
        // item label heading
        $items->add_control(
            'items_content_item_label_heading',
            [
                'label' => esc_html__('Label', 'ahura'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $items->add_control(
            'is_show_item_label',
            [
                'label' => esc_html__('Show label', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
            ]
        );

        // label text
        $items->add_control(
            'item_label_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('Addon', 'ahura')),
                'default' => esc_html__('Addon', 'ahura'),
                'condition' => [
                    'is_show_item_label' => 'yes',
                ],
            ]
        );

        // item label typography
        $items->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_label_text_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-item-label',
                'condition' => [
                    'is_show_item_label' => 'yes',
                ],
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );

        // position base point
        $items->add_control(
			'item_label_position_base_point',
			[
				'label' => esc_html__( 'Position Base', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => is_rtl() ? 'right' : 'left',
				'options' => [
					'right' => esc_html__( 'Right', 'ahura' ),
					'left'  => esc_html__( 'Left', 'ahura' ),
				],
			]
		);

        // position
        $items->add_control(
            'item_label_position',
            [
                'label' => esc_html__('Position', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'is_show_item_label' => 'yes',
                ],

                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 110,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-item-label' => '{{item_label_position_base_point.VALUE}}: {{SIZE}}{{UNIT}}',
                ],
            ]
        );


        // label text color
        $items->add_control(
            'item_label_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-item-label' => 'color: {{VALUE}};'
                ],
                'default' => '#fff',
                'condition' => [
                    'is_show_item_label' => 'yes',
                ],
            ]
        );

        // label text bg color
        $items->add_control(
            'item_label_text_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-item-label' => 'background-color: {{VALUE}};',
                ],
                'default' => '#3f5dd5',
                'condition' => [
                    'is_show_item_label' => 'yes',
                ],
            ]
        );

        // border
        $items->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_label_border',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-item-label',
                'condition' => [
                    'is_show_item_label' => 'yes',
                ],
                'fields_options' => [
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
                        'default' => '#3f5dd5',
                    ],
                ],
            ]
        );

        // item label border-radius
        $items->add_control(
            'item_label_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'is_show_item_label' => 'yes',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'item_label_text_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],

                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 40,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-item-label' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // label padding
        $items->add_responsive_control(
            'box_label_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-item-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '1',
                    'bottom' => '0',
                    'right' => '5',
                    'left' => '5',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'condition' => [
                    'is_show_item_label' => 'yes',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'item_label_text_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'item_label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );


        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'label' => esc_html__('Items', 'ahura'),
                'title_field' => '{{{item_text}}}',
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Documentation of api', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Online meeting with your team', 'ahura'),
                        'is_show_item_label' => 'yes',
                        'item_label_position' => [
                            'unit' => '%',
                            'size' => '110',
                        ],
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('24/7 supporting your site', 'ahura'),
                    ],
                    [
                        'item_icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Support in ticket system', 'ahura'),
                    ],
                ],
            ]
        );

        $this->end_controls_section();


        // BUTTON
        $this->start_controls_section(
            'button_content',
            [
                'label' => esc_html__('Button', 'ahura'),
            ]
        );

        // button text
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html__('Get started now', 'ahura')),
                'default' => esc_html__('Get started now', 'ahura'),
            ]
        );

        // button link
        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'options' => ['url', 'is_external', 'nofollow'],
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // FOOTER
        $this->start_controls_section(
            'footer_content',
            [
                'label' => esc_html__('Footer', 'ahura'),
            ]
        );

        // is active
        $this->add_control(
            'show_box_footer_text',
            [
                'label' => esc_html__('Show footer text', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // text
        $this->add_control(
            'box_footer_text',
            [
                'label' => esc_html__('Footer text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => sprintf('%s %s', esc_html__('ex.', 'ahura'), esc_html_x('Try 14 day free trial', 'price_box_element', 'ahura')),
                'default' => esc_html_x('Try 14 day free trial', 'price_box_element', 'ahura'),
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // STYLES

        // BOX
        $this->start_controls_section(
            'main_box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // box background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'main_box_background',
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#fff'
                    ],
                ],
            ]
        );
        $this->add_control(
            'after_main_box_bg_controller_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // box-shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'widget_box_shadow',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15',
                'fields_options' => [
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .06)'
                        ]
                    ]
                ]
            ]
        );
        
        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'main_box_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15',
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
                        'default' => '#f4f4f4',
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'main_box_border_radius',
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
                    'unit' => 'px',
                    'size' => 0,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'main_box_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'widget_box_shadow_box_shadow_type',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'main_box_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '30',
                    'bottom' => '30',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        $this->end_controls_section();
        
        // LABEL
        $this->start_controls_section(
            'label_style',
            [
                'label' => esc_html__('Label', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_box_label' => 'yes',
                ],
            ]
        );

        // set top position
        $this->add_control(
            'label_position_set_top_state',
            [
                'label' => esc_html__('Top position', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Active', 'ahura'),
                'label_off' => esc_html__('Inactive', 'ahura'),
                'return_value' => 'yes',
                // 'default' => 'yes',
            ]
        );
        $this->add_control(
            'label_position_top',
            [
                'label' => esc_html__('Top', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'label_position_set_top_state' => 'yes',
                ],

                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-label' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );


        // set right position
        $this->add_control(
            'label_position_set_right_state',
            [
                'label' => esc_html__('Right position', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Active', 'ahura'),
                'label_off' => esc_html__('Inactive', 'ahura'),
                'return_value' => 'yes',
                'default' => !is_rtl() ? 'yes' : '',
            ]
        );
        $this->add_control(
            'label_position_right',
            [
                'label' => esc_html__('Right', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'label_position_set_right_state' => 'yes',
                ],

                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-label' => 'right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        // set left position
        $this->add_control(
            'label_position_set_left_state',
            [
                'label' => esc_html__('Left position', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Active', 'ahura'),
                'label_off' => esc_html__('Inactive', 'ahura'),
                'return_value' => 'yes',
                'default' => is_rtl() ? 'yes' : '',
            ]
        );
        $this->add_control(
            'label_position_left',
            [
                'label' => esc_html__('Left', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'label_position_set_left_state' => 'yes',
                ],

                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-label' => 'left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'box_label_style_after_positoin_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_label_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-label',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 12,
                        ],
                    ],
                ],
            ]
        );

        // color
        $this->add_control(
            'box_label_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-label' => 'color: {{VALUE}};'
                ],
                'default' => '#000',
            ]
        );
        
        // bg
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_label_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-label',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#eaeaea'
                    ],
                ],
            ]
        );

        $this->add_control(
            'box_label_style_after_background_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // box-shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'label_box_shadow',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-label',
                'fields_options' => [
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .06)'
                        ]
                    ]
                ]
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'label_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-label',
                'fields_options' => [
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
                    ],
                ],
            ]
        );
        $this->add_control(
            'box_label_style_after_border_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // border-radius
        $this->add_control(
            'label_border_radius',
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
                    'unit' => 'px',
                    'size' => 5,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'label_box_shadow_box_shadow_type',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'box_label_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-label' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'box_label_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'label_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'label_box_shadow_box_shadow_type',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'box_label_background_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'top' => '3',
                    'bottom' => '3',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        $this->end_controls_section();

        // TITLE
        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 35,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ]
                ],
            ]
        );

        // text alignment
        $alignmentOptions = [
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
            ],
        ];
        if (!is_rtl()) {
            $alignmentOptions = array_reverse($alignmentOptions);
        }

        $this->add_control(
            'title_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // title color
        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => '#000',
            ]
        );

        // title bg-color
        $this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-title',
                'fields_options' => [
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
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'title_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'title_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'title_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        // margin
        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();
        
        // TITLE SUFFIX
        $this->start_controls_section(
            'title_suffix_style',
            [
                'label' => esc_html__('Title suffix', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_suffix_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-title-suffix',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );

        // text alignment
        $this->add_control(
            'title_suffix_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title-suffix' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // color
        $this->add_control(
            'title_suffix_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title-suffix' => 'color: {{VALUE}};'
                ],
                'default' => '#828282',
            ]
        );

        // bg-color
        $this->add_control(
            'title_suffix_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title-suffix' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'title_suffix_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-title-suffix',
                'fields_options' => [
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
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'title_suffix_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'title_suffix_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'title_suffix_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title-suffix' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'title_suffix_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title-suffix' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        // margin
        $this->add_control(
            'title_suffix_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-title-suffix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();

        

        // PRICE SECTION
        $this->start_controls_section(
            'price_section_style',
            [
                'label' => esc_html__('Price', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // text alignment
        $this->add_control(
            'price_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        // direction
        $this->add_control(
            'price_value_reverse_flex_direction',
            [
                'label' => esc_html__('Reverse price value direction', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section .ah-price' => 'flex-direction: row-reverse',
                ],
            ]
        );
        $this->add_control(
            'price_section_reverse_flex_direction',
            [
                'label' => esc_html__('Reverse price section direction', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section' => 'flex-direction: row-reverse',
                ],
            ]
        );

        // gap
        $this->add_control(
            'price_section_items_gap',
            [
                'label' => esc_html__('Price & Suffix gap', 'ahura'),
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
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'price_value_item_gap',
            [
                'label' => esc_html__('Price & Currency gap', 'ahura'),
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
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section .ah-price' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // price typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_value_typography',
                'label' => esc_html__('Price typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section .ah-price-value',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],

                ],
            ]
        );

        // currency typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_currency_value_typography',
                'label' => esc_html__('Currency typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section .ah-price-currency',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                ],
            ]
        );

        // price suffix typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_suffix_typography',
                'label' => esc_html__('Suffix typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section .ah-price-suffix',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                ],
            ]
        );

        // price text color
        $this->add_control(
            'price_value_text_color',
            [
                'label' => esc_html__('Price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section .ah-price-value' => 'color: {{VALUE}};'
                ],
                'default' => '#000',
            ]
        );

        // currency text color
        $this->add_control(
            'price_currency_value_text_color',
            [
                'label' => esc_html__('Currency color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section .ah-price-currency' => 'color: {{VALUE}};'
                ],
                'default' => '#000',
            ]
        );

        // price suffix text color
        $this->add_control(
            'price_suffix_text_color',
            [
                'label' => esc_html__('Suffix color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section .ah-price-suffix' => 'color: {{VALUE}};'
                ],
                'default' => '#000',
            ]
        );

        // bg color
        $this->add_control(
            'price_section_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'price_section_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section',
                'fields_options' => [
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
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'price_section_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'price_section_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'price_section_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        // padding
        $this->add_control(
            'price_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        // margin
        $this->add_control(
            'price_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-price-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '10',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();

        // DESCRIPTION
        $this->start_controls_section(
            'box_description_style',
            [
                'label' => esc_html__('Description', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // alignment
        $this->add_control(
            'box_description_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-description' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_description_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-description',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                    'font_weight' => [
                        'default' => 'bold',
                    ],
                ],
            ]
        );

        // text color
        $this->add_control(
            'box_description_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => '#000',
            ]
        );

        // bg-color
        $this->add_control(
            'box_description_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-description' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_description_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-description',
                'fields_options' => [
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
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'box_description_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_description_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_description_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-description' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'box_description_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        // margin
        $this->add_control(
            'box_description_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '15',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();

        // ITEMS
        $this->start_controls_section(
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // alignment
        $this->add_control(
            'items_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html_x('Start', 'price_box_element', 'ahura'),
                        'icon' => is_rtl() ? 'eicon-text-align-right' : 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ahura'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html_x('End', 'price_box_element', 'ahura'),
                        'icon' => is_rtl() ? 'eicon-text-align-left' : 'eicon-text-align-right',
                    ],
                ],
                'default' => 'start',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-items' => 'align-items: {{VALUE}}',
                ],
            ]
        );


        // direction
        $this->add_control(
            'items_item_reverse_flex_direction',
            [
                'label' => esc_html__('Reverse direction', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-items .ah-item' => 'flex-direction: row-reverse',
                ],
            ]
        );

        // gap
        $this->add_control(
            'items_item_gap',
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
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-items' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'items_section_item_icon_and_text_gap',
            [
                'label' => esc_html__('Horizontal gap', 'ahura'),
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
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-items .ah-item' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // bg color
        $this->add_control(
            'items_section_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-items' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        
        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'items_section_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-items',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => '0',
                            'right' => '0',
                            'left' => '0',
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                        'default' => '#eaeaea',
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'itesm_section_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'items_section_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'items_section_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-items' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        // padding
        $this->add_control(
            'items_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '15',
                    'bottom' => '0',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        // margin
        $this->add_control(
            'items_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '30',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();

        // BUTTON
        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // alignment
        $this->add_control(
            'button_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-button' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_section_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-button',
                'fields_options' => [
                    'width' => [
                        'label' => esc_html__('Border width', 'ahura'),
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => '0',
                            'right' => '0',
                            'left' => '0',
                        ]
                    ],
                    'color' => [
                        'label' => esc_html__('Border color', 'ahura'),
                    ],
                ],
            ]
        );

        // padding
        $this->add_control(
            'button_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        $this->start_controls_tabs(
            'button_style_tabs'
        );

        // normal mode
        $this->start_controls_tab(
            'button_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        // text color
        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a' => 'color: {{VALUE}};'
                ],
                'default' => '#fff',
            ]
        );

        // background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#158df7'
                    ],
                ],
            ]
        );
        $this->add_control(
            'button_style_normal_background_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a',
                'fields_options' => [
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
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'button_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'button_bg_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '50',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        
        // hover mode
        $this->start_controls_tab(
            'button_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        // text color
        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a:hover' => 'color: {{VALUE}};'
                ],
                'default' => '#fff',
            ]
        );

        // background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a:hover',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#2576bd'
                    ],
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a:hover',
                'fields_options' => [
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
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'button_border_radius_hover',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'button_bg_hover_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_hover_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '50',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'button_style_after_hover_tab_hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // padding
        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '20',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'button_bg_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_bg_hover_background',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'button_border_hover_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        // margin
        $this->add_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '60',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        
        $this->end_controls_section();

        // FOOTER
        $this->start_controls_section(
            'footer_style',
            [
                'label' => esc_html__('Footer', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
            ]
        );

        // footer alignment
        $this->add_control(
            'box_footer_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => $alignmentOptions,
                'default' => 'center',
                'toggle' => false,
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-footer' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_footer_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-footer',
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
            ]
        );

        // text color
        $this->add_control(
            'box_footer_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-footer' => 'color: {{VALUE}};'
                ],
                'default' => '#717171',
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
            ]
        );

        // bg-color
        $this->add_control(
            'box_footer_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-footer' => 'background-color: {{VALUE}};'
                ],
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_footer_border',
                'selector' => '{{WRAPPER}} .ahura_element_price_box_15 .ah-footer',
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
                'fields_options' => [
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
                    ],
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'box_footer_border_radius',
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
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'box_footer_bg_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'box_footer_border_border',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-footer' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // padding
        $this->add_control(
            'box_footer_section_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        // margin
        $this->add_control(
            'box_footer_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_15 .ah-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_box_footer_text' => 'yes',
                ],
                'default' => [
                    'top' => '25',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['button_link']['url'])) {
            $this->add_link_attributes('button_link', $settings['button_link']);
        }
?>
        <div class="ahura_element_price_box_15">
            <?php if($settings['show_box_label'] == 'yes'): ?>
                <div class="ah-label"><?php echo $settings['box_label_text']; ?></div>
            <?php endif; ?>
            <div class="ah-title"><?php echo $settings['box_title_text']; ?></div>
            <div class="ah-title-suffix"><?php echo $settings['box_title_suffix_text']; ?></div>
            <div class="ah-price-section">
                <div class="ah-price">
                    <div class="ah-price-value"><?php echo $settings['price_value']; ?></div>
                    <div class="ah-price-currency"><?php echo $settings['price_currency']; ?></div>
                </div>
                <div class="ah-price-suffix"><?php echo $settings['price_value_suffix']; ?></div>
            </div>
            <div class="ah-description"><?php echo $settings['box_description_text']; ?></div>
            <div class="ah-items">
                <?php foreach ($settings['items'] as $item) : ?>
                    <div class="ah-item elementor-repeater-item-<?php echo $item['_id']; ?>">
                        <span class="ah-icon">
                            <?php \Elementor\Icons_Manager::render_icon($item['item_icon']) ?>
                        </span>
                        <span class="ah-value"><?php echo $item['item_text']; ?></span>
                        <?php if ($item['is_show_item_label'] == 'yes') : ?>
                            <span class="ah-item-label"><?php echo $item['item_label_text']; ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="ah-button">
                <a <?php echo $this->get_render_attribute_string('button_link'); ?>><?php echo $settings['button_text']; ?></a>
            </div>
            <?php if($settings['show_box_footer_text'] == 'yes'): ?>
                <div class="ah-footer"><?php printf('- %s -', $settings['box_footer_text']); ?></div>
            <?php endif; ?>
        </div>
<?php
    }
}
