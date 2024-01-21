<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class colorful_title2 extends \Elementor\Widget_Base {
    /**
     * colorful_title2 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('colorful_title2_css', mw_assets::get_css('elementor.colorful_title2'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('colorful_title2_css')];
    }

	public function get_name() {
		return 'colorful_title2';
	}

	public function get_title() {
		return __( 'Colorful Title 2', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-colorful-title';
	}

	public function get_categories() {
		return ['ahuraelements'];
	}
	function get_keywords()
	{
		return ['colorful_title2', 'colorfultitle2', esc_html__('Colorful Title 2' , 'ahura')];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'ahura'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $repeater =  new \Elementor\Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label' => esc_html__('Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'item_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#212121',
                'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.item-title' => 'color: {{VALUE}}',
				],
            ]
        );

        $repeater->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'item_title_typography',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.item-title',
			]
		);

        $this->add_control(
			'items',
			[
				'label' => esc_html__('Items', 'ahura'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_text' => esc_html__('Ahura', 'ahura'),
						'item_color' => '#862EED',
					],
					[
						'item_text' => esc_html__('Power to change everything', 'ahura'),
					],
				],
				'title_field' => '{{{item_text}}}',
			]
		);
		
		$this->end_controls_section();
        $this->start_controls_section(
			'settings_content_section',
			[
				'label' => __('Settings', 'ahura'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'text_html_tag',
            [
                'label' => esc_html__('Text Html Tag', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'div',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                    'P' => 'P',
                ],
            ]
        );

        $this->add_control(
            'show_text_separator',
            [
                'label' => esc_html__('Show Separator', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'text_separator',
            [
                'label' => esc_html__('Separator', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => is_rtl() ? '،' : ',',
                'condition' => [
                    'show_text_separator' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
        /**
         * 
         * 
         *  Styles
         * 
         */
        $this->start_controls_section(
            'dots_styles',
            [
                'label' => __('Dots', 'ahura'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dots_background',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .colorful-title-items .dot',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#F6E7FF']
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dots_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .colorful-title-items .dot',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' =>
                        [
                            'unit' => 'px',
                            'top' => 2,
                            'right' => 2,
                            'bottom' => 2,
                            'left' => 2,
                        ]
                    ],
                    'color' => ['default' => '#7E5AB1']
                ]
            ]
        );

        $this->add_control(
            'dots_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .colorful-title-items .dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
			'box_styles',
			[
				'label' => __('Box', 'ahura'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
            'box_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'desktop_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .colorful-title-items' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $alignment = [
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
        ];

        $this->add_control(
            'box_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .colorful-title-items' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'items_title_typography',
                'selector' => '{{WRAPPER}} .item-title',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '25'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '900'
                    ]
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_background',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .colorful-title-items',
                'fields_options' => [
					'background' => ['default' => 'classic'],
					'color' => ['default' => '#F6E7FF']
				]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .colorful-title-items',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ]   
                    ],
                    'color' => ['default' => '#7E5AB1']
                ]
            ]
        );

        $this->add_control(
			'box_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ahura'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .colorful-title-items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
	}
	protected function render() {
		$settings = $this->get_settings_for_display();

        $items = $settings['items'];
        $show_text_separator = $settings['show_text_separator'];
        $text_separator = $settings['text_separator'];
        $html_tag = $settings['text_html_tag'];

        if($items):
		?>
		<div class="colorful-title2">
            <div class="colorful-title-items">
                <span class="dot dot-1"></span><span class="dot dot-2"></span>
                <<?php echo $html_tag ?> class="cf-content">
                    <?php
                    $i = 0;
                    foreach($items as $item):
                        ?>
                        <span class="elementor-repeater-item-<?php echo $item['_id']; ?> item-title">
                        <?php
                        echo $item['item_text'];
                        if($show_text_separator == 'yes'){
                            if(count($items) > 1 && $i != (count($items) - 1)){
                                echo $text_separator;
                            }
                        }
                        ?>
                    </span>
                        <?php
                        $i++;
                    endforeach; ?>
                </<?php echo $html_tag ?>>
                <span class="dot dot-3"></span><span class="dot dot-4"></span>
            </div>
		</div>
		<?php
        endif;
	}
}
