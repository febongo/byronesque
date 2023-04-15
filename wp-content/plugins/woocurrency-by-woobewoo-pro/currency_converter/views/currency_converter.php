<?php
class currency_converterViewWcu extends viewWcu
{
    public function getCurrencyConverter( $previewOptions = array() )
    {
        $currencyModule = frameWcu::_()->getModule( 'currency' );
        $currencyModel = $currencyModule->getModel();
        $moduleName = 'currency_converter';
		if ( !$previewOptions ) {
            $options = frameWcu::_()->getModule( 'options_pro' )->getModel()->getOptionsPro();
        } else {
			$options = $previewOptions;
		}
        $defOptions = $currencyModule->getDefaultOptions();
        $currencies = frameWcu::_()->getModule( 'currency' )->getModel()->getCurrencies();
        $currencySymbols = frameWcu::_()->getModule( 'currency' )->getCurrencySymbols();
        $showFlagDropdown = false;
        if ( !empty( frameWcu::_()->getModule( 'flags' ) ) ) {
            $flagsList = frameWcu::_()->getModule( 'flags' )->getFlagsList();
            $showFlagDropdown = !empty( $options[ $moduleName ][ 'design_tab' ][ 'cc_show_dropdown_flag' ] ) ? true : false;
        }

		$dropdownOrder = isset( $options[ $moduleName ][ 'design_tab' ][ 'cc_show_dropdown_order' ] ) ? $options[ $moduleName ][ 'design_tab' ][ 'cc_show_dropdown_order' ] : array();
		if ($previewOptions) {
			$dropdownOrder = explode(',', $dropdownOrder[0]);
		}

        $currenciesDropdown = array();
        $currenciesList = array();

        foreach ( $currencies as $c ) {
            $name = ( !empty( $c[ 'name' ] ) ) ? $c[ 'name' ] : '';
            $title = ( !empty( $c[ 'title' ] ) ) ? $c[ 'title' ] : '';
            $symbol = ( !empty( $c[ 'symbol' ] ) && !empty( $currencySymbols[ $c[ 'symbol' ] ] ) ) ? $currencySymbols[ $c[ 'symbol' ] ] : '';
            $rate = ( !empty( $currencies[ $name ][ 'rate' ] ) ) ? $currencies[ $name ][ 'rate' ] : '';
            $flag = ( !empty( $c[ 'flag' ] ) && !empty( $flagsList[ $c[ 'flag' ] ] ) ) ? $flagsList[ $c[ 'flag' ] ] : '';
            $flag_list = !empty( $flag ) ? '<img src="' . $flag . '">' : '';
            $flag_dropdown = !empty( $flag ) ? $flag : '';

            if ( !empty( $dropdownOrder ) ) {
                foreach ( $dropdownOrder as $item ) {
                    $currenciesDropdown[ $name ][ $item ] = ${$item};
                }
            }
            if ( $showFlagDropdown ) {
                $currenciesDropdown[ $name ][ 'flag_dropdown' ] = $flag_dropdown;
            }
        }
        frameWcu::_()->getModule( 'templates' )->loadCoreJs();
        frameWcu::_()->getModule( 'templates' )->loadFontAwesome();
        frameWcu::_()->addStyle( 'currency.converter', $this->getModule()->getModPath() . 'css/currency.converter.css' );
        frameWcu::_()->addScript( 'frontend.currency.converter', $this->getModule()->getModPath() . 'js/frontend.currency.converter.js' );
        $this->assign( 'currenciesDropdown', $currenciesDropdown );
        $this->assign( 'showFlagDropdown', $showFlagDropdown );
        $this->assign( 'currentCurrency', $currencyModule->getCurrentCurrency() );
        $this->assign( 'designTab', array_keys( $defOptions[ $moduleName ][ 'design_tab' ] ) );
        $this->assign( 'displayRulesTab', array_keys( $defOptions[ $moduleName ][ 'display_rules_tab' ] ) );
        $this->assign( 'optionsParams', $currencyModule->getView()->_prepareOptionsParams( $options, $defOptions ) );
        return parent::getContent( 'currencyConverter' );
    }
}
