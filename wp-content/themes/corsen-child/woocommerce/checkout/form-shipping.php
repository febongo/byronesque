<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="shippingAddressCustom" class="woocommerce-shipping-fields checkoutBlocks">
	<h5><?php esc_html_e( 'Shipping Address', 'woocommerce' ); ?></h5>
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<div class="shipping_address2 checkoutDetailBlock">

			<?php 
				$shipDefault = get_customer_addresses_default('shipping');
				// var_dump($shipDefault);
				if ($shipDefault) :
					// var_dump($shipDefault->userdata['reference_field']);
			?>
				<div class="defaultAddress">
					<p>Your default shipping address is set to: </p>
					<p class="addressDetails">
						<span><?= $shipDefault->userdata['shipping_first_name'] ?></span> <span><?= $shipDefault->userdata['shipping_last_name'] ?></span><br>
						<span><?= $shipDefault->userdata['shipping_address_1'] ?></span><br>
						<span><?= $shipDefault->userdata['shipping_postcode'] ?></span> <span><?= $shipDefault->userdata['shipping_state'] ?></span>, <span><?= $shipDefault->userdata['shipping_country'] ?></span>
					</p>
				</div>
				<label class='chk-container'>Ship to default address
					<input type='radio' name='shipOption' value='shipToDefault'>
					<span class='checkmark'></span>
				</label>

				<label class='chk-container'>Ship to another address
					<input type='radio' name='shipOption' value='shipToNew'>
					<span class='checkmark'></span>
				</label>


			<?php endif; ?>



			
			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>
				<?php
				$fields = $checkout->get_checkout_fields( 'shipping' );
				foreach ( $fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

			

			<span class="nextBlock btn" data-next="shippingMethodCustom">Continue</span>
		</div>

	<?php endif; ?>

</div>
<div class="woocommerce-additional-fields" style="display:none">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
