<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/pricing-table/class-corsencore-pricing-table-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/pricing-table/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
