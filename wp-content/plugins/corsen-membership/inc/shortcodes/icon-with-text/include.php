<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/icon-with-text/class-corsencore-icon-with-text-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/icon-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
