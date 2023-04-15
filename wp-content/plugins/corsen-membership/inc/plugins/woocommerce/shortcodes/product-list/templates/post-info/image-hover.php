<?php
$product_list_hover_image = get_post_meta( get_the_ID(), 'qodef_product_list_image_hover', true );
$has_image          = ! empty( $product_list_hover_image );

if ( $has_image && 'yes' === $enable_image_hover ) {
	$image_dimension     = isset( $image_dimension ) && ! empty( $image_dimension ) ? esc_attr( $image_dimension['size'] ) : apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
	$custom_image_width  = isset( $custom_image_width ) && '' !== $custom_image_width ? intval( $custom_image_width ) : 0;
	$custom_image_height = isset( $custom_image_height ) && '' !== $custom_image_height ? intval( $custom_image_height ) : 0;
	?>
	<div class="qodef-e-image-hover">
		<?php echo corsen_core_get_list_shortcode_item_image( $image_dimension, $product_list_hover_image, $custom_image_width, $custom_image_height ); ?>
	</div>
<?php } ?>
