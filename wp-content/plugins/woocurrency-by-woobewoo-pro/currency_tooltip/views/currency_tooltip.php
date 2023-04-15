<?php
class currency_tooltipViewWcu extends viewWcu
{
    public function getCurrencyTooltip($previewOptions = array())
    {
        $currencyModule = frameWcu::_()->getModule('currency');
        $currencyModel = $currencyModule->getModel();
        $options = frameWcu::_()->getModule('options_pro')->getModel()->getOptionsPro();
        $moduleName = 'currency_tooltip';
        if ($previewOptions) {
            $options = $previewOptions;
        }
        $show = $currencyModule->getShowModule($moduleName, true);
            if ($show) {
                $defOptions = $currencyModule->getDefaultOptions();
                $currencies = frameWcu::_()->getModule('currency')->getModel()->getCurrencies();
				$cryptoCurrencyList = frameWcu::_()->getModule('currency')->getCryptoCurrencyList();
                $currencySymbols = frameWcu::_()->getModule('currency')->getCurrencySymbols();
                $currenciesOpts = array();
                foreach ($currencies as $c) {
                    $name = (!empty($c['name'])) ? $c['name'] : '';
                    $symbol = (!empty($c['symbol']) && !empty($currencySymbols[$c['symbol']])) ? $currencySymbols[$c['symbol']] : $name;
                    $rate = (!empty($currencies[$name]['rate'])) ? $currencies[$name]['rate'] : '';
                    $position = (!empty($currencies[$name]['position'])) ? $currencies[$name]['position'] : '';

					$currenciesOpts[$name]['name'] = $name;

					if ( !array_key_exists( $name, $cryptoCurrencyList ) ) {
						$decimals = (!empty($c['decimals'])) ? $c['decimals'] : '0';
	                    $currenciesOpts[$name]['decimals'] = ($decimals == '1') ? get_option('woocommerce_price_num_decimals') : '0';
					} else {
						$currenciesOpts[$name]['decimals'] = frameWcu::_()->getModule('currency')->priceNumDecimalsCrypto;
					}
					
                    $currenciesOpts[$name]['symbol'] = $symbol;
                    $currenciesOpts[$name]['rate'] = $rate;
                    $currenciesOpts[$name]['position'] = $position;
                }
                wp_enqueue_script('wp-color-picker');
                wp_enqueue_style('wp-color-picker');
                frameWcu::_()->getModule('templates')->loadCoreJs();
                $this->assign('currencies', $currenciesOpts);
                $this->assign('currentCurrency', $currencyModule->getCurrentCurrency());
                $this->assign('designTab', array_keys($defOptions[$moduleName]['design_tab']));
                $this->assign('displayRulesTab', array_keys($defOptions[$moduleName]['display_rules_tab']));
                $this->assign('optionsParams', $currencyModule->getView()->_prepareOptionsParams($options, $defOptions));
                parent::display('currencyTooltip');
            }
        }
    }
