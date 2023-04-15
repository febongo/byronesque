<?php if ( ! empty( $product_image ) ) : ?>
	<div class="qodef-m-product-image">
		<?php echo wp_get_attachment_image( $product_image, 'full' ); ?>
	</div>
<?php endif; ?>
