<?php

include_once CORSEN_CORE_INC_PATH . '/blog/shortcodes/blog-list/class-corsencore-blog-list-shortcode.php';

foreach ( glob( CORSEN_CORE_INC_PATH . '/blog/shortcodes/blog-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
