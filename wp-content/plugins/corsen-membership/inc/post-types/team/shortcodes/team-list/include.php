<?php

include_once CORSEN_CORE_CPT_PATH . '/team/shortcodes/team-list/class-corsencore-team-list-shortcode.php';

foreach ( glob( CORSEN_CORE_CPT_PATH . '/team/shortcodes/team-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
