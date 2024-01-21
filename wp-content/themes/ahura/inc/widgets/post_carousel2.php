<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class post_carousel2 extends \Elementor\Widget_Base {
    /**
     * post_carousel2 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
		mw_assets::register_style('owl_carousel_css', mw_assets::get_css('owl-carousel'));
        mw_assets::register_script('owl_carousel_js', mw_assets::get_js('owl-carousel-min'));
        mw_assets::register_style('post_carousel2_css', mw_assets::get_css('elementor.post_carousel2'));
        mw_assets::register_script('post_carousel2_js', mw_assets::get_js('elementor.post_carousel2'));
        if (!is_rtl()) {
            mw_assets::register_style('post_carousel2_ltr_css', mw_assets::get_css('elementor.ltr.post_carousel2_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('post_carousel2_css'), mw_assets::get_handle_name('owl_carousel_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('post_carousel2_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('owl_carousel_js'), mw_assets::get_handle_name('post_carousel2_js')];
    }

	public function get_name() {
		return 'postcarousel2';
	}

	public function get_title() {
		return __( 'Post Carousel 2', 'ahura' );
	}

    public function get_icon() {
		return 'aicon-svg-post-carousel-2';
	}

	public function get_categories() {
		return [ 'ahuraelements', 'ahura_posts' ];
	}
	function get_keywords()
	{
		return ['post_carousel2', 'postcarousel2', esc_html__( 'Post Carousel 2' , 'ahura')];
	}

	public function register_controls() {
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
				'multiple' => true,
				'default'	=>	$default
			]
		);

		$this->add_control(
			'date',
			[
				'label'   => __( 'Show Date', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
                    'yes' => [ 'title' => __( 'Yes', 'ahura' ), 'icon' => 'eicon-check' ],
                    'no'  => [ 'title' => __( 'No', 'ahura' ), 'icon' => 'eicon-close' ]
				],
				'default' => 'yes'
			]
		);

		$this->add_control(
			'count',
			[
				'label'      => __( 'Number of posts', 'ahura' ),
				'type'       => \Elementor\Controls_Manager::NUMBER,
				'default'    => 8
			]
		);

		$this->add_control(
			'post_order',
			[
				'label' => __('Sort', 'ahura'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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

        $this->add_control(
            'show_slider_btn',
            [
                'label' => esc_html__('Slider Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .owl-carousel .owl-nav' => 'display:block;'
                ]
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
			'content_styles',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
            'box_height',
            [
                'label' => esc_html__('Height', 'ahura'),
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
                'selectors' => [
                    '{{WRAPPER}} .carousel2post' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

		// overlay color
		$this->add_control(
			'slide_overlay_color',
			[
				'label'   => __( 'Overlay color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000cc',
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-2 .carousel2post > a' => 'background-image: linear-gradient(360deg, {{VALUE}} 0%, transparent 50%)',
				],
			]
		);

		// title heading
		$this->add_control(
			'slide_title_style_heading',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		// title color
		$this->add_control(
			'slide_title_color',
			[
				'label'   => __( 'Title Color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-2 .carousel2post a .details h2' => 'color: {{VALUE}};',
				],
			]
		);
		// title typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'slide_title_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ah-slider-post-2 .carousel2post a .details h2',
                'fields_options' => [
					'typography' => ['default' => 'yes',],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 20,
                        ],
                    ],
					'font_weight' => [
						'default' => 'bold',
					],
                ],
			]
		);
		
		// meta heading
		$this->add_control(
			'slide_meta_data_style_heading',
			[
				'label' => esc_html__( 'Meta data', 'ahura' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		// title color
		$this->add_control(
			'slide_meta_data_color',
			[
				'label'   => __( 'Text color', 'ahura' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .ah-slider-post-2 .carousel2post a .details > span' => 'color: {{VALUE}};',
				],
			]
		);
		// title typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'slide_meta_data_typography',
                'label' => esc_html__('Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ah-slider-post-2 .carousel2post a .details > span',
                'fields_options' => [
					'typography' => ['default' => 'yes',],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'slider_button_style',
            [
                'label' => esc_html__('Slider button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_slider_btn' => 'yes'
                ]
            ]
        );
        // color
        $this->add_control(
            'slider_btn_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-nav i.fa' => 'color: {{VALUE}};'
                ],
                'default' => '#181522',
            ]
        );

        // bg color
        $this->add_control(
            'slider_btn_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-nav i.fa' => 'background-color: {{VALUE}};'
                ],
                'default' => '#ffffff',
            ]
        );

        // typography
        $this->add_responsive_control(
            'slider_btn_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 23,
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-nav i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // border-radius
        $this->add_control(
            'slider_next_btn_border_radius',
            [
                'label' => esc_html__( 'Next button border radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .owl-nav i.fa' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 50,
                    'bottom' => 50,
                    'right' => 50,
                    'left' => 50,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_control(
            'slider_prev_btn_border_radius',
            [
                'label' => esc_html__( 'Previous button border radius', 'ahura' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .owl-prev i.fa' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 50,
                    'bottom' => 50,
                    'right' => 50,
                    'left' => 50,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$wid = $this->get_id();
		$postbox5 = new \WP_Query ( array(
			'posts_per_page' => $settings['count'],
			'cat'            => $settings['catsid'],
            'order'         =>  $settings['post_order']
		) );
		if ( $postbox5->have_posts() ) : ?>
            <div class="ah-slider-post-2 post-carousel2 post-carousel2-<?php echo $wid ?>">
                <div class="owl-carousel owl-post-carousel2">
					<?php while ( $postbox5->have_posts() ) : $postbox5->the_post(); ?>
						<?php
						$thumb_id  = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src( $thumb_id, $settings['item_cover_size'], true );
						?>
                        <div class="carousel2post grid-post-grey" style="background-image:url('<?php echo $thumb_url[0]; ?>');">
							<a href="<?php the_permalink(); ?>">
								<div class="details">
									<h2><?php the_title(); ?></h2>
									<?php if ( $settings['date'] == 'yes' ) : ?>
										<span><i class="fa fa-clock"></i> <?php echo get_the_date( 'd F Y' ); ?></span>
									<?php endif; ?>
								</div>
							</a>
                        </div>
					<?php endwhile; ?>
				</div>
            </div>
			<?php wp_reset_postdata(); ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    handlePostCarousel2Element({widgetID: '<?php echo $wid ?>'});
                });
            </script>
			<?php else:?>
                <div class="ahura-element-msg">
                    <?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
                </div>
		<?php endif; ?>
        <div class="clear"></div>
		<?php
	}

}
