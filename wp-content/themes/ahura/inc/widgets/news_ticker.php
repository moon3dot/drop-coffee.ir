<?php

namespace ahura\inc\widgets;

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

defined('ABSPATH') or die('No script kiddies please!');

class news_ticker extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'news_ticker';
    }
    function get_title()
    {
        return esc_html__('News ticker', 'ahura');
    }
    public function get_icon() {
		return 'eicon-code-highlight';
	}
    function get_categories()
    {
        return ['ahuraelements'];
    }
    function get_keywords()
    {
        return ['news ticker', 'news', esc_html__('news ticker', 'ahura')];
    }

    function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('news_ticker_css', mw_assets::get_css('elementor.news_ticker'));
        mw_assets::register_style('swipercss',mw_assets::get_css('swiper-bundle-min'));
        mw_assets::register_script('swiperjs', mw_assets::get_js('swiper-bundle-min'));
        mw_assets::register_script('news_ticker_js', mw_assets::get_js('elementor.news_ticker'));
    }

    function get_style_depends()
    {
        return [mw_assets::get_handle_name('news_ticker_css'), mw_assets::get_handle_name('swipercss')];
    }

    function get_script_depends()
    {
        return [mw_assets::get_handle_name('swiperjs'), mw_assets::get_handle_name('news_ticker_js')];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'conetent_section',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );

        $this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'ahura' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'BREAKING NEWS', 'ahura' ),
			]
		);

        $allCategories = get_categories();
        $categoryList = [];
        foreach ($allCategories as $item) {
            $categoryList[$item->term_id] = $item->name;
        }

        $this->add_control(
            'category_ids',
            [
                'label'    => __('Categories', 'ahura'),
                'type'     => \Elementor\Controls_Manager::SELECT2,
                'options'  => $categoryList,
                'label_block' => true,
                'multiple' => true,
                'default' => key($categoryList),
            ]
        );

        $allTags = get_terms([
            'taxonomy' => 'post_tag',
            'hide_empty' => false,
        ]);
        $tagsList = [];
        if ($allTags) {
            foreach ($allTags as $item) {
                $tagsList[$item->term_id] = $item->name;
            }
        }

        $this->add_control(
            'tags_ids',
            [
                'label'    => __('Taxonomy', 'ahura'),
                'type'     => \Elementor\Controls_Manager::SELECT2,
                'options'  => $tagsList,
                'label_block' => true,
                'multiple' => true,
            ]
        );
        
        $this->add_control(
            'posts_count',
            [
                'label'      => __('Number of posts', 'ahura'),
                'type'       => \Elementor\Controls_Manager::NUMBER,
                'default'    => 4
            ]
        );

        $this->add_control(
            'posts_order',
            [
                'label' => __('Sort', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'default' => 'DESC',
                'options' => [
                    'ASC' => [
                        'title' => __('Ascending', 'ahura'),
                        'icon' => 'fa fa-arrow-up'
                    ],
                    'DESC' => [
                        'title' => __('Descending', 'ahura'),
                        'icon' => 'fa fa-arrow-down'
                    ],
                ],
                'toggle' => false,
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'general_styles',
            [
                'label' => esc_html__('General', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'box_height',
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
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .items-swiper-head' => 'min-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .swiper-news-ticker' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'title_meta_width',
			[
				'label' => esc_html__( 'Title/Meta width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .items-swiper-head' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'auto_play',
			[
				'label' => esc_html__( 'Auto Play', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'yes', 'ahura' ),
				'label_off' => esc_html__( 'no', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'auto_play_speed',
			[
				'label' => esc_html__( 'Auto Play Speed', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10000,
				'step' => 1,
				'default' => 1000,
                'condition' => ['auto_play' => 'yes']
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'head_styles',
            [
                'label' => esc_html__('Head', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'head_color',
			[
				'label' => esc_html__( 'Head color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .items-swiper-head' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'head_backcolor',
			[
				'label' => esc_html__( 'Head background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .items-swiper-head' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'head_typography',
				'selector' => '{{WRAPPER}} .items-swiper-head',
			]
		);  

        $this->end_controls_section();

        $this->start_controls_section(
            'title_styles',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-title' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'meta_backcolor',
			[
				'label' => esc_html__( 'Meta background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .news-ticker-wrapper' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .swiper-title',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'post_date_styles',
            [
                'label' => esc_html__('Post date', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'show_post_date',
			[
				'label' => esc_html__( 'Show post date', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'post_date_color',
			[
				'label' => esc_html__( 'Post date color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-date' => 'color: {{VALUE}}',
				],
                'condition' => ['show_post_date' => 'yes']
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'post_date_typography',
				'selector' => '{{WRAPPER}} .swiper-date',
                'condition' => ['show_post_date' => 'yes']
			]
		);

        $this->add_control(
			'post_date_backcolor',
			[
				'label' => esc_html__( 'Post date background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-date' => 'background-color: {{VALUE}}',
				],
                'condition' => ['show_post_date' => 'yes']
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'ticker_date_styles',
            [
                'label' => esc_html__('Ticker date', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'show_ticker_date',
			[
				'label' => esc_html__( 'Show ticker date', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'ticker_date_icon',
			[
				'label' => esc_html__( 'Icon', 'ahura' ),
				'type' => \Elementor\Controls_Manager::ICONS,
			]
		);

        $this->add_control(
			'ticker_date_icon_color',
			[
				'label' => esc_html__( 'Post date icon color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .news-ticker-icon-wrapper i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .news-ticker-icon-wrapper svg' => 'fill: {{VALUE}}',
				],
                'condition' => ['show_ticker_date' => 'yes']
			]
		);

        $this->add_responsive_control(
			'ticker_date_width',
			[
				'label' => esc_html__( 'Ticker date width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .news-ticker-today' => 'width: {{SIZE}}{{UNIT}};',
				],
                'condition' => ['show_ticker_date' => 'yes']
			]
		);

        $this->add_control(
			'ticker_date_color',
			[
				'label' => esc_html__( 'Post date color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .news-ticker-today span' => 'color: {{VALUE}}',
				],
                'condition' => ['show_ticker_date' => 'yes']
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'ticker_date_typography',
				'selector' => '{{WRAPPER}} .news-ticker-today',
                'condition' => ['show_ticker_date' => 'yes']
			]
		);

        $this->add_control(
			'ticker_date_backcolor',
			[
				'label' => esc_html__( 'Ticker date background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .news-ticker-today' => 'background-color: {{VALUE}}',
				],
                'condition' => ['show_ticker_date' => 'yes']
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'thumbnail_styles',
            [
                'label' => esc_html__('Thumbnail', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'show_img',
			[
				'label' => esc_html__( 'Show thumbnail', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_responsive_control(
			'img_width',
			[
				'label' => esc_html__( 'Thumbnail width', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 80,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .img-container img' => 'width: {{SIZE}}{{UNIT}};',
				],
                'condition' => ['show_img' => 'yes']
			]
		);

        $this->add_control(
			'img_border_radius',
			[
				'label' => esc_html__( 'Border radius', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .img-container img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => ['show_img' => 'yes']
			]
		);

        $this->add_control(
			'img_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .img-container img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => ['show_img' => 'yes']
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'btn_styles',
            [
                'label' => esc_html__('Navigation', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Button color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-news-ticker div[class^="items-swiper-button"] i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .swiper-news-ticker div[class^="items-swiper-button"] svg' => 'fill: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'btn_backcolor',
			[
				'label' => esc_html__( 'Date background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-news-ticker div[class^="items-swiper-button"] i' => 'background-color: {{VALUE}}',
				],
			]
		);
        

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $categoryIds = $settings['category_ids'];
        $tags_id = $settings['tags_ids'];
        $taxQuery = [];
        if($categoryIds)
        {
            $taxQuery[] = [
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $categoryIds,
            ];
        }
        if($tags_id)
        {
            $taxQuery[] = [
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tags_id,
            ];
        }
        if(!empty($taxQuery))
        {
            $taxQuery['relation'] = 'AND';
        }
        $args = [
            'post_status' => 'publish',
            'posts_per_page' => $settings['posts_count'] ? $settings['posts_count'] : 4,
            'order' => $settings['posts_order'] ? $settings['posts_order'] : 'DESC',
            'tax_query' => $taxQuery,
        ];
        $posts = new \WP_Query($args); ?>
        <div class="news-ticker-wrapper d-flex justify-content-center align-items-center w-100">
            <?php if( $settings['show_ticker_date'] == 'yes' ): ?>
                <div class="news-ticker-today d-flex justify-content-center align-items-center">
                    <?php if($settings['ticker_date_icon']['value']): ?>
                        <div class="news-ticker-icon-wrapper <?php echo is_rtl() ? 'pl-2' : 'pr-2'; ?>">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['ticker_date_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                    <?php endif; ?>
                    <span><?php echo wp_date(get_option('date_format')); ?></span>
                </div>
            <?php endif; ?>
            <?php if($settings['title']): ?><h2 class="items-swiper-head"><?php echo $settings['title']; ?></h2><?php endif; ?>
            <div class="swiper swiper-news-ticker d-flex align-items-center">
                <div class="swiper-wrapper d-flex align-items-center">
                    <?php if ($posts->have_posts()): ?>
                        <?php while ($posts->have_posts()) : $posts->the_post();
                            $postDate = get_the_date(get_option('date_format'));
                            $item_id = uniqid(); ?>
                            <div class="swiper-slide elementor-repeater-item-<?php echo $item_id; ?> d-flex align-items-center <?php echo is_rtl() ? 'mr-3' : 'ml-3'; ?>">
                                <?php if($settings['show_img'] == 'yes'): ?>
                                <div class="img-container d-flex justify-content-center align-items-center"><?php echo get_the_post_thumbnail(); ?></div>
                                <?php endif; ?>
                                <div class="swiper-title"><a href="<?php the_permalink(); ?>"><?php the_title()?></a></div>
                                <?php if( $settings['show_post_date'] == 'yes' ): ?>
                                    <div class="swiper-date <?php echo is_rtl() ? 'mr-4' : 'ml-4'; ?>"><?php echo $postDate ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p><?php _e('Sorry,no posts were found for display.', 'ahura')?></p>
                    <?php endif; ?>
                </div>
                <div class="items-swiper-nav">
                    <div class="items-swiper-button-prev <?php echo is_rtl() ? 'rtl' : 'ltr'; ?> d-flex justify-content-center align-items-center"><i class="fa fa-chevron-left"></i></div>
                    <div class="items-swiper-button-next <?php echo is_rtl() ? 'rtl' : 'ltr'; ?> d-flex justify-content-center align-items-center"><i class="fa fa-chevron-right"></i></div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                handleNewsTickerElement({
                    autoPlayStatus: <?php echo $settings['auto_play'] === 'yes' ? 'true' : 'false' ?>,
                    playDelay: <?php echo $settings['auto_play'] === 'yes' ? $settings['auto_play_speed'] : 99999; ?>
                });
            })
        </script>
    <?php
    }
}
