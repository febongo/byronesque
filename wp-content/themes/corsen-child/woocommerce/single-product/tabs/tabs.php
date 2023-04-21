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

$letter_of_authenticity = get_field("letter_of_authenticity");

if ( $total_sold && $letter_of_authenticity && $letter_of_authenticity["authenticity_note"] && $letter_of_authenticity["authenticity_information"]) {
	echo "<div class='authenticity_note'>".$letter_of_authenticity["authenticity_note"]."</div>";
	echo "<div class='authenticity_note_pop'><div class='overlay authenticity_note_pop_close'></div><div class='auth-content-wrap'><span class='authenticity_note_pop_close'>x</span>".$letter_of_authenticity["authenticity_information"]."</div></div>";
}

?>

<div class="woocommerce-tabs wc-tabs-wrapper">
	<div class="accordion" id="productDescription">	

		
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
		<div class="card">
			<div class="card-header" id="headingByroSay">
				<p class="mb-0" data-toggle="collapse" data-target="#productDescriptionByroSay" aria-expanded="true" aria-controls="productDescriptionByroSay">
					Byronesque says
				</p>
			</div>

			<div id="productDescriptionByroSay" class="collapse" aria-labelledby="headingByroSay" data-parent="#productDescriptionByroSay">
				<div class="card-body">
				<?= $byronesque_say ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<!-- MADE IN  -->
		<?php if ($product_details) : ?>
		<div class="card">
			<div class="card-header" id="headingMadeIn">
				<p class="mb-0" data-toggle="collapse" data-target="#productDescriptionMadeIn" aria-expanded="true" aria-controls="productDescriptionMadeIn">
					Product details
				</p>
			</div>

			<div id="productDescriptionMadeIn" class="collapse" aria-labelledby="headingMadeIn" data-parent="#productDescriptionMadeIn">
				<div class="card-body">
				<?= $product_details ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<!-- MADE FROM  -->
		<?php if ($measurements) : ?>
		<div class="card">
			<div class="card-header" id="headingMadeFrom">
				<p class="mb-0" data-toggle="collapse" data-target="#productDescriptionMadeFrom" aria-expanded="true" aria-controls="productDescriptionMadeFrom">
					Measurements
				</p>
			</div>

			<div id="productDescriptionMadeFrom" class="collapse" aria-labelledby="headingMadeFrom" data-parent="#productDescriptionMadeFrom">
				<div class="card-body">
				<?= $measurements ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<!-- Condition and care notes  -->
		<?php if ($condition_and_) : ?>
		<div class="card">
			<div class="card-header" id="headingCondition">
				<p class="mb-0" data-toggle="collapse" data-target="#productDescriptionCondition" aria-expanded="true" aria-controls="productDescriptionCondition">
				Condition and care notes
				</p>
			</div>

			<div id="productDescriptionCondition" class="collapse" aria-labelledby="headingCondition" data-parent="#productDescriptionCondition">
				<div class="card-body">
				<?= $condition_and_ ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<!-- shipping_and_return_policy  -->
		<?php if ($shipping_and_return_policy) : ?>
		<div class="card">
			<div class="card-header" id="headingShipping">
				<p class="mb-0" data-toggle="collapse" data-target="#productDescriptionShipping" aria-expanded="true" aria-controls="productDescriptionShipping">
					Shipping & returns policy
				</p>
			</div>

			<div id="productDescriptionShipping" class="collapse" aria-labelledby="headingShipping" data-parent="#productDescriptionShipping">
				<div class="card-body">
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



<script>
jQuery(document).ready(function($) {
  $('.accordion .card-header').click(function() {
	$(".accordion .card").removeClass("open")
	$(this).parent().toggleClass('open');

  });

  $(".open-auth-note").click(function(){
	  $(".authenticity_note_pop").css("display","flex");
  });

  $(".authenticity_note_pop_close").click(function(){
	  $(".authenticity_note_pop").css("display","none");
  });
});
</script>

<style>
.accordion .card-header {
  cursor: pointer;
}
.accordion .card-body {
  display: none;
  height: 0px;
  overflow: hidden;
  transition: height 1s;
}
.accordion .open .card-header {
  border-bottom: none;
}

.accordion .open .card-body {
  display: block !important;
  height: auto;
}

.single-product .product_meta{
	display: none;
}

.authenticity_note_pop{
	position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
	padding: 0;
	padding-right:0 !important;
    display: none;
    align-items: center;
    justify-content: center;
	z-index: 11;
	
}

.authenticity_note_pop .overlay{
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    position: absolute;
    top: 0;
    left: 0;
}

.authenticity_note_pop .auth-content-wrap{
	max-width: 567px;
    background: #fff;
    padding: 40px;
    z-index: 9999;
    position: relative;
}
</style>
