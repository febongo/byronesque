<?php
/**
 * This file contain the shipping multi-tab configuration
 *
 * @package YITH\Shippo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$shipping_tab = array(
	'shipping' => array(
		'shipping-options' => array(
			'type'     => 'multi_tab',
			'sub-tabs' => array(
				'shipping-sender-info' => array(
					'title' => __( 'Sender Info', 'yith-shippo-shippings-for-woocommerce' ),
				),
				'shipping-rates'       => array(
					'title' => __( 'Shipping Rates', 'yith-shippo-shippings-for-woocommerce' ),
				),
				'shipping-rules'       => array(
					'title' => __( 'Shipping Rules', 'yith-shippo-shippings-for-woocommerce' ),
				),
				'shipping-tracking'    => array(
					'title' => __( 'Shipping Tracking', 'yith-shippo-shippings-for-woocommerce' ),
				),
			),
		),
	),
);

return $shipping_tab;
