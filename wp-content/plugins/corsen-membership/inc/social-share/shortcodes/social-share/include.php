<?php

include_once CORSEN_CORE_INC_PATH . '/social-share/shortcodes/social-share/class-corsencore-social-share-shortcode.php';

foreach ( glob( CORSEN_CORE_INC_PATH . '/social-share/shortcodes/social-share/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
