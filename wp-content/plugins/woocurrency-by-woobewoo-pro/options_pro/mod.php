<?php
class options_proWcu extends moduleWcu
{
    public $optionsDbOptPro = 'wcu_options_pro';
    public function init() {
        parent::init();
	    dispatcherWcu::addAction('afterPointOption', array($this->getView(), 'getAfterPointOption'), 10, 1);
	    dispatcherWcu::addAction('exchangeFeeOption', array($this->getView(), 'getExchangeFeeOption'), 10, 1);
	    dispatcherWcu::addAction('beforeCurrencySwitcherList', array($this->getView(), 'getPopupMessage'), 10, 1);
	    dispatcherWcu::addAction('getProShowPopupSwitcherMessage', array($this, 'getProShowPopupSwitcherMessage'), 10, 1);
    }
    public function getProModuleDefaultOptions() {
        $currencyTooltip = frameWcu::_()->getModule('currency_tooltip');
		$currencyConverter = frameWcu::_()->getModule('currency_converter');
		$currencyRates = frameWcu::_()->getModule('currency_rates');
        $customCss = frameWcu::_()->getModule('custom_css');
        $geoIpRules = frameWcu::_()->getModule('geoip_rules');
        $manualPrices = frameWcu::_()->getModule('manual_prices');
        return array(
            'currency_tooltip' => ($currencyTooltip) ?  frameWcu::_()->getModule('currency_tooltip')->getDefaultOptions() : array(),
			'currency_converter' => ($currencyConverter) ?  frameWcu::_()->getModule('currency_converter')->getDefaultOptions() : array(),
			'currency_rates' => ($currencyRates) ?  frameWcu::_()->getModule('currency_rates')->getDefaultOptions() : array(),
			'custom_css' => ($customCss) ?  frameWcu::_()->getModule('custom_css')->getDefaultOptions() : array(),
            'geoip_rules' => ($geoIpRules) ?  frameWcu::_()->getModule('geoip_rules')->getDefaultOptions() : array(),
            'manual_prices' => ($manualPrices) ?  frameWcu::_()->getModule('manual_prices')->getDefaultOptions() : array(),
        );
    }
    public function getProModuleOptionsParams() {
        $currencyTooltip = frameWcu::_()->getModule('currency_tooltip');
		$currencyConverter = frameWcu::_()->getModule('currency_converter');
		$currencyRates = frameWcu::_()->getModule('currency_rates');
		$customCss = frameWcu::_()->getModule('custom_css');
        $geoIpRules = frameWcu::_()->getModule('geoip_rules');
        $manualPrices = frameWcu::_()->getModule('manual_prices');
        return array(
			'currency_tooltip' => ($currencyTooltip) ?  frameWcu::_()->getModule('currency_tooltip')->getOptionsParams() : array(),
			'currency_converter' => ($currencyConverter) ?  frameWcu::_()->getModule('currency_converter')->getOptionsParams() : array(),
			'currency_rates' => ($currencyRates) ?  frameWcu::_()->getModule('currency_rates')->getOptionsParams() : array(),
			'custom_css' => ($customCss) ? frameWcu::_()->getModule('custom_css')->getOptionsParams() : array(),
            'geoip_rules' => ($geoIpRules) ? frameWcu::_()->getModule('geoip_rules')->getOptionsParams() : array(),
            'manual_prices' => ($manualPrices) ? frameWcu::_()->getModule('manual_prices')->getOptionsParams() : array(),
        );
    }
    public function getSimpleDropdown($currencies, $currentCurrency, $designTab, $displayRulesTab, $prepareParams, $isShortcode = false, $mode = '') {
        return $this->getView()->displaySimpleDropdown($currencies, $currentCurrency, $designTab, $displayRulesTab, $prepareParams, $isShortcode, $mode);
    }
	public function getProCurrencyAgregator() {
        return array(
			'free_converter' => 'Free Converter',
			'currencyapi' => 'Currency Conversion API',
			'cryptocompare' => 'Cryptocompare',
			'ratesapi' => 'RatesAPI',
			'ecb' => 'European Central Bank',
	        'poloniex' => 'Poloniex',
	        'finance_yahoo' => 'Finance Yahoo',
	        'fixer' => 'Fixer',
	        'currencylayer' => 'Currencylayer',
	        'oer' => 'Open Exchange Rates',
	        'cbr' => 'Russian Centrobank',
	        'nbp' => 'Narodowy Bank Polski',
	        'pb' => 'Ukrainian Privatbank',
	        'bnr' => 'National Bank of Romania'
		);
    }
    public function getProCsIconSize() {
        return array(
            'html' => 'radiobuttons',
            'row_classes' => 'wcuSwEnableDesign',
            'row_parent' => 'type',
            'row_show' => 'simple',
            'row_hide' => '',
            'tooltip' => __('Choose icon size for Currency Switcher Simple.', WCU_LANG_CODE),
            'label' => __('Icon size', WCU_LANG_CODE),
            'params' => array(
                'attrs' => 'class="wcuSwitcherRadioLabel"',
                'no_br'	=> true,
                'options' => array(
                    's' => __('S', WCU_LANG_CODE),
                    'm' => __('M', WCU_LANG_CODE),
                    'l' => __('L', WCU_LANG_CODE),
                ),
                'labeled' => array(
                    's' => __('S', WCU_LANG_CODE),
                    'm' => __('M', WCU_LANG_CODE),
                    'l' => __('L', WCU_LANG_CODE),
                ),
            ),
        );
    }
    public function getProCsIconType() {
        return array(
            'html' => 'radiobuttons',
            'row_classes' => 'wcuSwEnableDesign wcuHidden',
            'row_parent' => 'type',
            'row_show' => 'simple',
            'row_hide' => '',
            'tooltip' => __('Choose design of currency switcher blocks.', WCU_LANG_CODE),
            'label' => __('Icon type', WCU_LANG_CODE),
            'params' => array(
                'attrs' => 'class="wcuSwitcherRadioLabel"',
                'no_br'	=> true,
                'options' => array(
                    'rectangular' => __('rectangular', WCU_LANG_CODE),
                    //'circle' => __('circle', WCU_LANG_CODE),
                ),
                'labeled' => array(
                    'rectangular' => __('rectangular', WCU_LANG_CODE),
                    //'circle' => __('circle', WCU_LANG_CODE),
                ),
                'data-target-toggle' => '.wcuSwDisableIconType',
            ),
        );
    }
    public function getProCsDesign() {
        return array(
            'html' => 'selectbox',
            'row_classes' => 'wcuSwEnableDesign',
            'row_parent' => 'type',
            'row_show' => 'simple',
            'row_hide' => '',
            'tooltip' => __('Select design of panel for Currency Switcher Simple.', WCU_LANG_CODE),
            'label' => __('Design', WCU_LANG_CODE),
            'params' => array(
                'options' => array(
                    'Classic' => __('Classic', WCU_LANG_CODE),
                    'Dropdown' => __('Dropdown', WCU_LANG_CODE),
                ),
                'data-target-toggle' => '.wcuSwEnableSwitcher',
            ),
        );
    }
	public function getProShowPopupSwitcherMessage() {
		return array(
			'html' => 'checkboxHiddenVal',
			'row_classes' => '',
			'row_show' => '',
			'row_hide' => '',
			'tooltip' => __('Show popup message "Do you want change currency?". Read more in the <a href="https://woobewoo.com/documentation/currency-switcher-mode/">documentation</a>.', WCU_LANG_CODE),
			'label' => __('Show popup message for switcher', WCU_LANG_CODE),
			'params' => array(
				'value'=>'1',
			),
		);
	}
    public function getProCsFloatingOrder() {
        return array(
            'name' => __('Currency codes', WCU_LANG_CODE),
            'title' => __('Titles', WCU_LANG_CODE),
            'symbol' => __('Currency symbols', WCU_LANG_CODE),
            'rate' => __('Currency rates', WCU_LANG_CODE),
            'flag' => __('Flags', WCU_LANG_CODE),
        );
    }
    public function getProCsFloatingOpeningButton() {
        return array(
            'attrs' => 'class="wcuSwitcherRadioLabel"',
            'no_br'	=> true,
            'options' => array (
                'currency_codes' => __('currency codes', WCU_LANG_CODE),
                'currency_symbols' => __('currency symbols', WCU_LANG_CODE),
                'flags' => __('flags', WCU_LANG_CODE),
                'text' => __('text', WCU_LANG_CODE),
            ),
            'labeled' => array (
                'currency_codes' => __('currency codes', WCU_LANG_CODE),
                'currency_symbols' => __('currency symbols', WCU_LANG_CODE),
                'flags' => __('flags', WCU_LANG_CODE),
                'text' => __('text', WCU_LANG_CODE),
            ),
        );
    }
	public function getCurrencyAfterPointList() {
		return array(
			0, 1, 2, 3, 4, 5, 6, 7, 8, 9
		);
	}
	public function getCurrencyExchangeFeeSignList() {
		return array( 0 => '+', 1 => '-' );
	}

}
