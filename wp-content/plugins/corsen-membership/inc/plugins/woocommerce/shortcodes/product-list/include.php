<?php

include_once CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/class-corsencore-product-list-shortcode.php';
include_once CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/helper.php';

foreach ( glob( CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
