<?php
namespace ahura\inc\widgets;

use \Elementor\Controls_Manager;
use ahura\app\mw_assets;

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class mailer_lite2 extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;

    public function __construct($data=[], $args=[])
    {
        parent::__construct($data, $args);
        mw_assets::register_style('mailer_lite2', mw_assets::get_css('elementor.mailer_lite2'));
        if(!is_rtl()){
            mw_assets::register_style('mailer_lite2_ltr', mw_assets::get_css('elementor.ltr.mailer_lite2_ltr'));
        }
        mw_assets::register_script('mailer_lite2_js', mw_assets::get_js('elementor.mailer_lite2'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('mailer_lite2')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('mailer_lite2_ltr');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('mailer_lite2_js')];
    }

    public function get_name()
    {
        return 'mailer_lite2';
    }

    public function get_title()
    {
        return esc_html__('Mailer lite 2', 'ahura');
    }

    public function get_icon() {
		return 'aicon-svg-mailer-lite';
	}

    public function get_categories() {
		return ['ahuraelements'];
	}

    public function get_keywords()
    {
        return ['mailer_lite2', 'mailerlite2', esc_html__( 'Mailer lite 2' , 'ahura')];
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
            'api_key',
            [
                'label' => esc_html__('Api Key', 'ahura'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'submit_btn_text',
            [
                'label' => esc_html__('Submit Button', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Subscribe', 'ahura')
            ]
        );

        $this->add_control(
            'submit_move_end',
            [
                'label' => esc_html__('Submit button move to end', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no'
            ]
        );

        $this->add_control(
            'thanks_content',
            [
                'label' => esc_html__('Thanks message content', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('You have successfully joined our subscriber list.', 'ahura')
            ]
        );

        $this->add_control(
            'error_content',
            [
                'label' => esc_html__('Error message content', 'ahura'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('An error occurred, please try again.', 'ahura')
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'fields_section',
            [
                'label' => esc_html__('Fields', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $fields_repeater = new \Elementor\Repeater();

        $fields_repeater->add_control(
            'field_type',
            [
                'label' => esc_html__('Field', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 'name',
				'options' => [
					'email'  => esc_html__( 'Email', 'ahura' ),
					'name'  => esc_html__( 'Name', 'ahura' ),
					'last_name' => esc_html__( 'Last Name', 'ahura' ),
					'city' => esc_html__( 'City', 'ahura' ),
					'phone' => esc_html__( 'Phone', 'ahura' ),
					'state' => esc_html__( 'State', 'ahura' ),
					'company' => esc_html__( 'Company', 'ahura' ),
					'zip' => esc_html__( 'Zip', 'ahura' ),
					'country' => esc_html__( 'Country', 'ahura' ),
				],
            ]
        );

        $fields_repeater->add_control(
            'field_input_type',
            [
                'label' => esc_html__('Field type', 'ahura'),
                'type' => Controls_Manager::SELECT,
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
                'type' => Controls_Manager::TEXT,
            ]
        );

        $fields_repeater->add_control(
            'field_is_required',
            [
                'label' => esc_html__('Is required?', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no'
            ]
        );

        $fields_repeater->add_control(
            'field_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-at',
                    'library' => 'solid'
                ]
            ]
        );

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields_repeater->get_controls(),
                'title_field' => '{{{field_type}}}',
                'default' => [
                    [
                        'field_placeholder' => esc_html__('Email', 'ahura'),
                        'field_type' => 'email',
                        'field_input_type' => 'text',
                        'field_is_required' => 'yes'
                    ]
                ]
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
            'fields_style',
            [
                'label' => esc_html__('Fields', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'fields_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} button' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40
                ],
            ]
        );

        $alignment = [
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
        ];

        $this->add_control(
            'box_text_alignment',
            [
                'label' => esc_html__('Alignment', 'ahura'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => is_rtl() ? $alignment : array_reverse($alignment),
                'default' => is_rtl() ? 'right' : 'left',
                'selectors' => [
                    '{{WRAPPER}} .ml-form-input :where(input, textarea)' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => esc_html__('Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ml-form-input :where(input, textarea)' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#464646',
                'selectors' => [
                    '{{WRAPPER}} .ml-form-input i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ml-form-input svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typo',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ml-form-input :where(input, textarea)',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_control(
            'input_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .ml-form-input :where(input, textarea)' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ml-form-input :where(input, textarea)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ml-form-input :where(input, textarea)',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ml-form-input :where(input, textarea)',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'button_styles',
            [
                'label' => esc_html__('Button', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .ml-form-submit button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typo',
                'label' => esc_html__('Typography', 'ahura'),
                'selector' => '{{WRAPPER}} .ml-form-submit button',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '15'
                        ]
                    ],
                    'font_weight' => [
                        'default' => '400'
                    ],
                ]
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__('Background Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .ml-form-submit button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ml-form-submit button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'isLinked' => true,
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ml-form-submit button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .ml-form-submit button',
                'fields_options' => [
                    'box_shadow_type' => ['default' => 'yes'],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 11,
                            'blur' => 24,
                            'spread' => -10,
                            'color' => '#000000b5'
                        ]
                    ]
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function render_fields($fields)
    {
        if(!$fields || !is_array($fields))
            return false;
        $i = 0;
        foreach($fields as $field):
            $i++;
            $wrapper_class_list = [];
            $wrapper_class_list[] = 'ml-field-' . $field['field_type'];
            if($field['field_type'] == 'email')
                $wrapper_class_list[] = 'ml-validate-email';
            if($field['field_input_type'] == 'textarea')
                $wrapper_class_list[] = 'ml-form-textarea';
            if($field['field_is_required'] == 'yes')
                $wrapper_class_list[] = 'ml-validate-required';
            $wrapper_class = implode(' ', $wrapper_class_list);
            $has_icon = isset($field['field_icon']) && !empty($field['field_icon']['value']);
        ?>
        <div class="ml-form-input <?php echo !$has_icon ? 'without-icon' : '' ?> <?php echo (count($fields) > 1 && count($fields) == $i) ? 'last-field' : '' ?> <?php echo $wrapper_class?>">
            <?php \Elementor\Icons_Manager::render_icon( $field['field_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            <?php if($field['field_type'] == 'email'):?>
                <input aria-label="email" aria-required="true" type="email" class="form-control" name="fields[email]" placeholder="<?php echo $field['field_placeholder'] ?>" autocomplete="email">
            <?php else: ?>
                <?php $this->render_field($field['field_type'], $field['field_input_type'], $field['field_placeholder']);?>
            <?php endif;?>
        </div>
        <?php endforeach;
    }

    private function render_field($field_name, $field_input_type, $field_placeholder)
    {
        if($field_input_type == 'text'): ?>
            <input aria-label="<?php echo $field_name?>" type="text" class="form-control" data-inputmask="" name="fields[<?php echo $field_name?>]" placeholder="<?php echo $field_placeholder?>" autocomplete="<?php echo $field_name?>">
        <?php elseif($field_input_type == 'textarea'): ?>
            <textarea class="form-control" name="fields[<?php echo $field_name?>]" aria-label="<?php echo $field_name?>" maxlength="255" placeholder="<?php echo $field_placeholder?>" aria-invalid="false"></textarea>
        <?php endif;
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
    
        $fields = $settings['fields'];
        ?>
        <div class="mailer-lite2">
            <div class="mailerlite-form-wrap <?php echo $settings['submit_move_end'] == 'yes' ? 'submit-btn-end' : '' ?> <?php echo (is_array($fields) && count($fields) > 1) ? 'with-group-fields' : '' ?>">
                <form action="/" method="post" class="mailerlite-subscribe-form" data-success-message="<?php echo $settings['thanks_content'] ?>" data-error-message="<?php echo $settings['error_content'] ?>">
                    <?php $this->render_fields($fields);?>
                    <div class="ml-form-submit">
                        <button type="submit">
                            <span class="line-loader" style="display:none"></span>
                            <?php echo $settings['submit_btn_text'] ?>
                        </button>
                    </div>
                    <input type="hidden" name="k" value="<?php echo base64_encode($settings['api_key']) ?>">
                </form>
            </div>
        </div>
        <?php
    }
}