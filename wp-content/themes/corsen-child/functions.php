<?php

if ( ! function_exists( 'corsen_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function corsen_child_theme_enqueue_scripts() {
		$main_style = 'corsen-main';

		wp_enqueue_style( 'corsen-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ) );
	}

	add_action( 'wp_enqueue_scripts', 'corsen_child_theme_enqueue_scripts' );
}


