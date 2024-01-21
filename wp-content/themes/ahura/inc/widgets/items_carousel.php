<?php

namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

defined('ABSPATH') or die('No script kiddies please!');

class items_carousel extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_items_carousel';
    }
    function get_title()
    {
        return esc_html__('Items carousel', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-items-carousel';
	}
    function get_categories()
    {
        return ['ahuraelements'];
    }
    function get_keywords()
    {
        return ['itemscarousel', 'items_carousel', esc_html__('Items carousel', 'ahura')];
    }

    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $items_carousel_css = mw_assets::get_css('elementor.items_carousel');
        mw_assets::register_style('items_carousel_css', $items_carousel_css);
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'));
        mw_assets::register_script('items_carousel_js', mw_assets::get_js('elementor.items_carousel'));
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('items_carousel_css'), mw_assets::get_handle_name('swipercss')];
    }

    function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('items_carousel_js')];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'conetent_section',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );

        $this->add_control(
			'auto_play',
			[
				'label' => esc_html__( 'Auto Play', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'yes', 'ahura' ),
				'label_off' => esc_html__( 'no', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'auto_play_speed',
			[
				'label' => esc_html__( 'Auto Play Speed', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10000,
				'step' => 1,
				'default' => 1000,
                'condition' => ['auto_play' => 'yes']
			]
		);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'ahura'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Title', 'ahura'),
            ]
        );

        $repeater->add_control(
            'link_text',
            [
                'label' => __('Button Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Read more', 'ahura')
            ]
        );

        $repeater->add_control(
            'link_url',
            [
                'label' => __('Button url', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#'
                ]
            ]
        );

        $repeater->add_responsive_control(
            'image_top',
            [
                'label' => esc_html__('Image top', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 40
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .items-carousel-image img' => 'margin-top: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->start_controls_tabs('item_style_tabs');
        $repeater->start_controls_tab('item_style_title_tab', ['label' => esc_html__( 'Title', 'ahura' )]);

        $repeater->add_control(
            'item_title_color',
            [
                'label' => esc_html__( 'Title Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .items-carousel-content h5' => 'color: {{VALUE}}',
                ],
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title Typography', 'ahura'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .items-carousel-content h5',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '35',
                        ]
                    ],
                    'font_weight' => [
                        'default' => '900'
                    ],
                    'line_height' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '40',
                        ]
                    ],
                ]
            ]
        );

        $repeater->end_controls_tab();
        $repeater->start_controls_tab('item_style_btn_tab', ['label' => esc_html__( 'Button', 'ahura' )]);

        $repeater->add_control(
            'link_color',
            [
                'label' => __('Button color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#5C79D1',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .items-carousel-content a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'link_background_color',
                'label' => __( 'Button background color', 'ahura' ),
                'types' => [ 'classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .items-carousel-content a',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#fff'
                        ]
                ]
            ]
        );

        $repeater->end_controls_tab();
        $repeater->start_controls_tab('item_style_box_tab', ['label' => esc_html__( 'Box', 'ahura' )]);

        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'gradient'
                        ],
                    'color' =>
                        [
                            'default' => '#5c79d1'
                        ],
                    'color_b' =>
                        [
                            'default' => '#9c70f4'
                        ],
                ]
            ]
        );

        $repeater->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                ]
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );

        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            'items',
            [
                'label' => __('Slides', 'ahura'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('Title','ahura')
                    ],[
                        'title' => __('Title','ahura')
                    ],[
                        'title' => __('Title','ahura')
                    ]
                ],
                'title_field' => '{{{ title }}}',
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
                'label' => esc_html__('Image', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'img_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .items-carousel img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'box_img_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .items-carousel img',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .items-carousel img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'btn_styles',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Button Typography', 'ahura'),
                'name' => 'item_btn_typography',
                'selector' => '{{WRAPPER}} .items-carousel-link',
                'fields_options' =>
                    [
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '15',
                            ]
                        ],
                    ]
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .items-carousel-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .items-carousel-link',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .items-carousel-link',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'active_styles',
            [
                'label' => esc_html__('Active Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __( 'Active box shadow', 'ahura' ),
                'selector' => '{{WRAPPER}} .items-carousel .swiper-slide-next',
                'fields_options' =>
                    [
                        'box_shadow_type' =>
                            [
                                'default' =>'yes'
                            ],
                        'box_shadow' => [
                            'default' =>
                                [
                                    'horizontal' => 0,
                                    'vertical' => 0,
                                    'blur' => 20,
                                    'spread' => 5,
                                    'color' => 'rgba(156,112,244,0.33)'
                                ]
                        ]
                    ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
    ?>
        <div class="swiper swiper-items-carousel items-carousel">
            <div class="swiper-wrapper">
                <?php if ($settings['items']) {
                    foreach ($settings['items'] as $item) {
                        $item_id = !empty($item['_id']) ? $item['_id'] : uniqid();
                        if ( ! empty( $item['link_url']['url'] ) ) {
                            $this->add_link_attributes( 'link_url_' . $item_id, $item['link_url'] );
                        }
                        ?>
                        <div class="swiper-slide elementor-repeater-item-<?php echo $item_id; ?>">
                            <div class="items-carousel-image">
                                <?php if (!empty($item['image']['id'])): ?>
                                    <?php echo wp_get_attachment_image($item['image']['id'], 'full') ?>
                                <?php elseif(!empty($item['image']['url'])): ?>
                                    <img src="<?php echo $item['image']['url']; ?>" alt="element">
                                <?php endif; ?>
                            </div>
                            <div class="items-carousel-content">
                                <div class="items-carousel-title">
                                    <h5><?php echo $item['title']; ?></h5>
                                </div>
                                <a <?php echo $this->get_render_attribute_string( 'link_url_' . $item_id ); ?> class="items-carousel-link"><?php echo $item['link_text']; ?></a>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
            <div class="items-carousel-button-prev"><i class="fa fa-chevron-left"></i></div>
            <div class="items-carousel-button-next"><i class="fa fa-chevron-right"></i></div>
        </div>
        <script type="text/javascript">
        jQuery(document).ready(function($){
            let playDelayValue = <?php echo $settings['auto_play'] === 'yes' ? $settings['auto_play_speed'] : 99999; ?>;
            handleItemsCarouselElement({
                autoPlayStatus: <?php echo $settings['auto_play'] === 'yes' ? 'true' : 'false' ?>,
                playDelay: playDelayValue
            });
        });
        </script>
    <?php
    }
}
