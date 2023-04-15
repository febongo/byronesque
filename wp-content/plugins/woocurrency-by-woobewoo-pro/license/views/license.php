<?php
class licenseViewWcu extends viewWcu {
	public function getTabContent() {
		frameWcu::_()->addScript('admin.license', $this->getModule()->getModPath(). 'js/admin.license.js');
		frameWcu::_()->getModule('templates')->loadJqueryUi();
		$this->assign('credentials', $this->getModel()->getCredentials());
		$this->assign('isActive', $this->getModel()->isActive());
		$this->assign('isExpired', $this->getModel()->isExpired());
		$this->assign('extendUrl', $this->getModel()->getExtendUrl());
		return parent::getContent('licenseAdmin');
	}
}
