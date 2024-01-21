<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts extends \Elementor\Widget_Base
{
    /**
     * grid_posts constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts_css', mw_assets::get_css('elementor.grid_posts'));
        if (!is_rtl()) {
            mw_assets::register_style('grid_posts_ltr_css', mw_assets::get_css('elementor.ltr.grid_posts_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_posts_css')];
        if (!is_rtl()) {
            $styles[] = mw_assets::get_handle_name('grid_posts_ltr_css');
        }
        return $styles;
    }

    public function get_name()
    {
        return 'gridposts';
    }

    public function get_title()
    {
        return __('Grid Posts 1', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-grid-post-1';
    }

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }
    function get_keywords()
    {
        return ['gridposts1', 'grid_posts_1', esc_html__('Grid Posts 1', 'ahura')];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $categories = get_categories();
        $cats       = [];
        foreach ($categories as $category) {
            $cats[$category->term_id] = $category->name;
        }
        $default = key($cats);
        $this->add_control(
            'catsid',
            [
                'label'    => __('Categories', 'ahura'),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $cats,
                'label_block' => true,
                'multiple' => true,
                'default' => $default
            ]
        );

        $tags   = get_terms(['taxonomy' => 'post_tag']);
        $tag    = [];
        foreach ($tags as $tagItem) {
            $tag[$tagItem->term_id] = $tagItem->name;
        }
        $default = key($tag);

        $this->add_control(
            'tagsid',
            [
                'label'         => __('tag', 'ahura'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $tag,
                'label_block'   => true,
                'multiple'      => true,
                'default'       => $default
            ]
        );

        $item_types   = get_terms(['taxonomy' => 'content_types']);
        $content_type    = [];
        foreach ($item_types as $item_type) {
            $content_type[$item_type->term_id] = $item_type->name;
        }
        $default = key($content_type);

        $this->add_control(
            'content_types_id',
            [
                'label'         => __('Content type', 'ahura'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $content_type,
                'label_block'   => true,
                'multiple'      => true,
                'default'       => $default
            ]
        );

        $this->add_control(
            'postcount',
            [
                'label'      => __('Number of posts', 'ahura'),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 4
            ]
        );

        $this->add_control(
            'posttitle',
            [
                'label'      => __('Title', 'ahura'),
                'type'       => Controls_Manager::TEXT,
                'default' => esc_html__('Posts List', 'ahura'),
            ]
        );

        $this->add_control(
            'postlink',
            [
                'label'      => __('Show all url', 'ahura'),
                'type'       => Controls_Manager::URL,
                'dynamic' => ['active' => true],
            ]
        );
        $this->add_control(
            'post_order',
            [
                'label' => __('Sort', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'DESC',
                'options' => [
                    'ASC' => [
                        'title' => __('Ascending', 'ahura'),
                        'icon' => 'eicon-sort-up'
                    ],
                    'DESC' => [
                        'title' => __('Descending', 'ahura'),
                        'icon' => 'eicon-sort-down'
                    ],
                ],
                'toggle' => true
            ]
        );

        $this->add_control('divider', ['type' => \Elementor\Controls_Manager::DIVIDER]);

        $this->add_control(
            'show_posts_overlay',
            [
                'label' => esc_html__('Posts Overlay', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'verthumb',
            ]
        );

        $this->end_controls_section();
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

        /**
         *
         *
         * Box style
         *
         *
         */
        $this->start_controls_section(
            'box_style_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_head_margin',
            [
                'label' => esc_html__('Box Header Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top', 'bottom'],
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .cat-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .postbox1 .cat-more-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 30,
                    'left' => 0,
                    'isLinked' => true
                ]
            ]
        );

        $this->add_control(
            'title_options',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'box_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .cat-name' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#36D43D',
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .cat-name' => 'color: {{VALUE}};border-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'box_title_typography',
                'selector' => '{{WRAPPER}} .postbox1 .cat-name',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '19',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'btn_options',
            [
                'label' => esc_html__('Button', 'ahura'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'box_btn_color',
            [
                'label' => esc_html__('Button color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .cat-more-link' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'box_btn_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#36D43D',
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .cat-more-link' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Button Typography', 'ahura'),
                'name' => 'box_btn_typography',
                'selector' => '{{WRAPPER}} .postbox1 .cat-more-link',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'box_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .cat-more-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                ]
            ]
        );

        $this->add_responsive_control(
            'box_btn_padding',
            [
                'label' => esc_html__('padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .cat-more-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 5,
                    'right' => 15,
                    'bottom' => 5,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_btn_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .postbox1 .cat-more-link',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 20,
                            'spread' => 0,
                            'color' => 'rgba(54, 212, 61, 0.5)'
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_section();
        
        
        /**
         *
         *
         *
         * Items style
         *
         *
         */
        $this->start_controls_section(
            'items_style_section',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // posts items columns
        $this->add_responsive_control(
            'posts_items_column',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __('Items column', 'ahura'),
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .postbox1posts' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
                'desktop_default' => '4',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => sprintf('1 %s', __('Column', 'ahura')),
                    '2' => sprintf('2 %s', __('Column', 'ahura')),
                    '3' => sprintf('3 %s', __('Column', 'ahura')),
                    '4' => sprintf('4 %s', __('Column', 'ahura')),
                ],
            ]
        );

        $this->start_controls_tabs('items_style_tabs');

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 125,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 2.5,
                        'max' => 300,
                    ],
                    'rem' => [
                        'min' => 2.5,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 350,
                    'unit' => 'px',
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'size' => 350,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 210,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .grid-post' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'box_item_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .grid-post a span' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_item_title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .grid-post a span' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'box_item_title_typography',
                'selector' => '{{WRAPPER}} .postbox1 .grid-post a span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '23',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .postbox1 .grid-post',
            ]
        );

        $this->add_responsive_control(
            'box_item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .grid-post a span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 2,
                    'right' => 1,
                    'bottom' => 2,
                    'left' => 1,
                    'unit' => 'em',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_item_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .grid-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 1.5,
                    'left' => 0,
                    'unit' => 'em',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .grid-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .postbox1 .grid-post a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'box_item_title_text_shadow',
                'label' => esc_html__('Text Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .postbox1 .grid-post a span',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .postbox1 .grid-post',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_item_title_color_hover',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .grid-post:hover a span' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_item_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .postbox1 .grid-post:hover',
            ]
        );

        $this->add_responsive_control(
            'box_item_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .postbox1 .grid-post:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .postbox1 .grid-post:hover a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .postbox1 .grid-post:hover',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 20,
                            'blur' => 30,
                            'spread' => 0,
                            'color' => 'rgba(40, 46, 54, 0.30)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_tabs();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $first_cat_id = $settings['catsid'] && is_array($settings['catsid']) ? $settings['catsid'][0] : $settings['catsid'];
        $post_order = $settings['post_order'];
        $postbox1 = new \WP_Query([
            'posts_per_page' => $settings['postcount'],
            'tax_query' => [
                'relation' => 'OR',
                [
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $settings['catsid'],
                ],
                [
                    'taxonomy' => 'post_tag',
                    'field' => 'term_id',
                    'terms' => $settings['tagsid'],
                ],
                [
                    'taxonomy' => 'content_types',
                    'field' => 'term_id',
                    'terms' => $settings['content_types_id'],
                ],
            ],
            'order'         =>  $post_order
        ]);
        if ($postbox1->have_posts()) : ?>
            <div class="postbox1">
                <h2 class="cat-name">
                    <?php
                    if (!isset($settings['posttitle'])) {
                        echo get_cat_name($first_cat_id);
                    } else {
                        echo $settings['posttitle'];
                    }
                    ?>
                </h2>
                <a class="cat-more-link" href="<?php echo $settings['postlink']['url']; ?>"><?php echo __('Show All', 'ahura'); ?></a>
                <div class="clear"></div>
                <div class="postbox1posts">
                    <?php while ($postbox1->have_posts()) :
                        $postbox1->the_post();
                        $thumb_id  = get_post_thumbnail_id();
                        $thumb_url = wp_get_attachment_image_src($thumb_id, $settings['item_cover_size'], true);
                        ?>
                        <article class="grid-post <?php echo ($settings['show_posts_overlay'] == 'yes') ? 'grid-post-grey' : '' ?>" style="background-image:url('<?php echo $thumb_url[0]; ?>');">
                            <a href="<?php the_permalink(); ?>">
                                <span><?php the_title(); ?></span>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="mw_element_error">
                <?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.', 'ahura'); ?>
            </div>
        <?php endif; ?>
        <div class="clear"></div>
<?php
    }
}
