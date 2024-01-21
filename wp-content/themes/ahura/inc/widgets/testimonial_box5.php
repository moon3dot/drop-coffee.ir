<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;

class testimonial_box5 extends \Elementor\Widget_Base
{

    // Use prepared methods
    use \ahura\app\traits\mw_elementor;

    /**
     * testimonial_box5 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        \ahura\app\mw_assets::register_style('testimonial_box5_css', \ahura\app\mw_assets::get_css('elementor.testimonial_box5'));
        if (!is_rtl()) {
            \ahura\app\mw_assets::register_style('testimonial_box5_ltr_css', \ahura\app\mw_assets::get_css('elementor.ltr.testimonial_box5_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [\ahura\app\mw_assets::get_handle_name('testimonial_box5_css')];
        if (!is_rtl()) {
            $styles[] = \ahura\app\mw_assets::get_handle_name('testimonial_box5_ltr_css');
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
        return 'testimonial_box5';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Testimonial Box 5', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'aicon-svg-testimonial-box-5';
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
        return ['testimonialbox5', 'testimonial_box_5', esc_html__('Testimonial Box 5', 'ahura')];
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
                'condition' => [
                        'show_rate' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();
        /**
         *
         * #### End content section
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
                    '{{WRAPPER}} .testimonial-box5 .head .avatar img' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 74
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
                    '{{WRAPPER}} .testimonial-box5 .head .avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_avatar_shadow',
                'label' => esc_html__('Avatar Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box5 .head .avatar img',
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
                    '{{WRAPPER}} .testimonial-box5 .meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 0,
                    'right' => 10,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px'
                ]
            ]
        );

        $this->add_control(
            'box_stars_color',
            [
                'label' => esc_html__('Stars color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff9d00',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .meta .rate .stars span.checked' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_rate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_untracked_stars_color',
            [
                'label' => esc_html__('Untracked Stars color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#E0E0E0',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .meta .rate .stars span' => 'color: {{VALUE}}',
                ],
                'condition' => [
                        'show_rate' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .head .name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_subtitle_color',
            [
                'label' => esc_html__('SubTitle color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#bfbfbf',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .head .site-name' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box5 .head .name',
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
                'selector' => '{{WRAPPER}} .testimonial-box5 .head .site-name',
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

        /**
         *
         *
         * #### End title style
         *
         *
         * Start content styles
         *
         *
         */
        $this->start_controls_section(
            'box_content_style',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_content_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#979797',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .content' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_content_typo',
                'selector' => '{{WRAPPER}} .testimonial-box5 .content',
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
            'box_content_margin',
            [
                'label' => esc_html__('Content Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'allowed_dimensions' => ['top', 'bottom'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 18,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ]
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Start box style
         *
         */


        $this->start_controls_section(
            'box_wrap_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('box_wrap_style_tabs');
        $this->start_controls_tab(
            'box_wrap_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_wrap_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box5',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .testimonial-box5' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 23,
                    'right' => 23,
                    'bottom' => 23,
                    'left' => 23,
                ]
            ]
        );

        $this->add_control('hr', ['type' => \Elementor\Controls_Manager::DIVIDER,]);

        $this->add_responsive_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 15,
                        'max' => 70
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40
                ],
            ]
        );

        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff9d00',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .icon svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_icon_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box5 .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box5',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'box_wrap_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_wrap_hover_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box5:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_hover_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box5:hover',
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
        <div class="ahura-testimonial testimonial-box5">
            <div class="icon">
                <svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0" fill="none" width="24" height="24"/>
                    <g>
                        <path d="M11.192 15.757c0-.88-.23-1.618-.69-2.217-.326-.412-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.1-1.956.76-3.022.66-1.065 1.515-1.867 2.558-2.403L9.373 5c-.8.396-1.56.898-2.26 1.505-.71.607-1.34 1.305-1.9 2.094s-.98 1.68-1.25 2.69-.346 2.04-.217 3.1c.168 1.4.62 2.52 1.356 3.35.735.84 1.652 1.26 2.748 1.26.965 0 1.766-.29 2.4-.878.628-.576.94-1.365.94-2.368l.002.003zm9.124 0c0-.88-.23-1.618-.69-2.217-.326-.42-.77-.692-1.327-.817-.56-.124-1.074-.13-1.54-.022-.16-.94.09-1.95.75-3.02.66-1.06 1.514-1.86 2.557-2.4L18.49 5c-.8.396-1.555.898-2.26 1.505-.708.607-1.34 1.305-1.894 2.094-.556.79-.97 1.68-1.24 2.69-.273 1-.345 2.04-.217 3.1.165 1.4.615 2.52 1.35 3.35.732.833 1.646 1.25 2.742 1.25.967 0 1.768-.29 2.402-.876.627-.576.942-1.365.942-2.368v.01z"/>
                    </g>
                </svg>
            </div>
            <div class="head">
                <div class="avatar">
                    <img src="<?= $avatar_url ?>" alt="<?= $name ?>">
                </div>
                <div class="meta">
                    <div class="name"><?= $name ?></div>
                    <div class="site-name"><?= $site_name ?></div>
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
            <div class="content"><?= $content ?></div>
        </div>
        <?php
    }
}
