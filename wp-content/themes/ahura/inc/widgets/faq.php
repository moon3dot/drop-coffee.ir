<?php
namespace ahura\inc\widgets;

// Block direct access to the main plugin file.

use ahura\app\mw_assets;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class faq extends \Elementor\Widget_Base
{
    use \ahura\app\traits\mw_elementor;
    public function get_name()
    {
        return 'ahura_faq';
    }
    function get_title()
    {
        return esc_html__('FAQ', 'ahura');
    }
    function get_categories() {
		return [ 'ahuraelements' ];
	}
    function get_keywords()
    {
        return ['frequentaly asked question', 'frequentaly_asked_question','faq',esc_html__('FAQ', 'ahura')];
    }
    function __construct($data=[], $args=null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('elementor_faq', mw_assets::get_css('elementor.faq'));
        mw_assets::register_script('elementor_faq', mw_assets::get_js('elementor.faq'));
    }
    function get_style_depends()
    {
        return [mw_assets::get_handle_name('elementor_faq')];
    }
    function get_script_depends()
    {
        return [mw_assets::get_handle_name('elementor_faq')];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Content', 'ahura'),
            ]
        );
        $items = new \Elementor\Repeater();
        $items->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-chevron-down',
                    'library' => 'solid',
                ],
            ]
        );
        $items->add_control(
            'item_close_icon',
            [
                'label' => esc_html__('Close icon', 'ahura'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa fa-chevron-up',
                    'library' => 'solid',
                ],
            ]
        );
        $items->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('ex. Support in ticket system', 'ahura'),
                'default' => esc_html__('How can i submit new ticket?', 'ahura'),
            ]
        );
        $items->add_control(
            'item_description',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Write description text here', 'ahura'),
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
            ]
        );
        
        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'label' => esc_html__('Items', 'ahura'),
                'title_field' => '{{{item_title}}}',
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'item_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-down',
                        ],
                        'item_close_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-up'
                        ],
                        'item_title' => esc_html__('How can i submit new ticket?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-down',
                        ],
                        'item_close_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-up'
                        ],
                        'item_title' => esc_html__('How can I track my order?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-down',
                        ],
                        'item_close_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-up'
                        ],
                        'item_title' => esc_html__('Can I pay my order in installments (credit)?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-down',
                        ],
                        'item_close_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-up'
                        ],
                        'item_title' => esc_html__('How is the shipping cost calculated?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-down',
                        ],
                        'item_close_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-up'
                        ],
                        'item_title' => esc_html__('What are the terms for buying and returning goods?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                    [
                        'item_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-down',
                        ],
                        'item_close_icon' => [
                            'library' => 'solid',
                            'value' => 'fa fa-chevron-up'
                        ],
                        'item_title' => esc_html__('What are the conditions for using the discount code for the first purchase?', 'ahura'),
                        'item_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'ahura'),
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icons', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'items_icon_color',
            [
                'label' => esc_html__('Icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item .ah-title-section .ah-icon.ah-for-open' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item .ah-title-section .ah-icon.ah-for-open svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#000000',
            ]
        );
        $this->add_control(
            'items_close_icon_color',
            [
                'label' => esc_html__('Close icon color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item .ah-title-section .ah-icon.ah-for-close' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item .ah-title-section .ah-icon.ah-for-close svg' => 'fill: {{VALUE}};'
                ],
                'default' => '#000000',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'texts_style',
            [
                'label' => esc_html__('Texts', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item .ah-title-section .ah-title' => 'color: {{VALUE}};'
                ],
                'default' => 'black',
            ]
        );
        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item .ah-description' => 'color: {{VALUE}};'
                ],
                'default' => '#868686',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item .ah-title-section .ah-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 25,
                        ],
                    ],
                ],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'ahura'),
				'selector' => '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item .ah-description',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => 16,
                        ],
                    ],
                ],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'items_style',
            [
                'label' => esc_html__('Items', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'items_border_color',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ahura_element_faq .ah-items .ah-item:not(:last-of-type)' => 'border-color: {{VALUE}};'
                ],
                'default' => '#eaeaea',
            ]
        );
        $this->add_control(
			'items_padding',
			[
				'label' => esc_html__( 'Padding', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_faq .ah-items .ah-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'right' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
        $this->add_control(
			'items_margin',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ahura_element_faq .ah-items .ah-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default' => [
                    'top' => '0',
                    'bottom' => '0',
                    'right' => '0',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
			]
		);
        $this->end_controls_section();
    }
    
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="ahura_element_faq">
            <div class="ah-items">                
                <?php foreach($settings['items'] as $item): ?>
                <div class="ah-item <?php printf('elementor-repeater-item-%s', $item['_id'])?>">
                    <div class="ah-title-section">
                        <div class="ah-title"><?php echo $item['item_title']; ?></div>
                        <div class="ah-icon ah-for-open">
                            <?php \Elementor\Icons_Manager::render_icon($item['item_icon'])?>
                        </div>
                        <div class="ah-icon ah-for-close">
                            <?php \Elementor\Icons_Manager::render_icon($item['item_close_icon'])?>
                        </div>
                    </div>
                    <div class="ah-description"><?php echo $item['item_description']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}