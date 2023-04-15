<?php
class licenseControllerWcu extends controllerWcu {
	public function activate() {
		$res = new responseWcu();
		if($this->getModel()->activate(reqWcu::get('post'))) {
			$res->addMessage(__('Done', WCU_LANG_CODE));
		} else
			$res->pushError ($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function dismissNotice() {
		$res = new responseWcu();
		frameWcu::_()->getModule('options')->getModel()->save('dismiss_pro_opt', 1);
		$res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			WCU_USERLEVELS => array(
				WCU_ADMIN => array('activate', 'dismissNotice')
			),
		);
	}
}

