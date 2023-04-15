<?php

$params = array_merge( $params, corsen_core_vertical_split_slider_generate_template_params( $item ) );

// include content product
corsen_core_template_part( 'shortcodes/vertical-split-slider', 'templates/parts/product', '', $params );

// include content product background image
corsen_core_template_part( 'shortcodes/vertical-split-slider', 'templates/parts/product-image', '', $params );
