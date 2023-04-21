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



// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Add to Bag', 'woocommerce' ); 
}

// Pagination
add_filter( 'woocommerce_pagination_args' , 'tq73et_override_pagination_args' );
function tq73et_override_pagination_args( $args ) {
	$args['prev_text'] = __( 'Previous' );
	$args['next_text'] = __( 'Next' );
	return $args;
}