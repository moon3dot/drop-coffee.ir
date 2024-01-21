<?php if(!\ahura\app\mw_options::get_mod_is_active_light_fontface()): ?>
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: 100;
	src: url('../../fonts/woff/dana-thin.woff') format('woff');
	font-display: swap;
}
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: 300;
	src: url('../../fonts/woff/dana-light.woff') format('woff');
    font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_ultralight_fontface()): ?>
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: 200;
	src: url('../../fonts/woff/dana-extralight.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_medium_fontface()): ?>
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: normal;
	src: url('../../fonts/woff/dana-regular.woff') format('woff');
    font-display: swap;
}
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: 500;
	src: url('../../fonts/woff/dana-medium.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_bold_fontface()): ?>
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: 600;
	src: url('../../fonts/woff/dana-demibold.woff') format('woff');
	font-display: swap;
}

@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: 750;
	src: url('../../fonts/woff/dana-ultrabold.woff') format('woff');
	font-display: swap;
}
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: 800;
	src: url('../../fonts/woff/dana-extrabold.woff') format('woff');
	font-display: swap;
}
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: bold;
	src: url('../../fonts/woff/dana-bold.woff') format('woff');
	font-display: swap;
}
<?php endif; ?>
<?php if(!\ahura\app\mw_options::get_mod_is_active_black_fontface()): ?>
@font-face {
	font-family: dana;
	font-style: normal;
	font-weight: 900;
	src: url('../../fonts/woff/dana-black.woff') format('woff');
    font-display: swap;
}
<?php endif; ?>
