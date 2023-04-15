<?php

class custom_currencyViewWcu extends viewWcu {

	public $dbPrefix = 'wcu_options_pro';

	public function getCustomCurrenciesList($params) {
		$model = $this->getModel();
		$optionsPro =  frameWcu::_()->getModule('options_pro')->getModel()->getOptionsPro();
		$customCurrenciesList = isset($optionsPro['custom_currency']) ? $optionsPro['custom_currency'] : array();
		$this->assign('customCurrenciesList', $customCurrenciesList);
		$this->assign('dbPrefix', $this->dbPrefix);
		parent::display('customCurrency');
	}


}
