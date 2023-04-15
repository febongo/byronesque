<div <?php wc_product_cat_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
			<?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/image', '', $params ); ?>
			<div class="woocommerce-loop-category__title-holder">
                <?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-category-list', 'templates/post-info/title', '', $params ); ?>
                <a class="button product_type_simple add_to_cart_button ajax_add_to_cart" href="<?php echo get_term_link( $category_slug, 'product_cat' ); ?>">shop collection</a>
            </div>
	</div>
</div>
