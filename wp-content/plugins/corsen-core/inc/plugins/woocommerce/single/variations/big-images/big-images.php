<?php

if ( ! function_exists( 'corsen_core_add_woo_product_single_variation_big_images' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function corsen_core_add_woo_product_single_variation_big_images( $variations ) {
		$variations['big_images'] = esc_html__( 'Big Images', 'corsen-core' );

		return $variations;
	}

	add_filter( 'corsen_core_filter_woo_single_product_layouts', 'corsen_core_add_woo_product_single_variation_big_images' );
}

if ( ! function_exists( 'corsen_core_load_single_woo_templates_images_large' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @return array
	 */
	function corsen_core_load_single_woo_templates_images_large() {
        add_filter( 'corsen_filter_enable_page_title', 'corsen_core_woo_single_product_images_large_disable_page_title' );
        add_filter( 'corsen_filter_page_inner_classes', 'corsen_core_woo_single_product_images_large_full_width_class' );
        add_action( 'woocommerce_after_single_product_summary', 'corsen_core_woo_single_product_images_large_related_wrapper_before', 5 );
        add_action( 'woocommerce_after_single_product_summary', 'corsen_core_woo_single_product_images_large_related_wrapper_after', 30 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        add_action( 'woocommerce_share', 'woocommerce_output_product_data_tabs', 20 );
		add_action( 'woocommerce_before_single_product_summary', 'corsen_core_woo_single_product_images_large_add_images', 20 );
		add_action( 'corsen_core_action_woo_single_product_gallery_images', 'woocommerce_show_product_thumbnails' );
		add_filter( 'woocommerce_gallery_image_size', 'corsen_core_woo_single_product_images_large_thumb_size' );
	}

	add_action( 'corsen_core_action_load_template_hooks_big_images', 'corsen_core_load_single_woo_templates_images_large' );
}

if ( ! function_exists( 'corsen_core_woo_single_product_images_large_add_images' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @return $html
	 */
	function corsen_core_woo_single_product_images_large_add_images() {

		corsen_core_template_part( 'plugins/woocommerce/single', 'templates/images-holder' );

	}
}

if ( ! function_exists( 'corsen_core_woo_single_product_images_large_thumb_size' ) ) {

	function corsen_core_woo_single_product_images_large_thumb_size( $thumb_size ) {

		$thumb_size = 'full';

		return $thumb_size;
	}
}

if ( ! function_exists( 'corsen_core_woo_single_product_images_large_full_width_class' ) ) {

    function corsen_core_woo_single_product_images_large_full_width_class( $classes ) {

        $classes = 'qodef-content-full-width';

        return $classes;
    }
}

if ( ! function_exists( 'corsen_core_woo_single_product_images_large_related_wrapper_before' ) ) {

    function corsen_core_woo_single_product_images_large_related_wrapper_before( $html ) {

        $html = '<div class="qodef-content-grid"><div class="qodef-grid"><div class="qodef-grid-inner">';

        echo $html;
    }
}

if ( ! function_exists( 'corsen_core_woo_single_product_images_large_related_wrapper_after' ) ) {

    function corsen_core_woo_single_product_images_large_related_wrapper_after( $html ) {

        $html = '</div></div></div>';

        echo $html;
    }
}

if ( ! function_exists( 'corsen_core_woo_single_product_images_large_disable_page_title' ) ) {

    function corsen_core_woo_single_product_images_large_disable_page_title( $enable_page_title ) {
        $enable_page_title = false;

        return $enable_page_title;
    }
}