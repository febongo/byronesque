<?php

class currency_tooltipModelWcu extends modelWcu {
    public function getTootlipSettings() {
        $tooltipSettings = get_option($this->getModule()->currencyDbOpt, array());
        return $tooltipSettings;
    }
}
