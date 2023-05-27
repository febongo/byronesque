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
/* Gateway UPS                                                                          */
/****************************************************************************************/

class cdi_c_Ups_Affranchissement {
	public static function init() {
		add_action( 'admin_init', __CLASS__ . '::cdi_Ups_run_affranchissement' );
	}

	public static function cdi_Ups_run_affranchissement() {
		if ( isset( $_POST['cdi_gateway_ups'] ) && isset( $_POST['cdi_ups_run_affranchissement_nonce'] ) && wp_verify_nonce( $_POST['cdi_ups_run_affranchissement_nonce'], 'cdi_ups_run_affranchissement' ) ) {
			global $woocommerce;
			global $wpdb;
			global $order_id;
			if ( current_user_can( 'cdi_gateway' ) ) {
				update_option( 'cdi_o_Date_lastwsauto', date( 'ymdHis' ) );
				$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'cdi' );
				if ( count( $results ) ) {
					$cdi_nbrorderstodo = 0;
					$cdi_rowcurrentorder = 0;
					$cdi_nbrtrkcode = 0;
					$cdi_nbrwscorrect = 0;
					foreach ( $results as $row ) {
						$cdi_tracking = $row->cdi_tracking;
						$carrier = get_post_meta( $row->cdi_order_id, '_cdi_meta_carrier', true );
						if ( ! $cdi_tracking && ( $row->cdi_status == 'open' or null == $row->cdi_status ) && ( $carrier == 'ups' ) ) {
							$cdi_nbrorderstodo = $cdi_nbrorderstodo + 1;
						}
					}
					if ( $cdi_nbrorderstodo > 0 ) {
						foreach ( $results as $row ) {
							  $cdi_tracking = $row->cdi_tracking;
							  $carrier = get_post_meta( $row->cdi_order_id, '_cdi_meta_carrier', true );
							  $errorws = null;
							if ( ! $cdi_tracking && ( $row->cdi_status == 'open' or null == $row->cdi_status ) && ( $carrier == 'ups' ) ) {
								$cdi_rowcurrentorder = $cdi_rowcurrentorder + 1;
								$array_for_carrier = apply_filters( 'cdi_filterarray_auto_arrayforcarrier', cdi_c_Function::cdi_array_for_carrier( $row ) );
								if ( ! is_array( $array_for_carrier ) ) {
									$errorws = __( ' ===> Error stop processing at order #', 'cdi' ) . $row->cdi_order_id . ' :  ===> ' . $array_for_carrier;
									break;
								}
								$order_id = $array_for_carrier['order_id'];

								include_once( 'ups-access-context.php' );

								// ****** Custom for some datas
								$codeproduct = $array_for_carrier['product_code'];
								$shipping_country = $array_for_carrier['shipping_country'];
								if ( ! $codeproduct or $codeproduct == 'none' ) {
									if ( $array_for_carrier['pickup_Location_id'] ) { // It is a relay method
										$codeproduct = 'AP'; // AP - UPS Access Point
									} else {
										$codeproduct = get_option( 'cdi_o_settings_ups_deliver' );
									}
								}
								if ( $codeproduct == 'AP' ) {
									$codeproduct = '11';
								}
								// EORI Lenght
								$TaxIdentificationNumber = substr( get_option( 'cdi_o_settings_cn23_eori' ), 0, 14 ); // Solve : Ups is 15 digits, but Eori is FR+Siret+key 16 digits. So drop the key ?
								// Only one phone in UPS for fix and cellular. For merchant and for customer. So the cellular is the option
								$shipperphone = get_option( 'cdi_o_settings_merchant_fixphone' );
								if ( get_option( 'cdi_o_settings_merchant_cellularphone' ) != '' ) {
									$shipperphone = get_option( 'cdi_o_settings_merchant_cellularphone' );
								}
								$shiptophone = $array_for_carrier['billing_phone'];
								$shiptophonecellular = cdi_c_Function::cdi_sanitize_mobilenumber( $array_for_carrier['billing_phone'], $array_for_carrier['shipping_country'] );
								if ( $shiptophonecellular ) {
									$shiptophone = $shiptophonecellular;
								}
								$shiptophone = apply_filters( 'cdi_filterstring_auto_mobilenumber', $shiptophone, $order_id );
								// Probably a futur filter to apply
								$cdireference = $array_for_carrier['sender_parcel_ref'] . '(' . $array_for_carrier['ordernumber'] . ')';
								$detailshipment = get_option( 'cdi_o_settings_global_shipment_description' );

								// ****** Confirm Request
								$endpointurl = $urlconfirm;
								// Create AccessRequest XMl
								$accessRequestXML = new SimpleXMLElement( '<AccessRequest></AccessRequest>' );
								$accessRequestXML->addChild( 'AccessLicenseNumber', $upsaccessLicenseNumber );
								$accessRequestXML->addChild( 'UserId', $upsuserId );
								$accessRequestXML->addChild( 'Password', $upspassword );
								// Create ShipmentConfirmRequest XMl
								$shipmentConfirmRequestXML = new SimpleXMLElement( '<ShipmentConfirmRequest ></ShipmentConfirmRequest>' );
								$request = $shipmentConfirmRequestXML->addChild( 'Request' );
								$request->addChild( 'RequestAction', 'ShipConfirm' );
								$request->addChild( 'RequestOption', 'nonvalidate' );
								$transactionReference = $request->addChild( 'TransactionReference' );
								$transactionReference->addChild( 'CustomerContext', $cdireference );
								// Shipment
								$shipment = $shipmentConfirmRequestXML->addChild( 'Shipment' );
								$shipment->addChild( 'Description', $detailshipment );
								// Shipper
								$shipper = $shipment->addChild( 'Shipper' );
								$shipper->addChild( 'Name', get_option( 'cdi_o_settings_merchant_CompanyName' ) );
								$shipper->addChild( 'AttentionName', get_option( 'cdi_o_settings_merchant_CompanyName' ) );
								$shipper->addChild( 'ShipperNumber', $upscomptenumber );
								$shipper->addChild( 'TaxIdentificationNumber', $TaxIdentificationNumber );
								$shipper->addChild( 'PhoneNumber', $shipperphone );
								$shipper->addChild( 'EMailAddress', get_option( 'cdi_o_settings_merchant_Email' ) );
								$shipperAddress = $shipper->addChild( 'Address' );
								$shipperAddress->addChild( 'AddressLine1', get_option( 'cdi_o_settings_merchant_Line1' ) );
								$shipperAddress->addChild( 'AddressLine2', get_option( 'cdi_o_settings_merchant_Line2' ) );
								$shipperAddress->addChild( 'City', get_option( 'cdi_o_settings_merchant_City' ) );
								$shipperAddress->addChild( 'StateProvinceCode', '' );
								$shipperAddress->addChild( 'PostalCode', get_option( 'cdi_o_settings_merchant_ZipCode' ) );
								$shipperAddress->addChild( 'CountryCode', get_option( 'cdi_o_settings_merchant_CountryCode' ) );
								// Shipto
								$shipTo = $shipment->addChild( 'ShipTo' );
								$shipTo->addChild( 'CompanyName', $array_for_carrier['shipping_first_name'] . ' ' . $array_for_carrier['shipping_last_name'] );
								$shipTo->addChild( 'AttentionName', $array_for_carrier['shipping_first_name'] . ' ' . $array_for_carrier['shipping_last_name'] );
								$shipTo->addChild( 'PhoneNumber', $shiptophone );
								$shipTo->addChild( 'EMailAddress', $array_for_carrier['billing_email'] );
								$shipToAddress = $shipTo->addChild( 'Address' );
								$shipToAddress->addChild( 'AddressLine1', $array_for_carrier['shipping_address_1'] );
								$shipToAddress->addChild( 'AddressLine2', $array_for_carrier['shipping_address_2'] );
								$shipToAddress->addChild( 'AddressLine3', $array_for_carrier['shipping_address_3'] . ' ' . $array_for_carrier['shipping_address_4'] );
								$shipToAddress->addChild( 'City', $array_for_carrier['shipping_city'] );
								$shipToAddress->addChild( 'StateProvinceCode', $array_for_carrier['shipping_state'] );
								$shipToAddress->addChild( 'PostalCode', $array_for_carrier['shipping_postcode'] );
								$shipToAddress->addChild( 'CountryCode', $array_for_carrier['shipping_country'] );
								$locationid = get_post_meta( $order_id, '_cdi_meta_pickupLocationId', true );
								$shipToAddress->addChild( 'LocationID', $locationid );
								// Here the UPS Access Point
								if ( $locationid ) {
									$shipmentIndicationType = $shipment->addChild( 'ShipmentIndicationType' );
									$shipmentIndicationType->addChild( 'Code', '02' );
									$alternateDeliveryAddress = $shipment->addChild( 'AlternateDeliveryAddress' );
									$alternateDeliveryAddress->addChild( 'Name', htmlspecialchars( get_post_meta( $order_id, '_cdi_meta_pickupfulladdress', true )['nom'] ) );
									$alternateDeliveryAddress->addChild( 'AttentionName', htmlspecialchars( get_post_meta( $order_id, '_cdi_meta_pickupfulladdress', true )['nom'] ) );
									$alternateDeliveryAddress->addChild( 'UPSAccessPointID', $locationid );
									$alternateAddress = $alternateDeliveryAddress->addChild( 'Address' );
									$alternateAddress->addChild( 'AddressLine1', htmlspecialchars( get_post_meta( $order_id, '_cdi_meta_pickupfulladdress', true )['adresse1'] ) );
									$alternateAddress->addChild( 'AddressLine2', htmlspecialchars( get_post_meta( $order_id, '_cdi_meta_pickupfulladdress', true )['adresse2'] ) );
									$alternateAddress->addChild( 'AddressLine3', htmlspecialchars( get_post_meta( $order_id, '_cdi_meta_pickupfulladdress', true )['adresse3'] ) );
									$alternateAddress->addChild( 'City', htmlspecialchars( get_post_meta( $order_id, '_cdi_meta_pickupfulladdress', true )['localite'] ) );
									$alternateAddress->addChild( 'StateProvinceCode', htmlspecialchars( $array_for_carrier['shipping_state'] ) );
									$alternateAddress->addChild( 'PostalCode', get_post_meta( $order_id, '_cdi_meta_pickupfulladdress', true )['codePostal'] );
									$alternateAddress->addChild( 'CountryCode', get_post_meta( $order_id, '_cdi_meta_pickupfulladdress', true )['codePays'] );
									$shipmentServiceOptions = $shipment->addChild( 'ShipmentServiceOptions' );
									$notification = $shipmentServiceOptions->addChild( 'Notification' );
									$notification->addChild( 'NotificationCode', '012' );
									$eMailMessage = $notification->addChild( 'EMailMessage' );
									$eMailMessage->addChild( 'EMailAddress', $array_for_carrier['billing_email'] );
									$eMailMessage->addChild( 'Memo', __( 'Your package has arrived at your UPS Access Point. It is now at your disposal. Your order N °: ', 'cdi' ) . $cdireference );
									$locale = $notification->addChild( 'Locale' );
									$locale->addChild( 'Language', 'FRA' );
									$locale->addChild( 'Dialect', '97' );
									$notification = $shipmentServiceOptions->addChild( 'Notification' );
									$notification->addChild( 'NotificationCode', '013' );
									$eMailMessage = $notification->addChild( 'EMailMessage' );
									$eMailMessage->addChild( 'EMailAddress', get_option( 'cdi_o_settings_merchant_Email' ) );
									$eMailMessage->addChild( 'Memo', __( 'Your customer package has arrived at the UPS access point. It is now at his disposal. His order N °: ', 'cdi' ) . $cdireference );
									$locale = $notification->addChild( 'Locale' );
									$locale->addChild( 'Language', 'FRA' );
									$locale->addChild( 'Dialect', '97' );
								}
								// Shipfrom
								$shipFrom = $shipment->addChild( 'ShipFrom' );
								$shipFrom->addChild( 'CompanyName', get_option( 'cdi_o_settings_merchant_CompanyName' ) );
								$shipFrom->addChild( 'AttentionName', get_option( 'cdi_o_settings_merchant_CompanyName' ) );
								$shipFrom->addChild( 'TaxIdentificationNumber', $TaxIdentificationNumber );
								$shipFrom->addChild( 'PhoneNumber', $shipperphone );
								$shipFromAddress = $shipFrom->addChild( 'Address' );
								$shipFromAddress->addChild( 'AddressLine1', get_option( 'cdi_o_settings_merchant_Line1' ) );
								$shipFromAddress->addChild( 'AddressLine2', get_option( 'cdi_o_settings_merchant_Line2' ) );
								$shipFromAddress->addChild( 'City', get_option( 'cdi_o_settings_merchant_City' ) );
								$shipFromAddress->addChild( 'StateProvinceCode', '' );
								$shipFromAddress->addChild( 'PostalCode', get_option( 'cdi_o_settings_merchant_ZipCode' ) );
								$shipFromAddress->addChild( 'CountryCode', get_option( 'cdi_o_settings_merchant_CountryCode' ) );
								// Payment
								$paymentInformation = $shipment->addChild( 'PaymentInformation' );
								$prepaid = $paymentInformation->addChild( 'Prepaid' );
								$billShipper = $prepaid->addChild( 'BillShipper' );
								$billShipper->addChild( 'AccountNumber', $upscomptenumber );
								// Rate
								// $rateInformation = $shipment->addChild ( 'RateInformation' );
								// $rateInformation->addChild ( "NegotiatedRatesIndicator", "" );
								// Reference
								$referenceNumber = $shipment->addChild( 'ReferenceNumber' );
								$referenceNumber->addChild( 'Code', 'CD' );
								$referenceNumber->addChild( 'Value', 'A - ' . get_option( 'cdi_installation_id' ) . ' - ' . $cdireference );
								// Service
								$service = $shipment->addChild( 'Service' );
								$service->addChild( 'Code', $codeproduct );
								$service->addChild( 'Description', '' );
								// Package
								$package = $shipment->addChild( 'Package' );
								$package->addChild( 'Description', '' );
								$packagingType = $package->addChild( 'PackagingType' );
								$packagingType->addChild( 'Code', '02' );
								$packagingType->addChild( 'Description', 'Customer Supplied Package' );
								$packageWeight = $package->addChild( 'PackageWeight' );
								$unitOfMeasurement = $packageWeight->addChild( 'UnitOfMeasurement' );
								$unitOfMeasurement->addChild( 'code', 'KGS' );
								$packageWeight->addChild( 'Weight', (float)($array_for_carrier['parcel_weight']) / 1000 );
								// Label
								$labelSpecification = $shipmentConfirmRequestXML->addChild( 'LabelSpecification' );
								$labelSpecification->addChild( 'HTTPUserAgent', '' );
								$labelPrintMethod = $labelSpecification->addChild( 'LabelPrintMethod' );
								$labelPrintMethod->addChild( 'Code', 'GIF' ); // L'AVOIR EN PDF SERAIT MIEUX
								$labelPrintMethod->addChild( 'Description', '' );
								$labelImageFormat = $labelSpecification->addChild( 'LabelImageFormat' );
								$labelImageFormat->addChild( 'Code', 'GIF' );
								$labelImageFormat->addChild( 'Description', '' );

								$requestXML = $accessRequestXML->asXML() . $shipmentConfirmRequestXML->asXML();
								$response = cdi_c_Function::cdi_url_post_remote( $endpointurl, $requestXML );
								$arrayresponse = json_decode( json_encode( (array) simplexml_load_string( $response ) ), true );

								$returnerrcode = $arrayresponse['Response']['ResponseStatusCode'];
								$returnerrlibelle = $arrayresponse['Response']['ResponseStatusDescription'];
								$returnerrlibellecomplement = null;
								if ( $returnerrcode != 1 ) {
									if ( isset( $arrayresponse['Response']['Error'] ) ) {
										$returnerrlibellecomplement = implode( ' ', $arrayresponse['Response']['Error'] );
									}
									$errorws = __( ' ===> Error stop processing at order #', 'cdi' ) . $array_for_carrier['order_id'] . ' - ' . $returnerrcode . ' : ' . $returnerrlibelle . ' ' . $returnerrlibellecomplement;
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, $errorws, 'tec' );
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, $arrayresponse, 'tec' );
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, $requestXML, 'tec' );
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, json_decode( json_encode( (array) simplexml_load_string( $shipmentConfirmRequestXML->asXML() ) ), true ), 'tec' );
									break;
								}
								if ( isset( $arrayresponse['Response']['Error'] ) ) {
									$returnerrlibellecomplement = implode( ' ', $arrayresponse['Response']['Error'] );
									$warningws = __( ' ===> Warning processing at order #', 'cdi' ) . $array_for_carrier['order_id'] . ' : ' . $returnerrlibellecomplement;
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, $warningws, 'msg' );
								}

								$shipmentIdentificationNumber = $arrayresponse['ShipmentIdentificationNumber'];
								$shipmentDigest = $arrayresponse['ShipmentDigest'];
								$shipmentCharges = $arrayresponse['ShipmentCharges']['TotalCharges']['MonetaryValue'];
								$shipmentChargesCurrency = $arrayresponse['ShipmentCharges']['TotalCharges']['CurrencyCode'];

								// ****** Check quote / price
								$limitquote = get_post_meta( $order_id, '_cdi_meta_limitquote', true );
								update_post_meta( $order_id, '_cdi_meta_realquote', $shipmentCharges );
								if ( $limitquote < $shipmentCharges ) {
									$errorws = __( ' ===> Error stop processing at order #', 'cdi' ) . $array_for_carrier['order_id'] . ' - ' . 'Exceeding the fixed quotation limit' . ' - Limite ' . $limitquote . ' Cout annoncé par UPS ' . $shipmentCharges;
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, $errorws, 'msg' );
									break;
								}

								// ****** Accept Request
								$endpointurl = $urlaccept;
								// Create AccessRequest XMl
								$accessRequestXML = new SimpleXMLElement( '<AccessRequest></AccessRequest>' );
								$accessRequestXML->addChild( 'AccessLicenseNumber', $upsaccessLicenseNumber );
								$accessRequestXML->addChild( 'UserId', $upsuserId );
								$accessRequestXML->addChild( 'Password', $upspassword );
								// Create ShipmentAcceptRequest XMl
								$shipmentAcceptRequestXML = new SimpleXMLElement( '<ShipmentAcceptRequest ></ShipmentAcceptRequest >' );
								$request = $shipmentAcceptRequestXML->addChild( 'Request' );
								$request->addChild( 'RequestAction', 'ShipAccept' );
								$shipmentAcceptRequestXML->addChild( 'ShipmentDigest', $shipmentDigest );

								$requestXML = $accessRequestXML->asXML() . $shipmentAcceptRequestXML->asXML();
								$response = cdi_c_Function::cdi_url_post_remote( $endpointurl, $requestXML );
								$arrayresponse = json_decode( json_encode( (array) simplexml_load_string( $response ) ), true );
								$returnerrcode = $arrayresponse['Response']['ResponseStatusCode'];
								$returnerrlibelle = $arrayresponse['Response']['ResponseStatusDescription'];
								$returnerrlibellecomplement = null;
								if ( $returnerrcode != 1 ) {
									if ( isset( $arrayresponse['Response']['Error'] ) ) {
										$returnerrlibellecomplement = implode( ' ', $arrayresponse['Response']['Error'] );
									}
									$errorws = __( ' ===> Error stop processing at order #', 'cdi' ) . $array_for_carrier['order_id'] . ' - ' . $returnerrcode . ' : ' . $returnerrlibelle . ' ' . $returnerrlibellecomplement;
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, $errorws, 'tec' );
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, $arrayresponse, 'tec' );
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, $requestXML, 'tec' );
									cdi_c_Function::cdi_debug( __LINE__, __FILE__, json_decode( json_encode( (array) simplexml_load_string( $shipmentAcceptRequestXML->asXML() ) ), true ), 'tec' );
									break;
								}
								$GraphicImage = $arrayresponse['ShipmentResults']['PackageResults']['LabelImage']['GraphicImage'];
								$HTMLImage = $arrayresponse['ShipmentResults']['PackageResults']['LabelImage']['HTMLImage'];
								$retparcelnumber = $shipmentIdentificationNumber;
								$parcelNumberPartner = '';

								// Depending of ups format
								$upsformat = get_option( 'cdi_o_settings_ups_OutputPrintingType' );
								if ( $upsformat == 'PDF_10x15_300dpi' ) {
									$pdf64base = cdi_c_Pdf_Workshop::cdi_convert_giftopdf( $GraphicImage, 'L', array( '150', '100' ), '90', $order_id );
								}
								if ( $upsformat == 'PDF_A5_paysage' ) {
									$pdf64base = cdi_c_Pdf_Workshop::cdi_convert_giftopdf( $GraphicImage, 'L', array( '210', '148' ), '90', $order_id );
								}
								if ( $upsformat == 'PDF_A4_portrait' ) {
									$pdf64base = cdi_c_Pdf_Workshop::cdi_convert_giftopdf( $GraphicImage, 'L', array( '297', '210' ), '90', $order_id );
								}

								cdi_c_Function::cdi_debug( __LINE__, __FILE__, 'Order : ' . $order_id . ' Parcel : ' . $retparcelnumber, 'msg' );
								$cdi_nbrwscorrect = $cdi_nbrwscorrect + 1;
								if ( get_option( 'cdi_o_settings_ups_modetestprod' ) == 'yes' ) {
									cdi_c_Function::cdi_stat( 'UPS-aff' );
								} else {
									cdi_c_Function::cdi_stat( 'UPS-aff-test' );
								}
								$x = $wpdb->update(
									$wpdb->prefix . 'cdi',
									array(
										'cdi_tracking' => $retparcelnumber,
										'cdi_parcelNumberPartner' => $parcelNumberPartner,
										'cdi_hreflabel' => '',
									),
									array( 'cdi_order_id' => $order_id )
								);
								cdi_c_Function::cdi_uploads_put_contents( $order_id, 'label', $pdf64base );
								if ( cdi_c_Function::cdi_cn23_country( $array_for_carrier['shipping_country'], $array_for_carrier['shipping_postcode'] ) ) {
											$base64cn23 = cdi_c_Pdf_Workshop::cdi_build_cn23_pdf( $order_id, $retparcelnumber, $array_for_carrier );
											cdi_c_Function::cdi_uploads_put_contents( $order_id, 'cn23', $base64cn23 );
								}
								cdi_c_Gateway::cdi_synchro_gateway_to_order( $order_id );

								// ********************************* End UPS service *********************************
							} // End !$cdi_tracking
							if ( $errorws !== null ) {
								break;
							}
						} // End row
						// Close sequence
						$message = number_format_i18n( $cdi_nbrwscorrect ) . __( ' parcels processed with ups Web Service.', 'cdi' ) . ' ' . $errorws;
						update_option( 'cdi_o_notice_display', $message );
						$sendback = admin_url() . 'admin.php?page=passerelle-cdi';
						wp_redirect( $sendback );
						exit();
					} // End cdi_nbrorderstodo
				} //End $results
			} // End current_user_can
		} // End cdi_UPS_run_affranchissement
	} // cdi_gateway_UPS
} // End class




