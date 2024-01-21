<?php
namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class products_category extends \Elementor\Widget_Base
{
    use \ahura\app\traits\Taxonomy_Utilities;

    /**
     * products_category constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('products_category_css', mw_assets::get_css('elementor.products_category'));
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'), false);
        mw_assets::register_script('products_category_js', mw_assets::get_js('elementor.products_category'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('products_category_css'), mw_assets::get_handle_name('swipercss')];
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('products_category_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'ahura_products_category';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Product Categories Carousel', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-product-categories';
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
        return ['productscategory', 'products_category', esc_html__('Product Categories Carousel', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_mode',
            [
                'label' => esc_html__('Mode', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'all' => esc_html__('All', 'ahura'),
                    'custom' => esc_html__('Select Categories', 'ahura'),
                ],
                'default' => 'all'
            ]
        );

        $this->add_control(
            'cat_ids',
            [
                'label' => esc_html__('Categories', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_taxonomy_ids('product_cat'),
                'label_block' => true,
                'multiple' => true,
                'condition' => [
                    'show_mode' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' => esc_html__('Counter', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'thumbnail',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'content_settings',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'slides_per_view',
            [
                'label' => esc_html__('Slides per view', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                ],
                'default' => 6,
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Arrows', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'ahura'),
                    'default' => esc_html__('Dots', 'ahura'),
                    'fraction' => esc_html__('Fraction', 'ahura'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label' => esc_html__('Transition Duration', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 2500,
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label' => esc_html__('Infinite Loop', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();
		/**
         *
         *
         * Start box style
         *
         */

        $this->start_controls_section(
            'box_wrap_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->start_controls_tabs('box_wrap_style_tabs');
        $this->start_controls_tab(
            'box_wrap_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );
		
		$this->add_control(
			'cover_more',
			[
				'label' => esc_html__('Cover', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);
		
		$this->add_responsive_control(
            'box_img_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
					'rem' => [
                        'min' => 0,
                        'max' => 1000
                    ],
					'em' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                ],
            ]
        );
		
		$this->add_responsive_control(
            'box_img_size',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item img' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000
                    ],
					'rem' => [
                        'min' => 0,
                        'max' => 1000
                    ],
					'em' => [
                        'min' => 0,
                        'max' => 1000
                    ],
                ],
            ]
        );
		
		$this->add_control(
			'content_more',
			[
				'label' => esc_html__('Content', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .product-cat-item span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
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
                    '{{WRAPPER}} .product-cat-item span' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_wrap_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .product-cat-item',
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 7,
                    'right' => 7,
                    'bottom' => 7,
                    'left' => 7,
                ]
            ]
        );

        $this->add_responsive_control(
            'box_wrap_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );
		
		$this->add_control(
			'counter_more',
			[
				'label' => esc_html__('Counter', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_count' => 'yes'
				]
			]
		);
		
		$this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_count_typo',
                'selector' => '{{WRAPPER}} .product-cat-item em',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ],
				'condition' => [
					'show_count' => 'yes'
				]
            ]
        );
		
		$this->add_control(
            'box_count_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item em' => 'color: {{VALUE}}',
                ],
				'condition' => [
					'show_count' => 'yes'
				]
            ]
        );

        $this->add_control(
            'box_count_bg_color',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#919191',
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item em' => 'background-color: {{VALUE}}',
                ],
				'condition' => [
					'show_count' => 'yes'
				]
            ]
        );
		
		$this->add_responsive_control(
            'box_count_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item em' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 50,
                    'right' => 50,
                    'bottom' => 50,
                    'left' => 50,
                ],
				'condition' => [
					'show_count' => 'yes'
				]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'box_wrap_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_title_color_hover',
            [
                'label' => esc_html__('Title color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#673ab7',
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item:hover span' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'box_bg_color_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item:hover' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_wrap_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .product-cat-item:hover',
            ]
        );

        $this->add_responsive_control(
            'box_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		
		$this->add_control(
			'counter_more_hover',
			[
				'label' => esc_html__('Counter', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_count' => 'yes'
				]
			]
		);
		
		$this->add_control(
            'box_count_color_hover',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item:hover em' => 'color: {{VALUE}}',
                ],
				'condition' => [
					'show_count' => 'yes'
				]
            ]
        );

        $this->add_control(
            'box_count_bg_color_hover',
            [
                'label' => esc_html__('Background color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#673ab7',
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item:hover em' => 'background-color: {{VALUE}}',
                ],
				'condition' => [
					'show_count' => 'yes'
				]
            ]
        );
		
		$this->add_responsive_control(
            'box_count_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .product-cat-item:hover em' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition' => [
					'show_count' => 'yes'
				]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
		$this->start_controls_section(
            'box_navigation_style',
            [
                'label' => esc_html__('Navigation', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'nav_options',
			[
				'label' => esc_html__('Navigation', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'box_nav_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-products-category .apc-swiper-button-next, {{WRAPPER}} .ahura-products-category .apc-swiper-button-prev' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'paginate_options',
			[
				'label' => esc_html__('Pagination', 'ahura'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'box_paginate_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00000087',
                'selectors' => [
                    '{{WRAPPER}} .ahura-products-category .apc-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .ahura-products-category .apc-swiper-pagination.swiper-pagination-progressbar' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_paginate_active_color',
            [
                'label' => esc_html__('Active Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-products-category .apc-swiper-pagination.swiper-pagination-bullets .swiper-pagination-bullet-active' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .ahura-products-category .apc-swiper-pagination.swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}}',
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

        if (!\ahura\app\woocommerce::is_active()) {
            if(is_admin()) {
                ?>
                <div class="productcategorybox mw_elem_empty_box"><h3><?php _e('To use this element you must install woocommerce plugin.', 'ahura'); ?></h3></div>
                <?php
            }
            return false;
        }

        $wid = $this->get_id();
        $show_mode = $settings['show_mode'];
        $cats = $show_mode == 'custom' ? $this->get_terms('product_cat', $settings['cat_ids']) : $this->get_terms('product_cat');
        $has_paginate = ($settings['pagination'] == 'yes' || $settings['pagination'] != 'none');
        $has_navigate = ($settings['show_arrows'] == 'yes');

        if(!$cats)
            return false;
        ?>
       <div class="ahura-products-category ahura-products-category-<?php echo $wid; ?><?php echo $has_paginate ? ' has-paginate' : '' ?><?php echo $has_navigate ? ' has-navigate' : '' ?>">
        <div class="swiper ahura-products-category-carousel ahura-products-category-carousel-<?php echo $wid; ?>">
            <div class="swiper-wrapper">
                <?php
                foreach($cats as $cat):
					$cat_id = is_array($cat) ? $cat['term_id'] : $cat->term_id;
                    $img_id = get_term_meta($cat_id, 'thumbnail_id', true);
                    $img = intval($img_id) ? wp_get_attachment_url($img_id) : wc_placeholder_img_src();					
                ?>
                <div class="swiper-slide">
                    <a href="<?php echo get_category_link($cat_id) ?>" class="product-cat-item">
                        <?php if(intval($img)): ?>
                            <?php echo wp_get_attachment_image($img, $settings['item_cover_size']) ?>
                        <?php else: ?>
                            <img src="<?php echo $img ?>" alt="<?php echo $cat->name ?>">
                        <?php endif; ?>
                        <div class="product-cat-item-details">
						<span><?php echo $cat->name ?></span>
                        <?php if($settings['show_count'] == 'yes' && intval($cat->count)): ?>
                        <em><?php echo $cat->count ?></em>
                        <?php endif; ?>
						</div>
                    </a>
                </div>
                <?php endforeach;  ?>
            </div>
        </div>
       <?php if($has_paginate): ?>
            <div class="apc-swiper-pagination"></div>
        <?php endif; ?>
        <?php if($has_navigate): ?>
            <div class="swiper-nav-button apc-swiper-button-prev"><i class="fas fa-angle-right"></i></div>
            <div class="swiper-nav-button apc-swiper-button-next"><i class="fas fa-angle-left"></i></div>
        <?php endif; ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                handleProductsCategoryElement({
                    widgetID: '<?php echo $wid ?>',
                    loop: <?php echo $settings['infinite_loop'] == 'yes' ? 'true' : 'false' ?>,
                    slidesPerView: <?php echo (isset($settings['slides_per_view']) && intval($settings['slides_per_view'])) ? $settings['slides_per_view'] : 3 ?>,
                    mobilePerView: <?php echo (isset($settings['slides_per_view_mobile']) && intval($settings['slides_per_view_mobile'])) ? $settings['slides_per_view_mobile'] : 1 ?>,
                    tabletPerView: <?php echo (isset($settings['slides_per_view_tablet']) && intval($settings['slides_per_view_tablet'])) ? $settings['slides_per_view_tablet'] : 2 ?>,
                    navigation: <?php echo $has_navigate ? 'true' : 'false' ?>,
                    autoPlay: <?php echo $settings['autoplay'] == 'yes' ? 'true' : 'false' ?>,
                    transitionDuration: <?php echo (intval($settings['transition_duration'])) ? $settings['transition_duration'] : 2500 ?>,
                    showPagination: <?php echo $has_paginate ? 'true' : 'false' ?>,
                    paginationType: '<?php echo $settings['pagination'] ?>',
                });
            });
        </script>
       </div>
        <?php
    }
}