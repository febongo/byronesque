<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/tabs/class-corsencore-tab-shortcode.php';
include_once CORSEN_CORE_SHORTCODES_PATH . '/tabs/class-corsencore-tab-child-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/tabs/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
