<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 */

// Instead of showing the attributes in a left-right table,
// we show them as columns with the name above each value.


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$has_row    = false;
$attributes = $product->get_attributes();

// $vendor = get_the_terms($product_id, 'dc_vendor_shop');

?>

<?php
// show location
//  $locationTerm = get_the_terms($product->get_id(), 'location');
//  $locationArr=[];

//  foreach($locationTerm as $locTerms){
// 	$locationArr[] = $locTerms->name; 
//  }

 $hasSize=false;
?>

<div class="product_attributes">

	<?php foreach ( $attributes as $attribute ) :

		if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) 
			continue;

		$values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) );
		$att_val = apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

		if( empty( $att_val ) )
			continue;

		$has_row = true;
		?>

		<?php if ( strtolower($attribute['name']) == "pa_size") : $hasSize=true;?>
			<div class="product-size">
				<span class="att_label b2-stressed"><?php echo wc_attribute_label( $attribute['name'] ); ?>: </span>
				<span class="att_value b2"><?php echo $att_val; ?></span><!-- .att_value -->
			</div>
		<?php endif; ?>

	<?php endforeach; ?>

	<?php //if($vendor && count($vendor) > 0) : ?>
		<!-- <div class="product-shipsfrom">
			<span class="att_label b2-stressed">Ships From: </span>
			<span class="att_value b2"><?= $vendor[0]->name ?></span>
		</div> -->
	<?php //endif; ?>

</div>

<?php if( !$hasSize ) : ?>
	<p class="size-info">Please see description for sizes.</p>
<?php endif; ?>