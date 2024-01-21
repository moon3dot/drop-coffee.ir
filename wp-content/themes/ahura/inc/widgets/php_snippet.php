<?php
namespace ahura\inc\widgets;
// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class php_snippet extends \Elementor\Widget_Base {
	use \ahura\app\traits\mw_elementor;
	
	public function get_name() {
		return 'php_snippet';
	}

	public function get_title() {
		return __( 'PHP Snippet', 'ahura' );
	}

	public function get_icon() {
		return 'aicon-svg-php-snippet';
	}

	public function get_categories() {
		return [ 'ahuraelements' ];
	}
	function get_keywords()
	{
		return ['php_snippet', 'phpsnippet', esc_html__( 'PHP Snippet' , 'ahura')];
	}

	public function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'ahura' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'ahura' ),
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
					],
				],
				'default' => 'right',
				'toggle' => true,
			]
		);
		
		$this->add_control(
			'php_snippet_code',
			[
				'label' => __( 'PHP snippet code', 'ahura' ),
				'type' => \Elementor\Controls_Manager::CODE,
				'language' => 'php',
				'rows' => 20,
				'description' => __( 'Enter the code without &lt;?php ?&gt;.', 'ahura' )
			]
		);

		$this->end_controls_section();
	}

    public function safe_execute_php_code($code){
        if(!empty($code) && !wp_doing_ajax()){
            try {
                return eval("{$code}");
            }  catch (\Error $e) {
                return $e->getMessage();
            } catch (\Exception $e) {
                return $e->getMessage();
            } catch (\ParseError $e) {
                return $e->getMessage();
            }
        }
    }

	public function render() {
		$settings = $this->get_settings_for_display(); 
		$code = $settings['php_snippet_code'];
		
		if(!wp_doing_ajax()):
		?>
        <div class="ahura_code_snippet" style="text-align:<?php echo $settings['text_align']; ?>">
            <?php
            if(!empty($code)){
                echo $this->safe_execute_php_code($code);
            } else {
                echo sprintf("<div class='ahura-element-not-found-msg'>%s</div>", __('With this element you can execute PHP codes.', 'ahura'));
            }
            ?>
        </div>
        <?php 
        else: 
            \ahura\app\Ahura_Alert::frontNotice(__('To see the result, open the preview page in a new tab.', 'ahura'), \ahura\app\Ahura_Alert::INFO);
        endif; ?>
        <?php
	}
}
