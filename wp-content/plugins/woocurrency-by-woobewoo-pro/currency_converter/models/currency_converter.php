<?php

class currency_converterModelWcu extends modelWcu {

    public function getCurrecnyConverterSettings() {
        $currencyConverterSettings = get_option($this->getModule()->currencyDbOpt, array());
        return $currencyConverterSettings;
    }

}
