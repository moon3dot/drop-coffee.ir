<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class post_list4 extends \Elementor\Widget_Base
{
    /**
     * post_list4 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('post_list4_css', mw_assets::get_css('elementor.post_list4'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('post_list4_css')];
    }

    public function get_name()
    {
        return 'postlist4';
    }

    public function get_title()
    {
        return __('Post List 4', 'ahura');
    }

    public function get_icon() {
		return 'aicon-svg-post-list4';
	}

    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }

    function get_keywords()
	{
		return ['post_list_4', 'postlist4', esc_html__( 'Post List 4' , 'ahura')];
	}

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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
                'type'     => \Elementor\Controls_Manager::SELECT2,
                'options'  => $cats,
                'label_block' => true,
                'multiple' => true,
                'default' => $default
            ]
        );
        $this->add_control(
            'postcount',
            [
                'label'      => __('Number of posts', 'ahura'),
                'type'       => \Elementor\Controls_Manager::NUMBER,
                'default'    => 3
            ]
        );
        $this->add_control(
            'title',
            [
                'label'      => __('Title', 'ahura'),
                'type'       => \Elementor\Controls_Manager::TEXT,
                'default'    => __('Title Here', 'ahura'),
            ]
        );
        $this->add_control(
            'description',
            [
                'label'      => __('Description', 'ahura'),
                'type'       => \Elementor\Controls_Manager::TEXTAREA,
                'default'    => __('Description Here', 'ahura'),
            ]
        );

        $this->add_control(
			'btn_options',
			[
				'label' => esc_html__( 'Button', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'linktxet',
            [
                'label'      => __('Title', 'ahura'),
                'type'       => \Elementor\Controls_Manager::TEXT,
                'default'    => __('Title Here', 'ahura'),
            ]
        );

        $this->add_control(
            'linkurl',
            [
                'label'      => __('Url', 'ahura'),
                'type'       => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
			'article_options',
			[
				'label' => esc_html__( 'Article', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'show_post_title',
            [
                'label' => esc_html__('Show Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
                
        $this->add_control(
            'show_icon',
            [
                'label' => esc_html__('Show Icon', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
			'post_icon',
			[
				'label' => esc_html__('Icon', 'ahura'),
				'type' => \Elementor\Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
				'default' => [
					'value' => 'fas fa-play-circle',
					'library' => 'fa-solid',
				],
                'condition' => [
                    'show_icon' => 'yes'
                ]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'sqthumb',
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
         */
        $this->start_controls_section(
            'btns_styles',
            [
                'label' => __('Button', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'link_bg_color',
                'label' => esc_html__('Background', 'ahura'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .post-list-4-link',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#ffc33a'],
                ]
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __("Text Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495c',
                'selectors' => [
                    '{{WRAPPER}} .post-list-4-link' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'selector' => '{{WRAPPER}} .post-list-4-link',
                'fields_options' =>
                [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-4-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 4,
                    'right' => 4,
                    'bottom' => 4,
                    'left' => 4,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'linktextshdow',
                'selector' => "{{WRAPPER}} .post-list-4-link"
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'article_cover_styles',
            [
                'label' => __('Cover', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'img_height',
            [
                'label' => esc_html__('Cover Height', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
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
                    'size' => 357,
                    'unit' => 'px',
                ],
                'desktop_default' => [
                    'size' => 357,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 357,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 357,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-list-4-item img' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'post_cover_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-4-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 0,
                    'left' => 0,
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'article_styles',
            [
                'label' => __('Article', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $alignment = [
            'left' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-text-align-left'
            ],
            'center' => [
                'title' => __('Center', 'ahura'),
                'icon' => 'eicon-text-align-center'
            ],
            'right' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-text-align-right'
            ]
        ];

        $this->add_control(
            'post_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => 'right',
                'selectors' => [
                    '{{WRAPPER}} .post-list-4-post-title' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'show_post_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'post_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 70
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .post-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'post_icon_color',
            [
                'label' => __("Icon Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} a.post-list-4-item .post-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} a.post-list-4-item .post-icon svg' => 'fill: {{VALUE}}'
                ],
                'condition' => [
                    'show_icon' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'post_title_color',
            [
                'label' => __("Title Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .post-list-4-post-title h3' => 'color: {{VALUE}}'
                ],
                'condition' => [
                    'show_post_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_title_typography',
                'label' => __("Title Typography", "ahura"),
                'selector' => '{{WRAPPER}} .post-list-4-post-title h3',
                'fields_options' =>[
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '22'
                        ]
                    ]
                ],
                'condition' => [
                    'show_post_title' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'post_box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} a.post-list-4-item',
            ]
        );

        $this->add_control(
            'post_item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} a.post-list-4-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} a.post-list-4-item',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 30,
                            'spread' => 0,
                            'color' => 'rgba(70, 72, 77, .08)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();

         $this->start_controls_section(
            'box_wrap_styles',
            [
                'label' => __('Box', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'items_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					' d-flex align-items-center justify-content-end' => [
						'title' => esc_html__( 'left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
					' d-flex align-items-center justify-content-center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					' d-flex align-items-center justify-content-start' => [
						'title' => esc_html__( 'right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'right',
				'toggle' => true,
			]
		);

        $this->add_control(
            'title_color',
            [
                'label' => __("Title Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .post-list-4-title' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __("Title Typography", "ahura"),
                'selector' => '{{WRAPPER}} .post-list-4-title',
                'fields_options' =>
                [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '32'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __("Description Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .post-list-4-description' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __("Description Typography", "ahura"),
                'selector' => '{{WRAPPER}} .post-list-4-description',
                'fields_options' =>
                [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} a.post-list-4-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $catidd   = $settings['catsid'];
        $show_post_title = $settings['show_post_title'] == 'yes';
        $show_icon = $settings['show_icon'] == 'yes';
        $postbox1 = new \WP_Query(array(
            'posts_per_page' => $settings['postcount'],
            'cat'            => $catidd,
            'post_status' => 'publish',
        ));

        $classes = $settings['items_align'];

        if(!in_array($classes, ['right', 'left', 'center'])){
            $classes = explode(' ', $settings['items_align']);
            unset($classes[1]);
            $classes = implode(' ', $classes);
        }

        if ($postbox1->have_posts()) : ?>
            <div class="post-list-4">
                <div class="post-list-4-top-box">
                    <div class="post-list-top-box-right">
                        <div class="post-list-4-title">
                            <?php echo $settings['title']; ?>
                        </div>
                        <div class="post-list-4-description">
                            <?php echo $settings['description']; ?>
                        </div>
                    </div>
                    <div class="post-list-4-top-box-left">
                        <a href="<?php echo $settings['linkurl']['url']; ?>" class="post-list-4-link"><?php echo $settings['linktxet']; ?></a>
                    </div>
                </div>
                <div class="post-list-4-items <?php echo $classes; ?>">
                    <?php while ($postbox1->have_posts()) : $postbox1->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="post-list-4-item <?php echo !$show_post_title ? ' without-title' : '' ?>">
                            <div class="post-list-4-thumbnail d-flex justify-content-center align-items-start">
                                <?php if($show_icon): ?>
                                    <div class="post-icon">
                                    <?php \Elementor\Icons_Manager::render_icon($settings['post_icon'], [ 'aria-hidden' => 'true' ]); ?>
                                    </div>
                                <?php endif; ?>
                                <?php the_post_thumbnail($settings['item_cover_size']) ?>
                            </div>
                            <?php if($show_post_title): ?>
                                <div class="post-list-4-post-title">
                                    <h3><?php the_title(); ?></h3>
                                </div>
                            <?php endif; ?>
                        </a>
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
