<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_attr( $data_attr, 'data-options' ); ?>>
	<?php
	// Include global filter from theme
	corsen_core_theme_template_part( 'filter', 'templates/filter', '', $params );
	?>
    <?php if ( 'yes' === $product_list_enable_filter_category || 'yes' === $product_list_enable_filter_order_by ) { ?>
    <div class="qodef-filter-holder">
        <?php
        // Get filter by category part
        corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/filter/category-filter', '', $params );

        // Get filter by order by part
        corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/filter/ordering-filter', '', $params );
        ?>
    </div>
    <?php } ?>
	<ul class="qodef-grid-inner">
        <?php if ( 'masonry' === $params['behavior'] ) { ?>
            <li class="qodef-grid-masonry-sizer"></li>
        <?php } ?>
		<?php
		// Include items
		corsen_core_template_part( 'plugins/woocommerce/shortcodes/product-list', 'templates/loop', '', $params );
		?>
	</ul>
	<?php
	// Include global pagination from theme
	corsen_core_theme_template_part( 'pagination', 'templates/pagination', $params['pagination_type'], $params );
	?>
</div>
