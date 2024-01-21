<?php
namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;
use Elementor\Utils;

class image_slider2 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\link_utilities;

    /**
     * image_slider2 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('image_slider2_css', mw_assets::get_css('elementor.image_slider2'));
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'), false);
        mw_assets::register_script('image_slider2_js', mw_assets::get_js('elementor.image_slider2'), false);
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('swipercss'),mw_assets::get_handle_name('image_slider2_css')];
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('image_slider2_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'image_slider2';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Image Slider 2', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-slides';
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
        return ['imageslider2', 'image_slider2', esc_html__('Image Slider 2', 'ahura')];
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
         * Start content section
         *
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'item_image',
			[
				'label' => esc_html__('Image', 'ahura'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $repeater->add_control(
            'item_url',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'is_external' => true,
                ],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => esc_html__('Slides', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_image' => ['url' => Utils::get_placeholder_image_src()],
                        'item_image' => ['url' => Utils::get_placeholder_image_src()],
                        'item_image' => ['url' => Utils::get_placeholder_image_src()],
                    ]
                ],
                
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'content_settings',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'slides_per_view',
            [
                'label' => esc_html__('Slides per view', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                ],
                'default' =>1,
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Arrows', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label' => esc_html__('Transition Duration', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 2500,
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label' => esc_html__('Infinite Loop', 'ahura'),
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
         * Styles
         *
         */
        $this->start_controls_section(
            'box_navigation_style',
            [
                'label' => esc_html__('Navigation', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'nav_options',
			[
				'label' => esc_html__('Navigation', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'box_nav_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .image-slider-2 .swiper-nav-button i' => 'border-bottom-color: {{VALUE}}',
                    '{{WRAPPER}} .image-slider-2 .swiper-btn-prev i:after' => 'border-top-color: {{VALUE}};border-right-color: {{VALUE}}',
                    '{{WRAPPER}} .image-slider-2 .swiper-btn-next i:after' => 'border-bottom-color: {{VALUE}};border-left-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_nav_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .image-slider-2 .swiper-nav-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'paginate_options',
			[
				'label' => esc_html__('Pagination', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'box_paginate_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00000087',
                'selectors' => [
                    '{{WRAPPER}} .image-slider-2 .swiper-pagination-bullets .swiper-pagination-bullet' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_paginate_active_color',
            [
                'label' => esc_html__('Active Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .image-slider-2 .swiper-pagination-bullets .swiper-pagination-bullet-active' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .image-slider-2 .swiper-pagination-bullets .swiper-pagination-bullet-active:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'box_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 13,
                ],
                'selectors' => [
                    '{{WRAPPER}} .image-slider-2, {{WRAPPER}} .image-slider-2 img' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .image-slider-2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .image-slider-2',
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
        $wid = $this->get_id();
        $slides = $settings['slides'];

        $has_paginate = ($settings['show_pagination'] == 'yes');
        $has_navigate = ($settings['show_arrows'] == 'yes');
        ?>
        <div class="image-slider-2 image-slider-2-<?php echo $wid; ?><?php echo $has_paginate ? ' has-paginate' : '' ?><?php echo $has_navigate ? ' has-navigate' : '' ?>">
           <div class="swiper image-slider-2-slides">
            <div class="swiper-wrapper">
                <?php 
                if($slides):
                    foreach($slides as $slide):
                        $has_url = isset($slide['item_url']['url']) && !empty($slide['item_url']['url']);
                 ?>
                <div class="swiper-slide">
                    <?php if($has_url): ?>
                        <a <?php $this->render_link_attrs($slide['item_url']) ?>>
                    <?php endif; ?>

                    <?php 
                    if(isset($slide['item_image']['id']) && !empty($slide['item_image']['id'])){
                        echo wp_get_attachment_image($slide['item_image']['id'], 'full');
                    } else {
                        echo "<img src='{$slide['item_image']['url']}' alt='Slide Image'>";
                    }
                    ?>

                    <?php if($has_url): ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
            <?php if($has_paginate): ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>
            <?php if($has_navigate): ?>
                <div class="swiper-navigation-btns">
                    <div class="swiper-nav-button swiper-btn-prev"><i class="gg-arrow-long-right"></i></div>
                    <div class="swiper-nav-button swiper-btn-next"><i class="gg-arrow-long-left"></i></div>
                </div>
            <?php endif; ?>
           </div>
           <script type="text/javascript">
            jQuery(document).ready(function(){
                handleImageSlider2Element({
                    widgetID: '<?php echo $wid; ?>',
                    autoPlay: <?php echo $settings['autoplay'] == 'yes' ? 'true' : 'false' ?>,
                    transitionDuration: <?php echo (intval($settings['transition_duration'])) ? $settings['transition_duration'] : 2500 ?>,
                    loop: <?php echo $settings['infinite_loop'] == 'yes' ? 'true' : 'false' ?>,
                    slidesPerView: <?php echo (isset($settings['slides_per_view']) && intval($settings['slides_per_view'])) ? $settings['slides_per_view'] : 1 ?>,
                    mobilePerView: <?php echo (isset($settings['slides_per_view_mobile']) && intval($settings['slides_per_view_mobile'])) ? $settings['slides_per_view_mobile'] : 1 ?>,
                    tabletPerView: <?php echo (isset($settings['slides_per_view_tablet']) && intval($settings['slides_per_view_tablet'])) ? $settings['slides_per_view_tablet'] : 1 ?>,
                    pagination: <?php echo $has_paginate ? 'true' : 'false' ?>,
                    navigation: <?php echo $has_navigate ? 'true' : 'false' ?>,
                });
            });
            </script>
        </div>
        <?php
    }
}