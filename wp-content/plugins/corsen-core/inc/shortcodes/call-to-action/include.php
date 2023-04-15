<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/call-to-action/class-corsencore-call-to-action-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/call-to-action/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
