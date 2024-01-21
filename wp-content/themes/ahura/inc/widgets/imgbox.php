<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class imgbox extends \Elementor\Widget_Base {
    /**
     * imgbox constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('imgbox_css', mw_assets::get_css('elementor.imgbox'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('imgbox_css')];
    }

	public function get_name() {
		return 'imagebox';
	}
  
	public function get_title() {
		return __( 'Image Box', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-imgbox';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['imgbox', 'img_box', 'imagebox', 'image_box', esc_html__( 'Image Box' , 'ahura')];
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
		'subtitle',
		[
			'label' => __( 'Subtitle', 'ahura' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __('Subtitle Here', 'ahura')
		]
		);
    
		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'ahura' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image', 'svg'],
                'default' => ['url' => get_template_directory_uri() . '/img/offer-icon.webp']
			]
		);

		$this->add_control(
			'boxurl',
			[
				'label' => __( 'URL', 'ahura' ),
				'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
			]
		);
		
		$this->end_controls_section();
        $this->start_controls_section(
            'content_styles',
            [
                'label' => __( 'Content', 'ahura' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('style_tabs');
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'ahura' ),
            ]
        );

        $this->add_control(
            'textcolor',
            [
                'label' => __( 'Text Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .imgbox span, {{WRAPPER}} .imgbox p' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .imgbox span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'subtextcolor',
            [
                'label' => __( 'Subtitle Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.imgbox p' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Subtitle Typography', 'ahura'),
                'name' => 'item_subtitle_typography',
                'selector' => '{{WRAPPER}} .imgbox p',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'ahura' ),
            ]
        );

        $this->add_control(
            'textcolor_hover',
            [
                'label' => __( 'Text Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .imgbox:hover span, {{WRAPPER}} .imgbox:hover p' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'subtextcolor_hover',
            [
                'label' => __( 'Subtitle Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.imgbox:hover p' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles',
            [
                'label' => __( 'Box', 'ahura' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_img_height',
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
                'default' => ['unit' => 'px', 'size' => 190],
                'selectors' => [
                    '{{WRAPPER}} .imgbox' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'box_bg',
            [
                'label' => __( 'Background Color', 'ahura' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6EC1E4',
                'selectors' => [
                    '{{WRAPPER}} .imgbox' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .imgbox',
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .imgbox' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .imgbox',
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$bg_image = $settings['image']['url'];
		$this->add_inline_editing_attributes('title', 'none');
		$this->add_inline_editing_attributes('subtitle', 'none');
        if ( ! empty( $settings['boxurl']['url'] ) ) {
            $this->add_link_attributes( 'boxurl', $settings['boxurl'] );
        }
        ?>
        <a <?php echo $this->get_render_attribute_string( 'boxurl' ); ?> class="imgbox" style="<?php echo $bg_image ? "background-image:url('".$bg_image."')" : ''; ?>">
            <span <?php echo $this->get_render_attribute_string('title');?>><?php echo $settings['title'];?></span>
            <p <?php echo $this->get_render_attribute_string('subtitle');?>><?php echo $settings['subtitle'];?></p>
        </a>
	   <?php
  }
}
