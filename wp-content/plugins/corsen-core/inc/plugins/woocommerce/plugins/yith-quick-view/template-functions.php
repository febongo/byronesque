<?php

if ( ! function_exists( 'corsen_core_yith_quick_view_single_title' ) ) {
	/**
	 * Function that override product single item title template
	 */
	function corsen_core_yith_quick_view_single_title() {
		$option    = corsen_get_post_value_through_levels( 'qodef_woo_yith_quick_view_title_tag' );
		$title_tag = ! empty( $option ) ? esc_attr( $option ) : 'h1';

		echo '<' . esc_attr( $title_tag ) . ' class="qodef-woo-product-title product_title entry-title">' . wp_kses_post( get_the_title() ) . '</' . esc_attr( $title_tag ) . '>';
	}
}

if ( ! function_exists( 'corsen_core_add_yith_quick_view_plugin_link_to_single' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function corsen_core_add_yith_quick_view_plugin_link_to_single() {

		if ( class_exists( 'CorsenCore_Button_Shortcode' ) ) {
			$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), corsen_core_woo_get_global_product() );

			$button_params = array(
				'link'          => $link,
				'text'          => esc_html__( 'View More', 'corsen-core' ),
				'size'          => 'normal',
				'button_layout' => 'textual',
				'custom_class'  => 'qodef-yith-wcqv-link',
			);

			echo CorsenCore_Button_Shortcode::call_shortcode( $button_params );
		}
	}
}

if ( ! function_exists( 'corsen_core_add_yith_quick_view_plugin_button_icon' ) ) {
	/**
	 * Function that add additional class name into global class list for body tag
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function corsen_core_add_yith_quick_view_plugin_button_icon( $classes ) {

		$option = corsen_core_get_post_value_through_levels( 'qodef_enable_woo_yith_quick_view_predefined_style' );

		if ( 'yes' === $option ) {
			$classes[] = 'qodef-yith-wcqv--predefined';
		}

		return $classes;
	}

	add_filter( 'body_class', 'corsen_core_add_yith_quick_view_plugin_button_icon' );
}
