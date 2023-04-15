<?php
// Include logo.
corsen_core_get_header_logo_image();

// Include widget area one.
corsen_core_get_header_widget_area();

// Include menu opener.

$opener_icon_text = corsen_core_get_option_value( 'admin', 'qodef_fullscreen_icon_label' );
$show_icon_text = 'yes' === $opener_icon_text;
corsen_core_get_opener_icon_html(
	array(
		'option_name'  => 'fullscreen_menu',
		'custom_class' => 'qodef-fullscreen-menu-opener',
        'custom_html'   => $show_icon_text ? '<span class="qodef-fullscreen-menu-opener-text">' . esc_html__( 'Menu', 'corsen-core' ) . '</span>' : '',
	),
	true
);
