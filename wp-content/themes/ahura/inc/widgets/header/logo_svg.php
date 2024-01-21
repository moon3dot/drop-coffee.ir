<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use ahura\app\mw_assets;

defined('ABSPATH') || exit('No Access');

class Elementor_ahura_logo_svg extends \Elementor\Widget_Base
{
    public function __construct($data=[], $args=[])
    {
        parent::__construct($data, $args);
        mw_assets::register_style('logo_svg_css', mw_assets::get_css('elementor.logo_svg'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('logo_svg_css')];
        return $styles;
    }

    function get_name()
    {
        return 'ahura_logo_svg';
    }

    function get_title()
    {
        return esc_html__('SVG Logo', 'ahura');
    }

    function get_icon()
    {
        return 'eicon-logo';
    }

    function get_categories()
    {
        return ['ahuraheader'];
    }

    public function get_keywords()
    {
        return ['logo_svg', 'logosvg', esc_html__('SVG Logo' , 'ahura')];
    }

    public function register_controls()
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
                'media_types' => ['svg'],
                'default' => [
                    'url' => \ahura\app\mw_assets::get_img('ahura-logo', 'svg')
                ],
                'condition' => [
                        'use_svg!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'use_svg',
            [
                'label' => esc_html__('SVG Content', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'svg_content',
            [
                'label' => esc_html__( 'Content', 'ahura' ),
                'type' => Controls_Manager::TEXTAREA,
                'description' => __('Put the content of the SVG file in this field.', 'ahura'),
                'condition' => [
                    'use_svg' => 'yes'
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

        $this->start_controls_section(
            'section_image_style',[
                'label' => __('Image', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => __('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 250,
                    'unit' => 'px'
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
                    '{{WRAPPER}} .ahura-logo-element img, {{WRAPPER}} .ahura-logo-element svg' => 'width: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => __('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'default' => [
                    'size' => 150,
                    'unit' => 'px'
                ],
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
                    '{{WRAPPER}} .ahura-logo-element img, {{WRAPPER}} .ahura-logo-element svg' => 'height: {{SIZE}}{{UNIT}}'
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
                    '{{WRAPPER}} .ahura-logo-element, {{WRAPPER}} .ahura-logo-element a' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $site_link = home_url();
        $classes = [];
        $img = isset($settings['image']['url']) && !empty($settings['image']['url']) ? $settings['image']['url'] : null;
        $img_id = isset($settings['image']['id']) && !empty($settings['image']['id']) ? $settings['image']['id'] : null;

        if($settings['hide_in_scroll']){
            $classes[] = 'hide_in_scroll';
        }

        $class_names = implode(' ', $classes);
        ?>
        <div class="ahura-logo-element ahura-svg-logo-element <?php echo $class_names ?>">
            <a href="<?php echo $site_link ?>">
                <?php if ($settings['use_svg'] === 'yes'): ?>
                    <?php echo $settings['svg_content'] ?>
                <?php else: ?>
                    <?php
                    $file_path = get_attached_file($img_id, true);
                    $is_svg = !empty($file_path) && strpos(strtolower($file_path), '.svg') !== false;
                    if ($img_id && !empty($file_path) && $is_svg):
                        echo file_get_contents($file_path);
                    else: ?>
                        <img src="<?php echo !empty($img) ? $img : ''; ?>" alt="<?php echo get_bloginfo('name') ?>">
                    <?php endif; ?>
                <?php endif; ?>
            </a>
        </div>
        <?php
    }
}
