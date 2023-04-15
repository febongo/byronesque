<?php

class geoip_rulesViewWcu extends viewWcu {

	public function getGeoIpRulesTab() {
		$model = $this->getModel();
		$currencyList = frameWcu::_()->getModule('currency')->getModel()->getCurrencies();
		$currencyCountryListArr = $this->getModule()->getCurrencyCountryList();
	    $getCountryNameListArr = $this->getModule()->getCountryNameList();
	    $currencySymbolsArr = frameWcu::_()->getModule('currency')->getCurrencySymbols();
		$optionsPro =  frameWcu::_()->getModule('options_pro')->getModel()->getOptionsPro();

		$this->assign('currencyList', $currencyList);
		$this->assign('currencyCountryListArr', $currencyCountryListArr);
		$this->assign('getCountryNameListArr', $getCountryNameListArr);
		$this->assign('currencySymbolsArr', $currencySymbolsArr);
		$this->assign('optionsPro', $optionsPro);
		$this->assign('dbPrefix', frameWcu::_()->getModule('options_pro')->optionsDbOptPro);

		parent::display('geoIpRules');
	}

}
