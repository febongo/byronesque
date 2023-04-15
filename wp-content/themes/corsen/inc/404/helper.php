<?php

if ( ! function_exists( 'corsen_set_404_page_inner_classes' ) ) {
	/**
	 * Function that return classes for the page inner div from header.php
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	function corsen_set_404_page_inner_classes( $classes ) {

		if ( is_404() ) {
			$classes = 'qodef-content-full-width';
		}

		return $classes;
	}

	add_filter( 'corsen_filter_page_inner_classes', 'corsen_set_404_page_inner_classes' );
}

if ( ! function_exists( 'corsen_get_404_page_parameters' ) ) {
	/**
	 * Function that set 404 page area content parameters
	 */
	function corsen_get_404_page_parameters() {

		$params = array(
			'title'       => esc_html__( 'Error Page', 'corsen' ),
			'text'        => esc_html__( 'The page you are looking for doesn\'t exist. It may have been moved or removed altogether. Please try searching for some other page, or return to the website\'s homepage to find what you\'re looking for.', 'corsen' ),
			'button_text' => esc_html__( 'Back to home', 'corsen' ),
		);

		return apply_filters( 'corsen_filter_404_page_template_params', $params );
	}
}
