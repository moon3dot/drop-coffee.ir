<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;

class navbar3 extends \Elementor\Widget_Base
{
    /**
     * navbar3 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        \ahura\app\mw_assets::register_style('navbar3_css', \ahura\app\mw_assets::get_css('elementor.navbar3'));
    }

    public function get_style_depends()
    {
        return [\ahura\app\mw_assets::get_handle_name('navbar3_css')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'navbar3';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Navbar 3', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-form-vertical';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuranavbar'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['navbar3', 'navbar_3', esc_html__('Navbar 3', 'ahura')];
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
            'content_items_section',
            [
                'label' => esc_html__('Menu', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'exclude_inline_options' => ['svg'],
                'skin' => 'inline',
                'default' => [
                    'value' => 'fas fa-folder',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'https://mihanwp.com',
            ]
        );

        $repeater->add_control(
            'item_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#787878',
                'selectors' => [
                    '{{WRAPPER}} .navbar-items {{CURRENT_ITEM}} i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .navbar-items {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}}'
                ]
            ]
        );

        $repeater->add_control(
            'item_color_hover',
            [
                'label' => esc_html__('Hover Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .navbar-items {{CURRENT_ITEM}} a:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .navbar-items {{CURRENT_ITEM}} a:hover svg' => 'fill: {{VALUE}}'
                ]
            ]
        );

        $repeater->add_control(
            'item_primary',
            [
                'label' => esc_html__('Primary Item', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'menu_items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_icon' => ['value' => 'fas fa-home'],
                    ],
                    [
                        'item_icon' => ['value' => 'fas fa-list-ul'],
                    ],
                    [
                        'item_icon' => ['value' => 'fas fa-store'],
                        'item_color' => '#fff',
                        'item_primary' => 'yes'
                    ],
                    [
                        'item_icon' => ['value' => 'fas fa-play-circle'],
                    ],
                    [
                        'item_icon' => ['value' => 'fas fa-user'],
                    ],
                ],
                'title_field' => '{{{item_icon.value}}}',
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Start Styles
         *
         */
        /**
         *
         * Items style
         *
         */
        $this->start_controls_section(
            'items_style_section',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .navbar-3 .navbar-items .nav-item i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .navbar-3 .navbar-items .nav-item svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 70
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 22
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .navbar-3 .navbar-items .nav-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Primary item style
         *
         *
         */
        $this->start_controls_section(
            'item_primary_style_section',
            [
                'label' => esc_html__('Primary Item', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_pri_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#d72f36',
                'selectors' => [
                    '{{WRAPPER}} .navbar-3 .navbar-items .nav-item-primary a' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'item_pri_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .navbar-3 .navbar-items .nav-item-primary a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->add_responsive_control(
            'item_pri_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .navbar-3 .navbar-items .nav-item-primary a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'item_pri_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .navbar-3 .navbar-items .nav-item-primary a',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => '#d72f36'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Box Style
         *
         *
         */
        $this->start_controls_section(
            'box_style_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .navbar-3 .navbar-items' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .navbar-3 .navbar-items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 25,
                    'right' => 25,
                    'bottom' => 0,
                    'left' => 0,
                ]
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .navbar-3 .navbar-items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .navbar-3 .navbar-items',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => -10,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.13)'
                        ]
                    ]
                ],
            ]
        );

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
        $items = $settings['menu_items'];
        if ($items) {
            ?>
            <div class="ahura-mobile-navbar-3">
                <div class="navbar-3 navbar-<?php echo $widget_id ?>">
                    <div class="navbar-items-wrap">
                        <div class="navbar-items">
                            <?php
                            foreach ($items as $item):
                                $primary_cls = $item['item_primary'] === 'yes' ? 'nav-item-primary' : '';
                                ?>
                                <div class="nav-item <?php echo $primary_cls ?> elementor-repeater-item-<?php echo $item['_id']; ?>">
                                    <a <?php $this->render_link_attrs($item['item_link']) ?>>
                                        <?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}