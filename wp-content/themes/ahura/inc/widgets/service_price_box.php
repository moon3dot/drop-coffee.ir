<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class service_price_box extends \Elementor\Widget_Base {
	use \ahura\app\traits\mw_elementor;
	public function get_name() {
		return 'ahoora_service_price_box';
	}

	public function get_title() {
		return __( 'Service Price Box', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-price-box-1';
	}

	public function get_categories() {
		return [ 'ahuraelements', 'ahura_price_box' ];
	}
	function get_keywords()
	{
		return ['service_price_box', 'servicepricebox', esc_html__( 'Service Price Box' , 'ahura')];
	}
	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		$service_price_box_css = mw_assets::get_css('elementor.service_price_box');
		mw_assets::register_style('service_price_box', $service_price_box_css);
		if(!is_rtl()){
			mw_assets::register_style('service_price_box_ltr', mw_assets::get_css('elementor.ltr.service_price_box_ltr'));
		}
	}
	function get_style_depends()
	{
		$styles = [mw_assets::get_handle_name('service_price_box')];
		if(!is_rtl()){
			$styles[] = mw_assets::get_handle_name('service_price_box_ltr');
		}
		return $styles;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'service_box_special_mode',
			[
				'label' => __("Special Mode", 'ahura'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __("Yes", 'ahura'),
				'label_off' => __("No", 'ahura'),
				'return_value' => '1'
			]
		);

        $this->add_control(
            'service_icon',
            [
                'type' => \Elementor\Controls_Manager::ICONS,
                'label' => __('Service Icon', 'ahura'),
                'description' => __('Choose from font library', 'ahura'),
                'skin'	=>	'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-dollar-sign',
                    'library' => 'fa-solid'
                ]
            ]
        );

		$this->add_control(
			'title',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __('Title', 'ahura'),
				'default' => __("Service Title", 'ahura'),
			]
		);

		$this->add_control(
			'sub_title',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __('Sub Title', 'ahura'),
				'default' => __("Service Sub Title", 'ahura'),
			]
		);

        $this->add_control(
            'btn_text',
            [
                'label' => __('Button Text', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __("Checkout", 'ahura')
            ]
        );

        $this->add_control(
            'url',
            [
                'type' => \Elementor\Controls_Manager::URL,
                'label' => __('Url', 'ahura'),
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#'
                ]
            ]
        );

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'item_title',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __('Item Title', 'ahura'),
				'default' => __("Know More", 'ahura')
			]
		);
		$box_default_data = [
			'item_title' => __("Item Title", 'ahura')
		];
		$this->add_control(
			'service_items_data',
			[
				'type' => \Elementor\Controls_Manager::REPEATER,
				'label' => __("Services Box", 'ahura'),
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{item_title}}}',
				'default' => [
					$box_default_data,
					$box_default_data,
					$box_default_data
				]
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
            'icon_styles',
            [
                'label' => __( 'Icon', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem','%'],
                'selectors' => [
                    '{{WRAPPER}} .icon_wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .icon_wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ],
                ],
                'default' => [
                    'size' => 2,
                    'unit' => 'rem'
                ]
            ]
        );

        $this->add_control(
            'service_icon_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __("Icon Color", 'ahura'),
                'default' => '#ffffff',
                'selectors' =>
                    [
                        '{{WRAPPER}} .icon_wrapper' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .icon_wrapper svg' => 'fill: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'icon_bg_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .icon_wrapper',
                'condition' => [
                        'service_box_special_mode' => '1'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'items_styles',
            [
                'label' => __( 'Items', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_icon_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __("Icon Color", 'ahura'),
                'default' => '#6068f2',
                'selectors' =>
                    [
                        '{{WRAPPER}} .prev-icon i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .prev-icon svg' => 'fill: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __("Text Color", 'ahura'),
                'default' => '#333',
                'selectors' =>
                    [
                        '{{WRAPPER}} .service_items span' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Text Typography', 'ahura'),
                'name' => 'item_text_typography',
                'selector' => '{{WRAPPER}} .service_items span',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '18',
                            ]
                        ],
                    ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'btn_styles',
            [
                'label' => __( 'Button', 'ahura' ),
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
            'btn_color',
            [
                'label' => __('Button text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'white',
                'selectors' => [
                    '{{WRAPPER}} .service_link_btn' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Typography', 'ahura'),
                'name' => 'btn_typography',
                'selector' => '{{WRAPPER}} .service_link_btn',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '18',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_bg_color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .service_link_btn',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#6068f2'
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
                    '{{WRAPPER}} .service_link_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .service_link_btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .service_link_btn',
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
            'btn_color_on_hover',
            [
                'label' => __('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6068f2',
                'selectors' => [
                    '{{WRAPPER}} .service_link_btn:hover' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_bg_color_on_hover',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .service_link_btn:hover',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#fff'
                        ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .service_link_btn:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .service_link_btn:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'head_styles',
            [
                'label' => __( 'Header', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'service_box_background',
                'selector' => '{{WRAPPER}} .service_colorize_box',
                'fields_options' =>
                    [
                        'background' => [
                            'default' => 'gradient'
                        ],
                        'color' => [
                            'default' => '#b67dfb'
                        ],
                        'color_b' => [
                            'default' => '#6068f2'
                        ]
                    ]
            ]
        );

        $this->add_control(
            'head_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .service_colorize_box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'head_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .service_colorize_box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'head_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .service_colorize_box',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .service_price_item .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title Typography', 'ahura'),
                'name' => 'box_title_typography',
                'selector' => '{{WRAPPER}} .service_price_item .title',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'rem',
                                'size' => '1.8',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_control(
            'box_subtitle_color',
            [
                'label' => esc_html__('Subtitle Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .service_price_item .sub_title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Subtitle Typography', 'ahura'),
                'name' => 'box_subtitle_typography',
                'selector' => '{{WRAPPER}} .service_price_item .sub_title',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '18',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'service_wrap_background',
                'selector' => '{{WRAPPER}} .service_price_item',
                'fields_options' =>
                    [
                        'background' => [
                            'default' => 'classic'
                        ],
                        'color' => [
                            'default' => '#ffffff'
                        ],
                    ],
                'condition' => [
                    'service_box_special_mode!' => '1'
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
                    '{{WRAPPER}} .service_price_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ],
                'condition' => [
                    'service_box_special_mode!' => '1'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .service_price_item',
                'condition' => [
                    'service_box_special_mode!' => '1'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .service_price_item',
                'condition' => [
                    'service_box_special_mode!' => '1'
                ]
            ]
        );

        $this->end_controls_section();
	}
	protected function render_link_attrs($url_data, $classes=false)
	{
		$class = $classes ? $classes : false;
		$target = $url_data['is_external'] ? 'target="_blank"' : '';
		$nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
		$cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
		$data = 'class="'.$class.'" href="'.$url_data['url'].'" '.$target.' '.$nofollow.' '.$cu_attr;
		echo $data;
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$type = $settings['service_box_special_mode'] ? 1 : 2;
		$this->add_inline_editing_attributes('title', 'none');
		$this->add_inline_editing_attributes('sub_title', 'none');
		$this->add_inline_editing_attributes('btn_text', 'none');
		?>
		<div class="service_price_wrapper">
			<div class="service_price_item <?php echo $type==1 ? 'service_colorize_box' : ''; ?> type-<?php echo $type;?>">
				<div class="head_section <?php echo $type==2 ? 'service_colorize_box' : '';?>">
					<div class="icon_wrapper">
						<?php \Elementor\Icons_Manager::render_icon($settings['service_icon']); ?>
					</div>
					<h3 class="title"><?php $this->render_inline_edit_data($settings['title'], 'title');?></h3>
					<span class="sub_title"><?php $this->render_inline_edit_data($settings['sub_title'], 'sub_title');?></span>
				</div>
				<ul class="service_items">
					<?php foreach($settings['service_items_data'] as $item_id => $item):
					$repeater_item_key = $this->get_repeater_setting_key('item_title', 'service_items_data', $item_id);
					$this->add_inline_editing_attributes($repeater_item_key, 'none');
						?>
						<li>
							<?php echo $type==2 ? '<span class="prev-icon"><i class="fa fa-check-square"></i></span>' : '';?>
							<span <?php echo $this->get_render_attribute_string($repeater_item_key);?>><?php echo $item['item_title']; ?></span></li>
					<?php endforeach; ?>
				</ul>
				<a <?php $this->render_link_attrs($settings['url'], 'service_link_btn')?>><?php $this->render_inline_edit_data($settings['btn_text'], 'btn_text'); ?></a>
			</div>
		</div>
		<?php
	}

}
