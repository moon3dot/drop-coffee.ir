<?php
namespace ahura\inc\widgets;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class shop_countdown extends \Elementor\Widget_Base {
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('ahura_shopcountdown_css', mw_assets::get_css('elementor.shop_countdown'));
        mw_assets::register_script('ahura_shopcountdown_js', mw_assets::get_js('widget_shopcountdown'));
        wp_localize_script(mw_assets::get_handle_name('ahura_shopcountdown_js'), 'wsc_data', array(
            'translate' => [
                'day' => __('Day', 'ahura'),
                'hour' => __('Hour', 'ahura'),
                'minute' => __('Minute', 'ahura'),
                'seconds' => __('Seconds', 'ahura'),
                'finished' => __('Finished!', 'ahura'),
            ]
        ));
    }

	public function get_name() {
		return 'mwcountdown';
	}
  
	public function get_title() {
		return __( 'Shop CountDown', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-shop-countdown';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['shop_countdown', 'shopcountdown', esc_html__( 'Shop CountDown' , 'ahura')];
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
            'textcolor',
            [
                'label' => __( 'Text Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' =>
                    [
                        '{{WRAPPER}} .countdownbox span' => 'color: {{VALUE}}',
                        '{{WRAPPER}} #mwtimercountdown li' => 'color: {{VALUE}}',
                        '{{WRAPPER}} #mwtimercountdown li span' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title Typography', 'ahura'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .countdownbox span',
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
                        'font_weight' => [
                            'default' => 'bold'
                        ],
                    ],
            ]
        );

        $this->add_control(
            'timer_textcolor',
            [
                'label' => __( 'Timer Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' =>
                    [
                        '{{WRAPPER}} .countdownbox #mwtimercountdown li' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .countdownbox #mwtimercountdown li span' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Timer Typography', 'ahura'),
                'name' => 'timer_typography',
                'selector' => '{{WRAPPER}} #mwtimercountdown li, {{WRAPPER}} #mwtimercountdown li span',
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
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'color',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .countdownbox',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#4054B2'],
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
                    '{{WRAPPER}} .countdownbox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__( 'Padding', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .countdownbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .countdownbox',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 5,
                            'blur' => 10,
                            'spread' => 0,
                            'color' => '#00000054'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
	}

	function get_style_depends()
	{
		return [ mw_assets::get_handle_name('ahura_shopcountdown_css') ];
	}
	function get_script_depends()
	{
		return [ mw_assets::get_handle_name('ahura_shopcountdown_js') ];
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('title', 'none');
		$el_id = $this->get_id();
    ?>
    <div class="shop-countdown-element countdownbox" mm-date="<?php echo strtotime($settings['time']) . '000'?>">
        <span <?php echo $this->get_render_attribute_string('title');?>><?php echo $settings['title'];?></span>
        <ul id="mwtimercountdown"></ul>
      <script>
      jQuery(document).ready(function($){
          countdown_init($('.elementor-element-<?php echo $el_id?> .countdownbox'))
      });
      </script>
    </div>
	   <?php
  }

}
