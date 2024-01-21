<?php
namespace ahura\inc\widgets;

// Die if is direct opened file
defined('ABSPATH') or die('No script kiddies please!');

use Elementor\Controls_Manager;
use ahura\app\mw_assets;

class neshan_map extends \Elementor\Widget_Base
{
    /**
     * neshan_map constructor.
     * @param array $data
     * @param null $args
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        mw_assets::register_style('leaflet_css', mw_assets::get_css('leaflet'));
        mw_assets::register_style('neshanmap_css', mw_assets::get_css('elementor.neshan_map'));

        mw_assets::register_script('leaflet_js', mw_assets::get_js('leaflet'));
    }

    public function get_style_depends()
    {
        $styles = [mw_assets::get_handle_name('leaflet_css'), mw_assets::get_handle_name('neshanmap_css')];
        return $styles;
    }

    public function get_script_depends()
    {
        return [mw_assets::get_handle_name('leaflet_js')];
    }

    /**
     *
     * Set element id
     *
     * @return string
     */
    public function get_name()
    {
        return 'ahura_neshanmap';
    }

    /**
     *
     * Set element widget
     *
     * @return mixed
     */
    public function get_title()
    {
        return esc_html__('Neshan Map', 'ahura');
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
        return ['neshanmap', 'neshan_map', esc_html__('Neshan Map', 'ahura')];
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
                'description' => __('The public access key has a lot of limitations and after some time it becomes inactive and inaccessible, be sure to get a private key and use it.', 'ahura')
            ]
        );

        $this->add_control(
            'style_mode',
            [
                'label' => esc_html__('Style', 'ahura'),
                'type' => Controls_Manager::SELECT,
                'default' => 'dreamy',
				'options' => [
					'dreamy' => esc_html__('Dreamy', 'ahura'),
					'dreamy-gold' => esc_html__('Dreamy Gold', 'ahura'),
					'neshan' => esc_html__('Neshan', 'ahura'),
					'standard-day' => esc_html__('Standard Day', 'ahura'),
					'standard-night' => esc_html__('Standard Night', 'ahura'),
					'osm-bright' => esc_html__('OSM Bright', 'ahura'),
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
            'traffic_mode',
            [
                'label' => esc_html__('Traffic Mode', 'ahura'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'ahura'),
                'label_off' => esc_html__('No', 'ahura'),
                'return_value' => 'yes',
                'default' => 'no',
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
			'marker',
			[
				'label' => esc_html__('Marker Image', 'ahura'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => get_template_directory_uri() . '/img/marker-icon.png',
				],
                'condition' => [
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
                'selectors' => [
                    '{{WRAPPER}} .ahura-map-element' => 'height: {{SIZE}}{{UNIT}};',
                ],
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
				'selector' => '{{WRAPPER}} .ahura-map-element .leaflet-tile-pane',
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
                    '{{WRAPPER}} .ahura-map-element .leaflet-marker-icon' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .ahura-map-element .leaflet-marker-icon' => 'height: {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ahura-map-element .leaflet-marker-icon',
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
        $traffic_mode = $settings['traffic_mode'] == 'yes';
        $style_key = $style_mode == 'custom' && !empty($settings['style_key']) ? $settings['style_key'] : false;
        $zoom = intval($settings['zoom']) ? $settings['zoom'] : 11;
        $lng = !empty($settings['lng']) ? $settings['lng'] : 52.5418852538383;
        $lat = !empty($settings['lat']) ? $settings['lat'] : 29.6085199586813;
        $show_points = $settings['points_show'] == 'yes';
        $points = $show_points ? $settings['points'] : false;
        $marker = is_array($settings['marker']) && !empty($settings['marker']['url']) ? $settings['marker']['url'] : get_template_directory_uri() . '/img/marker-icon.png';

        if($settings['use_public_key'] === 'yes'){
            $api_key = 'web.f3d7b74a30074170a33bf60f509609f2';
        }

        if(!empty($api_key)):
        ?>
        <div class="ahura-map-element-wrap neshan-map-1 neshan-map-1-<?php echo $wid ?>">
            <?php if(is_admin()): ?>
                <div class="map-details"><div class="lnglat"><?php echo esc_html__('Just click on a point to get location information.', 'ahura') ?></div></div>
            <?php endif; ?>
            <div class="ahura-map-element" id="map_<?php echo $wid ?>"></div>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    if(typeof L !== undefined){
                        const map_<?php echo $wid ?> = new L.Map('map_<?php echo $wid ?>', {
                            key: '<?php echo $api_key ?>',
                            maptype: '<?php echo $style_mode != 'custom' ? $style_mode : $style_key; ?>',
                            poi: true,
                            traffic: <?php echo $traffic_mode ? 'true' : 'false' ?>,
                            center: [<?php echo $lat ?>, <?php echo $lng ?>],
                            zoom: <?php echo $zoom ?>
                        });
                        <?php if(is_admin()): ?>
                        map_<?php echo $wid ?>.on("click", function (e) {
                            if(typeof e.latlng !== undefined){
                                let lnglat = e.latlng,
                                    lng = lnglat.lng,
                                    lat = lnglat.lat,
                                    selector = jQuery('.neshan-map-1-<?php echo $wid ?> .map-details .lnglat');
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
                        <?php if($marker): ?>
                            const marker_<?php echo $wid ?> = L.icon({
                                iconUrl: '<?php echo $marker ?>',
                                iconAnchor: [22, 94],
                                popupAnchor: [-3, -76],
                            });
                        <?php endif; ?>
                        <?php 
                        if($points):
                            foreach($points as $point):
                                $key_id = md5(time() . md5($point['point_lng'] . $point['point_lat']));
                                $content_show = $point['point_content_show'] == 'yes';
                                $content = $point['point_content'];
                        ?>
                            const map_<?php echo $wid ?>_marker_<?php echo $key_id ?> = new L.marker([<?php echo $point['point_lat'] ?>, <?php echo $point['point_lng'] ?>], {icon: marker_<?php echo $wid ?>}).addTo(map_<?php echo $wid ?>);
                            <?php if($content_show && !empty($content)): ?>
                            map_<?php echo $wid ?>_marker_<?php echo $key_id ?>.bindPopup(`<?php echo $content ?>`);
                            <?php endif; ?>
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