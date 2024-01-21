<?php

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class Ahura_Main_Menu extends \Elementor\Widget_Base
{
    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('main_menu_css', mw_assets::get_css('elementor.main_menu'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('main_menu_css')];
    }

    public function get_name()
    {
        return 'mainmenu';
    }

    public function get_title()
    {
        return esc_html__('Main Menu', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-menu-bar';
    }

    public function get_categories()
    {
        return ['ahuraheader'];
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
            'hide_in_scroll',
            [
                'label' => esc_html__('Hide in scroll', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => false
            ]
        );

        $this->end_controls_section();
        /**
         *
         * Styles
         *
         */
        $this->start_controls_section(
            'main_menu_style_section',
            [
                'label' => esc_html__('Main Menu', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .menu-wrapper ul li a' => 'color: {{VALUE}} !important',
                        '{{WRAPPER}} .menu-wrapper ul li::after' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'menu_color_hover',
            [
                'label' => esc_html__('Hover Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .menu-wrapper ul li a:hover' => 'color: {{VALUE}} !important',
                        '{{WRAPPER}} .menu-wrapper ul li:hover::after' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_fontsize',
                'label' => esc_html__('Menu Font Size', 'ahura'),
                'selector' => '{{WRAPPER}} .menu-wrapper ul li a',
                'fields_options' =>
                    [
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '15'
                            ]
                        ]
                    ]
            ]
        );

        $this->end_controls_section();

        /*
         *
         *
         * Sub menu
         *
         *
         */

        $this->start_controls_section(
            'main_submenu_style_section',
            [
                'label' => esc_html__('Sub Menu', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'submenu_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .menu-wrapper ul.sub-menu li a' => 'color: {{VALUE}} !important',
                        '{{WRAPPER}} .menu-wrapper ul.sub-menu li::after' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'submenu_color_hover',
            [
                'label' => esc_html__('Hover Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .menu-wrapper ul.sub-menu li a:hover' => 'color: {{VALUE}} !important',
                        '{{WRAPPER}} .menu-wrapper ul.sub-menu li:hover::after' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'submenu_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .menu-wrapper ul.sub-menu' => 'background-color: {{VALUE}} !important',
                    ]
            ]
        );

        $this->add_control(
			'top_margin',
			[
				'label' => esc_html__( 'Margin from top', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 35,
				],
				'selectors' => [
					'{{WRAPPER}} .topmenu > li > ul.sub-menu' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submenu_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .menu-wrapper ul.sub-menu',
            ]
        );

        $this->end_controls_section();

        /**
         *
         * Mobile menu styles
         *
         */
        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __('Mobile Menu', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
            'mobile_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .siteside ul li a' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
			'more_options',
			[
				'label' => esc_html__('Menu', 'ahura'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'back_mobile_menu_color',
            [
                'label' => __('Mobile menu backrground color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'mobile_menu_color',
            [
                'label' => __('Mobile menu color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside li a' => 'color: {{VALUE}}',
                    ]
            ]
        );
		
		$this->add_control(
            'mobile_menu_color_hover',
            [
                'label' => esc_html__('Hover Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside li a:hover' => 'color: {{VALUE}} !important',
                    ]
            ]
        );

        $this->add_control(
            'mobile_menu_current_color_hover',
            [
                'label' => __('Current Menu color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside li.current-menu-item a' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'back_mobile_menu_current_color_hover',
            [
                'label' => __('Current Menu Background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside li.current-menu-item a' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'items_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '.siteside li a',
            ]
        );

        $this->add_control(
            'items_spacing',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'allowed_dimensions' => ['top', 'bottom'],
                'selectors' => [
                    '.siteside li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'more2_options',
			[
				'label' => esc_html__('Button', 'ahura'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
            'mm_btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem','%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-icon, #topbar {{WRAPPER}} .menu-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20
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
            'mm_btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-icon, #topbar {{WRAPPER}} .menu-icon' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'sub_content_style_section',
            [
                'label' => __('Mobile Submenu', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'mobile_menu_sub_color',
            [
                'label' => __('Sub Menu color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside .sub-menu li a' => 'color: {{VALUE}}',
                    ]
            ]
        );
		
		$this->add_control(
            'mobile_menu_sub_menu_color_hover',
            [
                'label' => esc_html__('Hover Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside .sub-menu li a:hover' => 'color: {{VALUE}} !important',
                    ]
            ]
        );

        $this->add_control(
            'back_mobile_menu_sub_color_hover',
            [
                'label' => __('Sub Menu Background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside .sub-menu li a' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="ahura-element-main-menu <?php echo ($settings['hide_in_scroll']) ? ' hide_in_scroll' : '' ?>">
            <?php if (has_nav_menu('topmenu')) : ?>
                <a href="#" class="menu-icon" id="mw_open_side_menu">
                    <i class="fa fa-bars"></i>
                </a>
                <div id="siteside" class="siteside" data-align="<?php echo $settings['mobile_text_align'] ?>">
                    <span class="fa fa-window-close siteside-close" id="menu-close"></span>
                    <?php rd_topmenu(); ?>
                </div>
            <?php endif; ?>
            <div class="menu-wrapper in_custom_header">
                <?php rd_topmenu(); ?>
            </div>
        </div>
        <?php
    }
}
