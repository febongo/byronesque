<?php

if ( ! function_exists( 'corsen_core_include_blog_single_related_posts_template' ) ) {
	/**
	 * Function which includes additional module on single posts page
	 */
	function corsen_core_include_blog_single_related_posts_template() {
		if ( is_single() ) {
			include_once CORSEN_CORE_INC_PATH . '/blog/templates/single/related-posts/templates/related-posts.php';
		}
	}

	add_action( 'corsen_action_after_blog_post_item', 'corsen_core_include_blog_single_related_posts_template', 150 );  // permission 25 is set to define template position
}
