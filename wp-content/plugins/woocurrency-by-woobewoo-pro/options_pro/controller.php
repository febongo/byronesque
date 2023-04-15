<?php
class options_proControllerWcu extends controllerWcu
{
	public function getPermissions() {
		return array(
			WCU_USERLEVELS => array(
				WCU_ADMIN => array('activate', 'dismissNotice')
			),
		);
	}
}
