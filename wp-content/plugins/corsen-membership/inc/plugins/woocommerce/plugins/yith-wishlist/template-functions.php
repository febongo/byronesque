<?php

if ( ! function_exists( 'corsen_core_add_yith_wishlist_plugin_button_icon' ) ) {
	/**
	 * Function that add additional class name into global class list for body tag
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function corsen_core_add_yith_wishlist_plugin_button_icon( $classes ) {

		$option = corsen_core_get_post_value_through_levels( 'qodef_enable_woo_yith_wishlist_predefined_style' );

		if ( 'yes' === $option ) {
			$classes[] = 'qodef-yith-wcwl--predefined';
		}

		return $classes;
	}

	add_filter( 'body_class', 'corsen_core_add_yith_wishlist_plugin_button_icon' );
}
