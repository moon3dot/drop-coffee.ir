<?php
namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class charts extends \Elementor\Widget_Base {
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('chartcss', mw_assets::get_css('elementor.charts'));
    }

	public function get_name() {
		return 'ahura_chart';
	}

	public function get_title() {
		return __( 'Chart', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-image-box';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}

	function get_keywords()
	{
		return [ 'countdown_element', 'countdown', 'countdown', esc_html__( 'charts' , 'ahura' ) ];
	}

	function get_style_depends()
	{
		return [ mw_assets::get_handle_name( 'chartcss' ) ];
	}
    
	protected function register_controls() {
		$this->start_controls_section(
			'section_general', [
				'label' => __( 'General', 'ahura' ),
			]
		);

        $this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '20', 'ahura' ),
			]
		);

        $this->add_control(
			'percent',
			[
				'label' => esc_html__( 'Percent', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 20,
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'tilte_section',
            [
                'label' => esc_html__('General', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pie' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'gold'
			]
		);

        $this->add_control(
			'border',
			[
				'label' => esc_html__( 'Border', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
			]
		);

        $this->add_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
			]
		);
		
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        $wid = $this->get_id(); ?>

        <div class="pie-charts-<?php echo $wid; ?>">
            <div class="pie animate no-round" style="--percent:<?php echo $settings[ 'percent' ]; ?>;--color:<?php echo $settings[ 'border_color' ]; ?>;--border:<?php echo $settings[ 'border' ][ 'size' ] . 'px'; ?>;--width:<?php echo $settings[ 'width' ][ 'size' ] . 'px'; ?>"><?php echo $settings[ 'title' ]; ?></div>
        </div>

	   <?php
    }
}
