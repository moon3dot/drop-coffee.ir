<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class imgbox3 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\link_utilities;

    /**
     * imgbox3 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('imgbox3_css', mw_assets::get_css('elementor.imgbox3'));
        if(!is_rtl()){
            mw_assets::register_style('imgbox3_ltr_css', mw_assets::get_css('elementor.ltr.imgbox3_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('imgbox3_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('imgbox3_ltr_css');
        }
        return $styles;
    }

    public function get_name()
    {
        return 'ahura_imgbox3';
    }

    public function get_title()
    {
        return esc_html__('Image Box 3', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-image';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['imgbox3', 'imgbox_3', esc_html__('Image Box 3', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
			'image',
			[
				'label' => esc_html__('Choose Image', 'ahura'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'ahura'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Default title', 'ahura'),
			]
		);

        $this->add_control(
			'description',
			[
				'label' => esc_html__('Description', 'ahura'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
			]
		);

        $this->add_control(
            'box_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control('divider1', ['type' => Controls_Manager::DIVIDER]);

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'full',
            ]
        );

        $this->end_controls_section();
        
        /***
         *
         *
         * Box style
         *
         *
         */
        $this->start_controls_section(
            'box_item_styles',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'box_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 5,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 5,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'unit' => 'px',
                    'size' => 400
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura-element-imgbox3' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control('divider2', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .item-box-details .box-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_des_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .item-box-details .box-des' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .item-box-details .box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '600'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'des_typography',
                'label' => esc_html__('Description Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .item-box-details .box-des',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '300'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
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
            'box_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .item-box-details' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-element-wrap-imgbox3',
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-element-wrap-imgbox3' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-element-wrap-imgbox3',
            ]
        );
        $this->end_controls_section();
    }

    /**
     *
     * Render content for display
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();

        $title = $settings['title'];
        $des = $settings['description'];
        $link = $settings['box_link'];

        $image_src = isset($settings['image']['id']) && intval($settings['image']['id']) ? $settings['image']['id'] : $settings['image']['url'];
        $image_src = (intval($image_src)) ? wp_get_attachment_image_src($image_src, $settings['item_cover_size']) : $image_src;
        $image_src = (is_array($image_src) && isset($image_src[0])) ? $image_src[0] : $image_src;
        $image_src = !empty($image_src) ? $image_src : \Elementor\Utils::get_placeholder_image_src();
        ?>
        <div class="ahura-element-wrap-imgbox3">
            <a <?php $this->render_link_attrs($link, (isset($link['url']) && !empty($link['url']))) ?> class="ahura-element-imgbox3" style="background-image:url(<?php echo $image_src ?>)">
                <div class="item-box-details">
                    <?php if(!empty($title)): ?>
                        <div class="box-title"><?php echo $title; ?></div>
                    <?php endif; ?>
                    <?php if(!empty($des)): ?>
                        <div class="box-des"><?php echo $des; ?></div>
                    <?php endif; ?>
                </div>
            </a>
        </div>
        <?php
    }
}