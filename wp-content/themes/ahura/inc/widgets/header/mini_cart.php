<?php
// Block direct access to the main plugin file.

defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class Ahura_Mini_Cart extends \Elementor\Widget_Base
{
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('mini_cart_css', mw_assets::get_css('elementor.mini_cart'));
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('mini_cart_css')];
    }

    public function get_name()
    {
        return 'minicart';
    }

    public function get_title()
    {
        return __('Mini Cart', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-woo-cart';
    }

    public function get_categories()
    {
        return ['ahuraheader'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-shopping-bag',
                    'library' => 'solid'
                ]
            ]
        );

        $this->add_control(
            'hide_in_scroll',
            [
                'label' => __('Hide in scroll', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => false
            ]
        );

        $this->end_controls_section();

        $AlignmentOptions = [
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => __('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ],
        ];
        /**
         *
         *
         *
         * Styles
         *
         *
         *
         */
        $this->start_controls_section(
            'btn_style_section',
            [
                'label' => __('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem','%'],
                'selectors' => [
                    '{{WRAPPER}} .cart-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .cart-icon svg, {{WRAPPER}} .cart-icon img' => 'width: {{SIZE}}{{UNIT}};',
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
            'btn_icon_color',
            [
                'label' => __('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .cart-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cart-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .cart-icon' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .cart-icon',
            ]
        );

        $this->add_control(
            'button_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .cart-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .cart-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_alignment',
            [
                'label' => __('Icon Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $AlignmentOptions : array_reverse($AlignmentOptions),
                'default' => 'center',
                'toggle' => false,
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Checkout button style
         *
         *
         */
        $this->start_controls_section(
            'basket_ch_content_section',
            [
                'label' => __('Checkout Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bs_ch_color',
            [
                'label' => __('Checkout Button Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .mini-cart-header-right .button.checkout' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'bs_ch_bg_color',
            [
                'label' => __('Checkout Button Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .mini-cart-header-content .button.checkout' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'bs_ch_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .mini-cart-header-content .button.checkout',
            ]
        );

        $this->add_control(
            'bs_ch_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-header-content .button.checkout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_ch_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .mini-cart-header-content .button.checkout',
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Cart button style
         *
         *
         */
        $this->start_controls_section(
            'basket_cart_content_section',
            [
                'label' => __('Cart Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bs_cb_color',
            [
                'label' => __('Cart Button Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .mini-cart-header-right a.button:not(.checkout)' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'bs_cb_bg_color',
            [
                'label' => __('Cart Button Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .mini-cart-header-content a.button:not(.checkout)' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'bs_cb_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .mini-cart-header-content a.button:not(.checkout)',
            ]
        );

        $this->add_control(
            'bs_cb_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-header-content a.button:not(.checkout)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_cb_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .mini-cart-header-content a.button:not(.checkout)',
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Price styles
         *
         */
        $this->start_controls_section(
            'price_styles_section',
            [
                'label' => __('Price', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_text_alignment',
            [
                'label' => __('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $AlignmentOptions : array_reverse($AlignmentOptions),
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} p.woocommerce-mini-cart__total' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'item_price_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} p.woocommerce-mini-cart__total,{{WRAPPER}} p.woocommerce-mini-cart__total span bdi, {{WRAPPER}} p.woocommerce-mini-cart__total ins span bdi' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'item_price_typography',
                'selector' => '{{WRAPPER}} p.woocommerce-mini-cart__total,{{WRAPPER}} p.woocommerce-mini-cart__total span bdi, {{WRAPPER}} p.woocommerce-mini-cart__total ins span bdi',
            ]
        );

        $this->add_control(
            'price_spacing',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} p.woocommerce-mini-cart__total' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Basket style
         *
         *
         */
        $this->start_controls_section(
            'basket_content_section',
            [
                'label' => __('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bs_txt_color',
            [
                'label' => __('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .mini-cart-header-content' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .mini-cart-header-content span' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .mini-cart-header-content p' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .mini-cart-header-content a' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .mini-cart-header-content div' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .mini-cart-header-content em' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .woocommerce-mini-cart-item .mini_cart_item' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'bs_bg_color',
            [
                'label' => __('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .mini-cart-header-content' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .mini-cart-header-content .mini_cart_item' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'bs_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-header-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bs_img_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart-header-content .attachment-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $rl_align_options = [
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ],
        ];
        $this->add_control(
            'align',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $rl_align_options : array_reverse($rl_align_options),
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="mini-cart-element mini-cart-icon-mode-<?php echo $settings['icon_alignment']; ?> mini-cart-header-<?php echo $settings['align'] ?><?php echo ($settings['hide_in_scroll']) ? ' hide_in_scroll' : '' ?>">
            <?php \ahura\app\mini_cart::init_mini_cart($settings['icon']['value'], true); ?>
        </div>
        <?php
    }
}
