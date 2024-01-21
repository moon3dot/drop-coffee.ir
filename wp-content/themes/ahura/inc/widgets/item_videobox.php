<?php
namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class item_videobox extends \Elementor\Widget_Base {
	use \ahura\app\traits\mw_elementor;
	
	public function get_name() {
		return 'item_videobox';
	}

	public function get_title() {
		return __( 'Video Box', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-item-videobox';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['item_videobox', 'itemvideobox', esc_html__( 'Video Box' , 'ahura')];
	}
    
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
		mw_assets::register_style('videobox_widget_style', mw_assets::get_css('elementor.video_box'));
    }
 
    public function get_style_depends() {
		return [ mw_assets::get_handle_name('videobox_widget_style') ];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'image_section',
			[
				'label' => __( 'Image', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'item_image',
			[
				'label' => esc_html__( 'Choose Image', 'ahura' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'btn_link',
            [
                'label' => __( 'Button link', 'ahura' ),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => site_url(),
                    'is_external' => true,
                    'nofollow' => true,
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

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__( 'Height', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
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
                'selectors' => [
                    '{{WRAPPER}} .videbox_content' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400,
                ]
            ]
        );

        $this->add_control(
            'image_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .videbox_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'image_position',
            [
                'label' => __( 'Images Position', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'initial',
                'options' => [
                    'initial'  => __( 'initial', 'ahura' ),
                    'left' => __( 'left', 'ahura' ),
                    'right' => __( 'right', 'ahura' ),
                    'top' => __( 'top', 'ahura' ),
                    'bottom' => __( 'bottom', 'ahura' ),
                    'center' => __( 'center', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .videbox_content' => 'background-position: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .videbox_content',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'btn_styles',
            [
                'label' => __( 'button', 'ahura' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'ahura' ),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

        $elementClass = 'icon_player';
		if ( $settings['hover_animation'] ) {
			$elementClass .= ' elementor-animation-' . $settings['hover_animation'];
		}
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );

        if ( ! empty( $settings['btn_link']['url'] ) ) {
            $this->add_link_attributes( 'btn_link', $settings['btn_link'] );
        }

        $image = $settings['item_image'];
        $bg = '';
        if (!empty($image['url'])){
            $bg = $image['url'];
        } elseif(!empty($image['id'])) {
            $bg = wp_get_attachment_image_url($image['id']);
        }
		?>
        <div class="item-videobox-element videbox_content" style="background-image: url(<?php echo $bg ?>);">
            <a <?php echo $this->get_render_attribute_string( 'btn_link' ); ?>>
                <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/play.svg');"></div>
            </a>
        </div>
		<?php
	}

}
