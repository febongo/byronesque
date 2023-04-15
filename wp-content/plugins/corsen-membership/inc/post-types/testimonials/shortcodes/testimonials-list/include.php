<?php

include_once CORSEN_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/class-corsencore-testimonials-list-shortcode.php';

foreach ( glob( CORSEN_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
