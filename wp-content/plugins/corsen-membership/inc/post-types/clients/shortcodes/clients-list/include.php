<?php

include_once CORSEN_CORE_CPT_PATH . '/clients/shortcodes/clients-list/class-corsencore-clients-list-shortcode.php';

foreach ( glob( CORSEN_CORE_CPT_PATH . '/clients/shortcodes/clients-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
