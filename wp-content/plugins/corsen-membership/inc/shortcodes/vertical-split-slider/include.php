<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/vertical-split-slider/helper.php';
include_once CORSEN_CORE_SHORTCODES_PATH . '/vertical-split-slider/class-corsencore-vertical-split-slider-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/vertical-split-slider/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
