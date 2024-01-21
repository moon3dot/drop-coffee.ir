<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;

class information_box_8 extends \Elementor\Widget_Base
{

    // Use prepared methods
    use \ahura\app\traits\mw_elementor;

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        \ahura\app\mw_assets::register_style('information_box_8_css', \ahura\app\mw_assets::get_css('elementor.information_box_8'));
    }

    public function get_style_depends()
    {
        return [\ahura\app\mw_assets::get_handle_name('information_box_8_css')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'information_box_8';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Information Box 8', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon() {
		return 'aicon-svg-information-box-8';
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
     * Widget keywords
     *
     * @return string[]
     */
    public function get_keywords()
    {
        return ['informationbox8', 'information_box_8', __('Information Box 8', 'ahura')];
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
            'front_content_section',
            [
                'label' => esc_html__('Front Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'box_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-pen',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Crayons', 'ahura'),
            ]
        );

        $this->add_control(
            'box_des',
            [
                'label' => esc_html__('Subtitle', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Category', 'ahura'),
            ]
        );

        $this->add_control(
            'box_back_show',
            [
                'label' => esc_html__('Back Show', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Back content
         *
         *
         */
        $this->start_controls_section(
            'back_content_section',
            [
                'label' => esc_html__('Back Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'box_back_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_back_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-pen',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'box_back_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Crayons', 'ahura'),
            ]
        );

        $this->add_control('hr', ['type' => \Elementor\Controls_Manager::DIVIDER]);

        $this->add_control(
            'box_button_show',
            [
                'label' => esc_html__('Button Show', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'box_back_button_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('View All Products', 'ahura'),
                'condition' => [
                    'box_button_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_back_button_icon',
            [
                'label' => esc_html__('Button Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'skin' => 'inline',
                'default' => [
                    'value' => 'fas fa-chevron-left',
                    'library' => 'solid',
                ],
                'condition' => [
                    'box_button_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_back_button_link',
            [
                'label' => esc_html__('Button Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://mihanwp.com',
                'dynamic' => ['active' => true],
                'condition' => [
                    'box_button_show' => 'yes'
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
         *
         */
        $this->start_controls_section(
            'box_front_wrap_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '200',
                ],
                'selectors' => [
                    '{{WRAPPER}} .triangle svg' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs('box_wrap_front_style_tabs');
        $this->start_controls_tab(
            'box_wrap_front_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_front_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .information-box-8 .box-content .icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .information-box-8 .box-content .icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_front_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .information-box-8 .box-content div' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .information-box-8 .triangle svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_front_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .information-box-8 .front .title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '17'
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
                'name' => 'box_front_des_typo',
                'label' => esc_html__('Description Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .information-box-8 .front .des',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '12'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'box_front_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-8 .front .icon' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .information-box-8 .front .icon svg' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 40
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 2.3
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 2.3
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 2
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'box_content_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .information-box-8 .triangle',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'box_front_wrap_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_front_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .information-box-8:hover .box-content .icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .information-box-8:hover .box-content .icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_front_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .information-box-8:hover .box-content div' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_front_bg_color_hover',
            [
                'label' => esc_html__('Background', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#354AC4',
                'selectors' => [
                    '{{WRAPPER}} .information-box-8:hover .triangle svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        /**
         *
         *
         * Start back style
         *
         *
         */
        $this->start_controls_section(
            'box_back_wrap_style',
            [
                'label' => esc_html__('Box Back', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'box_back_show' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'box_back_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .information-box-8 .back .icon' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .information-box-8 .back .icon svg' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 40
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 2.3
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 2.3
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 2
                ],
            ]
        );

        $this->add_control(
            'box_back_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .information-box-8:hover .back .icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .information-box-8:hover .back .icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_back_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .information-box-8 .back .title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '17'
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
                'name' => 'box_back_des_typo',
                'label' => esc_html__('Description Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .information-box-8 .back .des',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '12'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ]
            ]
        );

        $this->add_control(
            'box_back_button_color',
            [
                'label' => esc_html__('Button Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .information-box-8 .back a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'box_button_show' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_back_button_typo',
                'label' => esc_html__('Button Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .information-box-8 .back a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ],
                'condition' => [
                    'box_button_show' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

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
        ?>
        <div class="information-box-8 <?php echo ($settings['box_back_show'] === 'yes') ? 'has-back' : '' ?>">
            <div class="box-content">
                <div class="info">
                    <div class="front">
                        <div class="icon">
                            <?php \Elementor\Icons_Manager::render_icon($settings['box_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                        <div class="title"><?php echo $settings['box_title'] ?></div>
                        <div class="des"><?php echo $settings['box_des'] ?></div>
                    </div>
                    <?php if ($settings['box_back_show'] === 'yes'): ?>
                        <div class="back">
                            <div class="icon">
                                <?php \Elementor\Icons_Manager::render_icon($settings['box_back_icon'], ['aria-hidden' => 'true']); ?>
                            </div>
                            <div class="title"><?php echo $settings['box_back_title'] ?></div>
                            <?php if($settings['box_button_show'] === 'yes'): ?>
                                <div class="back-button">
                                    <a <?php $this->render_link_attrs($settings['box_back_button_link']) ?>>
                                        <?php echo $settings['box_back_button_text'] ?>
                                        <?php \Elementor\Icons_Manager::render_icon($settings['box_back_button_icon'], ['aria-hidden' => 'true']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="triangle">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 926.39 873.71" style="enable-background:new 0 0 926.39 873.71;" xml:space="preserve">
                    <path d="M317.32,94.01L26.99,623.57C-33.79,734.43,46.43,869.9,172.86,869.9h580.67c126.43,0,206.65-135.47,145.87-246.33L609.06,94.01C545.92-21.17,380.47-21.17,317.32,94.01z"/>
                </svg>
            </div>
        </div>
        <?php
    }
}