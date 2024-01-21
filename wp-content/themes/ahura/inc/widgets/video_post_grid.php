<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class video_post_grid extends \Elementor\Widget_Base
{
    /**
     * video_post_grid constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('video_post_grid_css', mw_assets::get_css('elementor.video_post_grid'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('video_post_grid_css')];
    }

    public function get_name()
    {
        return 'video_post_grid';
    }

    public function get_title()
    {
        return esc_html__('Video Post Grid', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-video-post-grid';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['videopostgrid', 'video_post_grid', esc_html__('Video Post Grid', 'ahura')];
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
                'label' => esc_html__('Category', 'ahura'),
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
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item .vpg-details' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_item_details_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFFC7',
                'selectors' => [
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item .vpg-details' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_item_details_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#3E3E3E',
                'selectors' => [
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item .vpg-details .vpg-title h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_item_details_meta_color',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#7B7B7B',
                'selectors' => [
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item .vpg-details .vpg-metas div' => 'color: {{VALUE}}',
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
                'selector' => '{{WRAPPER}} .video-post-grid-1 .vpg-item .vpg-details .vpg-title h2',
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
                'selector' => '{{WRAPPER}} .video-post-grid-1 .vpg-item .vpg-details .vpg-metas div',
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
            'box_item_details_padding',
            [
                'label' => esc_html__('padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item .vpg-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    'size' => 450,
                    'unit' => 'px',
                ],
                'desktop_default' => [
                    'size' => 450,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 450,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 350,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item.vpg-item-lg' => 'min-height: calc({{SIZE}}{{UNIT}} + 30px)',
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item.vpg-item-sm' => 'min-height: calc({{SIZE}}{{UNIT}} / 2)',
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
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .video-post-grid-1 .vpg-item .vpg-cover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .video-post-grid-1 .vpg-item',
            ]
        );

        $this->add_control('divider', ['type' => Controls_Manager::DIVIDER]);

        $this->add_control(
            'box_item_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'ahura'),
                'type' => Controls_Manager::HOVER_ANIMATION,
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
        $posts = $this->get_posts(['posts_per_page' => 2, 'offset' => 1]);
        $posts2 = $this->get_posts(['posts_per_page' => 1]);

        $hoverClass = '';
        if ($settings['box_item_hover_animation']) {
            $hoverClass .= ' elementor-animation-' . $settings['box_item_hover_animation'];
        }

        if ($posts || $posts2):
            ?>
            <div class="video-post-grid-wrap">
                <div class="video-post-grid-1">
                    <div class="row align-items-center">
                        <?php if ($posts2): ?>
                            <div class="col-12 col-sm-12 col-mg-8 col-lg-8">
                                <?php
                                while ($posts2->have_posts()):$posts2->the_post();
        $img = wp_get_attachment_image_src(get_post_thumbnail_id(), $settings['item_cover_size']); ?>
                                    <div class="vpg-item vpg-item-lg <?php echo $hoverClass; ?>">
                                        <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                            <div class="vpg-cover row align-items-center p-0 m-0"
                                                 style="background-image: url(<?php echo (isset($img[0])) ? $img[0] : '' ?>)">
                                                <div class="col-12 vpg-play-button"><i class="fas fa-play-circle"></i>
                                                </div>
                                            </div>
                                            <div class="vpg-details">
                                                <div class="vpg-title"><h2><?php the_title() ?></h2></div>
                                                <?php if ($settings['item_meta_show'] === 'yes'): ?>
                                                    <div class="vpg-metas">
                                                        <?php
                                                        $cats = get_the_category();
        if ($cats) { ?>
                                                            <div class="vpg-cats">
                                                                <span><i class="fas fa-folder"></i><?php printf('%s:', esc_html__('Category', 'ahura')); ?></span>
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
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($posts): ?>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                            <div class="row vpg-items-sm align-items-center">
                                <?php
                                while ($posts->have_posts()):$posts->the_post();
        $img = wp_get_attachment_image_src(get_post_thumbnail_id(), $settings['item_cover_size']); ?>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-12">
                                        <div class="vpg-item vpg-item-sm <?php echo $hoverClass; ?>">
                                            <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                                <div class="vpg-cover row align-items-center p-0 m-0"
                                                     style="background-image: url(<?php echo (isset($img[0])) ? $img[0] : '' ?>)">
                                                    <div class="col-12 vpg-play-button"><i
                                                                class="fas fa-play-circle"></i></div>
                                                </div>
                                                <div class="vpg-details">
                                                    <div class="vpg-title"><h2><?php the_title() ?></h2></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php
                                endwhile;
        wp_reset_query();
        wp_reset_postdata();
        endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="mw_element_error">
                <?php echo esc_html__('Sorry, no posts were found for display.', 'ahura'); ?>
            </div>
        <?php
        endif;
    }
}
