<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class video_carousel extends \Elementor\Widget_Base
{

    // Use prepared methods
    use \ahura\app\traits\mw_elementor;

    /**
     * video_carousel constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('video_carousel_css', mw_assets::get_css('elementor.video_carousel'));
        wp_register_script(mw_assets::get_handle_name('modaljs'), get_template_directory_uri(). '/js/jquery.modal.min.js' , ['jquery'], null, true);
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'));
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_script('video_carousel_js', mw_assets::get_js('elementor.video_carousel'));
        if (!is_rtl()) {
            mw_assets::register_style('video_carousel_ltr_css', mw_assets::get_css('elementor.ltr.video_carousel_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('video_carousel_css'), mw_assets::get_handle_name('swipercss')];
        if (!is_rtl()) {
            $styles[] = mw_assets::get_handle_name('video_carousel_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('modaljs'), mw_assets::get_handle_name('video_carousel_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'video_carousel';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Video Carousel 1', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'aicon-svg-video-carousel';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraelements'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    public function get_keywords()
    {
        return ['videocarousel1', 'video_carousel_1', esc_html__('Video Carousel 1', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        /**
         *
         *
         * Start content
         *
         */
        $this->start_controls_section(
            'video_carousel_content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'video_carousel_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Homemade pasta cooking tutorial in 15 minutes', 'ahura'),
            ]
        );

        $repeater->add_control(
            'video_carousel_subtitle',
            [
                'label' => esc_html__('SubTitle', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Category: recipe', 'ahura'),
            ]
        );

        $repeater->add_control(
            'video_carousel_subtitle_icon',
            [
                'label' => esc_html__('SubTitle Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'skin' => 'inline',
                'default' => [
                    'value' => 'fas fa-folder',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'video_carousel_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://mihanwp.com',
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'is_external' => true,
                ],
            ]
        );

        $repeater->add_control(
            'video_carousel_cover',
            [
                'label' => esc_html__('Choose Cover', 'ahura'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'video_carousel_use_video',
            [
                'label' => esc_html__('Use Video', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'video_carousel_url',
            [
                'label' => esc_html__('Choose Video', 'ahura'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'condition' => [
                    'video_carousel_use_video' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'video_carousel_display_in_modal',
            [
                'label' => esc_html__('Video in Modal', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'video_carousel_use_video' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'video_carousel_items',
            [
                'label' => esc_html__('Video List', 'ahura'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'video_carousel_title' => esc_html__('Types of vegetarian food', 'ahura'),
                        'video_carousel_cover' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    [
                        'video_carousel_title' => esc_html__('Homemade pasta cooking tutorial in 15 minutes', 'ahura'),
                        'video_carousel_subtitle' => esc_html__('Category: recipe', 'ahura'),
                        'video_carousel_cover' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    [
                        'video_carousel_title' => esc_html__('Delicious Chinese chicken', 'ahura'),
                        'video_carousel_cover' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ],
                'title_field' => '{{{video_carousel_title}}}',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'video_carousel_settings_section',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'slides_per_view',
            [
                'label' => esc_html__('Slides per view', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                ],
                'default' => 3,
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Start Styles
         *
         */

        /**
         *
         *
         * Start descriptions styles
         *
         *
         */
        $this->start_controls_section(
            'video_carousel_descriptions_style',
            [
                'label' => esc_html__('Descriptions', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_des_bg',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .video-carousel .des-content, {{WRAPPER}} .video-carousel .des-content .arrow-icon',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff']
                ]
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => esc_html__('Text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .des-content' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .video-carousel-1 .arrow-icon' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_subtitle_color',
            [
                'label' => esc_html__('SubTitle color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#a1a1a1',
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .des-content .subtitle' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .des-content .subtitle i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .des-content .subtitle svg' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'subtitle_icon_size',
            [
                'label' => esc_html__('Subtitle Icon Size', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 13
                ],
                'selectors' => [
                    '{{WRAPPER}} .des-content .subtitle i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .des-content .subtitle svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_des_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .video-carousel-1 .des-content .title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_des_subtitle_typo',
                'label' => esc_html__('SubTitle Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .video-carousel-1 .des-content .subtitle',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 300
                    ],
                ]
            ]
        );


        $this->add_control(
            'des_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .des-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_control(
            'des_box_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .des-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'des_box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .video-carousel-1 .des-content',
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         *
         * Start navigation buttons style
         *
         *
         */

        $this->start_controls_section(
            'video_carousel_btns_style',
            [
                'label' => esc_html__('Navigation', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_btns_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .swiper-buttons div' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_btns_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255, 18, 18, .55)',
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .swiper-buttons div' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_btns_typo',
                'selector' => '{{WRAPPER}} .video-carousel-1 .swiper-buttons div',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '22'
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'box_btns_border_radius',
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
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .swiper-buttons div' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_btns_dimensions',
            [
                'label' => esc_html__('Dimensions', 'ahura'),
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
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .swiper-buttons div' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_btns_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .swiper-buttons div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_btns_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .video-carousel-1 .swiper-buttons div',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'video_carousel_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'box_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1 .cover' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .video-carousel-1 .video-box, {{WRAPPER}} .video-carousel-1 .video-box video' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 600
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 290
                ],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel-1, {{WRAPPER}} .video-carousel-1 .cover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .video-carousel-1 .video-box, .video-carousel-1 .video-box video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .video-carousel-1',
            ]
        );

        $this->end_controls_section();
    }

    /**
     *
     * Render element content (html)
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $items = $settings['video_carousel_items']; ?>
        <?php if ($items): ?>
        <div class="swiper video-carousel video-carousel-1 video-carousel-<?php echo $id ?>">
            <div class="swiper-wrapper scn-<?php echo $settings['slides_per_view'] ?>">
                <?php foreach ($items as $item):
                    $with_video = ($item['video_carousel_use_video'] === 'yes');
                    $in_modal = ($item['video_carousel_display_in_modal'] === 'yes'); ?>
                    <div class="swiper-slide">
                        <?php if ($with_video): ?>
                        <div class="play-button bp">
                            <a href="#videoModal-<?php echo $id; ?>"  rel="videoModal-<?php echo $id; ?>:open" data-wid="<?php echo $id; ?>" class="play" <?php echo ($in_modal) ? sprintf('data-src="%s"', $item['video_carousel_url']['url']) : '' ?>>
                                <i class="fa fa-play"></i>
                            </a>
                        </div>
                        <?php endif; ?>
                        <div class="cover bp" style="background-image: url(<?php echo $item['video_carousel_cover']['url'] ?>)"></div>
                        <?php if ($with_video && !empty($item['video_carousel_url']['url'])): ?>
                            <div class="video-box ap" style="display:none;">
                                <video controls>
                                    <source src="<?php echo $item['video_carousel_url']['url'] ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php endif; ?>
                        <div class="des bp">
                            <a href="<?php echo $item['video_carousel_link']['url'] ?>">
                                <div class="des-content">
                                    <h3 class="title"><?php echo $item['video_carousel_title'] ?></h3>
                                    <div class="subtitle">
                                        <?php \Elementor\Icons_Manager::render_icon( $item['video_carousel_subtitle_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        <?php echo $item['video_carousel_subtitle'] ?>
                                    </div>
                                    <i class="fa fa-chevron-left arrow-icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-buttons">
                            <div class="video-carousel-button-next"><i class="fa fa-chevron-right"></i></div>
                            <div class="video-carousel-button-prev"><i class="fa fa-chevron-left"></i></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="videoModal-<?php echo $id; ?>" class="videoModal videoModal-<?php echo $id; ?>" style="display:none;">
            <video controls>
                <source src="" type="video/mp4">
            </video>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                handleVideoCarouselElement({
                    widgetID: '<?php echo $id ?>',
                    loop: <?php echo count($items) > $settings['slides_per_view'] ? 'true' : 'false' ?>,
                    slidesPerView: <?php echo (isset($settings['slides_per_view']) && intval($settings['slides_per_view'])) ? $settings['slides_per_view'] : 3 ?>,
                    mobilePerView: <?php echo (isset($settings['slides_per_view_mobile']) && intval($settings['slides_per_view_mobile'])) ? $settings['slides_per_view_mobile'] : 1 ?>,
                    tabletPerView: <?php echo (isset($settings['slides_per_view_tablet']) && intval($settings['slides_per_view_tablet'])) ? $settings['slides_per_view_tablet'] : 2 ?>,
                });
            });
        </script>
    <?php endif; ?>
        <?php
    }
}
