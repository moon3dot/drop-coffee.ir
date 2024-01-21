<?php
namespace ahura\app\customization;

if(class_exists('WP_Customize_Control'))
{
    class heading_box extends \WP_Customize_Control
    {
        /**
         * Renders the control wrapper and calls $this->render_content() for the internals.
         *
         * @since 3.4.0
         */
        protected function render() {
            $id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
            $class = 'ah-heading-box-wrap customize-control customize-control-' . $this->type;

            printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
            $this->render_content();
            echo '</li>';
        }

        function render_content()
        {
            ?>
            <div class="ahura_customize_heading_box_wrapper <?php echo is_rtl() ? 'ahura_rtl_mode' : 'ahura_ltr_mode'; ?>">
                <div class="ah-heading">
                    <?php echo $this->label; ?>
                </div>
                <?php if(!empty($this->description)):?>
                    <span class="ahura_cusomize_controller_description margin_top"><?php echo $this->description;?></span>
                <?php endif; ?>
            </div>
            <?php
        }
    }
}