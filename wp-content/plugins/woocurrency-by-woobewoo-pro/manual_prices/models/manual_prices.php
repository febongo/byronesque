<?php

class manual_pricesModelWcu extends modelWcu {
	private $settings = null;
	private $notMainCurrencyList = null;
	private $manualCurrencyList = null;

    public function getManualPricesSettings() {
    	if (is_null($this->settings)) { 
        	$settings = get_option($this->getModule()->currencyDbOpt, array());
        	$settings = isset($settings['manual_prices']) ? $settings['manual_prices'] : array();

        	$list = array();
        	if (isset($settings['toggle_manual_prices']) && $settings['toggle_manual_prices'] == '1') {
        		$isAll = isset($settings['for_all_currencies']) && $settings['for_all_currencies'] == '1';
				$selected = isset($settings['currencies_list']) ? $settings['currencies_list'] : '';
				if ($isAll || !empty($selected)) {
					$currencies = $this->getNotMainCurrencyList();
					foreach ($currencies as $ccy) {
						if ($isAll || in_array($ccy, $selected)) {
							$list[] = $ccy;
						}
					}
				}
			}
			$this->settings = $settings;
			$this->manualCurrencyList = $list;
        }
        return $this->settings;
    }

    public function getNotMainCurrencyList() {
    	if (is_null($this->notMainCurrencyList)) {
	    	$currencies = frameWcu::_()->getModule('currency')->getCurrencies();
	    	$list = array();
	    	foreach ($currencies as $currency) {
	    		if (!isset($currency['etalon']) || $currency['etalon'] == 0) {
	    			$name = isset($currency['name']) ? $currency['name'] : '';
	    			if (!empty($name)) {
	    				$list[$name] = $name;
	    			}
	    		}
	    	}
	    	$this->notMainCurrencyList = $list;
	    }
        return $this->notMainCurrencyList;
    }

    public function createCurrencyPriceFields() {
    	if (is_null($this->manualCurrencyList) || empty($this->manualCurrencyList)) {
    		return;
    	}
		$currencies = $this->manualCurrencyList;
		foreach ($currencies as $ccy) {
			$args = array(
				'id' => 'wcu_currency_prices[' . $ccy . ']',
				'label' => __('Price, ' . $ccy, WCU_LANG_CODE),
				'class' => 'wcu-custom-field',
				'wrapper_class' => 'wcu-custom-field-wrapper',
			);
			woocommerce_wp_text_input($args);
		}
	}

	public function createCurrencyAvailable() {
		global $post_id;

		$optionsPro = frameWcu::_()->getModule( 'options_pro' )->getModel()->getOptionsPro();
		foreach ( $optionsPro['geoip_rules']['currency_list'] as $key => $region ) {
			woocommerce_wp_checkbox( array(
				'id'    => 'wcu_currency_unavailable[' . $key . ']',
				'label' => __( 'Product unavailable for ' . $key, WCU_LANG_CODE ),
				'value' => get_post_meta( $post_id, 'wcu_currency_unavailable_' . $key, true ) ? 'yes' : 'no'
			));
		}
	}

	public function createCurrencyPriceFieldsVariation($loop, $variation_data, $variation) {
		if (is_null($this->manualCurrencyList) || empty($this->manualCurrencyList)) {
    		return;
    	}
		$currencies = $this->manualCurrencyList;
		foreach ($currencies as $ccy) {
			$field = 'wcu_currency_prices_v[' . $ccy . ']';
			$args = array(
				'id' => $field . '[' . $variation->ID . ']',
				'label' => __('Price, ' . $ccy, WCU_LANG_CODE),
				'class' => 'wcu-custom-field',
				'wrapper_class' => 'wcu-custom-field-wrapper',
				'value' => get_post_meta($variation->ID, $field, true),
			);
			woocommerce_wp_text_input($args);
		}
	}

    public function saveCurrencyPriceFields($postId) {
		$prices = isset( $_POST['wcu_currency_prices'] ) ? $_POST['wcu_currency_prices'] : array();
		if (is_array($prices)) {
			foreach($prices as $ccy => $value) {
				$key = 'wcu_currency_prices[' . $ccy . ']';
				if ($value == '') {
					delete_post_meta( $postId, $key );
				} else {
					update_post_meta($postId, $key, sanitize_text_field(floatval(str_replace(',', '.', $value))));
				}
			}
		}
    }

	public function saveCurrencyAvailable( $postId ) {
    	$postMeta = get_post_meta( $postId );

		foreach ( $postMeta as $key => $value ) {
			if ( strpos( $key, 'wcu_currency_unavailable_' ) === 0 ) {
				delete_post_meta( $postId, $key );
			}
		}

		$uavailable = isset( $_POST['wcu_currency_unavailable'] ) ? $_POST['wcu_currency_unavailable'] : array();
		if ( is_array( $uavailable ) ) {
			foreach ( $uavailable as $key => $value ) {
				update_post_meta( $postId, 'wcu_currency_unavailable_' . $key , sanitize_text_field(  $value  ) );
			}
		}
	}

    public function saveCurrencyPriceFieldsVariation($postId) {
    	$prices = isset( $_POST['wcu_currency_prices_v'] ) ? $_POST['wcu_currency_prices_v'] : array();
		if (is_array($prices)) {
			foreach($prices as $ccy => $values) {
				if (isset($values[$postId])) {
					$value = $values[$postId];
					$key = 'wcu_currency_prices_v[' . $ccy . ']';
					if ($value == '') {
						delete_post_meta( $postId, $key );
					} else {
						update_post_meta($postId, $key, sanitize_text_field(floatval(str_replace(',', '.', $value))));
					}
				}
			}
		}
    }

	public function setCartItemsPrice( $cart ) {
		$ccy = frameWcu::_()->getModule('currency')->getCurrentCurrency();
    	if (is_array($this->manualCurrencyList) && in_array($ccy, $this->manualCurrencyList)) {
			foreach ( $cart->get_cart() as $key => $cartItem ) {
				$field = 'wcu_currency_prices' . (!empty($cartItem['variation_id']) ? '_v' : '');
				$product = $cartItem['data'];
    			if ($product) {
    				$manual = $product->get_meta($field . '[' . $ccy . ']');
					if (!empty($manual)) {
						$regular = $product->get_regular_price();
						$price = $product->get_price();
    					if ($regular != $price && !empty($regular)) {
   							$manual = round($manual * $price / $regular, 2);
    					}
						$product->set_price($manual);
					} else {
						$product->set_price( apply_filters( 'raw_woocommerce_price', $product->get_price(), $product ) );
					}
				}
			}
		}
	}

    public function getManualPrice($price, $ccy, $prod = null) {
		if (is_array($this->manualCurrencyList) && in_array($ccy, $this->manualCurrencyList)) {

			if (is_null($prod) || !is_object($prod)) {
				global $product, $post, $wtbpProduct;
				if (is_object($wtbpProduct)) {
					$prod = $wtbpProduct;
				} else if (is_object($product)) {
					$prod = $product;
				} else if (is_object($post) && ('product' == $post->post_type || 'product_variation' == $post->post_type)) {
					$prod = wc_get_product($post->ID);
				}
			} else {
				$price = $prod->get_price();
			}

			$manual = false;
			if ( is_object( $prod ) ) {
    			if ($prod->get_type() == 'variable') {
    				$prices = $prod->get_variation_prices();
    				if (!empty($prices) && isset($prices['price']) && isset($prices['regular_price'])) {
    					foreach ($prices['price'] as $id => $value) {
    						$regular = $prices['regular_price'][$id];
    						if ($value == $price) {
    							$manual = get_post_meta($id, 'wcu_currency_prices_v[' . $ccy . ']', true);
    							if (!empty($manual) && $regular != $value && !empty($regular)) {
    								$manual = round($manual * $price / $regular, 2);
    							}
    							break;
    						}
    					}
    					if ($manual === false) {
    						foreach ($prices['regular_price'] as $id => $value) {
    							if ($value == $price) {
    								$manual = get_post_meta($id, 'wcu_currency_prices_v[' . $ccy . ']', true);
    								break;
    							}
    						}
    					}
    				}
    			} else {
    				$manual = $prod->get_meta('wcu_currency_prices[' . $ccy . ']');
    				if (!empty($manual)) {
    					$regular = $prod->get_regular_price();
    					if ($regular != $price && !empty($regular)) {    						
   							$manual = round($manual * $price / $regular, 2);
    					}
    				}
    			}
    			if ($manual === '' || $manual === false) {
    				return false;
    			}
    			return (empty($manual) || $price == $manual) ? true : $manual;
			}
			return true;
    	}
    	return $price;
    }

}
