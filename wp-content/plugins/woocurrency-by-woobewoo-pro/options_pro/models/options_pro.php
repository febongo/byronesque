<?php
class options_proModelWcu extends modelWcu
{
	public function getOptionsPro() {
		$options = get_option($this->getModule()->optionsDbOptPro, array());
		if(empty($options) || !is_array($options)) {
			$options = frameWcu::_()->getModule('currency')->getDefaultOptions();
		}
		return $options;
	}
    public function saveOptionsProParams($optionsPro) {

		$flags = isset($optionsPro['flags']) ? $optionsPro['flags'] : array();
		$flagsList = array();
		if(!empty($flags['title'])) {
			foreach($flags['title'] as $key => $name) {
				$flagsList[$name] = isset($flags['image'][$key]) ? $flags['image'][$key] : '';
			}
		}
		$optionsPro['flags'] = $flagsList;

		$customCurrencies = isset($optionsPro['custom_currency']) ? $optionsPro['custom_currency'] : array();
		$customCurrenciesList = array();
		if(!empty($customCurrencies['code'])) {
			foreach($customCurrencies['code'] as $key => $name) {
				$name = frameWcu::_()->getModule('currency')->wcuTranslit($name);
				$customCurrenciesList[$name] = isset($customCurrencies['symbol'][$key]) ? $customCurrencies['symbol'][$key] : '';
			}
		}
		$optionsPro['custom_currency'] = $customCurrenciesList;

        return update_option($this->getModule()->optionsDbOptPro, $optionsPro);
    }
}
