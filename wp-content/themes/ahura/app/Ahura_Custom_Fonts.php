<?php

namespace ahura\app;

class Ahura_Custom_Fonts
{
    public static function getFontsObj(){
        return get_posts(['post_type' => 'ahura_fonts', 'post_status' => 'publish']);
    }

    public static function getFonts(){
        $fonts = static::getFontsObj();
        $arr = [];
        if($fonts){
            foreach($fonts as $font){
                $options = get_post_meta($font->ID, 'font_variations');
                if($options){
                    foreach($options as $key => $option){
                        if(is_array($option) && count($option) > 0){
                            $arr[$font->ID] = [
                                'font_family' => ($font->post_title) ? $font->post_title : '',
                                'vars' => $option
                            ];
                        }
                    }
                }
            }
        }
        return $arr;
    }

    public static function getFontsCSS(){
        $custom_fonts = self::getFonts();

        ob_start();
        if ($custom_fonts):
            foreach ($custom_fonts as $font):
                $vars = $font['vars'];
                if(!is_array($vars) || (is_array($vars) && count($vars) <= 0))
                    continue;
                foreach($vars as $key => $value):
                    $eot = $value['eot']['url'] ?? false;
                    $woff2 = $value['woff2']['url'] ?? false;
                    $woff = $value['woff']['url'] ?? false;
                    $ttf = $value['ttf']['url'] ?? false;
                    $eol = PHP_EOL;
                    $is_ok = ($eot || $woff2 || $woff || $ttf);
                    if ($is_ok):
                        ?>
                        @font-face {
                            font-family: <?php echo $font['font_family'] ?>;
                            font-style: normal;
                            font-weight: <?php echo $value['font_weight'] ?>;
                            <?php echo (!empty($eot)) ? "src: url('{$eot}');" . $eol : ''; ?>
                            src: <?php echo (!empty($eot)) ? "url('{$eot}?#iefix') format('embedded-opentype')" . (($woff2 || $woff || $ttf) ? ',' : '') . $eol : ''; ?>
                            <?php echo (!empty($woff2)) ? "url('{$woff2}') format('woff2')" . (($woff || $ttf) ? ',' : '') . $eol : ''; ?>
                            <?php echo (!empty($woff)) ? "url('{$woff}') format('woff')" . (($ttf) ? ',' : '') . $eol : ''; ?>
                            <?php echo (!empty($ttf)) ? "url('{$ttf}') format('truetype')" : ''; ?>;
                            font-display: swap;
                        }
                    <?php
                    endif;
                endforeach;
            endforeach;
        endif;
        return ob_get_clean();
    }
}