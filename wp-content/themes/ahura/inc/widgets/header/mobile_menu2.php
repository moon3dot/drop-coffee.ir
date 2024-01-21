<?php
// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class Ahura_Mobile_Menu2 extends \Elementor\Widget_Base
{
    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('mobile_menu2_css', mw_assets::get_css('elementor.mobile_menu2'));
        if(!is_rtl()){
            mw_assets::register_style('mobile_menu2_ltr_css', mw_assets::get_css('elementor.ltr.mobile_menu2_ltr'));
        }
        mw_assets::register_script('mobile_menu2_js', mw_assets::get_js('elementor.mobile_menu2'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('mobile_menu2_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('mobile_menu2_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('mobile_menu2_js')];
    }

    public function get_name()
    {
        return 'ahura_mobile_menu2';
    }

    public function get_title()
    {
        return esc_html__('Mobile Menu 2', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-menu-toggle';
    }

    public function get_categories()
    {
        return ['ahuraheader'];
    }

    function get_keywords()
    {
        return ['mobilemenu2', 'mobile_menu2', esc_html__('Mobile Menu 2', 'ahura')];
    }

    protected function register_controls()
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

        $this->add_control(
            'mobile_icon',
            [
                'label' => esc_html__('Mobile Button Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-bars',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'show_side_logo',
            [
                'label' => esc_html__('Show Logo', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'logo',
            [
                'label' => esc_html__( 'Logo', 'ahura' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_template_directory_uri() . '/img/ahura-logo.png',
                ],
                'condition' => [
                    'show_side_logo' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_close_btn',
            [
                'label' => esc_html__('Show Close Button', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         *
         * Side menu
         *
         */
        $this->start_controls_section(
            'side_styles_section',
            [
                'label' => __('Mobile Menu', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'side_width',
            [
                'label' => esc_html__( 'Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 5000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-side-content',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->add_control(
            'mm_btn_options',
            [
                'label' => esc_html__( 'Button', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mm_btn_width',
            [
                'label' => esc_html__( 'Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mm_btn_height',
            [
                'label' => esc_html__( 'Height', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-button' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mm_btn_color',
            [
                'label' => esc_html__( 'Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mmenu2-side-button i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mmenu2-side-button svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mm_btn_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-side-button',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mm_btn_border',
                'selector' => '{{WRAPPER}} .mmenu2-side-button',
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
                    'color' => ['default' => '#f0f0f0']
                ]
            ]
        );

        $this->add_control(
            'mm_btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mm_btn_shadow',
                'selector' => '{{WRAPPER}} .mmenu2-side-button',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'side_items_styles_section',
            [
                'label' => __('Mobile Menu Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('side_items_style_tabs');
        $this->start_controls_tab(
            'side_items_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_item_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-content ul li a, {{WRAPPER}} .mmenu2-side-content ul li > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'side_item_typo',
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul li a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_item_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul li a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_item_border',
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul li a',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'side_items_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_item_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-content ul li a:hover, {{WRAPPER}} .mmenu2-side-content ul li:hover > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_item_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul li a:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_item_border_hover',
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul li a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'side_items_style_active_tab',
            [
                'label' => esc_html__( 'Active', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_item_color_active',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-content ul li:is(.is-toggled, .current-menu-item) > a, {{WRAPPER}} .mmenu2-side-content ul li:is(.is-toggled, .current-menu-item) > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_item_background_active',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul li:is(.is-toggled, .current-menu-item) > a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_item_border_active',
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul li:is(.is-toggled, .current-menu-item) > a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'side_sub_items_styles_section',
            [
                'label' => __('Mobile Sub Menu Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('side_sub_items_style_tabs');
        $this->start_controls_tab(
            'side_sub_items_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_sub_item_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'side_sub_item_typo',
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_sub_item_background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li a',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#f0f0f0']
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_sub_item_border',
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li a',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'side_sub_items_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_sub_item_color_hover',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li a:hover, {{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li:hover > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_sub_item_background_hover',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li a:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_sub_item_border_hover',
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'side_sub_items_style_active_tab',
            [
                'label' => esc_html__( 'Active', 'ahura' ),
            ]
        );

        $this->add_control(
            'side_sub_item_color_active',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e72828',
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li:is(.is-toggled, .current-menu-item) > a, {{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li:is(.is-toggled, .current-menu-item) a > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'side_sub_item_background_active',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li:is(.is-toggled, .current-menu-item) > a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'side_sub_item_border_active',
                'selector' => '{{WRAPPER}} .mmenu2-side-content ul ul.sub-menu li:is(.is-toggled, .current-menu-item) > a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'side_close_styles_section',
            [
                'label' => __('Close Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'show_close_btn' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'close_color',
            [
                'label' => esc_html__( 'Text Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#434b78',
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-close-btn svg path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'close_bg',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mmenu2-close-btn',
                'fields_options' =>
                    [
                        'background' =>
                            [
                                'default' => 'classic'
                            ],
                        'color' => [
                            'default' => '#ffffff'
                        ]
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'close_border',
                'selector' => '{{WRAPPER}} .mmenu2-close-btn',
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
                    'color' => ['default' => '#cdcdcd']
                ]
            ]
        );

        $this->add_responsive_control(
            'close_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mmenu2-close-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'close_shadow',
                'selector' => '{{WRAPPER}} .mmenu2-close-btn',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 6,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => '#00000040'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $logo = $settings['logo'];
        $menu_location = $settings['menu_location'];
        $hide_in_scroll = $settings['hide_in_scroll'] == 'yes' ? ' hide_in_scroll' : '';
        ?>
        <div class="mobile-menu2-element mobile-menu-element-2 <?php echo $hide_in_scroll ?>">
            <?php if (!empty($menu_location) && has_nav_menu($menu_location)): ?>
                <div class="mmenu2-side-wrapper">
                    <div class="mmenu2-side-button">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['mobile_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                    <div class="mmenu2-side-container" style="opacity:0;">
                        <?php if ($settings['show_close_btn'] === 'yes'): ?>
                            <div class="mmenu2-close-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 440.7 440.7" style="enable-background:new 0 0 440.7 440.7;" xml:space="preserve"> <path d="M245.7,220.4L435.5,30.6c7-7,7-18.3,0-25.3c-7-7-18.3-7-25.3,0L220.4,195L30.6,5.2c-7-7-18.3-7-25.3,0s-7,18.3,0,25.3  l189.8,189.8L5.2,410.2c-7,7-7,18.3,0,25.3c3.5,3.5,8.1,5.2,12.7,5.2s9.2-1.7,12.7-5.2l189.8-189.8l189.8,189.8  c3.5,3.5,8.1,5.2,12.7,5.2s9.2-1.7,12.7-5.2c7-7,7-18.3,0-25.3L245.7,220.4z"/> </svg>
                            </div>
                        <?php endif; ?>
                        <div class="mmenu2-side-content">
                            <?php if ($settings['show_side_logo'] === 'yes'): ?>
                                <div class="mmenu2-side-head">
                                    <a href="<?php echo site_url() ?>">
                                        <?php
                                        if(!empty($logo['id'])){
                                            echo wp_get_attachment_image( $logo['id'], 'full' );
                                        } else {
                                            echo '<img src="' . $logo['url'] . '" alt="'. get_bloginfo('name') .'">';
                                        }
                                        ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php render_mega_menu($menu_location); ?>
                        </div>
                        <div class="mmenu2-side-overlay"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
