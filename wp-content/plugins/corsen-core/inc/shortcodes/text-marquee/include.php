<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/text-marquee/class-corsencore-text-marquee-shortcode.php';

foreach ( glob( CORSEN_CORE_INC_PATH . '/shortcodes/text-marquee/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
