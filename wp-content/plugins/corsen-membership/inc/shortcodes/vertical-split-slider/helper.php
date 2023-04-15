<?php
if ( ! function_exists( 'corsen_core_vertical_split_slider_generate_template_params' ) ) {
	/**
	 * function that generate new param keys as normally used in shortcode templates
	 * eg: for 'type-1' variation, instead of 'type_1_title' new key will be 'title'
	 *
	 * @param array $item - single repeater field item
	 *
	 * @return array
	 */
	function corsen_core_vertical_split_slider_generate_template_params( $item ) {
		// format variation name from dash to underscore
		$slide_content_layout = str_replace( '-', '_', $item['slide_content_layout'] );
		$modified_params      = array();

		foreach ( $item as $key => $value ) {
			// if key contains current item layout string
			if ( false !== str_contains( $key, $slide_content_layout ) ) {
				$modified_params[ str_replace( $slide_content_layout . '_', '', $key ) ] = $value;
			}
		}

		return $modified_params;
	}
}
