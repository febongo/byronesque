<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<div id="stepStarter"></div>
<div class="wrap-form">
	<div class="back-container">
		<a class="stepBack" href="#">Back</a>
	</div>
	<div class="form-checkout-block">
		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<div class="woocommerce-checkout-block">
			<div class="checkout-details">
				<?php if ( $checkout->get_checkout_fields() ) : ?>
					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
					<!-- <div class="woocommerce-myaccount-detailblock checkout-left-block"></div>		 -->
					<div class="woocommerce-myaccount-detailblock-checkout checkout-details-block">
						<div id="customer_details">

							<?php do_action( 'woocommerce_checkout_shipping' ); ?>

							<div id="shippingMethodCustom" class="checkoutBlocks inActive">

								<h4><?php esc_html_e( 'Shipping Method', 'woocommerce' ); ?></h4>

								<div id="" class="checkoutDetailBlock">
									<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

										<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

										<?php wc_cart_totals_shipping_html(); ?>

										<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

									<?php endif; ?>

									<span class="nextBlock btn" data-next="paymentMethodCustom">Continue</span>
								</div>
							</div>


							<div id="paymentMethodCustom" class="checkoutBlocks inActive">
								<h4><?php esc_html_e( 'Payment Method', 'woocommerce' ); ?></h4>
								<div id="payment" class="woocommerce-checkout-payment checkoutDetailBlock">
									
									
								</div>
								
							</div>
							
							<?php do_action( 'woocommerce_checkout_billing' ); ?>


						</div>
					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>
				
				
			</div>
			<div class="checkout-summary">
				
				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
				
				<div class="woocommerce-myaccount-detailblock order-summary-block">
					<h4 id="order_review_heading"><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></h4>
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>
				
					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

					<div class="shippingTo">Shipping to</div>
				</div>
				
				
			</div>
		</div>	
		</form>
	</div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

