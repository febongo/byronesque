<?php

if ( ! function_exists( 'corsen_core_add_woo_product_single_variation_full_width' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_woo_product_single_variation_full_width( $variations ) {
		$variations['full-width'] = esc_html__( 'Full Width', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_woo_single_product_layouts', 'corsen_core_add_woo_product_single_variation_full_width' );
}


if ( ! function_exists( 'corsen_core_load_single_woo_templates_full_width' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @return array
	 */
	function corsen_core_load_single_woo_templates_full_width() {
        add_filter( 'corsen_filter_enable_page_title', 'corsen_core_woo_single_product_full_width_disable_page_title' );
		add_filter( 'corsen_filter_page_inner_classes', 'corsen_core_woo_single_product_full_width_class' );
		remove_action( 'woocommerce_before_single_product_summary', 'corsen_add_product_single_content_holder', 2 );
		add_action( 'woocommerce_before_single_product_summary', 'corsen_core_add_product_single_full_width_content_holder', 2 );
	}

	add_action( 'corsen_core_action_load_template_hooks_full_width', 'corsen_core_load_single_woo_templates_full_width' );
}

if ( ! function_exists( 'corsen_core_woo_single_product_full_width_class' ) ) {

	function corsen_core_woo_single_product_full_width_class( $classes ) {

		$classes = 'qodef-content-full-width';

		return $classes;
	}
}

if ( ! function_exists( 'corsen_core_add_product_single_full_width_content_holder' ) ) {

	function corsen_core_add_product_single_full_width_content_holder() {
		$color = get_post_meta( get_the_ID(), 'qodef_product_bg_color', true );
		$style = '';

		if ( ! empty( $color ) ) {
			$style = 'style=background-color:' . esc_attr( $color );
		}

		echo '<div class="qodef-woo-single-inner"' . esc_html( $style ) . '>';
	}
}

if ( ! function_exists( 'corsen_core_woo_single_product_full_width_disable_page_title' ) ) {

    function corsen_core_woo_single_product_full_width_disable_page_title( $enable_page_title ) {
        $enable_page_title = false;

        return $enable_page_title;
    }
}


