<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/single-image/class-corsencore-single-image-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/single-image/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
