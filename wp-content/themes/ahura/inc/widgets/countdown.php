<?php
namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class countdown extends \Elementor\Widget_Base {
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('countdowncss', mw_assets::get_css('elementor.countdown'));
        mw_assets::register_style('flipcss', mw_assets::get_css('flip-clock'));
        $flipJs = mw_assets::get_js('flipclock-min');
        mw_assets::register_script('flipjs', $flipJs);
        wp_localize_script(mw_assets::get_handle_name('flipjs'), 'fpc_data', array(
            'translate' => [
                'day' => __('Day', 'ahura'),
                'hour' => __('Hour', 'ahura'),
                'minute' => __('Minute', 'ahura'),
                'seconds' => __('Seconds', 'ahura'),
            ]
        ));
    }

	public function get_name() {
		return 'ahura_countdown';
	}

	public function get_title() {
		return __( 'Shop CountDown2', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-countdown';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['countdown_element', 'countdown', 'countdown', esc_html__( 'Shop CountDown2' , 'ahura')];
	}

	function get_style_depends()
	{
		return [mw_assets::get_handle_name('flipcss')];
	}
	function get_script_depends()
	{
		return [mw_assets::get_handle_name('flipjs')];
	}
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __("Title Here", 'ahura')
			]
		);

		$this->add_control(
		'time',
		[
			'label' => __( 'Time', 'ahura' ),
			'type' => \Elementor\Controls_Manager::DATE_TIME,
			'default' => date('Y-m-d H:i:s', strtotime('+1 month'))
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
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'titlecolor',
            [
                'label' => __( 'Title Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495c',
                'selectors' =>
                    [
                        '{{WRAPPER}} .flip-clock-box-title' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'items_title_typography',
                'selector' => '{{WRAPPER}} .flip-clock-box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '24',
                        ]
                    ]
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'timer_styles',
            [
                'label' => __( 'Timer', 'ahura' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'textcolor',
            [
                'label' => __( 'Number Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'white',
                'selectors' =>
                    [
                        '{{WRAPPER}} .flip-clock-wrapper ul li a div' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'labelcolor',
            [
                'label' => __( 'Label Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' =>
                    [
                        '{{WRAPPER}} .flip-clock-label' => 'color: {{VALUE}}',
                    ]
            ]
        );

        $this->add_control(
            'timer_bg_color',
            [
                'label' => __( 'Background Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' =>
                    [
                        '{{WRAPPER}} .flip-clock-wrapper ul li a div div.inn' => 'background-color: {{VALUE}}',
                    ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'backgroundcolor',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .flip-clock-box',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#fff'],
                ]
            ]
        );

        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .flip-clock-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .flip-clock-box',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 2,
                            'spread' => 0,
                            'color' => 'rgb(0 0 0 / 6%)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('title', 'none');
		$el_id = $this->get_id();
    ?>
    <script type="text/javascript">
		jQuery(document).ready(function($) {
			var clock, currentDate, diff, futureDate, setcount;
			currentDate = new Date;
			futureDate = new Date('<?php echo $settings['time'] ?>');
			diff = futureDate.getTime() / 1000 - (currentDate.getTime() / 1000);
			if (diff > -1) {
				setcount = diff;
			} else {
				setcount = 0;
			}
			clock = $('#clock-<?php echo $el_id ?>').FlipClock(setcount, {
				clockFace: 'DailyCounter',
				countdown: true,
			});
			if (diff < setcount) {
				document.getElementById('flipclock').innerHTML = '<?php echo __('Finished!', 'ahura') ?>'
			}
		});
    </script>
		<div class="ahura-countdown-element flip-clock-box">
            <h2 class="flip-clock-box-title"><?php echo $settings['title']; ?></h2>
            <div class="box" id="flipclock">
              <div class="clock" id="clock-<?php echo $el_id ?>"></div>
            </div>
        </div>
	   <?php
  }
}
