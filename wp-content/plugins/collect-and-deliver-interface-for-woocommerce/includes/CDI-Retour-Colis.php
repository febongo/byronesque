<?php

/**
 * This file is part of the CDI - Collect and Deliver Interface plugin.
 * (c) Halyra
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/****************************************************************************************/
/* parcel returns                                                                       */
/****************************************************************************************/

class cdi_c_Retour_Colis {
	public static function init() {
		add_action( 'woocommerce_view_order', __CLASS__ . '::cdi_display_retourcolis' );
		add_action( 'init', __CLASS__ . '::cdi_print_returnlabel_pdf' );
	}

	public static function cdi_print_returnlabel_pdf() {
		if ( isset( $_POST['cdi_print_returnlabel_pdf'] ) && isset( $_POST['cdi_print_returnlabel_pdf_nonce'] ) && wp_verify_nonce( $_POST['cdi_print_returnlabel_pdf_nonce'], 'cdi_print_returnlabel_pdf' ) ) {
			global $woocommerce;
			$id_order = sanitize_text_field( $_POST['idreturnlabel'] );
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $id_order, 'msg' );
			$base64return = get_post_meta( $id_order, '_cdi_meta_base64_return', true );
			if ( $base64return ) {
				$cdi_loclabel_pdf = base64_decode( $base64return );
				$out = fopen( 'php://output', 'w' );
				$thepdffile = 'Return-' . $id_order . '-' . date( 'YmdHis' ) . '.pdf';
				header( 'Content-Type: application/pdf' );
				header( 'Content-Disposition: attachment; filename=' . $thepdffile );
				fwrite( $out, $cdi_loclabel_pdf );
				fclose( $out );
				die();
			}
		} // End $_POST['cdi_print_returnlabel_pdf'
	} // End function cdi_print_returnlabel_pdf


	public static function cdi_display_retourcolis( $id_order ) {
		global $woocommerce;
		// If posted, get and store the return label
		if ( isset( $_POST['cdi_getparcelreturn'] ) ) {
			$productcode = sanitize_text_field( $_POST['productcode'] );
			$carrier = get_post_meta( $id_order, '_cdi_meta_carrier', true );
			$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
			$route = 'cdi_c_Carrier_' . $carrier . '::cdi_prodlabel_parcelreturn';
			( $route )( $id_order, $productcode );
			cdi_c_Function::cdi_stat( 'RET-aff' );
		}

		// Normal processing of order view
		$statusparcelreturn = 'no';
		$carrier = get_post_meta( $id_order, '_cdi_meta_carrier', true );
		$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
		$route = 'cdi_c_Carrier_' . $carrier . '::cdi_isitopen_parcelreturn';
		$statusparcelreturn = ( $route )();
		if ( $statusparcelreturn == 'yes' ) {
			$order = new WC_Order( $id_order );
			// $statusorder = $order->post->post_status ;  // Deprecated WC3
			$statusorder = cdi_c_wc3::cdi_order_status( $order );
			if ( get_post_meta( $id_order, '_cdi_meta_status', true ) == 'intruck' ) {
				$retoureligible = apply_filters( 'cdi_filterstring_retourcolis_eligible', 'yes', $order );
			} else {
				$retoureligible = 'no';
			}
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $id_order . ' - ' . $statusorder . ' - ' . $retoureligible, 'msg' );
			if ( $retoureligible == 'yes' ) {
				$route = 'cdi_c_Carrier_' . $carrier . '::cdi_isitvalidorder_parcelreturn';
				$trackingheaders_parcelreturn = ( $route )( $id_order );
				if ( $trackingheaders_parcelreturn ) {
					$cdi_meta_exist_uploads_label = get_post_meta( $id_order, '_cdi_meta_exist_uploads_label', true );
					if ( $cdi_meta_exist_uploads_label == true ) {
						// Here we can process the parcel return function
						// $completeddate = $order->post->post_date ; // Deprecated WC3
						$completeddate = cdi_c_wc3::cdi_order_date_created( $order );
						$nbdaytoreturn = get_post_meta( $id_order, '_cdi_meta_nbdayparcelreturn', true );
						$daynoreturn = ( $nbdaytoreturn * 60 * 60 * 24 ) + strtotime( $completeddate );
						$today = strtotime( 'now' );
						if ( $today < $daynoreturn ) {
							$base64return = get_post_meta( $id_order, '_cdi_meta_base64_return', true );
							if ( $base64return ) {
								// Display the existing parcel return label
								$route = 'cdi_c_Carrier_' . $carrier . '::cdi_text_inviteprint_parcelreturn';
								$txt = ( $route )();
								$val = __( 'Print your parcel return label', 'cdi' );
								$route = 'cdi_c_Carrier_' . $carrier . '::cdi_url_carrier_following_parcelreturn';
								$url = ( $route )();
								echo '<div id="divcdiprintparcelreturn"><form method="post" id="cdi_print_returnlabel_pdf" action="">' . '<input type="hidden" name="idreturnlabel" value="' . esc_attr( $id_order ) . '" />' . ' <input type="submit" name="cdi_print_returnlabel_pdf" value="' . esc_attr( $val ) . '"  title="Print your parcel return label" /> <p> ' . esc_attr( $txt ) . '</p>';
								echo '<a href="' . esc_url( $url ) . '" onclick="window.open(this.href); return false;" > ' . esc_url( $url ) . ' </a>';
								wp_nonce_field( 'cdi_print_returnlabel_pdf', 'cdi_print_returnlabel_pdf_nonce' );
								echo '</form></div>';
							} else {
								// Create the parcel return label and display it
								$array_for_carrier = cdi_c_Function::cdi_array_for_carrier( $id_order );
								$shippingcountry = $array_for_carrier['shipping_country'];
								// Test if Product code exist in tables
								$route = 'cdi_c_Carrier_' . $carrier . '::cdi_whichproducttouse_parcelreturn';
								$productcode = ( $route )( $shippingcountry );
								if ( $productcode && $productcode !== '' ) {
									$route = 'cdi_c_Carrier_' . $carrier . '::cdi_text_preceding_parcelreturn';
									;
									$txt = ( $route )();
									$val = __( 'Request for a parcel return label', 'cdi' );
									echo '<div id="divcdigetparcelreturn"><form method="post" id="cdi_getparcelreturn" action="">' . esc_attr( $txt ) . ' <input type="submit" name="cdi_getparcelreturn" value="' . esc_attr( $val ) . '"  title="Request for a parcel return label"/>' . '<input type="hidden" name="productcode" value="' . esc_attr( $productcode ) . '"/>';
									// wp_nonce_field( 'cdi_getparcelreturn_run', 'cdi_getparcelreturn_run_nonce');
									echo '</form></div>   ';
								}
							}
						}
					}
				}
			}
		}
	}

	public static function cdi_check_returnlabel_eligible( $id_order ) {
		global $woocommerce;
		$return = false;
		$statusparcelreturn = 'no';
		$carrier = get_post_meta( $id_order, '_cdi_meta_carrier', true );
		$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
		$route = 'cdi_c_Carrier_' . $carrier . '::cdi_isitopen_parcelreturn';
		$statusparcelreturn = ( $route )();
		if ( $statusparcelreturn == 'yes' ) {
			$order = new WC_Order( $id_order );
			$statusorder = cdi_c_wc3::cdi_order_status( $order );
			if ( get_post_meta( $id_order, '_cdi_meta_status', true ) == 'intruck' ) {
				$retoureligible = apply_filters( 'cdi_filterstring_retourcolis_eligible', 'yes', $order );
			} else {
				$retoureligible = 'no';
			}
			if ( $retoureligible == 'yes' ) {
				$route = 'cdi_c_Carrier_' . $carrier . '::cdi_isitvalidorder_parcelreturn';
				$trackingheaders_parcelreturn = ( $route )( $id_order );
				if ( $trackingheaders_parcelreturn ) {
					$cdi_meta_exist_uploads_label = get_post_meta( $id_order, '_cdi_meta_exist_uploads_label', true );
					if ( $cdi_meta_exist_uploads_label == true ) {
						$completeddate = cdi_c_wc3::cdi_order_date_created( $order );
						$nbdaytoreturn = get_post_meta( $id_order, '_cdi_meta_nbdayparcelreturn', true );
						$daynoreturn = ( $nbdaytoreturn * 60 * 60 * 24 ) + strtotime( $completeddate );
						$today = strtotime( 'now' );
						if ( $today < $daynoreturn ) {
							$base64return = get_post_meta( $id_order, '_cdi_meta_base64_return', true );
							if ( ! $base64return ) {
								$return = true;
							}
						}
					}
				}
			}
		}
		return $return;
	}

}




