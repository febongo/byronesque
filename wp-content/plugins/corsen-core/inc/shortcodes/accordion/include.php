<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/accordion/class-corsencore-accordion-shortcode.php';
include_once CORSEN_CORE_SHORTCODES_PATH . '/accordion/class-corsencore-accordion-child-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/accordion/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
