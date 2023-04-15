<?php

class custom_cssModelWcu extends modelWcu {

    public function getCustomCssSettings() {
        $customCssSettings = get_option($this->getModule()->currencyDbOpt, array());
        return $customCssSettings;
    }

}
