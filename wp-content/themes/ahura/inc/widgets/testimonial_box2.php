<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class testimonial_box2 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ahura_testimonial_box2';
	}

	public function get_title() {
		return __( 'Testimonial Box 2', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-testimonial-box-2';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['testimonial_box2', 'testimonialbox2', esc_html__( 'Testimonial Box 2' , 'ahura')];
	}
	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		$testimonial_box2_css = mw_assets::get_css('elementor.testimonial_box2');
		mw_assets::register_style('testimonial_box2', $testimonial_box2_css);
	}
	function get_style_depends()
	{
		return [mw_assets::get_handle_name('testimonial_box2')];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$args = [
			'post_type' => 'testimonial',
			'number' => '-1'
		];
		$data = new \WP_Query($args);
		$options = [];
		if($data->have_posts())
		{
			while($data->have_posts())
			{
				$data->the_post();
				$options[get_the_ID()] = get_the_title(get_the_ID());
			}
		}
		wp_reset_postdata();
		$default = $options && is_array($options) ? key($options) : false;
		$this->add_control(
			'tst_id',
			[
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label' => __("Testimonial", 'ahura'),
				'label_block' => true,
				'options' => $options,
				'default' => $default
			]
		);

        $alignment_options = array(
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
            'text_alignment',
            [
                'label' => __('Text Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => is_rtl() ? 'right' : 'left',
                'options' => is_rtl() ? $alignment_options : array_reverse($alignment_options),
                'toggle' => true,
                'selectors' => [
                        '{{WRAPPER}} .content_wrapper p' => 'text-align: {{VALUE}}'
                ]
            ]
        );

		$this->add_control(
			'user_data_alignment',
			[
				'label' => __('User Data Alignment', 'ahura'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => is_rtl() ? $alignment_options : array_reverse($alignment_options),
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .content_wrapper .meta' => 'text-align: {{VALUE}}'
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
            'cover_styles',
            [
                'label' => __( 'Cover', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'cover_overlay_background',
            [
                'label' => __("Cover overlay background color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cover .overlay' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cover_background',
                'selector' => '{{WRAPPER}} .cover',
                'fields_options' =>
                    [
                        'background' => [
                            'default' => 'classic'
                        ],
                        'color' =>
                            [
                                'default' => '#304980'
                            ]
                    ]
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

        $this->add_control(
            'txt_color',
            [
                'label' => __("Text Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .content *' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Text Typography', 'ahura'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .content_wrapper p',
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
            'meta_color',
            [
                'label' => __("Meta Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .content_wrapper .meta span' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Text Typography', 'ahura'),
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .meta span',
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

        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_background_color',
            [
                'label' => __('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3A5EAF',
                'selectors' => [
                    '{{WRAPPER}} .content_wrapper' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .avatar' => 'border-color: {{VALUE}}'
                ]
            ]
        );

        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-box2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .testimonial-box2',
            ]
        );

        $this->end_controls_section();
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$pid = $settings['tst_id'];
		$content = get_post_field('post_content', $pid);
		$user_display_name = \ahura\app\mw_options::get_testimonial_username($pid);
		$sitename = \ahura\app\mw_options::get_testimonial_sitename($pid);
		$thumbnail_url = get_the_post_thumbnail_url($pid, 'thumbnail');

		if($pid):
		?>
		<div class="testimonial-box2">
			<div class="cover">
				<div class="avatar" style="background-image: url('<?php echo $thumbnail_url; ?>')"></div>
				<div class="overlay"></div>
			</div>
			<div class="content_wrapper">
				<div class="content">
					<p><?php echo $content;?></p>
				</div>
				<div class="meta">
					<span class="username"><?php echo $user_display_name?></span>
					<span class="sitename"><?php echo $sitename?></span>
				</div>
			</div>
		</div>
		<?php else: ?>
            <div class="mw_element_error">
                <?php echo esc_html__('Sorry, no testimonial were found for display.', 'ahura'); ?>
            </div>
		<?php
		endif;
	}

}
