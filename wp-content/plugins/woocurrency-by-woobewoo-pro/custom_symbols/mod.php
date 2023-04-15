<?php

class custom_symbolsWcu extends moduleWcu {

	public $currencyDbOptSymbols = 'wcu_currencies_symbols';
	public $currencyModule;
	public $currencySymbols = array();
	public $currencyUserSymbols = array();

	public function init() {
		parent::init();
		dispatcherWcu::addAction('customSymbols', array($this->getView(), 'getCustomSymbolInput'), 10, 1);
		frameWcu::_()->addScript('admin.custom_symbols', $this->getModPath() . 'js/admin.custom_symbols.js', array('jquery'));
	}

}
