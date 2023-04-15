<?php if ( ! empty( $id ) ) : ?>
	<?php
	$testimonials_list_params = array(
		'post_ids'           => $id,
		'skin'               => $skin,
		'posts_per_page'     => '1',
		'behavior'           => 'columns',
		'columns'            => '1',
		'columns_responsive' => 'predefined',
		'space'              => 'no',
		'additional_params'  => 'id',
	);

	echo CorsenCore_Testimonials_List_Shortcode::call_shortcode( $testimonials_list_params );
	?>
	<?php
endif;
