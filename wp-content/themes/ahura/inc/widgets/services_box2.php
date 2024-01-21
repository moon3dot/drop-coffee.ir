<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class services_box2 extends \Elementor\Widget_Base {
    use \ahura\app\traits\mw_elementor;
    public function get_name() {
        return 'ahoora_services_box2';
    }

    public function get_title() {
        return __( 'Services Box 2', 'ahura' );
    }

    public function get_icon() {
        return 'aicon-svg-services-box-2';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['servicebox2', 'services_box2', 'services_box_2', 'servicesbox2', esc_html__( 'Services Box 2' , 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $services_box2_css = mw_assets::get_css('elementor.services_box2');
        mw_assets::register_style('services_box2', $services_box2_css);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('services_box2')];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->start_controls_tabs('style_tabs');
        $repeater->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Content', 'ahura' ),
            ]
        );

        $repeater->add_control(
            'service_icon',
            [
                'label'    => __( 'Service Icon', 'ahura' ),
                'type'     => \Elementor\Controls_Manager::ICONS,
                'description' => __('Choose from font library or upload your own icon', 'ahura'),
                'default' => [
                    'value' => 'fa fa-compass',
                    'library' => 'fa-solid'
                ]
            ]
        );

        $repeater->add_control(
            'service_title',
            [
                'label'   => __( 'Service Title', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('Service Title', 'ahura')
            ]
        );

        $repeater->add_control(
            'service_description',
            [
                'label'   => __( 'Service Description', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Service description here', 'ahura')
            ]
        );

        $repeater->add_control(
            'scale',
            [
                'label' => __("Special Mode", 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ahura'),
                'label_of' => __("No", 'ahura'),
                'return_value' => '1',
                'default' => ''
            ]
        );

        $repeater->add_control(
            'use_link',
            [
                'label' => __('Use Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'ahura' ),
                'label_off' => esc_html__( 'No', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'box_link',
            [
                'label' => esc_html__( 'Link', 'ahura' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'condition' => ['use_link' => 'yes']
            ]
        );

        $repeater->add_control(
            'btn_text',
            [
                'label'   => __( 'Button Text', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __('Buy Service', 'ahura'),
                'condition' => ['use_link' => 'yes']
            ]
        );

        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            'item_style_tab',
            [
                'label' => esc_html__( 'Style', 'ahura' ),
            ]
        );

        $repeater->add_control(
            'icon_background_color',
            [
                'label' => __('Icon Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'white',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon_wrapper' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $repeater->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fd5e5e',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service_icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service_icon svg' => 'fill: {{VALUE}}'
                ]
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'ah_icon_border',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .icon_wrapper',
                'fields_options' => [
                    'border' => [
                        'label' => __('Icon border', 'ahura'),
                        'default' => 'solid'
                    ],
                    'width' => [
                        'default' => [
                            'unit' => 'px',
                            'top' => '10',
                            'right' => '10',
                            'bottom' => '10',
                            'left' => '10',
                        ]
                    ],
                    'color' => [
                        'default' => '#fd5e5e'
                    ]
                ]
            ]
        );

        $repeater->add_control(
            'title_color',
            [
                'label' => __("Title Color", 'ahura'),
                'name' => 'title_color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fd5e5e',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .ah_title' => 'color: {{VALUE}}'
                ]
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title typography', 'ahura'),
                'name' => 'ah_title_typography',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ah_title',
            ]
        );

        $repeater->add_control(
            'description_color',
            [
                'label' => __("Description Color", 'ahura'),
                'name' => 'title_color',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fd5e5e',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .description' => 'color: {{VALUE}}'
                ]
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Description typography', 'ahura'),
                'name' => 'ah_description_typography',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .description',
            ]
        );

        $repeater->add_control(
            'overlay_box_background',
            [
                'label' => __('Overlay box background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fd5e5e',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .box_overlay' => 'background-color: {{VALUE}}'
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'scale',
                            'value' => '1',
                            'operator' => '=='
                        ]
                    ]
                ]
            ]
        );

        $repeater->add_control(
            'box_border_bottom_color',
            [
                'label' => __('Box bottom border color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}::after' => 'border-color: {{VALUE}}'
                ]
            ]
        );

        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            'services',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'label' => __("Services Box", 'ahura'),
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{service_title}}}',
                'default' => [
                    [
                        'service_title' => __("First Box", 'ahura'),
                        'service_description' => __("Box 1 description here", 'ahura'),
                        'ah_icon_border_border' => 'solid',
                        'ah_icon_border_width' => [
                            'unit' => 'px',
                            'top' => '10',
                            'right' => '10',
                            'left' => '10',
                            'bottom' => '10'
                        ],
                        'ah_icon_border_color' => '#fd5e5e',
                        'box_border_bottom_color' => '#fd5e5e'
                    ],
                    [
                        'service_title' => __("Second Box", 'ahura'),
                        'service_description' => __("Box 2 description here", 'ahura'),
                        'scale' => '1',
                        'icon_color' => '#d84e4e',
                        'title_color' => 'white',
                        'description_color' => 'white',
                        'ah_icon_border_border' => 'solid',
                        'ah_icon_border_width' => [
                            'unit' => 'px',
                            'top' => '10',
                            'right' => '10',
                            'left' => '10',
                            'bottom' => '10'
                        ],
                        'ah_icon_border_color' => '#d84e4e',
                        'box_border_bottom_color' => '#fd5e5e'
                    ],
                    [
                        'service_title' => __("Third Box", 'ahura'),
                        'service_description' => __('Box 3 description here', 'ahura'),
                        'ah_icon_border_border' => 'solid',
                        'ah_icon_border_width' => [
                            'unit' => 'px',
                            'top' => '10',
                            'right' => '10',
                            'left' => '10',
                            'bottom' => '10'
                        ],
                        'ah_icon_border_color' => '#fd5e5e',
                        'box_border_bottom_color' => '#fd5e5e'
                    ]
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
            'btn_style_section',
            [
                'label' => __( 'Button', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('btn_style_tabs');
        $this->start_controls_tab(
            'btn_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#3c0000',
                'selectors' => [
                    '{{WRAPPER}} .ah-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'ahura'),
                'name' => 'btn_title_typo',
                'selector' => '{{WRAPPER}} .ah-button',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16',
                        ]
                    ]
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_bg',
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .ah-button',
            ]
        );

        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
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
                'default' => [
                    'unit' => 'px',
                    'size' => 5
                ],
                'selectors' => [
                    '{{WRAPPER}} .ah-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'selector' => '{{WRAPPER}} .ah-button',
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
                    'color' => ['default' => '#c54c4c']
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'btn_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'btn_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ah-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_bg_hover',
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .ah-button:hover',
            ]
        );

        $this->add_responsive_control(
            'btn_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .ah-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border_hover',
                'selector' => '{{WRAPPER}} .ah-button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function render_service_icon($settings)
    {
        if(isset($settings['service_icon']['library']) && $settings['service_icon']['library'] == 'svg')
        {
            echo '<img src="'.$settings['service_icon']['value']['url'].'" />';
        }else{
            \Elementor\Icons_Manager::render_icon( $settings['service_icon'], [ 'aria-hidden' => 'true' ] );
        }
    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="services_elem_2">
            <div class="row">
                <?php
                foreach($settings['services'] as $id => $service) {
                    $service_id = !empty($service['_id']) ? $service['_id'] : uniqid();
                    $repeater_title_key = $this->get_repeater_setting_key('service_title', 'services', $id);
                    $repeater_description_key = $this->get_repeater_setting_key('service_description', 'services', $id);
                    $this->add_inline_editing_attributes($repeater_title_key, 'none');
                    $this->add_inline_editing_attributes($repeater_description_key, 'none');

                    if ( ! empty( $service['box_link']['url'] ) ) {
                        $this->add_link_attributes( 'box_link_' . $service_id, $service['box_link'] );
                    }
                    ?>
                    <div class="col-md-4 <?php echo $service['scale'] ? 'ah_bold' : ''; ?> service_item_wrapper elementor-repeater-item-<?php echo $service_id; ?>">
                        <div class="service_item">
                            <div class="icon_wrapper">
                                <span class="service_icon"><?php $this->render_service_icon($service); ?></span>
                            </div>
                            <h3 class="ah_title"><?php $this->render_inline_edit_data($service['service_title'], $repeater_title_key); ?></h3>
                            <p class="description"><?php $this->render_inline_edit_data($service['service_description'], $repeater_description_key); ?></p>
                            <?php if ($service['use_link'] === 'yes'): ?>
                                <a <?php echo $this->get_render_attribute_string('box_link_' . $service_id); ?> class="ah-button"><?php echo $service['btn_text'] ?></a>
                            <?php endif; ?>
                            <div class="box_overlay"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php }
}
