<?php

namespace Sendcloud\Shipping\Checkout\Shipping\Standard;

use Exception;
use Sendcloud\Shipping\Checkout\Shipping\Base_Checkout_Handler;
use Sendcloud\Shipping\Repositories\Checkout_Payload_Meta_Repository;
use Sendcloud\Shipping\Repositories\Delivery_Methods_Repository;
use Sendcloud\Shipping\Utility\Logger;
use Sendcloud\Shipping\Utility\Logging_Callable;

class Checkout_Handler extends Base_Checkout_Handler {

	/**
	 * Delivery_Methods_Repository $delivery_method_repository.
	 *
	 * @var Delivery_Methods_Repository
	 */
	private $delivery_method_repository;

	/**
	 * Checkout_Handler constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->delivery_method_repository = new Delivery_Methods_Repository( $wpdb );
	}

	/**
	 * Hooks all checkout functions
	 */
	public function init() {
		add_action( 'woocommerce_checkout_process',
			new Logging_Callable( array( $this, 'validate_standard_shipping_selection' ) ) );
		add_action( 'woocommerce_checkout_update_order_meta',
			new Logging_Callable( array( $this, 'save_standard_delivery_meta' ) ) );
	}

	/**
	 * Validates submitted standard day data (if any) before order is created
	 */
	public function validate_standard_shipping_selection() {
		$shipping_method_parts    = $this->extract_shipping_method();
		$selected_shipping_method = array_key_exists( 0, $shipping_method_parts ) ? (string) $shipping_method_parts[0] : '';
		$instance_id              = array_key_exists( 1, $shipping_method_parts ) ? (string) $shipping_method_parts[1] : '';

		if ( Standard_Shipping_Method::ID !== $selected_shipping_method ) {
			return;
		}
		$delivery_method = $this->delivery_method_repository->find_by_system_id( $instance_id );
		try {
			$is_available = null !== $delivery_method && $delivery_method->isAvailable( $this->create_order() );
		} catch ( Exception $exception ) {
			Logger::error( 'Error while checking method availability. ' . $exception->getMessage() );
			$is_available = false;
		}

		if ( ! $is_available ) {
			wc_add_notice( __( 'Shipping method not available.', 'sendcloud-shipping' ), 'error' );
		}
	}

	/**
	 * Save order meta
	 *
	 * @param $order_id
	 */
	public function save_standard_delivery_meta( $order_id ) {
		$shipping_method_parts = $this->extract_shipping_method();
		if ( ! array_key_exists( 0, $shipping_method_parts ) || Standard_Shipping_Method::ID !== $shipping_method_parts[0] ) {
			return;
		}
		$instance_id          = array_key_exists( 1, $shipping_method_parts ) ? (string) $shipping_method_parts[1] : '';
		$delivery_method_data = $this->delivery_method_repository->find_by_system_id( $instance_id );

		if ( null !== $delivery_method_data ) {
			$checkout_payload_meta_repo = new Checkout_Payload_Meta_Repository();
			$checkout_payload_meta_repo->save_raw( $order_id,
				json_decode( $delivery_method_data->getRawConfig(), true ) );
		}
	}
}
