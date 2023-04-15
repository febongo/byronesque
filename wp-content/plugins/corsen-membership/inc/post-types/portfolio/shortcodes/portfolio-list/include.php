<?php

include_once CORSEN_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/helper.php';
include_once CORSEN_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/class-corsencore-portfolio-list-shortcode.php';

foreach ( glob( CORSEN_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
