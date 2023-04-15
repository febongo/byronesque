<?php if ( ! empty( $id ) ) : ?>
	<?php
	$product_list_params = array(
		'post_ids'           => $id,
		'posts_per_page'     => '1',
		'behavior'           => 'columns',
		'columns'            => '1',
		'columns_responsive' => 'predefined',
		'space'              => 'no',
		'additional_params'  => 'id',
		'layout'			 => 'info-on-image',
		'enable_border'		 => 'no',
		'hover_border'		 => 'no',
	);

	echo CorsenCore_Product_List_Shortcode::call_shortcode( $product_list_params );

	?>
	<?php
endif;
