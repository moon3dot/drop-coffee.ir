<?php
namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class information_box_4 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;

    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $information_box_4_css = mw_assets::get_css('elementor.information_box_4');
        mw_assets::register_style('information_box_4', $information_box_4_css);
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('information_box_4')];
    }

    public function get_name()
    {
        return 'ahura_information_box_4';
    }
    public function get_icon() {
		return 'aicon-svg-information-box-4';
	}
    function get_title()
    {
        return esc_html__('Information Box 4', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['informationbox4', 'information_box_4', esc_html__('Information box 4', 'ahura')];
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
                'default' => esc_html__('Title Here', 'ahura')
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Description is Here...', 'ahura')
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('More', 'ahura')
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Button link', 'ahura'),
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

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'library' => 'solid',
                    'value' => 'fas fa-eye'
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
            'title_section',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => "#ffffff",
                'selectors' =>
                [
                    '{{WRAPPER}} .title span' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'title_alignment',
            [
                'label' => __('Alignment', 'ahura'),
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
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .title span',
                'fields_options' =>
				[
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
                        'default' => 'bold'
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
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => "#ffffff",
                'selectors' =>
                [
                    '{{WRAPPER}} .description p' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'description_alignment',
            [
                'label' => __('Alignment', 'ahura'),
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
                    '{{WRAPPER}} .description p' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .description p',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '15'
						]
                    ],
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
            'box_btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
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
                    'size' => 15
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn-wrapper a i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .btn-wrapper a svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 30
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_information_box_4 .btn-wrapper a' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Color', 'ahura'),
                'default' => '#ffffff',
                'selectors' =>
                [
                    '{{WRAPPER}} .btn-wrapper a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-wrapper a svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_btn_bg',
                'selector' => '{{WRAPPER}} .btn-wrapper a',
            ]
        );
        
        $this->add_control(
            'button_alignment',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'end' => [
                        'title' => __('End', 'ahura'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => __('Center', 'ahura'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'start' => [
                        'title' => __('Start', 'ahura'),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .btn-wrapper' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .btn-wrapper a',
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
					'{{WRAPPER}} .btn-wrapper a' => 'border-radius: {{SIZE}}{{UNIT}};',
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
        $this->end_controls_section();

        $this->start_controls_section(
            'box_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_min_height',
            [
                'label' => esc_html__('Minimum Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => 160,
                        'max' => 600
                    ],
				],
				'default' => [
					'unit' => 'px',
					'size' => 160,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_information_box_4' => 'min-height: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .ahura_element_information_box_4',
                'fields_options' =>
                [
                    'background' =>
                    [
                        'default' => 'classic'
                    ],
                    'color' => 
                    [
                        'default' => '#319D7C'
                    ],
                ]
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => esc_html__('Border Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' =>
                    [
                        '{{WRAPPER}} .ahura_element_information_box_4::after' => 'border-color: {{VALUE}}',
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
                        'max' => 80
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_information_box_4' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ahura_element_information_box_4::after' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapbox_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_information_box_4',
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
        ?>
        <div class="ahura_element_information_box_4">
                <div class="title"><span><?php echo $settings['title'];?></span></div>
                <div class="description"><p><?php echo $settings['description']?></p></div>
                <div class="btn-wrapper">
                    <a <?php $this->render_link_attrs($settings['button_link'])?>>
                        <span><?php echo $settings['button_text']?></span>
                        <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </a>
                </div>            
        </div>
        <?php
    }
}