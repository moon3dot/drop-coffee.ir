<?php
namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class price_box_3 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_price_box_3';
    }
    function get_title()
    {
        return esc_html__('Price box 3', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-price-box-3';
	}
    function get_categories() {
		return [ 'ahuraelements', 'ahura_price_box' ];
	}
    function get_keywords()
    {
        return ['price_box_3', 'pricebox3', esc_html__( 'Price box 3' , 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $price_box_3_css = mw_assets::get_css('elementor.price_box_3');
        mw_assets::register_style('price_box_3', $price_box_3_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('price_box_3')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Monthly Subscription', 'ahura')
            ]
        );

        $this->add_control(
            'price_value',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => '170.000'
            ]
        );

        $this->add_control(
            'price_currency',
            [
                'label' => esc_html__('Currency', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Toman', 'ahura')
            ]
        );

        $this->add_control('div1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Purchase', 'ahura'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Button link', 'ahura' ),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control('div2', ['type' => Controls_Manager::DIVIDER]);

        $items_repeater = new \Elementor\Repeater();
        $items_repeater->add_control(
            'item_title',
            [
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Title Here', 'ahura'),
                'label' => esc_html__('Title', 'ahura'),
            ]
        );
        $items_repeater->add_control(
            'item_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' =>
                    [
                        '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
                    ]
            ]
        );
        $items_repeater->add_control(
            'item_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ff071b',
                'selectors' =>
                    [
                        '{{WRAPPER}} {{CURRENT_ITEM}}::before' => 'background-color: {{VALUE}}'
                    ]
            ]
        );
        $default_item = [
            [
                'item_title' => esc_html__('VIP Support', 'ahura')
            ],
            [
                'item_title' => esc_html__('All products access', 'ahura')
            ],
            [
                'item_title' => esc_html__('High speed download', 'ahura')
            ],
            [
                'item_title' => esc_html__('Some other features', 'ahura')
            ],
        ];
        $this->add_control(
            'price_items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $items_repeater->get_controls(),
                'title_field' => '{{{item_title}}}',
                'default' => $default_item
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         *  Styles
         *
         *
         */

        $this->start_controls_section(
            'price_section',
            [
                'label' => esc_html__('Price', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .price-line' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_value_typography',
                'label' => esc_html__('Price Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .price-line .value, {{WRAPPER}} .price-line .currency',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '30'
						]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ]
				]
			]
		);
        $this->add_control(
            'price_line_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_price_box_3 .price-line' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
				],
            ]
        );
        $this->add_control(
            'price_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top'],
                'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .price-line' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' =>
                [
                    'isLinked' => false,
                    'top' => '10'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'price_line_bg',
                'selector' => '{{WRAPPER}} .ahura_price_box_3 .price-line',
                'fields_options' =>
                [
                    'background' =>
                    [
                        'default' => 'gradient'
                    ],
                    'color' => 
                    [
                        'default' => '#fe248b'
                    ],
                    'color_b' =>
                    [
                        'default' => '#ff071b'
                    ],
                    'gradient_angle' =>
                    [
                        'default' =>
                        [
                            'unit' => 'deg',
                            'size' => 110
                        ]
                    ]
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'items_section',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_text_typography',
                'label' => esc_html__('Text Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .price_items ul li',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '16'
                            ]
                        ],
                    ]
            ]
        );

        $this->add_control(
            'price_items_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top'],
                'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_price_box_3 .price_items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' =>
                [
                    'isLinked' => false,
                    'top' => '110'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'label' => esc_html__('Text Color', 'ahura'),
                'selectors' =>
                [
                    '{{WRAPPER}} .btn-wrapper' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg',
                'selector' => '{{WRAPPER}} .ahura_price_box_3 .btn-wrapper',
                'fields_options' =>
                [
                    'background' =>
                    [
                        'default' => 'gradient'
                    ],
                    'color' => 
                    [
                        'default' => '#fe248b'
                    ],
                    'color_b' =>
                    [
                        'default' => '#ff071b'
                    ],
                    'gradient_angle' =>
                    [
                        'default' =>
                        [
                            'unit' => 'deg',
                            'size' => 110
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_price_box_3 .btn-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top'],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' =>
                    [
                        'isLinked' => false,
                        'top' => '20'
                    ]
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .btn-wrapper',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .btn-wrapper',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Title Color', 'ahura'),
                'default' => '#ff071b',
                'selectors' =>
                    [
                        '{{WRAPPER}} .title' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typography',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .title',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '16'
                            ]
                        ],
                        'font_weight' => [
                            'default' => 'bold'
                        ]
                    ]
            ]
        );

        $this->add_control(
            'title_alignment',
            [
                'label' => esc_html__('Title Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'ahura'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => __('Center', 'ahura'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => __('Right', 'ahura'),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .title' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .ahura_price_box_3',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#ffffff'
                            ]
                    ]
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_price_box_3' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function render_link_attrs($url_data)
	{
		$target = $url_data['is_external'] ? 'target="_blank"' : '';
		$nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
		$cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
		$data = 'href="'.$url_data['url'].'" '.$target.' '.$nofollow.' '.$cu_attr;
		echo $data;
	}
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $items = $settings['price_items'];
        ?>
        <div class="ahura_price_box_3">
            <div class="title">
                <span><?php echo $settings['title']?></span>
            </div>
            <div class="price-line">
                <span class="value"><?php echo $settings['price_value'];?></span>
                <span class="currency"><?php echo $settings['price_currency'];?></span>
            </div>
            <div class="price_items">
                <?php if($items): ?>
                    <ul>
                        <?php foreach($items as $item): ?>
                            <li class="elementor-repeater-item-<?php echo $item['_id']; ?>">
                                <span><?php echo $item['item_title'];?></span>
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif; ?>
            </div>
            <a <?php $this->render_link_attrs($settings['button_link'])?> class="btn-wrapper"><?php echo $settings['button_text'];?></a>
        </div>
        <?php
    }
}
