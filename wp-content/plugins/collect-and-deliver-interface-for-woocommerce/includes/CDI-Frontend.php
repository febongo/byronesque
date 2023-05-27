<?PHP

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
/* Add CDI actions to the orders listing                                                */
/****************************************************************************************/
class cdi_c_Frontend {
	public static function init() {
		add_action( 'woocommerce_view_order', __CLASS__ . '::cdi_display_tracking_view' );
		if ( get_option( 'cdi_o_settings_trackingemaillocation' ) == 'before' ) {
			add_action( 'woocommerce_email_before_order_table', __CLASS__ . '::cdi_woocommerce_email_where_order_table', 101, 4 );
		} else {
			add_action( 'woocommerce_email_after_order_table', __CLASS__ . '::cdi_woocommerce_email_where_order_table', 101, 4 );
		}
		add_filter( 'woocommerce_checkout_fields', __CLASS__ . '::cdi_override_checkout_fields' );
		add_filter( 'woocommerce_default_address_fields', __CLASS__ . '::cdi_override_default_address_fields' );
		add_filter( 'woocommerce_my_account_my_address_formatted_address', __CLASS__ . '::cdi_woocommerce_my_account_my_address_formatted_address', 2, 3 );
		add_filter( 'woocommerce_cart_shipping_packages', __CLASS__ . '::cdi_woocommerce_cart_shipping_packages' );
		add_filter( 'woocommerce_formatted_address_replacements', __CLASS__ . '::cdi_woocommerce_formatted_address_replacements', 10, 2 );
		add_filter( 'woocommerce_localisation_address_formats', __CLASS__ . '::cdi_woocommerce_localisation_address_formats' );
		add_filter( 'woocommerce_order_formatted_billing_address', __CLASS__ . '::cdi_woocommerce_order_formatted_billing_address', 10, 2 );
		add_filter( 'woocommerce_order_formatted_shipping_address', __CLASS__ . '::cdi_woocommerce_order_formatted_shipping_address', 10, 2 );
		add_filter( 'woocommerce_admin_billing_fields', __CLASS__ . '::cdi_woocommerce_admin_billing_fields' );
		add_filter( 'woocommerce_admin_shipping_fields', __CLASS__ . '::cdi_woocommerce_admin_shipping_fields' );
		add_filter( 'woocommerce_get_order_address', __CLASS__ . '::cdi_woocommerce_get_order_address', 10, 3 );
		add_filter( 'woocommerce_privacy_export_order_personal_data', __CLASS__ . '::cdi_woocommerce_privacy_export_order_personal_data', 10, 2 );
		add_action( 'woocommerce_privacy_remove_order_personal_data', __CLASS__ . '::cdi_woocommerce_privacy_remove_order_personal_data' );
		add_action( 'woocommerce_countries', __CLASS__ . '::cdi_woocommerce_countries' );
		add_action( 'woocommerce_continents', __CLASS__ . '::cdi_woocommerce_continents' );
		add_action( 'woocommerce_checkout_fields', __CLASS__ . '::cdi_woocommerce_checkout_fields_S1' );
		add_filter( 'gettext', __CLASS__ . '::cdi_gettext', 10, 3 );
	}

	public static function cdi_gettext( $translation, $text, $domain ) {
		if ( $text == 'Shipping address' && $translation == 'Adresse de livraison' && $domain == 'woocommerce' && get_option( 'cdi_o_settings_pickupaddresslayout' ) ) {
			return 'Adresse du destinataire';
		}
		// if ($text == "Shipping" && $translation == "Expédition" && $domain == "woocommerce" && get_option('cdi_o_settings_pickupaddresslayout')) {
		// return 'Destination' ;
		// }
		return $translation;
	}

	// Insert tracking code in customer order views
	public static function cdi_display_tracking_view( $id_order ) {
		$statusinsert = get_option( 'cdi_o_settings_inserttrackingcode' );
		if ( $statusinsert == 'order-views' or $statusinsert == 'emails and order-views' ) {
			$order = new WC_Order( $id_order );
			$method_name = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_shippingmethod_name', true );
			$carrier = get_post_meta( $id_order, '_cdi_meta_carrier', true );
			$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
			$carrierlabel = cdi_c_Function::cdi_get_libelle_carrier( $carrier );
			$trackingcode = get_post_meta( $id_order, '_cdi_meta_tracking', true );
			$pickupLocationlabel = get_post_meta( $id_order, '_cdi_meta_pickupLocationlabel', true );
			$pickupfulladdress = get_post_meta( $id_order, '_cdi_meta_pickupfulladdress', true );
			cdi_c_Function::cdi_debug( __LINE__, __FILE__, $id_order . ' - ' . $trackingcode, 'msg' );
			;
			$html = '';
			if ( $method_name and $carrierlabel ) {
				$html .= '<div id="cdimetashippingmethodname"><p>' . __( 'shipping request: ', 'cdi' ) . esc_attr( $method_name ) . __( ' - Carrier used: ', 'cdi' ) . $carrierlabel . '</p></div>';
			}
			if ( ! empty( $trackingcode ) ) {
				$txt = __( 'Order shipped. Your tracking code is : ', 'cdi' );
				$url = 'http://www.colissimo.fr/portail_colissimo/suivre.do?colispart=';  // defaut
				$carrier = get_post_meta( $id_order, '_cdi_meta_carrier', true );
				$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
				$route = 'cdi_c_Carrier_' . $carrier . '::cdi_text_preceding_trackingcode';
				$txt = ( $route )();
				$route = 'cdi_c_Carrier_' . $carrier . '::cdi_url_trackingcode';
				$url = ( $route )();
				$url = str_replace( 'href="', '', $url ); // Because backward compatibility
				$html .= '<div id="cditrackingcodeorderview" style="margin-left:10px"><p> ' . esc_attr( $txt ) . ' ' . '<a ' . 'href="' . esc_url( $url ) . esc_attr( $trackingcode ) . '" onclick="window.open(this.href); return false;" > ' . esc_attr( $trackingcode ) . '</a> </p></div>';
			}
			if ( is_array( $pickupfulladdress ) && get_option( 'cdi_o_settings_pickupaddresslayout' ) ) {
				$html .= '<h2 id="cdipickupLocationlabel"> <strong>' . __( 'Pickup address', 'cdi' ) . '</strong></h2>';
				$html .= '<address style="margin-left:20px">';
				$html .= ( esc_attr( $pickupfulladdress['nom'] ) . '<br>' );
				$html .= ( esc_attr( $pickupfulladdress['adresse1'] ) . '<br>' );
				if ( $pickupfulladdress['adresse2'] ) {
					$html .= ( esc_attr( $pickupfulladdress['adresse2'] ) . '<br>' );
				}
				if ( $pickupfulladdress['adresse3'] ) {
					$html .= ( esc_attr( $pickupfulladdress['adresse3'] ) . '<br>' );
				}
				$html .= ( esc_attr( $pickupfulladdress['codePostal'] . ' ' . $pickupfulladdress['localite'] ) . '<br>' );
				$html .= ( esc_attr( $pickupfulladdress['libellePays'] . ' (' . $pickupfulladdress['codePays'] ) . ')<br>' );
				$html .= '<br></address>';
				if ( $pickupLocationlabel ) {
					$pickupLocationlabel = stristr( $pickupLocationlabel, '=> Distance: ', true );
					$html .= '<div id="cdipickupLocationlabel" style="margin-left:10px"><p> ' . __( 'Pickup location : ', 'cdi' ) . esc_attr( $pickupLocationlabel ) . '</p></div>';
				}
			}
			$array_for_carrier = cdi_c_Function::cdi_array_for_carrier( $id_order );
			$html = apply_filters( 'cdi_filterhtml_fronttracking_orderview', $html, $array_for_carrier );
			echo wp_kses_post( $html );
		}
	}
	// Insert tracking code in emails
	public static function cdi_woocommerce_email_where_order_table( $order, $sent_to_admin, $plain_text, $email ) {
		$statusinsert = get_option( 'cdi_o_settings_inserttrackingcode' );
		if ( $statusinsert == 'emails' or $statusinsert == 'emails and order-views' ) {
			$id_order = $order->get_id();
			$method_name = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_shippingmethod_name', true );
			$carrier = get_post_meta( $id_order, '_cdi_meta_carrier', true );
			$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
			$carrierlabel = cdi_c_Function::cdi_get_libelle_carrier( $carrier );
			$trackingcode = get_post_meta( $id_order, '_cdi_meta_tracking', true );
			$pickupLocationlabel = get_post_meta( $id_order, '_cdi_meta_pickupLocationlabel', true );
			$pickupfulladdress = get_post_meta( $id_order, '_cdi_meta_pickupfulladdress', true );
			$html = '';
			if ( $method_name and $carrierlabel ) {
				$html .= '<div id="cdimetashippingmethodname"><p>' . __( 'shipping request: ', 'cdi' ) . esc_attr( $method_name ) . __( ' - Carrier used: ', 'cdi' ) . $carrierlabel . '</p></div>';
			}
			if ( ! empty( $trackingcode ) ) {
				$txt = __( 'Order shipped. Your tracking code is : ', 'cdi' );
				$url = 'http://www.colissimo.fr/portail_colissimo/suivre.do?colispart=';  // defaut
				$carrier = get_post_meta( $id_order, '_cdi_meta_carrier', true );
				$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
				$route = 'cdi_c_Carrier_' . $carrier . '::cdi_text_preceding_trackingcode';
				$txt = ( $route )();
				$route = 'cdi_c_Carrier_' . $carrier . '::cdi_url_trackingcode';
				$url = ( $route )();
				$url = str_replace( 'href="', '', $url ); // Because backward compatibility
				$html .= '<div id="cditrackingcodeemail" style="margin-left:10px"><p> ' . esc_attr( $txt ) . ' ' . '<a ' . 'href="' . esc_url( $url ) . esc_attr( $trackingcode ) . '" onclick="window.open(this.href); return false;" > ' . esc_attr( $trackingcode ) . '</a> </p></div>';
			}
			if ( is_array( $pickupfulladdress ) && get_option( 'cdi_o_settings_pickupaddresslayout' ) ) {
				$html .= '<h2 id="cdipickupLocationlabel"> <strong>' . __( 'Pickup address', 'cdi' ) . '</strong></h2>';
				$html .= '<address style="margin-left:20px">';
				$html .= ( esc_attr( $pickupfulladdress['nom'] ) . '<br>' );
				$html .= ( esc_attr( $pickupfulladdress['adresse1'] ) . '<br>' );
				if ( $pickupfulladdress['adresse2'] ) {
					$html .= ( esc_attr( $pickupfulladdress['adresse2'] ) . '<br>' );
				}
				if ( $pickupfulladdress['adresse3'] ) {
					$html .= ( esc_attr( $pickupfulladdress['adresse3'] ) . '<br>' );
				}
				$html .= ( esc_attr( $pickupfulladdress['codePostal'] . ' ' . $pickupfulladdress['localite'] ) . '<br>' );
				$html .= ( esc_attr( $pickupfulladdress['libellePays'] . ' (' . $pickupfulladdress['codePays'] ) . ')<br>' );
				$html .= '<br></address>';
				if ( $pickupLocationlabel ) {
					$pickupLocationlabel = stristr( $pickupLocationlabel, '=> Distance: ', true );
					$html .= '<div id="cdipickupLocationlabel" style="margin-left:10px"><p> ' . __( 'Pickup location : ', 'cdi' ) . esc_attr( $pickupLocationlabel ) . '</p></div>';
				}
			}
			$array_for_carrier = cdi_c_Function::cdi_array_for_carrier( $id_order );
			$html = apply_filters( 'cdi_filterhtml_fronttracking_sendingmail', $html, $array_for_carrier );
			echo wp_kses_post( $html );
		}
	}
	// checkout control
	public static function cdi_override_checkout_fields( $fields ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$fields['order']['order_comments']['placeholder'] = __( 'Notes on your order, eg special notes for color, size, ...', 'cdi' );
		}
		return $fields;
	}
	public static function cdi_override_default_address_fields( $fields ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$fields['address_1']['placeholder'] = __( '(*) House number + Name of the way (street, avenue, ...)', 'cdi' );
			$fields['address_2']['placeholder'] = __( 'Entrance - Block - Building - Residence', 'cdi' );
			$fields['address_3']['placeholder'] = __( 'Apartment or letter box number - Floor - Corridor - Staircase', 'cdi' );
			$fields['address_3']['class'] = array( 'form-row-wide', 'address-field' );
			$fields['address_3']['required'] = null;
			$fields['address_3']['autocomplete'] = 'address-line3';
			$fields['address_3']['priority'] = 61;
			$fields['address_4']['placeholder'] = __( 'Postal box - Place called', 'cdi' );
			$fields['address_4']['class'] = array( 'form-row-wide', 'address-field' );
			$fields['address_4']['required'] = null;
			$fields['address_4']['autocomplete'] = 'address-line4';
			$fields['address_4']['priority'] = 62;
		}
		return $fields;
	}
	public static function cdi_woocommerce_my_account_my_address_formatted_address( $address, $customer_id, $name ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$address['address_3'] = get_user_meta( $customer_id, $name . '_address_3', true );
			$address['address_4'] = get_user_meta( $customer_id, $name . '_address_4', true );
		}
		return $address;
	}
	public static function cdi_woocommerce_cart_shipping_packages( $packages ) {
		$items = $packages;
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$id = get_current_user_id();
			$items = array();
			foreach ( $packages as $key => $item ) {
				$item['destination']['address_3'] = get_user_meta( $id, 'shipping_address_3', true );
				$item['destination']['address_4'] = get_user_meta( $id, 'shipping_address_4', true );
				$items[ $key ] = $item;
			}
		}
		return $items;
	}
	public static function cdi_woocommerce_formatted_address_replacements( $items, $args ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			if ( isset( $args['address_3'] ) ) {
				$items['{address_3}'] = $args['address_3'];
				$items['{address_3_upper}'] = $args['address_3'];
			}
			if ( isset( $args['address_4'] ) ) {
				$items['{address_4}'] = $args['address_4'];
				$items['{address_4_upper}'] = $args['address_4'];
			}
		}
		return $items;
	}
	public static function cdi_woocommerce_localisation_address_formats( $formats ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$return = array();
			foreach ( $formats as $key => $format ) {
				$return[ $key ] = str_replace( '{address_2}', "{address_2}\n{address_3}\n{address_4}", $format );
			}
			return $return;
		}
		return $formats;
	}
	public static function cdi_woocommerce_order_formatted_billing_address( $address, $order ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$id = $order->get_id();
			$address['address_3'] = get_post_meta( $id, '_billing_address_3', true );
			$address['address_4'] = get_post_meta( $id, '_billing_address_4', true );
		}
		return $address;
	}
	public static function cdi_woocommerce_order_formatted_shipping_address( $address, $order ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$id = $order->get_id();
			$address['address_3'] = get_post_meta( $id, '_shipping_address_3', true );
			$address['address_4'] = get_post_meta( $id, '_shipping_address_4', true );
		}
		return $address;
	}
	public static function cdi_woocommerce_get_order_address( $items, $type, $third ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			if ( $type == 'shipping' ) {
				$return = array_merge(
					array(
						'first_name' => '',
						'last_name'  => '',
						'company'    => '',
						'address_1'  => '',
						'address_2'  => '',
						'address_3'  => '',
						'address_4'  => '',
						'city'       => '',
						'state'      => '',
						'postcode'   => '',
						'country'    => '',
					),
					$items
				);
			} else {
				$return = array_merge(
					array(
						'first_name' => '',
						'last_name'  => '',
						'company'    => '',
						'address_1'  => '',
						'address_2'  => '',
						'address_3'  => '',
						'address_4'  => '',
						'city'       => '',
						'state'      => '',
						'postcode'   => '',
						'country'    => '',
						'email'      => '',
						'phone'      => '',
					),
					$items
				);
			}
			return $return;
		}
		return $items;
	}
	public static function cdi_woocommerce_admin_billing_fields( $billing_fields ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$return = array();
			foreach ( $billing_fields as $key => $field ) {
				$return[ $key ] = $field;
				if ( $key == 'address_2' ) {
					$return['address_3'] = array(
						'label' => __( 'Address line 3', 'woocommerce' ),
						'show'  => false,
					);
					$return['address_4'] = array(
						'label' => __( 'Address line 4', 'woocommerce' ),
						'show'  => false,
					);
				}
			}
			return $return;
		}
		return $billing_fields;
	}
	public static function cdi_woocommerce_admin_shipping_fields( $shipping_fields ) {
		if ( 'yes' == get_option( 'cdi_o_settings_extentedaddress' ) ) {
			$return = array();
			foreach ( $shipping_fields as $key => $field ) {
				$return[ $key ] = $field;
				if ( $key == 'address_2' ) {
					$return['address_3'] = array(
						'label' => __( 'Address line 3', 'woocommerce' ),
						'show'  => false,
					);
					$return['address_4'] = array(
						'label' => __( 'Address line 4', 'woocommerce' ),
						'show'  => false,
					);
				}
			}
			return $return;
		}
		return $shipping_fields;
	}
	public static function cdi_woocommerce_privacy_export_order_personal_data( $personal_data, $order ) {
		$id = $order->get_id();
		$array = array();
		$array[] = array(
			'name' => 'Exp. Poids (g)',
			'value' => get_post_meta( $id, '_cdi_meta_parcelweight', true ),
		);
		$array[] = array(
			'name' => 'Exp. Assurance (€)',
			'value' => get_post_meta( $id, '_cdi_meta_amountcompensation', true ),
		);
		$array[] = array(
			'name' => 'Exp. Code suivi',
			'value' => get_post_meta( $id, '_cdi_meta_tracking', true ),
		);
		$array[] = array(
			'name' => 'Exp. Relais',
			'value' => get_post_meta( $id, '_cdi_meta_pickupLocationlabel', true ),
		);
		$array[] = array(
			'name' => 'Exp. Catégorie cn23',
			'value' => get_post_meta( $id, '_cdi_meta_cn23_category', true ),
		);
		$array[] = array(
			'name' => 'Exp. Transport cn23',
			'value' => get_post_meta( $id, '_cdi_meta_cn23_shipping', true ),
		);
		foreach ( $array as $item ) {
			if ( $item['value'] ) {
				$personal_data[] = $item;
			}
		}
		return $personal_data;
	}
	public static function cdi_woocommerce_privacy_remove_order_personal_data( $order ) {
		// For the moment it is better to do nothing and wait until things on the application of the regulation be stabilized. Indeed, the only deletion of personal WC data will already suffice to crash the system.
	}
	public static function cdi_woocommerce_countries( $countries ) {
		$return = $countries;
		if ( 'yes' == get_option( 'cdi_o_settings_extentS1contry' ) ) {
			$new_countries = array( 'S1'  => __( 'Les armées françaises', 'woocommerce' ) );
			$return = array_merge( $return, $new_countries );
		}
		return $return;
	}
	public static function cdi_woocommerce_continents( $continents ) {
		$return = $continents;
		if ( 'yes' == get_option( 'cdi_o_settings_extentS1contry' ) ) {
			$return['EU']['countries'][] = 'S1'; // Set in EU (in Europe, not in European Union). Alternatively, we could set it very far in Antartic (AN) ?!
		}
		return $return;
	}
	public static function cdi_woocommerce_checkout_fields_S1( $fields ) {
		global $woocommerce;
		$country = $woocommerce->customer->get_billing_country();
		if ( $country == 'S1' ) {
			$fields['billing']['billing_state']['required'] = false;
			$fields['shipping']['shipping_state']['required'] = false;
		}
		return $fields;
	}

}

