<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class iconbox extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iconbox';
	}
  
	public function get_title() {
		return __( 'Icon Box', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-icon-box';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['iconbox', 'icon_box', esc_html__( 'Icon Box' , 'ahura')];
	}
	function __construct($data=[], $args=null)
	{
		parent::__construct($data, $args);
		$iconbox_css = mw_assets::get_css('elementor.iconbox');
		mw_assets::register_style('iconbox', $iconbox_css);
	}
	function get_style_depends()
	{
		return [mw_assets::get_handle_name('iconbox')];
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
                'default' => __('Sample Title', 'ahura')
			]
		);
		
		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'ahura' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-apple-alt',
                    'library' => 'fa-solid',
                ],
			]
		);

        $this->add_control(
            'show_des',
            [
                'label' => esc_html__('Show Description', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
		
		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
			    'condition' => ['show_des' => 'yes']
            ]
		);
    
    $this->add_control(
			'color',
			[
				'label' => __( 'Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'blue' => __( 'Blue', 'ahura' ),
					'red' => __( 'Red', 'ahura' ),
					'purple' => __( 'Purple', 'ahura' ),
					'yellow' => __( 'Yellow', 'ahura' ),
					'green' => __( 'Green', 'ahura' ),
					'pink' => __( 'Pink', 'ahura' ),
					'Orange' => __( 'Orange', 'ahura' )
				),
                'default' => 'blue'
			]
		);

		$this->add_control('url', [
			'label' => __('URL', 'ahura'),
			'type' => \Elementor\Controls_Manager::URL,
            'dynamic' => ['active' => true],
		]);
        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style',
            [
                'label' => __( 'Icon', 'ahura' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .iconbox .icon_wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .iconbox .icon_wrapper img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .iconbox .icon_wrapper svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .iconbox .icon_wrapper i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .iconbox .icon_wrapper svg' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .iconbox .icon_wrapper svg > *' => 'fill: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_section();
        $this->start_controls_section(
            'content_style',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .iconbox span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Title Typography', 'ahura'),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .iconbox span',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '18',
                            ]
                        ],
                        'font_weight' => [
                            'default' => '700'
                        ],
                    ],
            ]
        );

        $this->add_control(
            'des_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .iconbox p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Description Typography', 'ahura'),
                'name' => 'des_typography',
                'selector' => '{{WRAPPER}} .iconbox p',
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
                        'font_weight' => [
                            'default' => '400'
                        ],
                    ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        $wid      = $this->get_id();
        if ( ! empty( $settings['url']['url'] ) ) {
			$this->add_link_attributes( 'url', $settings['url'] );
		}
        ?>

        <div class="iconbox iconbox-<?php echo $settings['color']; ?> iconbox-<?php echo $wid; ?>">
            <?php if( !empty( $settings['url']['url'] ) ): ?>
                <a <?php echo $this->get_render_attribute_string( 'website_link' ); ?>>
            <?php else: ?>
                <div class="simple-icon-box">
            <?php endif; ?>
                <div class="icon_wrapper">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon']); ?>
                    <span><?php echo $settings['title']; ?></span>
                    <?php if ($settings['show_des'] == 'yes'): ?>
                        <p><?php echo $settings['text']; ?></p>
                    <?php endif; ?>
                </div>
            <?php echo !empty( $settings['url']['url'] ) ? '</a>' : '</div>'; ?>
        </div>
        <?php
  }
}
