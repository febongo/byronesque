<?php
$portfolio_list_image = get_post_meta( get_the_ID(), 'qodef_portfolio_list_image', true );
$has_image            = ! empty( $portfolio_list_image ) || has_post_thumbnail();

if ( $has_image ) {
	$portfolio_url       = corsen_core_get_portfolio_list_item_url( get_the_ID() );
	$image_dimension     = isset( $image_dimension ) && ! empty( $image_dimension ) ? esc_attr( $image_dimension['size'] ) : 'full';
	$custom_image_width  = isset( $custom_image_width ) && '' !== $custom_image_width ? intval( $custom_image_width ) : 0;
	$custom_image_height = isset( $custom_image_height ) && '' !== $custom_image_height ? intval( $custom_image_height ) : 0;
	?>
	<div class="qodef-e-media-image">
		<a itemprop="url" href="<?php echo esc_url( $portfolio_url['link'] ); ?>" target="<?php echo esc_attr( $portfolio_url['target'] ); ?>">
			<?php echo corsen_core_get_list_shortcode_item_image( $image_dimension, $portfolio_list_image, $custom_image_width, $custom_image_height ); ?>
		</a>
	</div>
<?php } ?>
