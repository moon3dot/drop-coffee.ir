<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class grid_posts4 extends \Elementor\Widget_Base
{
    /**
     * grid_posts4 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('grid_posts4_css', mw_assets::get_css('elementor.grid_posts4'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('grid_posts4_css')];
    }

    public function get_name()
    {
        return 'gridposts4';
    }

    public function get_title()
    {
        return __('Grid Posts 4', 'ahura');
    }

	public function get_icon() {
		return 'aicon-svg-grid-post-4';
	}

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }
    function get_keywords()
    {
        return ['gridposts4', 'grid_posts_4', esc_html__('Grid Posts 4', 'ahura')];
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

        $this->add_control(
            'author',
            [
                'label'   => __('Author', 'ahura'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'time',
            [
                'label'   => __('Time', 'ahura'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes'
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
                'default' => 'stthumb',
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
                    'size' => 300,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '(desktop){{WRAPPER}} .grid-post4' => 'min-height: {{SIZE}}{{UNIT}}',
                    '(tablet){{WRAPPER}} .grid-post4' => 'min-height: 0;',
                    '(mobile){{WRAPPER}} .grid-post4' => 'min-height: 0;',

                    '(tablet){{WRAPPER}} .grid-post4 .grid-post4-right' => 'min-height: {{items_height_tablet.SIZE}}{{items_height_tablet.UNIT}}',
                    '(tablet){{WRAPPER}} .grid-post4 .grid-post4-left-item' => 'min-height: {{items_height_tablet.SIZE}}{{items_height_tablet.UNIT}}',

                    '(mobile){{WRAPPER}} .grid-post4 .grid-post4-right' => 'min-height: {{items_height_mobile.SIZE}}{{items_height_mobile.UNIT}}',
                    '(mobile){{WRAPPER}} .grid-post4 .grid-post4-left-item' => 'min-height: {{items_height_mobile.SIZE}}{{items_height_mobile.UNIT}}',
                ]
            ]
        );
        $this->add_responsive_control(
            'items_gap',
            [
                'label' => esc_html__('Items gap', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'desktop_defaults' => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'tablet_defaults' => [
                    'size' => 250,
                    'unit' => 'px',
                ],
                'mobile_defaults' => [
                    'size' => 250,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-post4' => 'gap: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .grid-post4 .grid-post4-left' => 'gap: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .grid-post4 .grid-post4-data, {{WRAPPER}} .grid-post4 .grid-post4-title' => 'text-align: {{VALUE}}',
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
                    '{{WRAPPER}} .grid-post4 a h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'items_meta_color',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .grid-post4 .grid-post4-data div' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .grid-post4 a h2',
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
                'selector' => '{{WRAPPER}} .grid-post4 .grid-post4-data div',
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
            'box_items_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post4' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'box_items_details_radius',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .grid-post4 .grid-post4-data' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .grid-post4 .grid-post4-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $catidd   = $settings['catsid'];
        $post_order = $settings['post_order'];
        $postbox1 = new \WP_Query(array(
            'posts_per_page' => 1,
            'cat'            => $catidd,
            'order'         =>  $post_order
        ));
        $postbox2 = new \WP_Query(array(
            'posts_per_page' => 2,
            'cat'            => $catidd,
            'order'         =>  $post_order,
            'offset'         => 1
        ));
        if ($postbox1->have_posts()) : ?>
            <div class="grid-post4">
                <?php while ($postbox1->have_posts()) : $postbox1->the_post(); ?>
                    <a href="<?php the_permalink() ?>" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), $settings['item_cover_size']); ?>')" class="grid-post4-right <?php echo ($settings['show_posts_overlay'] != 'yes') ? 'none-cover-overlay' : '' ?>">
                        <div class="grid-post4-data">
                            <?php if ($settings['author']) : ?>
                                <div class="grid-pots4-author">
                                    <i class="fa fa-user"></i> <?php the_author(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($settings['time']) : ?>
                                <div class="grid-post4-time">
                                    <i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h2 class="grid-post4-title"><?php the_title(); ?></h2>
                    </a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                <?php else:?>
					<div class="mw_element_error">
						<?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
					</div>
            <?php endif; ?>
            <div class="grid-post4-left">
                <?php if ($postbox2->have_posts()) : ?>
                    <?php while ($postbox2->have_posts()) : $postbox2->the_post(); ?>
                        <a href="<?php the_permalink() ?>" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), $settings['item_cover_size']); ?>')" class="grid-post4-left-item <?php echo ($settings['show_posts_overlay'] != 'yes') ? 'none-cover-overlay' : '' ?>">
                            <div class="grid-post4-data">
                                <?php if ($settings['author']) : ?>
                                    <div class="grid-pots4-author">
                                        <i class="fa fa-user"></i> <?php the_author(); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($settings['time']) : ?>
                                    <div class="grid-post4-time">
                                        <i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h2 class="grid-post4-title"><?php the_title(); ?></h2>
                        </a>
                    <?php endwhile; ?>
            </div>
            </div>
            <?php wp_reset_postdata(); ?>
            <?php else:?>
					<div class="mw_element_error">
						<?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
					</div>
        <?php endif; ?>
<?php
    }
}
