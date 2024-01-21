<?php

namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use \ahura\app\mw_assets;

class post_grid_tab extends \Elementor\Widget_Base
{
    /**
     * post_grid_tab constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('post_grid_tab_css', mw_assets::get_css('elementor.post_grid_tab'));
        if (!is_rtl()) {
            mw_assets::register_style('post_grid_tab_ltr_css', mw_assets::get_css('elementor.ltr.post_grid_tab_ltr'));
        }
        mw_assets::register_script('post_grid_tab_js', mw_assets::get_js('elementor.post_grid_tab'));
        wp_localize_script(mw_assets::get_handle_name('post_grid_tab_js'), 'ahura_data_pgt', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'translate' => [
                'view_more' => __('View More', 'ahura')
            ]
        ]);
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('post_grid_tab_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('post_grid_tab_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('post_grid_tab_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'post_grid_tab';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Post Grid Tab', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-tabs';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraelements', 'ahura_posts'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['postgridtab', 'post_grid_tab', esc_html__('Post Grid Tab', 'ahura')];
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
            'tabs_content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Tab Title', 'ahura'),
            ]
        );

        $repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => ['svg'],
                'default' => [
                    'value' => 'fas fa-mobile',
                    'library' => 'solid',
                ],
            ]
        );

        $post_types = get_post_types(array('public' => true), 'objects');
        unset($post_types['attachment']);
        $types = array();
        foreach ($post_types as $post_type) {
            $types[$post_type->name] = $post_type->labels->singular_name;
        }

        $repeater->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Type', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $types,
            ]
        );

        $taxonomies = get_taxonomies(['public' => true], 'objects');

        $taxs = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                $taxs[$taxonomy->name] = $taxonomy->labels->name;
            }
        }
        $repeater->add_control(
            'tax_name',
            [
                'label' => esc_html__('Taxonomy', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $taxs,
                'label_block' => true,
            ]
        );

        $cats = array();
        if ($taxonomies) {
            foreach ($taxonomies as $key => $taxonomy) {
                if ($term_object = get_terms($key)) {
                    if($term_object){
                        foreach ($term_object as $term) {
                            $cats[$term->term_id] = "{$term->name} - {$taxonomy->labels->name}";
                        }
                    }
                }
            }
        }
        $repeater->add_control(
            'cat_id',
            [
                'label' => esc_html__('Categories', 'ahura'),
                'type' => Controls_Manager::SELECT2,
                'options' => $cats,
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $repeater->add_control(
            'per_page',
            [
                'label' => esc_html__('Posts Count', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'max' => 8,
            ]
        );
		
		$repeater->add_control(
            'item_box_more_btn_title',
            [
                'label' => esc_html__('Button Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('View More', 'ahura'),
            ]
        );
		
        $repeater->add_control(
            'item_archive_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'placeholder' => site_url(),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );
		
		$repeater->add_control(
            'item_more_btn_title',
            [
                'label' => esc_html__('Post Button Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('View More', 'ahura'),
            ]
        );

        $repeater->add_control(
            'item_color',
            [
                'label' => esc_html__('Primary Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f30808',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items {{CURRENT_ITEM}}.active a' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items {{CURRENT_ITEM}} .ahura-loader-ring:after' => 'border-color: {{VALUE}} transparent {{VALUE}} transparent;',
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tabs-content {{CURRENT_ITEM}} .tab-title:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tabs-content {{CURRENT_ITEM}} .tab-archive-btn' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_items',
            [
                'label' => esc_html__('Items', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{item_title}}}',
                'default' => [
                    [
                        'item_title' => esc_html__('Tab Title', 'ahura'),
                        'item_archive_link' => ['url' => site_url()],
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'item_cover',
                'default' => 'full',
            ]
        );

        $this->add_control(
            'item_meta_show',
            [
                'label' => esc_html__('Meta', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_post_cover',
            [
                'label' => esc_html__('Post Cover', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
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
            'tab_items_style',
            [
                'label' => esc_html__('Tabs', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tab_btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ahura'),
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
                    'size' => 15
                ],
                'selectors' => [
                    '{{WRAPPER}} .pgt-tab-items .pgt-item-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pgt-tab-items .pgt-item-btn svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items .pgt-item-btn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items .pgt-item-btn svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_tab_title_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items .pgt-item-btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_tab_typo',
                'selector' => '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items .pgt-item-btn',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_tab_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items .pgt-item-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_tab_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items .pgt-item-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 15,
                    'right' => 20,
                    'bottom' => 15,
                    'left' => 20,
                ]
            ]
        );

        $this->add_control(
            'item_tab_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_tab_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .post-grid-tab-1 .pgt-tab-items .pgt-item-btn',
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Posts styles
         *
         *
         */
        $this->start_controls_section(
            'post_item_style',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'post_item_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 700
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 230,
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .post-item' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'post_item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .post-item .post-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'post_item_meta_color',
            [
                'label' => esc_html__('Meta Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .post-item .post-metas' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .post-grid-tab-1 .post-item .post-metas div' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'post_item_btn_color',
            [
                'label' => esc_html__('Button Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .post-item .post-foot a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_item_title_typo',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .post-grid-tab-1 .post-item .post-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '20'
                        ]
                    ],
                    'font_weight' => [
                        'default' => 'bold'
                    ],
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_item_meta_typo',
                'label' => esc_html__('Meta Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .post-grid-tab-1 .post-item .post-metas, {{WRAPPER}} .post-grid-tab-1 .post-item .post-metas span',
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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_item_btn_typo',
                'label' => esc_html__('Button Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .post-grid-tab-1 .post-item .post-foot a',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '300'
                    ],
                ]
            ]
        );

        $this->add_control(
            'post_item_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .post-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'post_item_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 25,
                    'right' => 25,
                    'bottom' => 25,
                    'left' => 25,
                ]
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * Box styles
         *
         *
         */
        $this->start_controls_section(
            'tab_box_wrap_style',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tabs_wrap_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .tab-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tabs_wrap_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tabs-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tabs_wrap_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_wrap_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => false,
                    'top' => 40,
                    'right' => 40,
                    'bottom' => 40,
                    'left' => 40,
                ]
            ]
        );

        $this->add_control(
            'tabs_wrap_margin',
            [
                'label' => esc_html__('Margin', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-tab-1 .pgt-tabs-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tabs_wrap_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .post-grid-tab-1 .pgt-tabs-content',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 0,
                            'blur' => 15,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, .15)'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render_link_attrs($url_data)
    {
        $target = $url_data['is_external'] ? 'target="_blank"' : '';
        $nofollow = $url_data['nofollow'] ? 'rel="nofollow"' : '';
        $cu_attr = $url_data['custom_attributes'] ? $url_data['custom_attributes'] : false;
        $data = 'href="' . $url_data['url'] . '" ' . $target . ' ' . $nofollow . ' ' . $cu_attr;
        echo $data;
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
        $items = $settings['tab_items'];
        $show_post_cover = $settings['show_post_cover'] == 'yes';

        if ($items):
            ?>
            <div class="post-grid-tab-1-wrap post-grid-tab-1-wrap-<?php echo $wid ?>">
                <div class="post-grid-tab-1">
                    <div class="pgt-tab-items">
                        <ul>
                            <?php
                            $i = 0;
                            foreach ($items as $item):
                                $first = ($i === 0);
                                $activeCls = $first ? 'active' : '';
                                $data = array(
                                    'post_type' => $item['post_type'],
                                    'taxonomy' => $item['tax_name'],
                                    'category' => $item['cat_id'],
                                    'num' => $item['per_page'],
                                    'thumb' => $settings['item_cover_size'],
                                    'sm' => $settings['item_meta_show']
                                );
                                $i++;
                                ?>
                                <li class="elementor-repeater-item-<?php echo $item['_id'] . ' ' . $activeCls; ?>">
                                    <a href="#" class="pgt-item-btn" id="tab-item-<?php echo $item['_id'] ?>" data-wid="<?php echo $wid ?>" data-tab="#tab-content-<?php echo $item['_id'] ?>" data-settings="<?php echo base64_encode(json_encode($data)) ?>">
                                        <?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                        <?php echo $item['item_title'] ?>
                                        <div class="ahura-loader-ring"></div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="pgt-tabs-content">
                        <?php
                        $i = 0;
                        foreach ($items as $item):
                            $firstWrap = ($i === 0);
                            $activeCls = $firstWrap ? 'active' : '';
                            ?>
                            <div class="pgt-tab-content-wrap elementor-repeater-item-<?php echo $item['_id'] . ' ' . $activeCls; ?>" id="tab-content-<?php echo $item['_id'] ?>" style="display:<?php echo $firstWrap ? 'block' : 'none' ?>">
                                <div class="tab-head">
                                    <div class="row">
                                        <div class="col-6 text-<?php echo (is_rtl()) ? 'right' : 'left' ?>">
                                            <h3 class="tab-title"><?php echo $item['item_title'] ?></h3>
                                        </div>
                                        <div class="col-6 text-<?php echo (is_rtl()) ? 'left' : 'right' ?>">
                                            <?php if(!empty($item['item_archive_link']['url'])): ?>
                                                <a <?php $this->render_link_attrs($item['item_archive_link']) ?>class="tab-archive-btn">
                                                    <?php echo $item['item_box_more_btn_title'] ?>
                                                    <i class="fas fa-long-arrow-alt-<?php echo (is_rtl()) ? 'left' : 'right' ?>"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pgt-tab-content">
                                    <?php
                                    if ($firstWrap):
                                        $args = array('post_type' => $item['post_type'], 'posts_per_page' => $item['per_page'], 'post_status' => 'publish');

                                        if ($item['cat_id']) {
                                            $args['tax_query'] = array(
                                                'tax_query' => [
                                                    'relation' => 'OR',
                                                    [
                                                        'taxonomy' => $item['tax_name'],
                                                        'field' => 'term_id',
                                                        'terms' => $item['cat_id'],
                                                    ]
                                                ]
                                            );
                                        }

                                        $posts = new \WP_Query($args);
                                        $colors = ['red', 'violet', 'yellow', 'blue'];

                                        if ($posts->have_posts()):
                                            $i = 0;
                                            while ($posts->have_posts()): $posts->the_post();
                                                $img = wp_get_attachment_image_src(get_post_thumbnail_id(), $settings['item_cover_size']);
                                                $date = get_the_modified_date();
                                                $color = array_rand($colors, 1);
                                                $selected_color = $show_post_cover ? $colors[$color] : null;
                                                ?>
                                                <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                                                    <div class="post-item" style="background-image:url(<?php echo (isset($img[0])) ? $img[0] : '' ?>);<?php echo $show_post_cover ? "box-shadow:0 0 15px var(--ahura-post-grid-1-{$selected_color})" : '' ?>">
                                                        <div class="overly" style="background-color:<?php echo $show_post_cover ? "var(--ahura-post-grid-1-{$selected_color})" : '#0000006e' ?>"></div>
                                                        <div class="post-details">
                                                            <div class="post-top">
                                                                <?php if ($settings['item_meta_show'] === 'yes'): ?>
                                                                    <div class="post-metas">
                                                                        <div class="date">
                                                                            <i class="fas fa-calendar"></i>
                                                                            <span><?php echo $date ?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <h2 class="post-title"><?php the_title() ?></h2>
                                                            </div>
                                                            <div class="post-foot">
                                                                <a href="<?php echo get_the_permalink() ?>">
                                                                    <i class="fas fa-eye"></i>
                                                                    <span><?php echo $item['item_more_btn_title'] ?></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $i++;
                                            endwhile;
                                            wp_reset_query();
                                            wp_reset_postdata();
                                        else: ?>
                                            <div class="col-12">
                                                <div class="mw_element_error">
                                                    <?php echo esc_html__('Sorry,no posts were found for display.', 'ahura'); ?>
                                                </div>
                                            </div>
                                        <?php
                                        endif;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
    }
}
