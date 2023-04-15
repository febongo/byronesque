<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/banner/class-corsencore-banner-shortcode.php';

foreach ( glob( CORSEN_CORE_INC_PATH . '/shortcodes/banner/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
