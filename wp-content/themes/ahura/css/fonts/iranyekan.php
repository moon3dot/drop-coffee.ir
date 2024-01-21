/*Load IRANYekan Fonts*/
<?php if(!\ahura\app\mw_options::get_mod_is_active_bold_fontface()): ?>
@font-face {
	font-family: iranyekan;
	font-style: normal;
	font-weight: bold;
	src: url('../../fonts/woff/iranyekanwebbold.woff') format('woff');
	font-display: swap;
}
@font-face {
	font-family: iranyekan;
	font-style: normal;
	font-weight: 800;
	src: url('../../fonts/woff/iranyekanwebextrabold.woff') format('woff');
    font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_light_fontface()): ?>
@font-face {
	font-family: iranyekan;
	font-style: normal;
	font-weight: 100;
	src: url('../../fonts/woff/iranyekanwebthin.woff') format('woff');
	font-display: swap;
}

@font-face {
	font-family: iranyekan;
	font-style: normal;
	font-weight: 300;
	src: url('../../fonts/woff/iranyekanweblight.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_medium_fontface()): ?>
@font-face {
	font-family: iranyekan;
	font-style: normal;
	font-weight: normal;
	src: url('../../fonts/woff/iranyekanwebregular.woff') format('woff');
	font-display: swap;
}

@font-face {
	font-family: iranyekan;
	font-style: normal;
	font-weight: 500;
	src: url('../../fonts/woff/iranyekanwebmedium.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_black_fontface()): ?>
@font-face {
	font-family: iranyekan;
	font-style: normal;
	font-weight: 900;
	src: url('../../fonts/woff/iranyekanwebblack.woff') format('woff');
	font-display: swap;
}

@font-face {
	font-family: iranyekan;
	font-style: normal;
	font-weight: 950;
	src: url('../../fonts/woff/iranyekanwebextrablack.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
/*End Load IRANYekan Fonts*/