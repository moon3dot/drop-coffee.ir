<?php
namespace ahura\inc\widgets;

use \Elementor\Controls_Manager;
use ahura\app\mw_assets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class lottie extends \Elementor\Widget_Base
{
    public function __construct($data=[], $args=[])
    {
        parent::__construct($data, $args);
        mw_assets::register_script('lottie_element_js', mw_assets::get_js('elementor.lottie'), null, false);
        mw_assets::register_script('lottie_js', mw_assets::get_js('lottie-min'), null, false);
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('lottie_js'), mw_assets::get_handle_name('lottie_element_js')];
    }

    public function get_name()
    {
        return 'ahura_lottie';
    }

    public function get_title()
    {
        return esc_html__('Lottie', 'ahura');
    }

    public function get_icon() {
        return 'eicon-lottie';
    }

    public function get_categories() {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['lottie', esc_html__('Lottie' , 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'source',
            [
                'label' => esc_html__( 'Source', 'ahura' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'media_file',
                'options' => [
                    'media_file' => esc_html__( 'Media File', 'ahura' ),
                    'external_url' => esc_html__( 'External Url', 'ahura' ),
                ],
            ]
        );

        $this->add_control(
            'media',
            [
                'label' => esc_html__( 'Upload JSON File', 'ahura' ),
                'type' => Controls_Manager::MEDIA,
                'media_types' => ['json'],
                'default' => [
                    'url' => 'https://lottie.host/830453db-4656-4b6c-a458-9e9c6498c8d3/AIBh4PokYQ.json',
                ],
                'condition' => [
                    'source' => 'media_file'
                ]
            ]
        );

        $this->add_control(
            'external_url',
            [
                'label' => esc_html__( 'External Url', 'ahura' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => 'https://lottie.host/830453db-4656-4b6c-a458-9e9c6498c8d3/AIBh4PokYQ.json',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'condition' => [
                    'source' => 'external_url'
                ]
            ]
        );

        $this->add_control(
            'custom_link_status',
            [
                'label' => esc_html__('Custom Link', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'custom_link',
            [
                'label' => esc_html__( 'Link', 'ahura' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'dynamic' => ['active' => true],
                'condition' => [
                    'custom_link_status' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'trigger',
            [
                'label' => esc_html__( 'Trigger', 'ahura' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'onclick' => esc_html__( 'On Click', 'ahura' ),
                    'onhover' => esc_html__( 'On Hover', 'ahura' ),
                    'scroll' => esc_html__( 'Scroll', 'ahura' ),
                    'none' => esc_html__( 'Autoplay', 'ahura' ),
                ],
            ]
        );

        $this->add_control(
            'play_speed',
            [
                'label' => esc_html__( 'Play Speed', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'step' => 0.1,
                        'max' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'render',
            [
                'label' => esc_html__( 'Renderer', 'ahura' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'svg',
                'options' => [
                    'svg' => 'SVG',
                    'canvas' => 'Canvas',
                ],
            ]
        );

        $this->add_control(
            'lazyload',
            [
                'label' => esc_html__('Lazy Load', 'ahura'),
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
         * Styles
         *
         *
         */
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
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

        $this->add_control(
            'box_alignment',
            [
                'label' => esc_html__('Position', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .ahura-lottie-element' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'box_width',
            [
                'label' => esc_html__( 'Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} svg, {{WRAPPER}} canvas' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_max_width',
            [
                'label' => esc_html__( 'Max Width', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} svg, {{WRAPPER}} canvas' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('box_styles_tabs');
        $this->start_controls_tab(
            'box_styles_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'box_opacity',
            [
                'label' => esc_html__( 'Opacity', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 0.01,
                        'max' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} svg, {{WRAPPER}} canvas' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'box_css_filters',
                'selector' => '{{WRAPPER}} svg, {{WRAPPER}} canvas',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'box_styles_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'box_opacity_hover',
            [
                'label' => esc_html__( 'Opacity', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 0.01,
                        'max' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} svg:hover, {{WRAPPER}} canvas:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'box_css_filters_hover',
                'selector' => '{{WRAPPER}} svg:hover, {{WRAPPER}} canvas:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        $url = $settings['source'] == 'media_file' ? $settings['media']['url'] : $settings['external_url']['url'];
        $has_link = $settings['custom_link_status'] === 'yes';
        $trigger = $settings['trigger'];

        if ($has_link && !empty($settings['custom_link']['url'])) {
            $this->add_link_attributes('custom_link', $settings['custom_link']);
        }
        ?>
        <div class="ahura-lottie-element">
            <?php if (is_admin()): ?>
            <div class="lottie-animation-none" style="opacity:0;">none</div>
            <?php endif; ?>
            <?php if ($has_link): ?>
            <a <?php echo $this->get_render_attribute_string('custom_link'); ?>>
            <?php endif; ?>
                <div id="lottie-element-<?php echo $wid ?>"></div>
            <?php if ($has_link): ?>
            </a>
            <?php endif; ?>
            <script>
                jQuery(document).ready(function (){
                    ahuraLottieElementAnimationHandle({
                        container: document.getElementById('lottie-element-<?php echo $wid ?>'),
                        path: '<?php echo $url ?>',
                        loop: <?php echo $settings['loop'] === 'yes' ? 'true' : 'false' ?>,
                        autoplay: <?php echo in_array($trigger, ['none', 'autoplay']) ? 'true' : 'false' ?>,
                        renderer: '<?php echo $settings['render'] ?>',
                        trigger: '<?php echo $trigger ?>',
                        playSpeed: <?php echo $settings['play_speed']['size'] ?>,
                        lazyload: <?php echo $settings['lazyload'] === 'yes' ? 'true' : 'false' ?>
                    });
                });
            </script>
        </div>
        <?php
    }
}