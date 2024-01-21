<?php

namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;
use ahura\app\Ahura_Alert;

class sound_player extends \Elementor\Widget_Base
{
    /**
     * sound_player constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('sound_player_css', mw_assets::get_css('elementor.sound_player'));
        if(!is_rtl()){
            mw_assets::register_style('sound_player_ltr_css', mw_assets::get_css('elementor.ltr.sound_player_ltr'));
        }
        wp_register_script(mw_assets::get_handle_name('howler_js'), get_template_directory_uri(). '/js/howler.min.js');
        mw_assets::register_script('sound_player_js', mw_assets::get_js('elementor.sound_player'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('sound_player_css')];
        if(!is_rtl()){
            $styles[] = mw_assets::get_handle_name('sound_player_ltr_css');
        }
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('howler_js'), mw_assets::get_handle_name('sound_player_js')];
    }

    public function get_name()
    {
        return 'sound_player';
    }

    public function get_title()
    {
        return esc_html__('Sound Player', 'ahura');
    }

    public function get_icon()
    {
        return 'eicon-play-o';
    }

    public function get_categories()
    {
        return ['ahuraelements'];
    }

    public function get_keywords()
    {
        return ['soundplayer', 'sound_player', esc_html__('Sound Player', 'ahura')];
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

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'item_title',
			[
				'label' => esc_html__('Title', 'ahura'),
				'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Homayoun Shajarian', 'ahura'),
			]
		);

        $repeater->add_control(
			'item_subtitle',
			[
				'label' => esc_html__('Sub Title', 'ahura'),
				'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Abr Mibarad', 'ahura'),
			]
		);

        $repeater->add_control(
			'item_audio',
			[
				'label' => esc_html__('Audio', 'ahura'),
				'type' => Controls_Manager::MEDIA,
                'media_types' => ['audio'],
				'default' => [
					'url' => 'undefined',
				],
			]
		);

        $repeater->add_control(
			'item_cover',
			[
				'label' => esc_html__('Cover', 'ahura'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'sounds',
            [
                'label' => esc_html__('Items', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => esc_html__('Homayoun Shajarian', 'ahura'),
                        'item_subtitle' => esc_html__('Abr Mibarad', 'ahura'),
                        'item_audio' => [
                            'url' => 'undefined',
                        ],
                    ]
                ],
                'title_field' => '{{{item_title}}}',
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
            'show_playlist',
            [
                'label' => esc_html__('Playlist', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_download',
            [
                'label' => esc_html__('Download', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_sound_volume',
            [
                'label' => esc_html__('Sound Volume', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_sound_speed',
            [
                'label' => esc_html__('Sound Speed', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_share',
            [
                'label' => esc_html__('Share', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'save_sound_time',
            [
                'label' => esc_html__('Save sound time', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
			'spt_important_note',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__('If this option is enabled, the last sound playback time will be saved in the user`s browser, and if the user leaves the website and returns again, the sound will be played from the same time it was stopped.', 'ahura'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition' => [
                    'save_sound_time' => 'yes'
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
            'player_styles_section',
            [
                'label' => esc_html__('Player', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'player_cover_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'size' => 109,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 115,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 250,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .sound-player-1 .sound-cover-wrap .sound-cover' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'player_primary_color',
            [
                'label' => esc_html__('Primary Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#61B615',
                'selectors' => [
                    '{{WRAPPER}} .sound-player-1 .sound-control-btn.sound-btn-playing svg, {{WRAPPER}} .sound-player-1 .sound-control-btn.sound-btn-playing svg path' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .sound-player-1 .sound-timer-progress span, {{WRAPPER}} .sound-player-1 .sound-timer-progress' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sound-player-1 .sound-timer-line .stl' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sound-player-1 .sound-timer-line input[type="range"]::-webkit-slider-thumb' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sound-player-1 .sound-timer-line input[type="range"]::-moz-range-thumb' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sound-player-1 .sound-timer-line input[type="range"]::-ms-thumb' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .sound-player-1 .sound-volume input[type="range"]::-webkit-slider-thumb' => 'box-shadow: -407px 0 0 400px {{VALUE}};border-color:{{VALUE}};',
                    '{{WRAPPER}} .sound-player-1 .sound-volume input[type="range"]::-moz-range-thumb' => 'box-shadow: -407px 0 0 400px {{VALUE}};border-color:{{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'player_btns_color',
            [
                'label' => esc_html__('Buttons Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sound-player-1 .sound-buttons-wrap a' => 'border-color: {{VALUE}}; color: {{VALUE}}',
                    '{{WRAPPER}} .sound-player-1 .sound-controls a svg, {{WRAPPER}} .sound-player-1 .sound-controls a svg path, {{WRAPPER}} .sound-player-1 .sound-controls a svg circle' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .sound-player-1 .sound-control-btn.sound-btn-playing' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'player_playlist_styles_section',
            [
                'label' => esc_html__('Playlist', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('player_playlist_styles_tabs');

        $this->start_controls_tab(
            'player_playlist_normal_tab',
            [
                'label' => esc_html__('Normal', 'ahura'),
            ]
        );

        $this->add_control(
            'playlist_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .sound-player-1 .sound-playlist-item .row, {{WRAPPER}} .sound-player-1 .sound-playlist-item .row a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'playlist_box_bg',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .sound-player-1 .sound-player-playlist',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'playlist_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .sound-player-1 .sound-player-playlist',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'playlist_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .sound-player-1 .sound-player-playlist',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'player_playlist_hover_tab',
            [
                'label' => esc_html__('Hover', 'ahura'),
            ]
        );

        $this->add_control(
            'playlist_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sound-player-1 .sound-playlist-item:hover .row, {{WRAPPER}} .sound-player-1 .sound-playlist-item:hover .row a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_playlist_item_hover',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .sound-player-1 .sound-playlist-item:hover',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'box_styles_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'box_text_color',
            [
                'label' => esc_html__('Text Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sound-player-1 .sound-player-content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_bg',
				'label' => esc_html__('Background', 'ahura'),
				'types' => ['gradient'],
				'selector' => '{{WRAPPER}} .sound-player-1 .sound-player-content',
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .sound-player-1 .sound-player-content',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrap_box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .sound-player-1 .sound-player-content',
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

        $buttons_disabled = $settings['show_share'] != 'yes' && $settings['show_playlist'] != 'yes' && $settings['show_download'] != 'yes';

        $sounds = $settings['sounds'];
        $soundsCount = count($sounds);
        $is_active = !is_admin() ? true : $sounds && $soundsCount > 0;
        if($is_active):
        ?>
        <div class="ahura-sound-player sound-player-1 <?php echo (!is_admin()) ? ' has-loader ' : '' ?> sound-player-<?php echo $wid; ?>" data-player-id="<?php echo $wid; ?>">
            <?php
            $i = 0;
            foreach($sounds as $sound):
                if($i != 0) continue;
                $sound_audio = isset($sound['item_audio']) && !empty($sound['item_audio']['url']) ? $sound['item_audio']['url'] : '';
                $meta = $sound_audio ? get_post_meta($sound['item_audio']['id'] , '_wp_attachment_metadata', true) : [];
                $length = $meta && isset($meta['length_formatted']) ? $meta['length_formatted'] : '00:00';
             ?>
             <div class="sound-player-content sound-player-content-<?php echo $sound['_id'] ?> <?php echo $buttons_disabled ? ' sound-cols-none-buttons' : '' ?>">
                <?php
                $show_frame = !is_admin() ? true : !empty($sound_audio) && $sound_audio !== 'undefined';
                if($show_frame): ?>
                <div class="sound-cols sound-cover-wrap">
                    <div class="sound-col-content">
                        <div class="sound-cover sound-pri-cover" style="background-image: url('<?php echo $sound['item_cover']['url']; ?>')"></div>
                    </div>
                </div>
                <div class="sound-cols sound-cols-eq sound-details-wrap">
                    <div class="sound-col-content">
                        <div class="sound-title"><?php echo $sound['item_title'] ?></div>
                        <div class="sound-subtitle"><?php echo $sound['item_subtitle'] ?></div>
                        <div class="sound-controls">
                            <?php if($settings['show_playlist'] == 'yes'): ?>
                                <a href="#" class="sound-control-btn sound-btn-<?php echo is_rtl() ? 'next' : 'prev' ?> <?php echo $soundsCount <= 1 || !is_rtl() ? ' btn-disabled' : '' ?>" data-player-id="<?php echo $wid; ?>">
                                    <?php if(is_rtl()): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="Group_30" data-name="Group 30"> <g id="Polygon_4" data-name="Polygon 4" transform="translate(348 -42) rotate(90)" fill="none"> <path d="M 192.5 77.42678833007812 C 176.9179382324219 77.42678833007812 162.9804077148438 85.49267578125 155.2169952392578 99.00302124023438 L 66.39511108398438 253.5762023925781 C 58.6591796875 267.0387878417969 58.68377685546875 283.0992736816406 66.46099853515625 296.5380249023438 C 74.23818969726562 309.976806640625 88.151123046875 317.9999694824219 103.6781311035156 317.9999694824219 L 281.3219299316406 317.9999694824219 C 296.848876953125 317.9999694824219 310.7617797851562 309.9768676757812 318.5390014648438 296.5380859375 C 326.316162109375 283.0992736816406 326.3408203125 267.0387878417969 318.6048889160156 253.5762023925781 L 229.7830047607422 99.00302124023438 C 222.0195922851562 85.49267578125 208.0820007324219 77.42678833007812 192.5 77.42678833007812 M 192.5 60.42678833007812 C 212.7447509765625 60.42678833007812 232.989501953125 70.46224975585938 244.5227661132812 90.53314208984375 L 333.3446350097656 245.1063232421875 C 356.3296508789062 285.106201171875 327.4554138183594 334.9999694824219 281.3219299316406 334.9999694824219 L 103.6781311035156 334.9999694824219 C 57.54458618164062 334.9999694824219 28.6702880859375 285.106201171875 51.65536499023438 245.1063232421875 L 140.4772338867188 90.53314208984375 C 152.010498046875 70.46224975585938 172.2552490234375 60.42678833007812 192.5 60.42678833007812 Z" stroke="none" fill="#000"/> </g> <circle id="Ellipse_11" data-name="Ellipse 11" cx="29.5" cy="29.5" r="29.5" transform="translate(85 120)" fill="#090909"/> </g> </svg>
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="Group_32" data-name="Group 32"> <g id="Polygon_4" data-name="Polygon 4" transform="translate(-47 343) rotate(-90)" fill="none"><path d="M 192.5 77.42678833007812 C 176.9179382324219 77.42678833007812 162.9804077148438 85.49267578125 155.2169952392578 99.00302124023438 L 66.39511108398438 253.5762023925781 C 58.6591796875 267.0387878417969 58.68377685546875 283.0992736816406 66.46099853515625 296.5380249023438 C 74.23818969726562 309.976806640625 88.151123046875 317.9999694824219 103.6781311035156 317.9999694824219 L 281.3219299316406 317.9999694824219 C 296.848876953125 317.9999694824219 310.7617797851562 309.9768676757812 318.5390014648438 296.5380859375 C 326.316162109375 283.0992736816406 326.3408203125 267.0387878417969 318.6048889160156 253.5762023925781 L 229.7830047607422 99.00302124023438 C 222.0195922851562 85.49267578125 208.0820007324219 77.42678833007812 192.5 77.42678833007812 M 192.5 60.42678833007812 C 212.7447509765625 60.42678833007812 232.989501953125 70.46224975585938 244.5227661132812 90.53314208984375 L 333.3446350097656 245.1063232421875 C 356.3296508789062 285.106201171875 327.4554138183594 334.9999694824219 281.3219299316406 334.9999694824219 L 103.6781311035156 334.9999694824219 C 57.54458618164062 334.9999694824219 28.6702880859375 285.106201171875 51.65536499023438 245.1063232421875 L 140.4772338867188 90.53314208984375 C 152.010498046875 70.46224975585938 172.2552490234375 60.42678833007812 192.5 60.42678833007812 Z" stroke="none" fill="#000"/> </g> <circle id="Ellipse_11" data-name="Ellipse 11" cx="29.5" cy="29.5" r="29.5" transform="translate(157 120)" fill="#090909"/> </g> </svg>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>
                            <a href="#" class="sound-control-btn sound-btn-playing sound-btn-play in-content" data-title="<?php echo isset($sound['item_title']) ? $sound['item_title'] : ''; ?>" data-subtitle="<?php echo isset($sound['item_subtitle']) ? $sound['item_subtitle'] : ''; ?>" data-cover="<?php echo isset($sound['item_cover']['url']) ? $sound['item_cover']['url'] : ''; ?>" data-duration="<?php echo isset($meta['length']) ? $meta['length'] : ''; ?>" data-length="<?php echo $length; ?>" data-player-id="<?php echo $wid; ?>" data-audio="<?php echo $sound_audio ?>" data-hash="<?php echo md5($sound_audio) ?>">
                                <svg class="player-play-icon" xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="Group_31" data-name="Group 31"> <g id="Polygon_4" data-name="Polygon 4" transform="translate(343 -41) rotate(90)" fill="none"><path d="M 191.4999542236328 77.89984130859375 C 175.8775482177734 77.89984130859375 161.9220123291016 85.9970703125 154.1689605712891 99.55996704101562 L 66.07882690429688 253.6600189208984 C 58.3831787109375 267.1224975585938 58.43484497070312 283.167236328125 66.21707153320312 296.5798950195312 C 73.99923706054688 309.9924926757812 87.90313720703125 318 103.4099426269531 318 L 279.590087890625 318 C 295.0968933105469 318 309.0007934570312 309.9924926757812 316.782958984375 296.579833984375 C 324.5651245117188 283.167236328125 324.6167907714844 267.1224975585938 316.9210815429688 253.6600189208984 L 228.8310089111328 99.55990600585938 C 221.0778961181641 85.9970703125 207.1223754882812 77.89984130859375 191.4999542236328 77.89984130859375 M 191.4999847412109 60.89987182617188 C 211.7859344482422 60.89987182617188 232.0718688964844 70.97430419921875 243.5897827148438 91.12319946289062 L 331.6798400878906 245.2233123779297 C 354.5452575683594 285.2227172851562 325.6637268066406 335 279.590087890625 335 L 103.4099426269531 335 C 57.33624267578125 335 28.45477294921875 285.2227172851562 51.320068359375 245.2233123779297 L 139.4101867675781 91.12319946289062 C 150.9281005859375 70.97430419921875 171.2140502929688 60.89987182617188 191.4999847412109 60.89987182617188 Z" stroke="none" fill="#000"/> </g> </g> </svg>
                                <svg class="player-pause-icon" xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="Group_28" data-name="Group 28"> <rect id="Rectangle_5" data-name="Rectangle 5" width="70" height="292" rx="35"/> <rect id="Rectangle_6" data-name="Rectangle 6" width="70" height="292" rx="35" transform="translate(182 4)"/> </g> </svg>
                            </a>
                            <?php if($settings['show_playlist'] == 'yes'): ?>
                                <a href="#" class="sound-control-btn sound-btn-<?php echo is_rtl() ? 'prev' : 'next' ?> <?php echo $soundsCount <= 1 || is_rtl() ? ' btn-disabled' : '' ?>" data-player-id="<?php echo $wid; ?>">
                                    <?php if(is_rtl()): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="Group_32" data-name="Group 32"> <g id="Polygon_4" data-name="Polygon 4" transform="translate(-47 343) rotate(-90)" fill="none"><path d="M 192.5 77.42678833007812 C 176.9179382324219 77.42678833007812 162.9804077148438 85.49267578125 155.2169952392578 99.00302124023438 L 66.39511108398438 253.5762023925781 C 58.6591796875 267.0387878417969 58.68377685546875 283.0992736816406 66.46099853515625 296.5380249023438 C 74.23818969726562 309.976806640625 88.151123046875 317.9999694824219 103.6781311035156 317.9999694824219 L 281.3219299316406 317.9999694824219 C 296.848876953125 317.9999694824219 310.7617797851562 309.9768676757812 318.5390014648438 296.5380859375 C 326.316162109375 283.0992736816406 326.3408203125 267.0387878417969 318.6048889160156 253.5762023925781 L 229.7830047607422 99.00302124023438 C 222.0195922851562 85.49267578125 208.0820007324219 77.42678833007812 192.5 77.42678833007812 M 192.5 60.42678833007812 C 212.7447509765625 60.42678833007812 232.989501953125 70.46224975585938 244.5227661132812 90.53314208984375 L 333.3446350097656 245.1063232421875 C 356.3296508789062 285.106201171875 327.4554138183594 334.9999694824219 281.3219299316406 334.9999694824219 L 103.6781311035156 334.9999694824219 C 57.54458618164062 334.9999694824219 28.6702880859375 285.106201171875 51.65536499023438 245.1063232421875 L 140.4772338867188 90.53314208984375 C 152.010498046875 70.46224975585938 172.2552490234375 60.42678833007812 192.5 60.42678833007812 Z" stroke="none" fill="#000"/> </g> <circle id="Ellipse_11" data-name="Ellipse 11" cx="29.5" cy="29.5" r="29.5" transform="translate(157 120)" fill="#090909"/> </g> </svg>
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="Group_30" data-name="Group 30"> <g id="Polygon_4" data-name="Polygon 4" transform="translate(348 -42) rotate(90)" fill="none"> <path d="M 192.5 77.42678833007812 C 176.9179382324219 77.42678833007812 162.9804077148438 85.49267578125 155.2169952392578 99.00302124023438 L 66.39511108398438 253.5762023925781 C 58.6591796875 267.0387878417969 58.68377685546875 283.0992736816406 66.46099853515625 296.5380249023438 C 74.23818969726562 309.976806640625 88.151123046875 317.9999694824219 103.6781311035156 317.9999694824219 L 281.3219299316406 317.9999694824219 C 296.848876953125 317.9999694824219 310.7617797851562 309.9768676757812 318.5390014648438 296.5380859375 C 326.316162109375 283.0992736816406 326.3408203125 267.0387878417969 318.6048889160156 253.5762023925781 L 229.7830047607422 99.00302124023438 C 222.0195922851562 85.49267578125 208.0820007324219 77.42678833007812 192.5 77.42678833007812 M 192.5 60.42678833007812 C 212.7447509765625 60.42678833007812 232.989501953125 70.46224975585938 244.5227661132812 90.53314208984375 L 333.3446350097656 245.1063232421875 C 356.3296508789062 285.106201171875 327.4554138183594 334.9999694824219 281.3219299316406 334.9999694824219 L 103.6781311035156 334.9999694824219 C 57.54458618164062 334.9999694824219 28.6702880859375 285.106201171875 51.65536499023438 245.1063232421875 L 140.4772338867188 90.53314208984375 C 152.010498046875 70.46224975585938 172.2552490234375 60.42678833007812 192.5 60.42678833007812 Z" stroke="none" fill="#000"/> </g> <circle id="Ellipse_11" data-name="Ellipse 11" cx="29.5" cy="29.5" r="29.5" transform="translate(85 120)" fill="#090909"/> </g> </svg>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>
                            <a href="#" class="sound-control-btn sound-btn-sec-prev" data-player-id="<?php echo $wid; ?>" data-hash="<?php echo md5($sound_audio) ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="_30-seconds" data-name="30-seconds"> <path id="Path_5" data-name="Path 5" d="M182.858,272.6c66.04-19.251,104.3-88.215,85.047-154.5a124.514,124.514,0,0,0-154.5-85.047A116.132,116.132,0,0,0,88.551,43.288l3.168.975A12.336,12.336,0,0,1,84.652,67.9L52,57.909a12.119,12.119,0,0,1-8.529-13.89,8.9,8.9,0,0,1,.731-3.655L56.384,8.44c0-.244.244-.487.244-.975a12.288,12.288,0,0,1,22.663,9.5l-3.168,8.042A146.106,146.106,0,0,1,148.254,6.247c81.148,0,146.7,65.8,146.7,146.944s-65.8,146.7-146.944,146.7a11.076,11.076,0,0,1-10.479-10.479,10.933,10.933,0,0,1,10.479-11.453A150.613,150.613,0,0,0,182.858,272.6ZM23.973,72.774A145.765,145.765,0,0,0,11.545,96.412h0c-2.681,6.092.487,13.159,6.58,15.84s13.4-.487,16.083-6.58A151.432,151.432,0,0,1,44.443,85.933l.244-.487C52.241,71.068,32.5,59.615,23.973,72.774Zm62.384,187.4a11.969,11.969,0,0,0-16.571,4.386c-3.168,5.849-1.462,13.4,4.386,16.571A180.263,180.263,0,0,0,98.3,292.338a12.3,12.3,0,0,0,8.285-23.15A124.9,124.9,0,0,1,86.357,260.171Zm-46.788-48.25h0a12.5,12.5,0,0,0-16.815-3.9,12.443,12.443,0,0,0-3.9,16.815,167.673,167.673,0,0,0,14.865,22.176,11.257,11.257,0,0,0,1.706,1.706c12.184,9.5,26.075-6.336,17.3-17.058A173.676,173.676,0,0,1,39.569,211.921Zm-13.4-40.7a154.987,154.987,0,0,1-1.462-21.2v-1.95c-1.462-15.84-23.638-14.865-24.369.244a136.523,136.523,0,0,0,1.706,26.318,6.489,6.489,0,0,0,.731,2.924,11.952,11.952,0,0,0,13.647,7.8,12.158,12.158,0,0,0,9.748-14.134Z" transform="translate(0)"/> <g id="Group_26" data-name="Group 26" transform="translate(72.711 99.549)"> <path id="Path_6" data-name="Path 6" d="M68.259,40.8A37.3,37.3,0,0,1,82.88,43.724a20.942,20.942,0,0,1,9.5,8.285A27.931,27.931,0,0,1,95.8,65.9v6.58a51.3,51.3,0,0,1-.487,6.092,18.537,18.537,0,0,1-1.95,5.117,18.17,18.17,0,0,1-3.412,4.143,14.763,14.763,0,0,1-5.117,2.681,14.435,14.435,0,0,1,5.6,3.168,19.082,19.082,0,0,1,3.9,4.874,28.423,28.423,0,0,1,2.437,6.336,37.835,37.835,0,0,1,.731,7.554v3.9a22.48,22.48,0,0,1-7.554,18.277,31.023,31.023,0,0,1-20.957,6.336h0a193.372,193.372,0,0,1-20.714-.975A172.344,172.344,0,0,1,30,137.3V116.587H59c2.681,0,5.361-.244,8.042-.487a7.136,7.136,0,0,0,3.9-1.706,4.367,4.367,0,0,0,.975-3.412v-2.437a5.733,5.733,0,0,0-1.218-3.9,10.222,10.222,0,0,0-3.412-2.193,38.3,38.3,0,0,0-5.6-.975L37.311,100.5V80.521L59.73,79.059a17.329,17.329,0,0,0,7.8-1.706,3.947,3.947,0,0,0,2.437-4.143V71.992a5.247,5.247,0,0,0-2.681-5.361,20.047,20.047,0,0,0-9.991-1.462H30.487V44.455c5.849-.975,11.941-1.95,18.277-2.681Z" transform="translate(-30 -40.769)"/> <path id="Path_7" data-name="Path 7" d="M135.912,114.168V68.842a33.427,33.427,0,0,0-3.168-15.352,22.019,22.019,0,0,0-8.773-9.5,28.614,28.614,0,0,0-14.134-3.168H88.393a31.453,31.453,0,0,0-14.865,3.168,23.21,23.21,0,0,0-9.26,9.5A36.884,36.884,0,0,0,61.1,68.842v45.326a32.58,32.58,0,0,0,3.168,14.378,22.01,22.01,0,0,0,9.016,9.26,35.78,35.78,0,0,0,15.109,3.168h21.2a25.177,25.177,0,0,0,19.5-7.067A27.258,27.258,0,0,0,135.912,114.168Zm-25.344-1.95a6.634,6.634,0,0,1-7.554,5.6H94.973v.244a7.715,7.715,0,0,1-5.6-1.706,8.024,8.024,0,0,1-1.95-6.092V71.523a8.678,8.678,0,0,1,1.706-5.849,6.78,6.78,0,0,1,5.117-1.95h9.991a8.023,8.023,0,0,1,4.63,1.462,8.024,8.024,0,0,1,1.95,6.092v38.5A9.142,9.142,0,0,0,110.569,112.219Z" transform="translate(14.687 -40.787)"/> </g> </g> </svg>
                            </a>
                            <a href="#" class="sound-control-btn sound-btn-sec-next" data-player-id="<?php echo $wid; ?>" data-hash="<?php echo md5($sound_audio) ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="_30-seconds2" data-name="30-seconds2"> <path id="Path_8" data-name="Path 8" d="M147.363,277.842A10.942,10.942,0,0,1,157.851,289.3a11.085,11.085,0,0,1-10.487,10.487A146.5,146.5,0,0,1,.3,153.216C.3,72,65.905,6.152,147.12,6.152a148.861,148.861,0,0,1,72.19,18.779l-3.171-8.048a12.3,12.3,0,0,1,22.681-9.512c.244.244.244.488.244.976L251.259,40.3a9.786,9.786,0,0,1,.732,3.658,12.174,12.174,0,0,1-8.536,13.658l-32.681,10A12.346,12.346,0,0,1,203.7,43.955l3.171-.976A116.226,116.226,0,0,0,182,32.736C115.9,13.469,46.638,51.759,27.371,117.852s19.023,135.357,85.116,154.624A114.3,114.3,0,0,0,147.363,277.842ZM271.746,72.733c-8.536-12.926-28.535-1.463-20.974,12.682l.244.488a126.52,126.52,0,0,1,10.243,19.755,12.3,12.3,0,1,0,22.681-9.512h0a194.718,194.718,0,0,0-12.194-23.413Zm-82.921,197.06a12.022,12.022,0,0,0-7.317,15.609,12.345,12.345,0,0,0,15.609,7.56,127.612,127.612,0,0,0,24.145-11.219,12.131,12.131,0,1,0-12.194-20.974A169.617,169.617,0,0,1,188.824,269.794Zm54.143-37.8c-9.024,10.731,5.122,26.584,17.316,17.072a11.266,11.266,0,0,0,1.707-1.707,153.21,153.21,0,0,0,14.877-22.194,12.215,12.215,0,0,0-20.73-12.926h0Q249.918,222.48,242.967,231.991Zm26.34-60.484a12.172,12.172,0,0,0,23.413,6.341c.244-.976.488-1.707.732-2.683a138.93,138.93,0,0,0,1.463-26.584c-.732-15.121-22.925-16.1-24.389-.244v1.951a88.657,88.657,0,0,1-1.219,21.218Z" transform="translate(0 0)"/> <g id="Group_27" data-name="Group 27" transform="translate(72.734 99.774)"> <path id="Path_9" data-name="Path 9" d="M68.29,40.8a37.328,37.328,0,0,1,14.633,2.927,20.959,20.959,0,0,1,9.512,8.292,27.954,27.954,0,0,1,3.414,13.9v6.585a51.341,51.341,0,0,1-.488,6.1,18.553,18.553,0,0,1-1.951,5.122A18.184,18.184,0,0,1,90,87.87a14.775,14.775,0,0,1-5.122,2.683,14.446,14.446,0,0,1,5.609,3.171,19.1,19.1,0,0,1,3.9,4.878,28.445,28.445,0,0,1,2.439,6.341,37.865,37.865,0,0,1,.732,7.56v3.9A22.5,22.5,0,0,1,90,134.7a31.048,31.048,0,0,1-20.974,6.341h0a193.528,193.528,0,0,1-20.73-.976A172.488,172.488,0,0,1,30,137.379v-20.73H59.022c2.683,0,5.366-.244,8.048-.488a7.142,7.142,0,0,0,3.9-1.707,4.371,4.371,0,0,0,.976-3.414V108.6a5.737,5.737,0,0,0-1.219-3.9,10.23,10.23,0,0,0-3.414-2.195,38.336,38.336,0,0,0-5.609-.976l-24.389-.976v-20L59.754,79.09a17.343,17.343,0,0,0,7.8-1.707A3.95,3.95,0,0,0,70,73.237V72.017a5.251,5.251,0,0,0-2.683-5.366,20.064,20.064,0,0,0-10-1.463H30.488V44.458c5.853-.976,11.95-1.951,18.291-2.683Z" transform="translate(-30 -40.769)"/> <path id="Path_10" data-name="Path 10" d="M135.973,114.228V68.865A33.454,33.454,0,0,0,132.8,53.5a22.037,22.037,0,0,0-8.78-9.512,28.637,28.637,0,0,0-14.145-3.171H88.415a31.479,31.479,0,0,0-14.877,3.171A23.229,23.229,0,0,0,64.271,53.5,36.913,36.913,0,0,0,61.1,68.865v45.363a32.607,32.607,0,0,0,3.171,14.389,22.028,22.028,0,0,0,9.024,9.268,35.809,35.809,0,0,0,15.121,3.171h21.218a25.2,25.2,0,0,0,19.511-7.073A27.28,27.28,0,0,0,135.973,114.228Zm-25.364-1.951a6.639,6.639,0,0,1-7.56,5.609H95v.244a7.721,7.721,0,0,1-5.609-1.707,8.03,8.03,0,0,1-1.951-6.1V71.548a8.685,8.685,0,0,1,1.707-5.853,6.786,6.786,0,0,1,5.122-1.951h10a8.03,8.03,0,0,1,4.634,1.463,8.03,8.03,0,0,1,1.951,6.1v38.534A9.15,9.15,0,0,0,110.609,112.277Z" transform="translate(14.749 -40.787)"/> </g> </g> </svg>
                            </a>
                            <?php if ($settings['show_sound_volume'] === 'yes'): ?>
                            <div class="sound-volume">
                                <i class="fas fa-volume-up"></i>
                                <div class="sound-volume-box">
                                    <input type="range" class="change-sound-volume" min="0" max="100" step="1" value="50" orient="vertical">
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($settings['show_sound_speed'] === 'yes'): ?>
                            <div class="sound-speed">
                                <i class="fas fa-tachometer-alt"></i>
                                <div class="sound-speed-box">
                                    <span class="speed-item" data-value="0.5">0.5</span>
                                    <span class="speed-item" data-value="0.75">0.75</span>
                                    <span class="speed-item active" data-value="1"><?php echo esc_html__('Normal', 'ahura') ?></span>
                                    <span class="speed-item" data-value="1.25">1.25</span>
                                    <span class="speed-item" data-value="1.5">1.5</span>
                                    <span class="speed-item" data-value="1.75">1.75</span>
                                    <span class="speed-item" data-value="2">2</span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="sound-cols sound-cols-eq sound-timer-wrap" id="timer-progress-<?php echo $wid; ?>-<?php echo md5($sound_audio) ?>">
                    <div class="sound-col-content">
                        <div class="sound-timer-line">
                            <span class="stl"></span>
                            <div class="sound-timer-progress" data-player-id="<?php echo $wid; ?>"><span></span></div>
                            <input dir="<?php echo is_rtl() ? 'rtl' : 'ltr' ?>" type="range" min="0" max="100" value="0" class="sound-player-range" data-player-id="<?php echo $wid; ?>" data-hash="<?php echo md5($sound_audio) ?>">
                        </div>
                        <div class="sound-timer-time">
                            <span class="sound-timer-default" title="<?php echo __('Remaining Time', 'ahura') ?>"><?php echo $length ?></span>
                            <span class="sound-timer-down">00:00</span>
                        </div>
                    </div>
                </div>
                <?php if(!$buttons_disabled): ?>
                <div class="sound-cols sound-cols-eq sound-buttons-wrap">
                    <div class="sound-col-content">
                        <?php if($settings['show_share'] == 'yes'): ?>
                        <a href="#" class="sound-control-btn sound-btn-share" data-player-id="<?php echo $wid; ?>" data-item-id="<?php echo $sound['_id'] ?>">
                            <i class="fas fa-share"></i>
                        </a>
                        <?php endif; ?>
                        <?php if($settings['show_playlist'] == 'yes' && $soundsCount > 1): ?>
                        <a href="#" class="sound-control-btn sound-btn-playlist" data-player-id="<?php echo $wid; ?>">
                            <span class="sound-badge"><?php echo $soundsCount; ?></span>
                            <i class="fas fa-list"></i>
                        </a>
                        <?php endif; ?>
                        <?php if($settings['show_download'] == 'yes'): ?>
                        <a href="<?php echo $sound_audio ?>" data-player-id="<?php echo $wid; ?>" class="sound-control-btn sound-btn-download">
                            <i class="fas fa-download"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($settings['show_share'] == 'yes'): ?>
                    <div class="sound-player-share-buttons sound-player-share-buttons-<?php echo $sound['_id'] ?>" data-item-id="<?php echo $sound['_id'] ?>" style="display:none">
                        <div class="player-share-buttons-content">
                            <div class="share-close" data-item-id="<?php echo $sound['_id'] ?>" data-player-id="<?php echo $wid; ?>"><i class="fa fa-times"></i></div>
                            <a href="https://api.whatsapp.com/send?text=<?php echo $sound['item_title'] . '/' . $sound['item_subtitle'] . ': ' . $sound_audio ?>" data-pattern="https://api.whatsapp.com/send?text={{title}} - {{url}}" class="btn-wa" target="_blank"><i class="fab fa-whatsapp"></i><?php echo esc_html__('Whatsapp', 'ahura') ?></a>
                            <a href="https://www.linkedin.com/shareArticle?url=<?php echo $sound_audio ?>&title=<?php echo $sound['item_title'] . '/' . $sound['item_subtitle'] ?>" data-pattern="https://www.linkedin.com/shareArticle?url={{url}}&title={{title}}" class="btn-lin" target="_blank"><i class="fab fa-linkedin"></i><?php echo esc_html__('Linkedin', 'ahura') ?></a>
                            <a href="https://twitter.com/share?url=<?php echo $sound_audio ?>&text=<?php echo $sound['item_title'] . '/' . $sound['item_subtitle'] ?>" data-pattern="https://twitter.com/share?url={{url}}&text={{title}}" class="btn-tw" target="_blank"><i class="fab fa-twitter"></i><?php echo esc_html__('Twitter', 'ahura') ?></a>
                            <a href="https://www.facebook.com/sharer.php?u=<?php echo $sound_audio ?>" class="btn-fb" target="_blank" data-pattern="https://www.facebook.com/sharer.php?u={{url}}"><i class="fab fa-facebook"></i><?php echo esc_html__('Facebook', 'ahura') ?></a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php 
                else:
                    Ahura_Alert::frontNotice(__('Please select a valid audio file.', 'ahura'), Ahura_Alert::ERROR);
                endif;
                ?>
            </div>
            <?php
            $i++;
            endforeach;
            ?>
            <?php if($soundsCount > 1): ?>
                <div class="sound-player-playlist" style="display:none">
                        <?php
                        $i = 0;
                        foreach($sounds as $sound):
                            $i++;
                            $sound_audio = $sound['item_audio']['url'];
                            $meta = get_post_meta($sound['item_audio']['id'] , '_wp_attachment_metadata', true);
                            $length = $meta && isset($meta['length_formatted']) ? $meta['length_formatted'] : '00:00';
                        ?>
                        <div class="sound-playlist-item sound-playlist-item-<?php echo md5($sound_audio) ?> sound-playlist-item-<?php echo $sound['_id'] ?> <?php echo $i == 1 ? ' active' : '' ?>">
                            <?php if($settings['show_share'] == 'yes'): ?>
                                <div class="sound-player-share-buttons sound-player-share-buttons-<?php echo $sound['_id'] ?>" data-item-id="<?php echo $sound['_id'] ?>" style="display:none">
                                    <div class="player-share-buttons-content">
                                        <div class="share-close" data-item-id="<?php echo $sound['_id'] ?>" data-player-id="<?php echo $wid; ?>"><i class="fa fa-times"></i></div>
                                        <a href="https://api.whatsapp.com/send?text=<?php echo $sound['item_title'] . '/' . $sound['item_subtitle'] . ': ' . $sound_audio ?>" class="btn-wa" target="_blank"><i class="fab fa-whatsapp"></i><?php echo esc_html__('Whatsapp', 'ahura') ?></a>
                                        <a href="https://www.linkedin.com/shareArticle?url=<?php echo $sound_audio ?>&title=<?php echo $sound['item_title'] . '/' . $sound['item_subtitle'] ?>" class="btn-lin" target="_blank"><i class="fab fa-linkedin"></i><?php echo esc_html__('Linkedin', 'ahura') ?></a>
                                        <a href="https://twitter.com/share?url=<?php echo $sound_audio ?>&text=<?php echo $sound['item_title'] . '/' . $sound['item_subtitle'] ?>" class="btn-tw" target="_blank"><i class="fab fa-twitter"></i><?php echo esc_html__('Twitter', 'ahura') ?></a>
                                        <a href="https://www.facebook.com/sharer.php?u=<?php echo $sound_audio ?>" class="btn-fb" target="_blank"><i class="fab fa-facebook"></i><?php echo esc_html__('Facebook', 'ahura') ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <?php if(!empty($sound_audio) && $sound_audio !== 'undefined'): ?>
                                <div class="col-1">.<?php echo $i; ?></div>
                                <div class="col-3"><?php echo $sound['item_title']; ?></div>
                                <div class="col-4"><?php echo $sound['item_subtitle']; ?></div>
                                <div class="col-2"><?php echo $length; ?></div>
                                <div class="col-2">
                                    <a href="#" class="sound-control-btn sound-btn-playing sound-btn-play in-playlist" data-title="<?php echo isset($sound['item_title']) ? $sound['item_title'] : ''; ?>" data-subtitle="<?php echo isset($sound['item_subtitle']) ? $sound['item_subtitle'] : ''; ?>" data-item-id="<?php echo isset($sound['_id']) ? $sound['_id'] : '' ?>" data-cover="<?php echo isset($sound['item_cover']['url']) ? $sound['item_cover']['url'] : ''; ?>" data-duration="<?php echo isset($meta['length']) ? $meta['length'] : ''; ?>" data-length="<?php echo $length; ?>" data-player-id="<?php echo $wid; ?>" data-audio="<?php echo $sound_audio ?>" data-hash="<?php echo md5($sound_audio) ?>">
                                        <svg class="player-play-icon" xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="Group_31" data-name="Group 31"> <g id="Polygon_4" data-name="Polygon 4" transform="translate(343 -41) rotate(90)" fill="none"><path d="M 191.4999542236328 77.89984130859375 C 175.8775482177734 77.89984130859375 161.9220123291016 85.9970703125 154.1689605712891 99.55996704101562 L 66.07882690429688 253.6600189208984 C 58.3831787109375 267.1224975585938 58.43484497070312 283.167236328125 66.21707153320312 296.5798950195312 C 73.99923706054688 309.9924926757812 87.90313720703125 318 103.4099426269531 318 L 279.590087890625 318 C 295.0968933105469 318 309.0007934570312 309.9924926757812 316.782958984375 296.579833984375 C 324.5651245117188 283.167236328125 324.6167907714844 267.1224975585938 316.9210815429688 253.6600189208984 L 228.8310089111328 99.55990600585938 C 221.0778961181641 85.9970703125 207.1223754882812 77.89984130859375 191.4999542236328 77.89984130859375 M 191.4999847412109 60.89987182617188 C 211.7859344482422 60.89987182617188 232.0718688964844 70.97430419921875 243.5897827148438 91.12319946289062 L 331.6798400878906 245.2233123779297 C 354.5452575683594 285.2227172851562 325.6637268066406 335 279.590087890625 335 L 103.4099426269531 335 C 57.33624267578125 335 28.45477294921875 285.2227172851562 51.320068359375 245.2233123779297 L 139.4101867675781 91.12319946289062 C 150.9281005859375 70.97430419921875 171.2140502929688 60.89987182617188 191.4999847412109 60.89987182617188 Z" stroke="none" fill="#000"/> </g> </g> </svg>
                                        <svg class="player-pause-icon" xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"> <g id="Group_28" data-name="Group 28"> <rect id="Rectangle_5" data-name="Rectangle 5" width="70" height="292" rx="35"/> <rect id="Rectangle_6" data-name="Rectangle 6" width="70" height="292" rx="35" transform="translate(182 4)"/> </g> </svg>
                                    </a>
                                    <?php if($settings['show_share'] == 'yes'): ?>
                                        <a href="#" class="sound-control-btn sound-btn-share sound-btn-share-in-playlist" data-player-id="<?php echo $wid; ?>" data-item-id="<?php echo $sound['_id'] ?>">
                                            <i class="fas fa-share"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if($settings['show_download'] == 'yes'): ?>
                                        <a href="<?php echo $sound_audio ?>" data-player-id="<?php echo $wid; ?>" class="sound-control-btn sound-btn-download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                    <div class="col-12"><?php echo Ahura_Alert::frontNotice(__('Please select a valid audio file.', 'ahura'), Ahura_Alert::ERROR); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <script type="text/javascript" id="sound_player_inline_js_<?php echo $wid; ?>">
                ahura_elementor_players_data[`player_<?php echo $wid ?>`] = {'save_audio': <?php echo $settings['save_sound_time'] == 'yes' ? 'true' : 'false' ?>};
            </script>
        </div>
        <?php
        endif; 
    }
}