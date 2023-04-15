<?php

class custom_symbolsViewWcu extends viewWcu {
	public function getCustomSymbolInput($currName) {
		$model = $this->getModel();
		$currensyUserSymbols = $model->getCurrencyUserSymbols();
		$this->assign('currName', $currName[1]);
		$this->assign('currenciesSymbols', $this->getModel()->getCurrencyUserSymbols());
		$this->assign('dbPrefixSymbols', $this->getModule()->currencyDbOptSymbols);
		parent::display('customSymbolInput');
	}
}
