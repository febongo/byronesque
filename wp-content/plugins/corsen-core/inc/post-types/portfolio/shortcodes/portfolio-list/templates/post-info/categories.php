<?php
$categories = wp_get_post_terms( get_the_ID(), 'portfolio-category' );

if ( ! empty( $categories ) ) { ?>
	<?php echo get_the_term_list( get_the_ID(), 'portfolio-category', '', '<span class="qodef-info-separator">|</span>' ); ?>
<?php } ?>
