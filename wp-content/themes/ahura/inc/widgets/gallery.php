<?php
namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class gallery extends \Elementor\Widget_Base
{
    /**
     * gallery constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('gallery_css', mw_assets::get_css('elementor.gallery'));
        if(!is_rtl()){
            mw_assets::register_style('gallery_ltr_css', mw_assets::get_css('elementor.ltr.gallery_ltr'));
        }
        mw_assets::register_style('simple_lightbox_css', mw_assets::get_css('simple-lightbox-min'));
        mw_assets::register_script('gallery_js', mw_assets::get_js('elementor.gallery'));
        wp_localize_script(mw_assets::get_handle_name('gallery_js'), 'ahura_gallery_data', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
        mw_assets::register_script('simple_lightbox_js', mw_assets::get_js('simple-lightbox-min'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('gallery_css'), mw_assets::get_handle_name('simple_lightbox_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('gallery_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('simple_lightbox_js'), mw_assets::get_handle_name('gallery_js')];
    }

    public function get_name()
    {
        return 'ahura_gallery';
    }

    public function get_title()
    {
        return esc_html__('Gallery', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['gallery', esc_html__('Gallery', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'tabs_content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'gallery',
            [
                'label' => esc_html__( 'Images', 'ahura' ),
                'type' => Controls_Manager::GALLERY,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'show_caption',
            [
                'label' => esc_html__('Show Caption', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Count', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'condition' => [
                    'show_pagination' => 'yes'
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

        $this->end_controls_section();
        /**
         *
         *
         * item styles
         *
         *
         */
        $this->start_controls_section(
            'item_cap_styles',
            [
                'label' => esc_html__('Caption', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_caption' => 'yes']
            ]
        );

        $this->add_control(
            'cap_text_color',
            [
                'label'   => __( 'Color', 'ahura' ),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .item-title' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => __('Typography', 'ahura'),
                'name' => 'cap_typography',
                'selector' => '{{WRAPPER}} .item-title',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16',
                        ]
                    ],
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cap_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .item-title',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => '#00000085'],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'item_img_styles',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_img_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'em', 'rem'],
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
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery-item-box' => 'width: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'item_img_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'em', 'rem'],
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
                'default' => [
                    'unit' => 'px',
                    'size' => 210,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery-item-box' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'item_img_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery-item-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_img_border',
                'selector' => '{{WRAPPER}} .gallery-item-box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_img_box_shadow',
                'selector' => '{{WRAPPER}} .gallery-item-box',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'item_img_custom_css_filters',
                'selector' => '{{WRAPPER}} .gallery-item-box',
            ]
        );

        $this->end_controls_section();
        /**
         *
         *
         * item pagination styles
         *
         *
         */
        $this->start_controls_section(
            'item_pagination_styles',
            [
                'label' => esc_html__('Pagination', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('item_pagination_styles_tabs');

        $this->start_controls_tab(
            'item_pagination_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_pagination_typo',
                'selector' => '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '16'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_pagination_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_pagination_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination a, {{WRAPPER}} .ahura-pagination span',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 2,
                            'blur' => 10,
                            'spread' => 0,
                            'color' => '#0000003b'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_pagination_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_pagination_border_hover',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_pagination_shadow_hover',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination a:hover, {{WRAPPER}} .ahura-pagination span:hover',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'item_pagination_styles_active_tab',
            [
                'label' => esc_html__('Active', 'ahura'),
            ]
        );

        $this->add_control(
            'item_pagination_buttons_text_color_active',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_bg_color_active',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_pagination_buttons_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-pagination span.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_pagination_border_active',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination span.current',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_pagination_shadow_active',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-pagination span.current',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     *
     * Render content for display
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();

        $items = $settings['gallery'];

        $page = $_GET['page_num'] ?? false;
        $current_page = ($page == 0) ? 1 : $page;
        $show_pagination = $settings['show_pagination'] == 'yes';
        $per_page = $show_pagination ? $settings['per_page'] : -1;

        $posts_in = [];

        if($items){
            foreach($items as $item){
                $posts_in[] = $item['id'];
            }
        }

        $args = array(
            'post_type' => 'attachment',
            'posts_per_page' => $per_page,
            'post_status' => 'any',
            'post__in' => $posts_in,
            'show_pagination' => $show_pagination,
            'item_cover_size' => $settings['item_cover_size'],
            'show_caption' => $settings['show_caption']
        );

        if(empty($posts_in)){
            $args['show_pagination'] = false;
            $show_pagination = false;
            $args['showposts'] = 4;
        }

        if ($show_pagination) {
            $args['paged'] = $current_page;
        }
        ?>
        <div class="ahura-gallery-element ahura-gallery-element-<?php echo $wid ?>">
            <div class="gallery-tabs-content">
                <div class="gallery-content-wrap" data-wid="<?php echo $wid ?>" data-settings="<?php echo base64_encode(json_encode($args)) ?>">
                    <div class="row">
                        <?php
                        $posts = new \WP_Query($args);

                        if ($posts->have_posts()):
                            $i = 0;
                            while ($posts->have_posts()): $posts->the_post();
                                include get_template_directory() . '/template-parts/loop/elementor/gallery-load-ajax.php';
                                $i++;
                            endwhile;
                            wp_reset_query();
                            wp_reset_postdata();
                        else: ?>
                            <div class="col-12">
                                <div class="ahura-element-msg">
                                    <?php echo esc_html__('Sorry,no gallery were found for display.', 'ahura'); ?>
                                </div>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                    <?php if($show_pagination && $posts->found_posts): ?>
                        <div class="ahura-pagination">
                            <?php ahura_custom_pagination($posts->found_posts, $per_page, $current_page, null, '<i class="fas fa-angle-right"></i>', '<i class="fas fa-angle-left"></i>'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}