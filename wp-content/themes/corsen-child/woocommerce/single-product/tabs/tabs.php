<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

$total_sold = get_post_meta(get_the_ID(),'total_sales', true);

$loa_details = get_field("loa_details");
$click_through_details = get_field("click_through_details");

if ( $loa_details && $click_through_details ) {
	echo "<div class='authenticity_note'>".$loa_details."</div>";
	echo "<div class='authenticity_note_pop'><div class='overlay authenticity_note_pop_close'></div><div class='auth-content-wrap'><span class='authenticity_note_pop_close'>x</span>".$click_through_details."</div></div>";
}

?>

<div class="woocommerce-tabs wc-tabs-wrapper">
	<div class="accordion accordion-flush" id="productDescription">	

		
		<?php 
			$byronesque_say = get_field("byronesque_say");
			$product_details = get_field("made_in");
			$measurements = get_field("measurements");
			$condition_and_ = get_field("condition_and_");
			$shipping_and_return_policy = get_field("shipping_and_return_policy");
			$ref = get_field("ref");
			$runaway_photo_credit = get_field("runaway_photo_credit");
		?>
		<!-- BYRONESQUE SAYS  -->
		<?php if ($byronesque_say) : ?>


			<div class="accordion-item" id="productDescriptionByroSayLabel">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#productDescriptionByroSay" aria-expanded="true" aria-controls="productDescriptionByroSay">
					In Our Opinion
					</button>
				</h2>
				<div id="productDescriptionByroSay" class="accordion-collapse collapse" aria-labelledby="productDescriptionByroSayLabel" data-bs-parent="#productDescription">
					<div class="accordion-body">
					<?= $byronesque_say ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- MADE IN  -->
		<?php if (true) : ?>
			<div class="accordion-item">
				<h2 class="accordion-header" id="productDescriptionMadeInlabel">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#productDescriptionMadeIn" aria-expanded="true" aria-controls="productDescriptionMadeIn">
					Product details
					</button>
				</h2>
				<div id="productDescriptionMadeIn" class="accordion-collapse collapse" aria-labelledby="productDescriptionMadeInlabel" data-bs-parent="#productDescription">
					<div class="accordion-body">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- MADE FROM  -->
		<?php if ($measurements) : ?>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#productDescriptionMadeFrom" aria-expanded="true" aria-controls="productDescriptionMadeFrom">
					Measurements
					</button>
				</h2>
				<div id="productDescriptionMadeFrom" class="accordion-collapse collapse" aria-labelledby="productDescriptionMadeFrom" data-bs-parent="#productDescription">
					<div class="accordion-body">
					<?= $measurements ?>
					</div>
				</div>
			</div>

		<?php endif; ?>

		<!-- Condition and care notes  -->
		<?php if ($condition_and_) : ?>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#productDescriptionCondition" aria-expanded="true" aria-controls="productDescriptionCondition">
					Condition and care notes
					</button>
				</h2>
				<div id="productDescriptionCondition" class="accordion-collapse collapse" aria-labelledby="productDescriptionCondition" data-bs-parent="#productDescription">
					<div class="accordion-body">
					<?= $condition_and_ ?>
					</div>
				</div>
			</div>

		<?php endif; ?>

		<!-- shipping_and_return_policy  -->
		<?php if ($shipping_and_return_policy) : ?>
			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#productDescriptionShipping" aria-expanded="true" aria-controls="productDescriptionShipping">
					Shipping & returns policy
					</button>
				</h2>
				<div id="productDescriptionShipping" class="accordion-collapse collapse" aria-labelledby="productDescriptionShipping" data-bs-parent="#productDescription">
					<div class="accordion-body">
					<?= $shipping_and_return_policy ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		

		<?php if ( ! empty( $product_tabs ) && false ) : ?>
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<div class="card">
					<div class="card-header" id="heading-<?= $key ?>">
						<h5 class="mb-0" data-toggle="collapse" data-target="#productDescription<?= $key ?>" aria-expanded="true" aria-controls="productDescription<?= $key ?>">
				
							<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
						
						</h5>
					</div>

					<div id="productDescription<?= $key ?>" class="collapse" aria-labelledby="heading-<?= $key ?>" data-parent="#productDescription">
						<div class="card-body">

						<?php
						if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab );
						}
						?>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
		<?php endif; ?>

	</div>

</div>
<?php do_action( 'woocommerce_product_after_tabs' ); ?>


<!-- ref  -->
<?php if ($ref) : ?>
<div class="product-ref">Ref: <?= $ref ?></div>
<?php endif; ?>

<!-- ref  -->
<?php if ($runaway_photo_credit) : ?>
<div class="product-ref">Runway photo credit: <?= $runaway_photo_credit ?></div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
.accordion-button:not(.collapsed){
	background-color: #000;
	color: #fff;
}
.accordion-button:focus{
	border: none;
	box-shadow: none;
}
</style>
