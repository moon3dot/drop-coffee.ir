<?php
// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class Ahura_Mega_Menu extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('mega_menu_css', mw_assets::get_css('elementor.mega_menu'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('mega_menu_css')];
        return $styles;
    }

    public function get_name()
    {
        return 'megamenu';
    }

    public function get_title()
    {
        return esc_html__('Mega Menu', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
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
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'megamenu_title',
			[
				'label' => __("Megamenu Title", 'ahura'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __("MegaMenu title", 'ahura'),
                'default' => __( 'Product Category', 'ahura' ),
			]
		);

        $this->add_control(
            'open_menu',
            [
                'label' => esc_html__('Open in Front Page', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'hide_in_scroll',
            [
                'label' => __('Hide in scroll', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => false
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         *
         * Styles
         *
         */
        $this->start_controls_section(
            'content_styles_section',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'btn_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 270
                ],
                'mobile_default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'tablet_default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'selectors' => [
                    '{{WRAPPER}} .cats-list' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .cats-list-title' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .cats-list-title' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'background_color_hover',
            [
                'label' => esc_html__('Hover Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .cats-list-title:hover' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'color_hover',
            [
                'label' => esc_html__('Hover Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .cats-list-title:hover' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_fontsize',
                'label' => esc_html__('Title Font Size', 'ahura'),
                'selector' => '{{WRAPPER}} .cats-list-title',
                'fields_options' =>
                    [
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '16'
                            ]
                        ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .cats-list-title',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cats-list-title' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'submenu_section',
            [
                'label' => esc_html__('Submenu', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'list_background_color',
            [
                'label' => esc_html__('List Items Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .cats-list .menu' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .cats-list ul.menu > li > a::after' => 'opacity: 0',
                        '{{WRAPPER}} .cats-list ul.menu > li > a::before' => 'opacity: 0',
                        '{{WRAPPER}} .cats-list .menu li ul' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'list_color',
            [
                'label' => esc_html__('List Items Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .cats-list .menu li a' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'list_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .cats-list > div ul',
            ]
        );

        $this->add_control(
            'list_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cats-list > div ul' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $open_menu = (!is_front_page() || !get_theme_mod('openmenuinfrontpage'));
        $open_menu = !is_front_page() || $settings['open_menu'] != 'yes';
        $hide_in_scroll = ($settings['hide_in_scroll']) ? ' hide_in_scroll' : '';
        ?>
        <div class="ahura-mega-menu-element">
            <div class="cats-list <?php echo $open_menu ? ' isnotfront' : '' ?> in_custom_header<?php echo $hide_in_scroll ?>">
                <span class="cats-list-title in_custom_header"><?php echo $settings['megamenu_title']; ?></span>
                <?php render_mega_menu(); ?>
            </div>
        </div>
        <?php
    }
}
