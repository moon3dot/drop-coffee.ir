/*Load IRANSansFaNum Font*/
<?php if(!\ahura\app\mw_options::get_mod_is_active_black_fontface()): ?>
@font-face {
	font-family: IRANSansFaNum;
	font-style: normal;
	font-weight: 900;
	src: url('../../fonts/fanum/woff/IRANSansWeb(FaNum)_Black.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_bold_fontface()): ?>
@font-face {
	font-family: IRANSansFaNum;
	font-style: normal;
	font-weight: bold;
	src: url('../../fonts/fanum/woff/IRANSansWeb(FaNum)_Bold.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_medium_fontface()): ?>
@font-face {
	font-family: IRANSansFaNum;
	font-style: normal;
	font-weight: 500;
	src: url('../../fonts/fanum/woff/IRANSansWeb(FaNum)_Medium.woff') format('woff');
	font-display: swap;
}
@font-face {
	font-family: IRANSansFaNum;
	font-style: normal;
	font-weight: normal;
	src: url('../../fonts/fanum/woff/IRANSansWeb(FaNum).woff') format('woff');
    font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_light_fontface()): ?>
@font-face {
	font-family: IRANSansFaNum;
	font-style: normal;
	font-weight: 300;
	src: url('../../fonts/fanum/woff/IRANSansWeb(FaNum)_Light.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_ultralight_fontface()): ?>
@font-face {
	font-family: IRANSansFaNum;
	font-style: normal;
	font-weight: 200;
	src: url('../../fonts/fanum/woff/IRANSansWeb(FaNum)_UltraLight.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>