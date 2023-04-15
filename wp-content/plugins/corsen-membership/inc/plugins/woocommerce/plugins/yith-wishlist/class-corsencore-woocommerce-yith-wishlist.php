<?php

if ( ! class_exists( 'CorsenCore_WooCommerce_YITH_Wishlist' ) ) {
	class CorsenCore_WooCommerce_YITH_Wishlist {
		private static $instance;

		public function __construct() {

			if ( qode_framework_is_installed( 'yith-wishlist' ) ) {
				// Init
				add_action( 'after_setup_theme', array( $this, 'init' ) );
			}
		}

		/**
		 * @return CorsenCore_WooCommerce_YITH_Wishlist
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function init() {

			// Change default templates position
			$this->change_templates_position();

			// Disable default resopnsive YITH Wishlist Page Table
			add_filter( 'yith_wcwl_is_wishlist_responsive', array( $this, 'is_responsive' ) );
		}

		function change_templates_position() {

			// Add button element for shop pages
			add_action( 'corsen_action_product_list_item_additional_image_content', 'corsen_core_get_yith_wishlist_shortcode' );
			add_action( 'corsen_core_action_product_list_item_additional_image_content', 'corsen_core_get_yith_wishlist_shortcode' );
            add_action( 'corsen_core_action_product_list_indent_slider_item_additional_image_content', 'corsen_core_get_yith_wishlist_shortcode' );
		}

		function is_responsive() {

			// Prevent from using wp_is_mobile and rendering responsive list instead of regular cart table
			return false;
		}
	}

	CorsenCore_WooCommerce_YITH_Wishlist::get_instance();
}
