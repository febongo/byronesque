<?php

if ( ! function_exists( 'corsen_core_add_textual_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function corsen_core_add_textual_spinner_layout_option( $layouts ) {
		$layouts['textual'] = esc_html__( 'Textual', 'corsen-core' );

		return $layouts;
	}

	add_filter( 'corsen_core_filter_page_spinner_layout_options', 'corsen_core_add_textual_spinner_layout_option' );
}

