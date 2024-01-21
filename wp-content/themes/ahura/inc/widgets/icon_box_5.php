<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class icon_box_5 extends \Elementor\Widget_Base {
    /**
     * @param $data
     * @param $args
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        mw_assets::register_style('icon_box5_css', mw_assets::get_css('elementor.icon_box_5'));
    }

    public function get_style_depends() {
        $styles = [mw_assets::get_handle_name('icon_box5_css')];
        return $styles;
    }

    public function get_name() {
        return 'ahura_icon_box_5';
    }

    public function get_title() {
        return __( 'Icon Box 5', 'ahura' );
    }

    public function get_icon() {
        return 'eicon-form-vertical';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['icon_box_5', 'iconbox5', esc_html__( 'Icon Box 5' , 'ahura')];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section', [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'cols_num',
            [
                'label' => esc_html__( 'Columns', 'ahura' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 15,
                'step' => 1,
                'default' => 6,
                'desktop_default' => 6,
                'tablet_default' => 3,
                'mobile_default' => 2,
                'selectors' => [
                    '{{WRAPPER}} .icons-box' => 'grid-template-columns: repeat({{VALUE}},minmax(0,1fr));',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Default title', 'ahura' ),
            ]
        );

        $repeater->add_control(
            'use_image',
            [
                'label' => esc_html__( 'Use Image', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'ahura' ),
                'label_off' => esc_html__( 'No', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'ahura' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'use_image' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-up',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'use_image!' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'box_link',
            [
                'label' => esc_html__( 'Link', 'ahura' ),
                'type' => Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => site_url(),
                ],
                'label_block' => true,
            ]
        );

        $repeater->add_control('hr', ['type' => Controls_Manager::DIVIDER]);

        $repeater->add_control(
            'item_title_color',
            [
                'label' => esc_html__( 'Title Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box .icon-box-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $repeater->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'use_image!' => 'yes'
                ]
            ]
        );

        $repeater->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'use_image' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{title}}}',
                'default' => [
                    ['title' => __('Mobile', 'ahura')],
                    ['title' => __('Digital Products', 'ahura')],
                    ['title' => __('Home and Kitchen', 'ahura')],
                    ['title' => __('Apparel', 'ahura')],
                    ['title' => __('Food Beverage', 'ahura')],
                    ['title' => __('Book and Media', 'ahura')],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'more_section', [
                'label' => __( 'More', 'ahura' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__( 'Show Title', 'ahura' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'ahura' ),
                'label_off' => esc_html__( 'Hide', 'ahura' ),
                'return_value' => 'yes',
                'default' => 'yes',
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
            'items_style_section', [
                'label' => __( 'Items', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_options',
            [
                'label' => esc_html__( 'Image', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__( 'Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-content .image-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__( 'Height', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-content .image-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_options',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .icon-box-content i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .icon-box-content svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-content i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .icon-box-content svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_options',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                        'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .icon-box-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .icon-box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 400],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ]
                    ]
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['items'];
        ?>
        <div class="icon-box-5-wrap">
            <div class="box-details">
                <div class="icons-box ic-<?php echo count($items) ?> ah-cols-<?php echo $settings['cols_num'] ?>">
                    <?php
                    if($items):
                        foreach($items as $item):
                            $item_id = !empty($item['_id']) ? $item['_id'] : uniqid();
                            if (!empty($item['box_link']['url'])) {
                                $this->add_link_attributes('box_link_' . $item_id, $item['box_link']);
                            }
                            ?>
                            <a <?php echo $this->get_render_attribute_string('box_link_' . $item_id); ?>>
                                <div class="elementor-repeater-item-<?php echo $item_id ?> icon-box">
                                    <div class="icon-box-content d-flex flex-column justify-content-center align-items-center">
                                        <?php
                                        if($item['use_image'] === 'yes'):
                                            ?><div class="image-container d-flex justify-content-center align-items-center"><?php
                                            if(!empty($item['image']['id'])){
                                                echo wp_get_attachment_image($item['image']['id'], 'full');
                                            } else {
                                                echo '<img src="' . $item['image']['url'] . '" alt="'. $item['title'] .'">';
                                            } ?>
                                            </div>
                                        <?php
                                        else:
                                            \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
                                        endif;
                                        ?>
                                        <?php if($settings['show_title'] === 'yes'): ?>
                                        <div class="icon-box-title"><?php echo $item['title'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
