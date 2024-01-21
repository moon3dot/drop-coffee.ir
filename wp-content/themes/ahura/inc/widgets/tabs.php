<?php
namespace ahura\inc\widgets;

use ahura\app\elementor\Ahura_Elementor_Builder;
use ahura\app\elementor\Elementor_Widget_Base;
use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class tabs extends Elementor_Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('tabs_css', mw_assets::get_css('elementor.tabs'));
        mw_assets::register_script('tabs_js', mw_assets::get_js('elementor.tabs'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('tabs_css')];
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('tabs_js')];
    }

    public function get_name()
    {
        return 'ahura_tabs';
    }

    public function get_title()
    {
        return esc_html__('Tabs', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['tabs', esc_html__('Tabs', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'tabs_section',
            [
                'label' => __('Tabs', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tab_icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-volleyball-ball',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Tab Title', 'ahura' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_content_type',
            [
                'label' => esc_html__( 'Content Type', 'ahura' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                        'text' => __('Text', 'ahura'),
                        'template' => __('Elementor Template', 'ahura'),
                ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_text_content',
            [
                'label' => esc_html__( 'Content', 'ahura' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => ahura_get_lorem_ipsum(),
                'condition' => ['tab_content_type' => 'text']
            ]
        );

        $templateOptions = [];
        $templatesObj = new Ahura_Elementor_Builder();
        $templates = $templatesObj->getTemplates();

        if ($templates){
            foreach ($templates as $template){
                $templateOptions[$template->ID] = $template->post_title;
            }
        }

        $repeater->add_control(
            'tab_content_template',
            [
                'label' => esc_html__( 'Template', 'ahura' ),
                'type' => Controls_Manager::SELECT,
                'options' => $templateOptions,
                'label_block' => true,
                'condition' => ['tab_content_type' => 'template']
            ]
        );

        $repeater->add_control(
            'tab_important_note',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__('You can create templates from the (Ahura > Builder) page.', 'ahura'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition' => ['tab_content_type' => 'template']
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'List', 'ahura' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__( 'Title 1', 'ahura' ),
                    ],
                    [
                        'tab_title' => esc_html__( 'Title 2', 'ahura' ),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control('hr1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'tabs_mode',
            [
                'label' => esc_html__( 'Mode', 'ahura' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal', 'ahura'),
                    'vertical' => __('Vertical', 'ahura'),
                ],
            ]
        );

        $AlignmentOptions = [
            'left' => [
                'title' => esc_html__( 'Left', 'ahura' ),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__( 'Center', 'ahura' ),
                'icon' => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => esc_html__( 'Right', 'ahura' ),
                'icon' => 'eicon-text-align-right',
            ],
        ];

        $this->add_responsive_control(
            'tab_items_text_alignment',
            [
                'label' => esc_html__( 'Alignment', 'ahura' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $AlignmentOptions : array_reverse($AlignmentOptions),
                'default' => is_rtl() ? 'right' : 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-items ul' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tab_icon_alignment',
            [
                'label' => esc_html__( 'Icon Alignment', 'ahura' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'ahura' ),
                        'icon' => 'eicon-icon-box',
                    ],
                    'middle' => [
                        'title' => esc_html__( 'Middle', 'ahura' ),
                        'icon' => 'eicon-call-to-action',
                    ],
                ],
                'default' => 'top',
                'toggle' => true,
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
            'tab_item_styles',
            [
                'label' => __('Tabs', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('tab_item_style_tabs');
        $this->start_controls_tab('tab_item_style_normal_tab', ['label' => esc_html__( 'Normal', 'ahura' )]);

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

        $this->add_responsive_control(
            'tab_item_text_alignment',
            [
                'label' => esc_html__('Text alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-items li' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9e9fb1',
                'selectors' =>
                    [
                        '{{WRAPPER}} button' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'item_tab_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#525252',
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-title-wrap' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ah-tab-title-wrap svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_tab_title_bg_color',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ah-tab-title-wrap',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_tab_typo',
                'selector' => '{{WRAPPER}} .ah-tab-title-wrap',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_tab_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-title-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-tab-title-wrap',
            ]
        );

        $this->add_responsive_control(
            'item_tab_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-title-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 15,
                    'bottom' => 10,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-tab-title-wrap',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab('tab_item_style_hover_tab', ['label' => esc_html__( 'Hover', 'ahura' )]);

        $this->add_control(
            'item_tab_title_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-title-wrap:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_tab_title_bg_color_hover',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .ah-tab-title-wrap:hover',
            ]
        );

        $this->add_control(
            'item_tab_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-title-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-tab-title-wrap:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-tab-title-wrap:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab('tab_item_style_active_tab', ['label' => esc_html__( 'Active', 'ahura' )]);

        $this->add_control(
            'item_tab_title_color_active',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E91E63',
                'selectors' => [
                    '{{WRAPPER}} .active .ah-tab-title-wrap' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_tab_title_bg_color_active',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .active .ah-tab-title-wrap',
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#f9f9f9'],
                ]
            ]
        );

        $this->add_control(
            'item_tab_radius_active',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .active .ah-tab-title-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border_active',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .active .ah-tab-title-wrap',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow_active',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .active .ah-tab-title-wrap',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'tab_content_styles',
            [
                'label' => __('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'content_tab_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-contents' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'content_tab_bg_color',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ah-tab-contents',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_tab_typo',
                'selector' => '{{WRAPPER}} .ah-tab-contents',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_control(
            'content_tab_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-contents' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-tab-contents',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => [
                        'default' => [
                            'unit' => 'px',
                            'top' => 1,
                            'bottom' => 1,
                            'right' => 1,
                            'left' => 1,
                        ]
                    ],
                    'color' => ['default' => '#f0f0f0'],
                ],
            ]
        );

        $this->add_responsive_control(
            'content_tab_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-contents' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_responsive_control(
            'content_tab_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ah-tab-contents' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_tab_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-tab-contents',
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();

        $tabs = $settings['tabs'];
        ?>
        <div class="ahura-tabs-element-wrap ah-tabs-mode-<?php echo $settings['tabs_mode'] ?>">
            <div class="ah-tab-items">
                <ul>
                    <?php $i = 0; foreach ($tabs as $tab): ?>
                    <li class="item-icon-pos-<?php echo $settings['tab_icon_alignment'] ?> <?php echo $i == 0 ? 'active' : '' ?>">
                        <div class="ah-tab-title-wrap" data-tab="ah-tab-content-<?php echo $tab['_id'] ?>">
                            <?php \Elementor\Icons_Manager::render_icon( $tab['tab_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <div class="ah-tab-title"><?php echo $tab['tab_title'] ?></div>
                        </div>
                    </li>
                    <?php $i++; endforeach; ?>
                </ul>
            </div>
            <div class="ah-tab-contents">
                <?php
                $i = 0;
                foreach ($tabs as $tab):
                    $mode = $tab['tab_content_type'];
                    $templateID = $tab['tab_content_template'];
                    ?>
                    <div class="ah-tab-content" id="ah-tab-content-<?php echo $tab['_id'] ?>" style="display:<?php echo $i == 0 ? 'block' : 'none' ?>">
                        <?php
                        if ($mode == 'template' && !empty($templateID)){
                            Ahura_Elementor_Builder::renderPage($tab['tab_content_template']);
                        } else {
                            echo $tab['tab_text_content'];
                        }
                        ?>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
        <?php
    }
}