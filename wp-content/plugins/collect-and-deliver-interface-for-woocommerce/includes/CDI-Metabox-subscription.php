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
/* CDI Meta box in Subscription panel                                                          */
/****************************************************************************************/
class cdi_c_Metabox_subscription {

	public static function init() {
		add_action( 'add_meta_boxes', __CLASS__ . '::cdi_addmetabox_subscription' );
		add_action( 'save_post', __CLASS__ . '::cdi_save_metabox_subscription', 99 );
	}

	public static function cdi_addmetabox_subscription() {
		global $post;
		$screen    = get_current_screen();
		$screen_id = isset( $screen->id ) ? $screen->id : '';
		if ( 'shop_subscription' == $screen_id ) {
			  add_meta_box( 'cdi-metabox-display-subscription', 'CDI Subscription', __CLASS__ . '::cdi_create_box_content_subscription', 'shop_subscription', 'side', 'low' );
		}
	}

	public static function cdi_create_box_content_subscription() {
		global $post;
		// Ref : wc-meta-box-functions.php
		?>
		<?php wp_nonce_field( 'cdi_save_metabox_subscription', 'cdi_save_metabox_subscription_nonce' ); ?> 
		<?php $post_id = $post->ID; ?> 
		<?php
		$carrier   = get_post_meta( $post_id, '_cdi_meta_carrier', true );
		if ( ! $carrier ) {
			// Manage compatibility for orders passed and processed previously in version 3.7.x ($carrier)
			$shippingmethod = get_post_meta( $post_id, '_cdi_refshippingmethod', true );
			if ( $shippingmethod and strpos( 'x' . $shippingmethod, 'colissimo_shippingzone_method_' ) > 0 ) {
				$carrier = 'colissimo'; // Old order which has been producted under CDI shipping method - May be or not already entered in CDI process
			} else {
				$carrier = 'colissimo'; // Old order not producted under CDI shipping method (for instance: Flat rates )
				// Allow change of carrier for this repatriation order with a filter
				$carrier = apply_filters( 'cdi_filterstring_subscription_repatriation_change_carrier', $carrier, $post, get_post_meta( $post_id, '_cdi_refshippingmethod', true ) );
			}
			update_post_meta( $post_id, '_cdi_meta_carrier', $carrier );
		}
		?>
					
		<?php $shippingmethod = get_post_meta( $post_id, '_cdi_refshippingmethod', true ); ?>
		<?php $method_name = get_post_meta( $post_id, '_cdi_meta_shippingmethod_name', true ); ?>
		<p style="margin-bottom:2px;"><a><?php _e( 'Original shipping : ', 'cdi' ); ?></a><a style="color:black;"><?php echo esc_attr( $method_name ); ?></a> : <?php echo esc_attr( $shippingmethod ); ?></p>
		<p> </p> 

		<div style='background-color:#eeeeee; color:#000000; width:100%;'><?php _e( 'Future shippings :', 'cdi' ); ?></div><p style="clear:both"></p>               
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

		<p style='width:50%; float:left; margin-top:5px;'><a><?php _e( 'Forced product code : ', 'cdi' ); ?>
																	   <?php
			woocommerce_wp_text_input(
				array(
					'name' => '_cdi_meta_productCode',
					'type' => 'text',
					'style' => 'width:45%; float:left;',
					'id'   => '_cdi_meta_productCode',
					'label' => '',
				)
			);
			?>
			 </a></p><p style="clear:both"></p>
			
		<p style='width:50%; float:left; margin-top:5px;'><a><?php _e( 'Pickup location id : ', 'cdi' ); ?>
																	   <?php
			woocommerce_wp_text_input(
				array(
					'name' => '_cdi_meta_pickupLocationId',
					'type' => 'text',
					'style' => 'width:45%; float:left;',
					'id'   => '_cdi_meta_pickupLocationId',
					'label' => '',
				)
			);
			?>
			 </a></p><p style="clear:both"></p>

		<?php
	}

	public static function cdi_save_metabox_subscription( $post_id ) {
		global $post, $post_type;

		if ( ! isset( $_POST['cdi_save_metabox_subscription_nonce'] ) ) {
			return $post_id; }
		if ( ! wp_verify_nonce( $_POST['cdi_save_metabox_subscription_nonce'], 'cdi_save_metabox_subscription' ) ) {
			return $post_id; }
		if ( $post_type !== 'shop_subscription' ) {
			return $post_id; }

		if ( ( $_POST['_cdi_meta_carrier'] !== get_post_meta( $post_id, '_cdi_meta_carrier', true ) ) or
		  ( isset( $_POST['_cdi_meta_productCode'] ) and ( $_POST['_cdi_meta_productCode'] !== get_post_meta( $post_id, '_cdi_meta_productCode', true ) ) ) or
		  ( $_POST['_cdi_meta_pickupLocationId'] !== get_post_meta( $post_id, '_cdi_meta_pickupLocationId', true ) ) ) {
			update_post_meta( $post_id, '_cdi_meta_carrierredirected', 'yes' );
		}

		if ( isset( $_POST['_cdi_meta_carrier'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_carrier', sanitize_text_field( $_POST['_cdi_meta_carrier'] ) ); }
		if ( isset( $_POST['_cdi_meta_productCode'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_productCode', sanitize_text_field( $_POST['_cdi_meta_productCode'] ) ); }
		if ( isset( $_POST['_cdi_meta_pickupLocationId'] ) ) {
			update_post_meta( $post_id, '_cdi_meta_pickupLocationId', sanitize_text_field( $_POST['_cdi_meta_pickupLocationId'] ) ); }
		if ( ! isset( $_POST['_cdi_meta_pickupLocationId'] ) or ( $_POST['_cdi_meta_pickupLocationId'] == null ) or ( $_POST['_cdi_meta_pickupLocationId'] == '' ) ) {
			update_post_meta( $post_id, '_cdi_meta_pickupLocationlabel', '' );
			update_post_meta( $post_id, '_cdi_meta_pickupfulladdress', '' );
		}

	}

}


?>
