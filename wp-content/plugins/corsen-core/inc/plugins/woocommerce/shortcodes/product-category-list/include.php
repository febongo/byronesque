<?php

include_once CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/media-custom-fields.php';
include_once CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/class-corsencore-product-category-list-shortcode.php';

foreach ( glob( CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
