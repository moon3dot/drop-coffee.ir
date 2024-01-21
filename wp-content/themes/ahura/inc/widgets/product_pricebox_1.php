<?php
namespace ahura\inc\widgets;
// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class product_pricebox_1 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'product_pricebox_1';
    }
    function get_title()
    {
        return esc_html__('Product Price box 1', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-product-price-box';
	}
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['product_pricebox_1', 'productpricebox1', esc_html__( 'Product Price box 1' , 'ahura')];
    }
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        mw_assets::register_style('product_pricebox_1_widget_style', mw_assets::get_css('elementor.product_pricebox_1'));
    }
    public function get_style_depends() {
        return [ mw_assets::get_handle_name('product_pricebox_1_widget_style') ];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $tags   = get_terms( ['taxonomy' => 'product_tag'] );
        $tag    = [];
        if($tags){
            foreach ( $tags as $tagItem ) {
                if($tagItem){
                    if(!empty($tagItem->term_id) && !empty($tagItem->name)){
                        $tag[$tagItem->term_id] = $tagItem->name;
                    }
                }
            }
        }
        $default = ($tag) ? key($tag) : 0;

        $this->add_control(
            'product_tag_selected',
            [
                'label'         => __('Product tag', 'ahura'),
                'type'          => \Elementor\Controls_Manager::SELECT2,
                'options'       => $tag,
                'label_block'   => true,
                'multiple'      => false,
                'default'       => $default
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Purchase', 'ahura'),
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
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'content_styles',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'title_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'ahura'),
                        'icon' => 'eicon-text-align-right'
                    ],
                    'center' => [
                        'title' => __('Center', 'ahura'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'left' => [
                        'title' => __('Left', 'ahura'),
                        'icon' => 'eicon-text-align-left'
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .title' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .price_items' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Title Color', 'ahura'),
                'default' => '#ff071b',
                'selectors' =>
                [
                    '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .title' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography','ahura'),
                'selector' => '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .title',
                'fields_options' =>
                    [
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '19'
                            ]
                        ]
                    ]
            ]
        );

        $this->add_control(
            'des_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__('Description Color', 'ahura'),
                'default' => '#333',
                'selectors' =>
                    [
                        '{{WRAPPER}} .product_pricebox_1 .price_items' => 'color: {{VALUE}}'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'des_typography',
                'label' => __('Description Typography','ahura'),
                'selector' => '{{WRAPPER}} .product_pricebox_1 .price_items',
                'fields_options' =>
                    [
                        'font_size' => [
                            'default' => [
                                'unit' => 'px',
                                'size' => '16'
                            ]
                        ]
                    ]
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'price_section',
            [
                'label' => esc_html__('Price', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .price-line' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_value_typography',
                'label' => esc_html__('Price Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .price-line span',
                'fields_options' =>
				[
                    'typography' => [
                        'default' => 'yes'
                    ],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '30'
						]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ]
				]
			]
		);
        $this->add_control(
            'price_line_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .price-line' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
				],
            ]
        );
        $this->add_control(
            'price_section_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top'],
                'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .price-line' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' =>
                [
                    'isLinked' => false,
                    'top' => '10'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'price_line_bg',
                'selector' => '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .price-line',
                'fields_options' =>
                [
                    'background' =>
                    [
                        'default' => 'gradient'
                    ],
                    'color' => 
                    [
                        'default' => '#fe248b'
                    ],
                    'color_b' =>
                    [
                        'default' => '#ff071b'
                    ],
                    'gradient_angle' =>
                    [
                        'default' =>
                        [
                            'unit' => 'deg',
                            'size' => 110
                        ]
                    ]
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ],
				],
				'default' => [
					'unit' => 'px',
                    'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .btn-wrapper a' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        $this->add_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => ['top'],
                'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .btn-wrapper a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' =>
                [
                    'isLinked' => false,
                    'top' => '20'
                ]
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'label' => esc_html__('Text Color', 'ahura'),
                'selectors' =>
                [
                    '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .btn-wrapper a' => 'color: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg',
                'selector' => '{{WRAPPER}} .product_pricebox_1 .product_pricebox_box_wrapper .btn-wrapper a',
                'fields_options' =>
                [
                    'background' =>
                    [
                        'default' => 'gradient'
                    ],
                    'color' => 
                    [
                        'default' => '#fe248b'
                    ],
                    'color_b' =>
                    [
                        'default' => '#ff071b'
                    ],
                    'gradient_angle' =>
                    [
                        'default' =>
                        [
                            'unit' => 'deg',
                            'size' => 110
                        ]
                    ]
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'box_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
				],
				'default' => [
					'unit' => 'px',
                    'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .product_pricebox_1' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ahura' ),
				'selector' => '{{WRAPPER}} .product_pricebox_1',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'box_bg',
                'selector' => '{{WRAPPER}} .product_pricebox_1',
                'fields_options' =>
                [
                    'background' =>
                    [
                        'default' => 'classic'
                    ],
                    'color' =>
                    [
                        'default' => '#ffffff'
                    ]
                ]
            ]
        );
        
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $has_des = $settings['show_des'] === 'yes';

        if(!\ahura\app\woocommerce::is_active()){
            return false;
        }

        $args = [
            'post_type' => 'product',
            'posts_per_page' => 1,
        ];

        $selected = $settings['product_tag_selected'];
        if(!empty($selected)){
            $args['tax_query'] = [
                'relation' => 'OR',
                [
                    'taxonomy' => 'product_tag',
                    'field' => 'term_id',
                    'terms' => $selected,
                ],
            ];
        }

        $post_box = new \WP_Query($args);
        ?>

        <?php if ( $post_box->have_posts() ) : ?>
            <div class="product_pricebox_1">
                <div class="post_box <?php echo !$has_des ? 'without-des' : '' ?>">
                    <div class="post_box_post row">
                        <?php while ( $post_box->have_posts() ) : $post_box->the_post(); ?>
                            <div class="product_pricebox_box_wrapper col-12">
                                <div class="title">
                                    <span><?php echo the_title(); ?></span>
                                </div>
                                <div class="price-line">
                                    <span class="value"><?php echo wc_get_product( get_the_ID() )->get_price_html(); ?></span>
                                </div>
                                <?php if ($has_des): ?>
                                <div class="price_items">
                                    <?php the_excerpt(); ?>
                                </div>
                                <?php endif; ?>
                                <div class="btn-wrapper">
                                    <a href="<?php the_permalink() ?>?add-to-cart=<?php echo get_the_ID(); ?>" class="btn"><?php echo $settings['button_text'];?></a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
                    <?php else:?>
                        <div class="mw_element_error">
                            <?php echo __('Nothing found. Edit the page with Elementor and select a category for this section.','ahura');?>
                        </div>
                <?php endif; ?>
            </div>
        <?php
    }
}
