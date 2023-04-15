<?php

if ( ! function_exists( 'corsen_get_sidebar_name' ) ) {
	/**
	 * Function that return sidebar name
	 *
	 * @return string
	 */
	function corsen_get_sidebar_name() {
		return apply_filters( 'corsen_filter_sidebar_name', 'qodef-main-sidebar' );
	}
}

if ( ! function_exists( 'corsen_get_sidebar_layout' ) ) {
	/**
	 * Function that return sidebar layout
	 *
	 * @return string
	 */
	function corsen_get_sidebar_layout() {
		$sidebar_layout = apply_filters( 'corsen_filter_sidebar_layout', 'no-sidebar' );

		if ( 'no-sidebar' !== $sidebar_layout && ! is_active_sidebar( corsen_get_sidebar_name() ) ) {
			$sidebar_layout = 'no-sidebar';
		}

		return $sidebar_layout;
	}
}

if ( ! function_exists( 'corsen_get_page_content_sidebar_classes' ) ) {
	/**
	 * Function that return classes for the page content when sidebar is enabled
	 *
	 * @return string
	 */
	function corsen_get_page_content_sidebar_classes() {
		$layout  = corsen_get_sidebar_layout();
		$classes = array( 'qodef-page-content-section' );

		switch ( $layout ) {
			case 'sidebar-33-right':
				$classes[] = 'qodef-col--8';
				$classes[] = 'qodef-col--content';
				break;
			case 'sidebar-25-right':
				$classes[] = 'qodef-col--9';
				$classes[] = 'qodef-col--content';
				break;
			case 'sidebar-33-left':
				$classes[] = 'qodef-col--8';
				$classes[] = 'qodef-col--content';
				$classes[] = 'qodef-col--content-reverse';
				break;
			case 'sidebar-25-left':
				$classes[] = 'qodef-col--9';
				$classes[] = 'qodef-col--content';
				$classes[] = 'qodef-col--content-reverse';
				break;
			default:
				$classes[] = 'qodef-col--12';
				$classes[] = 'qodef-col--content';
				break;
		}

		return implode( ' ', apply_filters( 'corsen_filter_page_content_sidebar_classes', $classes, $layout ) );
	}
}

if ( ! function_exists( 'corsen_get_page_sidebar_classes' ) ) {
	/**
	 * Function that return classes for the page sidebar when sidebar is enabled
	 *
	 * @return string
	 */
	function corsen_get_page_sidebar_classes() {
		$layout  = corsen_get_sidebar_layout();
		$classes = array( 'qodef-page-sidebar-section' );

		switch ( $layout ) {
			case 'sidebar-33-right':
				$classes[] = 'qodef-col--4';
				$classes[] = 'qodef-col--sidebar';
				break;
			case 'sidebar-25-right':
				$classes[] = 'qodef-col--3';
				$classes[] = 'qodef-col--sidebar';
				break;
			case 'sidebar-33-left':
				$classes[] = 'qodef-col--4';
				$classes[] = 'qodef-col--sidebar';
				$classes[] = 'qodef-col--sidebar-reverse';
				break;
			case 'sidebar-25-left':
				$classes[] = 'qodef-col--3';
				$classes[] = 'qodef-col--sidebar';
				$classes[] = 'qodef-col--sidebar-reverse';
				break;
		}

		return implode( ' ', apply_filters( 'corsen_filter_page_sidebar_classes', $classes, $layout ) );
	}
}
