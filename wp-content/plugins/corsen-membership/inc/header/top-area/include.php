<?php

include_once CORSEN_CORE_INC_PATH . '/header/top-area/class-corsencore-top-area.php';
include_once CORSEN_CORE_INC_PATH . '/header/top-area/helper.php';

foreach ( glob( CORSEN_CORE_INC_PATH . '/header/top-area/dashboard/*/*.php' ) as $dashboard ) {
	include_once $dashboard;
}
