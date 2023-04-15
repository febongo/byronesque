<?php

include_once CORSEN_CORE_INC_PATH . '/search/class-corsencore-search.php';
include_once CORSEN_CORE_INC_PATH . '/search/helper.php';
include_once CORSEN_CORE_INC_PATH . '/search/dashboard/admin/search-options.php';

foreach ( glob( CORSEN_CORE_INC_PATH . '/search/layouts/*/include.php' ) as $layout ) {
	include_once $layout;
}
