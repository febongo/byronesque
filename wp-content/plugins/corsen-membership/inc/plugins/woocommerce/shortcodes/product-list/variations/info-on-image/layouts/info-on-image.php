<li <?php wc_product_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="qodef-woo-product-image">
				<?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/mark' ); ?>
				<?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/image', '', $params ); ?>
                <?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/image-hover', '', $params ); ?>
                <div class="qodef-woo-product-image-inner">
                    <div class="qodef-woo-info-holder">
                        <?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/title', '', $params ); ?>
                        <?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/price', '', $params ); ?>
                        <?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/add-to-cart' ); ?>
                    </div>
					<?php
					// Hook to include additional content inside product list item content
					do_action( 'corsen_core_action_product_list_item_additional_content' );

					// Hook to include additional content inside product list item image
					do_action( 'corsen_core_action_product_list_item_additional_image_content' );
					?>
				</div>
				<?php corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/post-info/link' ); ?>
			</div>
		<?php } ?>
	</div>
</li>
