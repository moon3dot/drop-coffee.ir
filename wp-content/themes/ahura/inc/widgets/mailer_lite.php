<?php
namespace ahura\inc\widgets;

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class mailer_lite extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_mailer_lite';
    }
    function get_title()
    {
        return esc_html__('Mailer lite', 'ahura');
    }
    public function get_icon() {
		return 'aicon-svg-mailer-lite';
	}
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['mailer_lite', 'mailerlite', esc_html__( 'Mailer lite' , 'ahura')];
    }
    function __construct($data=[], $args=[])
    {
        parent::__construct($data, $args);
        $mailer_lite_css = mw_assets::get_css('elementor.mailer_lite');
        $mailer_lite_js = mw_assets::get_js('mailer_lite_element');
        mw_assets::register_style('ahura_element_mailer_lite', $mailer_lite_css);
        mw_assets::register_script('ahura_element_mailer_lite', $mailer_lite_js);
        wp_localize_script(mw_assets::get_handle_name('ahura_element_mailer_lite'), 'aeml', [
           'theme_url' => get_template_directory_uri()
        ]);
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('ahura_element_mailer_lite')];
    }
    function get_script_depends()
    {
        return [mw_assets::get_handle_name('ahura_element_mailer_lite')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'form_slug',
            [
                'label' => esc_html__('Form slug', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => sprintf(esc_html__('if your mailer lite form share url is %s, form slug is %s', 'ahura'), '<strong>https://landing.mailerlite.com/webforms/landing/b0f5h1</strong>', '<strong>b0f5h1</strong>'),
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Newsletter', 'ahura')
            ]
        );
        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Signup for news and special offers!', 'ahura'),
            ]
        );
        $this->add_control(
            'submit_btn_text',
            [
                'label' => esc_html__('Submit Button', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Subscribe', 'ahura')
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'fields_section',
            [
                'label' => esc_html__('Fields', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $fields_repeater = new \Elementor\Repeater();
        $fields_repeater->add_control(
            'field_type',
            [
                'label' => esc_html__('Field', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'name',
				'options' => [
					'email'  => __( 'Email', 'ahura' ),
					'name'  => __( 'Name', 'ahura' ),
					'last_name' => __( 'Last Name', 'ahura' ),
					'city' => __( 'City', 'ahura' ),
					'phone' => __( 'Phone', 'ahura' ),
					'state' => __( 'State', 'ahura' ),
					'company' => __( 'Company', 'ahura' ),
					'zip' => __( 'Zip', 'ahura' ),
					'country' => __( 'Country', 'ahura' ),
				],
            ]
        );
        $fields_repeater->add_control(
            'field_input_type',
            [
                'label' => esc_html__('Field type', 'ahura'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
				'options' => [
					'text'  => __( 'Text', 'ahura' ),
					'textarea' => __( 'Textarea', 'ahura' ),
				],
            ]
        );
        $fields_repeater->add_control(
            'field_placeholder',
            [
                'label' => esc_html__('Field placeholder', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $fields_repeater->add_control(
            'field_is_required',
            [
                'label' => esc_html__('Is required?', 'ahura'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 1
            ]
        );
        $email_field = [
            'field_placeholder' => esc_html__('Email', 'ahura'),
            'field_type' => 'email',
            'field_input_type' => 'text',
            'field_is_required' => 1
        ];
        $this->add_control(
            'mailer_lite_fields',
            [
                'label' => esc_html__('Fields', 'ahura'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $fields_repeater->get_controls(),
                'title_field' => '{{{field_type}}}',
                'default' => [
                    $email_field
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'thanks_section',
            [
                'label' => esc_html__('Thanks message', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'thanks_title',
            [
                'label' => esc_html__('Thanks message title', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Thank you!', 'ahura')
            ]
        );
        $this->add_control(
            'thanks_content',
            [
                'label' => esc_html__('Thanks message content', 'ahura'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('You have successfully joined our subscriber list.', 'ahura')
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
            'title_style_section',
            [
                'label' => esc_html__('Title Style', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody h4' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mailer_lite .ml-form-successBody h4' => 'color: {{VALUE}}',
                ],
                'default' => '#35495C'
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'name' => 'title_typography',
				'label' => __( 'Typography', 'ahura' ),
				'selector' => '{{WRAPPER}} .mailer_lite .ml-form-embedBody h4, {{WRAPPER}} .mailer_lite .ml-form-successBody h4',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '25'
                        ]
                    ]
                ]
			]
		);
        $this->add_control(
			'title_margin',
			[
				'label' => __( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'isLinked' => false
                ],
				'selectors' => [
					'{{WRAPPER}} .mailer_lite .ml-form-embedBody h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mailer_lite .ml-form-successBody h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->end_controls_section();
        $this->start_controls_section(
            'description_style_section',
            [
                'label' => esc_html__('Description Style', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody p' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mailer_lite .ml-form-successBody p' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'name' => 'description_typography',
				'label' => __( 'Typography', 'ahura' ),
				'selector' => '{{WRAPPER}} .mailer_lite .ml-form-embedBody p, {{WRAPPER}} .mailer_lite .ml-form-successBody p',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '18'
                        ]
                    ]
                ]
			]
		);
        $this->add_control(
			'description_margin',
			[
				'label' => __( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'bottom' => '15',
                    'isLinked' => false,
                ],
				'selectors' => [
					'{{WRAPPER}} .mailer_lite .ml-form-embedBody p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mailer_lite .ml-form-successBody p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->end_controls_section();
        $this->start_controls_section(
            'fields_style_section',
            [
                'label' => esc_html__('Fields style', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'fields_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form input' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form textarea' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form input' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form textarea' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'input_background',
                'label' => __( 'Background Color', 'ahura' ),
                'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form input, {{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form textarea',
                'fields_options' => [
                    'background' =>
                        [
                            'default' => 'classic'
                        ],
                    'color' =>
                        [
                            'default' => '#fff'
                        ],
                ]
            ]
        );

        $this->add_control(
            'input_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form input, {{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                ]
            ]
        );

        $this->add_control(
			'field_margin',
			[
				'label' => __( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'isLinked' => false,
                    'bottom' => '10'
                ],
				'selectors' => [
					'{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_input_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form input, {{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form textarea',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form input, {{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-block-form textarea',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button Style', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'submit_button_text_color',
            [
                'label' => esc_html__('Submit button text color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#35495C',
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-form-embedSubmit button' => 'color: {{VALUE}}'
                ],
            ]
        );
        $this->add_control(
            'submit_button_bg_color',
            [
                'label' => esc_html__('Submit button background color', 'ahura'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fcc52f',
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-form-embedSubmit button' => 'background-color: {{VALUE}} !important'
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'name' => 'submit_button_typography',
				'label' => __( 'Typography', 'ahura' ),
				'selector' => '{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-form-embedSubmit button',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '13'
                        ]
                    ]
                ]
			]
		);
        $this->add_control(
			'submit_button_margin',
			[
				'label' => __( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'isLinked' => false,
                    'top' => '10'
                ],
				'selectors' => [
					'{{WRAPPER}} .mailer_lite .ml-form-embedBody .ml-form-embedSubmit button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .ml-form-embedSubmit button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 4,
                    'right' => 4,
                    'bottom' => 4,
                    'left' => 4,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ml-form-embedSubmit button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ml-form-embedSubmit button',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'box_style',
            [
                'label' => esc_html__('Box Style', 'ahura'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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

        $this->add_responsive_control(
            'box_text_align',
            [
                'label' => esc_html__('Text Alignment', 'ahura'),
                'type' => Controls_Manager::CHOOSE,
                'options' => (is_rtl()) ? $alignment : array_reverse($alignment),
                'default' => (is_rtl()) ? 'right' : 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mailer_lite_bg',
                'label' => __( 'Background', 'ahura' ),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mailer_lite',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#ffffff'
                    ]
                ]
            ]
        );

        $this->add_control(
            'box_radius',
            [
                'label' => esc_html__( 'Border Radius', 'ahura' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .mailer_lite' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .mailer_lite',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mailer_lite_box_shadow',
                'selector' => '{{WRAPPER}} .mailer_lite',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 7,
                            'blur' => 30,
                            'spread' => 0,
                            'color' => 'rgba(0,0,0,.1)'
                        ]
                    ]
                ]
            ]
        );
        $this->end_controls_section();
    }
    private function render_fields($fields)
    {
        if(!$fields)
        {
            return false;
        }
        foreach($fields as $field):
        $wrapper_class_list = [];
        $wrapper_class_list[] = 'ml-field-' . $field['field_type'];
        if($field['field_type'] == 'email')
        {
            $wrapper_class_list[] = 'ml-validate-email';
        }
        // check if is required field
        if($field['field_is_required'])
        {
            $wrapper_class_list[] = 'ml-validate-required';
        }
        $wrapper_class = implode(' ', $wrapper_class_list);
        ?>
        <div class="ml-form-fieldRow">
            <div class="ml-field-group <?php echo $wrapper_class?>">
                <?php if($field['field_type'] == 'email'):?>
                    <input aria-label="email" aria-required="true" type="email" class="form-control" data-inputmask="" name="fields[email]" placeholder="<?php echo $field['field_placeholder']?>" autocomplete="email">
                <?php else:?>
                    <?php $this->render_field($field['field_type'], $field['field_input_type'], $field['field_placeholder']);?>
                <?php endif;?>
            </div>
        </div>
        <?php endforeach;
    }
    private function render_field($field_name, $field_input_type, $field_placeholder)
    {
        if($field_input_type == 'text'):?>
            <input aria-label="<?php echo $field_name?>" type="text" class="form-control" data-inputmask="" name="fields[<?php echo $field_name?>]" placeholder="<?php echo $field_placeholder?>" autocomplete="<?php echo $field_name?>">
        <?php elseif($field_input_type == 'textarea'):?>
            <textarea class="form-control" name="fields[<?php echo $field_name?>]" aria-label="<?php echo $field_name?>" maxlength="255" placeholder="<?php echo $field_placeholder?>" aria-invalid="false"></textarea>
        <?php endif;
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $form_slug = $settings['form_slug'];
        $form_slug = $form_slug ? $form_slug : (!is_admin() ? uniqid() : false);
        ?>
        <div class="mailer_lite">
            <?php if(!$form_slug && !is_admin()): ?>
                <div><?php esc_html_e('You must enter mailer lite form slug in mailer lite element', 'ahura')?></div>
            <?php else: ?>
            <div id="mlb2-ahura_mailer_lite_element_wrapper" class="ml-form-embedContainer ml-subscribe-form ml-subscribe-form-ahura_mailer_lite_element_wrapper">
                <div class="ml-form-align-center">
                    <div class="ml-form-embedWrapper embedForm">
                    <div class="ml-form-embedBody ml-form-embedBodyDefault row-form">
                        <div class="ml-form-embedContent">
                        <h4><?php echo $settings['title']; ?></h4>
                        <p><?php echo $settings['description']; ?></p>
                        </div>
                        <form class="ml-block-form" action="https://static.mailerlite.com/webforms/submit/<?php echo $form_slug;?>" data-code="<?php echo $form_slug?>" method="post" target="_blank">
                            <div class="ml-form-formContent">
                                <?php $this->render_fields($settings['mailer_lite_fields']);?>
                            </div>
                            <input type="hidden" name="ml-submit" value="1">
                            <div class="ml-form-embedSubmit">
                                <button type="submit" class="primary"><?php echo $settings['submit_btn_text'];?></button>
                                <button disabled="disabled" style="display:none" type="button" class="loading"> <div class="ml-form-embedSubmitLoad"></div> <span class="sr-only"><?php esc_html_e('Loading...', 'ahura')?></span> </button>
                            </div>
                            <input type="hidden" name="anticsrf" value="true">
                        </form>
                    </div>
                    <div class="ml-form-successBody row-success" style="display:none">
                        <div class="ml-form-successContent">
                            <h4><?php echo $settings['thanks_title']; ?></h4>
                            <p><?php echo $settings['thanks_content']; ?></p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
}