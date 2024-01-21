<?php
namespace ahura\inc\widgets;

// Block direct access to the main theme file.
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;
use ahura\app\Ahura_Alert;

class video_player extends \Elementor\Widget_Base
{
    /**
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('video_player_css', mw_assets::get_css('elementor.video_player'));
        mw_assets::register_style('plyr_css', mw_assets::get_css('plyr'));
        mw_assets::register_script('video_player_js', mw_assets::get_js('elementor.video_player'), null, false);
        mw_assets::localize('video_player_js', 'element_avp', [
            'restart' => esc_html__('Restart', 'ahura'),
            'rewind' => sprintf(esc_html__('Rewind %s seconds', 'ahura'), '{seektime}'),
            'play' => esc_html__('Play', 'ahura'),
            'pause' => esc_html__('Pause', 'ahura'),
            'fastForward' => sprintf(esc_html__('Forward %s seconds', 'ahura'), '{seektime}'),
            'seekLabel' => sprintf(esc_html__('%s of %s', 'ahura'), '{currentTime}', '{duration}'),
            'played' => esc_html__('Played', 'ahura'),
            'currentTime' => esc_html__('Current time', 'ahura'),
            'duration' => esc_html__('Duration', 'ahura'),
            'volume' => esc_html__('Volume', 'ahura'),
            'mute' => esc_html__('Mute', 'ahura'),
            'unmute' => esc_html__('Unmute', 'ahura'),
            'enableCaptions' => esc_html__('Enable captions', 'ahura'),
            'disableCaptions' => esc_html__('Disable captions', 'ahura'),
            'download' => esc_html__('Download', 'ahura'),
            'enterFullscreen' => esc_html__('Enter fullscreen', 'ahura'),
            'exitFullscreen' => esc_html__('Exit fullscreen', 'ahura'),
            'frameTitle' => sprintf(esc_html__('Player for %s', 'ahura'), '{title}'),
            'captions' => esc_html__('Captions', 'ahura'),
            'settings' => esc_html__('Settings', 'ahura'),
            'pip' => esc_html__('PIP', 'ahura'),
            'menuBack' => esc_html__('Go back to previous menu', 'ahura'),
            'speed' => esc_html__('Speed', 'ahura'),
            'normal' => esc_html__('Normal', 'ahura'),
            'quality' => esc_html__('Quality', 'ahura'),
            'loop' => esc_html__('Loop', 'ahura'),
            'start' => esc_html__('Start', 'ahura'),
            'end' => esc_html__('End', 'ahura'),
            'all' => esc_html__('All', 'ahura'),
            'reset' => esc_html__('Reset', 'ahura'),
            'disabled' => esc_html__('Disabled', 'ahura'),
            'enabled' => esc_html__('Enabled', 'ahura'),
        ]);
        mw_assets::register_script('plyr_js', mw_assets::get_js('plyr'), null, false);
    }

    public function get_style_depends()
    {
        return [mw_assets::get_handle_name('plyr_css'), mw_assets::get_handle_name('video_player_css')];
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('plyr_js'), mw_assets::get_handle_name('video_player_js')];
    }

    public function get_name()
    {
        return 'ahura_video_player';
    }

    public function get_title()
    {
        return esc_html__('Video Player', 'ahura');
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
        return ['videoplayer', 'video_player', esc_html__('Video Player', 'ahura')];
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
            'type',
            [
                'label' => esc_html__( 'Type', 'ahura' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'direct',
                'options' => [
                    'direct' => esc_html__( 'Direct Link', 'ahura' ),
                    'youtube' => esc_html__( 'Youtube', 'ahura' ),
                    'vimeo' => esc_html__( 'Vimeo', 'ahura' ),
                ],
            ]
        );

        $this->add_control(
            'video_cover',
            [
                'label' => esc_html__('Cover', 'ahura'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'type' => 'direct'
                ]
            ]
        );

        $video_repeater = new \Elementor\Repeater();

        $video_repeater->add_control(
            'video',
            [
                'label' => esc_html__('Video', 'ahura'),
                'type' => Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'default' => [
                    'url' => 'undefined',
                ],
            ]
        );

        $video_repeater->add_control(
            'quality',
            [
                'label' => esc_html__( 'Quality', 'ahura' ),
                'type' => Controls_Manager::SELECT,
                'default' => 0,
                'options' => [
                    0 => esc_html__( 'Default', 'ahura' ),
                    '480' => '480P',
                    '576' => '576P',
                    '720' => '720P (HD)',
                    '1080' => '1080P (Full HD)',
                    '1440' => '1440P (QHD)',
                    '2160' => '4K',
                ],
            ]
        );

        $this->add_control(
            'video_list',
            [
                'label' => esc_html__('Video Qualities', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $video_repeater->get_controls(),
                'condition' => [
                    'type' => 'direct'
                ]
            ]
        );

        $this->add_control(
            'use_caption',
            [
                'label' => esc_html__('Use Caption', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'type' => 'direct',
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'caption_title',
            [
                'label' => esc_html__('Title', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('English', 'ahura'),
            ]
        );

        $repeater->add_control(
            'caption_code',
            [
                'label' => esc_html__('Caption Code', 'ahura'),
                'type' => Controls_Manager::TEXT,
                'default' => 'EN',
            ]
        );

        $repeater->add_control(
            'caption_file',
            [
                'label' => esc_html__('Caption File', 'ahura'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'description' => esc_html__('Support .vtt format.', 'ahura')
            ]
        );

        $repeater->add_control(
            'default_caption',
            [
                'label' => esc_html__('Default', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'captions',
            [
                'label' => esc_html__('Captions', 'ahura'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'condition' => [
                    'type' => 'direct',
                    'use_caption' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'iframe_video_id',
            [
                'label' => esc_html__( 'Video ID', 'ahura' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                        'type!' => 'direct'
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('Settings', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'type' => 'direct'
                ]
            ]
        );

        $this->add_control(
            'player_controls',
            [
                'label' => esc_html__( 'Controls', 'ahura' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => [
                    'play-large' => esc_html__('Play Large Button', 'ahura'),
                    'mute' => esc_html__('Mute', 'ahura'),
                    'pip' => esc_html__('PIP', 'ahura'),
                    'download' => esc_html__('Download', 'ahura'),
                    'fullscreen' => esc_html__('Fullscreen', 'ahura'),
                    'settings' => esc_html__('Settings', 'ahura'),
                ],
                'default' => ['play-large', 'download', 'fullscreen', 'pip', 'mute', 'settings'],
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
            'player_style_section',
            [
                'label' => esc_html__('Player', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'pri_color',
            [
                'label' => esc_html__('Primary Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .plyr' => '--plyr-color-main: {{VALUE}};'
                ],
                'default' => '#00b3ff',
            ]
        );

        $this->add_control(
            'sec_color',
            [
                'label' => esc_html__('Secondary Color', 'ahura'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .plyr' => '--plyr-video-control-color-hover: {{VALUE}};',
                    '{{WRAPPER}} .plyr button.plyr__control--overlaid' => 'color: {{VALUE}};'
                ],
                'default' => '#ffffff',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'box_style_section',
            [
                'label' => esc_html__('Box', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .plyr, {{WRAPPER}} iframe',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__( 'Border radius', 'ahura' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .plyr, {{WRAPPER}} iframe' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box Shadow', 'ahura'),
                'selector' => '{{WRAPPER}} .plyr, {{WRAPPER}} iframe',
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

        $type = $settings['type'];
        $video_qualities = $settings['video_list'];
        $use_caption = $settings['use_caption'] === 'yes';
        $captions = $settings['captions'];
        $iframe_video_id = $settings['iframe_video_id'];
        $controls = $settings['player_controls'];
        ?>
            <div class="ahura-video-player-element video-player-<?php echo $wid; ?>">
                <?php if ($type == 'direct'): ?>
                    <video id="ahura_player_<?php echo $wid ?>" playsinline preload="none" data-poster="<?php echo $settings['video_cover']['url'] ?>">
                        <?php
                        if (!empty($video_qualities)):
                            foreach ($video_qualities as $item):
                                $quality = $item['quality'] != 0 ? sprintf('size="%s"', $item['quality']) : '';
                                ?>
                            <source src="<?php echo $item['video']['url'] ?>" type="video/mp4" <?php echo $quality ?>>
                            <?php endforeach;
                            endif; ?>
                        <?php
                        if ($use_caption && !empty($captions)):
                            foreach ($captions as $item):
                                $is_default = $item['default_caption'] === 'yes' ? 'default' : '';
                                ?>
                                <track kind="captions" label="<?php echo $item['caption_title'] ?>" src="<?php echo $item['caption_file']['url'] ?>" srclang="<?php echo strtolower($item['caption_code']) ?>" <?php echo $is_default ?>/>
                            <?php endforeach;
                        endif; ?>
                    </video>
                <?php else:
                    $src = $type == 'youtube' ? 'https://www.youtube.com/embed/' . $iframe_video_id : 'https://player.vimeo.com/video/' . $iframe_video_id;
                    ?>
                    <div class="plyr__video-embed" id="ahura_player_<?php echo $wid ?>">
                        <iframe src="<?php echo $src ?>" allowfullscreen allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture;web-share"></iframe>
                    </div>
                <?php endif; ?>
                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        const player_<?php echo $wid ?> = new Plyr(document.getElementById('ahura_player_<?php echo $wid ?>'), {
                            tooltips: {controls: true, seek: true},
                            controls: [
                                <?php echo in_array('play-large', $controls) ? "'play-large'," : '' ?>
                                'play',
                                'progress',
                                'current-time',
                                'duration',
                                <?php echo in_array('mute', $controls) ? "'mute'," : '' ?>
                                'volume',
                                <?php echo $use_caption ? "'captions'," : '' ?>
                                <?php echo in_array('settings', $controls) ? "'settings'," : '' ?>
                                <?php echo in_array('download', $controls) ? "'download'," : '' ?>
                                <?php echo in_array('pip', $controls) ? "'pip'," : '' ?>
                                <?php echo in_array('fullscreen', $controls) ? "'fullscreen'," : '' ?>
                            ],
                            i18n: ahura_video_player_i18n,
                        });
                    });
                </script>
            </div>
        <?php
    }
}