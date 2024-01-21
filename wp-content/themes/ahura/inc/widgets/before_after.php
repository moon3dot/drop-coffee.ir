<?php
namespace ahura\inc\widgets;

use \Elementor\Controls_Manager;
use ahura\app\mw_assets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class before_after extends \Elementor\Widget_Base
{
    public function __construct($data=[], $args=[])
    {
        parent::__construct($data, $args);
        mw_assets::register_style('before_after', mw_assets::get_css('elementor.before_after'));
        mw_assets::register_script('before_after_js', mw_assets::get_js('elementor.before_after'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('before_after')];
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('before_after_js')];
    }

    public function get_name()
    {
        return 'ahura_before_after';
    }

    public function get_title()
    {
        return esc_html__('Before & After', 'ahura');
    }

    public function get_icon() {
		return 'eicon-image-before-after';
	}

    public function get_categories() {
		return ['ahuraelements'];
	}

    public function get_keywords()
    {
        return ['before_after', 'beforeafter', esc_html__('Before & After' , 'ahura')];
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
			'image1',
			[
				'label' => esc_html__('Image 1', 'ahura'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'image2',
			[
				'label' => esc_html__('Image 2', 'ahura'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->end_controls_section();
        /**
         * 
         * 
         * 
         * Styles
         * 
         * 
         */
        $this->start_controls_section(
            'content_styles',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'box_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('You should adjust the width of the box in proportion to the width of the original images.', 'ahura'),
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-image-before-after' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 3000
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100
                ],
            ]
        );

        $this->add_responsive_control(
            'box_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-image-before-after' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-image-before-after',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-image-before-after',
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        
        $original_img = $settings['image1'];
        $modified_img = $settings['image2'];

        if(empty($original_img['url']) || empty($modified_img['url'])){
            return false;
        }
        ?>
        <div class="ahura-image-before-after before-after-element">
            <figure class="cd-image-container">
                <?php if (!empty($original_img['id'])): ?>
                    <?php echo wp_get_attachment_image($original_img['id'], 'full'); ?>
                <?php else: ?>
                    <img src="<?php echo esc_url($original_img['url']); ?>" alt="Original Image">
                <?php endif; ?>
                <span class="cd-image-label" data-type="original"><?php echo __('Before', 'ahura') ?></span>

                <div class="cd-resize-img">
                    <?php if (!empty($modified_img['id'])): ?>
                        <?php echo wp_get_attachment_image($modified_img['id'], 'full'); ?>
                    <?php else: ?>
                        <img src="<?php echo esc_url($modified_img['url']); ?>" alt="Modified Image">
                    <?php endif; ?>
                    <span class="cd-image-label" data-type="modified"><?php echo __('After', 'ahura') ?></span>
                </div>

                <span class="cd-handle"></span>
            </figure>
        </div>
        <?php
    }
}