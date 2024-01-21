/*Load IRANYekanFN Fonts*/
<?php if(!\ahura\app\mw_options::get_mod_is_active_bold_fontface()): ?>
@font-face {
	font-family: iranyekanfn;
	font-style: normal;
	font-weight: bold;
	src: url('../../fonts/fanum/woff/iranyekanwebboldfanum.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_light_fontface()): ?>
@font-face {
	font-family: iranyekanfn;
	font-style: normal;
	font-weight: 100;
	src: url('../../fonts/fanum/woff/iranyekanwebthinfanum.woff') format('woff');
	font-display: swap;
}

@font-face {
	font-family: iranyekanfn;
	font-style: normal;
	font-weight: 300;
	src: url('../../fonts/fanum/woff/iranyekanweblightfanum.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_medium_fontface()): ?>
@font-face {
	font-family: iranyekanfn;
	font-style: normal;
	font-weight: normal;
	src: url('../../fonts/fanum/woff/iranyekanwebregularfanum.woff') format('woff');
	font-display: swap;
}

@font-face {
	font-family: iranyekanfn;
	font-style: normal;
	font-weight: 500;
	src: url('../../fonts/fanum/woff/iranyekanwebmediumfanum.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_black_fontface()): ?>
@font-face {
	font-family: iranyekanfn;
	font-style: normal;
	font-weight: 800;
	src: url('../../fonts/fanum/woff/iranyekanwebextraboldfanum.woff') format('woff');
	font-display: swap;
}

@font-face {
	font-family: iranyekanfn;
	font-style: normal;
	font-weight: 900;
	src: url('../../fonts/fanum/woff/iranyekanwebblackfanum.woff') format('woff');
	font-display: swap;
}

@font-face {
	font-family: iranyekanfn;
	font-style: normal;
	font-weight: 950;
	src: url('../../fonts/fanum/woff/iranyekanwebextrablackfanum.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
/*End Load IRANYekanFN Fonts*/