<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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

$billDefault = get_customer_addresses_default('billing');
?>
<div id="billingAddressCustom" class="woocommerce-billing-fields checkoutBlocks inActive">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h5><?php esc_html_e( 'Billing Address', 'woocommerce' ); ?></h5>

	<?php else : ?>

		<h5><?php esc_html_e( 'Billing Address', 'woocommerce' ); ?></h5>

	<?php endif; ?>

	<div class="checkoutDetailBlock">

		<!--<?php if ($billDefault) : ?>
			<div class="defaultAddress">
				<p>Your default billing address is set to: </p>
				<p class="addressDetails">
					<span><?= $billDefault->userdata['billing_first_name'] ?></span> <span><?= $billDefault->userdata['billing_last_name'] ?></span><br>
					<span><?= $billDefault->userdata['billing_address_1'] ?></span><br>
					<span><?= $billDefault->userdata['billing_postcode'] ?></span> <span><?= $billDefault->userdata['billing_state'] ?></span>, <span><?= $billDefault->userdata['billing_country'] ?></span>
				</p>
			</div>
		<?php endif; ?>-->

		<label class='chk-container'>Same as shipping address
			<input type='radio' name='billOption' value='billSameShip'>
			<span class='checkmark'></span>
		</label>
		
		<?php if ($billDefault) : ?>

			<label class='chk-container'>Use default billing address
				<input type='radio' name='billOption' value='billToDefault'>
				<span class='checkmark'></span>
			</label>

		<?php endif; ?>

		<label class='chk-container'>Bill to another address
			<input type='radio' name='billOption' value='billToNew'>
			<span class='checkmark'></span>
		</label>
	
		<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

		<div class="woocommerce-billing-fields__field-wrapper">
			<?php
			$fields = $checkout->get_checkout_fields( 'billing' );

			foreach ( $fields as $key => $field ) {
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
			?>
		</div>
		<button type="button" class="nextBlock btn">Continue</button>
		<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
	</div>
</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>
