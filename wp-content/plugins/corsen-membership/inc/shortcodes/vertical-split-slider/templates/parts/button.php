<?php
$button_text = isset( $button_text ) && ! empty( $button_text ) ? $button_text : esc_html__( 'Read more', 'corsen' );

$button_params = array(
	'link'          => $button_link,
	'target'        => $button_target,
	'button_layout' => 'textual',
	'text'          => $button_text,
);

echo CorsenCore_Button_Shortcode::call_shortcode( $button_params );
