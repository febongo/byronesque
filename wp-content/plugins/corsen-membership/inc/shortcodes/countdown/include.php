<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/countdown/class-corsencore-countdown-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/countdown/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
