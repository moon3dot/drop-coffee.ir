<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts7 extends \Elementor\Widget_Base
{
    /**
     * grid_posts7 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts7_css', mw_assets::get_css('elementor.grid_posts7'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('grid_posts7_css')];
    }

    public function get_name()
    {
        return 'grid_posts7';
    }

    public function get_title()
    {
        return esc_html__('Grid Posts 7', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-grid-post-7';
    }

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }

    public function get_keywords()
    {
        return ['gridposts7', 'grid_posts7', esc_html__('Grid Posts 7', 'ahura')];
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
                'default' => $default
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
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Posts Count', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'max' => 8,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'full',
            ]
        );

        $this->add_responsive_control(
            'object_fit',
            [
                'label' => esc_html__( 'Aspect ratio', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'fill' => esc_html__( 'Default', 'ahura' ),
                    'contain' => esc_html__( 'Contain', 'ahura' ),
                    'cover'  => esc_html__( 'Cover', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-item img' => 'object-fit: {{VALUE}};',
                ],
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
            'item_excerpt_show',
            [
                'label' => esc_html__('Excerpt', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
			'excerpt_chars_count',
			[
				'label'   => __( 'Excerpt Characters', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
				'condition' => [
					'item_excerpt_show' => 'yes'
				]
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
                'default' => 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .grid-posts7 .post-details' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .grid-posts7 .post-details .post-excerpt' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .grid-posts7 .post-details .post-excerpt p' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_item_details_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#3E3E3E',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts7 .post-details .post-title h2' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .grid-posts7 .post-details .post-metas div' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'item_meta_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_item_details_excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#7B7B7B',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts7 .post-details .post-excerpt' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .grid-posts7 .post-details .post-excerpt p' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'item_excerpt_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_item_details_btn_color',
            [
                'label' => esc_html__('Button Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#418dff',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts7 .post-details .post-btns a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .grid-posts7 .post-details .post-title h2',
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
                'selector' => '{{WRAPPER}} .grid-posts7 .post-details .post-metas div',
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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Excerpt Typography', 'ahura'),
                'name' => 'item_excerpt_typography',
                'selector' => '{{WRAPPER}} .grid-posts7 .post-details .post-excerpt',
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
                    'item_excerpt_show' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Button Typography', 'ahura'),
                'name' => 'item_btns_typography',
                'selector' => '{{WRAPPER}} .grid-posts7 .post-details .post-btns a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 300],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13',
                        ]
                    ]
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
                    '{{WRAPPER}} .grid-posts7 .post-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 25,
                    'right' => 25,
                    'bottom' => 25,
                    'left' => 25,
                ]
            ]
        );

        $this->end_controls_section();

        /**
         *
         *
         * Image style
         *
         *
         */
        $this->start_controls_section(
            'box_item_image_styles',
            [
                'label' => esc_html__('Image', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'item_img_min_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
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
                    'size' => 237,
                    'unit' => 'px',
                ],
                'desktop_default' => [
                    'size' => 237,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 293,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 150,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-posts7 .post-item .post-cover' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_img_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts7 .post-item .post-cover img',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 2,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.13)'
                        ]
                    ]
                ],
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

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-posts7 .post-item' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-posts7 .post-item',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 2,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.13)'
                        ]
                    ]
                ],
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

        $hoverClass = '';
        if ($settings['box_item_hover_animation']) {
            $hoverClass .= ' elementor-animation-' . $settings['box_item_hover_animation'];
        }

        $chars_num = isset($settings['excerpt_chars_count']) && intval($settings['excerpt_chars_count']) ? $settings['excerpt_chars_count'] : false;

        if ($posts):
            ?>
            <div class="grid-posts7-wrap">
                <div class="grid-posts7">
                    <div class="row">
                        <?php
                        $i = 0;
                        while ($posts->have_posts()):$posts->the_post();
                            $i++;
                            $cls = ($i == 1 || $i % 4 == 0 || $i % 5 == 0 || $i % 9 == 0) ? 'post-revert' : '';
                            ?>
                            <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 mb-4 <?php echo $cls ?>">
                                <div class="post-item <?php echo $hoverClass; ?>">
                                    <div class="row p-0 m-0 align-items-center">
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5 p-0 m-0">
                                            <div class="post-cover">
                                                <?php echo wp_get_attachment_image(get_post_thumbnail_id(), $settings['item_cover_size']) ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-xs-12 col-sm-12 col-md-7 col-lg-7 p-0 m-0">
                                            <div class="post-details">
                                                <?php if ($settings['item_meta_show'] === 'yes'): ?>
                                                    <div class="post-metas">
                                                        <?php
                                                        $cats = get_the_category();
                                                        if ($cats) { ?>
                                                            <div class="post-cats">
                                                                <span><?php printf('%s:', esc_html__('Category', 'ahura')) ?></span>
                                                                <?php
                                                                foreach ($cats as $key => $cat) {
                                                                    $output = "<span>{$cat->cat_name}</span>";
                                                                    if (count($cats) > 1 && $key !== count($cats) - 1)
                                                                        $output .= is_rtl() ? "، " : ", ";
                                                                    echo $output;
                                                                }
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="post-title">
                                                    <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                                        <h2><?php the_title() ?></h2>
                                                    </a>
                                                </div>
                                                <?php if ($settings['item_excerpt_show'] === 'yes'): ?>
                                                    <div class="post-excerpt"><?php 
                                                        if($chars_num){
                                                            echo '<p>' . wp_trim_words(get_the_excerpt(), $chars_num, '...') . '</p>';
                                                        } else {
                                                            the_excerpt();
                                                        }
                                                    ?></div>
                                                <?php endif; ?>
                                                <div class="post-btns">
                                                    <a href="<?php echo esc_attr(get_the_permalink()) ?>">
                                                        <i class="fas fa-eye"></i>
                                                        <?php echo esc_html__('View More', 'ahura') ?>
                                                        <span class="f<?php echo (is_rtl()) ? 'l' : 'r' ?>">
                                                            <i class="fas fa-chevron-<?php echo (is_rtl()) ? 'left' : 'right' ?>"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="mw_element_error">
                <?php echo esc_html__('Sorry,no posts were found for display.', 'ahura'); ?>
            </div>
        <?php
        endif;
    }
}