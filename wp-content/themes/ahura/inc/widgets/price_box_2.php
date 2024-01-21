<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class price_box_2 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_price_box_2';
    }
    function get_title()
    {
        return esc_html__('Price box 2', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-price-box-2';
	}
    function get_categories() {
		return [ 'ahuraelements', 'ahura_price_box' ];
	}
    function get_keywords()
    {
        return ['price_box_2', 'pricebox_2', esc_html__( 'Price box 2' , 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $price_box_2_css = mw_assets::get_css('elementor.price_box_2');
        mw_assets::register_style('price_box_2', $price_box_2_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('price_box_2')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'library' => 'fa-solid',
                    'value' => 'fa fa-gem',
                ]
            ]
        );
        $this->add_control(
            'title_text',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Professional', 'ahura')
            ]
        );
        $this->add_control(
            'subtitle_text',
            [
                'label' => esc_html__('Sub title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('14 Days free trial', 'ahura')
            ]
        );
        $this->add_control(
            'price_text',
            [
                'label' => esc_html__('Price text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 1500
            ]
        );
        $this->add_control(
            'currency_text',
            [
                'label' => esc_html__('Currency Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Toman', 'ahura')
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Start 14 days trial', 'ahura')
            ]
        );
        $this->add_control(
			'button_link',
			[
				'label' => __( 'Button link', 'ahura' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://mihanwp.com/',
				'show_external' => true,
                'dynamic' => ['active' => true],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
        $this->end_controls_section();
        $this->start_controls_section(
            'items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $items_repeater = new \Elementor\Repeater();
        $items_repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'skin'	=>	'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'library' => 'solid',
                    'value' => 'fa fa-check'
                ]
            ]
        );
        $items_repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Item title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Type your text', 'ahura')
            ]
        );
        $items_repeater->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon svg' => 'fill: {{VALUE}}'
                ]
            ]
        );
        $items_repeater->add_control(
            'text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .item-title' => 'color: {{VALUE}}'
                ]
            ]
        );
        $default_item = [
            [
                'item_title' => esc_html__('14 days free trial', 'ahura')
            ],
            [
                'item_title' => esc_html__('Access to History', 'ahura')
            ],
            [
                'item_title' => esc_html__('Create 3 user in your account', 'ahura')
            ],
            [
                'item_title' => esc_html__('Support 24/7', 'ahura')
            ]
        ];
        $this->add_control(
            'box_items',
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
         * Styles
         *
         *
         */
        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem','%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 30
                ],
                'selectors' => [
                    '{{WRAPPER}} .header .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .header .icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ],
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f55e16',
                'selectors' => [
                    '{{WRAPPER}} .header .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .header .icon svg' => 'fill: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Icon background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fbe8d5',
                'selectors' => [
                    '{{WRAPPER}} .header .icon' => 'background-color: {{VALUE}}'
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'header_style',
            [
                'label' => esc_html__('Header', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'header_border_line_color',
            [
                'label' => esc_html__('Border line color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#d4d4d4',
                'selectors' => [
                    '{{WRAPPER}} .content' => 'border-color: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .header .box-data .title-section .title' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'sub_title_color',
            [
                'label' => esc_html__('Sub title color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .header .box-data .title-section .sub-title' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .header .box-data .price-section .price' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'price_currency_color',
            [
                'label' => esc_html__('Price currency color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .header .box-data .price-section .currency' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title typography', 'ahura'),
                'selector' => '{{WRAPPER}} .header .box-data .title-section .title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ]
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'label' => esc_html__('Sub title typography', 'ahura'),
                'selector' => '{{WRAPPER}} .header .box-data .title-section .sub-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ]
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__('Price typography', 'ahura'),
                'selector' => '{{WRAPPER}} .header .box-data .price-section .price',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ]
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_currency_typography',
                'label' => esc_html__('Price currency typography', 'ahura'),
                'selector' => '{{WRAPPER}} .header .box-data .price-section .currency',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ]
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50
                ],
                'selectors' => [
                    '{{WRAPPER}} .button-section a' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Button color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .button-section a' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .button-section a',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#f55e16'
                        ],
                ]
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .button-section a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .button-section a',
            ]
        );

        $this->add_control(
            'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .button-section a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 12,
                    'right' => 12,
                    'bottom' => 12,
                    'left' => 12,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .button-section a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .price_box_2',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#ffffff'
                        ],
                ]
            ]
        );

        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .price_box_2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .price_box_2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .price_box_2',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 7,
                            'blur' => 30,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.1)'
                        ]
                    ]
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
        $items = $settings['box_items'];

        ?>
        <div class="price_box_2">
            <div class="header">
                <div class="icon">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
                </div>
                <div class="box-data">
                    <div class="title-section">
                        <div class="title"><?php echo $settings['title_text']; ?></div>
                        <div class="sub-title"><?php echo $settings['subtitle_text']; ?></div>
                    </div>
                    <div class="price-section">
                        <span class="price"><?php echo $settings['price_text']; ?></span>
                        <span class="currency"><?php echo $settings['currency_text']; ?></span>
                    </div>
                </div>
            </div>
            <div class="content">
                <?php if($items): ?>
                    <ul>
                        <?php foreach($items as $item):?>
                            <li class="elementor-repeater-item-<?php echo $item['_id']; ?>">
                                <span class="icon">
                                    <?php \Elementor\Icons_Manager::render_icon($item['item_icon']);?>
                                </span>
                                <span class="item-title"><?php echo $item['item_title']?></span>
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="button-section">
                <a <?php $this->render_link_attrs($settings['button_link']);?>><?php echo $settings['button_text']; ?></a>
            </div>
        </div>
        <?php
    }
}