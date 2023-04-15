<?php

include_once CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list-indent-slider/class-corsencore-product-list-indent-slider-shortcode.php';
include_once CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list-indent-slider/helper.php';

foreach ( glob( CORSEN_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list-indent-slider/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
