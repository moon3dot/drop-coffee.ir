<?php
namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_tools;
use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class story extends \Elementor\Widget_Base
{
    /**
     * story constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $ver = mw_tools::get_theme_version();

        wp_register_style('swiper', mw_assets::get_css('swiper-bundle-min'), null, $ver);
        mw_assets::register_style('story_css', mw_assets::get_css('elementor.story'));
        if(!is_rtl()){
            mw_assets::register_style('story_ltr_css', mw_assets::get_css('elementor.ltr.story_ltr'));
        }

        wp_deregister_script('swiper');
        wp_register_script('swiper', mw_assets::get_js('swiper-bundle-min'), null, $ver, true);
        mw_assets::register_script('story_js', mw_assets::get_js('elementor.story'));
    }

    public function get_style_depends()
    {
        $styles = ['swiper', mw_assets::get_handle_name('story_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('story_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return ['swiper', mw_assets::get_handle_name('story_js')];
    }

    public function get_name()
    {
        return 'story_element';
    }

    public function get_title()
    {
        return esc_html__('Story', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-slider-push';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['story', esc_html__('Story', 'ahura')];
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
            'item_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Item Title', 'ahura'),
            ]
        );

        $repeater->add_control(
            'item_cover',
            [
                'label' => esc_html__('Choose Cover', 'ahura'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_story_image',
            [
                'label' => esc_html__( 'Choose Image', 'ahura' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_story_link',
            [
                'label' => esc_html__('Link', 'ahura'),
                'type' => Controls_Manager::URL,
                'placeholder' => site_url(),
                'options' => ['url', 'is_external', 'nofollow'],
                'dynamic' => ['active' => true],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'story_items',
            [
                'label' => esc_html__('Tabs', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{item_title}}}',
                'default' => [
                    [
                        'item_title' => esc_html__('Story Title', 'ahura'),
                    ]
                ]
            ]
        );

        $this->add_control(
			'show_col',
			[
				'label' => esc_html__( 'Show column', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ahura' ),
				'label_off' => esc_html__( 'Hide', 'ahura' ),
				'return_value' => 'yes',
				'default' => 'no',
            ],
		);

        $this->add_responsive_control(
			'col',
			[
				'label' => esc_html__( 'Columns', 'ahura' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 33,
				'options' => [
					100 => esc_html__( '1', 'ahura' ),
					50 => esc_html__( '2', 'ahura' ),
					33  => esc_html__( '3', 'ahura' ),
					25 => esc_html__( '4', 'ahura' ),
					20 => esc_html__( '5', 'ahura' ),
					16 => esc_html__( '6', 'ahura' ),
				],
                'condition' => [
                    'show_col' => 'yes',
                ],
				'selectors' => [
					'{{WRAPPER}} .story-lists .story' => 'width:{{VALUE}}%;display:flex;flex-direction:column;justify-content:center;align-items:center;margin-bottom:30px;',
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
         *
         */
        $this->start_controls_section(
            'item_story_styles',
            [
                'label' => esc_html__('Story', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'item_seen_color',
            [
                'label' => esc_html__('Seen mode Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#dbdbdb',
                'selectors' => [
                    '{{WRAPPER}} .story-element .story.seen svg' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_unseen_color',
            [
                'label' => esc_html__('Unseen mode Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e6123d',
                'selectors' => [
                    '{{WRAPPER}} .story-element .story svg' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Title Typography', 'ahura'),
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .story-element .story-title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px',
                            'size' => '14',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'item_title_seen_color',
            [
                'label' => esc_html__('Title seen mode Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#9d9d9d',
                'selectors' => [
                    '{{WRAPPER}} .story-element .story.seen .story-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_title_unseen_color',
            [
                'label' => esc_html__('Title unseen mode Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .story-element .story .story-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     *
     * Render content for display
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();

        $items = $settings['story_items'];
        ?>
        <div class="story-element story-container">
            <div <?php echo $settings['show_col'] == 'yes' ? 'style="gap:0"' : ''; ?> class="story-lists<?php echo $settings['show_col'] == 'yes' ? ' d-flex flex-wrap justify-content-start' : ''; ?>">
                <?php
                foreach ($items as $item):
                    $data_id = $item['_id'] . '-' . md5(!empty($item['item_story_image']['id']) ? $item['item_story_image']['id'] : $item['item_story_image']['url']);
                    ?>
                    <div class="story story-element-item elementor-repeater-item-<?php echo $item['_id']; ?> elementor-repeater-item-<?php echo $data_id; ?>" data-wid="<?php echo $wid ?>" data-id="<?php echo $data_id ?>" data-count="<?php echo !empty($item['item_story_image']['url']) ? 1 : 0 ?>">
                        <div class="story-cover-img">
                            <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" class="ins-story-circle-animation"><circle cx="50" cy="50" r="56"></circle></svg>
                            <img src="<?php echo $item['item_cover']['url'] ?>" alt="<?php echo $item['item_title'] ?>">
                        </div>
                        <p class="story-title"><?php echo $item['item_title'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="story-element-gallery-wrap story-element-gallery-wrap-<?php echo $wid ?>">
                <div class="close-overlay"></div>
                <div class="story-element-gallery story-element-gallery-<?php echo $wid ?>" dir="<?php echo is_rtl() ? 'rtl' : 'ltr' ?>">
                    <div class="story-gallery-items swiper-wrapper">
                        <?php
                        foreach ($items as $item):
                            $story_link = $item['item_story_link'];
                            $data_id = $item['_id'] . '-' . md5(!empty($item['item_story_image']['id']) ? $item['item_story_image']['id'] : $item['item_story_image']['url']);
                            if ( ! empty( $story_link['url'] ) ) {
                                $this->add_link_attributes( 'story_link_' . $item['_id'], $story_link);
                            }
                            ?>
                            <div class="swiper-slide">
                                <div class="story-image" data-wid="<?php echo $wid ?>" data-id="<?php echo $data_id ?>">
                                    <div class="story-progressbar"><div><div></div></div></div>
                                    <div class="story-details">
                                        <div class="story-g-cover">
                                            <img src="<?php echo $item['item_cover']['url'] ?>" alt="<?php echo $item['item_title'] ?>">
                                        </div>
                                        <div class="story-g-title">
                                            <?php echo $item['item_title'] ?>
                                        </div>
                                        <span class="close-story fa fa-times"></span>
                                    </div>
                                    <a <?php echo $this->get_render_attribute_string('story_link_' . $item['_id']); ?>>
                                        <?php if (empty($item['item_story_image']['id'])): ?>
                                            <img src="<?php echo $item['item_story_image']['url'] ?>" alt="<?php echo $item['item_title'] ?>">
                                        <?php else: ?>
                                            <?php echo wp_get_attachment_image($item['item_story_image']['id'], 'full') ?>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                    <div class="sbn swiper-button-next"></div>
                    <div class="sbn swiper-button-prev"></div>
                </div>
            </div>
        </div>
        <?php
    }
}