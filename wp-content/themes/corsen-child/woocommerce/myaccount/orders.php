<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
<h3>Orders</h3>
<?php if ( $has_orders ) : ?>

	<p>Everything you need to know about your current or previous orders. <br>If you have purchased from one of our brand concession partners, your digital appraisal certificate and any supporting documents are also securely stored here. </p>
	<p>Track your orders, request a return or check your order history</p>

	<?php foreach ( $customer_orders->orders as $customer_order ) : ?>
		<?php 
		$order      			= wc_get_order( $customer_order );
		$item_count 			= $order->get_item_count() - $order->get_item_count_refunded();
		$order_items           	= $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
		$show_purchase_note    	= $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
		?>
		<div style="margin-bottom:10px;" class="myaccount-orderblocks">
			<table>
				<thead>
				<tr class=“order-header”>
					<th style="width:23%" class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Order Date</span> </th>
					<th style="width:23%" class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Order Number</span</th>
					<th style="width:23%" class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Status</span></th>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions"></th>
				</tr>
				</thead>

				<tbody>
					<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order">
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Date">
							<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
						</td>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Order">
							<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
								<?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>
							</a>
						</td>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status" data-title="Status">
							<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
						</td>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions" data-title="Actions">
							<span class="toggle-details" data-details="order-details-<?= $order->get_id() ?>">
								<img class="open-arrow" src="https://vzc.hva.mybluehost.me/wp-content/uploads/2023/05/plus.svg">
								<img class="close-arrow" src="https://vzc.hva.mybluehost.me/wp-content/uploads/2023/05/minus.svg">
							</span>
						</td>											
					</tr>

					<tr class="orders-delivery-info order-detail-contents order-details-<?= $order->get_id() ?>">
						<td colspan="4">One delivery was sent from Paris, France</td>
					</tr>

					<tr class="orders-cart-details order-detail-contents order-details-<?= $order->get_id() ?>">
						<td colspan="4">Cart Details</td>
					</tr>

					<?php foreach ( $order_items as $item_id => $item ) {

						$product = $item->get_product();
						if ($product) :

						// $is_visible        = $product && $product->is_visible();
						$product_permalink = $product->get_permalink( );

						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'single-post-thumbnail' );

					?>
						<tr class="order-detail-contents order-details-<?= $order->get_id() ?>">
							<td class="thumb-image">

								<a href="<?= $product_permalink ?>">
									<img src="<?= $image && count($image) > 0 ? $image[0] : '' ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" >
								</a>
							</td>
							<td colspan="2" class="item-summary">
								<?php
									// $product_id = $item->get_product_id();
									$variation_id = $item->get_variation_id();
									$size;

									if ($variation_id) {
										$variation_data = $item->get_variation_attributes();
										if ($variation_id > 0 && !empty($variation_data)) {
											$size = $variation_data['pa_size']; 
										}
									}
									
								?>
								<span class="product-name"><?= $item->get_name() ?></span>
								<span><?= $product->short_description ?></span>
								<span><?= ($size ? "Size $size" : 'See product description for product sizes.') ?></span>
								<?= $product->get_price_html() ?>
							</td> 
							<td class="item-sumary-links">
								<span><a href="#">Apraisal details</a></span>
								<span><a href="#">Non-returnable</a></span>
							</td>
						</tr>
						<?php endif; ?>
					<?php } ?>
				</tbody>  

				<tfoot class="order-detail-contents order-details-<?= $order->get_id() ?>">
					<?php 
					$totals = $order->get_order_item_totals();
				
					?>
					<tr class="cart-subtotal">
						<th colspan="3" class="b2">Subtotal</th>
						<td><?= wp_kses_post( $totals['cart_subtotal']['value']); ?></td>
					</tr>

					<tr class="shipping-method">
						<th colspan="3"  class="b2"><span id="shippingMethod">Shipping</span></th>
						<td><?= wp_kses_post( $totals['shipping']['value']); ?></td>
					</tr>


					<tr class="tax-total">
						<th colspan="3" class="b2">Tax</th>
						<td><?= wp_kses_post( $totals['tax']['value']); ?></td>
					</tr>				

					<tr class="order-total">
						<th colspan="3" class="b2-stressed">Total</th>
						<td><strong><?= wp_kses_post( $totals['order_total']['value']); ?></strong> </td>
					</tr>
				</tfoot>
			</table>      
			<div class="order-detail-contents order-details-<?= $order->get_id() ?>">
				<p class="shippingTo">Delivery Address</p>
				<div class="order-change-address">
					<!-- <a href="#">Change Address</a> -->
				</div>
				<div class="shippingTo">

					<p class="shippingToDetails">
					<address>
						<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>

						<?php if ( $order->get_shipping_phone() ) : ?>
							<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_shipping_phone() ); ?></p>
						<?php endif; ?>
					</address>
					</p>
					<!-- <p class="shipping-note">If you need to change the delivery address for your order, you can do so before it’s prepared.</p> -->
				</div>
			</div>

		</div>
	
	<?php endforeach; ?>


	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
<div class="woocommerce-myaccount-messageblock">
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">

		
		<!--		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'woocommerce' ); ?></a>
		<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?> -->
		
		
		<p>You don’t have any orders yet. Have a look around and let us know if there’s anything we can help with.</p>
		<p>	You can contact our personal shopping team <a href="/../contact">here</a>.</p>
	</div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>

<style>
	.order-detail-contents{
		display: none;
	}

	.toggle-details .open-arrow{
		display: block;
	}
	.toggle-details .close-arrow{
		display: none;
	}

	.toggle-details.show .open-arrow{
		display: none;
	}
	.toggle-details.show .close-arrow{
		display: block;
	}
</style>

<script>
	jQuery(document).ready(function($){
		$(".toggle-details").click(function(){
			console.log('asd');
			var trId = $(this).attr('data-details')
			if( $(this).hasClass("show") ){
				$(".toggle-details").removeClass("show")

			} else {
				$(".toggle-details").removeClass("show")
				$(this).addClass("show")
				$(".order-detail-contents").removeAttr('style')
			}
			$("."+trId).slideToggle();
		});
	});

</script>
