<?php
class currency_tooltipControllerWcu extends controllerWcu {
	public function getPermissions() {
		return array(
			WCU_USERLEVELS => array(
				WCU_ADMIN => array('activate', 'dismissNotice')
			),
		);
	}
}
