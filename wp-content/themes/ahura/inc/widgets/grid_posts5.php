<?php

namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts5 extends \Elementor\Widget_Base
{
    /**
     * grid_posts5 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts5_css', mw_assets::get_css('elementor.grid_posts5'));
        if (!is_rtl()) {
            mw_assets::register_style('grid_post5_ltr_css', mw_assets::get_css('elementor.ltr.grid_posts5_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('grid_posts5_css')];
        if (!is_rtl()) {
            $styles[] = mw_assets::get_handle_name('grid_post5_ltr_css');
        }
        return $styles;
    }

    public function get_name()
    {
        return 'gridposts5';
    }

    public function get_title()
    {
        return __('Grid Posts 5', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-grid-post-5';
    }

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }
    function get_keywords()
    {
        return ['gridposts5', 'grid_posts_5', esc_html__('Grid Posts 5', 'ahura')];
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
        $cats       = array();
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
        $tag    = array();
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
        $this->add_control(
            'items_overlay_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => __('Overlay color', 'ahura'),
                'default' => '#000000cc',
                'condition' => [
                    'show_posts_overlay' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-post-5 h2' => 'background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, {{VALUE}} 100%);',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                    'rem' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 750,
                    'unit' => 'px',
                ],
                'desktop_default' => [
                    'size' => 750,
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
                    '{{WRAPPER}} .grid-post-5 .grid-post-5-right' => 'height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .grid-post-5 .grid-post-5-left > a' => 'height: calc(({{SIZE}}{{UNIT}} - 20px) / 2)'
                ]
            ]
        );

        $this->add_control(
            'items_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .grid-post-5 a h2' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'items_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-post-5 a h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .grid-post-5 a h2',
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

        $this->add_control(
            'box_items_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post-5 a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'box_items_details_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post-5 a h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'items_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .grid-post-5 a',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 2,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.5)'
                        ]
                    ]
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $catidd   = $settings['catsid'];
        $tagid   = $settings['tagsid'];
        $post_order = $settings['post_order'];
        $postbox1 = new \WP_Query(array(
            'posts_per_page' => 3,
            'tax_query' => [
                'relation' => 'OR',
                [
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $catidd,
                ],
                [
                    'taxonomy' => 'post_tag',
                    'field' => 'term_id',
                    'terms' => $tagid,
                ],
            ],
            'order'         =>  $post_order
        ));
        if ($havePost = $postbox1->have_posts()) {
            $counter = 1;
            $classData = [
                '1' => 'grid-post-5-right',
                '2' => 'grid-post-5-left-top',
                '3' => 'grid-post-5-left-bottom',
            ];
            $postData = [];

            while ($postbox1->have_posts()) {
                $postbox1->the_post();
                $postData[] = '<a href="' . get_the_permalink() . '" class="' . $classData[$counter] . '" style="background-image:url(' . get_the_post_thumbnail_url(null, $settings['item_cover_size']) . ');"><h2>' . get_the_title() . '</h2></a>';
                $counter++;
            }
        }
        wp_reset_postdata();
?>

        <?php if ($havePost) : ?>
            <div class="grid-post-5 <?php echo ($settings['show_posts_overlay'] != 'yes') ? 'none-cover-overlay' : '' ?>">
                <?php echo isset($postData[0]) ? $postData[0] : ''; ?>
                <div class="grid-post-5-left">
                    <?php echo isset($postData[1]) ? $postData[1] : ''; ?>
                    <?php echo isset($postData[2]) ? $postData[2] : ''; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="mw_element_error">
                <?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.', 'ahura'); ?>
            </div>
        <?php endif; ?>
<?php
    }
}
