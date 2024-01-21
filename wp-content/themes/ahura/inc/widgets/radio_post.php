<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class radio_post extends \Elementor\Widget_Base {
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $radio_post_css = mw_assets::get_css('elementor.radio_post');
        mw_assets::register_style('radio_post', $radio_post_css);
    }

	public function get_name() {
		return 'radiopost';
	}

	public function get_title() {
		return __( 'Radio Post', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-radio-post';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['radio_post', 'radiopost', esc_html__( 'Radio Post' , 'ahura')];
	}

	function get_style_depends()
	{
		return [mw_assets::get_handle_name('radio_post')];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$categories = get_categories();
		$cats       = array();
		foreach ( $categories as $category ) {
			$cats[ $category->term_id ] = $category->name;
		}
		$default = key($cats);
		$this->add_control(
			'catsid',
			[
				'label'    => __( 'Categories', 'ahura' ),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'options'  => $cats,
				'label_block' => true,
				'multiple' => false,
				'default' => $default
			]
		);

		$this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'stthumb',
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
                    '{{WRAPPER}} .radio-post-box img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
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
		 * Styles
		 * 
		 *
		 */
		$this->start_controls_section(
			'cover_styles',
			[
				'label' => __( 'Cover', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $position = [
            'row' => [
                'title' => __('Left', 'ahura'),
                'icon' => 'eicon-h-align-left'
            ],
            'row-reverse' => [
                'title' => __('Right', 'ahura'),
                'icon' => 'eicon-h-align-right'
            ]
        ];

        $this->add_control(
            'box_img_alignment',
            [
                'label' => esc_html__('Position', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => is_rtl() ? array_reverse($position) : $position,
                'default' => 'row',
                'selectors' => [
                    '{{WRAPPER}} .radio-post-box' => 'flex-direction: {{VALUE}};'
                ],
            ]
        );

		$this->add_responsive_control(
            'box_img_width',
            [
                'label' => esc_html__('Cover Width', 'ahura'),
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
                  'size' => 100,
                  'unit' => '%'
                ],
                'selectors' => [
                    '{{WRAPPER}} .radio-post-box img' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

		$this->add_responsive_control(
            'box_img_height',
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
                    'size' => 300,
                    'unit' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .radio-post-box img' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'img_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .radio-post-box img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'img_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .radio-post-box img',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .radio-post-box img',
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'content_styles',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
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

        $this->add_responsive_control(
            'item_details_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .radio-post-right' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'catcolor',
            [
                'label'   => __( 'Category Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495c',
                'selectors' => [
                    '{{WRAPPER}} .radio-post-right h2' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Typography', 'ahura'),
                'name' => 'cat_typography',
                'selector' => '{{WRAPPER}} .radio-post-right h2',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '17',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_control(
            'titlecolor',
            [
                'label'   => __( 'Post Title Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#4c4c4c',
                'selectors' => [
                    '{{WRAPPER}} .radio-post-right h3' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title Typography', 'ahura'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .radio-post-right h3',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '20',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'   => __( 'Excerpt Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#777',
                'selectors' => [
                    '{{WRAPPER}} .radio-post-right .post-excerpt' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Excerpt Typography', 'ahura'),
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .radio-post-right .post-excerpt',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '14',
                            ]
                        ],
                    ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'btn_styles',
            [
                'label' => __( 'Button', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'btx_text_color',
            [
                'label'   => __( 'Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .radio-post-right a' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Typography', 'ahura'),
                'name' => 'btn_typography',
                'selector' => '{{WRAPPER}} .radio-post-right a',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '15',
                            ]
                        ],
                    ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'bntbackground',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .radio-post-right a',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#673AB7'
                        ],
                ]
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .radio-post-right a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .radio-post-right a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .radio-post-right a',
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
        <?php $the_query = new \WP_Query(array(
            'posts_per_page' => 1,
            'cat' =>$settings['catsid'],
        ));
         if ( $the_query->have_posts() ):
         while ( $the_query->have_posts() ) : $the_query->the_post();
        ?>
        <div class="radio-post-box">
            <div class="radio-post-right">
                <h2><?php echo get_cat_name($settings['catsid']);?></h2>
                <h3><?php the_title();?></h3>
                <?php if ($settings['show_excerpt'] === 'yes'): ?>
                <div class="post-excerpt">
                    <?php the_excerpt() ?>
                </div>
                <?php endif; ?>
                <a href="<?php the_permalink()?>">نمایش نوشته</a>
            </div>
            <div class="radio-post-left">
                <?php the_post_thumbnail($settings['item_cover_size']);?>
            </div>
        </div>
        <?php 
            endwhile;
            endif;
        ?>
		<?php
	}
}
