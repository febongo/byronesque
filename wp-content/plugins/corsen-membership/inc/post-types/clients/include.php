<?php

include_once CORSEN_CORE_CPT_PATH . '/clients/helper.php';

foreach ( glob( CORSEN_CORE_CPT_PATH . '/clients/dashboard/meta-box/*.php' ) as $module ) {
	include_once $module;
}
