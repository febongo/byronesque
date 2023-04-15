<?php

if ( ! function_exists( 'corsen_core_add_woo_product_single_variation_gallery' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_woo_product_single_variation_gallery( $variations ) {
		$variations['gallery'] = esc_html__( 'Gallery', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_woo_single_product_layouts', 'corsen_core_add_woo_product_single_variation_gallery' );
}

if ( ! function_exists( 'corsen_core_load_single_woo_templates_gallery' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @return array
	 */
	function corsen_core_load_single_woo_templates_gallery() {
        add_filter( 'corsen_filter_enable_page_title', 'corsen_core_woo_single_product_gallery_disable_page_title' );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		add_action( 'woocommerce_before_single_product_summary', 'corsen_core_woo_single_product_gallery_add_images', 20 );
		add_action( 'corsen_core_action_woo_single_product_gallery_images', 'woocommerce_show_product_thumbnails' );
		add_filter( 'woocommerce_gallery_image_size', 'corsen_core_woo_single_product_gallery_thumb_size' );
		add_filter( 'corsen_filter_page_inner_classes', 'corsen_core_woo_single_product_gallery_full_width_set_full_width_class' );
	}

	add_action( 'corsen_core_action_load_template_hooks_gallery', 'corsen_core_load_single_woo_templates_gallery' );
}

if ( ! function_exists( 'corsen_core_woo_single_product_gallery_add_images' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @return $html
	 */
	function corsen_core_woo_single_product_gallery_add_images() {

		$atts = array(
			'columns' => 2,
		);

		corsen_core_template_part( 'plugins/woocommerce/single', 'templates/images-holder', '', $atts );

	}
}

if ( ! function_exists( 'corsen_core_woo_single_product_gallery_full_width_set_full_width_class' ) ) {

	function corsen_core_woo_single_product_gallery_full_width_set_full_width_class( $classes ) {

		$classes = 'qodef-content-full-width';

		return $classes;
	}
}

if ( ! function_exists( 'corsen_core_woo_single_product_gallery_thumb_size' ) ) {

	function corsen_core_woo_single_product_gallery_thumb_size( $thumb_size ) {

		$thumb_size = 'full';

		return $thumb_size;
	}
}

if ( ! function_exists( 'corsen_core_woo_single_product_gallery_disable_page_title' ) ) {

    function corsen_core_woo_single_product_gallery_disable_page_title( $enable_page_title ) {
        $enable_page_title = false;

        return $enable_page_title;
    }
}
