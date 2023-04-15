<?php

if ( ! function_exists( 'corsen_core_add_clock_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function corsen_core_add_clock_spinner_layout_option( $layouts ) {
		$layouts['clock'] = esc_html__( 'Clock', 'corsen-core' );

		return $layouts;
	}

	add_filter( 'corsen_core_filter_page_spinner_layout_options', 'corsen_core_add_clock_spinner_layout_option' );
}
