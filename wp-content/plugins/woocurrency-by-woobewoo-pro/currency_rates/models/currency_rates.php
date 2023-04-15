<?php

class currency_ratesModelWcu extends modelWcu {
    public function getCurrencyRatesSettings() {
        $currencyRatesSettings = get_option($this->getModule()->currencyDbOpt, array());
        return $currencyRatesSettings;
    }
}
