<?php

if ( ! function_exists( 'corsen_core_add_portfolio_single_variation_masonry_small' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_portfolio_single_variation_masonry_small( $variations ) {
		$variations['masonry-small'] = esc_html__( 'Masonry - Small', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_portfolio_single_layout_options', 'corsen_core_add_portfolio_single_variation_masonry_small' );
}

if ( ! function_exists( 'corsen_core_include_masonry_for_portfolio_single_variation_masonry_small' ) ) {
	/**
	 * Function that include masonry scripts for current module layout
	 *
	 * @param string $post_type
	 *
	 * @return string
	 */
	function corsen_core_include_masonry_for_portfolio_single_variation_masonry_small( $post_type ) {
		$portfolio_template = corsen_core_get_post_value_through_levels( 'qodef_portfolio_single_layout' );

		if ( 'masonry-small' === $portfolio_template ) {
			$post_type = 'portfolio-item';
		}

		return $post_type;
	}

	add_filter( 'corsen_filter_allowed_post_type_to_enqueue_masonry_scripts', 'corsen_core_include_masonry_for_portfolio_single_variation_masonry_small' );
}
