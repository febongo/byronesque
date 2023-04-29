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

								<h5><?php esc_html_e( 'Shipping Method', 'woocommerce' ); ?></h5>

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
								<h5><?php esc_html_e( 'Payment Method', 'woocommerce' ); ?></h5>
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
					<h5 id="order_review_heading"><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></h5>
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

<!-- to be transfered in stylesheet -->
<style>
.woocommerce-checkout #qodef-page-content .woocommerce{
	background: none;
}
.checkoutBlocks {
	background: #F8F5EACC;
	padding: 20px;
	margin-bottom: 20px;
}

.checkoutBlocks.inActive .checkoutDetailBlock{
	display: none;
}

.nextBlock{
	display: block;
	padding: 5px;
	width: 100%; 
	background: #000;
	color: #fff;
	margin : 20px 0;
	text-align: center;
	cursor: pointer;
}

#order_review #payment{
	display: none;
}

.woocommerce-checkout-block{
	width: 100%;
}

.woocommerce-checkout-block .checkout-details{
	width: 70%;
}

.woocommerce-checkout-block .checkout-details .checkout-details-block{
	width: 100%;
}

.woocommerce-checkout-block .checkout-summary{
	width: 30%;
}

.woocommerce-checkout-block .order-summary-block{
	width: 100%;
    position: relative;
    right: unset;
}

.checkoutBlocks .woocommerce-shipping-fields__field-wrapper,
.checkoutBlocks .woocommerce-billing-fields__field-wrapper{
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
}

.checkoutBlocks .form-row{
	width: calc(50% - 10px);

}

.checkoutBlocks .form-row label{
	display: none;
	
}

#qodef-woo-page.qodef--checkout .woocommerce-checkout-block #order_review_heading{
	margin-bottom: 20px !important;
}

#qodef-woo-page.qodef--checkout .woocommerce-checkout-block .woocommerce-checkout-review-order .product-quantity{
	display: none;
}

#billing_email_field{
	display:none;
}

.wrap-form{
	display: flex;
	flex-wrap: wrap;
}

.wrap-form .back-container{
	width: 60px;
	position: relative;
}

.wrap-form .back-container .stepBack{
	position: relative;
}

.wrap-form .form-checkout-block{
	width : calc(100% - 60px);
}

#qodef-woo-page.qodef--checkout .wrap-form .form-checkout-block .woocommerce-checkout{
	margin-top: 0;
}

.wc_payment_method .wc-stripe-card-icons-container{
	display: none ;
}
</style>