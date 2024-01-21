<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use ahura\app\mw_tools;

// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');


class typewriter extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'TypeWriter';
    }

    public function get_title()
    {
        return __('TypeWriter', 'ahura');
    }

    public function get_icon()
    {
        return 'aicon-svg-typewriter';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }
    public function get_keywords()
    {
        return ['typewriter', esc_html__( 'TypeWriter' , 'ahura')];
    }

    public function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        $version = mw_tools::get_theme_version();
        $typewriter_css = mw_assets::get_css('elementor.typewriter');
        mw_assets::register_style('typewriter', $typewriter_css);
        mw_assets::register_script('typewriter', mw_assets::get_js('elementor.typewriter'));
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('typewriter')];
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('typewriter')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text_fixed',
            [
                'label'    => __('Text Fixed', 'ahura'),
                'type'     => \Elementor\Controls_Manager::TEXT,
                'default' => __("Text Fixed", 'ahura')
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => __( 'Text', 'ahura' ),
                'type'     => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __( 'Text one', 'ahura' ),
                'default' => __( 'Text one', 'ahura' ),
            ]
        );

        $this->add_control(
			'text_list',
			[
				'label' => __( 'Text List', 'ahura' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => __( 'Text one', 'ahura' ),
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

        $this->add_control(
			'align',
			[
				'label' => __( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'default' => 'center',
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
         * 
         */
        $this->start_controls_section(
            'content_styles',
            [
                'label' => __('Content', 'ahura'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_fixed_style',
            [
                'label'   => __('ّFixed text color', 'ahura'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .typewriter-fixed' => 'color: {{VALUE}}'
                ],
                'default' => '#444'
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_fixed_typography',
				'label' => __("Fixed text Typography","ahura"),
				'selector' => '{{WRAPPER}} .typewriter-fixed',
				'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '23'
						]
					]
				]
			]
		);
        $this->add_control(
            'text_change_style',
            [
                'label'   => __('Fluid Text Color', 'ahura'),
                'type'    => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .Typewriter__wrapper' => 'color: {{VALUE}}'
                ],
                'default' => '#444'
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_change_typography',
				'label' => __("ّFluid Text Typography","ahura"),
				'selector' => '{{WRAPPER}} .typewriter *',
				'fields_options' =>
				[
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '23'
						]
					]
				]
			]
		);

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
    ?>
        <div class="typewriter-element typewriter-box-<?php echo $settings['align']?>">
            <span class="typewriter-fixed"><?php echo $settings['text_fixed']; ?></span>
            <?php
            $str = '';
            foreach ( $settings['text_list'] as $item ){
                $str .= '"'.$item['text'].'",';
            }
            ?>
            <div class="typewriter typewriter-<?php echo $wid ?>">
                <span class="Typewriter__wrapper Typewriter__wrapper-<?php echo $wid ?>" data-period="2500" data-text='[<?php echo substr($str, 0, -1) ?>]'></span>
                <span class="Typewriter__cursor">|</span>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    ahura_typewriter('Typewriter__wrapper-<?php echo $wid ?>');
                });
            </script>
        </div>
    <?php
    }
}
