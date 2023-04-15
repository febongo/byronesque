<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/image-with-text/class-corsencore-image-with-text-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/image-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
