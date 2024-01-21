<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class item_portfolio extends \Elementor\Widget_Base {

	public function get_name() {
		return 'item_portfolio';
	}
  
	public function get_title() {
		return __( 'Portfolio', 'ahura' );
	}

    public function get_icon() {
		return 'aicon-svg-item-portfolio';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['item_portfolio', 'item_portfolio', esc_html__( 'Portfolio', 'ahura')];
	}

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
		mw_assets::register_style('portfolio_widget_style', mw_assets::get_css('elementor.item_portfolio'));
		mw_assets::register_script('portfolio_widget_script', mw_assets::get_js('elementor.item_portfolio'), ['elementor-frontend']);
    }
 
    public function get_style_depends() {
        return [ mw_assets::get_handle_name('portfolio_widget_style') ];
    }
  
    public function get_script_depends() {
        return [ mw_assets::get_handle_name('portfolio_widget_script') ];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'header_all_title',
			[
				'label' => __("ALL label", 'ahura'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __("All", 'ahura')
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'ahura' ),
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'list_gallery',
			[
				'label' => __( 'Add Images', 'ahura' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Repeater List', 'ahura' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Item 1', 'ahura' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);
		
		$this->end_controls_section();

        $this->start_controls_section(
            'settings_section',
            [
                'label' => __('Settings', 'ahura'),
                'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'images_col',
            [
                'label' => __( 'Images column', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '6'  => __( '2', 'ahura' ),
                    '4' => __( '3', 'ahura' ),
                    '3' => __( '4', 'ahura' ),
                    '2' => __( '6', 'ahura' ),
                ],
            ]
        );

        $this->add_responsive_control(
            'object_fit',
            [
                'label' => esc_html__( 'Aspect ratio', 'ahura' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'auto' => esc_html__( 'Default', 'ahura' ),
                    'contain' => esc_html__( 'Contain', 'ahura' ),
                    'cover'  => esc_html__( 'Cover', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-box' => 'background-size: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show title', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'no',
                'options' => [
                    'yes' => [
                        'title' => __('yes', 'ahura'),
                        'icon' => 'eicon-check'
                    ],
                    'no' => [
                        'title' => __('no', 'ahura'),
                        'icon' => 'eicon-close'
                    ],
                ],
                'toggle' => true
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
            'image_section',
            [
                'label' => __('Image', 'ahura'),
                'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-box' => 'height: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_effect',
            [
                'label' => esc_html__('Image effect', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 100,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => ['unit' => '%', 'size' => 100],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-box' => 'filter: brightness({{SIZE}}%)',
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
                    '{{WRAPPER}} .portfolio-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'box_img_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio-box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio-box',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_section',
            [
                'label' => __('title', 'ahura'),
                'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_title' => 'yes']
            ]
        );

        $this->add_control(
            'img_title_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Image title color', 'ahura'),
                'default' => '#fff',
                'selectors' =>
                    [
                        '{{WRAPPER}} .portfolio .img-title' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'img_title_typography',
                'label' => __('Image title typography', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio .img-title',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '15'
                            ]
                        ],
                        'font_weight' => [
                            'default' => 'bold'
                        ]
                    ]
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
            'content_style_section',
            [
                'label' => __('Tabs', 'ahura'),
                'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
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
            'title_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Title color', 'ahura'),
                'default' => '#333',
                'selectors' =>
                    [
                        '{{WRAPPER}} .portfolio ul.header li' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title typography', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio ul.header li',
                'fields_options' =>
                    [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '15'
                            ]
                        ],
                        'font_weight' => [
                            'default' => 'bold'
                        ]
                    ]
            ]
        );

        $this->add_control(
            'title_backcolor',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Background Color', 'ahura'),
                'default' => '#fff',
                'selectors' =>
                    [
                        '{{WRAPPER}} .portfolio ul.header li' => 'background-color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'tab_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio ul.header li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_tab_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio ul.header li',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio ul.header li',
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
            'title_hover_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Title Color', 'ahura'),
                'selectors' =>
                    [
                        '{{WRAPPER}} .portfolio ul.header li:hover' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'title_hover_backcolor',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Background Color', 'ahura'),
                'default' => '#c5c5c5',
                'selectors' =>
                    [
                        '{{WRAPPER}} .portfolio ul.header li:hover' => 'background-color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'tab_radius_hover',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio ul.header li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_tab_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio ul.header li:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio ul.header li:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_active_tab',
            [
                'label' => esc_html__( 'Active', 'ahura' ),
            ]
        );

        $this->add_control(
            'title_active_color',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Title Color', 'ahura'),
                'selectors' =>
                    [
                        '{{WRAPPER}} .portfolio ul.header li.active' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'title_active_backcolor',
            [
                'type' => \Elementor\Controls_Manager::COLOR,
                'label' => __('Background Color', 'ahura'),
                'default' => '#c5c5c5',
                'selectors' =>
                    [
                        '{{WRAPPER}} .portfolio ul.header li.active' => 'background-color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_control(
            'tab_radius_active',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio ul.header li.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_tab_border_active',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio ul.header li.active',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tab_box_shadow_active',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .portfolio ul.header li.active',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
	$settings = $this->get_settings_for_display();

	if($settings['list']){
    ?>
	<section class="item-portfolio-element portfolio text-center animated fadeInUp">
        <div class="container">
			<div class="row justify-content-center">
				<ul class="header d-flex">
					<li class="active" data-class="all"><?php echo $settings['header_all_title']; ?></li>
					<?php foreach ( $settings['list'] as $item ): ?>
					<li class="elementor-repeater-item-<?php echo !empty($item['_id']) ? $item['_id'] : uniqid(); ?>"  data-class="<?php echo md5($item['list_title']) ?>">
                        <?php echo $item['list_title'] ?>
                    </li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="row">
			<?php
			foreach ($settings['list'] as $item) {
                if (empty($item['list_gallery'])){
                    $args = array(
                        'post_type'=> 'attachment',
                        'posts_per_page'=> 8,
                    );
                    $attachments = get_posts($args);
                    if($attachments){
                        foreach ($attachments as $attachment){
                            $item['list_gallery'][] = [
                                    'id' => $attachment->ID,
                                    'url' => wp_get_attachment_url($attachment->ID),
                            ];
                        }
                    }
                }
				foreach ($item['list_gallery'] as $image ) { ?>
                    <div class="col-md-<?php echo $settings['images_col'] ?> images animated" data-class="<?php echo md5($item['list_title']) ?>">
						<a href="<?php echo $image['url'] ?>">
                            <div class="portfolio-box" style="background-image:url(<?php echo $image['url'] ?>)">
                                <?php
                                $title = get_the_title(attachment_url_to_postid($image['url']));
                                if($settings['show_title'] === 'yes' && !empty($title)) { ?>
                                    <span class="img-title"><?php echo $title ?></span>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
				<?php }
			} 
			?>
			</div>
        </div>
    </section>
	<?php
	    }
    }
}
