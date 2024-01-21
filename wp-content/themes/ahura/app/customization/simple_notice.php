<?php
namespace ahura\app\customization;

if( class_exists( 'WP_Customize_Control' ) ) {
    class simple_notice extends \WP_Customize_Control {
        public $type = 'simple_notice';
        public function render_content() {
            $allowed_html = [
                'a'      => [ 'href' => [], 'title' => [], 'class' => [], 'target' => [] ],
                'br'     => [],
                'em'     => [],
                'strong' => [],
                'i'      => [ 'class' => [] ],
                'span'   => [ 'class' => [] ],
                'code'   => [],
            ];
        ?>
            <div class="ahura_cusomize_simple_notice">
                <?php if( !empty( $this->label ) ) { ?>
                    <span class="ahura_cusomize_simple_notice_title">
                        <?php echo esc_html( $this->label ); ?>
                    </span>
                <?php } ?>
                <?php if( !empty( $this->description ) ) { ?>
                    <span class="ahura_cusomize_simple_notice_description">
                        <?php echo wp_kses( $this->description, $allowed_html ); ?>
                    </span>
                <?php } ?>
            </div>
        <?php
        }
    }
}
