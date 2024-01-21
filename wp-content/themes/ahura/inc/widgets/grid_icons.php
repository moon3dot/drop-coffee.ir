<?php
namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

class grid_icons extends \Elementor\Widget_Base {
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('gridiconscss', mw_assets::get_css('elementor.grid_icons'));
    }

	public function get_name() {
		return 'ahura_gridicons';
	}

	public function get_title() {
		return __( 'Grid Icons', 'ahura' );
	}

	public function get_icon() {
		return 'eicon-apps';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}

	function get_keywords()
	{
		return [ 'grid icons', 'icons', 'grid', esc_html__( 'grid icons' , 'ahura' ), esc_html__( 'icons' , 'ahura' ) ];
	}

	function get_style_depends()
	{
		return [ mw_assets::get_handle_name( 'gridiconscss' ) ];
	}
    
	protected function register_controls() {

		$this->start_controls_section(
			'general_section', [
				'label' => __( 'General', 'ahura' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image', [
				'label'   => __( 'Logo', 'ahura' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'link', [
				'label'       => __( 'URL', 'ahura' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$repeater->add_control(
			'name', [
				'label'       => __( 'Brand Name', 'ahura' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Brand Name', 'ahura' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'logo_list', [
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => [['name' => 'Item #1'], ['name' => 'Item #2']],
			]
		);

		$this->add_control(
			'grid_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'row-reverse' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .ahura-logo-grid-wrapper' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(), [
				'name'      => 'thumbnail',
				'default'   => 'large',
				'separator' => 'before',
				'exclude'   => [
					'custom',
				],
			]
		);

		$this->add_responsive_control(
			'columns', [
				'label'           => __( 'Columns', 'ahura' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => [
					100 	=> __( '1', 'ahura' ),
					50 		=> __( '2', 'ahura' ),
					33		=> __( '3', 'ahura' ),
					25 		=> __( '4', 'ahura' ),
					20 		=> __( '5', 'ahura' ),
					16		=> __( '6', 'ahura' ),
				],
				'desktop_default' => 25,
				'tablet_default'  => 50,
				'mobile_default'  => 50,
				'selectors'  => [
					'{{WRAPPER}} .ahura-logo-grid-item' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section', [
				'label' => __( 'General', 'ahura' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'height', [
				'label'      => __( 'Height', 'ahura' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 500,
						'min' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ahura-logo-grid-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'grid_border_type', [
				'label'     => __( 'Border Type', 'ahura' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'   => __( 'None', 'ahura' ),
					'solid'  => __( 'Solid', 'ahura' ),
					'double' => __( 'Double', 'ahura' ),
					'dotted' => __( 'Dotted', 'ahura' ),
					'dashed' => __( 'Dashed', 'ahura' ),
				],
				'default'   => 'solid',
				'selectors' => [
					'{{WRAPPER}} .ahura-logo-grid-item' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'grid_bg_color', [
				'label'     => __( 'Background Color', 'ahura' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ahura-logo-grid-figure' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin', [
				'label'      => __( 'Margin', 'ahura' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-logo-grid-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding', [
				'label'      => __( 'Padding', 'ahura' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ahura-logo-grid-figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'image_effects', [
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'image_effects_normal', [
				'label' => __( 'Normal', 'ahura' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(), [
				'name'     => 'image_css_filters',
				'selector' => '{{WRAPPER}} .ahura-logo-grid-figure img',
			]
		);

		$this->add_control(
			'image_opacity', [
				'label'     => __( 'Opacity', 'ahura' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ahura-logo-grid-figure img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover', [
				'label' => __( 'Hover', 'ahura' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(), [
				'name'     => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .ahura-logo-grid-figure:hover img',
			]
		);

		$this->add_control(
			'image_opacity_hover', [
				'label'     => __( 'Opacity', 'ahura' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ahura-logo-grid-figure:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation', [
				'label'       => __( 'Hover Animation', 'ahura' ),
				'type'        => Controls_Manager::HOVER_ANIMATION,
				'label_block' => true,
			]
		);

		$this->add_control(
			'image_bg_hover_transition', [
				'label'     => __( 'Transition Duration', 'ahura' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ahura-logo-grid-figure:hover img' => 'transition-duration: {{SIZE}}s;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        $wid = $this->get_id(); ?>

        <div class="ahura-grid-icons-<?php echo $wid; ?>">
			<div class="ahura-logo-grid-wrapper d-flex flex-wrap">
			<?php foreach ( $settings['logo_list'] as $index => $item ) :
				$image        = wp_get_attachment_image_url( $item['image']['id'], $settings['thumbnail_size'] );
				$repeater_key = 'grid_item' . $index;
				$html_tag     = 'div';
				$this->add_render_attribute( $repeater_key, 'class', 'ahura-logo-grid-item' );

				if ( $item['link']['url'] ) {
					$html_tag = 'a';
					$this->add_render_attribute( $repeater_key, 'class', 'ahura-logo-grid-link' );
					$this->add_link_attributes( $repeater_key, $item['link'] );
				} ?>
			<<?php echo esc_attr( $html_tag ); ?> <?php $this->print_render_attribute_string( $repeater_key ); ?>>
			<figure class="ahura-logo-grid-figure">
				<?php
				if ( $image ) {
					echo wp_get_attachment_image( $item['image']['id'], $settings['thumbnail_size'], false, ['class' => 'ahura-logo-grid-img elementor-animation-' . esc_attr( $settings['hover_animation'] )] );
				} else {
					printf( '<img class="ahura-logo-grid-img elementor-animation-%s" src="%s" alt="%s">', esc_attr( $settings['hover_animation'] ), esc_url( $item['image']['url'] ), esc_attr( $item['name'] ) );
				}
				?>
			</figure>
		</<?php echo esc_attr( $html_tag ); ?>>
		<?php endforeach; ?>

		</div>
        </div>

	   <?php
    }
}
