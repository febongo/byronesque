<?php

class flagsModelWcu extends modelWcu {
    public function getCustomCssSettings() {
        $customCssSettings = get_option($this->getModule()->currencyDbOpt, array());
        return $customCssSettings;
    }

}
