<?php
namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class category_box extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_category_box';
    }
    function get_title()
    {
        return esc_html__('Category Box', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-category-box';
	}
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['category_box', esc_html__('Category Box', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $bannerBox5_css = mw_assets::get_css('elementor.category_box');
        mw_assets::register_style('category_box', $bannerBox5_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('category_box')];
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
                'label' => __( 'Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Products Category', 'ahura' ),
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => __( 'Description', 'ahura' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura' ),
            ]
        );

        $this->add_control(
            'show_btn',
            [
                'label' => esc_html__( 'Show Button', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'View All', 'ahura' ),
                'condition' => ['show_btn' => 'yes']
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'condition' => ['show_btn' => 'yes']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'items_section',
            [
                'label' => esc_html__('Items', 'ahura'),
            ]
        );

        $items_repeater = new \Elementor\Repeater();
        $items_repeater->add_control(
            'item_title',
            [
                'label' => __( 'Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Title', 'ahura' ),
            ]
        );

        $items_repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'library' => 'solid',
                    'value' => 'fas fa-rocket'
                ]
            ]
        );

        $items_repeater->add_control(
            'item_color',
            [
                'label' => __( 'Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#9397f5',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon svg' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'box-shadow: 5px 10px 10px 0 {{VALUE}}1a',
                ],
            ]
        );

        $items_repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_bg_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.item',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
            ]
        );

        $items_repeater->add_control(
            'item_link',
            [
                'label' => esc_html__( 'Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $default_item = [
            [
                'item_title' => __('T-Shirt', 'ahura'),
                'item_color' => '#9397f5',
                'item_icon' => [
                    'value' => 'fas fa-tshirt'
                ],
            ],
            [
                'item_title' => __('T-Shirt', 'ahura'),
                'item_color' => '#9397f5',
                'item_icon' => [
                    'value' => 'fas fa-tshirt'
                ],
            ],
            [
                'item_title' => __('T-Shirt', 'ahura'),
                'item_color' => '#9397f5',
                'item_icon' => [
                    'value' => 'fas fa-tshirt'
                ],
            ],
            [
                'item_title' => __('T-Shirt', 'ahura'),
                'item_color' => '#9397f5',
                'item_icon' => [
                    'value' => 'fas fa-tshirt'
                ],
            ],
        ];

        $this->add_control(
            'category_items',
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
            'tilte_section',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .info_section .title' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Title Typography', 'ahura'),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .info_section .title',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '25',
						]
					]
				]
			]
		);
        $this->end_controls_section();
        
        $this->start_controls_section(
            'description_section',
            [
                'label' => esc_html__('Description', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .info_section .description p' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Description Typography', 'ahura'),
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .info_section .description p',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						]
					]
				]
			]
		);

        $this->add_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .info_section .description p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' =>
                [
                    'isLinked' => false,
                    'top' => '25',
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

        $this->start_controls_tabs('btn_style_tabs');
        $this->start_controls_tab(
            'btn_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .info_section .button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_btn_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .info_section .button',
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
                        'max' => 80
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .info_section .button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .info_section .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' =>
                    [
                        'isLinked' => false,
                        'top' => '10',
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
                    '{{WRAPPER}} .info_section .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' =>
                    [
                        'isLinked' => false,
                        'top' => '10',
                        'bottom' => '10',
                        'right' => '25',
                        'left' => '25',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .info_section .button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .info_section .button',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'btn_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => __( 'Text Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .info_section .button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_btn_background_hover',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .info_section .button:hover',
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
            'button_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 80
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .info_section .button:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .info_section .button:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .info_section .button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        
        $this->start_controls_section(
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'items_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 80
                    ],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .items_section .icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .items_section .icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => __('Item Text Typography', 'ahura'),
				'name' => 'item_text_typography',
				'selector' => '{{WRAPPER}} .items_section .title',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						]
					]
				]
			]
		);
        $this->add_control(
            'item_padding',
            [
                'label' => esc_html__('Item Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .items_section .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' =>
                [
                    'isLinked' => true,
                    'top' => '45',
                    'right' => '45',
                    'bottom' => '45',
                    'left' => '45',
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'box_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .info_section',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#434eb5'
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
                    '{{WRAPPER}} .ahura_element_category_box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_category_box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_category_box',
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $items = $settings['category_items'];
        if (!empty($settings['button_link']['url'])) {
            $this->add_link_attributes('button_link', $settings['button_link']);
        }
        ?>
        <div class="ahura_element_category_box">
            <div class="info_section">
                <div class="title"><?php echo $settings['title'];?></div>
                <div class="description"><p><?php echo $settings['description_text']?></p></div>
                <?php if ($settings['show_btn'] === 'yes'): ?>
                <a <?php echo $this->get_render_attribute_string('button_link' ); ?> class="button"><?php echo $settings['button_text'] ?></a>
                <?php endif; ?>
            </div>
            <div class="items_section">
                <?php if($items): ?>
                    <?php
                    foreach($items as $item):
                        $item_id = !empty($item['_id']) ? $item['_id'] : uniqid();
                        if (!empty($item['item_link']['url'])) {
                            $this->add_link_attributes('item_link_' . $item_id, $item['item_link']);
                        }
                        ?>
                        <a <?php echo $this->get_render_attribute_string('item_link_' . $item_id); ?> class="item elementor-repeater-item-<?php echo $item_id ?>">
                            <div class="icon"><?php \Elementor\Icons_Manager::render_icon($item['item_icon'])?></div>
                            <div class="title"><?php echo $item['item_title']; ?></div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}