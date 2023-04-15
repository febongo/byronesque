<?php
class options_proViewWcu extends viewWcu
{
    public function displaySimpleDropdown($currencies, $currentCurrency, $designTab, $displayRulesTab, $prepareParams, $isShortcode = false, $mode = '') {
        frameWcu::_()->addStyle('switcher.simple.dropdown', $this->getModule()->getModPath() . 'css/switcher.simple.dropdown.css');
        frameWcu::_()->addScript('frontend.switcher', frameWcu::_()->getModule('currency_switcher')->getModPath() . 'js/frontend.switcher.js');
        $this->assign('currencies', $currencies);
        $this->assign('currentCurrency', $currentCurrency);
        $this->assign('designTab', $designTab);
        $this->assign('displayRulesTab', $displayRulesTab);
        $this->assign('optionsParams', $prepareParams);
        $this->assign('optionsParams', $prepareParams);
        $this->assign('isShortcode', $isShortcode );
        $this->assign('mode', $mode );
        return parent::getContent('switcherSimpleDropdown');
    }
    
    public function getAfterPointOption($params) {
	    $this->assign('params', $params);
	    $this->assign('defAfterPoint', frameWcu::_()->getModule('currency')->priceNumDecimals);
	    $this->assign('options', $this->getModule()->getCurrencyAfterPointList());
	    $this->assign('dbPrefix', frameWcu::_()->getModule('currency')->currencyDbOpt);
	    parent::display('afterPointOption');
    }
	
	public function getExchangeFeeOption($params) {
		$this->assign('params', $params);
		$this->assign('options', $this->getModule()->getCurrencyExchangeFeeSignList());
		$this->assign('dbPrefix', frameWcu::_()->getModule('currency')->currencyDbOpt);
		parent::display('exchangeFeeOption');
	}
	
	public function getPopupMessage($params) {
		$countryCode = frameWcu::_()->getModule('geoip_rules')->getUserCountryCode();
		$countryList = frameWcu::_()->getModule('geoip_rules')->getCountryNameList();
		$countryName = isset($countryList[$countryCode])
			? $countryList[$countryCode] : $countryCode;
		$this->assign('params', $params);
		$this->assign('countryName', $countryName);
		$this->assign('userCurrency',  frameWcu::_()->getModule('geoip_rules')->getCurrencyCodeByCountry($countryCode));
		$this->assign('currentCurrency', frameWcu::_()->getModule('currency')->getCurrentCurrency());
		parent::display('currencySwitcherPopupMessage');
	}
}
