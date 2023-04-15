<?php

$params = array_merge( $params, corsen_core_vertical_split_slider_generate_template_params( $item ) );

// include content title
corsen_core_template_part( 'shortcodes/vertical-split-slider', 'templates/parts/title', '', $params );

// include content text
corsen_core_template_part( 'shortcodes/vertical-split-slider', 'templates/parts/text', '', $params );

// include content button
corsen_core_template_part( 'shortcodes/vertical-split-slider', 'templates/parts/button', '', $params );
