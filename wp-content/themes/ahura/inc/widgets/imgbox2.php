<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

class imgbox2 extends \Elementor\Widget_Base
{
    /**
     * imgbox2 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('imgbox2_css', mw_assets::get_css('elementor.imgbox2'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('imgbox2_css')];
    }

    public function get_name()
    {
        return 'imagebox2';
    }
  
    public function get_title()
    {
        return __('Image Box 2', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-imgbox2';
    }

    public function get_categories()
    {
        return [ 'ahuraelements' ];
    }
    function get_keywords()
    {
        return ['imgbox2', 'img_box2', 'image_box_2', 'imagebox2', esc_html__( 'Image Box 2' , 'ahura')];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                "default" => __("Title Here", 'ahura')
            ]
        );
        
        $this->add_control(
            'subtitle',
            [
            'label' => __('Subtitle', 'ahura'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __("Subtitle Here", 'ahura')
        ]
        );
    
        $this->add_control(
            'image',
            [
                'label' => __('Image', 'ahura'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => ['url' => get_template_directory_uri() . '/img/mihanwp.png']
            ]
		);

        $this->add_control(
            'boxurl',
            [
                'label' => __('URL', 'ahura'),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => ['active' => true],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'content_styles',
            [
                'label' => __('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'textcolor',
            [
                'label' => __('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                        '{{WRAPPER}} a.imgbox2 *' => 'color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'hover_text_color',
            [
                'label' => __("Hover Text Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' =>
                    [
                        '{{WRAPPER}} a.imgbox2:hover *' => 'color: {{VALUE}};'
                    ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .imgbox2 span',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15',
                        ]
                    ]
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Subtitle Typography', 'ahura'),
                'name' => 'item_subtitle_typography',
                'selector' => '{{WRAPPER}} .imgbox2 p',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '22',
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles',
            [
                'label' => __('Box', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'backgrounc-color',
            [
                'label' => __('Background Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' =>
                    [
                        '{{WRAPPER}} .imgbox2' => 'background-color: {{VALUE}};'
                    ]
            ]
        );
        $this->add_control(
            'hover_bg_color',
            [
                'label' => __("Hover Background Color", 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f34b59',
                'selectors' =>
                    [
                        '{{WRAPPER}} a.imgbox2:hover' => 'background-color: {{VALUE}};box-shadow:0 0 20px {{VALUE}};'
                    ]
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .imgbox2' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_item_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .imgbox2',
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $img = $settings['image']['url'];
        $this->add_inline_editing_attributes('title', 'none');
        $this->add_inline_editing_attributes('subtitle', 'none');
        if ( ! empty( $settings['boxurl']['url'] ) ) {
            $this->add_link_attributes( 'boxurl', $settings['boxurl'] );
        }
        ?>
        <a <?php echo $this->get_render_attribute_string( 'boxurl' ); ?> class="imgbox2">
            <?php if ($img): ?>
                <img src="<?php echo $img; ?>" alt="Image Box"/>
            <?php endif; ?>
            <span <?php echo $this->get_render_attribute_string('title')?>><?php echo $settings['title']; ?></span>
            <p <?php echo $this->get_render_attribute_string('subtitle')?>><?php echo $settings['subtitle']; ?></p>
        </a>
	   <?php
    }
}
