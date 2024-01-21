<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class image_box extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;

    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $image_box_css = mw_assets::get_css('elementor.image_box');
        mw_assets::register_style('image_box', $image_box_css);
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('image_box')];
    }

    public function get_name()
    {
        return 'ahura_image_box';
    }
    function get_title()
    {
        return esc_html__('Picture box', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-image-box';
	}
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['picture box', 'picture', esc_html__( 'picture box' , 'ahura')];
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
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Title Here', 'ahura')
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__('Sub title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Sub title here', 'ahura')
            ]
        );

        $this->add_control(
            'use_link',
            [
                'label' => esc_html__( 'Use Link', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'ahura' ),
                'label_off' => esc_html__( 'No', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'box_link',
            [
                'label' => esc_html__( 'Link', 'ahura' ),
                'type' => \Elementor\Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
                'condition' => ['use_link' => 'yes']
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

        $this->add_responsive_control(
            'box_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_image_box' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'label' => esc_html__('Background', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_image_box',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#EADD9E'
                    ],
                    'image' => [
                            'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()]
                    ]
                ]
            ]
        );

        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura_image_box .title' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura_image_box .sub_title' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura_image_box' => 'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_image_box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura_image_box',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'typography',
            [
                'label' => esc_html__('Typography', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title typography', 'ahura'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .ahura_image_box .title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 20
                        ]
                    ]
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('sub title typography', 'ahura'),
                'name' => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .ahura_image_box .sub_title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 17
                        ]
                    ]
                ]
            ]
        );

        $alignment = array(
            'right' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'left' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ]
        );

        $this->add_control(
			'title_alignment',
			[
				'label' => __( 'Title alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
				'default' => 'center',
				'toggle' => false,
			]
		);
        $this->add_control(
			'sub_title_alignment',
			[
				'label' => __( 'Sub title alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
				'default' => 'center',
				'toggle' => false,
			]
		);
        $this->add_control(
			'title_margin',
			[
				'label' => __( 'Title margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'isLinked' => false
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_image_box .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        $this->add_control(
			'sub_title_margin',
			[
				'label' => __( 'Sub title margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'isLinked' => false
                ],
				'selectors' => [
					'{{WRAPPER}} .ahura_image_box .sub_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $title_alignment = $settings['title_alignment'];
        $sub_title_alignment = $settings['sub_title_alignment'];
        $use_link = $settings['use_link'] === 'yes';

        if ( $use_link && !empty($settings['box_link']['url']) ) {
            $this->add_link_attributes( 'box_link', $settings['box_link'] );
        }
        ?>
       <?php if ($use_link): ?>
        <a <?php echo $this->get_render_attribute_string( 'box_link' ); ?>>
            <?php endif; ?>
            <div class="ahura_image_box">
                <div class="title <?php echo $title_alignment?>"><?php echo $settings['title'];?></div>
                <div class="sub_title <?php echo $sub_title_alignment?>"><?php echo $settings['sub_title']; ?></div>
            </div>
        <?php if ($use_link): ?>
        </a>
        <?php endif; ?>
        <?php
    }
}