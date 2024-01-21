/*Load IRANSansDN Fonts*/
<?php if(!\ahura\app\mw_options::get_mod_is_active_bold_fontface()): ?>
@font-face {
	font-family: iransansdn;
	font-style: normal;
	font-weight: bold;
	src: url('../../fonts/woff/iransansdnbold.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_light_fontface()): ?>
@font-face {
	font-family: iransansdn;
	font-style: normal;
	font-weight: 300;
	src: url('../../fonts/woff/iransansdnlight.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_medium_fontface()): ?>
@font-face {
	font-family: iransansdn;
	font-style: normal;
	font-weight: normal;
	src: url('../../fonts/woff/iransansdn.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
/*End Load IRANSansDN Fonts*/