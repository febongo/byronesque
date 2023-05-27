<?php

namespace Sendcloud\Shipping\Checkout\Shipping\ServicePoint;

use Sendcloud\Shipping\Checkout\Shipping\Base_Checkout_Handler;
use Sendcloud\Shipping\Repositories\Checkout_Payload_Meta_Repository;
use Sendcloud\Shipping\Utility\Logging_Callable;
use Sendcloud\Shipping\Utility\View;
use WC_Product_Simple;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Checkout_Handler extends Base_Checkout_Handler {

	/**
	 * Hooks all checkout functions
	 */
	public function init() {
		add_action( 'woocommerce_checkout_after_order_review',
			new Logging_Callable( array( $this, 'initialize_service_point_widget' ) ) );
		add_action( 'wp_enqueue_scripts', new Logging_Callable( array( $this, 'register_scripts' ) ) );
		add_filter( 'clean_url', new Logging_Callable( array( $this, 'bypass_widget_src_cleanup' ) ), 10, 2 );
		add_filter( 'script_loader_tag', array( $this, 'defer_widget_scrip_tag' ), 10, 2 );
		add_action( 'woocommerce_after_shipping_rate', new Logging_Callable( array(
			$this,
			'render_service_point_widget'
		) ), 10,
			2 );
		add_action( 'woocommerce_checkout_update_order_meta', new Logging_Callable( array(
			$this,
			'save_service_point_data'
		) ) );
		add_action( 'woocommerce_checkout_process', new Logging_Callable( array(
			$this,
			'validate_service_point_selection'
		) ) );

		// compatibility with WooFunnel plugin
		add_action( 'wfacp_checkout_after_order_review', new Logging_Callable( array(
			$this,
			'initialize_service_point_widget'
		) ) );
	}

	/**
	 * Initializes nominated day shipping method widget
	 *
	 * @param WC_Shipping_Rate $method
	 */
	public function render_service_point_widget( $method, $index ) {
		if ( Service_Point_Shipping_Method::ID !== $method->method_id ) {
			return;
		}

		$this->render_widget( $method, $index );
	}

	/**
	 * Initializes nominated day widget for usage in checkout page
	 */
	public function initialize_service_point_widget() {
		wp_enqueue_script( static::WIDGET_JS_HANDLE );
		wp_enqueue_script( static::WIDGET_JS_CONTROLLER_HANDLE );
		echo wp_kses( View::file( '/widgets/service-point-delivery/checkout/widget-shipping-data.php' )->render( array(
			'shipping_data' => $this->create_shipment_data(),
		) ), View::get_allowed_tags() );
	}

	/**
	 * Save service point data
	 *
	 * @param $order_id
	 *
	 * @return void
	 */
	public function save_service_point_data( $order_id ) {
		$service_point_data = $this->extract_widget_submit_data( Service_Point_Shipping_Method::ID );
		if ( ! empty( $service_point_data ) ) {
			$checkout_payload_meta_repo = new Checkout_Payload_Meta_Repository();
			$checkout_payload_meta_repo->save_raw( $order_id, $service_point_data );
		}
	}

	/**
	 * Validates submitted service point data (if any) before order is created
	 */
	public function validate_service_point_selection() {
		$selected_shipping_method = $this->extract_shipping_method_id();
		if ( Service_Point_Shipping_Method::ID !== $selected_shipping_method ) {
			return;
		}

		$service_point_data = $this->extract_widget_submit_data( Service_Point_Shipping_Method::ID );
		if ( empty( $service_point_data['delivery_method_data'] ) ) {
			wc_add_notice( __( 'Please choose a service point.', 'sendcloud-shipping' ), 'error' );
		}
	}

	/**
	 * Create shipment data needed for service point rendering widget
	 *
	 * @return array
	 */
	private function create_shipment_data() {
		$customer   = WC()->cart->get_customer();
		$dimensions = [];
		foreach ( WC()->cart->get_cart() as $item ) {
			/**
			 * WooCommerce simple product
			 *
			 * @var WC_Product_Simple $product
			 */
			$product = $item['data'];
			if ( $product->get_length() && $product->get_width() && $product->get_height() ) {
				$dimensions[] = [
					(float) $product->get_length(),
					(float) $product->get_width(),
					(float) $product->get_height()
				];
			}
		}

		return [
			'service_point_id'              => '',
			'post_number'                   => '',
			'postal_code'                   => $customer->get_shipping_postcode(),
			'city'                          => $customer->get_shipping_city(),
			'cart_price'                    => WC()->cart->get_displayed_subtotal(),
			'cart_price_currency'           => get_option( 'woocommerce_currency' ),
			'cart_weight'                   => WC()->cart->get_cart_contents_weight(),
			'cart_weight_unit'              => get_option( 'woocommerce_weight_unit' ),
			'cart_item_dimensions'          => $dimensions,
			'cart_item_dimensions_unit'     => 'cm',
			'store_order_id'                => '',
			'checkout_shipping_method_id'   => '',
			'checkout_shipping_method_name' => ''
		];
	}
}
