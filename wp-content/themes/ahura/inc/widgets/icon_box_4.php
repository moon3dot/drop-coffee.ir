<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class icon_box_4 extends \Elementor\Widget_Base {
    /**
     * @param $data
     * @param $args
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        mw_assets::register_style('icon_box4_css', mw_assets::get_css('elementor.icon_box4'));
        if(!is_rtl()){
            mw_assets::register_style('icon_box4_ltr_css', mw_assets::get_css('elementor.ltr.icon_box4_ltr'));
        }
    }

    public function get_style_depends() {
        $styles = [mw_assets::get_handle_name('icon_box4_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('icon_box4_ltr_css');
        }
        return $styles;
    }

    public function get_name() {
        return 'ahura_icon_box_4';
    }

    public function get_title() {
        return __( 'Icon Box 4', 'ahura' );
    }

    public function get_icon() {
        return 'eicon-form-vertical';
    }

    public function get_categories() {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['icon_box_4', 'iconbox4', esc_html__( 'Icon Box 4' , 'ahura')];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section', [
                'label' => __( 'Content', 'ahura' ),
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

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__( 'Title', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Default title', 'ahura' ),
                'condition' => [
                        'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'cols_num',
            [
                'label' => esc_html__( 'Columns', 'ahura' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'default' => 3,
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
            'icon',
            [
                'label' => esc_html__( 'Icon', 'ahura' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
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

        $alignment = [
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-text-align-left'
            ],
            'center' => [
                'title' => __('Center', 'ahura'),
                'icon' => 'eicon-text-align-center'
            ],
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-text-align-right'
            ]
        ];

        $repeater->add_responsive_control(
            'item_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => (is_rtl() ? 'right' : 'left'),
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $repeater->add_control(
            'item_title_color',
            [
                'label' => esc_html__( 'Title Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $repeater->add_control(
            'box_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'ahura' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#354ac4',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box',
                'fields_options' =>
                    [
                        'background' => ['default' => 'classic'],
                        'image' => [
                            'default' => ['url'	=> get_template_directory_uri() . '/img/wheel-spinner.webp'],
                        ],
                        'size' => ['default' => 'contain'],
                        'position' => ['default' => 'center ' . (is_rtl() ? 'left' : 'right')],
                        'repeat' => ['default' => 'no-repeat'],
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
                    '{{WRAPPER}} {{CURRENT_ITEM}}.icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                    ['icon' => ['value' => 'fas fa-rocket']],
                    ['icon' => ['value' => 'fas fa-plane']],
                    ['icon' => ['value' => 'fas fa-meteor']],
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
            'items_styles', [
                'label' => __( 'Items', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .icon-box span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '400'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles', [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .box-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '17',
                        ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'box_options',
            [
                'label' => esc_html__( 'Box', 'ahura' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .icon-box-4-wrap',
                'fields_options' =>
                    [
                        'background' => ['default' => 'classic'],
                        'color' => ['default' => '#354ac4'],
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .icon-box-4-wrap',
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
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
                    'size' => 16
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box-4-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $show_title = $settings['show_title'] == 'yes';

        $items = $settings['items'];
        ?>
        <div class="icon-box-4-wrap">
            <div class="box-details <?php echo !$show_title ? 'without-title' : '' ?>">
                <?php if($show_title): ?>
                <div class="box-title">
                    <?php echo $settings['box_title'] ?>
                </div>
                <?php endif; ?>
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
                                        <div class="icon-box-content">
                                            <?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                            <span class="icon-box-title"><?php echo $item['title'] ?></span>
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
