<?php
class update_ratesModelWcu extends modelWcu {

	public function getUpdateFreq() {
			$options =  frameWcu::_()->getModule('currency')->getModel()->getOptions();

			if (isset($options['options']['aur_freq'])){
				$aur_freq = ($options['options']['aur_freq']) ? $options['options']['aur_freq'] : 'disabled';
			} else {
				$aur_freq = 'disabled';
			}

			return $aur_freq;
	}

	public function getEmailNotice() {
			$options =  frameWcu::_()->getModule('currency')->getModel()->getOptions();

			if (isset($options['options']['aur_email_notice'])){
				$aur_email_notice = ($options['options']['aur_email_notice']) ? $options['options']['aur_email_notice'] : 'disabled';
			} else {
				$aur_email_notice = 'disabled';
			}

			return $aur_email_notice;
	}

	public function getMainCurrency($currencies) {
		foreach ($currencies as $currency => $key) {
			if ($key['etalon'] === '1') {
				$mainCurrency = $currency;
			}
		}
		return $mainCurrency;
	}

	public function getCurrencyRate($currencies, $mainCurrency) {
		foreach ($currencies as $currency => $key) {
			if ($key['etalon'] === '0') {
				$currencies[$currency]['rate'] = frameWcu::_()->getModule('currency')->getModel()->getCurrencyRate($mainCurrency, $currency);
			} elseif ($key['etalon'] === '1') {
			  $currencies[$currency]['rate'] = 1;
			}
		}
		return $currencies;
	}

	public function formatData($currencies) {
			$data = array();
			foreach ($currencies as $a) {
			    foreach ($a as $k => $v) {
			    	$data[$k][] = $v;
				}
			}
			return $data;
	}

	public function updateRates() {
		$currencies =  frameWcu::_()->getModule('currency')->getModel()->getCurrencies();
		$mainCurrency = $this->getMainCurrency($currencies);
		$currencies = $this->getCurrencyRate($currencies, $mainCurrency);
		$data = $this->formatData($currencies);
		frameWcu::_()->getModule('currency')->getModel()->saveCurrencies($data);

		$emailNotice = $this->getEmailNotice();
		if (!empty($emailNotice) && ($emailNotice === 'enabled') ) {
			$headers = 'From: '.get_site_url().' <'.get_option('admin_email').'>' . "\r\n";
			$headers .= "Content-type: text/html; charset=\"UTF-8\" \r\n";
			$message = '';
			foreach ($currencies as $key => $currency) {
				$message .= $key.' '.$currency['rate'].'<br/>';
			}
			wp_mail( get_option('admin_email'), 'Result of automatic update rates on your site '.get_site_url(), $message, $headers);
		}

	}

}
