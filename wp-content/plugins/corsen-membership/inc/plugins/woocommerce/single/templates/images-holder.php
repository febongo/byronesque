<?php $columns_number = $columns ?? 1; ?>
<div class="woocommerce-product-gallery qodef-grid qodef-layout--columns qodef-gutter--no qodef-col-num--<?php echo esc_attr( $columns_number ); ?>">
	<div class="qodef-grid-inner clear">
		<?php do_action( 'corsen_core_action_woo_single_product_gallery_images' ); ?>
	</div>
</div>
