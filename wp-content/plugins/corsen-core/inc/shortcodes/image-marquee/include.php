<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/image-marquee/class-corsencore-image-marquee-shortcode.php';

foreach ( glob( CORSEN_CORE_INC_PATH . '/shortcodes/image-marquee/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
