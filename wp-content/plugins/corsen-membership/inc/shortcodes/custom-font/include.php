<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/custom-font/class-corsencore-custom-font-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/custom-font/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
