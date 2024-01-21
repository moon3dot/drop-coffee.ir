<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
class banner_box_4 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_banner_box_4';
    }
    function get_title()
    {
        return esc_html__('Banner Box 4', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-banner-box-4';
	}
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['bannerbox4', 'banner_box_4', esc_html__('Banner box 4', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $banner_box_4_css = mw_assets::get_css('elementor.banner_box_4');
        mw_assets::register_style('banner_box_4', $banner_box_4_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('banner_box_4')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
                    'value' => 'fas fa-bus'
                ]
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Bus Ticket', 'ahura'),
            ]
        );

        $this->add_control(
            'box_link',
            [
                'label' => esc_html__( 'Box link', 'ahura'),
                'type' => Controls_Manager::URL,
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
        /**
         *
         *
         * Styles
         *
         *
         */
        $this->start_controls_section(
            'content_styles',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ahura'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 40,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .data .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .data .link-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .data .icon svg' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .data .link-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' =>
                [
                    '{{WRAPPER}} .data .icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .data .icon svg' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .data .link-icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .data .link-icon svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' =>
                [
                    '{{WRAPPER}} .data .title' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .data .icon' => 'color: {{VALUE}}',
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
							'size' => '15'
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
            'color_box',
            [
                'label' => esc_html__('Color Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'color_box_bg',
                'selector' => '{{WRAPPER}} .data',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#36ab87'
                            ],
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
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .ahura_element_banner_box_4',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' =>
                            [
                                'default' => '#44D7AA'
                            ],
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_banner_box_4' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_wrap_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_banner_box_4',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_element_banner_box_4',
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if ( ! empty( $settings['box_link']['url'] ) ) {
            $this->add_link_attributes( 'box_link', $settings['box_link'] );
        }
        ?>
        <div class="ahura_element_banner_box_4">
            <a <?php echo $this->get_render_attribute_string( 'box_link' ); ?> class="data">
                <div class="icon"><?php \Elementor\Icons_Manager::render_icon($settings['icon'])?></div>
                <div class="title"><span><?php echo $settings['title'];?></span></div>
                <div class="link-icon"><i class="fas fa-chevron-circle-left"></i></div>
            </a>
        </div>
        <?php
    }
}