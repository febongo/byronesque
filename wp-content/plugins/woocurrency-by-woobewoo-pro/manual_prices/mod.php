<?php
class manual_pricesWcu extends moduleWcu {

	public $currencyDbOpt = 'wcu_options_pro';

	public function init() {
		parent::init();
		add_action( 'init', array( $this, 'initManualPriceFields' ), 999 );
		if ( is_admin() ) {
			add_action( 'init', array( $this, 'initManualAvailable' ), 999 );
		}
	}

	public function initManualAvailable() {
		$model      = $this->getModel();
		$optionsPro = frameWcu::_()->getModule( 'options_pro' )->getModel()->getOptionsPro();
		if ( $optionsPro['geoip_rules']['enable'] && ! empty( $optionsPro['geoip_rules']['automatic_by_ip'] ) ) {
			add_action( 'woocommerce_product_options_pricing', array( $model, 'createCurrencyAvailable' ) );
			add_action( 'woocommerce_process_product_meta', array( $model, 'saveCurrencyAvailable' ) );
		}
	}

	public function initManualPriceFields() {
		$model = $this->getModel();
		$settings = $model->getManualPricesSettings();
        if (isset($settings['toggle_manual_prices']) && $settings['toggle_manual_prices'] == '1') {
        	add_action('woocommerce_product_options_pricing', array($model, 'createCurrencyPriceFields'));
        	add_action('woocommerce_variation_options_pricing', array($model, 'createCurrencyPriceFieldsVariation'), 10, 3);
        	add_action('woocommerce_process_product_meta', array($model, 'saveCurrencyPriceFields'));
        	add_action('woocommerce_save_product_variation', array($model, 'saveCurrencyPriceFieldsVariation'), 10, 2);

        	dispatcherWcu::addFilter('getManualPrice', array($model, 'getManualPrice'), 10, 3);
        	dispatcherWcu::addAction('setCartItemsPrice', array($model, 'setCartItemsPrice'), 10, 2);
        	if (is_admin()) {
        		frameWcu::_()->addStyle( 'wcu.manual.prices', $this->getModPath() . 'css/currency.manual.css' );
        	}
        }
	}


	public function getDefaultOptions() {
		return array(
			'toggle_manual_prices' => '0',
			'for_all_currencies' => '1',
			'currencies_list' => ''
		);
	}

	public function getOptionsParams() {
		return array(
			'toggle_manual_prices' => array(
				'html' => 'checkboxHiddenVal',
				'row_classes' => '',
				'row_show' => 'all',
				'row_hide' => '',
				'tooltip' => __('Enable to set individual prices for each product for each currency.', WCU_LANG_CODE),
				'label' => __('Enable Manual Prices', WCU_LANG_CODE),
				'params' => array(
					'value' => '1',
				),
			),
			'for_all_currencies' => array(
				'html' => 'checkboxHiddenVal',
				'row_classes' => '',
				'row_parent' => '',
				'row_show' => '',
				'row_hide' => '',
				'tooltip' => __('If this option is enabled, prices in all currencies will be determined not by the exchange rate, but taken from the corresponding fields of the product editing form.', WCU_LANG_CODE),
				'label' => __('Set manual prices for all currencies', WCU_LANG_CODE),
				'params' => array(
					'value' => '1',
				),
			),
			'currencies_list' => array(
				'html' => 'selectlist',
				'row_classes' => 'wcuMultiSelect',
				'row_parent' => '',
				'row_show' => '',
				'row_hide' => '',
				'tooltip' => __('If you want to manually set prices only for some currencies, then select the necessary ones, prices in the remaining currencies will be calculated at the rate automatically. The option "Set manual prices for all currencies" must be disabled.', WCU_LANG_CODE),
				'label' => __('Select currencies', WCU_LANG_CODE),
				'params' => array(
					'options' => $this->getModel()->getNotMainCurrencyList(),
				),
			),
		);
	}
}
