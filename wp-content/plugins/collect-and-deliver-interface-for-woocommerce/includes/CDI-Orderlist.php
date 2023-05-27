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
/* Add CDI actions to the orders listing                                          */
/****************************************************************************************/
class cdi_c_Orderlist_Action {
	public static function init() {
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::cdi_admin_enqueue_scripts_edit' );
		add_filter( 'woocommerce_admin_order_buyer_name', __CLASS__ . '::cdi_woocommerce_admin_order_buyer_name', 10, 2 ); // This filter to be before the display of order status
		add_action( 'woocommerce_admin_order_actions_end', __CLASS__ . '::cdi_woocommerce_admin_order_actions_end' ); // This action at the end only to display of CDI icons
		add_action( 'wp_ajax_cdi_orderlist_button', __CLASS__ . '::cdi_orderlist_button_callback' );
		add_action( 'admin_notices', __CLASS__ . '::cdi_orderlist_admin_notices' );
		add_action( 'admin_init', __CLASS__ . '::cdi_printpdf_fromajax' );
	}
	
	public static function cdi_printpdf_fromajax() {
	// Special differed prints request from shop_order. Not possible in js client (security reasons) nor callback ajax serveur (not allowed)
		$cdi_printajax_todo = get_option( 'cdi_printajax_todo' ) ;
		if ($cdi_printajax_todo && is_array( $cdi_printajax_todo ) ) { 
			$type = $cdi_printajax_todo['type'] ;
			$orderid = $cdi_printajax_todo['orderid'] ;
			$cdi_locfile = cdi_c_Function::cdi_uploads_get_contents( $orderid, $type );
			if ( $cdi_locfile ) {
				$cdi_locfile_pdf = base64_decode( $cdi_locfile );
				$out = fopen( 'php://output', 'w' );
				$thepdffile = $type .  '-' . $orderid . '-' . date( 'YmdHis' ) . '.pdf';
				header( 'Content-Type: application/pdf' );
				header( 'Content-Disposition: attachment; filename=' . $thepdffile );
				fwrite( $out, $cdi_locfile_pdf );
				fclose( $out );
			}
			update_option( 'cdi_printajax_todo', null );
			die();
		}
	}

	public static function cdi_admin_enqueue_scripts_edit( $hook_suffix ) {
		if ( $hook_suffix == 'edit.php' or $hook_suffix == 'post.php' ) {
			wp_enqueue_script( 'cdi_handle_js_admin_edit', plugin_dir_url( __FILE__ ) . '../js/cdiadminedit.js', array( 'jquery' ), $ver = false, $in_footer = true );
			$varjs = 'var cdiadminedittransinsert = "' . __( 'Insert parcels in CDI Gateway', 'cdi' ) . '" ; ';
			wp_add_inline_script( 'cdi_handle_js_admin_edit', $varjs );
		}
	}

	public static function cdi_orderlist_admin_notices() {
		global $pagenow;
		if ( $pagenow == 'edit.php' ) {
			if ( isset( $returnmsg ) ) {
				?> <div style="padding: 5px;" class="notice notice-warning is-dismissible"><p> <?php echo wp_kses_post( $returnmsg ); ?>  </p></div> 
																						  <?php
			}
		}
	}

	public static function cdi_woocommerce_admin_order_buyer_name( $buyer, $order ) {
		self::cdi_init_metabox( $order );
		$eligible = self::cdi_check_synchro_eligible( $order );
		if ( $eligible == 'yes' ) {
			self::cdi_synchro_metabox_gateway( $order );
		}
		return $buyer;
	}

	public static function cdi_woocommerce_admin_order_actions_end( $order ) {
		$eligible = self::cdi_check_synchro_eligible( $order );
		if ( $eligible == 'yes' ) {
			?>
		<a id="cdi-<?php echo esc_attr( cdi_c_wc3::cdi_order_id( $order ) ); ?>"
			<?php $cdi_status = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', true ); ?>
			<?php
			if ( $cdi_status == 'waiting' ) {
				?>
				 class="button tips preview-cdi waiting" alt="<?php _e( 'Waiting', 'cdi' ); ?>" data-tip="<?php _e( 'Waiting - Can be filed in the CDI gateway.', 'cdi' ); ?>"<?php } ?>
			<?php
			if ( $cdi_status == 'deposited' ) {
				?>
				 class="button tips preview-cdi deposited" alt="<?php _e( 'Deposited', 'cdi' ); ?>" data-tip="<?php _e( 'Filed in CDI gateway - Is pending for processing.', 'cdi' ); ?>"<?php } ?>
			<?php
			if ( $cdi_status == 'intruck' ) {
				?>
				 class="button tips preview-cdi intruck" alt="<?php _e( 'In truck', 'cdi' ); ?>" data-tip="<?php _e( 'In truck - Parcel is on the road and carrier is in charge.', 'cdi' ); ?>"<?php } ?>
				 
		></a>
			<?php
		}

		if ('yes' == get_option( 'cdi_o_settings_display_labelcn23_shoporder' ) ) {
			if ( get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_exist_uploads_label', true ) == true ) {
				?>
					<a id="cdi-<?php echo esc_attr( cdi_c_wc3::cdi_order_id( $order ) ); ?>" 
					class="button tips preview-cdi orderlistlabel" alt="<?php _e( 'label', 'cdi' ); ?>" data-tip="<?php _e( 'Label exits. May be printed.', 'cdi' ); ?>" 
					>				
				<?php }						
				
			if ( get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_exist_uploads_cn23', true ) == true ) {
				?>
					<a id="cdi-<?php echo esc_attr( cdi_c_wc3::cdi_order_id( $order ) ); ?>" 
					class="button tips preview-cdi orderlistcn23" alt="<?php _e( 'cn23', 'cdi' ); ?>" data-tip="<?php _e( 'Cn23 exits. May be printed.', 'cdi' ); ?>" 
					>
				<?php } 
		}

		if ( 'yes' == get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_carrierredirected', true ) ) {
			$carrier = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_carrier', true );
			$carrierlabel = cdi_c_Function::cdi_get_libelle_carrier( $carrier );
			$productcode = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_productCode', true );
			?>
		<a id="cdi-<?php echo esc_attr( cdi_c_wc3::cdi_order_id( $order ) ); ?>" class="button tips preview-cdi carrierredirected" alt="<?php _e( 'Carrier redirected', 'cdi' ); ?>" data-tip="
							  <?php
								echo '==> ' . esc_attr( $carrierlabel ) . ' : ' . esc_attr( $productcode ) . ' <br><br>';
								_e( 'This parcel has been redirected by administrator to another carrier and/or with another carrier code. The initial shipping indication showed by WooCommerce may not be the right one. Only the information in CDI gatewal is true.<br><br>Click on icon to suppress this notification.', 'cdi' );
								?>
								" >
			<?php
		}
		if ( 'yes' == get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_return_executed', true ) ) {
			?>
		<a id="cdi-<?php echo esc_attr( cdi_c_wc3::cdi_order_id( $order ) ); ?>" class="button tips preview-cdi returnexecuted" alt="<?php _e( 'Parcel return asked', 'cdi' ); ?>" data-tip="<?php _e( 'Parcel return asked - A parcel return label has been asked by the customer (but we dont know if the parcel has already been sent).<br><br>Click on icon to suppress this notification.', 'cdi' ); ?>" ><?php
		}
	}

	public static function cdi_init_metabox( $order ) {
		global $woocommerce;
		global $wpdb;

		// Manage compatibility for orders passed and processed previously in version 3.7.x ($carrier)
		$carrier = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_carrier', true );
		if ( ! $carrier ) {
			$shippingmethod = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_refshippingmethod', true );
			if ( $shippingmethod and strpos( 'x' . $shippingmethod, 'colissimo_shippingzone_method_' ) > 0 ) {
				$carrier = 'colissimo'; // Old order which has been producted under CDI shipping method - May be or not already entered in CDI process
			} else {
				$carrier = 'colissimo'; // Old order not producted under CDI shipping method (for instance: Flat rates )
				// Allow change of carrier for this repatriation order with a filter
				$carrier = apply_filters( 'cdi_filterstring_orderlist_repatriation_change_carrier', $carrier, $order, get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_refshippingmethod', true ) );
			}
			update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_carrier', $carrier );
		}

		$eligible = self::cdi_check_synchro_eligible( $order );
		if ( $eligible == 'yes' ) {
			if ( ! get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', true ) ) { // create the CDI Metabox

				// common
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', 'waiting', true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_tracking', '', true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_parcelNumberPartner', '', true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_urllabel', '', true );
				// Via settings
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_departure', get_option( 'cdi_o_settings_departure' ), true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_typeparcel', get_option( 'cdi_o_settings_defaulttypeparcel' ), true );
				$total_weight = cdi_c_Function::cdi_calc_totalnetweight( $order ) + get_option( 'cdi_o_settings_parceltareweight' );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_parcelweight', $total_weight, true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_signature', get_option( 'cdi_o_settings_signature' ), true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_additionalcompensation', get_option( 'cdi_o_settings_additionalcompensation' ), true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_amountcompensation', get_option( 'cdi_o_settings_amountcompensation' ), true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_typereturn', get_option( 'cdi_o_settings_defaulttypereturn' ), true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_nbdayparcelreturn', get_option( 'cdi_o_settings_nbdayparcelreturn' ), true );
				// Without settings
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_returnReceipt', 'non', true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_ftd', 'non', true );

				// Meta for web services - can already have been created by PointRetrait web service But may not if a no CDI method is used
				if ( null == get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_productCode', true ) ) {
					add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_productCode', '', true );
				}
				if ( null == get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_pickupLocationId', true ) ) {
					add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_pickupLocationId', '', true );
				}
				// Filter to custom the datas when creating the metabox
				$arrfilter = array(
					'_cdi_meta_carrier' => $carrier,
					'_cdi_meta_departure' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_departure', true ),
					'_cdi_meta_typeparcel' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_typeparcel', true ),
					'_cdi_meta_parcelweight' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_parcelweight', true ),
					'_cdi_meta_signature' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_signature', true ),
					'_cdi_meta_additionalcompensation' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_additionalcompensation', true ),
					'_cdi_meta_amountcompensation' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_amountcompensation', true ),
					'_cdi_meta_typereturn' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_typereturn', true ),
					'_cdi_meta_nbdayparcelreturn' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_nbdayparcelreturn', true ),
					'_cdi_meta_returnReceipt' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_returnReceipt', true ),
					'_cdi_meta_ftd' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_ftd', true ),

					'_cdi_meta_productCode' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_productCode', true ),
					'_cdi_meta_pickupLocationId' => get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_pickupLocationId', true ),

				);
				$return = apply_filters( 'cdi_filterarray_orderlist_before_metabox', $arrfilter, $order, get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_refshippingmethod', true ) );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_carrier', $return['_cdi_meta_carrier'] );

				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_departure', $return['_cdi_meta_departure'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_typeparcel', $return['_cdi_meta_typeparcel'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_parcelweight', $return['_cdi_meta_parcelweight'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_signature', $return['_cdi_meta_signature'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_additionalcompensation', $return['_cdi_meta_additionalcompensation'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_amountcompensation', $return['_cdi_meta_amountcompensation'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_typereturn', $return['_cdi_meta_typereturn'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_nbdayparcelreturn', $return['_cdi_meta_nbdayparcelreturn'] );

				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_returnReceipt', $return['_cdi_meta_returnReceipt'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_ftd', $return['_cdi_meta_ftd'] );

				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_productCode', $return['_cdi_meta_productCode'] );
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_pickupLocationId', $return['_cdi_meta_pickupLocationId'] );

				$order_id = cdi_c_wc3::cdi_order_id( $order );
				$route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_initforcarrier';
				$return = ( $route )( $order_id, $order );

				// Calculate CN23 article fields
				$cdi_meta_cn23_shipping = cdi_c_Function::cdi_cn23_calc_shipping( $order );
				$cdi_meta_cn23_category = get_option( 'cdi_o_settings_cn23_category' );
				$arrfilter = array(
					'_cdi_meta_cn23_shipping' => $cdi_meta_cn23_shipping,
					'_cdi_meta_cn23_category' => $cdi_meta_cn23_category,
				);
				$return = apply_filters( 'cdi_filterarray_orderlist_before_metaboxcn23', $arrfilter, $order, get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_refshippingmethod', true ) );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_cn23_shipping', $return['_cdi_meta_cn23_shipping'], true );
				add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_cn23_category', $return['_cdi_meta_cn23_category'], true );

				// Add cn23data according to nbitem
				$nbart = 0;
				$maxitemcn23 = get_option( 'cdi_o_settings_maxitemcn23' );
				if ( ! $maxitemcn23 ) {
					$maxitemcn23 = 100;
				}
				$items_chosen = cdi_c_Function::cdi_get_items_chosen( $order );
				foreach ( $items_chosen as $item ) {
					$product_id = $item['variation_id'];
					if ( $product_id == 0 ) { // No variation for that one
						$product_id = $item['product_id'];
					}
					$product = wc_get_product( $product_id );
					// $artweight
					$artweight = $product->get_weight();
					if ( get_option( 'woocommerce_weight_unit' ) == 'kg' ) { // Convert kg to g
						if ( is_numeric( $artweight ) ) {
							$artweight = $artweight * 1000;
						} else {
							$artweight = 0;
						}
					}
					// $artdesc
					$artdesc = $product->get_name();
					// $artquantity
					$artquantity = $item->get_quantity();
					// $artvalueht
					$artvalueht = round( ( $item->get_total() / $artquantity ), 2 );
					if ( $artvalueht == 0 ) { // Case when value is 0
						$artvalueht = 0.01;
					}
					// $hstariff - If variable product, only the parent custom field is considered
					$hstariff = get_post_meta( $item['product_id'], 'hstariff', true );
					if ( ! $hstariff ) {
						$hstariff = '';
					}

					$cdi_meta_cn23_article_description = get_option( 'cdi_o_settings_cn23_article_description' );
					if ( ! $cdi_meta_cn23_article_description or $cdi_meta_cn23_article_description == ' ' ) {
						$cdi_meta_cn23_article_description = $artdesc;
					}
					$cdi_meta_cn23_article_weight = get_option( 'cdi_o_settings_cn23_article_weight' );
					if ( ! $cdi_meta_cn23_article_weight or $cdi_meta_cn23_article_weight == 0 ) {
						$cdi_meta_cn23_article_weight = $artweight;
					}
					$cdi_meta_cn23_article_quantity = get_option( 'cdi_o_settings_cn23_article_quantity' );
					if ( ! $cdi_meta_cn23_article_quantity or $cdi_meta_cn23_article_quantity == 0 ) {
						$cdi_meta_cn23_article_quantity = $artquantity;
					}
					$cdi_meta_cn23_article_value = get_option( 'cdi_o_settings_cn23_article_value' );
					if ( ! $cdi_meta_cn23_article_value or $cdi_meta_cn23_article_value == 0 ) {
						$cdi_meta_cn23_article_value = $artvalueht;
					}
					$cdi_meta_cn23_article_hstariffnumber = get_option( 'cdi_o_settings_cn23_article_hstariffnumber' );
					if ( ! $cdi_meta_cn23_article_hstariffnumber or $cdi_meta_cn23_article_hstariffnumber == ' ' ) {
						$cdi_meta_cn23_article_hstariffnumber = $hstariff;
					}
					$cdi_meta_cn23_article_origincountry = get_option( 'cdi_o_settings_cn23_article_origincountry' );
					$arrfilter = array(
						'_cdi_meta_cn23_article_description' => $cdi_meta_cn23_article_description,
						'_cdi_meta_cn23_article_weight' => $cdi_meta_cn23_article_weight,
						'_cdi_meta_cn23_article_quantity' => $cdi_meta_cn23_article_quantity,
						'_cdi_meta_cn23_article_value' => $cdi_meta_cn23_article_value,
						'_cdi_meta_cn23_article_hstariffnumber' => $cdi_meta_cn23_article_hstariffnumber,
						'_cdi_meta_cn23_article_origincountry' => $cdi_meta_cn23_article_origincountry,
					);

					$return = apply_filters( 'cdi_filterarray_orderlist_before_metaboxcn23art', $arrfilter, $order, get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_refshippingmethod', true ), $item );
					add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_cn23_article_description_' . $nbart, $return['_cdi_meta_cn23_article_description'], true );
					add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_cn23_article_weight_' . $nbart, $return['_cdi_meta_cn23_article_weight'], true );
					add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_cn23_article_quantity_' . $nbart, $return['_cdi_meta_cn23_article_quantity'], true );
					add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_cn23_article_value_' . $nbart, $return['_cdi_meta_cn23_article_value'], true );
					add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_cn23_article_hstariffnumber_' . $nbart, $return['_cdi_meta_cn23_article_hstariffnumber'], true );
					add_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_cn23_article_origincountry_' . $nbart, $return['_cdi_meta_cn23_article_origincountry'], true );

					if ( $nbart >= ( $maxitemcn23 - 1 ) ) {
						break; // A max limit is needed
					}
					$nbart = $nbart + 1;
				}
				// Auto fill the gateway with a parcel
				if ( get_option( 'cdi_o_settings_autoparcel_gateway' ) == 'yes' ) {
					$autofill = false;
					$autoparcel_shippinglist = get_option( 'cdi_o_settings_autoparcel_shippinglist' );
					if ( $autoparcel_shippinglist == null or $autoparcel_shippinglist == '' ) {
						$autofill = true;
					} else {
						$arr_autoparcel_shippinglist = array_map( 'trim', explode( ',', $autoparcel_shippinglist ) );
						$arr_refshippingmethod = explode( ':', get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_refshippingmethod', true ) );
						if ( in_array( $arr_refshippingmethod[0], $arr_autoparcel_shippinglist )  // Is it a racine-name alone ?
						or in_array( $arr_refshippingmethod[0] . ':' . $arr_refshippingmethod[1], $arr_autoparcel_shippinglist ) ) { // Or racine-name:instance ?
							$autofill = true;
						}
					}
					if ( $autofill == true ) {
						update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', 'deposited', true );
						cdi_c_Gateway::cdi_c_Addgateway_open();
						cdi_c_Gateway::cdi_c_Addgateway_add( cdi_c_wc3::cdi_order_id( $order ) );
						cdi_c_Gateway::cdi_c_Addgateway_close();
					}
				}
			}
		}
	}

	public static function cdi_check_synchro_eligible( $order ) {
		$status = cdi_c_wc3::cdi_order_status( $order );
		if ( $status == 'processing' or $status == 'on-hold' ) {
			$eligible = 'yes';
		} else {
			$eligible = apply_filters( 'cdi_filterstring_orderlist_eligible', 'no', $order );
		}
		return $eligible;
	}

	public static function cdi_synchro_metabox_gateway( $order ) {
		global $woocommerce;
		global $wpdb;
		// Synchro from CDI gateway to orders
		if ( get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', true ) !== 'intruck' ) {
			$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . "cdi where cdi_order_id like '" . esc_sql( cdi_c_wc3::cdi_order_id( $order ) ) . "' " );
			if ( count( $results ) ) {
				foreach ( $results as $row ) {
					$tracking_code = $row->cdi_tracking;
					$cdi_parcelNumberPartner = $row->cdi_parcelNumberPartner;
					$url_label = $row->cdi_hreflabel;
					$id_row = $row->id;
				}
				if ( $tracking_code && ( $row->cdi_status == 'open' or null == $row->cdi_status ) ) { // For compatibility if parcels are in gateway at change
					$cdi_parcelNumberPartner = str_replace( ' ', '', $cdi_parcelNumberPartner );
					update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', 'intruck' );
					update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_tracking', $tracking_code );
					update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_parcelNumberPartner', $cdi_parcelNumberPartner );
					update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_urllabel', $url_label );
					if ( get_option( 'cdi_o_settings_autoclean_gateway' ) == 'yes' ) {
						$wpdb->query( 'delete from ' . $wpdb->prefix . "cdi where id = '" . esc_sql( $id_row ) . "' limit 1" );
					}
					// Auto "completed" order when parcel is set "intruck"
					if ( get_option( 'cdi_o_settings_autocompleted_intruck' ) == 'yes' ) {
						$order->update_status( 'completed', 'Autoset by CDI according settings.' );
					}
					do_action( 'cdi_actionorderlist_after_updateorder', $order );
				} else {
					update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', 'deposited' );
				}
			} else {
				update_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', 'waiting' );
			}
		}
	}

	public static function cdi_clear_metabox( $orderid ) {
		global $woocommerce;
		delete_post_meta( $orderid, '_cdi_meta_status' );
		delete_post_meta( $orderid, '_cdi_meta_tracking' );
		delete_post_meta( $orderid, '_cdi_meta_parcelNumberPartner' );
		delete_post_meta( $orderid, '_cdi_meta_urllabel' );
		delete_post_meta( $orderid, '_cdi_meta_departure' );
		delete_post_meta( $orderid, '_cdi_meta_typeparcel' );
		delete_post_meta( $orderid, '_cdi_meta_parcelweight' );
		delete_post_meta( $orderid, '_cdi_meta_signature' );
		delete_post_meta( $orderid, '_cdi_meta_additionalcompensation' );
		delete_post_meta( $orderid, '_cdi_meta_amountcompensation' );
		delete_post_meta( $orderid, '_cdi_meta_returnReceipt' );
		delete_post_meta( $orderid, '_cdi_meta_typereturn' );
		delete_post_meta( $orderid, '_cdi_meta_ftd' );
		delete_post_meta( $orderid, '_cdi_meta_nbdayparcelreturn' );
		delete_post_meta( $orderid, '_cdi_meta_exist_uploads_label' );
		delete_post_meta( $orderid, '_cdi_meta_base64_return' );
		delete_post_meta( $orderid, '_cdi_meta_cn23_shipping' );
		delete_post_meta( $orderid, '_cdi_meta_cn23_category' );
		delete_post_meta( $orderid, 'cdi_colis_inovert' );
		delete_post_meta( $orderid, '_cdi_chosen_products' );
		for ( $i = 0; $i <= 99; $i++ ) {
			delete_post_meta( $orderid, '_cdi_meta_cn23_article_description_' . $i );
			delete_post_meta( $orderid, '_cdi_meta_cn23_article_weight_' . $i );
			delete_post_meta( $orderid, '_cdi_meta_cn23_article_quantity_' . $i );
			delete_post_meta( $orderid, '_cdi_meta_cn23_article_value_' . $i );
			delete_post_meta( $orderid, '_cdi_meta_cn23_article_hstariffnumber_' . $i );
			delete_post_meta( $orderid, '_cdi_meta_cn23_article_origincountry_' . $i );
		}
	}

	public static function cdi_orderlist_button_callback() {
		$orderid = sanitize_text_field( $_POST['orderid'] );
		$orderid = str_replace( 'cdi-', '', $orderid );
		$mode = sanitize_text_field( $_POST['mode'] );
		if ( $mode == 'carrierredirected' ) {
			delete_post_meta( $orderid, '_cdi_meta_carrierredirected' );
		} elseif ( $mode == 'return' ) {
			delete_post_meta( $orderid, '_cdi_meta_return_executed' );
		} elseif ( $mode == 'synchrogateway' ) {
			$order = new WC_Order( $orderid );
			$eligible = self::cdi_check_synchro_eligible( $order );
			if ( $eligible == 'yes' ) {
				self::cdi_synchro_metabox_gateway( $order );
			}
		} elseif ( $mode == 'resetmetabox' ) {
			$order = new WC_Order( $orderid );
			$eligible = self::cdi_check_synchro_eligible( $order );
			if ( $eligible == 'yes' ) {
				self::cdi_clear_metabox( $orderid );
				self::cdi_init_metabox( $order );
			}
		} elseif ( $mode == 'waitingmetabox' ) {
			cdi_c_Gateway::cdi_c_Addgateway_open();
			cdi_c_Gateway::cdi_c_Addgateway_add( $orderid );
			cdi_c_Gateway::cdi_c_Addgateway_close();
			update_post_meta( $orderid, '_cdi_meta_status', 'deposited' );
		} elseif ( $mode == 'orderlistlabel' ) {
			$cdi_printajax_todo = array( 'type' => 'label' , 'orderid' => $orderid ) ;
			update_option( 'cdi_printajax_todo', $cdi_printajax_todo );	
		} elseif ( $mode == 'orderlistcn23' ) {
			$cdi_printajax_todo = array( 'type' => 'cn23' , 'orderid' => $orderid ) ;
			update_option( 'cdi_printajax_todo', $cdi_printajax_todo );				
		} else {
			cdi_c_Gateway::cdi_c_Addgateway_open();
			cdi_c_Gateway::cdi_c_Addgateway_add( $orderid );
			cdi_c_Gateway::cdi_c_Addgateway_close();
		}
		wp_die();
	}
}
?>
