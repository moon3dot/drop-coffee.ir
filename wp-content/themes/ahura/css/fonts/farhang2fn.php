/**
*
*	Name:			farhang2 Fonts
*	Version:			2.1
*	Author:			Moslem Ebrahimi (moslemebrahimi.com)
*	Created on:		May 11, 2022
*	Updated on:		May 22, 2022
*	Website:			http://fontiran.com
*	Copyright:		Commercial/Proprietary Software
--------------------------------------------------------------------------------------
فونت فرهنگ یک نرم افزار مالکیتی محسوب می شود. جهت آگاهی از قوانین استفاده از این فونت ها لطفا به وب سایت (فونت ایران دات کام) مراجعه نمایید
--------------------------------------------------------------------------------------
farhang2 fonts are considered a proprietary software. To gain information about the laws regarding the use of these fonts, please visit www.fontiran.com
--------------------------------------------------------------------------------------
This set of fonts are used in this project under the license: (A3TPROI2)
------------------------------------------------------------------------------------- fonts/-
*
**/
<?php if(!\ahura\app\mw_options::get_mod_is_active_bold_fontface()): ?>
    @font-face {
    font-family: farhang2fn;
    font-style: normal;
    font-weight: 800;
    src: url('../../fonts/fanum/woff/Farhang2FaNum-ExtraBold.woff') format('woff');
    font-display: swap;
    }
    @font-face {
    font-family: farhang2fn;
    font-style: normal;
    font-weight: bold;
    src: url('../../fonts/fanum/woff/Farhang2FaNum-Bold.woff') format('woff');
    font-display: swap;
    }
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_light_fontface()): ?>
    @font-face {
    font-family: farhang2fn;
    font-style: normal;
    font-weight: 100;
    src: url('../../fonts/fanum/woff/Farhang2FaNum-Thin.woff') format('woff');
    font-display: swap;
    }
    @font-face {
    font-family: farhang2fn;
    font-style: normal;
    font-weight: 300;
    src: url('../../fonts/fanum/woff/Farhang2FaNum-Light.woff') format('woff');
    font-display: swap;
    }
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_medium_fontface()): ?>
    @font-face {
    font-family: farhang2fn;
    font-style: normal;
    font-weight: normal;
    src: url('../../fonts/fanum/woff/Farhang2FaNum-Regular.woff') format('woff');
    font-display: swap;
    }
    @font-face {
    font-family: farhang2fn;
    font-style: normal;
    font-weight: 500;
    src: url('../../fonts/fanum/woff/Farhang2FaNum-Medium.woff') format('woff');
    font-display: swap;
    }
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_black_fontface()): ?>
    @font-face {
    font-family: farhang2fn;
    font-style: normal;
    font-weight: 900;
    src: url('../../fonts/fanum/woff/Farhang2FaNum-Black.woff') format('woff');
    font-display: swap;
    }
<?php endif; ?>