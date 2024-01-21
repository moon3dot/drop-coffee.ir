<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');


class introduction_box extends \Elementor\Widget_Base
{
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $introduction_box_css = mw_assets::get_css('elementor.introduction_box');
        mw_assets::register_style('introduction_box', $introduction_box_css);
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('introduction_box')];
    }

    public function get_name()
    {
        return 'introductionbox';
    }
  
    public function get_title()
    {
        return __('Introduction Box', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-introduction-box';
    }

    public function get_categories()
    {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['introduction_box', 'introductionbox', esc_html__( 'Introduction Box' , 'ahura')];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                "default" => __("Title Here", 'ahura')
            ]
        );

        $this->add_control(
            'subtitle',
            [
            'label' => __('Subtitle', 'ahura'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __("Subtitle Here", 'ahura')
        ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Image', 'ahura'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
		);

        $this->add_responsive_control(
            'object_fit',
            [
                'label' => esc_html__( 'Aspect ratio', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'fill' => esc_html__( 'Default', 'ahura' ),
                    'contain' => esc_html__( 'Contain', 'ahura' ),
                    'cover'  => esc_html__( 'Cover', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'use_link',
            [
                'label' => esc_html__('Use Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'url',
            [
                'label'     => __('Url', 'ahura'),
                'type'      => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'default'   => [
                    'url' => '#',
                ],
                'condition' => [
                        'use_link' => 'yes'
                ]
            ]
        );

        $this->add_control('divider1', ['type' => \Elementor\Controls_Manager::DIVIDER]);

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Title Tag', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => esc_html__( 'H1', 'ahura' ),
                    'h2' => esc_html__( 'H2', 'ahura' ),
                    'h3' => esc_html__( 'H3', 'ahura' ),
                    'h4' => esc_html__( 'H4', 'ahura' ),
                    'h5' => esc_html__( 'H5', 'ahura' ),
                    'h6' => esc_html__( 'H6', 'ahura' ),
                    'p' => esc_html__( 'P', 'ahura' ),
                    'div' => esc_html__( 'DIV', 'ahura' ),
                ],
            ]
        );

        $this->add_control(
            'subtitle_tag',
            [
                'label' => esc_html__( 'SubTitle Tag', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => esc_html__( 'H1', 'ahura' ),
                    'h2' => esc_html__( 'H2', 'ahura' ),
                    'h3' => esc_html__( 'H3', 'ahura' ),
                    'h4' => esc_html__( 'H4', 'ahura' ),
                    'h5' => esc_html__( 'H5', 'ahura' ),
                    'h6' => esc_html__( 'H6', 'ahura' ),
                    'p' => esc_html__( 'P', 'ahura' ),
                    'div' => esc_html__( 'DIV', 'ahura' ),
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
            'img_styles',
            [
                'label' => __('Image', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => __( 'Width', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                    'size' => '50',
                ],
                'tablet_default' => [
                    'unit' => '%',
                    'size' => '100',
                ],
                'mobile_default' => [
                    'unit' => '%',
                    'size' => '100',
                ],
                'size_units' => [ '%', 'px', 'vw' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .introduction-box-left' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => __( 'Height', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '330',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => '400',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => '150',
                ],
                'size_units' => [ 'px', '%', 'vw' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .introduction-box-left img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'img_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .introduction-box-left img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'img_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .introduction-box-left img',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .introduction-box-left img',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'content_styles',
            [
                'label' => __('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .introduction-box h2, {{WRAPPER}} .introduction-box .title' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __("Title Typography", "ahura"),
                'selector' => '{{WRAPPER}} .introduction-box h2, {{WRAPPER}} .introduction-box .title',
                'fields_options' =>
                    [
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '38'
                            ]
                        ]
                    ]
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label' => __('Sub Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .introduction-box h3, {{WRAPPER}} .introduction-box .subtitle' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'label' => __("Sub Title Typography", "ahura"),
                'selector' => '{{WRAPPER}} .introduction-box h3, {{WRAPPER}} .introduction-box .subtitle',
                'fields_options' =>
                    [
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '24'
                            ]
                        ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'ahura' ),
                'types' => [ 'classic', 'gradient'],
                'fields_options' =>
                    [
                        'background' => [
                            'default' => 'gradient'
                        ],
                        'color' => [
                            'default' => '#521d91'
                        ],
                        'color_b' => [
                            'default' => '#4a42ec'
                        ],
                        'gradient_angle' =>[
                            'default' => [
                                'unit' => 'deg',
                                'size' => 200,
                            ],
                        ]
                    ],
                'selector' => '{{WRAPPER}} .introduction-box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .introduction-box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __( 'Box Shadow', 'ahura' ),
                'selector' => '{{WRAPPER}} .introduction-box',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $use_link = $settings['use_link'] == 'yes';
        ?>
        <<?php echo $use_link ? "a href='{$settings['url']['url']}'" : 'div' ?> class="introduction-box">
            <div class="introduction-box-right">
                <<?php echo $settings['title_tag'];?> class="title"><?php echo $settings['title'];?></<?php echo $settings['title_tag'];?>>
                <<?php echo $settings['subtitle_tag'];?> class="subtitle"><?php echo $settings['subtitle'];?></<?php echo $settings['subtitle_tag'];?>>
            </div>
            <div class="introduction-box-left">
                <?php if(!empty($settings['image']['url'])): ?>
                    <img src="<?php echo $settings['image']['url'];?>">
                <?php endif; ?>
            </div>
        </<?php echo $use_link ? 'a' : 'div'  ?>>
        <?php
    }
}
