<?php
namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class mapbox_1 extends \Elementor\Widget_Base
{
    /**
     * mapbox_1 constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('mapbox_css', mw_assets::get_css('mapbox-gl'));
        mw_assets::register_style('mapbox1_css', mw_assets::get_css('elementor.mapbox1'));

        mw_assets::register_script('mapbox_js', mw_assets::get_js('mapbox-gl'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('mapbox1_css'), mw_assets::get_handle_name('mapbox_css')];
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('mapbox_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'ahura_mapbox1';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Mapbox', 'ahura');
    }

    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-map-pin';
    }

    /**
     *
     * Set element category
     *
     * @return string[]
     */
    public function get_categories()
    {
        return ['ahuraelements'];
    }

    /**
     *
     * Keywords for search
     *
     * @return array
     */
    function get_keywords()
    {
        return ['mapbox1', 'mapbox_1', esc_html__('Mapbox', 'ahura')];
    }

    /**
     *
     * Element controls option
     *
     */
    public function register_controls()
    {
        /**
         *
         * Start content section
         *
         */
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'api_key',
            [
                'label' => esc_html__('Api Key', 'ahura'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'use_public_key!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'use_public_key',
            [
                'label' => esc_html__('Using public key', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('It is recommended to use your own private key, public keys have many restrictions and are suitable for low traffic websites.', 'ahura')
            ]
        );

        $this->add_control(
            'style_mode',
            [
                'label' => esc_html__('Style', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
				'options' => [
					'default'  => esc_html__('Default', 'ahura'),
					'custom' => esc_html__('Custom', 'ahura'),
				],
            ]
        );

        $this->add_control(
            'style_key',
            [
                'label' => esc_html__('Style Key', 'ahura'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'style_mode' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'zoom',
            [
                'label' => esc_html__('Zoom', 'ahura'),
                'type' => Controls_Manager::NUMBER,
                'default' => 11,
                'min' => 1,
                'step' => 1,
            ]
        );

        $this->add_control(
            'lng',
            [
                'label' => esc_html__('Longitude', 'ahura'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => 52.5418852538383
            ]
        );

        $this->add_control(
            'lat',
            [
                'label' => esc_html__('Latitude', 'ahura'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => 29.6085199586813
            ]
        );

        $this->add_control(
            'use_custom_marker',
            [
                'label' => esc_html__('Custom Marker', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'points_show' => 'yes'
                ]
            ]
        );

        $this->add_control(
			'marker',
			[
				'label' => esc_html__('Marker Image', 'ahura'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => get_template_directory_uri() . '/img/marker-icon.png',
				],
                'condition' => [
                    'use_custom_marker' => 'yes',
                    'points_show' => 'yes'
                ]
			]
		);

        $this->end_controls_section();
        $this->start_controls_section(
            'points_content_section',
            [
                'label' => esc_html__('Points', 'ahura'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'points_show',
            [
                'label' => esc_html__('Show Points', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'point_lng',
            [
                'label' => esc_html__('Longitude', 'ahura'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => 52.5418852538383
            ]
        );

        $repeater->add_control(
            'point_lat',
            [
                'label' => esc_html__('Latitude', 'ahura'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => 29.6085199586813
            ]
        );

        $repeater->add_control(
            'point_content_show',
            [
                'label' => esc_html__('Show Content', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ahura'),
                'label_off' => esc_html__('Hide', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
			'point_content',
			[
				'label' => esc_html__('Content', 'ahura'),
				'type' => Controls_Manager::WYSIWYG,
                'condition' => [
                    'point_content_show' => 'yes'
                ]
			]
		);

        $this->add_control(
            'points',
            [
                'label' => __('Points', 'ahura'),
                'type' =>Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'point_lng' => 52.5418852538383,
                        'point_lat' => 29.6085199586813,
                    ],
                    [
                        'point_lng' => 52.51003260512681,
                        'point_lat' => 29.628622280328173,
                    ],
                    [
                        'point_lng' => 52.579097723246036,
                        'point_lat' => 29.60678910778276,
                    ],
                    [
                        'point_lng' => 52.490737250618054,
                        'point_lat' => 29.606256532297905,
                    ],
                ],
                'condition' => [
                    'points_show' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'map_style',
            [
                'label' => esc_html__('Map', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'map_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem','%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'map_border',
                'label' => esc_html__('Border', 'ahura'),
                'selector' => '{{WRAPPER}} .ahura-map-element',
            ]
        );

        $this->add_control(
            'map_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ahura'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-map-element' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'map_css_filters',
				'selector' => '{{WRAPPER}} .ahura-map-element .mapboxgl-canvas',
			]
		);

        $this->end_controls_section();
        $this->start_controls_section(
            'map_marker_style',
            [
                'label' => esc_html__('Marker', 'ahura'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'points_show' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'marker_width',
            [
                'label' => esc_html__('Width', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-map-element .marker' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35
                ],
            ]
        );

        $this->add_responsive_control(
            'marker_height',
            [
                'label' => esc_html__('Height', 'ahura'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px','em','rem'],
                'selectors' => [
                    '{{WRAPPER}} .ahura-map-element .marker' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'map_marker_css_filters',
				'selector' => '{{WRAPPER}} .ahura-map-element .marker',
			]
		);

        $this->end_controls_section();
    }


    /**
     *
     * Render element content (html)
     *
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $wid = $this->get_id();
        $api_key = $settings['api_key'];
        $style_mode = $settings['style_mode'];
        $style_key = $style_mode == 'custom' && !empty($settings['style_key']) ? $settings['style_key'] : 'mapbox://styles/mapbox/streets-v11';
        $zoom = intval($settings['zoom']) ? $settings['zoom'] : 11;
        $lng = !empty($settings['lng']) ? $settings['lng'] : 52.5418852538383;
        $lat = !empty($settings['lat']) ? $settings['lat'] : 29.6085199586813;
        $show_points = $settings['points_show'] == 'yes';
        $points = $show_points ? $settings['points'] : false;
        $marker = $settings['use_custom_marker'] == 'yes' ? $settings['marker'] : false;
        $map_height = $settings['map_height'] ? "{$settings['map_height']['size']}{$settings['map_height']['unit']}" : '';

        if($settings['use_public_key'] === 'yes'){
            $api_key = 'pk.eyJ1IjoiYWxpcmV6YWRlaGthciIsImEiOiJja3A0eWVydXYxb3M0MnBtdzF2ZDI1MDQyIn0.0Pjo8FUUkr3o9zOPM1FxnA';
        }

        if(!empty($api_key)):
        ?>
        <div class="ahura-map-element-wrap mapbox-1 mapbox-1-<?php echo $wid ?>">
            <?php if(is_admin()): ?>
                <div class="map-details"><div class="lnglat"><?php echo esc_html__('Just click on a point to get location information.', 'ahura') ?></div></div>
            <?php endif; ?>
            <div class="ahura-map-element" id="map_<?php echo $wid ?>" style="height:<?php echo $map_height ?>"></div>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    if(typeof mapboxgl !== "undefined"){
                        mapboxgl.accessToken = '<?php echo $api_key ?>';
                        const map_<?php echo $wid ?> = new mapboxgl.Map({
                            container: 'map_<?php echo $wid ?>',
                            style: '<?php echo $style_key ?>',
                            center: [<?php echo $lng ?>, <?php echo $lat ?>],
                            zoom: <?php echo $zoom ?>,
                            projection: 'globe'
                        });
                        map_<?php echo $wid ?>.on('style.load', () => {
                            map_<?php echo $wid ?>.setFog({});
                        });
                        <?php if(is_admin()): ?>
                        map_<?php echo $wid ?>.on("click", function (e) {
                            if(typeof e.lngLat !== undefined){
                                let lnglat = e.lngLat,
                                    lng = lnglat.lng,
                                    lat = lnglat.lat,
                                    selector = jQuery('.mapbox-1-<?php echo $wid ?> .map-details .lnglat');
                                if(selector.length){
                                    if(lng && lat){
                                        selector.parent().css('display', 'block');
                                        selector.text(`<?php echo sprintf(esc_html__('Longitude: %s / Latitude: %s', 'ahura'), '${lng}', '${lat}') ?>`);
                                    } else {
                                        selector.parent().css('display', 'none');
                                    }
                                }
                            }
                        });
                        <?php endif; ?>
                        <?php 
                        if($points):
                            foreach($points as $point):
                                $key_id = md5(time() . md5($point['point_lng'] . $point['point_lat']));
                                $content_show = $point['point_content_show'] == 'yes';
                                $content = $point['point_content'];
                        ?>
                            <?php if($marker): ?>
                            const marker_<?php echo $wid ?>_<?php echo $key_id ?> = document.createElement('div');
                            marker_<?php echo $wid ?>_<?php echo $key_id ?>.className = 'marker marker-<?php echo $wid ?>';
                            marker_<?php echo $wid ?>_<?php echo $key_id ?>.style.backgroundImage = "url(<?php echo $marker['url'] ?>)";
                            <?php endif; ?>
                            const map_<?php echo $wid ?>_marker_<?php echo $key_id ?> = new mapboxgl.Marker(<?php echo $marker ? "marker_{$wid}_{$key_id}" : '' ?>).setLngLat([<?php echo $point['point_lng'] ?>, <?php echo $point['point_lat'] ?>]);
                            <?php if($content_show && !empty($content)): ?>
                            map_<?php echo $wid ?>_marker_<?php echo $key_id ?>.setPopup(
                                new mapboxgl.Popup({offset: 25})
                                .setHTML(
                                    `<?php echo $content ?>`
                                )
                            );
                            <?php endif; ?>
                            map_<?php echo $wid ?>_marker_<?php echo $key_id ?>.addTo(map_<?php echo $wid ?>);
                        <?php 
                            endforeach;
                        endif; ?>
                    }
                });
            </script>
        </div>
        <?php else: ?>
            <div class="ahura-element-msg">
                <?php echo __('Please enter the access key.','ahura');?>
            </div>
		<?php endif; ?>
        <?php
    }
}