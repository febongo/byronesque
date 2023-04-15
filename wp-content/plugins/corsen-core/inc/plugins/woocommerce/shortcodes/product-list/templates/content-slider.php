<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
	<div class="swiper-wrapper">
		<?php
		// Include items
		corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/loop', '', $params );
		?>
	</div>
	<?php corsen_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
	<?php corsen_core_template_part( 'content', 'templates/swiper-pag', '', $params ); ?>
</div>
