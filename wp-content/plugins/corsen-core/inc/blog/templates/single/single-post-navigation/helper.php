<?php

if ( ! function_exists( 'corsen_core_include_blog_single_post_navigation_template' ) ) {
	/**
	 * Function which includes additional module on single posts page
	 */
	function corsen_core_include_blog_single_post_navigation_template() {
		if ( is_single() ) {
			include_once CORSEN_CORE_INC_PATH . '/blog/templates/single/single-post-navigation/templates/single-post-navigation.php';
		}
	}

	add_action( 'corsen_action_after_blog_post_item', 'corsen_core_include_blog_single_post_navigation_template', 20 ); // permission 20 is set to define template position
}
