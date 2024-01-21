/**
*
*	Name:			Anjoman Fonts
*	Version:			2.0
*	Author:			Moslem Ebrahimi (moslemebrahimi.com)
*	Created on:		April 4, 2020
*	Updated on:		April 4, 2020
*	Website:			http://fontiran.com
*	Copyright:		Commercial/Proprietary Software
--------------------------------------------------------------------------------------
فونت انجمن یک نرم افزار مالکیتی محسوب می شود. جهت آگاهی از قوانین استفاده از این فونت ها لطفا به وب سایت (فونت ایران دات کام) مراجعه نمایید
--------------------------------------------------------------------------------------
Anjoman fonts are considered a proprietary software. To gain information about the laws regarding the use of these fonts, please visit www.fontiran.com
--------------------------------------------------------------------------------------
This set of fonts are used in this project under the license: (XM7RMY)
------------------------------------------------------------------------------------- fonts/-
*
**/
<?php if(!\ahura\app\mw_options::get_mod_is_active_light_fontface()): ?>
    @font-face {
    font-family: anjomanfn;
    font-style: normal;
    font-weight: 300;
    src: url('../../fonts/fanum/woff/Anjoman-FaNum-Light.woff') format('woff');
    font-display: swap;
    }
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_medium_fontface()): ?>
    @font-face {
    font-family: anjomanfn;
    font-style: normal;
    font-weight: normal;
    src: url('../../fonts/fanum/woff/Anjoman-FaNum-Regular.woff') format('woff');
    font-display: swap;
    }
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_bold_fontface()): ?>
    @font-face {
    font-family: anjomanfn;
    font-style: normal;
    font-weight: bold;
    src: url('../../fonts/fanum/woff/Anjoman-FaNum-Bold.woff') format('woff');
    font-display: swap;
    }
<?php endif; ?>
