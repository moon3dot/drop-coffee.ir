<?php
// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class Ahura_Menu extends \Elementor\Widget_Base
{
     /**
     * Ahura_Menu constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('menu_css', mw_assets::get_css('elementor.menu'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('menu_css')];
    }

    public function get_name()
    {
        return 'ahura_menu';
    }

    public function get_title()
    {
        return esc_html__('Menu', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-menu-bar';
    }

    public function get_categories()
    {
        return ['ahuraheader'];
    }

    function get_keywords()
    {
        return ['menu', 'menu1', esc_html__('Menu', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $locations = [];
        $menu_locations = get_nav_menu_locations();

        if($menu_locations){
            foreach($menu_locations as $key => $value){
                $menu_item = wp_get_nav_menu_object(get_nav_menu_locations($key)[$key]);
                if($menu_item){
                    $locations[$key] = $menu_item->name;
                }
            }
        }

        $this->add_control(
            'menu_location',
            [
                'label' => esc_html__('Menu Location', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'options' => $locations,
                'default' => ($locations) ? key($locations) : false
            ]
        );

        $this->add_control(
            'mode',
            [
                'label' => esc_html__('Mode', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'horizontal' => [
                        'title' => __('Horizontal', 'ahura'),
                        'icon' => 'eicon-navigation-horizontal'
                    ],
                    'vertical' => [
                        'title' => __('Vertical', 'ahura'),
                        'icon' => 'eicon-navigation-vertical'
                    ],
                ],
                'default' => 'horizontal',
            ]
        );

        $this->add_control(
            'hide_in_scroll',
            [
                'label' => esc_html__('Hide in scroll', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
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
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
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
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'submenu_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .menu-wrapper ul.sub-menu' => 'background-color: {{VALUE}} !important',
                    ]
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
                'tab' => Controls_Manager::TAB_STYLE,
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
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'back_mobile_menu_color',
            [
                'label' => __('Mobile menu backrground color', 'ahura'),
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside li.current-menu-item a' => 'background-color: {{VALUE}}',
                    ]
            ]
        );
        $this->add_control(
            'mobile_menu_items_border_color',
            [
                'label' => __('Border color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222',
                'selectors' =>
                    [
                        '.siteside li > a' => 'border-color: {{VALUE}}',
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
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '.siteside li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'more2_options',
			[
				'label' => esc_html__('Button', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
            'mm_btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
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
                'type' => Controls_Manager::COLOR,
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
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'mobile_menu_sub_color',
            [
                'label' => __('Sub Menu color', 'ahura'),
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '.siteside .sub-menu li a' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $menu_location = $settings['menu_location'];
        $hide_in_scroll = $settings['hide_in_scroll'] == 'yes' ? ' hide_in_scroll' : '';
        $mode = $settings['mode'];
        ?>
        <div class="menu-element menu-element-1 nav-mode-<?php echo $mode; ?> <?php echo $hide_in_scroll ?>">
            <?php if (!empty($menu_location) && has_nav_menu($menu_location)): ?>
                <a href="#" class="menu-icon" id="mw_open_side_menu">
                    <i class="fa fa-bars"></i>
                </a>
                <div id="siteside" class="siteside" data-align="<?php echo $settings['mobile_text_align'] ?>">
                    <span class="fa fa-window-close siteside-close" id="menu-close"></span>
                    <?php render_menu_location($menu_location); ?>
                </div>
                <div class="menu-wrapper in_custom_header">
                    <?php render_menu_location($menu_location, true); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
