<?php

if ( ! function_exists( 'corsen_core_include_portfolio_single_post_navigation_template' ) ) {
	/**
	 * Function which includes additional module on single portfolio page
	 */
	function corsen_core_include_portfolio_single_post_navigation_template() {
		corsen_core_template_part( 'post-types/portfolio', 'templates/single/single-navigation/templates/single-navigation' );
	}

	add_action( 'corsen_core_action_after_portfolio_single_item', 'corsen_core_include_portfolio_single_post_navigation_template' );
}
