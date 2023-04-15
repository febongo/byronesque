<?php

if ( ! function_exists( 'corsen_core_register_revealing_search_layout' ) ) {
	/**
	 * Function that add variation layout into global list
	 *
	 * @param array $search_layouts
	 *
	 * @return array
	 */
	function corsen_core_register_revealing_search_layout( $search_layouts ) {
		$search_layouts['revealing'] = 'CorsenCore_Revealing_Search';

		return $search_layouts;
	}

	add_filter( 'corsen_core_filter_register_search_layouts', 'corsen_core_register_revealing_search_layout' );
}
