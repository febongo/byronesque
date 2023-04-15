<?php

include_once CORSEN_CORE_SHORTCODES_PATH . '/interactive-link-showcase/class-corsencore-interactive-link-showcase-shortcode.php';

foreach ( glob( CORSEN_CORE_SHORTCODES_PATH . '/interactive-link-showcase/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
