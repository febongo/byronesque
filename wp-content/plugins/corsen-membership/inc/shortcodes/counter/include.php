<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/counter/class-corsencore-counter-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/counter/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
