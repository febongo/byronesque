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
/* UPS Retour Colis                                                               */
/****************************************************************************************/

class cdi_c_Ups_Retourcolis {
	public static function init() {
	}

	public static function cdi_ups_calc_parcelretour( $order_id, $productcode ) {
		global $woocommerce;

		$errorws = null;
		$array_for_carrier = cdi_c_Function::cdi_array_for_carrier( $order_id );

		include_once( 'ups-access-context.php' );

		// ****** Custom for some datas
		$codeproduct = '11'; // Always return with UPS Standart
		$shipping_country = $array_for_carrier['shipping_country'];
		$cdireference = $array_for_carrier['sender_parcel_ref'] . '(' . $array_for_carrier['ordernumber'] . ')';
		$detailshipment = get_option( 'cdi_o_settings_global_shipment_description' );

		$shipperphone = $array_for_carrier['billing_phone'];
		$shippercellular = cdi_c_Function::cdi_sanitize_mobilenumber( $array_for_carrier['billing_phone'], $array_for_carrier['shipping_country'] );
		if ( $shippercellular ) {
			$shipperphone = $shippercellular;
		}
		$shipperphone = apply_filters( 'cdi_filterstring_auto_mobilenumber', $shipperphone, $order_id );

		// Only one phone in UPS for fix and cellular. For merchant and for customer. So the cellular is the option
		$shippermerchant = get_option( 'cdi_o_settings_merchant_fixphone' );
		if ( get_option( 'cdi_o_settings_merchant_cellularphone' ) != '' ) {
			$shippermerchant = get_option( 'cdi_o_settings_merchant_cellularphone' );
		}

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

		// Return
		$returnService = $shipment->addChild( 'ReturnService' );
		$returnService->addChild( 'Code', '9' );

		$shipment->addChild( 'Description', $detailshipment );

		// Shipper
		$shipper = $shipment->addChild( 'Shipper' );
		$shipper->addChild( 'Name', get_option( 'cdi_o_settings_merchant_CompanyName' ) );
		$shipper->addChild( 'AttentionName', get_option( 'cdi_o_settings_merchant_CompanyName' ) );
		$shipper->addChild( 'ShipperNumber', $upscomptenumber );
		// $shipper->addChild ( "TaxIdentificationNumber", $TaxIdentificationNumber );
		$shipper->addChild( 'PhoneNumber', $shippermerchant );
		$shipper->addChild( 'EMailAddress', get_option( 'cdi_o_settings_merchant_Email' ) );
		  $shipperAddress = $shipper->addChild( 'Address' );
		  $shipperAddress->addChild( 'AddressLine1', get_option( 'cdi_o_settings_merchant_Line1' ) );
		  $shipperAddress->addChild( 'AddressLine2', get_option( 'cdi_o_settings_merchant_Line2' ) );
		  $shipperAddress->addChild( 'AddressLine3', get_option( 'cdi_o_settings_ups_returnparcelservice' ) );
		  $shipperAddress->addChild( 'City', get_option( 'cdi_o_settings_merchant_City' ) );
		  $shipperAddress->addChild( 'StateProvinceCode', '' );
		  $shipperAddress->addChild( 'PostalCode', get_option( 'cdi_o_settings_merchant_ZipCode' ) );
		  $shipperAddress->addChild( 'CountryCode', get_option( 'cdi_o_settings_merchant_CountryCode' ) );

		// Shipto
		$shipTo = $shipment->addChild( 'ShipTo' );
		$shipTo->addChild( 'CompanyName', get_option( 'cdi_o_settings_merchant_CompanyName' ) );
		$shipTo->addChild( 'AttentionName', get_option( 'cdi_o_settings_merchant_CompanyName' ) );
		$shipTo->addChild( 'PhoneNumber', $shippermerchant );
		$shipTo->addChild( 'EMailAddress', get_option( 'cdi_o_settings_merchant_Email' ) );
		  $shipToAddress = $shipTo->addChild( 'Address' );
		  $shipToAddress->addChild( 'AddressLine1', get_option( 'cdi_o_settings_merchant_Line1' ) );
		  $shipToAddress->addChild( 'AddressLine2', get_option( 'cdi_o_settings_merchant_Line2' ) );
		  $shipToAddress->addChild( 'AddressLine3', get_option( 'cdi_o_settings_ups_returnparcelservice' ) );
		  $shipToAddress->addChild( 'City', get_option( 'cdi_o_settings_merchant_City' ) );
		  $shipToAddress->addChild( 'StateProvinceCode', '' );
		  $shipToAddress->addChild( 'PostalCode', get_option( 'cdi_o_settings_merchant_ZipCode' ) );
		  $shipToAddress->addChild( 'CountryCode', get_option( 'cdi_o_settings_merchant_CountryCode' ) );

		// Shipfrom
		$shipFrom = $shipment->addChild( 'ShipFrom' );
		$shipFrom->addChild( 'CompanyName', $array_for_carrier['shipping_first_name'] . ' ' . $array_for_carrier['shipping_last_name'] );
		$shipFrom->addChild( 'AttentionName', $array_for_carrier['shipping_first_name'] . ' ' . $array_for_carrier['shipping_last_name'] );
		$shipFrom->addChild( 'PhoneNumber', $shipperphone );
		  $shipFromAddress = $shipFrom->addChild( 'Address' );
		  $shipFromAddress->addChild( 'AddressLine1', $array_for_carrier['shipping_address_1'] );
		  $shipFromAddress->addChild( 'AddressLine2', $array_for_carrier['shipping_address_2'] );
		  $shipFromAddress->addChild( 'AddressLine3', $array_for_carrier['shipping_address_3'] . ' ' . $array_for_carrier['shipping_address_4'] );
		  $shipFromAddress->addChild( 'City', $array_for_carrier['shipping_city'] );
		  $shipFromAddress->addChild( 'StateProvinceCode', $array_for_carrier['shipping_state'] );
		  $shipFromAddress->addChild( 'PostalCode', $array_for_carrier['shipping_postcode'] );
		  $shipFromAddress->addChild( 'CountryCode', $array_for_carrier['shipping_country'] );

		// Payment
		$paymentInformation = $shipment->addChild( 'PaymentInformation' );
		  $prepaid = $paymentInformation->addChild( 'Prepaid' );
			$billShipper = $prepaid->addChild( 'BillShipper' );
			$billShipper->addChild( 'AccountNumber', $upscomptenumber );

		// Reference
		$referenceNumber = $shipment->addChild( 'ReferenceNumber' );
		$referenceNumber->addChild( 'Code', 'CD' );
		$referenceNumber->addChild( 'Value', 'R - ' . get_option( 'cdi_installation_id' ) . ' - ' . $cdireference );

		// Service
		$service = $shipment->addChild( 'Service' );
		$service->addChild( 'Code', $codeproduct );
		$service->addChild( 'Description', '' );

		// Package
		$package = $shipment->addChild( 'Package' );
		$package->addChild( 'Description', 'Return to marchand : ' );
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
		  $labelPrintMethod->addChild( 'Code', 'GIF' );
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
			$errorws = __( ' ===> Error stop processing at Return for order #', 'cdi' ) . $array_for_carrier['order_id'] . ' - ' . $returnerrcode . ' : ' . $returnerrlibelle . ' ' . $returnerrlibellecomplement;
			echo wp_kses_post( $errorws );
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $errorws, 'tec' );
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $arrayresponse, 'tec' );
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $requestXML, 'tec' );
			// cdi_c_Function::cdi_debug(__LINE__ ,__FILE__ , json_decode(json_encode((array)simplexml_load_string($shipmentConfirmRequestXML->asXML())),true), 'tec');
			return;
		}

		$shipmentIdentificationNumber = $arrayresponse['ShipmentIdentificationNumber'];
		$shipmentDigest = $arrayresponse['ShipmentDigest'];
		$shipmentCharges = $arrayresponse['ShipmentCharges']['TotalCharges']['MonetaryValue'];
		$shipmentChargesCurrency = $arrayresponse['ShipmentCharges']['TotalCharges']['CurrencyCode'];

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
			$errorws = __( ' ===> Error stop processing at Return for order #', 'cdi' ) . $array_for_carrier['order_id'] . ' - ' . $returnerrcode . ' : ' . $returnerrlibelle . ' ' . $returnerrlibellecomplement;
			echo wp_kses_post( $errorws );
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $errorws, 'tec' );
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $arrayresponse, 'tec' );
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $requestXML, 'tec' );
			// cdi_c_Function::cdi_debug(__LINE__ ,__FILE__ , json_decode(json_encode((array)simplexml_load_string($shipmentAcceptRequestXML->asXML())),true), 'tec');
			return;
		}

		$GraphicImage = $arrayresponse['ShipmentResults']['PackageResults']['LabelImage']['GraphicImage'];
		$HTMLImage = $arrayresponse['ShipmentResults']['PackageResults']['LabelImage']['HTMLImage'];
		$retparcelnumber = $shipmentIdentificationNumber;
		$parcelNumberPartner = '';

		// process the data
		$retparcelnumber = $shipmentIdentificationNumber;
		delete_post_meta( $order_id, '_cdi_meta_parcelnumber_return' );
		add_post_meta( $order_id, '_cdi_meta_parcelnumber_return', $retparcelnumber, true );
		$retpdfurl = '';
		delete_post_meta( $order_id, '_cdi_meta_pdfurl_return' );
		add_post_meta( $order_id, '_cdi_meta_pdfurl_return', $retpdfurl, true );
		delete_post_meta( $order_id, '_cdi_meta_return_executed' );
		add_post_meta( $order_id, '_cdi_meta_return_executed', 'yes', true );
		$base64labelreturn = cdi_c_Pdf_Workshop::cdi_convert_giftopdf( $GraphicImage, 'L', array( '150', '100' ), '90', $order_id ); // Only in 10x15 format
		cdi_c_Function::cdi_debug( __LINE__, __FILE__, 'Order : ' . $order_id . ' Parcel : ' . $retparcelnumber, 'msg' );
		if ( $base64labelreturn ) {
			delete_post_meta( $order_id, '_cdi_meta_base64_return' );
			add_post_meta( $order_id, '_cdi_meta_base64_return', $base64labelreturn, true );
		}
		if ( get_option( 'cdi_o_settings_ups_modetestprod' ) == 'yes' ) {
			cdi_c_Function::cdi_stat( 'UPS-ret' );
		} else {
			cdi_c_Function::cdi_stat( 'UPS-ret-test' );
		}
	}
}




