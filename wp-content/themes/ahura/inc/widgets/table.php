<?php
namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class table extends \Elementor\Widget_Base
{
    /**
     * team_members constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('table_css', mw_assets::get_css('elementor.table'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('table_css')];
        return $styles;
    }

    public function get_name()
    {
        return 'ahura_table';
    }

    public function get_title()
    {
        return esc_html__('Table', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-table';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['table', esc_html__('Table', 'ahura')];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'tabs_content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'headings_content',
            [
                'label' => esc_html__( 'Content', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'headings',
            [
                'label' => esc_html__( 'Headings', 'ahura' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'headings_content' => esc_html__( 'Name', 'ahura' ),
                    ],
                    [
                        'headings_content' => esc_html__( 'Category', 'ahura' ),
                    ],
                ],
                'title_field' => '{{{ headings_content }}}',
            ]
        );

        $this->add_control(
			'content_cols_num',
			[
				'label' => esc_html__( 'Content columns', 'ahura' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 2,
			]
		);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'col_content',
            [
                'label' => esc_html__( 'Content', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'contents',
            [
                'label' => esc_html__( 'Contents', 'ahura' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'col_content' => esc_html__( 'Ahura', 'ahura' ),
                    ],
                    [
                        'col_content' => esc_html__( 'Theme', 'ahura' ),
                    ],
                    [
                        'col_content' => esc_html__( 'MihanPanel', 'ahura' ),
                    ],
                    [
                        'col_content' => esc_html__( 'Plugin', 'ahura' ),
                    ],
                ],
                'title_field' => '{{{ col_content }}}',
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'headings_items_style',
            [
                'label' => esc_html__('Heading', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'headings_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'left' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} th' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} th',
			]
		);

        $this->add_control(
			'headings_color',
			[
				'label' => esc_html__( 'Headings color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} th' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'headings_backcolor',
			[
				'label' => esc_html__( 'Headings background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} th' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'heading_border',
				'selector' => '{{WRAPPER}} th',
			]
		);
        
        $this->add_control(
			'heading_padding',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 8,
					'right' => 8,
					'bottom' => 8,
					'left' => 8,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
            'content_style',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'content_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => esc_html__( 'Right', 'ahura' ),
						'icon' => 'eicon-text-align-right',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ahura' ),
						'icon' => 'eicon-text-align-center',
					],
					'left' => [
						'title' => esc_html__( 'Left', 'ahura' ),
						'icon' => 'eicon-text-align-left',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} tr' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} tr',
			]
		);

        $this->add_control(
			'row_color_status',
			[
				'label' => esc_html__( 'Row color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Content Color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr' => 'color: {{VALUE}}',
				],
                'condition' => ['row_color_status' => 'no']
			]
		);

        $this->add_control(
			'content_backcolor',
			[
				'label' => esc_html__( 'Content background color', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr' => 'background-color: {{VALUE}}',
				],
                'condition' => ['row_color_status' => 'no']
			]
		);

        $this->add_control(
			'odd_row_color',
			[
				'label' => esc_html__( 'Row Color (odd)', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:nth-child(odd)' => 'color: {{VALUE}}',
				],
                'condition' => ['row_color_status' => 'yes']
			]
		);

        $this->add_control(
			'odd_row_backcolor',
			[
				'label' => esc_html__( 'Row background color (odd)', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:nth-child(odd)' => 'background-color: {{VALUE}}',
				],
                'condition' => ['row_color_status' => 'yes']
			]
		);

        $this->add_control(
			'even_row_color',
			[
				'label' => esc_html__( 'Row Color (even)', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:nth-child(even)' => 'color: {{VALUE}}',
				],
                'condition' => ['row_color_status' => 'yes']
			]
		);

        $this->add_control(
			'even_row_backcolor',
			[
				'label' => esc_html__( 'Row background color (even)', 'ahura' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:nth-child(even)' => 'background-color: {{VALUE}}',
				],
                'condition' => ['row_color_status' => 'yes']
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'selector' => '{{WRAPPER}} td',
			]
		);
        
        $this->add_control(
			'content_padding',
			[
				'label' => esc_html__( 'Margin', 'ahura' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 8,
					'right' => 8,
					'bottom' => 8,
					'left' => 8,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }
    
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid      = $this->get_id();
        $headings = $settings['headings'];
        $contents = $settings['contents']; ?>
        <div class="ahura-table ahura-table-<?php echo $wid ?>">
            <table>
                <tr>
                    <?php foreach ($headings as $heading): ?>
                        <th><?php echo $heading['headings_content']; ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                <?php $col_controller = 1; foreach ($contents as $content): ?>
                    <td><?php echo $content['col_content'] ?></td>
                    <?php if($col_controller == $settings['content_cols_num']): ?>
                        </tr><tr>
                        <?php $col_controller = 0 ?>
                    <?php endif; ?>
                    <?php $col_controller++; ?>
                <?php endforeach; ?>
            </table>
        </div>
        <?php
    }
}