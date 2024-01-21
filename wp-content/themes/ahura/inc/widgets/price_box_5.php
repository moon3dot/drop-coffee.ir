<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class price_box_5 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_price_box_5';
    }
    function get_title()
    {
        return esc_html__('Price box 5', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements', 'ahura_price_box' ];
	}
    function get_keywords()
    {
        return ['pricebox5','price_box_5',esc_html__('Price box 5', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $price_box_5_css = mw_assets::get_css('elementor.price_box_5');
        mw_assets::register_style('elementor_price_box_5', $price_box_5_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_price_box_5')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'head_content',
            [
                'label' => esc_html__('Header', 'ahura'),
            ]
        );
        $this->add_control(
			'active_header_badge',
			[
				'label' => esc_html__( 'Show badge', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'ahura' ),
				'label_off' => esc_html__( 'No', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        $this->add_control(
            'badge_text',
            [
                'label' => esc_html__('Badge text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Special', 'ahura'),
                'default' => esc_html__('Special', 'ahura'),
                'condition' => [
                    'active_header_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-cloud',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Standard', 'ahura'),
                'default' => esc_html__('Standard', 'ahura'),
            ]
        );
        $this->add_control(
            'subtitle',
            [
                // THIS
                'label' => esc_html__('Subtitle', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Monthly payment', 'ahura'),
                'default' => esc_html__('Monthly payment', 'ahura'),
            ]
        );
        $this->add_control(
            'price',
            [
                'label' => esc_html__('Price', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. 95', 'price_box_element', 'ahura'),
                'default' => esc_html_x('95', 'price_box_element', 'ahura'),
            ]
        );
        $this->add_control(
            'price_currency',
            [
                'label' => esc_html__('Price currency', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html_x('ex. $', 'price_box_element', 'ahura'),
                'default' => esc_html_x('$', 'price_box_element', 'ahura'),
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'items_content',
            [
                'label' => esc_html__('Items', 'ahura'),
            ]
        );
        $items = new \Elementor\Repeater();
        $items->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-check-circle',
                    'library' => 'solid',
                ],
            ]
        );
        $items->add_control(
            'item_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Support in ticket system', 'ahura'),
                'default' => esc_html__('Support in ticket system', 'ahura'),
            ]
        );

        $items->add_control(
            'item_icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#A1E8AF',
            ]
        );
        $items->add_control(
            'item_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah-text' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );

        $items->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_icon_typography',
                'label' => esc_html__('Icon Typography', 'ahura'),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-icon',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
			]
		);
        $items->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_text_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah-text',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
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
                'title' => '{{{item_text}}}',
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Documentation of api', 'ahura'),
                    ],
                    [
                        'icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Online meeting with your team', 'ahura'),
                    ],
                    [
                        'icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('24/7 supporting your site', 'ahura'),
                    ],
                    [
                        'icon' => ['value' => 'fa fa-check-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Support in ticket system', 'ahura'),
                    ],
                    [
                        'icon' => ['value' => 'far fa-times-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Private mentor', 'ahura'),

                        'item_text_typography_typography' => 'yes',
                        'item_text_typography_text_decoration' => 'line-through',
                        'item_text_color' => '#656363',
                        'item_icon_color' => '#656363',
                    ],
                    [
                        'icon' => ['value' => 'far fa-times-circle', 'library' => 'solid'],
                        'item_text' => esc_html__('Self hosting', 'ahura'),

                        'item_text_typography_typography' => 'yes',
                        'item_text_typography_text_decoration' => 'line-through',
                        'item_text_color' => '#656363',
                        'item_icon_color' => '#656363',
                    ],

                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'button_content',
            [
                'label' => esc_html__('Button', 'ahura'),
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Choose plan', 'ahura'),
                'default' => esc_html__('Choose plan', 'ahura'),
            ]
        );
        $this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Link', 'ahura' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'options' => [ 'url', 'is_external', 'nofollow' ],
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

        $this->start_controls_section(
            'head_style',
            [
                'label' => esc_html__('Header', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'badge_text_color',
            [
                'label' => esc_html__('Badge text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5[btn-text]::after' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
                'condition' => [
                    'active_header_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'badge_bg_color',
            [
                'label' => esc_html__('Badge background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5[btn-text]::after' => 'background-color: {{VALUE}};'
                ],
                'default' => '#FFD400',
                'condition' => [
                    'active_header_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
			'icon_style_options',
			[
				'label' => esc_html__( 'Icon options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-icon svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#FFD400',
            ]
        );

        $this->add_control(
			'title_style_options',
			[
				'label' => esc_html__( 'Title options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-title-section .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Subtitle color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-title-section .ah-subtitle' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-title-section .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 20,
                        ],
                    ],
                ],
			]
		);
        

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
                'label' => esc_html__('Subtitle Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-title-section .ah-subtitle',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 14,
                        ],
                    ],
                ],
			]
		);
        $this->add_control(
			'price_style_options',
			[
				'label' => esc_html__( 'Price options', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Price color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-price .ah-value' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_control(
            'price_currency_color',
            [
                'label' => esc_html__('Currency color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-price .ah-currency' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_value_typography',
                'label' => esc_html__('Price Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-price .ah-value',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 30,
                        ],
                    ],
                ],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_currency_value_typography',
                'label' => esc_html__('Currency Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-price .ah-currency',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
			]
		);
        $this->add_control(
			'price_section_items_gap',
			[
				'label' => esc_html__( 'Gap', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-price' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'price_items_flex_direction',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Horizontal', 'ahura' ),
						'icon' => 'eicon-navigation-horizontal',
					],
					'column' => [
						'title' => esc_html__( 'Vertical', 'ahura' ),
						'icon' => 'eicon-navigation-vertical',
					],
				],
				'default' => 'row',
                'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-price' => 'flex-direction: {{VALUE}};',
				],
			]
		);
        $this->add_control(
			'price_items_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Start', 'ahura' ),
						'icon' => is_rtl() ? 'eicon-text-align-right' : 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'End', 'ahura' ),
						'icon' => is_rtl() ? 'eicon-text-align-left' : 'eicon-text-align-right',
					],
				],
				'default' => 'end',
                'toggle' => false,
                'condition' => [
                    'price_items_flex_direction' => 'column',
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_5 .ah-head .ah-price' => 'align-items: {{VALUE}};',
				],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'items_text_gap',
			[
				'label' => esc_html__( 'Gap', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_5 .ah-items-section' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'items_text_and_icon_gap',
			[
				'label' => esc_html__( 'Vertical gap', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'{{WRAPPER}} .ahura_element_price_box_5 .ah-items-section .ah-item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5 .ah-button-section a' => 'color: {{VALUE}};'
                ],
                'default' => 'white',
            ]
        );
        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_price_box_5 .ah-button-section a' => 'background-color: {{VALUE}};'
                ],
                'default' => '#731DD8',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_price_box_5 .ah-button-section a',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
			]
		);
        $this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
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
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_5 .ah-button-section a' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_price_box_5 .ah-button-section a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '10',
                    'bottom' => '10',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                ],
			]
		);

        $this->end_controls_section();
    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button_link', $settings['button_link'] );
		}
        ?>
        <div class="ahura_element_price_box_5" <?php echo $settings['active_header_badge'] ? sprintf('btn-text="%s"', $settings['badge_text']) : ''; ?>>
            <div class="ah-head">
                <div class="ah-icon">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'])?>
                </div>
                <div class="ah-title-section">
                    <div class="ah-title"><?php echo $settings['title']; ?></div>
                    <div class="ah-subtitle"><?php echo $settings['subtitle']; ?></div>
                </div>
                <div class="ah-price">
                    <span class="ah-value"><?php echo $settings['price']; ?></span>
                    <span class="ah-currency"><?php echo $settings['price_currency']; ?></span>
                </div>
            </div>
            <div class="ah-items-section">
                <?php
                foreach($settings['items'] as $item):
                ?>
                    <div class="ah-item elementor-repeater-item-<?php echo $item['_id'];?>">
                        <span class="ah-icon">
                            <?php \Elementor\Icons_Manager::render_icon($item['icon'])?>
                        </span>
                        <span class="ah-text"><?php echo $item['item_text']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="ah-button-section">
                <a <?php echo $this->get_render_attribute_string( 'button_link' ); ?>><?php echo $settings['button_text']; ?></a>
            </div>
        </div>
        <?php
    }
}