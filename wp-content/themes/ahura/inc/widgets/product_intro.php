<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;
class product_intro extends \Elementor\Widget_Base
{
    use \ahura\app\traits\WoocommerceMethods;

    /**
     * shop_carousel3 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('product_intro_css', mw_assets::get_css('elementor.product_intro'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('product_intro_css')];
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('shop_carousel3_js')];
    }

    public function get_name()
    {
        return 'product_intro';
    }

    public function get_title()
    {
        return esc_html__('Product intro', 'ahura');
    }

	public function get_icon() {
		return 'eicon-product-description';
	}

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['Product intro', 'product', __('Product intro', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $options = [];

        $products = $this->get_products_array();

        if($products){
            foreach($products as $product) {
                $options[$product['ID']] = $product['post_title'];
            }
        }

        $default = ($options) ? key($options) : 0;

        $this->add_control(
            'product',
            [
                'label' => esc_html__('Product', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => $options,
                'default' => $default
            ]
        );

        $this->add_control(
			'show_price',
			[
				'label' => esc_html__( 'Show price', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'show_description',
			[
				'label' => esc_html__( 'Show description', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'show_image',
			[
				'label' => esc_html__( 'Show image', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'product_size',
                'default' => 'shop_catalog',
                'default' => 'full',
            ]
        );

        $this->add_control(
			'description_words',
			[
				'label' => esc_html__( 'Description words', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 1000,
				'step' => 1,
				'default' => 44,
			]
		);

        $this->add_control(
			'custom_description',
			[
				'label' => esc_html__( 'Show custom description', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
                'condition' => ['show_description' => 'yes']
			]
		);

        $this->add_control(
			'content_description',
			[
				'label' => esc_html__( 'Description', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'Default description', 'ahura' ),
                'condition' => ['custom_description' => 'yes']
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'product_style',
            [
                'label' => esc_html__('Product', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $content_alignment_default = 'row';
        is_rtl() ? $content_alignment_default = 'row' : $content_alignment_default = 'row-reverse';

        $this->add_control(
			'content_alignment',
			[
				'label' => esc_html__( 'Content alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'row-reverse' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'row' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => $content_alignment_default,
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .product-intro' => 'flex-direction: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'width',
			[
				'label' => esc_html__( 'Image/content Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .img-container' => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .intro-content-container' => 'width:calc(100% - {{SIZE}}%);',
				],
                'condition' => ['show_image' => 'yes']
			]
		);      

        $this->end_controls_section();

        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .img-container img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'image_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .img-container img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'image_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .img-container img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'show_image_box_shadow',
			[
				'label' => esc_html__( 'Show box shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'image_box_shadow',
			[
				'label' => esc_html__( 'Image Box shadow', 'ahura' ),
				'type' => \Elementor\Controls_Manager::BOX_SHADOW,
				'selectors' => [
					'{{SELECTOR}} .img-container img' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
				],
                'condition' => ['show_image_box_shadow' => 'yes']
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $title_alignment_default = 'right';
        is_rtl() ? $title_alignment_default = 'right' : $title_alignment_default = 'left';

        $this->add_control(
			'title_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'left' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => $title_alignment_default,
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .intro-title' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .intro-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .intro-title',
			]
		);

        $this->add_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .intro-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 15,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .intro-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'price_style',
            [
                'label' => esc_html__('Price', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $price_alignment_default = 'right';
        is_rtl() ? $price_alignment_default = 'right' : $price_alignment_default = 'left';

        $this->add_control(
			'price_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'left' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => $price_alignment_default,
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .intro-price' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Title color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .intro-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} .intro-price',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '17'
						]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ]
				]
			]
		);

        $this->add_control(
			'price_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .intro-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'price_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 20,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .intro-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'description_style',
            [
                'label' => esc_html__('Description', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $description_alignment_default = 'right';
        is_rtl() ? $description_alignment_default = 'right' : $description_alignment_default = 'left';

        $this->add_control(
			'description_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'left' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => $description_alignment_default,
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .intro-description' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Title color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .intro-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .intro-description',
			]
		);

        $this->add_control(
			'description_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .intro-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'description_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 40,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .intro-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $button_alignment_default = 'right';
        is_rtl() ? $button_alignment_default = 'right' : $button_alignment_default = 'left';

        $this->add_control(
			'button_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'left' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => $button_alignment_default,
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .add-to-cart-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'button_color',
			[
				'label' => esc_html__( 'Button color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.add-btn' => 'color: {{VALUE}}',
				],
                'default' => '#ffffff'
			]
		);

        $this->add_control(
			'button_backcolor',
			[
				'label' => esc_html__( 'Button background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.add-btn' => 'background-color: {{VALUE}}',
				],
                'default' => '#354ac4'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} a.add-btn',
			]
		);

        $this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} a.add-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'button_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} a.add-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'button_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 5,
					'right' => 5,
					'bottom' => 5,
					'left' => 5,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} a.add-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

    /**
     *
     * Render content for display
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
		if( !\ahura\app\woocommerce::is_active() ) return;
        $selected_product = $settings['product'] ? wc_get_product( $settings['product'] ) : false;
        if( !$selected_product ) return; ?>
        
        <div class="d-flex align-items-center justify-content-center product-intro product-intro-<?php echo $wid ?>">
            <?php if( $settings['show_image'] == 'yes' && $selected_product->get_image() && $settings['product_size_size'] ): ?>
                <div class="img-container">
                    <?php echo $selected_product->get_image( $settings['product_size_size'] ); ?>
                </div>
            <?php endif; ?>
            <div class="intro-content-container">
                <div class="intro-content-header">
                    <?php if ($selected_product->get_name() ): ?>
                        <h2 class="intro-title">
                            <a href="<?php echo get_permalink( $selected_product->get_id() ) ? get_permalink( $selected_product->get_id() ) : '#'; ?>"><?php echo $selected_product->get_name(); ?></a>
                        </h2>
                    <?php endif; ?>
                    <?php if( $settings['show_price'] == 'yes' && wc_price( $selected_product->get_price() ) ): ?>
                        <p class="intro-price">
                            <?php echo wc_price( $selected_product->get_price() ) ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php if( $settings['show_description'] == 'yes' ): ?>
                    <p class="intro-description">
                        <?php if( $settings['custom_description'] == 'yes' ): ?>
                            <?php echo $settings['content_description']; ?>
                        <?php else: ?>
                            <?php if( $selected_product->get_description() ): ?>
                                <?php echo wp_trim_words( $selected_product->get_description(), $settings['description_words'], '...' ); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
                <div class="add-to-cart-wrap">
                    <a href="<?php echo get_permalink( $selected_product->get_id() ) ? get_permalink( $selected_product->get_id() ) : '#'; ?>" class="add-btn" role="button"><?php echo __( 'Product page', 'ahura' ); ?></a>
                </div>
            </div>
        </div>
        <?php
    }
}