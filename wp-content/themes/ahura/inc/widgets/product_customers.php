<?php
namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

class product_customers extends \Elementor\Widget_Base
{
    use \ahura\app\traits\link_utilities;
    use \ahura\app\traits\WoocommerceMethods;

    /**
     * product_customers constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('product_customers_css', mw_assets::get_css('elementor.product_customers'));

        if(!is_rtl()){
            mw_assets::register_style('product_customers_ltr_css', mw_assets::get_css('elementor.ltr.product_customers_ltr'));
        }
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('product_customers_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('product_customers_ltr_css');
        }
        return $styles;
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'product_customers';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Product Customers', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-my-account';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraelements'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['productcustomers', 'product_customers', esc_html__('Product Customers', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        /**
         *
         *
         * Start content
         *
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'image',
			[
				'label' => esc_html__('Choose Image', 'ahura'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
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
                    'fill' => esc_html__( 'Default', 'ahura' ),
                    'contain' => esc_html__( 'Contain', 'ahura' ),
                    'cover'  => esc_html__( 'Cover', 'ahura' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-cover img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_customers',
            [
                'label' => esc_html__('Show Product Buyers', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_avatars',
            [
                'label' => esc_html__('Show Buyers Avatar', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_customers' => 'yes'
                ]
            ]
        );

        $options = [];

        $products = $this->get_products_array();

        if($products){
            foreach($products as $product) {
                $options[$product['ID']] = $product['post_title'];
            }
        }

        $default = ($products) ? key($options) : 0;

        $this->add_control(
            'product_id',
            [
                'label' => esc_html__('Product', 'ahura'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => $options,
                'default' => $default,
                'description' => esc_html__('To display a few items from product buyers.', 'ahura'),
                'condition' => [
                    'show_customers' => 'yes',
                    'show_avatars' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'box_title',
            [
                'label' => esc_html__('Box Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Top site course students', 'ahura'),
                'condition' => [
                    'show_customers' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'customer_number',
            [
                'label' => esc_html__('Buyers Number', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => '2000+',
                'condition' => [
                    'show_customers' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'has_link',
            [
                'label' => esc_html__('Box Link', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
			'box_link',
			[
				'label' => esc_html__('Link', 'ahura'),
                'label_block' => true,
				'type' => Controls_Manager::URL,
				'placeholder' => site_url(),
				'options' => ['url', 'is_external', 'nofollow'],
                'dynamic' => ['active' => true],
				'default' => [
					'url' => site_url(),
					'is_external' => true,
				],
                'condition' => [
                    'has_link' => 'yes'
                ]
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'bubbles_section',
            [
                'label' => esc_html__('Bubbles', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_bubbles',
            [
                'label' => esc_html__('Show Bubbles', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f30808',
                'selectors' => [
                    '{{WRAPPER}} .product-customers-1 .bubbles {{CURRENT_ITEM}}.bubble' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $repeater->add_control(
            'item_size',
            [
                'label' => esc_html__('Dimensions', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'em'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'rem' => [
						'min' => 0,
						'max' => 1000,
					],
                    'em' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .product-customers-1 .bubbles {{CURRENT_ITEM}}.bubble' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $repeater->add_control(
			'position_options',
			[
				'label' => esc_html__('Position', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $repeater->add_responsive_control(
            'x_axis',
            [
                'label' => esc_html__('X Axis', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-customers-1 .bubbles {{CURRENT_ITEM}}.bubble' => '--e-pc-transform-translateX: {{SIZE}}{{UNIT}};transform: translateX(var(--e-pc-transform-translateX)) translateY(var(--e-pc-transform-translateY));',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'y_axis',
            [
                'label' => esc_html__('Y Axis', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','%'],
                'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-customers-1 .bubbles {{CURRENT_ITEM}}.bubble' => '--e-pc-transform-translateY: {{SIZE}}{{UNIT}};transform: translateY(var(--e-pc-transform-translateY)) translateX(var(--e-pc-transform-translateX));',
				],
            ]
        );

        $repeater->add_control(
			'item_popover_toggle',
			[
				'label' => esc_html__('More', 'ahura'),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => esc_html__('Default', 'ahura'),
				'label_on' => esc_html__('Custom', 'ahura'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $repeater->start_popover();
        $repeater->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-customers-1 .bubbles {{CURRENT_ITEM}}.bubble' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ]
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .product-customers-1 .bubbles {{CURRENT_ITEM}}.bubble',
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-customers-1 .bubbles {{CURRENT_ITEM}}.bubble',
            ]
        );
		$repeater->end_popover();

        $this->add_control(
            'bubbles',
            [
                'label' => esc_html__('Bubbles', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_color' => '#eb269c',
                        'item_size' => [
                            'unit' => 'px',
                            'size' => 70
                        ],
                        'x_axis' => [
                            'unit' => 'px',
                            'size' => is_rtl() ? -480 : 480
                        ],
                        'y_axis' => [
                            'unit' => 'px',
                            'size' => 110
                        ]
                    ],
                    [
                        'item_color' => '#FFC800',
                        'item_size' => [
                            'unit' => 'px',
                            'size' => 40
                        ],
                        'x_axis' => [
                            'unit' => 'px',
                            'size' => is_rtl() ? 40 : -40
                        ],
                        'y_axis' => [
                            'unit' => 'px',
                            'size' => 30
                        ]
                    ],
                    [
                        'item_color' => '#26ddeb',
                        'item_size' => [
                            'unit' => 'px',
                            'size' => 30
                        ],
                        'x_axis' => [
                            'unit' => 'px',
                            'size' => is_rtl() ? 50 : -50
                        ],
                        'y_axis' => [
                            'unit' => 'px',
                            'size' => 338
                        ]
                    ]
                ],
                'condition' => [
                    'show_bubbles' => 'yes'
                ]
            ]
        );
      
        $this->end_controls_section();
        /**
         *
         *
         * Start Styles
         *
         */
        $this->start_controls_section(
            'content_section_styles',
            [
                'label' => esc_html__('Image', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'em', '%'],
				'default' => [
					'unit' => 'px',
					'size' => 550,
				],
                'tablet_default' => ['size' => 280,'unit' => 'px'],
                'mobile_default' => ['size' => 280,'unit' => 'px'],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-customers-1 .item-cover img' => 'height: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'img_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .product-customers-1 .item-cover img',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => 
                        [
                            'unit' => 'px',
                            'top' => 15,
                            'right' => 15,
                            'bottom' => 15,
                            'left' => 15,
                        ]   
                    ],
                    'color' => ['default' => '#fff']
                ]
            ]
        );

        $this->add_control(
            'img_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-customers-1 .item-cover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 90,
                    'right' => 90,
                    'bottom' => 90,
                    'left' => 90,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-customers-1 .item-cover img',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 9,
                            'blur' => 50,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .18)'
                        ]
                    ]
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'customers_section_styles',
            [
                'label' => esc_html__('Buyers Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_customers' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'box_title_color',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .product-customers-list .pc-box-title' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_title_typo',
                'selector' => '{{WRAPPER}} .product-customers-list .pc-box-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                ]
            ]
        );

        $this->add_control(
            'box_number_color',
            [
                'label' => esc_html__('Number color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#19b977',
                'selectors' => [
                    '{{WRAPPER}} .product-customers-1 .pc-num' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_number_typo',
                'selector' => '{{WRAPPER}} .product-customers-1 .pc-num',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => 'bold'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ],
                ]
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_background',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .product-customers-1 .product-customers-list',
                'fields_options' => [
					'background' => ['default' => 'classic'],
					'color' => ['default' => '#fff']
				]
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'customers_box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .product-customers-1 .product-customers-list',
            ]
        );

        $this->add_control(
            'customers_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-customers-1 .product-customers-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'customers_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .product-customers-1 .product-customers-list',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 9,
                            'blur' => 50,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .18)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     *
     * Render element content (html)
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        $show_bubbles = $settings['show_bubbles'];
        $bubbles = ($show_bubbles == 'yes') ? $settings['bubbles'] : false;
        $has_link = $settings['has_link'];
        $image = $settings['image'];

        $is_active_woocommerce = \ahura\app\woocommerce::is_active();
        $product_id = isset($settings['product_id']) && intval($settings['product_id']) ? $settings['product_id'] : 0;
        $customers = $is_active_woocommerce ? $this->get_product_customers($product_id, 4) : false;
        ?>
           <div class="product-customers-1 product-customers-1-<?php echo $wid ?>">
                <?php if($has_link == 'yes'): ?>
                <a <?php $this->render_link_attrs($settings['box_link']) ?>>
                <?php endif; ?>
                <?php if($bubbles): ?>
                    <div class="bubbles">
                        <?php foreach ($bubbles as $bubble): ?>
                            <span class="elementor-repeater-item-<?php echo $bubble['_id']; ?> bubble"></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="item-cover">
                    <?php 
                    if($image['id']){
                        echo wp_get_attachment_image($image['id'], 'full');
                    } else {
                        echo "<img src='{$image['url']}' alt='Placeholder'>";
                    }
                    ?>
                </div>
                <?php 
                if($is_active_woocommerce && $settings['show_customers'] == 'yes'):
                    $customer_number = $settings['customer_number'];
                    $show_avatars = $settings['show_avatars'];
                 ?>
                <div class="product-customers-list">
                    <div class="pc-box-title"><?php echo $settings['box_title'] ?></div>
                    <?php if($show_avatars == 'yes' || !empty($customer_number)) ?>
                    <div class="pc-items-num <?php echo ($show_avatars != 'yes' || !$customers || empty($customer_number)) ? ' single-item' : '' ?>">
                        <?php if($show_avatars == 'yes' && $customers): ?>
                            <div class="pc-items">
                                <?php 
                                foreach($customers as $customer):
                                    $user = get_user_by('email', $customer);
                                    if(!$user) continue;
                                ?>
                                <div class="product-customer-item">
                                    <?php echo get_avatar($user->ID, 40); ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($customer_number)): ?>
                            <div class="pc-num"><?php echo $customer_number ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($has_link == 'yes'): ?>
                </a>
                <?php endif; ?>
           </div>
        <?php
    }
}
