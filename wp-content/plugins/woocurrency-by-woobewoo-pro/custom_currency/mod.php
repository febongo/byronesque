<?php

class custom_currencyWcu extends moduleWcu {

	public $dbPrefix = 'wcu_options_pro';
	public $optionsPro;

	public function init() {
		parent::init();
		$this->optionsPro = frameWcu::_()->getModule('options_pro')->getModel()->getOptionsPro();
		dispatcherWcu::addAction('wcuCustomCurrency', array($this->getView(), 'getCustomCurrenciesList'), 10, 2);
	}



}
