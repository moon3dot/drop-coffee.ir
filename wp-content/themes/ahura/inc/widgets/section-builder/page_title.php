<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use Elementor\Plugin;
use Elementor\Controls_Manager;

class ahura_page_title extends \ahura\app\elementor\Elementor_Widget_Base
{
    public function get_name() {
        return 'ahura_page_title';
    }

    public function get_title() {
        return esc_html__( 'Page Title', 'ahura' );
    }

    public function get_icon() {
        return 'eicon-archive-title';
    }

    public function get_categories() {
        return ['ahura_archive'];
    }

    public function get_keywords() {
        return ['page_title', 'title', 'pagetitle', esc_html__( 'Page Title', 'ahura' )];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'title_styles',
            [
                'label' => esc_html__('Title', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $alignment = array(
            'right' => [
                'title' => esc_html__('Right', 'ahura'),
                'icon' => 'eicon-text-align-right',
            ],
            'center' => [
                'title' => esc_html__('Center', 'ahura'),
                'icon' => 'eicon-text-align-center',
            ],
            'left' => [
                'title' => esc_html__('Left', 'ahura'),
                'icon' => 'eicon-text-align-left',
            ]
        );
        if(!is_rtl())
        {
            $alignment = array_reverse($alignment);
        }

        $this->add_control(
            'title_alignment',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => $alignment,
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .ah-page-title-element' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'item_bg',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ah-page-title-element' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0b0c40',
                'selectors' => [
                    '{{WRAPPER}} .ah-page-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-page-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_weight' => ['default' => '900'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'em',
                            'size' => '1.4',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'title_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ah-page-title-element' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-page-title-element',
            ]
        );

        $this->add_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ah-page-title-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .ah-page-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'title_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ah-page-title-element',
            ]
        );

        $this->end_controls_section();
    }

    protected function should_show_page_title() {
        if (!function_exists('get_the_ID')) return false;

        $current_doc = Plugin::instance()->documents->get(get_the_ID());
        if ($current_doc && 'yes' === $current_doc->get_settings('hide_title')) {
            return false;
        }

        return true;
    }

    public function render()
    {
        if ( $this->should_show_page_title() ):?>
            <div class="ah-page-title-element">
                <h1 class="ah-page-title">
                    <?php
                    if (is_category()){
                        echo single_cat_title('', false);
                    } elseif(is_tag()){
                        echo single_tag_title('', false);
                    } elseif(is_archive()){
                        echo get_the_archive_title();
                    } else {
                        echo get_the_title();
                    }
                    ?>
                </h1>
            </div>
        <?php
        endif;
    }
}