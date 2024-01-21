<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;

class testimonial_box6 extends \Elementor\Widget_Base
{

    // Use prepared methods
    use \ahura\app\traits\mw_elementor;

    /**
     * testimonial_box6 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        \ahura\app\mw_assets::register_style('testimonial_box6_css', \ahura\app\mw_assets::get_css('elementor.testimonial_box6'));
    }

    public function get_style_depends()
    {
        return [\ahura\app\mw_assets::get_handle_name('testimonial_box6_css')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'testimonial_box6';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Testimonial 6', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'aicon-svg-testimonial-box-6';
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
    public function get_keywords()
    {
        return ['testimonialbox6', 'testimonial_box_6', esc_html__('Testimonial Box 6', 'ahura')];
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

        $items = get_posts(['post_type' => 'testimonial', 'numberposts' => -1]);
        $options = [];
        if ($items) {
            foreach ($items as $item) {
                $options[$item->ID] = $item->post_title;
            }
        }
        $this->add_control(
            'tst_id',
            [
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label' => esc_html__('Testimonial', 'ahura'),
                'label_block' => true,
                'options' => $options,
                'default' => ($options && is_array($options)) ? key($options) : false
            ]
        );

        $this->add_control(
            'show_rate',
            [
                'label' => esc_html__('Show Rate', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'rate',
            [
                'label' => esc_html__('Rate', 'ahura'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 0.1,
                'default' => 5,
                'condition' => ['show_rate' => 'yes']
            ]
        );
        $this->end_controls_section();
        /*
         *
         *
         *
         * Start style section
         *
         */
        /**
         *
         *
         *
         *
         * Start avatar styles
         *
         */
        $this->start_controls_section(
            'box_avatar_style',
            [
                'label' => esc_html__('Avatar', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'box_avatar_size',
            [
                'label' => esc_html__('Avatar Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap .avatar img' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 65
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60
                ],
            ]
        );

        $this->add_control(
            'box_avatar_radius',
            [
                'label' => esc_html__('Avatar Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap .avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'box_avatar_shadow',
                'label' => esc_html__('Avatar Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box6-wrap .avatar img',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 17,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.13)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         *
         *
         * Start title styles
         *
         */
        $this->start_controls_section(
            'box_head_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_control(
            'box_title_padding',
            [
                'label' => esc_html__('Title Box Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap .meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 5,
                    'unit' => 'px',
                ]
            ]
        );

        $this->add_control(
            'box_stars_color',
            [
                'label' => esc_html__('Stars color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#13913f',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap .meta .rate .stars span.checked' => 'color: {{VALUE}}',
                ],
                'condition' => ['show_rate' => 'yes']
            ]
        );

        $this->add_control(
            'box_untracked_stars_color',
            [
                'label' => esc_html__('Untracked Stars color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#C8C8C8',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap .meta .rate .stars span' => 'color: {{VALUE}}',
                ],
                'condition' => ['show_rate' => 'yes']
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap .name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_subtitle_color',
            [
                'label' => esc_html__('SubTitle color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#7c7c7c',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap .site-name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box6-wrap .name',
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
                'name' => 'box_subtitle_typo',
                'label' => esc_html__('SubTitle Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box6-wrap .site-name',
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
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_content_style',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('box_content_style_tabs');
        $this->start_controls_tab(
            'box_content_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_content_bg',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f1f1f1',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .testimonial-box6 .curve:before' => 'box-shadow: 50px -50px 0 0 {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6 .content' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_content_typo',
                'selector' => '{{WRAPPER}} .testimonial-box6 .content',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ]
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'right', 'left'],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 17,
                    'right' => 17,
                    'bottom' => 0,
                    'left' => 17,
                ]
            ]
        );

        $this->add_control(
            'box_content_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 23,
                    'right' => 23,
                    'bottom' => 23,
                    'left' => 23,
                    'unit' => 'px',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'box_content_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_text_hover_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap:hover .content' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_bg_hover_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box6-wrap:hover .testimonial-box6' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .testimonial-box6-wrap:hover .curve:before' => 'box-shadow: 50px -50px 0 0 {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
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
        $tid = $settings['tst_id'];

        if (!intval($tid)) {
            return false;
        }

        $name = \ahura\app\mw_options::get_testimonial_username($tid);
        $site_name = \ahura\app\mw_options::get_testimonial_sitename($tid);
        $avatar_url = get_the_post_thumbnail_url($tid, 'thumbnail');
        $content = get_post_field('post_content', $tid);

        $star_rate = $settings['rate']; ?>
        <div class="testimonial-box6-wrap">
            <div class="ahura-testimonial testimonial-box6">
                <div class="content"><?= $content ?></div>
                <div class="curve"></div>
            </div>
            <div class="meta">
                <div class="avatar">
                    <img src="<?= $avatar_url ?>" alt="<?= $name ?>">
                </div>
                <div class="right">
                    <div class="name"><?= $name ?></div>
                    <div class="site-name"><?= $site_name ?></div>
                </div>
                <div class="left">
                    <?php if ($settings['show_rate'] === 'yes' && $star_rate): ?>
                        <div class="rate">
                            <div class="num"><?= $star_rate ?></div>
                            <div class="stars">
                                <?php
                                for ($i = 0; $i <= $star_rate; $i++) {
                                    if ($i >= 5) {
                                        break;
                                    }
                                    $checked = ($i < 5 && $i < $star_rate) ? 'checked' : '';
                                    if ($checked) {
                                        echo '<span class="fa fa-star ' . $checked . '"></span>';
                                    }
                                }
        if ($i <= 5) {
            for ($n = 1; $n <= 5 - $star_rate; $n++) {
                echo '<span class="fa fa-star"></span>';
            }
        } ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}
