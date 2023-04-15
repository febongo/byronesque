<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/item-showcase/class-corsencore-item-showcase-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/item-showcase/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
