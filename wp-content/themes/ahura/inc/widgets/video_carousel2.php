<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class video_carousel2 extends \Elementor\Widget_Base
{
    /**
     * video_carousel2 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'));
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_style('video_carousel2_css', mw_assets::get_css('elementor.video_carousel2'));
        mw_assets::register_script('video_carousel2_js', mw_assets::get_js('elementor.video_carousel2'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('video_carousel2_css'), mw_assets::get_handle_name('swipercss')];
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('video_carousel2_js')];
    }

    public function get_name()
    {
        return 'video_carousel2';
    }

    public function get_title()
    {
        return esc_html__('Video Carousel 2', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-video-carousel-2';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['videocarousel2', 'video_carousel2', esc_html__('Video Carousel 2', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'display_settings',
            [
                'label' => esc_html__('Layout', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $post_types = get_post_types(array('public' => true), 'objects');
        unset($post_types['attachment']);
        $types = array();
        foreach ($post_types as $post_type) {
            $types[$post_type->name] = $post_type->labels->singular_name;
        }

        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Type', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $types,
            ]
        );

        $taxonomies = get_taxonomies(['public' => true], 'objects');

        $taxs = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($taxonomy->public) {
                    $taxs[$taxonomy->name] = $taxonomy->labels->name;
                }
            }
        }
        $default = ($taxs) ? key($taxs) : 0;
        $this->add_control(
            'tax_name',
            [
                'label' => esc_html__('Taxonomy', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $taxs,
                'label_block' => true,
                'default' => $default,
            ]
        );

        $cats = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($term_object = get_terms($key)) {
                    if($term_object){
                        foreach ($term_object as $term) {
                            $cats[$term->term_id] = "{$term->name} - {$taxonomy->labels->name}";
                        }
                    }
                }
            }
        }
        $default = ($cats) ? key($cats) : 0;
        $this->add_control(
            'cat_id',
            [
                'label' => esc_html__('Categories', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $cats,
                'label_block' => true,
                'multiple' => true,
                'default' => $default,
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Slides Count', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 6
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'full',
            ]
        );

        $this->add_control(
            'item_meta_show',
            [
                'label' => esc_html__('Meta', 'ahura'),
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
        $this->end_controls_section();
        /**
         *
         *
         *
         * Styles
         *
         *
         *
         */

        $this->start_controls_section(
            'box_item_details_styles',
            [
                'label' => esc_html__('Details', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
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
            'item_details_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-details' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_item_details_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00000091',
                'selectors' => [
                    '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-details' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_item_details_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-details .vpc-title h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_item_details_meta_color',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-details .vpc-metas div' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'item_meta_show' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-details .vpc-title h2',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
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
                'label' => esc_html__('Meta Typography', 'ahura'),
                'name' => 'item_meta_typography',
                'selector' => '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-details .vpc-metas div',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 300],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ]
                ],
                'condition' => [
                    'item_meta_show' => 'yes'
                ]
            ]
        );


        $this->add_control(
            'item_details_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'box_item_details_padding',
            [
                'label' => esc_html__('padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'box_item_height',
            [
                'label' => esc_html__('Min Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 600,
                    'unit' => 'px',
                ],
                'desktop_default' => [
                    'size' => 600,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 450,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 250,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel2 .vpc-item' => 'min-height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .video-carousel2 .vpc-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .video-carousel2 .vpc-item .vpc-cover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'item_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .video-carousel2 .vpc-item',
            ]
        );

        $this->end_controls_section();
    }

    /**
     *
     * Get posts result
     *
     * @param array $params
     * @return false
     */
    public function get_posts($params = [])
    {
        $settings = $this->get_settings_for_display();
        $args = array(
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['per_page'],
            'post_status' => 'publish',
        );

        if ($settings['cat_id']) {
            $args['tax_query'] = array(
                'tax_query' => [
                    'relation' => 'OR',
                    [
                        'taxonomy' => $settings['tax_name'],
                        'field' => 'term_id',
                        'terms' => $settings['cat_id'],
                    ]
                ]
            );
        }

        $posts = new \WP_Query(array_merge($args, $params));
        return ($posts->have_posts()) ? $posts : false;
    }

    /**
     *
     * Render content for display
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        $posts = $this->get_posts();

        if ($posts):
            ?>
            <div class="video-carousel2-wrap">
                <div class="swiper video-carousel2 video-carousel2-<?= $wid ?>">
                    <div class="swiper-wrapper">
                        <?php
                        while ($posts->have_posts()):$posts->the_post();
                            $img = wp_get_attachment_image_src(get_post_thumbnail_id(), $settings['item_cover_size']);
                            $date = get_the_modified_date(); 
                            ?>
                            <div class="swiper-slide">
                                <div class="vpc-item">
                                    <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                        <div class="vpc-cover row align-items-center p-0 m-0" style="background-image: url(<?php echo (isset($img[0])) ? $img[0] : '' ?>)">
                                            <div class="col-12 vpc-play-button"><i class="fas fa-play-circle"></i></div>
                                        </div>
                                        <div class="vpc-details">
                                            <div class="vpc-title"><h2><?php the_title() ?></h2></div>
                                            <?php if ($settings['item_meta_show'] === 'yes'): ?>
                                                <div class="vpc-metas">
                                                    <?php
                                                    $cats = get_the_category();
                                                    if ($cats) { ?>
                                                        <div class="vpc-cats">
                                                            <span><i class="fas fa-folder"></i></span>
                                                            <?php
                                                            foreach ($cats as $cat) {
                                                                $output = "<span>{$cat->cat_name}</span>";
                                                                if (count($cats) > 1) {
                                                                    $output .= ", ";
                                                                }
                                                                echo $output;
                                                            }
                                                            ?>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="vpc-date">
                                                        <span><i class="fas fa-calendar"></i></span>
                                                        <span><?php echo $date ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata(); 
                        ?>
                    </div>
                    <?php if ($settings['show_pagination'] === 'yes'): ?>
                        <div class="vpc2-swiper-pagination"></div>
                    <?php endif; ?>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    handleVideoCarousel2Element();
                });
            </script>
        <?php else: ?>
            <div class="ahura-element-msg">
                <?php echo esc_html__('Sorry, no posts were found for display.', 'ahura'); ?>
            </div>
        <?php
        endif;
    }
}
