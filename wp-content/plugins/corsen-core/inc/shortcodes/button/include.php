<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/button/class-corsencore-button-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/button/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
