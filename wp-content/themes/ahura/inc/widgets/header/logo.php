<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

defined('ABSPATH') || exit('No Access');
class Elementor_ahura_logo extends \Elementor\Widget_Base
{
    function get_name()
    {
        return 'ahura_logo';
    }
    function get_title()
    {
        return esc_html__('Logo', 'ahura');
    }
    function get_icon()
    {
        return 'eicon-logo';
    }
    function get_categories()
    {
        return ['ahuraheader'];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_image',[
                'label' => __('Image', 'ahura')
            ]
        );
        $this->add_control(
            'image',
            [
                'label' => __('Choose Image', 'ahura'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \ahura\app\mw_assets::get_img('ahura-logo')
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'full',
                'separator' => 'none'
            ]
        );
        $this->add_responsive_control(
            'width',
            [
                'label' => __('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%'
                ],
                'tablet_default' => [
                    'unit' => '%'
                ],
                'mobile_default' => [
                    'unit' => '%'
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura-logo-element img' => 'width: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'ahura'),
                        'icon' => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => __('Center', 'ahura'),
                        'icon' => 'eicon-text-align-center'
                    ],
                    'right' => [
                        'title' => __('Right', 'ahura'),
                        'icon' => 'eicon-text-align-right'
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .ahura-logo-element a' => 'justify-items: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'hide_in_scroll',
            [
                'label' => __('Hide in scroll', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'description' => __('This feature is work just in header', 'ahura'),
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $site_link = home_url();
        $classes = ['ahura-logo-element'];
        if($settings['hide_in_scroll'])
        {
            $classes[] = 'hide_in_scroll';
        }
        $class_args = sprintf('class="%s"', implode(' ', $classes));
        ?>
        <div <?php echo $class_args ?>>
            <a href="<?php echo $site_link ?>">
                <?php echo Group_Control_Image_Size::get_attachment_image_html($settings); ?>
            </a>
        </div>
    <?php
    }
}
