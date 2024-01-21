<?php
namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;

class img_hotspot extends \Elementor\Widget_Base
{
    
    public function __construct( $data = [], $args = null )
    {
        parent::__construct( $data, $args );
        mw_assets::register_style( 'img_hotspot_css', mw_assets::get_css( 'elementor.img_hotspot' ) );
    }

    public function get_style_depends()
    {
        return [ mw_assets::get_handle_name( 'img_hotspot_css' ) ];
    }
    
    public function get_name()
    {
        return 'img_hotspot';
    }
    
    public function get_title()
    {
        return esc_html__( 'Image hotspot', 'ahura' );
    }
    
    public function get_icon()
    {
        return 'aicon-svg-imgbox';
    }
    
    public function get_categories()
    {
        return [ 'ahuraelements' ];
    }
    
    public function get_keywords()
    {
        return [ 'Image hotspor', 'image', 'hotspot', esc_html__( 'Image hotspot', 'ahura' ) ];
    }
    
    public function register_controls()
    {
        
        $this->start_controls_section(
			'section_hotspot', [
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
		);

		$this->add_control(
			'image', [
				'label'      => __( 'Image', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::MEDIA,
				'default'    => [
					'url'    => \Elementor\Utils::get_placeholder_image_src(),
                ],
				'dynamic'    => [
                    'active' => true,
                ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(), [
				'name'      => 'media_thumbnail',
				'default'   => 'full',
				'separator' => 'none',
				'exclude'   => [
					'custom',
                ],
            ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'hot_media_type', [
				'label'       => __( 'Media Type', 'ahura' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'none'  => [
						'title' => __( 'None', 'ahura' ),
						'icon'  => 'eicon-ban',
                    ],
					'icon'  => [
						'title' => __( 'Icon', 'ahura' ),
						'icon'  => 'eicon-star-o',
                    ],
					'image' => [
						'title' => __( 'Image', 'ahura' ),
						'icon'  => 'eicon-image',
                    ],
				],
				'default'     => 'icon',
				'toggle'      => false,
			]
		);

		$repeater->add_control(
			'hot_icon', [
				'show_label'  => false,
				'type'        => \Elementor\Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => [
					'value'   => 'fas fa-plus',
					'library' => 'fa-solid',
                ],
				'condition'   => [
					'hot_media_type' => 'icon',
                ],
			]
		);

		$repeater->add_control(
			'spots_image', [
				'label'     => __( 'Image', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
				'condition' => [
					'hot_media_type' => 'image',
                ],
				'dynamic'   => [
					'active' => true,
                ],
            ]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(), [
				'name'      => 'spots_thumbnail',
				'default'   => 'full',
				'separator' => 'none',
				'exclude'   => [
					'custom',
                ],
				'condition' => [
					'hot_media_type' => 'image',
                ],
            ]
		);

		$repeater->add_control(
			'hot_offset_toggle', [
				'label'        => __( 'Offset', 'ahura' ),
				'type'         => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'ahura' ),
				'label_on'     => __( 'Custom', 'ahura' ),
				'return_value' => 'yes',
            ]
		);

		$repeater->start_popover();

		$repeater->add_responsive_control(
			'hot_offset_x', [
				'label'      => __( 'Offset Left', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => - 1000,
						'max' => 1000,
                    ],
					'%'  => [
						'min' => 0,
						'max' => 100,
                    ],
                ],
				'default'    => [
					'unit' => 'px',
					'size' => 50,
                ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
                ],
				'condition'  => [
					'hot_offset_toggle' => 'yes',
                ],
            ]
		);

		$repeater->add_responsive_control(
			'hot_offset_y', [
				'label'      => __( 'Offset Top', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => - 1000,
						'max' => 1000,
                    ],
					'%'  => [
						'min' => 0,
						'max' => 100,
                    ],
                ],
				'default'    => [
					'unit' => 'px',
					'size' => 50,
                ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper {{CURRENT_ITEM}}' => ' top: {{SIZE}}{{UNIT}};',
                ],
				'condition'  => [
					'hot_offset_toggle' => 'yes',
                ],
            ]
		);

		$repeater->end_popover();

		$repeater->add_control(
			'show_tooltip', [
				'label'        => __( 'Show Tooltip ', 'ahura' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'ahura' ),
				'label_off'    => __( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'separator'    => 'before',
				'default'      => 'yes',
            ]
		);

		$repeater->add_responsive_control(
			'position', [
				'label'                => __( 'Position', 'ahura' ),
				'type'                 => \Elementor\Controls_Manager::SELECT,
				'default'              => 'top',
				'tablet_default'       => 'bottom',
				'mobile_default'       => 'bottom',
				'options'              => [
					'top'    => __( 'Top', 'ahura' ),
					'right'  => __( 'Right', 'ahura' ),
					'bottom' => __( 'Bottom', 'ahura' ),
					'left'   => __( 'Left', 'ahura' ),
                ],
				'selectors_dictionary' => [
					'top'    => '--ahura-hotspot-tooltip-top:auto; --ahura-hotspot-tooltip-right:auto; --ahura-hotspot-tooltip-bottom:100%; --ahura-hotspot-tooltip-left:50%; --ahura-hotspot-tooltip-transform-x: -50%; --ahura-hotspot-tooltip-transform-y: 0; --ahura-hotspot-tooltip-margin: 0 0 10px 0;
                    --ahura-hotspot-tooltip-before-top:auto; --ahura-hotspot-tooltip-before-right:auto; --ahura-hotspot-tooltip-before-left: 50%; --ahura-hotspot-tooltip-before-bottom: -5px; --ahura-hotspot-tooltip-before-transform-x: -50%; --ahura-hotspot-tooltip-before-transform-y: 0;',
					'right'  => '--ahura-hotspot-tooltip-bottom:auto; --ahura-hotspot-tooltip-right:auto; --ahura-hotspot-tooltip-left:100%; --ahura-hotspot-tooltip-top:50%; --ahura-hotspot-tooltip-transform-y: -50%; --ahura-hotspot-tooltip-transform-x: 0; --ahura-hotspot-tooltip-margin: 0 0 0 10px;
                    --ahura-hotspot-tooltip-before-bottom:auto; --ahura-hotspot-tooltip-before-right:auto; --ahura-hotspot-tooltip-before-top: 50%; --ahura-hotspot-tooltip-before-left: -5px; --ahura-hotspot-tooltip-before-transform-y: -50%; --ahura-hotspot-tooltip-before-transform-x: 0;',
					'bottom' => '--ahura-hotspot-tooltip-bottom:auto; --ahura-hotspot-tooltip-right:auto; --ahura-hotspot-tooltip-top:100%; --ahura-hotspot-tooltip-left:50%; --ahura-hotspot-tooltip-transform-x: -50%; --ahura-hotspot-tooltip-transform-y: 0; --ahura-hotspot-tooltip-margin: 10px 0 0 0;
                    --ahura-hotspot-tooltip-before-bottom:auto; --ahura-hotspot-tooltip-before-right:auto; --ahura-hotspot-tooltip-before-left: 50%; --ahura-hotspot-tooltip-before-top: -5px; --ahura-hotspot-tooltip-before-transform-x: -50%; --ahura-hotspot-tooltip-before-transform-y: 0;',
					'left'   => '--ahura-hotspot-tooltip-bottom:auto; --ahura-hotspot-tooltip-left:auto; --ahura-hotspot-tooltip-right:100%; --ahura-hotspot-tooltip-top:50%; --ahura-hotspot-tooltip-transform-y: -50%; --ahura-hotspot-tooltip-transform-x: 0; --ahura-hotspot-tooltip-margin: 0 10px 0 0;
                    --ahura-hotspot-tooltip-before-bottom:auto; --ahura-hotspot-tooltip-before-left:auto; --ahura-hotspot-tooltip-before-top: 50%; --ahura-hotspot-tooltip-before-right: -5px; --ahura-hotspot-tooltip-before-transform-y: -50%; --ahura-hotspot-tooltip-before-transform-x: 0;',
                ],
				'selectors'            => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ahura-hotspot-tooltip-text,
                    {{WRAPPER}} {{CURRENT_ITEM}} .ahura-hotspot-tooltip-text:before' => '{{VALUE}};',
                ],
				'condition'            => [
					'show_tooltip' => 'yes',
                ],
			]
		);

		$repeater->add_control(
			'tooltip_text', [
				'label'       => __( 'Tooltip Text', 'ahura' ),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'default'     => __( 'Tooltip Content', 'ahura' ),
				'placeholder' => __( 'Type tooltip text here.', 'ahura' ),
				'condition'   => [
					'show_tooltip' => 'yes',
                ],
            ]
		);

		$repeater->add_control(
			'show_default_tooltip', [
				'label'        => __( 'Default Active Tooltip ', 'ahura' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'ahura' ),
				'label_off'    => __( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'separator'    => 'before',
            ]
		);

		$this->add_control(
			'hotspot_items', [
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'show_label'  => false,
				'separator'   => 'before',
				'render_type' => 'template',
				'default'     => [ [
                    'hot_icon'     => [
                        'value'   => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                    'tooltip_text' => __( 'Tooltip Content', 'ahura' ),
                ]],
			]
		);

		$this->end_controls_section();

		//Styling Tab
		$this->start_controls_section(
			'section_style_hot_image', [
				'label' => __( 'Image', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'alignment', [
				'label'     => __( 'Alignment', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'ahura' ),
						'icon'  => 'eicon-h-align-left',
                    ],
					'center' => [
						'title' => __( 'Center', 'ahura' ),
						'icon'  => 'eicon-h-align-center',
                    ],
					'right'  => [
						'title' => __( 'Right', 'ahura' ),
						'icon'  => 'eicon-h-align-right',
                    ],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};',
                ],
			]
		);

		$this->add_responsive_control(
			'hot_image_width_size', [
				'label'      => __( 'Width', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
                    ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
			]
		);

		$this->add_responsive_control(
			'hot_image_height_size', [
				'label'      => __( 'Height', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
                    ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
			]
		);

		$this->add_responsive_control(
			'_hot_object-fit', [
				'label'     => __( 'Object Fit', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					''        => __( 'Default', 'ahura' ),
					'fill'    => __( 'Fill', 'ahura' ),
					'cover'   => __( 'Cover', 'ahura' ),
					'contain' => __( 'Contain', 'ahura' ),
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-image > img' => 'object-fit: {{VALUE}};',
                ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(), [
				'name'     => 'hot_image_border',
				'label'    => __( 'Border', 'ahura' ),
				'selector' => '{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-image > img',
			]
		);

		$this->add_responsive_control(
			'hot_image_border_radius', [
				'label'      => __( 'Border Radius', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-image > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(), [
				'name'     => 'hot_image_shadow',
				'exclude'  => [
					'box_shadow_position',
                ],
				'selector' => '{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-image > img',
			]
		);

		$this->add_responsive_control(
			'hot_image_padding', [
				'label'      => __( 'Padding', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-image > img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
			]
		);

		$this->end_controls_section();

		/* Spot */
		$this->start_controls_section(
			'section_style_spot', [
				'label' => __( 'Spot', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'spot_font_size', [
				'label'      => __( 'Media Size', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item .ahura-hotspot-item-wrap > i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item .ahura-hotspot-item-wrap > img' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item .ahura-hotspot-item-wrap > svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'spot_width_size', [
				'label'      => __( 'Background Size', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'spot_hot' );

		$this->start_controls_tab(
			'spots_hot_normal', [
				'label' => __( 'Normal', 'ahura' ),
			]
		);

		$this->add_control(
			'spot_color', [
				'label'     => __( 'Color', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item .ahura-hotspot-item-wrap > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item .ahura-hotspot-item-wrap > svg' => 'fill: {{VALUE}};',
                ],
			]
		);

		$this->add_control(
			'spot_bg_color', [
				'label'     => __( 'Background Color', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item' => 'background-color: {{VALUE}};',
                ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'spot_hot_hover', [
				'label' => __( 'Hover', 'ahura' ),
			]
		);

		$this->add_control(
			'spot_hvr_color', [
				'label'     => __( 'Color', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item:hover .ahura-hotspot-item-wrap > i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item:hover .ahura-hotspot-item-wrap > svg' => 'fill: {{VALUE}};',
                ],
			]
		);

		$this->add_control(
			'spot_bg_hvr_color', [
				'label'     => __( 'Background Color', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'spot_hvr_border_color', [
				'label'     => __( 'Border Color', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(), [
				'name'     => 'spot_border',
				'label'    => __( 'Border', 'ahura' ),
				'selector' => '{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item',
			]
		);

		$this->add_responsive_control(
			'spot_border_radius', [
				'label'      => __( 'Border Radius', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item,
					{{WRAPPER}} .ahura-hotspot-item-wrap:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(), [
				'name'     => 'spot_image_shadow',
				'exclude'  => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .ahura-hotspot-wrapper .ahura-hotspot-item',
			]
		);

		$this->end_controls_section();

		/* Tooltip */
		$this->start_controls_section(
			'section_style_tooltip', [
				'label' => __( 'Tooltip', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tooltip_alignment', [
				'label'     => __( 'Alignment', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'ahura' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ahura' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'ahura' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-tooltip-text' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(), [
				'name'     => 'tooltip_typography',
				'label'    => __( 'Typography', 'ahura' ),
				'selector' => '{{WRAPPER}} .ahura-hotspot-tooltip-text, {{WRAPPER}} .ahura-hotspot-tooltip-text > *',
			]
		);

		$this->add_responsive_control(
			'tooltip_width_size', [
				'label'      => __( 'Width', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-tooltip-text' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tooltip_color', [
				'label'     => __( 'Text Color', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-tooltip-text, {{WRAPPER}} .ahura-hotspot-tooltip-text > *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tooltip_bg_color', [
				'label'     => __( 'Background Color', 'ahura' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura-hotspot-tooltip-text,
                    {{WRAPPER}} .ahura-hotspot-tooltip-text:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'tooltip_border_radius', [
				'label'      => __( 'Border Radius', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-tooltip-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(), [
				'name'     => 'tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .ahura-hotspot-tooltip-text',
			]
		);

		$this->add_responsive_control(
			'tooltip_padding', [
				'label'      => __( 'Padding', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-hotspot-tooltip-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();?>
        <div class="ahura-hotspot-wrapper">
            <figure class="ahura-hotspot-image">
                <?php if ( $settings['image'] ) echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'media_thumbnail', 'image' ) ); ?>
            </figure>
            <?php foreach ( $settings['hotspot_items'] as $item ) : ?>
				<span class="elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?> ahura-hotspot-item">
					<span class="ahura-hotspot-item-wrap ahura-hotspot-type-hover">
						<?php if ( 'yes' === $item['show_tooltip'] ) : ?>
						<span class="ahura-hotspot-tooltip-text <?php echo esc_attr( $item['show_default_tooltip'] === 'yes' ? 'ahura-active' : '' ); ?> ahura-hotspot-<?php echo esc_attr( $item['position'] ); ?>">
							<?php echo wp_kses_post( $item['tooltip_text'] ); ?>
						</span>
						<?php endif; ?>
						<?php if ( 'icon' === $item['hot_media_type'] ):
							\Elementor\Icons_Manager::render_icon( $item['hot_icon'], [ 'aria-hidden' => 'true' ] );
						endif;
						if ( 'image' === $item['hot_media_type'] ):
							echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $item, 'spots_thumbnail', 'spots_image' ) );
						endif; ?>
					</span>
				</span>
            <?php endforeach; ?>
		</div>
        <?php
    }
}