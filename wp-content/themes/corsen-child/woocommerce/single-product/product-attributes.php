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

ob_start();

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

	<div class="product-size">
		<span class="att_label b2-stressed"><?php echo wc_attribute_label( $attribute['name'] ); ?>: </span>
		<span class="att_value b2"><?php echo $att_val; ?></span><!-- .att_value -->
	</div>

	<?php endforeach; ?>



</div>
<?php
if ( $has_row ) {
	echo ob_get_clean();
} else {
	ob_end_clean();
}
