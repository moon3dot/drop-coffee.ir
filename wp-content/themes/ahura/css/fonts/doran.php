/**
*
*	Name:			Doran Fonts
*	Version:			1.0
*	Author:			Fereshte Iranshahi and Reza Bakhtiarifard
*	Created on:		Aug 2022
*	Updated on:		Aug 2022
*	Vendor:			http://fontiran.com
*	Copyright:		Commercial/Proprietary Software
--------------------------------------------------------------------------------------
فونت دوران یک نرم افزار مالکیتی محسوب می شود. جهت آگاهی از قوانین استفاده از این فونت ها لطفا به وب سایت (فونت ایران دات کام) مراجعه نمایید
--------------------------------------------------------------------------------------
Doran fonts are considered a proprietary software. To gain information about the laws regarding the use of these fonts, please visit www.fontiran.com
--------------------------------------------------------------------------------------
This set of fonts are used in this project under the license: (TFG4ZXR0)
------------------------------------------------------------------------------------- fonts/-
*
**/

<?php if(!\ahura\app\mw_options::get_mod_is_active_medium_fontface()): ?>
@font-face {
    font-family: doran;
    font-style: normal;
    font-weight: normal;
    src: url('../../fonts/woff/Doran-Regular.woff') format('woff');
    font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_bold_fontface()): ?>
@font-face {
    font-family: doran;
    font-style: normal;
    font-weight: 800;
    src: url('../../fonts/woff/Doran-ExtraBold.woff') format('woff');
    font-display: swap;
}
<?php endif; ?>