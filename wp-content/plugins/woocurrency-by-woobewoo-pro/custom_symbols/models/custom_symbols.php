<?php

class custom_symbolsModelWcu extends modelWcu {

	public function saveCurrenciesSymbols($currenciesSymbols) {
		$currenciesFilteredArray = array();
		if ($currenciesSymbols) {
			foreach ( $currenciesSymbols as $currencyTitle => $currencyValue ) {
				if ( $currencyValue && !empty($currencyValue) && $currencyValue !== 0 ) {
					$currenciesFilteredArray[$currencyTitle] = $currencyValue;
				}
			}
		}
		return update_option($this->getModule()->currencyDbOptSymbols, $currenciesFilteredArray);
	}

	public function getCurrencyUserSymbols() {
			$currencies = get_option($this->getModule()->currencyDbOptSymbols, array());
			return $currencies;
	}

}
