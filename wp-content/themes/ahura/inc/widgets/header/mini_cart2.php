<?php
// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class Ahura_Mini_Cart2 extends \Elementor\Widget_Base
{
    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('mini_cart2_css', mw_assets::get_css('elementor.mini_cart2'));
        mw_assets::register_script('mini_cart2_js', mw_assets::get_js('elementor.mini_cart2'));
        wp_localize_script(mw_assets::get_handle_name('mini_cart2_js'), 'mc2_data', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('mini_cart2_css')];
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('mini_cart2_js')];
    }

    public function get_name()
    {
        return 'ahura_mini_cart2';
    }

    public function get_title()
    {
        return esc_html__('Mini Cart 2', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-cart';
    }

    public function get_categories()
    {
        return ['ahuraheader'];
    }

    function get_keywords()
    {
        return ['mini_cart2', 'minicart2', esc_html__('Mini Cart 2', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => ['url' => get_template_directory_uri() . '/img/basket-icon.svg'],
                    'library' => 'svg',
                ],
            ]
        );

        $this->add_control(
            'hide_in_scroll',
            [
                'label' => esc_html__('Hide in scroll', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();
        /**
         *
         * Styles
         *
         */
        $this->start_controls_section(
            'btn_styles_section',
            [
                'label' => __('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('btn_styles_tabs');
        $this->start_controls_tab(
            'btn_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_responsive_control(
            'btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem','%'],
                'selectors' => [
                    '{{WRAPPER}} .mc2-button i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mc2-button svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300
                    ],
                ],
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__( 'Icon Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#282828',
                'selectors' => [
                    '{{WRAPPER}} .mc2-button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mc2-button svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mc2-button',
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mc2-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 6,
                    'right' => 6,
                    'bottom' => 6,
                    'left' => 6,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .mc2-button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .mc2-button',
            ]
        );

        $this->add_control(
            'counter_options',
            [
                'label' => esc_html__( 'Counter', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'counter_title_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .mc2-button .mc2-count' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'counter_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mc2-button .mc2-count',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ff3939'
                        ]
                    ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'btn_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'btn_color_hover',
            [
                'label' => esc_html__( 'Icon Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc2-button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mc2-button:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mc2-button:hover',
            ]
        );

        $this->add_control(
            'btn_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mc2-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .mc2-button:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .mc2-button:hover',
            ]
        );

        $this->add_control(
            'counter_options_hover',
            [
                'label' => esc_html__( 'Counter', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'counter_title_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc2-button:hover .mc2-count' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'counter_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mc2-button:hover .mc2-count',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'items_styles_section',
            [
                'label' => __('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .cart-item-content h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .cart-item-content h3',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_vars_color',
            [
                'label' => esc_html__( 'Variations Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#999',
                'selectors' => [
                    '{{WRAPPER}} .cart-item-vars dt, {{WRAPPER}} .cart-item-vars dd' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_vars_typography',
                'selector' => '{{WRAPPER}} .cart-item-vars dt, {{WRAPPER}} .cart-item-vars dd',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '300'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'price_options',
            [
                'label' => esc_html__( 'price', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'price1_color',
            [
                'label' => esc_html__( 'Price Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#282828',
                'selectors' => [
                    '{{WRAPPER}} .cart-item-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price1_typography',
                'selector' => '{{WRAPPER}} .cart-item-price',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '600'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '19',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'price2_color',
            [
                'label' => esc_html__( 'Price by Discount Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fc3838',
                'selectors' => [
                    '{{WRAPPER}} .cart-item-saved-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price2_typography',
                'selector' => '{{WRAPPER}} .cart-item-saved-price',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '400'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'btns_styles_section',
            [
                'label' => __('Buttons', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'btn1_options',
            [
                'label' => esc_html__( 'Cart', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'btn1_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#19bfd3',
                'selectors' => [
                    '{{WRAPPER}} .mc2-btns1 a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'btn1_typography',
                'selector' => '{{WRAPPER}} .mc2-btns1 a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '400'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'btn2_options',
            [
                'label' => esc_html__( 'Checkout', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'btn2_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .mc2-btns2 a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'btn2_typography',
                'selector' => '{{WRAPPER}} .mc2-btns2 a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '400'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16',
                        ]
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn2_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mc2-btns2 a',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#fc3838'
                        ]
                    ]
            ]
        );

        $this->add_control(
            'btn2_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mc2-btns2 a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles_section',
            [
                'label' => __('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $position = [
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-h-align-right'
            ],
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-h-align-left'
            ],
        ];

        $this->add_control(
            'box_position',
            [
                'label' => esc_html__('Position', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $position : array_reverse($position),
                'default' => is_rtl() ? 'left' : 'right',
                'selectors' => [
                    '{{WRAPPER}} .mc2-container' => '{{VALUE}}: 0;'
                ],
            ]
        );

        $this->add_control(
            'text_primary_color',
            [
                'label' => esc_html__( 'Primary Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#999',
                'selectors' => [
                    '{{WRAPPER}} .mc2-content' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mc2-content p' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mc2-content .mc2-counter' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mc2-content .mc2-total-prices > div:first-child' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'text_secondary_color',
            [
                'label' => esc_html__( 'Secondary Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#282828',
                'selectors' => [
                    '{{WRAPPER}} .total-cart-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mc2-content',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .mc2-content',
            ]
        );

        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mc2-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 6,
                    'right' => 6,
                    'bottom' => 6,
                    'left' => 6,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'selector' => '{{WRAPPER}} .mc2-content',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 12,
                            'spread' => 0,
                            'color' => '#00000047'
                        ]
                    ]
                ],

            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $hide_in_scroll = $settings['hide_in_scroll'] == 'yes' ? ' hide_in_scroll' : '';
        $icon = $settings['icon'];

        if(!\ahura\app\woocommerce::is_active()){
            return false;
        }

        if(is_admin()){
            wc_load_cart();
        }
        $cart = \WC()->cart;
        $total_items = $cart->get_cart_contents_count();
        ?>
        <div class="mini-cart2-element <?php echo $hide_in_scroll ?>">
            <a href="<?php echo wc_get_cart_url(); ?>" class="mc2-button">
                <?php
                if($icon['library'] === 'svg'){
                    $alt = __('Cart', 'ahura');
                    if (isset($icon['value']['id']) && !empty($icon['value']['id'])){
                        echo wp_get_attachment_image($icon['value']['id'], 'full');
                    } else {
                        echo "<img src='{$icon['value']['url']}' alt='{$alt}'>";
                    }
                } else {
                    \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
                }
                ?>
                <div class="mc2-count" style="opacity:<?php echo $total_items > 0 ? '1' : '0' ?>"><?php echo $total_items ?></div>
            </a>
            <div class="mc2-container" style="display: none">
                <?php include get_template_directory() . '/template-parts/loop/elementor/mini-cart2-load-ajax.php'; ?>
            </div>
        </div>
        <?php
    }
}
