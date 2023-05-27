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
/* CDI Meta box in orderspanel                                                          */
/****************************************************************************************/
class cdi_c_Metabox {
	public static function init() {
		add_action( 'add_meta_boxes_shop_order', __CLASS__ . '::cdi_addmetabox' );
		add_action( 'save_post', __CLASS__ . '::cdi_save_metabox', 99 );
	}
	public static function cdi_addmetabox() {
		global $woocommerce, $post;
		$order = new WC_Order( $post->ID );
		$cdi_status = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', true );
		if ( $cdi_status ) { // Show CDI Metabox only if it is not an admin order in process
			if ( ( $cdi_status == 'deposited' or $cdi_status == 'intruck' ) ) {
				add_meta_box( 'cdi-metabox-display', 'CDI Métabox <a id="cdi-' . cdi_c_wc3::cdi_order_id( $order ) . '" class="button tips preview-cdi synchrogateway" data-tip="Synchro again from CDI Gateway (for this order only)." ></a>', __CLASS__ . '::cdi_create_box_content', 'shop_order', 'side', 'low' );
			} elseif ( $cdi_status == 'waiting' ) {
				add_meta_box( 'cdi-metabox-display', 'CDI Métabox <a id="cdi-' . cdi_c_wc3::cdi_order_id( $order ) . '" class="button tips preview-cdi resetmetabox" data-tip="Reset (compute again) CDI Metabox from WC order (for this order only)." ></a>', __CLASS__ . '::cdi_create_box_content', 'shop_order', 'side', 'low' );
			} else {
				add_meta_box( 'cdi-metabox-display', 'CDI Métabox', __CLASS__ . '::cdi_create_box_content', 'shop_order', 'side', 'low' );
			}
		}
	}
	public static function cdi_create_box_content() {
		global $woocommerce;
		// Ref : wc-meta-box-functions.php
		?>
		<?php wp_nonce_field( 'cdi_save_metabox', 'cdi_save_metabox_nonce' ); ?> 
		<?php global $woocommerce, $post; ?>
		<?php $order = new WC_Order( $post->ID ); ?> 
		<?php $order_id = cdi_c_wc3::cdi_order_id( $order ); ?>
		
		<?php
		$carrier   = get_post_meta( $order_id, '_cdi_meta_carrier', true );
		if ( ! $carrier ) {
			update_post_meta( $order_id, '_cdi_meta_carrier', 'colissimo' ); // Defaut
		}
		?>
		  <div class="cdi-tracking-box">
		 
		<?php $order_number = $order->get_order_number(); ?>
		<p><a><?php _e( 'Parcel (Order) : ', 'cdi' ); ?></a><a style='color:black'><?php echo esc_attr( $order_id ); ?> ( <?php echo esc_attr( $order_number ); ?> ) </a></p>
		 
		<?php $cdi_status = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_status', true ); ?>
		<?php $lib_cdi_status = str_replace( array( 'waiting', 'deposited', 'intruck' ), array( __( 'Waiting', 'cdi' ), __( 'Deposited', 'cdi' ), __( 'Intruck', 'cdi' ) ), $cdi_status ); ?> 
		<p><a><?php _e( 'Status : ', 'cdi' ); ?></a><a style='color:black'><?php echo esc_attr( $lib_cdi_status ); ?> </a>
			  <?php
				if ( $cdi_status == 'waiting' ) {
					?>
					 <a> - </a><a id="cdi-<?php echo esc_attr( cdi_c_wc3::cdi_order_id( $order ) ); ?>" class="button tips preview-cdi waitingmetabox" alt="<?php _e( 'Waiting', 'cdi' ); ?>" data-tip="<?php _e( 'Waiting - Can be filed in the CDI gateway.', 'cdi' ); ?>" > <?php } ?>
			  </a>
		</p>
		<?php
		$cdi_urllabel = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_urllabel', true );
			  $cdi_tracking = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_tracking', true );
		if ( $cdi_status == 'intruck' && $cdi_tracking ) {
			;
			?>
				 <p><a style="color:black;"><?php echo wp_kses_post( cdi_c_Function::cdi_get_whereis_parcel( $order_id, $cdi_tracking ) ); ?></a></p>
				<?php
		}
		?>

		<p style='width:35%; float:left;  margin-top:5px;'><a><?php _e( 'Carrier : ', 'cdi' ); ?>
			<?php
			woocommerce_wp_select(
				array(
					'name' => '_cdi_meta_carrier',
					'type' => 'text',
					'options' => array(
						'colissimo' => __( 'Colissimo', 'cdi' ),
						'mondialrelay' => __( 'Mondial Relay', 'cdi' ),
						'ups'      => __( 'UPS', 'cdi' ),
						'collect'      => __( 'Collect', 'cdi' ),
						'notcdi' => cdi_c_Function::cdi_get_libelle_carrier( 'notcdi' ),
					),
					'style' => 'width:60%; float:left;',
					'id'   => '_cdi_meta_carrier',
					'label' => '',
				)
			);
			?>
			 </a></p><p style="clear:both"></p>
		</div>
			
		<!--  Expedition zone -->            
		<div style='background-color:#eeeeee; color:#000000; width:100%;'>Expedition</div><p style="clear:both"></p>            

		<?php $shipping_country = get_post_meta( $order_id, '_shipping_country', true ); ?>
		<?php $shipping_postcode = get_post_meta( $order_id, '_shipping_postcode', true ); ?>
		<p style='float:left;  margin-top:5px;'><a><?php _e( 'To : ', 'cdi' ); ?></a><a style="color:black;"><?php echo esc_attr( $shipping_country ) . ' ' . WC()->countries->countries[ $shipping_country ]; ?> </a></p><p style="clear:both"></p>
		<?php $shippingmethod = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_refshippingmethod', true ); ?>
		<?php
		$method_name = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_shippingmethod_name', true );
		  $carrier = get_post_meta( cdi_c_wc3::cdi_order_id( $order ), '_cdi_meta_carrier', true );
		  $carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
		  $carrierlabel = cdi_c_Function::cdi_get_libelle_carrier( $carrier );
		  echo '<div id="cdimetashippingmethodname"><p>' . __( 'shipping request: ', 'cdi' ) . esc_attr( $method_name ) . __( ' - Carrier used: ', 'cdi' ) . esc_attr( $carrierlabel ) . '</p></div>';
		?>
		<p> </p>
		<!--  End Expedition zone --> 
		
		<!--  Tracking code zone --> 
		  <?php
				  $carrier = get_post_meta( $order_id, '_cdi_meta_carrier', true );
				  $carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
				  $route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_tracking_zone';
				  ( $route )( $order_id, $order );
			?>
		<!--  End Tracking code zone --> 

		<!--  Parcel settings zone --> 
		  <?php
				  $carrier = get_post_meta( $order_id, '_cdi_meta_carrier', true );
				  $carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
				  $route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_parcel_settings';
				  ( $route )( $order_id, $order );
			?>
		<!--  End Parcel settings zone --> 

		<!--  Parcel deliver choices zone --> 
		  <?php
				  $carrier = get_post_meta( $order_id, '_cdi_meta_carrier', true );
				  $carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
				  $route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_optional_choices';
				  ( $route )( $order_id, $order );
			?>
		<!--  End Parcel deliver choices zone --> 

		<!--  Shipping customer choices zone -->  
		  <?php
			// Update of label and full address pickup if necessary
			$pickupLocationId = get_post_meta( $order_id, '_cdi_meta_pickupLocationId', true );
			$last_pickupLocationId = get_post_meta( $order_id, '_cdi_meta_lastpickupLocationId', true );
			if ( $pickupLocationId != $last_pickupLocationId ) {
				if ( $pickupLocationId ) {
					$carrier = get_post_meta( $order_id, '_cdi_meta_carrier', true );
					$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
					$route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_shipping_updatepickupaddress';
					( $route )( $order_id, $order );
				}
				update_post_meta( $order_id, '_cdi_meta_lastpickupLocationId', $pickupLocationId );
			}
			?>
		  <?php
				  $carrier = get_post_meta( $order_id, '_cdi_meta_carrier', true );
				  $carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
				  $route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_shipping_customer_choices';
				  ( $route )( $order_id, $order );
			?>
		<!--  End Shipping customer choices zone --> 

		<!--  Shipping cn23 zone --> 
		  <?php
				  $carrier = get_post_meta( $order_id, '_cdi_meta_carrier', true );
				  $carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
				  $route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_shipping_cn23';
				  ( $route )( $order_id, $order );
			?>
		<!--  End Shipping cn23 zone --> 

		<!--  Parcel return options zone --> 
		  <?php
				  $carrier = get_post_meta( $order_id, '_cdi_meta_carrier', true );
				  $carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
				  $route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_parcel_return';
				  ( $route )( $order_id, $order );
			?>
		<!--  End Parcel return options zone --> 

		<?php
	}
	public static function cdi_save_metabox( $post_id ) {
		if ( ! wc_get_order( $post_id ) ) {
			return;
		}
		global $woocommerce, $post, $post_type;
		$order = new WC_Order( $post_id );
		$order_id = $post_id;

		if ( ! isset( $_POST['cdi_save_metabox_nonce'] ) ) {
			return $post_id; }
		if ( ! wp_verify_nonce( $_POST['cdi_save_metabox_nonce'], 'cdi_save_metabox' ) ) {
			return $post_id; }
		if ( $post_type !== 'shop_order' ) {
			return $post_id; }
		$cdi_status = get_post_meta( $post_id, '_cdi_meta_status', true );
		if ( ! $cdi_status ) {
			return $post_id; } // Metabox CDI not yet created

		if ( ( $_POST['_cdi_meta_carrier'] !== get_post_meta( $order_id, '_cdi_meta_carrier', true ) ) or
		  ( isset( $_POST['_cdi_meta_productCode'] ) and ( $_POST['_cdi_meta_productCode'] !== get_post_meta( $order_id, '_cdi_meta_productCode', true ) ) ) or
		  ( $_POST['_cdi_meta_pickupLocationId'] !== get_post_meta( $order_id, '_cdi_meta_pickupLocationId', true ) ) ) {
			update_post_meta( $order_id, '_cdi_meta_carrierredirected', 'yes' );
		}
		if ( isset( $_POST['_cdi_meta_carrier'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_carrier', sanitize_text_field( $_POST['_cdi_meta_carrier'] ) ); }
		if ( isset( $_POST['_cdi_meta_destcountrycode'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_destcountrycode', sanitize_text_field( $_POST['_cdi_meta_destcountrycode'] ) ); }
		if ( isset( $_POST['_cdi_meta_departure'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_departure', sanitize_text_field( $_POST['_cdi_meta_departure'] ) ); }
		if ( isset( $_POST['_cdi_meta_tracking'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_tracking', preg_replace( '/[^A-Z0-9]/', '', strtoupper( $_POST['_cdi_meta_tracking'] ) ) ); }
		if ( isset( $_POST['_cdi_meta_collect_status'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_collect_status', sanitize_text_field( $_POST['_cdi_meta_collect_status'] ) ); }
		if ( isset( $_POST['_cdi_meta_securitymode'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_securitymode', sanitize_text_field( $_POST['_cdi_meta_securitymode'] ) ); }
		if ( isset( $_POST['_cdi_meta_deliveredcode'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_deliveredcode', sanitize_text_field( $_POST['_cdi_meta_deliveredcode'] ) ); }					
		if ( isset( $_POST['_cdi_meta_typeparcel'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_typeparcel', sanitize_text_field( $_POST['_cdi_meta_typeparcel'] ) ); }
		if ( isset( $_POST['_cdi_meta_parcelweight'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_parcelweight', sanitize_text_field( $_POST['_cdi_meta_parcelweight'] ) ); }
		if ( isset( $_POST['_cdi_meta_limitquote'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_limitquote', sanitize_text_field( $_POST['_cdi_meta_limitquote'] ) ); }
		if ( isset( $_POST['_cdi_meta_collectcar'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_collectcar', sanitize_text_field( $_POST['_cdi_meta_collectcar'] ) ); }
		if ( isset( $_POST['_cdi_meta_signature'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_signature', sanitize_text_field( $_POST['_cdi_meta_signature'] ) ); }
		if ( isset( $_POST['_cdi_meta_additionalcompensation'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_additionalcompensation', sanitize_text_field( $_POST['_cdi_meta_additionalcompensation'] ) ); }
		if ( isset( $_POST['_cdi_meta_amountcompensation'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_amountcompensation', sanitize_text_field( $_POST['_cdi_meta_amountcompensation'] ) ); }
		if ( isset( $_POST['_cdi_meta_returnReceipt'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_returnReceipt', sanitize_text_field( $_POST['_cdi_meta_returnReceipt'] ) ); }
		if ( isset( $_POST['_cdi_meta_typereturn'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_typereturn', sanitize_text_field( $_POST['_cdi_meta_typereturn'] ) ); }
		if ( isset( $_POST['_cdi_meta_ftd'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_ftd', sanitize_text_field( $_POST['_cdi_meta_ftd'] ) ); }
		if ( isset( $_POST['_cdi_meta_productCode'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_productCode', sanitize_text_field( $_POST['_cdi_meta_productCode'] ) ); }
		if ( isset( $_POST['_cdi_meta_pickupLocationId'] ) ) {
			$new_pickupLocationId = sanitize_text_field( $_POST['_cdi_meta_pickupLocationId'] );
			update_post_meta( $order_id, '_cdi_meta_pickupLocationId', $new_pickupLocationId );
			$last_pickupLocationId = get_post_meta( $post_id, '_cdi_meta_lastpickupLocationId', true );
			if ( $new_pickupLocationId != $last_pickupLocationId ) {
				update_post_meta( $order_id, '_cdi_meta_lastpickupLocationId', $new_pickupLocationId );
				if ( ! $new_pickupLocationId ) {
					update_post_meta( $order_id, '_cdi_meta_pickupLocationlabel', '' );
					update_post_meta( $order_id, '_cdi_meta_pickupfulladdress', '' );
				} else { // try to get new address
					$carrier = get_post_meta( $order_id, '_cdi_meta_carrier', true );
					$carrier = cdi_c_Function::cdi_fallback_carrier( $carrier );
					$route = 'cdi_c_Carrier_' . $carrier . '::cdi_metabox_shipping_updatepickupaddress';
					( $route )( $order_id, $order );
				}
			}
		}
		if ( isset( $_POST['_cdi_meta_cn23_shipping'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_cn23_shipping', sanitize_text_field( $_POST['_cdi_meta_cn23_shipping'] ) ); }
		if ( isset( $_POST['_cdi_meta_cn23_category'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_cn23_category', sanitize_text_field( $_POST['_cdi_meta_cn23_category'] ) ); }
		if ( isset( $_POST['_cdi_meta_nbdayparcelreturn'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_nbdayparcelreturn', sanitize_text_field( $_POST['_cdi_meta_nbdayparcelreturn'] ) ); }

		// $order = new WC_Order($post->ID); $items = $order->get_items(); => give a crash with woocommerce-pdf-invoices-packingslips, so a resiliant way to found to find nb of cn23 articles

		$nbart = 0;
		$maxitemcn23 = get_option( 'cdi_o_settings_maxitemcn23' );
		if ( ! $maxitemcn23 ) {
			$maxitemcn23 = 100;
		}
		while ( $nbart <= ( $maxitemcn23 - 1 ) ) { // Check post limited to limit server overhead
			if ( isset( $_POST[ '_cdi_meta_cn23_article_description_' . $nbart ] ) ) {
				update_post_meta( $post_id, '_cdi_meta_cn23_article_description_' . $nbart, sanitize_text_field( $_POST[ '_cdi_meta_cn23_article_description_' . $nbart ] ) ); }
			if ( isset( $_POST[ '_cdi_meta_cn23_article_weight_' . $nbart ] ) ) {
				update_post_meta( $post_id, '_cdi_meta_cn23_article_weight_' . $nbart, sanitize_text_field( $_POST[ '_cdi_meta_cn23_article_weight_' . $nbart ] ) ); }
			if ( isset( $_POST[ '_cdi_meta_cn23_article_quantity_' . $nbart ] ) ) {
				update_post_meta( $post_id, '_cdi_meta_cn23_article_quantity_' . $nbart, sanitize_text_field( $_POST[ '_cdi_meta_cn23_article_quantity_' . $nbart ] ) ); }
			if ( isset( $_POST[ '_cdi_meta_cn23_article_value_' . $nbart ] ) ) {
				update_post_meta( $post_id, '_cdi_meta_cn23_article_value_' . $nbart, sanitize_text_field( $_POST[ '_cdi_meta_cn23_article_value_' . $nbart ] ) ); }
			if ( isset( $_POST[ '_cdi_meta_cn23_article_hstariffnumber_' . $nbart ] ) ) {
				update_post_meta( $post_id, '_cdi_meta_cn23_article_hstariffnumber_' . $nbart, sanitize_text_field( $_POST[ '_cdi_meta_cn23_article_hstariffnumber_' . $nbart ] ) ); }
			if ( isset( $_POST[ '_cdi_meta_cn23_article_origincountry_' . $nbart ] ) ) {
				update_post_meta( $post_id, '_cdi_meta_cn23_article_origincountry_' . $nbart, sanitize_text_field( $_POST[ '_cdi_meta_cn23_article_origincountry_' . $nbart ] ) ); }
			$nbart = $nbart + 1;
		}
	}

}


?>
