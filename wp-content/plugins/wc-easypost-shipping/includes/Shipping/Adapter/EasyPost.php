<?php

/*********************************************************************/
/*  PROGRAM          FlexRC                                          */
/*  PROPERTY         3-7170 Ash Cres                                 */
/*  OF               Vancouver BC   V6P 3K7                          */
/*  				 Voice 604 800-7879                              */
/*                                                                   */
/*  Any usage / copying / extension or modification without          */
/*  prior authorization is prohibited                                */
/*********************************************************************/

namespace OneTeamSoftware\WooCommerce\Shipping\Adapter;

defined('ABSPATH') || exit;

if (!class_exists('\\OneTeamSoftware\\WooCommerce\\Shipping\\Adapter\\EasyPost')):

require_once(__DIR__ . '/AbstractAdapter.php');

class EasyPost extends AbstractAdapter
{
	protected $apiKey;
	protected $testApiKey;

	// we don't want these properties overwritten by settings
	protected $_carriers;
	protected $_services;

	const MIN_WEIGHT = 0.2;
	const MAX_DESCRIPTION_LENGTH = 45;

	public function __construct($id, array $settings = array())
	{
		$this->apiKey = null;
		$this->testApiKey = null;

		parent::__construct($id, $settings);

		$this->currencies = array('USD' => __('USD', $this->id), 'CAD' => __('CAD', $this->id));

		$this->statuses = array(
			'pre_transit' => __('Pre-Shipment Information Received', $this->id),
			'available_for_pickup' => __('Available For Pickup', $this->id),
			'in_transit' => __('In Transit', $this->id),
			'out_for_delivery' => __('Out For Delivery', $this->id),
			'delivered' => __('Delivered', $this->id),
			'return_to_sender' => __('Return To Sender', $this->id),
			'failure' => __('Exception', $this->id),
			'error' => __('Error', $this->id),
			'cancelled' => __('Cancelled', $this->id),
			'unknown' => __('Shipping Label Created', $this->id),
			'submitted' => __('Refund Requested', $this->id),
			'rejected' => __('Refund Rejected', $this->id),
			'refunded' => __('Refunded', $this->id),
		);

		$this->completedStatuses = array(
			'delivered',
			'error',
			'cancelled',
		);

		$this->contentTypes = array(
			'merchandise' => __('Merchandise', $this->id),
			'documents' => __('Documents', $this->id),
			'gift' => __('Gift', $this->id),
			'returned_goods' => __('Returned Goods', $this->id),
			'sample' => __('Sample', $this->id),
			'other' => __('Other', $this->id),
		);

		$this->initCarriers();
		$this->initServices();
		$this->initPackageTypes();
	}

	public function getName()
	{
		return 'EasyPost';
	}

	public function hasCustomItemsFeature()
	{
		return true;
	}

	public function hasTariffFeature()
	{
		return true;
	}

	public function hasUseSellerAddressFeature()
	{
		return true;
	}

	public function hasReturnLabelFeature()
	{
		return true;
	}

	public function hasAddressValidationFeature()
	{
		return true;
	}

	public function hasLinkFeature()
	{
		return true;
	}

	public function hasMediaMailFeature()
	{
		return true;
	}

	public function hasOriginFeature()
	{
		return true;
	}

	public function hasInsuranceFeature()
	{
		return true;
	}

	public function hasSignatureFeature()
	{
		return true;
	}

	public function hasDisplayDeliveryTimeFeature()
	{
		return true;
	}

	public function hasUpdateShipmentsFeature()
	{
		return true;
	}

	public function hasCreateShipmentFeature()
	{
		return true;
	}

	public function hasCreateManifestsFeature()
	{
		return true;
	}

	public function hasCarriersFeature()
	{
		return true;
	}

	public function validate(array $settings)
	{
		$errors = array();

		$this->setSettings($settings);

		$apiTokenKey = 'apiKey';
		$apiTokenName = __('Product API Key', $this->id);
		if ($settings['sandbox'] == 'yes') {
			$apiTokenKey = 'testApiKey';
			$apiTokenName = __('Sandbox / Test API Key', $this->id);
		}

		if (empty($settings[$apiTokenKey])) {
			$errors[] = sprintf('<strong>%s:</strong> %s', $apiTokenName, __('is required for the integration to work', $this->id));
		} else if (!$this->validateActiveApiToken()) {
			$errors[] = sprintf('<strong>%s:</strong> %s', $apiTokenName, __('is invalid', $this->id));
		}

		return $errors;
	}

	protected function validateActiveApiToken()
	{
		$response = $this->get('INVALID_SHIPMENT_ID');
		if (!empty($response['response']['error']['code']) && $response['response']['error']['code'] == 'APIKEY.INACTIVE') {
			return false;
		}

		return true;
	}

	public function getIntegrationFormFields()
	{
		$formFields = array(
			'easypost_terms' => array(
				'type' => 'title',
				'description' => sprintf(
					'<div class="notice notice-info inline"><p>%s %s<br/>%s</p></div>',
					__('Please note that EasyPost is charging fees for using their API service.', $this->id),
					sprintf(
						__('For more information please check %sEasyPost Terms of Services%s', $this->id), 
						'<a href="https://www.easypost.com/privacy#terms-of-service-api" target="_blank">', 
						'</a>'
					),
					sprintf(
						__('Do you need EasyPost account? Please %sclick here%s to register it!', $this->id), 
						'<a href="https://t.sidekickopen80.com/s1t/c/5/f18dQhb0S7lM8dDMPbW2n0x6l2B9nMJN7t5XWPfhMynW1q0QnF3N1RKFW56dz5C5rqGxd102?te=W3R5hFj4cm2zwW4mKLS-3K1M1cW45SBb-1JxwY5W1LDKvQ41Y-N9W4hMnzc4cNcV-W3F6d814fGzVZW4cNbzW4myz_r0&si=8000000004157677&pi=ae62ad0e-6d94-48dd-e2b8-5bfb2520810c" target="_blank">', 
						'</a>'
					)
				)
			),

			'apiKey' => array(
				'title' => __('Production API Key', $this->id),
				'type' => 'text',
				'description' => sprintf(__('You can find it at %sProfile -> API Keys%s.', $this->id), '<a href="https://www.easypost.com/account/api-keys" target="_blank">', '</a>'),
			),
			'testApiKey' => array(
				'title' => __('Sandbox / Test API Key', $this->id),
				'type' => 'text',
				'description' => sprintf(__('You can find it at %sProfile -> API Keys%s.', $this->id), '<a href="https://www.easypost.com/account/api-keys" target="_blank">', '</a>'),
			),
		);

		return $formFields;
	}

	public function getRates(array $params)
	{
		$this->logger->debug(__FILE__, __LINE__, 'getRates');

		$cacheKey = $this->getRatesCacheKey($params);
		$response = $this->getCacheValue($cacheKey);
		if (empty($response)) {		
			$params['function'] = __FUNCTION__;
			$response = $this->sendRequest('shipments', 'POST', $params);
	
			if (!empty($response['shipment'])) {
				$this->logger->debug(__FILE__, __LINE__, 'Cache shipment for the future');
		
				$this->setCacheValue($cacheKey, $response);
			}
		} else {
			$this->logger->debug(__FILE__, __LINE__, 'Found previously returned rates, so return them');
		}

		return $response;
	}

	public function getCacheKey(array $params)
	{
		$cacheKey = parent::getCacheKey($params);
		$cacheKey .= '_' . $this->getApiKey();

		return md5($cacheKey);
	}

	protected function getRatesCacheKey(array $params)
	{
		$params['validateAddress'] = $this->validateAddress;

		if (isset($params['service'])) {
			unset($params['service']);
		}

		if (isset($params['function'])) {
			unset($params['function']);
		}

		return $this->getCacheKey($params) . '_rates';
	}

	protected function getRatesParams(array $inParams)
	{
		$this->logger->debug(__FILE__, __LINE__, 'getRatesParams');

		$params = array();

		$params['mode'] = $this->sandbox ? 'test' : 'production';

		if (!empty($inParams['order_number'])) {
			$params['reference'] = $inParams['order_number'];
		}

		$insurance = $this->insurance;
		if (isset($inParams['insurance'])) {
			$insurance = filter_var($inParams['insurance'], FILTER_VALIDATE_BOOLEAN);
		}

		if ($insurance && !empty($inParams['value'])) {
			$params['insurance'] = number_format($inParams['value'], 3, '.', '');
		}

		$params['is_return'] = false;
		if (!empty($inParams['return'])) {
			$params['is_return'] = filter_var($inParams['return'], FILTER_VALIDATE_BOOLEAN);
		}

		if ($this->signature) {
			$params['options']['delivery_confirmation'] = 'SIGNATURE';
		}

		//$params['options']['delivery_confirmation'] = $this->signature ? 'SIGNATURE' : 'NO_SIGNATURE';
		$params['options']['currency'] = $this->currency;
		$params['options']['alcohol'] = false;
		$params['options']['label_format'] = 'PDF';

		$labelTime = strtotime('now');

		if (date('w', $labelTime) % 6 == 0 || intval(date('H', $labelTime)) > 16) {
			// if weekend or after 4pm then take next business day at noon
			$labelTime = strtotime('now + 1 Weekday noon');
		} else if (intval(date('H', $labelTime)) < 9) {
			// if before 9am then use today noon
			$labelTime = strtotime('today noon');
		}

		$params['options']['label_date'] = date('c', $labelTime);

		if (!empty($this->mediaMail) && $this->mediaMail != 'exclude') {
			$params['options']['special_rates_eligibility'] = 'USPS.MEDIAMAIL';
		}

		$params['parcel']['weight'] = 0;
		$params['parcel']['length'] = 0;
		$params['parcel']['width'] = 0;
		$params['parcel']['height'] = 0;

		$params['from_address']['name'] = null;
		$params['from_address']['company'] = null;
		$params['from_address']['street1'] = null;
		$params['from_address']['street2'] = null;
		$params['from_address']['city'] = null;
		$params['from_address']['state'] = null;
		$params['from_address']['country'] = null;
		$params['from_address']['zip'] = null;
		$params['from_address']['phone'] = null;

		$params['to_address'] = $params['from_address'];

		//if (!empty($inParams['service'])) {
		//	$postageTypeParts = explode('_', $inParams['service'], 2);
		//	$params['rate']['carrier'] = $postageTypeParts[0];
		//	$params['rate']['service'] = $postageTypeParts[1];
		//}

		if (isset($inParams['currency'])) {
			$currency = strtoupper($inParams['currency']);
			if (isset($this->currencies[$currency])) {
				$params['options']['currency'] = strtoupper($inParams['currency']);
			}
		}

		if (isset($inParams['signature'])) {
			$signature = filter_var($inParams['signature'], FILTER_VALIDATE_BOOLEAN);
			$params['options']['delivery_confirmation'] = $signature ? 'ADULT_SIGNATURE' : 'NO_SIGNATURE';
		}

		if (isset($inParams['mediaMail'])) {
			if (!empty($inParams['mediaMail']) && $inParams['mediaMail'] != 'exclude') {
				$params['options']['special_rates_eligibility'] = 'USPS.MEDIAMAIL';
			} else {
				$params['options']['special_rates_eligibility'] = null;
			}
		}

		//if (isset($inParams['service'])) {
		//	$params['selected_rate'] = $inParams['service'];
		//}

		if (empty($inParams['origin']) && !empty($this->origin)) {
			$inParams['origin'] = $this->origin;
		}

		if (!empty($inParams['origin'])) {
			$this->logger->debug(__FILE__, __LINE__, 'From Address: ' . print_r($inParams['origin'], true));

			$params['from_address'] = $this->getCachedAddress($inParams['origin']);
		}
		
		if (!empty($inParams['destination'])) {
			$this->logger->debug(__FILE__, __LINE__, 'To Address: ' . print_r($inParams['destination'], true));

			$params['to_address'] = $this->getCachedAddress($inParams['destination']);
		}

		if (isset($inParams['name'])) {
			$params['to_address']['name'] = $inParams['name'];
		}

		$params['parcel'] = $this->getCachedParcelInfo($inParams);
		$params['customs_info'] = $this->getCachedCustomsInfo($inParams);
		
		$params = array('shipment' => $params);

		return $params;
	}

	protected function getRequestParams(array $inParams)
	{
		$this->logger->debug(__FILE__, __LINE__, 'getRequestParams: ' . print_r($inParams, true));

		$params = array();

		if (!empty($inParams['function']) && $inParams['function'] == 'getRates') {
			$params = $this->getRatesParams($inParams);
		}

		return $params;
	}

	protected function getCachedParcelInfo(array $inParams)
	{
		$parcel = $this->prepareParcelInfo($inParams);

		$cacheKey = $this->getCacheKey($parcel);
		$parcelId = $this->getCacheValue($cacheKey);
		if (!empty($parcelId)) {
			$this->logger->debug(__FILE__, __LINE__, 'Found previous cached parcel ID: ' . $parcelId . ', so re-use it');
			
			$parcel = array('id' => $parcelId);
		}

		return $parcel;
	}

	protected function prepareParcelInfo(array $inParams)
	{
		$this->logger->debug(__FILE__, __LINE__, 'prepareParcelInfo');

		if (!empty($inParams['type']) && $inParams['type'] != 'parcel' && isset($this->packageTypes[$inParams['type']])) {
			$typeParts = explode('_', $inParams['type'], 2);
			if (count($typeParts) == 2) {
				$parcel['predefined_package'] = $typeParts[1];
			}
		}

		$parcel['weight'] = 0;
		$parcel['length'] = 0;
		$parcel['width'] = 0;
		$parcel['height'] = 0;

		if (isset($inParams['weight'])) {
			$parcel['weight'] = round($inParams['weight'], 3);
		}

		if (isset($inParams['length'])) {
			$parcel['length'] = round($inParams['length'], 3);
		}

		if (isset($inParams['width'])) {
			$parcel['width'] = round($inParams['width'], 3);
		}

		if (isset($inParams['height'])) {
			$parcel['height'] = round($inParams['height'], 3);
		}

		$dimensionUnit = $this->dimensionUnit;
		if (isset($inParams['dimension_unit']) && in_array($inParams['dimension_unit'], array('m', 'cm', 'in'))) {
			$dimensionUnit = $inParams['dimension_unit'];
		}

		// convert dimension, if required
		if (!in_array($dimensionUnit, array('in'))) {
			$this->logger->debug(__FILE__, __LINE__, 'Our dimension unit is ' . $dimensionUnit . ', so convert it to in');

			$dimensionUnit = 'in';
			$parcel['length'] = wc_get_dimension($parcel['length'], $dimensionUnit);
			$parcel['width'] = wc_get_dimension($parcel['width'], $dimensionUnit);
			$parcel['height'] = wc_get_dimension($parcel['height'], $dimensionUnit);
		}

		$weightUnit = $this->weightUnit;
		if (isset($inParams['weight_unit']) && in_array($inParams['weight_unit'], array('g', 'kg', 'lbs', 'oz'))) {
			$weightUnit = $inParams['weight_unit'];
		}

		// convert weight, if required
		if (!in_array($weightUnit, array('oz'))) {
			$this->logger->debug(__FILE__, __LINE__, 'Our weight unit is ' . $weightUnit . ', so convert it to oz');

			$weightUnit = 'oz';
			$parcel['weight'] = wc_get_weight($parcel['weight'], $weightUnit);
		}	

		$parcel['weight'] = number_format($parcel['weight'], 3, '.', '');
		$parcel['length'] = number_format($parcel['length'], 3, '.', '');
		$parcel['width'] = number_format($parcel['width'], 3, '.', '');
		$parcel['height'] = number_format($parcel['height'], 3, '.', '');

		return $parcel;
	}

	protected function getCachedCustomsInfo(array $inParams)
	{
		$customsInfo = $this->prepareCustomsInfo($inParams);
		if (!empty($customsInfo)) {
			$cacheKey = $this->getCacheKey($customsInfo);
			$customsInfoId = $this->getCacheValue($cacheKey);
			if (!empty($customsInfoId)) {
				$this->logger->debug(__FILE__, __LINE__, 'Found previous cached customs info ID: ' . $customsInfoId . ', so re-use it');
				
				$customsInfo = array('id' => $customsInfoId);
			}	
		}

		return $customsInfo;
	}

	protected function prepareCustomsInfo(array $inParams)
	{
		$this->logger->debug(__FILE__, __LINE__, 'prepareCustomsInfo');

		if (isset($inParams['origin']['country']) 
			&& isset($inParams['destination']['country'])
			&& $inParams['origin']['country'] == $inParams['destination']['country']) {
			$this->logger->debug(__FILE__, __LINE__, 'Order is local, so no need for customs info');

			return null;
		}

		$customsInfo = array();

		if (empty($inParams['origin']) && !empty($this->origin)) {
			$inParams['origin'] = $this->origin;
		}

		$customsInfo['contents_type'] = 'merchandise';
		if (!empty($inParams['contents']) && !empty($this->contentTypes[$inParams['contents']])) {
			$customsInfo['contents_type'] = $inParams['contents'];
		}

		if (!empty($inParams['origin']['company'])) {
			$customsInfo['customs_certify'] = true;
			$customsInfo['customs_signer'] = $inParams['origin']['company'];
		} else if (!empty($inParams['origin']['name'])) {
			$customsInfo['customs_certify'] = true;
			$customsInfo['customs_signer'] = $inParams['origin']['name'];
		}

		$customsInfo['non_delivery_option'] = 'return';
		$customsInfo['restriction_type'] = 'none';
		$customsInfo['restriction_comments'] = null;
		$customsInfo['restriction_type'] = 'none';

		if (isset($inParams['description'])) {
			$customsInfo['contents_explanation'] = $inParams['description'];
		}

		if (!empty($inParams['items']) && is_array($inParams['items'])) {
			$customsInfo['customs_items'] = $this->prepareCustomsItems($inParams['items'], strtoupper($inParams['origin']['country']));
		}

		return $customsInfo;
	}

	protected function prepareCustomsItems(array $itemsInParcel, $defaultOriginCountry)
	{
		$this->logger->debug(__FILE__, __LINE__, 'prepareCustomsItems');

		$customsItems = array();

		foreach ($itemsInParcel as $itemInParcel) {
			if (empty($itemInParcel['country'])) {
				$itemInParcel['country'] = $defaultOriginCountry;
			}

			$customsItem = $this->prepareCustomsItem($itemInParcel);
			if (!empty($customsItem)) {
				$customsItems[] = $customsItem;
			}
		}
		
		return $customsItems;
	}

	protected function prepareCustomsItem($itemInParcel)
	{
		if (empty($itemInParcel['name']) || 
			!isset($itemInParcel['weight']) || 
			empty($itemInParcel['quantity']) ||
			!isset($itemInParcel['value'])) {
			$this->logger->debug(__FILE__, __LINE__, 'Item is invalid, so skip it ' . print_r($itemInParcel, true));

			return false;
		}
		
		$weight = floatval($itemInParcel['weight']) * $itemInParcel['quantity'];
		if (!in_array($this->weightUnit, array('oz'))) {
			$weight = wc_get_weight($weight, 'oz');
		}

		$tariff = $this->defaultTariff;
		if (!empty($itemInParcel['tariff'])) {
			$tariff = $itemInParcel['tariff'];
		}

		$description = preg_replace('/[^\w\d\s]/', '?', utf8_decode($itemInParcel['name']));

		$customsItem = array(
			'description' => substr($description, 0, min(self::MAX_DESCRIPTION_LENGTH, strlen($description))),
			'quantity' => $itemInParcel['quantity'],
			'value' => number_format($itemInParcel['value'] * $itemInParcel['quantity'], 2, '.', ''),
			'weight' => number_format(max($weight, self::MIN_WEIGHT), 2, '.', ''),
			'origin_country' => trim($itemInParcel['country']),
			'hs_tariff_number' => $tariff
		);

		return $customsItem;
	}

	protected function getCachedAddress($options)
	{
		$addr = $this->prepareAddress($options);

		$cacheKey = $this->getCacheKey($addr);
		$addrId = $this->getCacheValue($cacheKey);
		if (!empty($addrId)) {
			$this->logger->debug(__FILE__, __LINE__, 'Found previous cached address ID: ' . $addrId . ', so re-use it');

			$addr = array('id' => $addrId);
		}

		return $addr;
	}
	
	protected function prepareAddress($options)
	{
		$addr = array();

		if ($this->validateAddress) {
			$addr['verify'] = array('delivery');
		}

		$addr['residential'] = true;

		if (!empty($options['name'])) {
			$addr['name'] = $options['name'];
		} else {
			$addr['name'] = 'Resident';
		}

		if (!empty($options['company'])) {
			$addr['company'] = $options['company'];
			$addr['residential'] = false;

			if (empty($options['name'])) {
				$addr['name'] = $options['company'];
			}
		}

		if (isset($options['email'])) {
			$addr['email'] = $options['email'];
		}

		if (isset($options['phone'])) {
			if (is_array($options['phone'])) {
				$options['phone'] = current($options['phone']);
			}
			
			$addr['phone'] = $options['phone'];
		}

		if (isset($options['country'])) {
			$addr['country'] = strtoupper($options['country']);
		}

		if (isset($options['state'])) {
			$addr['state'] = $options['state'];
		}

		if (isset($options['postcode'])) {
			$addr['zip'] = $options['postcode'];
		}

		if (isset($options['city'])) {
			$addr['city'] = $options['city'];
		}

		if (!empty($options['address'])) {
			$addr['street1'] = $options['address'];
		}

		if (isset($options['address_2'])) {
			$addr['street2'] = $options['address_2'];
		}
		
		return $addr;
	}

	protected function setValidationErrors($addressField, &$newResponse, $addressType)
	{
		if (empty($addressField['verifications'])) {
			return false;
		}

		foreach ($addressField['verifications'] as $val) {
			if (!empty($val['errors'])) {
				foreach ($val['errors'] as $error) {
					$errorMessage = $this->getErrorMessage($error);
					$newResponse['validation_errors'][$addressType][] = $errorMessage;
				}
			}
		}

		return true;
	}

	protected function getErrorMessage($error)
	{
		if (is_string($error)) {
			return $error;
		}
		
		if (empty($error['message'])) {
			return '';
		}

		if (is_array($error['message'])) {
			return $this->getErrorMessage($error['message']);
		}

		return $error['message'];
	}

	protected function getRatesResponse($response, array $params)
	{
		$this->logger->debug(__FILE__, __LINE__, 'getRatesResponse');

		$newResponse = array();

		if (!empty($response['id'])) {
			$newResponse['shipment']['id'] = $response['id'];
			
			if (empty($newResponse['shipment']['ship_date'])) {
				$newResponse['shipment']['ship_date'] = date('Y-m-d H:i:s');
			}
		}

		if (empty($response['rates']) && !empty($response['messages'])) {
			$newResponse['error']['message'] = $this->getErrorMessage(current($response['messages']));
		}

		if (!empty($response['from_address'])) {
			$this->setValidationErrors($response['from_address'], $newResponse, 'origin');
		}

		if (!empty($response['to_address'])) {
			$this->setValidationErrors($response['to_address'], $newResponse, 'destination');
		}

		$onlyMediaMail = false;
		if (!empty($this->mediaMail) && $this->mediaMail == 'only') {
			$onlyMediaMail = true;
		} else if (!empty($params['mediaMail']) && $params['mediaMail'] == 'only') {
			$onlyMediaMail = true;
		}

		$insuranceFee = 0;
		if (($this->insurance || (!empty($params['insurance']) && $params['insurance'] != 'no')) && !empty($params['value'])) {
			$insuranceFee = 0.01 * $params['value'];
			if ($insuranceFee < 1) {
				$insuranceFee = 1;
			}

			$this->logger->debug(__FILE__, __LINE__, 'Insurance fee: ' . $insuranceFee);
		}

		if (!empty($response['rates'])) {
			$rates = array();

			foreach ($response['rates'] as $rate) {
				if ($onlyMediaMail && $rate['service'] != 'MediaMail') {
					continue;
				}

				$serviceId = $this->getServiceId($rate['carrier'], $rate['service']);
				$serviceName = $this->getServiceName($rate['carrier'], $rate['service']);

				$rate['service'] = $serviceId;
				$rate['postage_description'] = apply_filters($this->id . '_service_name', $serviceName, $serviceId);

				$rate['cost'] = $rate['rate'] + $insuranceFee;
				$rate['insurance_fee'] = $insuranceFee;
				$rate['delivery_fee'] = 0;
				$rate['tracking_type_description'] = '';
				$rate['delivery_time_description'] = '';

				if (!empty($rate['delivery_days'])) {
					$rate['delivery_time_description'] = sprintf(__('Estimated delivery in %d days', $this->id), $rate['delivery_days']);
				}

				$rates[$serviceId] = $rate;
			}
			
			$newResponse['shipment']['rates'] = $this->sortRates($rates);
		}

		$this->setShipmentCacheValues($response, $params);

		return $newResponse;
	}

	protected function setAddressCacheValue($responseAddress, $inAddress)
	{
		if (empty($responseAddress['id'])) {
			return;
		}

		$addrId = $responseAddress['id'];
		$this->logger->debug(__FILE__, __LINE__, 'Cache from address ID: ' . $addrId);

		$addr = $this->prepareAddress($inAddress);
		$isSameAddress = true;
		foreach ($addr as $key => $value) {
			if (!isset($responseAddress[$key]) || $value != $responseAddress[$key]) {
				$this->logger->debug(__FILE__, __LINE__, 'Key: ' . $key . ' is different');
				$isSameAddress = false;
				break;
			}
		}
		
		if ($isSameAddress) {
			$cacheKey = $this->getCacheKey($addr);
			$this->setCacheValue($cacheKey, $addrId);	
		}
	}

	protected function setShipmentCacheValues($response, array $params)
	{
		$this->logger->debug(__FILE__, __LINE__, 'setShipmentCacheValues');

		if (!empty($response['from_address'])) {
			$origin = array();
			if (!empty($params['origin'])) {
				$origin = $params['origin'];
			}

			if (empty($origin) && !empty($this->origin)) {
				$origin = $this->origin;
			}
		
			if (!empty($origin)) {
				$this->setAddressCacheValue($response['from_address'], $origin);
			}
		}

		if (!empty($response['to_address']) && !empty($params['destination'])) {
			$this->setAddressCacheValue($response['to_address'], $params['destination']);
		}

		if (!empty($response['parcel']['id'])) {
			$parcelId = $response['parcel']['id'];
			$this->logger->debug(__FILE__, __LINE__, 'Cache parcel ID: ' . $parcelId);

			$parcel = $this->prepareParcelInfo($params);
			$cacheKey = $this->getCacheKey($parcel);

			$this->setCacheValue($cacheKey, $parcelId);
		}

		if (!empty($response['customs_info']['id'])) {
			$customsInfoId = $response['customs_info']['id'];
			$this->logger->debug(__FILE__, __LINE__, 'Cache customs info ID: ' . $customsInfoId);

			$customsInfo = $this->prepareCustomsInfo($params);
			$cacheKey = $this->getCacheKey($customsInfo);

			$this->setCacheValue($cacheKey, $customsInfoId);
		}
	}

	protected function getResponse($response, array $params)
	{
		$this->logger->debug(__FILE__, __LINE__, 'getResponse');

		$newResponse = array('response' => $response, 'params' => $params);

		if (!empty($response['error'])) {
			$newResponse['error']['message'] = $this->getErrorMessage($response['error']);
		}

		if (!empty($params['function']) && $params['function'] == 'getRates') {
			$newResponse = array_replace_recursive($newResponse, $this->getRatesResponse($response, $params));
		}

		return $newResponse;
	}

	protected function getRouteUrl($route)
	{
		$routeUrl = sprintf('https://api.easypost.com/v2/%s',
			$route);

		return $routeUrl;
	}

	protected function getApiKey()
	{
		return ($this->sandbox ? $this->testApiKey : $this->apiKey);
	}

	protected function addHeadersAndParams(&$headers, &$params)
	{
		$headers['Authorization'] = 'Bearer ' . $this->getApiKey();
	}

	protected function getServiceName($carrier, $service)
	{
		$serviceId = $this->getServiceId($carrier, $service);

		if (!empty($this->_services[$serviceId])) {
			return $this->_services[$serviceId];
		}

		return $service;
	}

	protected function getServiceId($carrier, $service)
	{
		return $carrier . '_' . $service;
	}

	protected function initPackageTypes()
	{
		$this->packageTypes = array(
			'parcel' => 'Parcel',
			'DHLExpress_JumboDocument' => 'DHL Express Jumbo Document',
			'DHLExpress_JumboParcel' => 'DHL Express Jumbo Parcel',
			'DHLExpress_Document' => 'DHL Express Document',
			'DHLExpress_DHLFlyer' => 'DHL Express DHL Flyer',
			'DHLExpress_Domestic' => 'DHL Express Domestic',
			'DHLExpress_ExpressDocument' => 'DHL Express Express Document',
			'DHLExpress_DHLExpressEnvelope' => 'DHL Express Envelope',
			'DHLExpress_JumboBox' => 'DHL Express JumboBox',
			'DHLExpress_JumboJuniorDocument' => 'DHL Express Jumbo Junior Document',
			'DHLExpress_JuniorJumboBox' => 'DHL Express Junior JumboBox',
			'DHLExpress_JumboJuniorParcel' => 'DHL Express Jumbo Junior Parcel',
			'DHLExpress_OtherDHLPackaging' => 'DHL Express Other Packaging',
			'DHLExpress_Parcel' => 'DHL Express Parcel',
			'DHLExpress_YourPackaging' => 'DHL Express Your Packaging',
			'DHLGlobalMail_Letter' => 'DHL eCommerce Letter',
			'DHLGlobalMail_Flat' => 'DHL eCommerce Flat',
			'DHLGlobalMail_BPM' => 'DHL eCommerce BPM',
			'DHLGlobalMail_Parcel' => 'DHL eCommerce Parcel',
			'DirectLink_Parcel' => 'DirectLink Parcel',
			'DirectLink_Document' => 'DirectLink Document',
			'DPDUK_Parcel' => 'DPD UK Parcel',
			'DPDUK_Pallet' => 'DPD UK Pallet',
			'DPDUK_ExpressPak' => 'DPDUK ExpressPak',
			'DPDUK_FreightParcel' => 'DPDUK Freight Parcel',
			'DPDUK_Freight' => 'DPDUK Freight',
			'Estafeta_ENVELOPE' => 'Estafeta ENVELOPE',
			'Estafeta_PARCEL' => 'Estafeta PARCEL',
			'Fastway_Parcel' => 'Fastway Parcel',
			'Fastway_Satchel' => 'Fastway Satchel',
			'Fastway_ParcelBlack' => 'Fastway Parcel Black',
			'Fastway_ParcelBlue' => 'Fastway Parcel Blue',
			'Fastway_ParcelBrown' => 'Fastway Parcel Brown',
			'Fastway_ParcelGreen' => 'Fastway Parcel Green',
			'Fastway_ParcelGrey' => 'Fastway Parcel Grey',
			'Fastway_ParcelLime' => 'Fastway Parcel Lime',
			'Fastway_ParcelOrange' => 'Fastway Parcel Orange',
			'Fastway_ParcelRed' => 'Fastway Parcel Red',
			'Fastway_ParcelWhite' => 'Fastway Parcel White',
			'Fastway_ParcelYellow' => 'Fastway Parcel Yellow',
			'Fastway_SatchelSat-Loc-A3' => 'Fastway SatchelSat Loc A3',
			'Fastway_SatchelSat-Nat-A2' => 'Fastway SatchelSat Nat A2',
			'Fastway_SatchelSat-Nat-A3' => 'Fastway SatchelSat Nat A3',
			'Fastway_SatchelSat-Nat-A4' => 'Fastway SatchelSat Nat A4',
			'Fastway_SatchelSat-Nat-A5' => 'Fastway SatchelSat Nat A5',
			'Fastway_ParcelLrg-Flat-Rate-Parcel' => 'Fastway Parcel Large Flat Rate Parcel',
			'Fastway_ParcelMed-Flat-Rate-Parcel' => 'Fastway Parcel Medium Flat Rate Parcel',
			'Fastway_ParcelSml-Flat-Rate-Parcel' => 'Fastway Parcel Small Flat Rate Parcel',
			'Fastway_BoxMed' => 'Fastway Box Medium',
			'Fastway_BoxSml' => 'Fastway Box Small',
			'FedEx_FedExEnvelope' => 'FedEx Envelope',
			'FedEx_FedExBox' => 'FedEx Box',
			'FedEx_FedExPak' => 'FedEx Pak',
			'FedEx_FedExTube' => 'FedEx Tube',
			'FedEx_FedEx10kgBox' => 'FedEx 10kg Box',
			'FedEx_FedEx25kgBox' => 'FedEx 25kg Box',
			'FedEx_FedExSmallBox' => 'FedEx Small Box',
			'FedEx_FedExMediumBox' => 'FedEx Medium Box',
			'FedEx_FedExLargeBox' => 'FedEx Large Box',
			'FedEx_FedExExtraLargeBox' => 'FedEx Extra Large Box',
			'InterlinkExpress_Parcel' => 'Interlink Express Parcel',
			'InterlinkExpress_Pallet' => 'Interlink Express Pallet',
			'InterlinkExpress_ExpressPak' => 'Interlink Express Pak',
			'InterlinkExpress_FreightParcel' => 'Interlink Express Freight Parcel',
			'InterlinkExpress_Freight' => 'Interlink Express Freight',
			'LaserShip_Box' => 'LaserShip Box',
			'LaserShip_Tube' => 'LaserShip Tube',
			'LaserShip_Pak' => 'LaserShip Pak',
			'LaserShip_Envelope' => 'LaserShip Envelope',
			'LaserShip_Custom' => 'LaserShip Custom',
			'Liefery_SmallParcel' => 'Liefery Small Parcel',
			'Liefery_MediumParcel' => 'Liefery Medium Parcel',
			'Liefery_LargeParcel' => 'Liefery Large Parcel',
			'Liefery_ExtraLargeParcel' => 'Liefery Extra Large Parcel',
			'OnTrac_Letter' => 'OnTrac Letter',
			'Purolator_CustomerPackaging' => 'Purolator Customer Packaging',
			'Purolator_ExpressPack' => 'Purolator Express Pack',
			'Purolator_ExpressBox' => 'Purolator Express Box',
			'Purolator_ExpressEnvelope' => 'Purolator Express Envelope',
			'RoyalMail_Letter' => 'Royal Mail Letter',
			'RoyalMail_LargeLetter' => 'Royal Mail Large Letter',
			'RoyalMail_SmallParcel' => 'Royal Mail Small Parcel',
			'RoyalMail_MediumParcel' => 'Royal Mail Medium Parcel',
			'SprintShip_ENVELOPE' => 'Sprint Ship ENVELOPE',
			'SprintShip_LARGE_BOX_OR_TOTE' => 'SprintShip LARGE BOX OR TOTE',
			'SprintShip_MULTI_PACK' => 'SprintShip MULTI PACK',
			'SprintShip_SMALL_OR_MEDIUM_BOX_OR_TOTE' => 'SprintShip SMALL OR MEDIUM BOX OR TOTE',
			'SprintShip_PACKAGE' => 'SprintShip PACKAGE',
			'StarTrack_Carton' => 'StarTrack Carton',
			'StarTrack_Pallet' => 'StarTrack Pallet',
			'StarTrack_Satchel' => 'StarTrack Satchel',
			'StarTrack_Bag' => 'StarTrack Bag',
			'StarTrack_Envelope' => 'StarTrack Envelope',
			'StarTrack_Item' => 'StarTrack Item',
			'StarTrack_Jiffybag' => 'StarTrack Jiffybag',
			'StarTrack_Skid' => 'StarTrack Skid',
			'TForce_Parcel' => 'TForce Parcel',
			'TForce_Letter' => 'TForce Letter',
			'UPS_UPSLetter' => 'UPS UPSLetter',
			'UPS_UPSExpressBox' => 'UPS Express Box',
			'UPS_UPS25kgBox' => 'UPS 25kg Box',
			'UPS_UPS10kgBox' => 'UPS 10kg Box',
			'UPS_Tube' => 'UPS Tube',
			'UPS_Pak' => 'UPS Pak',
			'UPS_SmallExpressBox' => 'UPS Small Express Box',
			'UPS_MediumExpressBox' => 'UPS Medium Express Box',
			'UPS_LargeExpressBox' => 'UPS Large Express Box',
			'USPS_Card' => 'USPS Card',
			'USPS_Letter' => 'USPS Letter',
			'USPS_Flat' => 'USPS Flat',
			'USPS_FlatRateEnvelope' => 'USPS Flat Rate Envelope',
			'USPS_FlatRateLegalEnvelope' => 'USPS Flat Rate Legal Envelope',
			'USPS_FlatRatePaddedEnvelope' => 'USPS Flat Rate Padded Envelope',
			'USPS_Parcel' => 'USPS Parcel',
			'USPS_IrregularParcel' => 'USPS Irregular Parcel',
			'USPS_SoftPack' => 'USPS Soft Pack',
			'USPS_SmallFlatRateBox' => 'USPS Small Flat Rate Box',
			'USPS_MediumFlatRateBox' => 'USPS Medium Flat Rate Box',
			'USPS_LargeFlatRateBox' => 'USPS Large Flat Rate Box',
			'USPS_LargeFlatRateBoxAPOFPO' => 'USPS Large Flat Rate Box APO/FPO',
			'USPS_RegionalRateBoxA' => 'USPS Regional Rate Box A',
			'USPS_RegionalRateBoxB' => 'USPS Regional Rate Box B'
		);
	}

	protected function initCarriers()
	{
		$this->_carriers = array(
			'AmazonMws' => 'AmazonMws',
			'APC' => 'APC',
			'Aramex' => 'Aramex',
			'ArrowXL' => 'ArrowXL',
			'Asendia' => 'Asendia',
			'AustraliaPost' => 'Australia Post',
			'AxlehireV3' => 'AxlehireV3',
			'BorderGuru' => 'BorderGuru',
			'Cainiao' => 'Cainiao',
			'CanadaPost' => 'Canada Post',
			'Canpar' => 'Canpar',
			'ColumbusLastMile' => 'CDL Last Mile Solutions',
			'Chronopost' => 'Chronopost',
			'ColisPrive' => 'Colis Privé',
			'Colissimo' => 'Colissimo',
			'CouriersPlease' => 'CouriersPlease',
			'DaiPost' => 'Dai Post',
			'Deliv' => 'Deliv',
			'DeutschePost' => 'Deutsche Post',
			'DeutschePostUK' => 'Deutsche Post UK',
			'DHLEcommerceAsia' => 'DHL eCommerce Asia',
			'DHLExpress' => 'DHL Express',
			'DHLFreight' => 'DHL Freight',
			'DHLGermany' => 'DHL Germany',
			'DHLGlobalMail' => 'DHL eCommerce',
			'DHLGlobalmailInternational' => 'DHL eCommerce International',
			'Dicom' => 'Dicom',
			'DirectLink' => 'Direct Link',
			'Doorman' => 'Doorman',
			'DPD' => 'DPD',
			'DPDUK' => 'DPD UK',
			'ChinaEMS' => 'China EMS',
			'Estafeta' => 'Estafeta',
			'Estes' => 'Estes',
			'Fastway' => 'Fastway',
			'FedEx' => 'FedEx',
			'FedExMailview' => 'FedEx Mailview',
			'FedExSameDayCity' => 'FedEx SameDay City',
			'FedExUK' => 'FedEx UK',
			'FedexSmartPost' => 'FedEx SmartPost',
			'FirstMile' => 'FirstMile',
			'Globegistics' => 'Globegistics',
			'GSO' => 'GSO',
			'Hermes' => 'Hermes',
			'HongKongPost' => 'Hong Kong Post',
			'InterlinkExpress' => 'Interlink Express',
			'JancoFreight' => 'Janco Freight',
			'JPPost' => 'JP Post',
			'KuronekoYamato' => 'Kuroneko Yamato',
			'LaPoste' => 'La Poste',
			'LaserShipV2' => 'LaserShipV2',
			'LatvijasPasts' => 'Latvijas Pasts',
			'Liefery' => 'Liefery',
			'LoomisExpress' => 'Loomis Express',
			'LSO' => 'LSO',
			'Network4' => 'Network4',
			'Newgistics' => 'Newgistics',
			'Norco' => 'Norco',
			'OmniParcel' => 'OmniParcel',
			'OnTrac' => 'OnTrac',
			'OnTracDirectPost' => 'OnTrac DirectPost',
			'OrangeDS' => 'Orange DS',
			'OsmWorldwide' => 'Osm Worldwide',
			'Parcelforce' => 'Parcelforce',
			'Passport' => 'Passport',
			'Pilot' => 'Pilot',
			'PostNL' => 'PostNL',
			'Posten' => 'Posten',
			'PostNord' => 'PostNord',
			'Purolator' => 'Purolator',
			'RoyalMail' => 'Royal Mail',
			'RRDonnelley' => 'RR Donnelley',
			'Seko' => 'Seko',
			'SingaporePost' => 'Singapore Post',
			'SpeeDee' => 'Spee-Dee',
			'SprintShip' => 'SprintShip',
			'StarTrack' => 'StarTrack',
			'Toll' => 'Toll',
			'TForce' => 'TForce',
			'UDS' => 'UDS',
			'Ukrposhta' => 'Ukrposhta',
			'UPS' => 'UPS',
			'UPSIparcel' => 'UPS i-parcel',
			'UPSMailInnovations' => 'UPS Mail Innovations',
			'USPS' => 'USPS',
			'Veho' => 'Veho',
			'Yanwen' => 'Yanwen',
			'Yodel' => 'Yodel',
		);
	}

	protected function initServices()
	{
		$this->_services = array(
			'AmazonMws_UPS Rates' => 'Amazon UPS Rates',
			'AmazonMws_USPS Rates' => 'Amazon USPS Rates',
			'AmazonMws_FedEx Rates' => 'Amazon FedEx Rates',
			'AmazonMws_UPS Labels' => 'Amazon UPS Labels',
			'AmazonMws_USPS Labels' => 'Amazon USPS Labels',
			'AmazonMws_FedEx Labels' => 'Amazon Fedex Labels',
			'AmazonMws_UPS Tracking' => 'Amazon UPS Tracking',
			'AmazonMws_USPS Tracking' => 'Amazon USPS Tracking',
			'AmazonMws_FedEx Tracking' => 'Amazon FedEx Tracking',
			'APC_parcelConnectBookService' => 'APC Parcel Connect Book Service',
			'APC_parcelConnectExpeditedDDP' => 'APC Parcel Connect Expedited DDP',
			'APC_parcelConnectExpeditedDDU' => 'APC Parcel Connect Expedited DDU',
			'APC_parcelConnectPriorityDDP' => 'APC Parcel Connect Priority DDP',
			'APC_parcelConnectPriorityDDPDelcon' => 'APC Parcel Connect Priority DDP Delcon',
			'APC_parcelConnectPriorityDDU' => 'APC Parcel Connect Priority DDU',
			'APC_parcelConnectPriorityDDUDelcon' => 'APC Parcel Connect Priority DDU Delcon',
			'APC_parcelConnectPriorityDDUPQW' => 'APC Parcel Connect Priority DDUPQW',
			'APC_parcelConnectStandardDDU' => 'APC Parcel Connect Standard DDU',
			'APC_parcelConnectStandardDDUPQW' => 'APC Parcel Connect Standard DDUPQW',
			'APC_parcelConnectPacketDDU' => 'APC Parcel Connect Packet DDU',
			'Aramex_Domestic' => 'Aramex Domestic',
			'Aramex_PriorityDocumentExpress' => 'Aramex Priority Document Express',
			'Aramex_PriorityParcelExpress' => 'Aramex Priority Parcel Express',
			'Aramex_PriorityLetterExpress' => 'Aramex Priority Letter Express',
			'Aramex_DeferredDocumentExpress' => 'Aramex Deferred Document Express',
			'Aramex_DeferredParcelExpress' => 'Aramex Deferred Parcel Express',
			'Aramex_GroundDocumentExpress' => 'Aramex Ground Document Express',
			'Aramex_GroundParcelExpress' => 'Aramex Ground Parcel Express',
			'Aramex_EconomyParcelExpress' => 'Aramex Economy Parcel Express',
			'ArrowXL_48HRBrownInstall' => 'ArrowXL 48HR Brown Install',
			'ArrowXL_48HRBrownInstallRemove' => 'ArrowXL 48HR Brown Install Remove',
			'ArrowXL_48HROther' => 'ArrowXL 48HR Other',
			'ArrowXL_48HROtherRemove' => 'ArrowXL 48HR Other Remove',
			'ArrowXL_48HRWhiteInstall' => 'ArrowXL 48HR White Install',
			'ArrowXL_48HRWhiteInstallRemove' => 'ArrowXL 48HR White Install Remove',
			'ArrowXL_48HRWhiteRemove' => 'ArrowXL 48HR White Remove',
			'ArrowXL_ExpressBrownInstall' => 'ArrowXL Express Brown Install',
			'ArrowXL_ExpressBrownInstallRemove' => 'ArrowXL Express Brown Install Remove',
			'ArrowXL_ExpressOther' => 'ArrowXL Express Other',
			'ArrowXL_ExpressOtherRemove' => 'ArrowXL Express Other Remove',
			'ArrowXL_ExpressWhiteInstall' => 'ArrowXL Express White Install',
			'ArrowXL_ExpressWhiteInstallRemove' => 'ArrowXL Express White Install Remove',
			'ArrowXL_ExpressWhiteRemove' => 'ArrowXL Express White Remove',
			'ArrowXL_StandardBrownInstall' => 'ArrowXL Standard Brown Install',
			'ArrowXL_StandardBrownInstallRemove' => 'ArrowXL Standard Brown Install Remove',
			'ArrowXL_StandardBrownRemove' => 'ArrowXL Standard Brown Remove',
			'ArrowXL_StandardOther' => 'ArrowXL Standard Other',
			'ArrowXL_StandardOtherAssemble' => 'ArrowXL Standard Other Assemble',
			'ArrowXL_StandardOtherNoUnpack' => 'ArrowXL Standard Other No Unpack',
			'ArrowXL_StandardOtherRemove' => 'ArrowXL Standard Other Remove',
			'ArrowXL_StandardOtherUnpack' => 'ArrowXL Standard Other Unpack',
			'ArrowXL_StandardOtherUnpackLeavePackaging' => 'ArrowXL Standard Other Unpack Leave Packaging',
			'ArrowXL_StandardReturns' => 'ArrowXL Standard Returns',
			'ArrowXL_StandardWhiteInstall' => 'ArrowXL Standard White Install',
			'ArrowXL_StandardWhiteInstallRemove' => 'ArrowXL Standard White Install Remove',
			'ArrowXL_StandardWhiteRemove' => 'ArrowXL Standard White Remove',
			'Asendia_PMI' => 'Asendia PMI',
			'Asendia_ePacket' => 'Asendia ePacket',
			'Asendia_IPA' => 'Asendia IPA',
			'Asendia_ISAL' => 'Asendia ISAL',
			'AustraliaPost_ExpressPost' => 'Australia Post Express Post',
			'AustraliaPost_ExpressPostSignature' => 'Australia Post Express Pos tSignature',
			'AustraliaPost_ParcelPost' => 'Australia Post Parcel Post',
			'AustraliaPost_ParcelPostSignature' => 'Australia Post Parcel Post Signature',
			'AustraliaPost_ParcelPostExtra' => 'Australia Post Parcel Post Extra',
			'AustraliaPost_ParcelPostWinePlusSignature' => 'Australia Post Parcel Post Wine Plus Signature',
			'AxlehireV3_AxleHireDelivery' => 'AxleHire Delivery',
			'BorderGuru_ECONOMY' => 'BorderGuru Economy',
			'BorderGuru_PRIORITY' => 'BorderGuru Priority',
			'BorderGuru_EXPEDITED' => 'BorderGuru Expedited',
			'Cainiao_Cainiao' => 'Cainiao',
			'CanadaPost_RegularParcel' => 'Canada Post Regular Parcel',
			'CanadaPost_ExpeditedParcel' => 'Canada Post Expedited Parcel',
			'CanadaPost_Xpresspost' => 'Canada Post Xpresspost',
			'CanadaPost_XpresspostCertified' => 'Canada Post Xpresspost Certified',
			'CanadaPost_Priority' => 'Canada Post Priority',
			'CanadaPost_LibraryBooks' => 'Canada Post Library Books',
			'CanadaPost_ExpeditedParcelUSA' => 'Canada Post Expedited Parcel USA',
			'CanadaPost_PriorityWorldwideEnvelopeUSA' => 'Canada Post Priority Worldwide Envelope USA',
			'CanadaPost_PriorityWorldwidePakUSA' => 'Canada Post Priority Worldwide Pak USA',
			'CanadaPost_PriorityWorldwideParcelUSA' => 'Canada Post Priority Worldwide Parcel USA',
			'CanadaPost_SmallPacketUSAAir' => 'Canada Post Small Packet USA Air',
			'CanadaPost_TrackedPacketUSA' => 'Canada Post Tracked Packet USA',
			'CanadaPost_TrackedPacketUSALVM' => 'Canada Post Tracked Packet USA LVM',
			'CanadaPost_XpresspostUSA' => 'Canada Post Xpresspost USA',
			'CanadaPost_XpresspostInternational' => 'Canada Post Xpresspost International',
			'CanadaPost_InternationalParcelAir' => 'Canada Post International Parcel Air',
			'CanadaPost_InternationalParcelSurface' => 'Canada Post International Parcel Surface',
			'CanadaPost_PriorityWorldwideEnvelopeIntl' => 'Canada Post Priority Worldwide Envelope Intl',
			'CanadaPost_PriorityWorldwidePakIntl' => 'Canada Post Priority Worldwide Pak Intl',
			'CanadaPost_PriorityWorldwideParcelIntl' => 'Canada Post Priority Worldwide Parcel Intl',
			'CanadaPost_SmallPacketInternationalAir' => 'Canada Post Small Packet International Air',
			'CanadaPost_SmallPacketInternationalSurface' => 'Canada Post Small Packet International Surface',
			'CanadaPost_TrackedPacketInternational' => 'Canada Post Tracked Packet International',
			'Canpar_Ground' => 'Canpar Ground',
			'Canpar_SelectLetter' => 'Canpar Select Letter',
			'Canpar_SelectPak' => 'Canpar Select Pak',
			'Canpar_Select' => 'Canpar Select',
			'Canpar_OvernightLetter' => 'Canpar Overnight Letter',
			'Canpar_OvernightPak' => 'Canpar Overnight Pak',
			'Canpar_Overnight' => 'Canpar Overnight',
			'Canpar_SelectUSA' => 'Canpar Select USA',
			'Canpar_USAPak' => 'Canpar USA Pak',
			'Canpar_USALetter' => 'Canpar USA Letter',
			'Canpar_USA' => 'Canpar USA',
			'Canpar_International' => 'Canpar International',
			'ColumbusLastMile_DISTRIBUTION' => 'ColumbusLastMile DISTRIBUTION',
			'ColumbusLastMile_Same Day' => 'ColumbusLastMile Same Day',
			'Chronopost_Chronopost' => 'Chronopost',
			'ColisPrive_Parcel' => 'Colis Privé Parcel',
			'Colissimo_Colissimo' => 'Colissimo',
			'CouriersPlease_DomesticPrioritySignature' => 'CouriersPlease Domestic Priority Signature',
			'CouriersPlease_DomesticPriority' => 'CouriersPlease Domestic Priority',
			'CouriersPlease_DomesticOffPeakSignature' => 'CouriersPlease Domestic Off Peak Signature',
			'CouriersPlease_DomesticOffPeak' => 'CouriersPlease Domestic Off Peak',
			'CouriersPlease_GoldDomesticSignature' => 'CouriersPlease Gold Domestic Signature',
			'CouriersPlease_GoldDomestic' => 'CouriersPlease Gold Domestic',
			'CouriersPlease_AustralianCityExpressSignature' => 'CouriersPlease Australian City Express Signature',
			'CouriersPlease_AustralianCityExpress' => 'CouriersPlease Australian City Express',
			'CouriersPlease_DomesticSaverSignature' => 'CouriersPlease Domestic Saver Signature',
			'CouriersPlease_DomesticSaver' => 'CouriersPlease Domestic Saver',
			'CouriersPlease_RoadExpress' => 'CouriersPlease Road Express',
			'CouriersPlease_5KgSatchel' => 'CouriersPlease 5Kg Satchel',
			'CouriersPlease_3KgSatchel' => 'CouriersPlease 3Kg Satchel',
			'CouriersPlease_1KgSatchel' => 'CouriersPlease 1Kg Satchel',
			'CouriersPlease_5KgSatchelATL' => 'CouriersPlease 5Kg Satchel ATL',
			'CouriersPlease_3KgSatchelATL' => 'CouriersPlease 3Kg Satchel ATL',
			'CouriersPlease_1KgSatchelATL' => 'CouriersPlease 1Kg Satchel ATL',
			'CouriersPlease_500GramSatchel' => 'CouriersPlease 500Gram Satchel',
			'CouriersPlease_500GramSatchelATL' => 'CouriersPlease 500Gram Satchel ATL',
			'CouriersPlease_25KgParcel' => 'CouriersPlease 25Kg Parcel',
			'CouriersPlease_10KgParcel' => 'CouriersPlease 10Kg Parcel',
			'CouriersPlease_5KgParcel' => 'CouriersPlease 5Kg Parcel',
			'CouriersPlease_3KgParcel' => 'CouriersPlease 3Kg Parcel',
			'CouriersPlease_1KgParcel' => 'CouriersPlease 1Kg Parcel',
			'CouriersPlease_500GramParcel' => 'CouriersPlease 500Gram Parcel',
			'CouriersPlease_500GramParcelATL' => 'CouriersPlease 500Gram Parcel ATL',
			'CouriersPlease_ExpressInternationalPriority' => 'CouriersPlease Express International Priority',
			'CouriersPlease_InternationalSaver' => 'CouriersPlease International Saver',
			'CouriersPlease_InternationalExpressImport' => 'CouriersPlease International Express Import',
			'CouriersPlease_ExpressInternationalPriority' => 'CouriersPlease ExpressInternational Priority',
			'CouriersPlease_InternationalExpress' => 'CouriersPlease International Express',
			'DaiPost_DomesticTracked' => 'DaiPost Domestic Tracked',
			'DaiPost_InternationalEconomy' => 'DaiPost International Economy',
			'DaiPost_InternationalStandard' => 'DaiPost International Standard',
			'DaiPost_InternationalExpress' => 'DaiPost International Express',
			'Deliv_Scheduled' => 'Deliv Scheduled',
			'Deliv_OnDemand' => 'Deliv On Demand',
			'DeutschePost_PacketPlus' => 'Deutsche Post Packet Plus',
			'DeutschePostUK_PriorityPacketPlus' => 'Deutsche Post UK Priority Packet Plus',
			'DeutschePostUK_PriorityPacket' => 'Deutsche Post UK Priority Packet',
			'DeutschePostUK_PriorityPacketTracked' => 'Deutsche Post UK Priority Packet Tracked',
			'DeutschePostUK_BusinessMailRegistered' => 'Deutsche Post UK Business Mail Registered',
			'DeutschePostUK_StandardPacket' => 'Deutsche Post UK Standard Packet',
			'DeutschePostUK_BusinessMailStandard' => 'Deutsche Post UK Business Mail Standard',
			'DHLEcommerceAsia_Packet' => 'DHL eCommerce Asia Packet',
			'DHLEcommerceAsia_PacketPlus' => 'DHL eCommerce Asia PacketPlus',
			'DHLEcommerceAsia_ParcelDirect' => 'DHL eCommerce Asia ParcelDirect',
			'DHLEcommerceAsia_ParcelDirectExpedited' => 'DHL eCommerce Asia Parcel Direct Expedited',
			'DHLExpress_BreakBulkEconomy' => 'DHL Express Break Bulk Economy',
			'DHLExpress_BreakBulkExpress' => 'DHL Express Break Bulk Express',
			'DHLExpress_DomesticEconomySelect' => 'DHL Express Domestic Economy Select',
			'DHLExpress_DomesticExpress' => 'DHL Express Domestic Express',
			'DHLExpress_DomesticExpress1030' => 'DHL Express Domestic Express 1030',
			'DHLExpress_DomesticExpress1200' => 'DHL Express Domestic Express 1200',
			'DHLExpress_EconomySelect' => 'DHL Express Economy Select',
			'DHLExpress_EconomySelectNonDoc' => 'DHL Express Economy Select Non Doc',
			'DHLExpress_EuroPack' => 'DHL Express Euro Pack',
			'DHLExpress_EuropackNonDoc' => 'DHL Express Europack Non Doc',
			'DHLExpress_Express1030' => 'DHL Express Express 1030',
			'DHLExpress_Express1030NonDoc' => 'DHL Express Express 1030 Non Doc',
			'DHLExpress_Express1200NonDoc' => 'DHL Express Express 1200 Non Doc',
			'DHLExpress_Express1200' => 'DHL Express Express 1200',
			'DHLExpress_Express900' => 'DHL Express Express 900',
			'DHLExpress_Express900NonDoc' => 'DHL Express Express900NonDoc',
			'DHLExpress_ExpressEasy' => 'DHL Express Express Easy',
			'DHLExpress_ExpressEasyNonDoc' => 'DHL Express Express Easy Non Doc',
			'DHLExpress_ExpressEnvelope' => 'DHL Express Express Envelope',
			'DHLExpress_ExpressWorldwide' => 'DHL Express Express Worldwide',
			'DHLExpress_ExpressWorldwideB2C' => 'DHL Express Express Worldwide B2C',
			'DHLExpress_ExpressWorldwideB2CNonDoc' => 'DHL Express Express Worldwide B2C NonDoc',
			'DHLExpress_ExpressWorldwideECX' => 'DHL Express Express Worldwide ECX',
			'DHLExpress_ExpressWorldwideNonDoc' => 'DHL Express Express Worldwide Non Doc',
			'DHLExpress_FreightWorldwide' => 'DHL Express Freight Worldwide',
			'DHLExpress_GlobalmailBusiness' => 'DHL Express Globalmail Business',
			'DHLExpress_JetLine' => 'DHL Express Jet Line',
			'DHLExpress_JumboBox' => 'DHL Express Jumbo Box',
			'DHLExpress_LogisticsServices' => 'DHL Express Logistics Services',
			'DHLExpress_SameDay' => 'DHL Express Same Day',
			'DHLExpress_SecureLine' => 'DHL Express Secure Line',
			'DHLExpress_SprintLine' => 'DHL Express Sprint Line',
			'DHLFreight_DHLFreight' => 'DHL Freight',
			'DHLGermany_DHLGermany' => 'DHL Germany',
			'DHLGlobalMail_BPMExpeditedDomestic' => 'DHL eCommerce BPM Expedited Domestic',
			'DHLGlobalMail_BPMGroundDomestic' => 'DHL eCommerce BPM Ground Domestic',
			'DHLGlobalMail_FlatsExpeditedDomestic' => 'DHL eCommerce Flats Expedited Domestic',
			'DHLGlobalMail_FlatsGroundDomestic' => 'DHL eCommerce Flats Ground Domestic',
			'DHLGlobalMail_MediaMailGroundDomestic' => 'DHL eCommerce Media Mail Ground Domestic',
			'DHLGlobalMail_ParcelExpeditedMax' => 'DHL eCommerce Parcel Expedited Max',
			'DHLGlobalMail_ParcelPlusExpeditedDomestic' => 'DHL eCommerce Parcel Plus Expedited Domestic',
			'DHLGlobalMail_ParcelPlusGroundDomestic' => 'DHL eCommerce Parcel Plus Ground Domestic',
			'DHLGlobalMail_ParcelsExpeditedDomestic' => 'DHL eCommerce Parcels Expedited Domestic',
			'DHLGlobalMail_ParcelsGroundDomestic' => 'DHL eCommerce Parcels Ground Domestic',
			'DHLGlobalmailInternational_DHLPacketInternationalPriority' => 'DHL eCommerce Packet International Priority',
			'DHLGlobalmailInternational_DHLPacketInternationalStandard' => 'DHL eCommerce Packet International Standard',
			'DHLGlobalmailInternational_DHLPacketPlusInternational' => 'DHL eCommerce Packet Plus International',
			'DHLGlobalmailInternational_DHLPacketIPA' => 'DHL eCommerce Packet IPA',
			'DHLGlobalmailInternational_DHLPacketISAL' => 'DHL eCommerce Packet ISAL',
			'DHLGlobalmailInternational_DHLParcelInternationalPriority' => 'DHL eCommerce Parcel International Priority',
			'DHLGlobalmailInternational_DHLParcelInternationalStandard' => 'DHL eCommerce Parcel International Standard',
			'DHLGlobalmailInternational_DHLParcelDirectInternationalPriority' => 'DHL eCommerce Parcel Direct International Priority',
			'DHLGlobalmailInternational_DHLParcelDirectInternationalExpedited' => 'DHL eCommerce Direct International Expedited',
			'Dicom_Ground' => 'Dicom Ground',
			'DirectLink_RegisteredMail' => 'Direct Link Registered Mail',
			'DirectLink_UntrackedMail' => 'Direct Link Untracked Mail',
			'DirectLink_ParcelMail' => 'Direct Link Parcel Mail',
			'DoormanDirect_DoormanDirect' => 'Doorman Direct',
			'DPD_DPDCLASSIC' => 'DPD CLASSIC',
			'DPD_DPD8:30' => 'DPD 8:30',
			'DPD_DPD10:00' => 'DPD 10:00',
			'DPD_DPD12:00' => 'DPD 12:00',
			'DPD_DPD18:00' => 'DPD 18:00',
			'DPD_DPDEXPRESS' => 'DPD EXPRESS',
			'DPD_DPDPARCELLETTER' => 'DPD PARCEL LETTER',
			'DPD_DPDPARCELLETTERPLUS' => 'DPD PARCEL LETTER PLUS',
			'DPD_DPDINTERNATIONALMAIL' => 'DPD INTERNATIONAL MAIL',
			'DPDUK_DPDUK' => 'DPD UK',
			'ChinaEMS_ChinaEMS' => 'China EMS',
			'Estafeta_NextDayBy930' => 'Estafeta Next Day By 9:30',
			'Estafeta_NextDayBy1130' => 'Estafeta Next Day By 11:30',
			'Estafeta_NextDay' => 'Estafeta Next Day',
			'Estafeta_Ground' => 'Estafeta Ground',
			'Estafeta_TwoDay' => 'Estafeta Two Day',
			'Estafeta_LTL' => 'Estafeta LTL',
			'Estes_Estes' => 'Estes',
			'Fastway_Parcel' => 'Fastway Parcel',
			'Fastway_Satchel' => 'Fastway Satchel',
			'FedEx_FEDEX_GROUND' => 'FedEx Ground',
			'FedEx_FEDEX_2_DAY' => 'FedEx 2 Day',
			'FedEx_FEDEX_2_DAY_AM' => 'Fedex 2 Day AM',
			'FedEx_FEDEX_EXPRESS_SAVER' => 'FedEx Express Saver',
			'FedEx_STANDARD_OVERNIGHT' => 'FedEx Standard Overnight',
			'FedEx_FIRST_OVERNIGHT' => 'FedEx First Overnight',
			'FedEx_PRIORITY_OVERNIGHT' => 'FedEx Priority Overnight',
			'FedEx_INTERNATIONAL_ECONOMY' => 'FedEx International Economy',
			'FedEx_INTERNATIONAL_FIRST' => 'FedEx International First',
			'FedEx_INTERNATIONAL_PRIORITY' => 'FedEx International Priority',
			'FedEx_GROUND_HOME_DELIVERY' => 'FedEx Ground Home Delivery',
			'FedEx_SMART_POST' => 'FedEx Smart Post',
			'FedExMailview_FedExMailview' => 'FedEx Mailview',
			'FedExSameDayCity_EconomyService' => 'FedEx SameDay City Economy Service',
			'FedExSameDayCity_StandardService' => 'FedEx SameDay City Standard Service',
			'FedExSameDayCity_PriorityService' => 'FedEx SameDay City Priority Service',
			'FedExSameDayCity_LastMile' => 'FedEx SameDay City Last Mile',
			'FedExUK_FEDEX_NEXT_DAY_EARLY_MORNING' => 'FedEx Next Day Early Morning',
			'FedExUK_FEDEX_NEXT_DAY_MID_MORNING' => 'FedEx Next Day Mid Morning',
			'FedExUK_FEDEX_NEXT_DAY_AFTERNOON' => 'FedEx Next Day Afternoon',
			'FedExUK_FEDEX_NEXT_DAY_END_OF_DAY' => 'FedEx Next Day End Of Day',
			'FedExUK_FEDEX_DISTANCE_DEFERRED' => 'FedEx Distance Deferred',
			'FedExUK_FEDEX_NEXT_DAY_FREIGHT' => 'FedEx Next Day Freight',
			'FedexSmartPost_SMART_POST' => 'FedEx SmartPost',
			'FirstMile_FirstMile' => 'First Mile',
			'Globegistics_PMEI' => 'Globegistics PMEI',
			'Globegistics_PMI' => 'Globegistics PMI',
			'Globegistics_eComDomestic' => 'Globegistics eCommerce Domestic',
			'Globegistics_eComEurope' => 'Globegistics eCommerce Europe',
			'Globegistics_eComExpress' => 'Globegistics eCommerce Express',
			'Globegistics_eComExtra' => 'Globegistics eCommerce Extra',
			'Globegistics_eComIPA' => 'Globegistics eCommerce IPA',
			'Globegistics_eComISAL' => 'Globegistics eCommerce ISAL',
			'Globegistics_eComPMEIDutyPaid' => 'Globegistics eCommerce PMEI Duty Paid',
			'Globegistics_eComPMIDutyPaid' => 'Globegistics eCommerce PMI Duty Paid',
			'Globegistics_eComPacket' => 'Globegistics eCommerce Packet',
			'Globegistics_eComPacketDDP' => 'Globegistics eCommerce Packet DDP',
			'Globegistics_eComPriority' => 'Globegistics eCommerce Priority',
			'Globegistics_eComStandard' => 'Globegistics eCommerce Standard',
			'Globegistics_eComTrackedDDP' => 'Globegistics eCommerce Tracked DDP',
			'Globegistics_eComTrackedDDU' => 'Globegistics eCommerce Tracked DDU',
			'GSO_EarlyPriorityOvernight' => 'GSO Early Priority Overnight',
			'GSO_PriorityOvernight' => 'GSO Priority Overnight',
			'GSO_CaliforniaParcelService' => 'GSO California Parcel Service',
			'GSO_SaturdayDeliveryService' => 'GSO Saturday Delivery Service',
			'GSO_EarlySaturdayService' => 'GSO Early Saturday Service',
			'GSO_Ground' => 'GSO Ground',
			'GSO_Overnight' => 'GSO Overnight',
			'Hermes_DomesticDelivery' => 'Hermes Domestic Delivery',
			'Hermes_DomesticDeliverySigned' => 'Hermes Domestic Delivery Signed',
			'Hermes_InternationalDelivery' => 'Hermes International Delivery',
			'Hermes_InternationalDeliverySigned' => 'Hermes International Delivery Signed',
			'HongKongPost_HongKongPost' => 'Hong Kong Post',
			'InterlinkExpress_InterlinkAirClassicInternationalAir' => 'Interlink Air Classic International Air',
			'InterlinkExpress_InterlinkAirExpressInternationalAir' => 'Interlink Air Express International Air',
			'InterlinkExpress_InterlinkExpresspak1By10:30' => 'Interlink Expresspak 1 By 10:30',
			'InterlinkExpress_InterlinkExpresspak1By12' => 'Interlink Expresspak 1 By 12',
			'InterlinkExpress_InterlinkExpresspak1NextDay' => 'Interlink Expresspak 1 Next Day',
			'InterlinkExpress_InterlinkExpresspak1Saturday' => 'Interlink Expresspak 1 Saturday',
			'InterlinkExpress_InterlinkExpresspak1SaturdayBy10:30' => 'Interlink Expresspak 1 Saturday By 10:30',
			'InterlinkExpress_InterlinkExpresspak1SaturdayBy12' => 'Interlink Expresspak 1 Saturday By 12',
			'InterlinkExpress_InterlinkExpresspak1Sunday' => 'Interlink Expresspak 1 Sunday',
			'InterlinkExpress_InterlinkExpresspak1SundayBy12' => 'Interlink Expresspak 1 Sunday By 12',
			'InterlinkExpress_InterlinkExpresspak5By10' => 'Interlink Expresspak 5 By 10',
			'InterlinkExpress_InterlinkExpresspak5By10:30' => 'Interlink Expresspak 5 By 10:30',
			'InterlinkExpress_InterlinkExpresspak5By12' => 'Interlink Expresspak 5 By 12',
			'InterlinkExpress_InterlinkExpresspak5NextDay' => 'Interlink Expresspak 5 Next Day',
			'InterlinkExpress_InterlinkExpresspak5Saturday' => 'Interlink Expresspak 5 Saturday',
			'InterlinkExpress_InterlinkExpresspak5SaturdayBy10' => 'Interlink Expresspak 5 SaturdayBy 10',
			'InterlinkExpress_InterlinkExpresspak5SaturdayBy10:30' => 'Interlink Expresspak 5 Saturday By 10:30',
			'InterlinkExpress_InterlinkExpresspak5SaturdayBy12' => 'Interlink Expresspak 5 Saturday By 12',
			'InterlinkExpress_InterlinkExpresspak5Sunday' => 'Interlink Expresspak 5 Sunday',
			'InterlinkExpress_InterlinkExpresspak5SundayBy12' => 'Interlink Expresspak 5 Sunday By 12',
			'InterlinkExpress_InterlinkFreightBy10' => 'Interlink Freight By 10',
			'InterlinkExpress_InterlinkFreightBy12' => 'Interlink Freight By 12',
			'InterlinkExpress_InterlinkFreightNextDay' => 'Interlink Freight Next Day',
			'InterlinkExpress_InterlinkFreightSaturday' => 'Interlink Freight Saturday',
			'InterlinkExpress_InterlinkFreightSaturdayBy10' => 'Interlink Freight Saturday By 10',
			'InterlinkExpress_InterlinkFreightSaturdayBy12' => 'Interlink Freight Saturday By 12',
			'InterlinkExpress_InterlinkFreightSunday' => 'Interlink Freight Sunday',
			'InterlinkExpress_InterlinkFreightSundayBy12' => 'Interlink Freight Sunday By 12',
			'InterlinkExpress_InterlinkParcelBy10' => 'Interlink Parcel By 10',
			'InterlinkExpress_InterlinkParcelBy10:30' => 'Interlink Parcel By 10:30',
			'InterlinkExpress_InterlinkParcelBy12' => 'Interlink Parcel By 12',
			'InterlinkExpress_InterlinkParcelDpdEuropeByRoad' => 'Interlink Parcel Dpd Europe By Road',
			'InterlinkExpress_InterlinkParcelNextDay' => 'Interlink Parcel Next Day',
			'InterlinkExpress_InterlinkParcelReturn' => 'Interlink Parcel Return',
			'InterlinkExpress_InterlinkParcelReturnToShop' => 'Interlink Parcel Return To Shop',
			'InterlinkExpress_InterlinkParcelSaturday' => 'Interlink Parcel Saturday',
			'InterlinkExpress_InterlinkParcelSaturdayBy10' => 'Interlink Parcel Saturday By 10',
			'InterlinkExpress_InterlinkParcelSaturdayBy10:30' => 'Interlink Parcel Saturday By 10:30',
			'InterlinkExpress_InterlinkParcelSaturdayBy12' => 'Interlink Parcel Saturday By 12',
			'InterlinkExpress_InterlinkParcelShipToShop' => 'Interlink Parcel Ship To Shop',
			'InterlinkExpress_InterlinkParcelSunday' => 'Interlink Parcel Sunday',
			'InterlinkExpress_InterlinkParcelSundayBy12' => 'Interlink Parcel Sunday By 12',
			'InterlinkExpress_InterlinkParcelTwoDay' => 'Interlink Parcel Two Day',
			'InterlinkExpress_InterlinkPickupParcelDpdEuropeByRoad' => 'Interlink Pickup Parcel Dpd Europe By Road',
			'JancoFreight_JancoFreight' => 'JancoFreight',
			'JPPost_JPPost' => 'JP Post',
			'KuronekoYamato_KuronekoYamato' => 'Kuroneko Yamato',
			'LaPoste_LaPoste' => 'La Poste',
			'LaserShipV2_LaserShipV2' => 'LaserShipV2',
			'LatvijasPasts_LatvijasPasts' => 'Latvijas Pasts',
			'Liefery_TourAppointment20161124From1600To1900' => 'Liefery',
			'LoomisExpress_LoomisGround' => 'Loomis Ground',
			'LoomisExpress_LoomisExpress1800' => 'Loomis Express 18:00',
			'LoomisExpress_LoomisExpress1200' => 'Loomis Express 12:00',
			'LoomisExpress_LoomisExpress900' => 'Loomis Express 9:00',
			'LSO_GroundEarly' => 'LSO Ground Early',
			'LSO_GroundBasic' => 'LSO Ground Basic',
			'LSO_PriorityBasic' => 'LSO Priority Basic',
			'LSO_PriorityEarly' => 'LSO Priority Early',
			'LSO_PrioritySaturday' => 'Priority Saturday',
			'LSO_Priority2ndDay' => 'LSO Priority 2nd Day',
			'LSO_SameDay' => 'LSO Same Day',
			'Network4_BronzeDelivery' => 'Network4 Bronze Delivery',
			'Network4_BronzeDeliveryAndCollection' => 'Network4 Bronze Delivery And Collection',
			'Network4_SilverDelivery' => 'Network4 SilverDelivery',
			'Network4_SilverDeliveryAndCollection' => 'Network4 Silver Delivery And Collection',
			'Network4_GoldDelivery' => 'Network4 Gold Delivery',
			'Network4_GoldDeliveryAndCollection' => 'Network4 Gold Delivery And Collection',
			'Network4_PlatinumDelivery' => 'Network4 Platinum Delivery',
			'Network4_PlatinumDeliveryAndCollection' => 'Network4 Platinum Delivery And Collection',
			'Newgistics_ParcelSelect' => 'Newgistics Parcel Select',
			'Newgistics_ParcelSelectLightweight' => 'Newgistics Parcel Select Lightweight',
			'Newgistics_Ground' => 'Newgistics Ground',
			'Newgistics_Express' => 'Newgistics Express',
			'Newgistics_FirstClassMail' => 'Newgistics First Class Mail',
			'Newgistics_PriorityMail' => 'Newgistics Priority Mail',
			'Newgistics_BoundPrintedMatter' => 'Newgistics Bound Printed Matter',
			'Norco_EarlyOvernite' => 'Norco Early Overnite',
			'Norco_MorningOvernite' => 'Norco Morning Overnite',
			'Norco_OneOvernite' => 'Norco One Overnite',
			'Norco_NextDayOvernite' => 'Norco Next Day Overnite',
			'Norco_SaturdayOvernite' => 'Norco Saturday Overnite',
			'Norco_2DayMetro' => 'Norco 2 Day Metro',
			'Norco_Ground' => 'Norco Ground',
			'Norco_Overnight' => 'Norco Overnight',
			'OmniParcel_OmniParcel' => 'OmniParcel',
			'OnTrac_Sunrise' => 'OnTrac Sunrise',
			'OnTrac_Gold' => 'OnTrac Gold',
			'OnTrac_OnTracGround' => 'OnTrac Ground',
			'OnTrac_SameDay' => 'OnTrac Same Day',
			'OnTrac_PalletizedFreight' => 'OnTrac Palletized Freight',
			'OnTracDirectPost_FirstClassMail' => 'OnTrac DirectPost First Class Mail',
			'OnTracDirectPost_PriorityMail' => 'OnTrac DirectPost Priority Mail',
			'OnTracDirectPost_BoundPrintedMatter' => 'OnTrac DirectPost Bound Printed Matter',
			'OnTracDirectPost_MediaMail' => 'OnTrac DirectPost Media Mail',
			'OnTracDirectPost_ParcelSelect' => 'OnTrac DirectPost Parcel Select',
			'OnTracDirectPost_ParcelSelectLightweight' => 'OnTrac DirectPost Parcel Select Lightweight',
			'OrangeDS_OrangeDSInternational' => 'OrangeDS International',
			'OrangeDS_OrangeDSDomestic' => 'OrangeDS Domestic',
			'OrangeDS_OrangeDSTracking' => 'OrangeDS Tracking',
			'OrangeDS_OrangeDSSecureShip' => 'OrangeDS Secure Ship',
			'OsmWorldwide_First' => 'Osm Worldwide First',
			'OsmWorldwide_Expedited' => 'Osm Worldwide Expedited',
			'OsmWorldwide_ParcelSelectLightweight' => 'Osm Worldwide Parcel Select Lightweight',
			'OsmWorldwide_Priority' => 'Osm Worldwide Priority',
			'OsmWorldwide_BPM' => 'Osm Worldwide BPM',
			'OsmWorldwide_ParcelSelect' => 'Osm Worldwide Parcel Select',
			'OsmWorldwide_MediaMail' => 'Osm Worldwide Media Mail',
			'OsmWorldwide_MarketingParcel' => 'Osm Worldwide Marketing Parcel',
			'OsmWorldwide_MarketingParcelTracked' => 'Osm Worldwide Marketing Parcel Tracked',
			'Parcelforce_Parcelforce' => 'Parcelforce',
			'Passport_Passport' => 'Passport',
			'Pilot_Pilot' => 'Pilot',
			'PostNL_PostNL' => 'PostNL',
			'Posten_Posten' => 'Posten',
			'PostNord_PostNord' => 'PostNord',
			'Purolator_PurolatorExpress' => 'Purolator Express',
			'Purolator_PurolatorExpress12PM' => 'Purolator Express12PM',
			'Purolator_PurolatorExpressPack12PM' => 'Purolator Express Pack 12PM',
			'Purolator_PurolatorExpressBox12PM' => 'Purolator Express Box 12PM',
			'Purolator_PurolatorExpressEnvelope12PM' => 'Purolator Express Envelope 12PM',
			'Purolator_PurolatorExpress1030AM' => 'Purolator Express 10:30AM',
			'Purolator_PurolatorExpress9AM' => 'Purolator Express 9AM',
			'Purolator_PurolatorExpressBox' => 'Purolator Express Box',
			'Purolator_PurolatorExpressBox1030AM' => 'Purolator Express Box 10:30AM',
			'Purolator_PurolatorExpressBox9AM' => 'Purolator Express Box 9AM',
			'Purolator_PurolatorExpressBoxEvening' => 'Purolator Express Box Evening',
			'Purolator_PurolatorExpressBoxInternational' => 'Purolator Express Box International',
			'Purolator_PurolatorExpressBoxInternational1030AM' => 'Purolator Express Box International 10:30AM',
			'Purolator_PurolatorExpressBoxInternational1200' => 'Purolator Express Box International 12:00',
			'Purolator_PurolatorExpressBoxInternational9AM' => 'Purolator Express Box International 9AM',
			'Purolator_PurolatorExpressBoxUS' => 'Purolator Express Box US',
			'Purolator_PurolatorExpressBoxUS1030AM' => 'Purolator Express Box US 10:30AM',
			'Purolator_PurolatorExpressBoxUS1200' => 'Purolator Express Box US 12:00',
			'Purolator_PurolatorExpressBoxUS9AM' => 'Purolator Express Box US 9AM',
			'Purolator_PurolatorExpressEnvelope' => 'Purolator Express Envelope',
			'Purolator_PurolatorExpressEnvelope1030AM' => 'Purolator Express Envelope 10:30AM',
			'Purolator_PurolatorExpressEnvelope9AM' => 'Purolator Express Envelope 9AM',
			'Purolator_PurolatorExpressEnvelopeEvening' => 'Purolator Express Envelope Evening',
			'Purolator_PurolatorExpressEnvelopeInternational' => 'Purolator Express Envelope International',
			'Purolator_PurolatorExpressEnvelopeInternational1030AM' => 'Purolator Express Envelope International 10:30AM',
			'Purolator_PurolatorExpressEnvelopeInternational1200' => 'Purolator Express Envelope International 1200',
			'Purolator_PurolatorExpressEnvelopeInternational9AM' => 'Purolator Express Envelope International 9AM',
			'Purolator_PurolatorExpressEnvelopeUS' => 'Purolator Express Envelope US',
			'Purolator_PurolatorExpressEnvelopeUS1030AM' => 'Purolator Express Envelope US 10:30AM',
			'Purolator_PurolatorExpressEnvelopeUS1200' => 'Purolator Express Envelope US 12:00',
			'Purolator_PurolatorExpressEnvelopeUS9AM' => 'Purolator Express Envelope US 9AM',
			'Purolator_PurolatorExpressEvening' => 'Purolator Express Evening',
			'Purolator_PurolatorExpressInternational' => 'Purolator Express International',
			'Purolator_PurolatorExpressInternational1030AM' => 'Purolator Express International 10:30AM',
			'Purolator_PurolatorExpressInternational1200' => 'Purolator Express International 12:00',
			'Purolator_PurolatorExpressInternational9AM' => 'Purolator Express International 9AM',
			'Purolator_PurolatorExpressPack' => 'Purolator Express Pack',
			'Purolator_PurolatorExpressPack1030AM' => 'Purolator Express Pack 10:30AM',
			'Purolator_PurolatorExpressPack9AM' => 'Purolator Express Pack 9AM',
			'Purolator_PurolatorExpressPackEvening' => 'Purolator Express Pack Evening',
			'Purolator_PurolatorExpressPackInternational' => 'Purolator Express Pack International',
			'Purolator_PurolatorExpressPackInternational1030AM' => 'Purolator Express Pack International 10:30AM',
			'Purolator_PurolatorExpressPackInternational1200' => 'Purolator Express Pack International 12:00',
			'Purolator_PurolatorExpressPackInternational9AM' => 'Purolator Express Pack International 9AM',
			'Purolator_PurolatorExpressPackUS' => 'Purolator Express Pack US',
			'Purolator_PurolatorExpressPackUS1030AM' => 'Purolator Express Pack US 10:30AM',
			'Purolator_PurolatorExpressPackUS1200' => 'Purolator Express Pack US 12:00',
			'Purolator_PurolatorExpressPackUS9AM' => 'Purolator Express Pack US 9AM',
			'Purolator_PurolatorExpressUS' => 'Purolator Express US',
			'Purolator_PurolatorExpressUS1030AM' => 'Purolator Express US 10:30AM',
			'Purolator_PurolatorExpressUS1200' => 'Purolator Express US 12:00',
			'Purolator_PurolatorExpressUS9AM' => 'Purolator Express US 9AM',
			'Purolator_PurolatorGround' => 'Purolator Ground',
			'Purolator_PurolatorGround1030AM' => 'Purolator Ground 10:30AM',
			'Purolator_PurolatorGround9AM' => 'Purolator Ground 9AM',
			'Purolator_PurolatorGroundDistribution' => 'Purolator Ground Distribution',
			'Purolator_PurolatorGroundEvening' => 'Purolator Ground Evening',
			'Purolator_PurolatorGroundRegional' => 'Purolator Ground Regional',
			'Purolator_PurolatorGroundUS' => 'Purolator Ground US',
			'RoyalMail_HerMajestysForces' => 'RoyalMail Her Majestys Forces', 
			'RoyalMail_InternationalFlats' => 'RoyalMail International Flats', 
			'RoyalMail_InternationalBusinessMailLargeLetterZeroSortPriority' => 'RoyalMail International Business Mail Large Letter Zero Sort Priority', 
			'RoyalMail_InternationalBusinessMailLargeLetterZeroSortPriorityMachine' => 'RoyalMail International Business Mail Large Letter Zero Sort Priority Machine', 
			'RoyalMail_InternationalBusinessMailLargeLetterZoneSortPriority' => 'RoyalMail International Business Mail Large Letter Zone Sort Priority', 
			'RoyalMail_InternationalBusinessMailLargeLetterMaxSortPriority' => 'RoyalMail International Business Mail Large Letter Max Sort Priority', 
			'RoyalMail_InternationalBusinessMailLargeLetterCountrySortHighVolumePriority' => 'RoyalMail International Business Mail Large Letter Country Sort High Volume Priority', 
			'RoyalMail_InternationalBusinessMailLargeLetterCountrySortLowVolumePriority' => 'RoyalMail International Business Mail Large Letter Country Sort Low Volume Priority', 
			'RoyalMail_InternationalBusinessMailLargeLetterZoneSortPriorityMachine' => 'RoyalMail International Business Mail Large Letter Zone Sort Priority Machine', 
			'RoyalMail_InternationalBusinessMailMixedZeroSortPriority' => 'RoyalMail International Business Mail Mixed Zero Sort Priority', 
			'RoyalMail_InternationalBusinessMailMixedZeroSortPriorityMachine' => 'RoyalMail International Business Mail Mixed Zero Sort Priority Machine', 
			'RoyalMail_InternationalBusinessMailMixedZonePriority' => 'RoyalMail International Business Mail Mixed ZonePriority', 
			'RoyalMail_InternationalBusinessMailMixedZonePriorityMachine' => 'RoyalMail International Business Mail Mixed Zone Priority Machine', 
			'RoyalMail_InternationalBusinessMailLetterZoneSortPriority' => 'RoyalMail International Business Mail Letter Zone Sort Priority', 
			'RoyalMail_InternationalBusinessMailLetterMaxSortPriority' => 'RoyalMail International Business Mail Letter Max SortPriority', 
			'RoyalMail_InternationalBusinessMailLetterCountrySortHighVolumePriority' => 'RoyalMail International Business Mail Letter Country Sort High Volume Priority', 
			'RoyalMail_InternationalBusinessMailLetterZoneSortPriorityMachine' => 'RoyalMail International Business Mail Letter Zone Sort Priority Machine', 
			'RoyalMail_InternationalBusinessParcelsZoneSortPriority' => 'RoyalMail International Business Parcels Zone Sort Priority', 
			'RoyalMail_InternationalBusinessParcelsMaxSortPriority' => 'RoyalMail International Business Parcels Max Sort Priority', 
			'RoyalMail_InternationalBusinessParcelsPrintDirectPriority' => 'RoyalMail International Business Parcels Print Direct Priority', 
			'RoyalMail_InternationalBusinessParcelsZeroSortPriority' => 'RoyalMail International Business Parcels Zero Sort Priority', 
			'RoyalMail_InternationalBusinessParcelsZeroSortHighVolumePriority' => 'RoyalMail International Business Parcels Zero Sort High Volume Priority', 
			'RoyalMail_InternationalBusinessParcelsZeroSortLowVolumePriority' => 'RoyalMail International Business Parcels Zero Sort Low Volume Priority', 
			'RoyalMail_InternationalBusinessParcelsBespokePostal' => 'RoyalMail International Business Parcels Bespoke Postal', 
			'RoyalMail_InternationalEconomy' => 'RoyalMail International Economy', 
			'RoyalMail_InternationalBusinessMailLetterZoneSortEconomy' => 'RoyalMail International Business Mail Letter Zone Sort Economy', 
			'RoyalMail_InternationalBusinessMailLetterMaxSortStandard' => 'RoyalMail International Business Mail Letter Max Sort Standard', 
			'RoyalMail_InternationalBusinessMailLetterMaxSortEconomy' => 'RoyalMail International Business Mail Letter Max Sort Economy', 
			'RoyalMail_InternationalBusinessMailLetterCountrySortHighVolumeEconomy' => 'RoyalMail International Business Mail Letter Country Sort High Volume Economy', 
			'RoyalMail_InternationalBusinessMailLetterZoneSortEconomyMachine' => 'RoyalMail International Business Mail Letter Zone Sort Economy Machine', 
			'RoyalMail_InternationalBusinessMailLargeLetterCountrySortHighVolumeEconomy' => 'RoyalMail International Business Mail Large Letter Country SortHigh Volume Economy', 
			'RoyalMail_InternationalBusinessMailLargeLetterCountrySortLowVolumeEconomy' => 'RoyalMail International Business Mail Large Letter Country SortLow Volume Economy', 
			'RoyalMail_InternationalBusinessMailLargeLetterZeroSortEconomy' => 'RoyalMail International Business Mail Large Letter Zero Sort Economy', 
			'RoyalMail_InternationalBusinessMailLargeLetterZeroSortEconomyMachine' => 'RoyalMail International Business Mail Large Letter Zero Sort Economy Machine', 
			'RoyalMail_InternationalBusinessMailLargeLetterZoneSortEconomy' => 'RoyalMail International Business Mail Large Letter Zone Sort Economy', 
			'RoyalMail_InternationalBusinessMailLargeLetterMaxSortStandard' => 'RoyalMail International Business Mail Large Letter Max Sort Standard', 
			'RoyalMail_InternationalBusinessMailLargeLetterMaxSortEconomy' => 'RoyalMail International Business Mail Large Letter Max Sort Economy', 
			'RoyalMail_InternationalBusinessMailLargeLetterZoneSortEconomyMachine' => 'RoyalMail International Business Mail Large Letter Zone Sort Economy Machine', 
			'RoyalMail_InternationalBusinessMailMixedZeroSortEconomy' => 'RoyalMail International Business Mail Mixed Zero Sort Economy', 
			'RoyalMail_InternationalBusinessMailMixedZeroSortEconomyMachine' => 'RoyalMail International Business Mail Mixed Zero Sort Economy Machine', 
			'RoyalMail_InternationalBusinessMailMixedZoneEconomy' => 'RoyalMail International Business Mail Mixed Zone Economy', 
			'RoyalMail_InternationalBusinessMailMixedZoneEconomyMachine' => 'RoyalMail International Business Mail Mixed Zone Economy Machine', 
			'RoyalMail_InternationalBusinessParcelsZoneSortEconomy' => 'RoyalMail International Business Parcels Zone Sort Economy', 
			'RoyalMail_InternationalBusinessParcelsMaxSortStandard' => 'RoyalMail International Business Parcels Max Sort Standard', 
			'RoyalMail_InternationalBusinessParcelsMaxSortEconomy' => 'RoyalMail International Business Parcels Max Sort Economy', 
			'RoyalMail_InternationalBusinessParcelsPrintDirectStandard' => 'RoyalMail International Business Parcels Print Direct Standard', 
			'RoyalMail_InternationalBusinessParcelsPrintDirectEconomy' => 'RoyalMail International Business Parcels Print Direct Economy', 
			'RoyalMail_InternationalBusinessParcelsZeroSortEconomy' => 'RoyalMail International Business Parcels Zero Sort Economy', 
			'RoyalMail_InternationalBusinessParcelsZeroSortHighVolumeEconomy' => 'RoyalMail International Business Parcels Zero Sort High Volume Economy', 
			'RoyalMail_InternationalBusinessParcelsZeroSortLowVolumeEconomy' => 'RoyalMail International Business Parcels Zero Sort Low Volume Economy', 
			'RoyalMail_InternationalTrackedAndSigned' => 'RoyalMail International Tracked And Signed', 
			'RoyalMail_InternationalTrackedAndSignedExtraCompensation' => 'RoyalMail International Tracked And Signed Extra Compensation', 
			'RoyalMail_InternationalBusinessParcelsTrackedAndSigned' => 'RoyalMail International Business Parcels Tracked And Signed', 
			'RoyalMail_InternationalBusinessParcelsTrackedAndSignedCountry' => 'RoyalMail International Business Parcels Tracked And Signed Country', 
			'RoyalMail_InternationalBusinessParcelsTrackedAndSignedExtraCompensation' => 'RoyalMail International Business Parcels Tracked And Signed Extra Compensation', 
			'RoyalMail_InternationalBusinessParcelsTrackedAndSignedExtraCompensationCountry' => 'RoyalMail International Business Parcels Tracked And Signed Extra Compensation Country', 
			'RoyalMail_InternationalBusinessMailTrackedAndSigned' => 'RoyalMail International Business Mail Tracked And Signed', 
			'RoyalMail_InternationalBusinessMailTrackedAndSignedCountry' => 'RoyalMail International Business Mail Tracked And Signed Country', 
			'RoyalMail_InternationalBusinessMailTrackedAndSignedExtraCompensation' => 'RoyalMail International Business Mail Tracked And Signed Extra Compensation', 
			'RoyalMail_InternationalBusinessMailTrackedAndSignedExtraCompensationCountry' => 'RoyalMail International Business Mail Tracked And Signed Extra Compensation Country', 
			'RoyalMail_InternationalTracked' => 'RoyalMail International Tracked', 
			'RoyalMail_InternationalTrackedExtraCompensation' => 'RoyalMail International Tracked Extra Compensation', 
			'RoyalMail_InternationalBusinessParcelsTracked' => 'RoyalMail International Business Parcels Tracked ', 
			'RoyalMail_InternationalBusinessParcelsTrackedCountry' => 'RoyalMail International Business Parcels Tracked Country', 
			'RoyalMail_InternationalBusinessParcelsTrackedExtraCompensation' => 'RoyalMail International Business Parcels Tracked Extra Compensation', 
			'RoyalMail_InternationalBusinessParcelsTrackedExtraCompensationCountry' => 'RoyalMail International Business Parcels Tracked Extra Compensation Country', 
			'RoyalMail_InternationalBusinessParcelsTrackedCountryHighVolume' => 'RoyalMail International Business Parcels Tracked Country High Volume', 
			'RoyalMail_InternationalBusinessParcelsTrackedXtrCompCountryHighVol' => 'RoyalMail International Business Parcels Tracked Xtr Comp Country High Vol', 
			'RoyalMail_InternationalBusinessMailTracked' => 'RoyalMail International Business Mail Tracked ', 
			'RoyalMail_InternationalBusinessMailTrackedCountry' => 'RoyalMail International Business Mail Tracked Country', 
			'RoyalMail_InternationalBusinessMailTrackedExtraCompensation' => 'RoyalMail International Business Mail Tracked Extra Compensation', 
			'RoyalMail_InternationalBusinessMailTrackedExtraCompensationCountry' => 'RoyalMail International Business Mail Tracked Extra Compensation Country', 
			'RoyalMail_InternationalBusinessParcelsTrackedDDP' => 'RoyalMail International Business Parcels Tracked DDP', 
			'RoyalMail_InternationalSigned' => 'RoyalMail International Signed', 
			'RoyalMail_InternationalSignedExtraCompensation' => 'RoyalMail International Signed Extra Compensation', 
			'RoyalMail_InternationalBusinessParcelsSigned' => 'RoyalMail International Business Parcels Signed', 
			'RoyalMail_InternationalBusinessParcelsSignedCountry' => 'RoyalMail International Business Parcels Signed Country', 
			'RoyalMail_CrossBorderImportEUSignedParcel' => 'RoyalMail Cross Border Import EU Signed Parcel',
			'RoyalMail_InternationalBusinessParcelsSignedExtraCompensationCountry' => 'RoyalMail International Business Parcels Signed Extra Compensation Country', 
			'RoyalMail_InternationalBusinessParcelsSignedExtraCompensation' => 'RoyalMail International Business Parcels Signed Extra Compensation', 
			'RoyalMail_InternationalBusinessParcelsSignedCountryHighVolume' => 'RoyalMail International Business Parcels Signed Country High Volume', 
			'RoyalMail_InternationalBusinessParcelsSignedXtrCompCountryHighVolume' => 'RoyalMail International Business Parcels Signed Xtr Comp Country High Volume', 
			'RoyalMail_InternationalBusinessMailSigned' => 'RoyalMail International Business Mail Signed', 
			'RoyalMail_InternationalBusinessMailSignedExtraCompensation' => 'RoyalMail International Business Mail Signed Extra Compensation', 
			'RoyalMail_InternationalBusinessMailSignedExtraCompensationCountry' => 'RoyalMail International Business Mail Signed Extra Compensation Country', 
			'RoyalMail_InternationalBusinessMailSignedCountry' => 'RoyalMail International Business Mail Signed Country', 
			'RoyalMail_InternationalBusinessMailSignedCountryHighVolume' => 'RoyalMail International Business Mail Signed Country High Volume', 
			'RoyalMail_InternationalBusinessMailSignedXtrCompCountryHighVol' => 'RoyalMail International Business Mail Signed Xtr Comp Country High Vol', 
			'RoyalMail_1stClass' => 'RoyalMail 1st Class', 
			'RoyalMail_2ndClass' => 'RoyalMail 2nd Class', 
			'RoyalMail_RoyalMail1stClass' => 'RoyalMail RoyalMail 1st Class', 
			'RoyalMail_RoyalMail2ndClass' => 'RoyalMail RoyalMail 2nd Class', 
			'RoyalMail_RoyalMail24' => 'RoyalMail 24', 
			'RoyalMail_RoyalMail48' => 'RoyalMail 48', 
			'RoyalMail_RoyalMail24PresortedParcel' => 'RoyalMail 24 Presorted Parcel', 
			'RoyalMail_RoyalMail48PresortedParcel' => 'RoyalMail 48 Presorted Parcel', 
			'RoyalMail_RoyalMail48PresortedParcelSafeplace' => 'RoyalMail 48 Presorted Parcel Safeplace', 
			'RoyalMail_RoyalMail24PresortedParcelAnnualFlatRate' => 'RoyalMail 24 Presorted Parcel Annual Flat Rate', 
			'RoyalMail_RoyalMail48PresortedParcelAnnualFlatRate' => 'RoyalMail 48 Presorted Parcel Annual Flat Rate', 
			'RoyalMail_RoyalMail24PacketPostAnnualFlatRateSafeplace' => 'RoyalMail 24 Packet Post Annual Flat Rate Safeplace', 
			'RoyalMail_RoyalMail24PresortedLargeLetterAnnualFlatRate' => 'RoyalMail 24 Presorted Large Letter Annual Flat Rate', 
			'RoyalMail_RoyalMail24LargeLetterAnnualFlatRateSafeplace' => 'RoyalMail 24 Large Letter Annual Flat Rate Safeplace', 
			'RoyalMail_RoyalMail48PresortedLargeLetterAnnualFlatRate' => 'RoyalMail 48 Presorted Large Letter Annual Flat Rate', 
			'RoyalMail_RoyalMail24Sort8LargeLetterAnnualFlatRate' => 'RoyalMail 24 Sort 8 Large Letter Annual Flat Rate', 
			'RoyalMail_RoyalMail48Sort8LargeLetterAnnualFlatRate' => 'RoyalMail 48 Sort 8 Large Letter Annual Flat Rate', 
			'RoyalMail_RoyalMail24Sort8LargeLetterFlatRate' => 'RoyalMail 24 Sort 8 Large Letter Flat Rate', 
			'RoyalMail_RoyalMail24Sort8LargeLetterFlatRateSafeplace' => 'RoyalMail 24 Sort 8 Large Letter Flat Rate Safeplace', 
			'RoyalMail_RoyalMail48Sort8LargeLetterFlatRate' => 'RoyalMail 48 Sort 8 Large Letter Flat Rate', 
			'RoyalMail_RoyalMail24Sort8ParcelFlatRate' => 'RoyalMail 24 Sort 8 Parcel Flat Rate', 
			'RoyalMail_RoyalMail24Sort8ParcelFlatRateSafeplace' => 'RoyalMail 24 Sort 8 Parcel Flat Rate Safeplace', 
			'RoyalMail_RoyalMail48Sort8ParcelFlatRate' => 'RoyalMail 48 Sort 8 Parcel Flat Rate', 
			'RoyalMail_RoyalMail48Sort8ParcelAnnualFlatRate' => 'RoyalMail 48 Sort 8 Parcel Annual Flat Rate', 
			'RoyalMail_RoyalMail48Sort8ParcelAnnualFlatRateSafeplace' => 'RoyalMail 48 Sort 8 Parcel Annual Flat Rate Safeplace', 
			'RoyalMail_RoyalMail24Sort8DailyRate' => 'RoyalMail 24 Sort 8 Daily Rate', 
			'RoyalMail_RoyalMail48Sort8DailyRate' => 'RoyalMail 48 Sort 8 Daily Rate', 
			'RoyalMail_RoyalMail24Sort8ParcelAnnualFlatRate' => 'RoyalMail 24 Sort 8 Parcel Annual Flat Rate', 
			'RoyalMail_RoyalMail24PresortedLargeLetter' => 'RoyalMail 24 Presorted Large Letter', 
			'RoyalMail_RoyalMail48PresortedLargeLetter' => 'RoyalMail 48 Presorted Large Letter', 
			'RoyalMail_RoyalMail48PresortedLargeLetterSafeplace' => 'RoyalMail 48 Presorted Large Letter Safeplace', 
			'RoyalMail_RoyalMail24LargeLetterFlatRate' => 'RoyalMail 24 Large Letter Flat Rate', 
			'RoyalMail_RoyalMail48LargeLetterFlatRate' => 'RoyalMail 48 Large Letter Flat Rate', 
			'RoyalMail_RoyalMail24ParcelFlatRate' => 'RoyalMail 24 Parcel Flat Rate', 
			'RoyalMail_RoyalMail48ParcelFlatRate' => 'RoyalMail 48 Parcel Flat Rate', 
			'RoyalMail_RoyalMail24LargeLetterAnnualFlatRate' => 'RoyalMail 24 Large Letter Annual Flat Rate', 
			'RoyalMail_RoyalMail48LargeLetterAnnualFlatRate' => 'RoyalMail 48 Large Letter Annual Flat Rate', 
			'RoyalMail_RoyalMail48LargeLetterAnnualFlatRateSafeplace' => 'RoyalMail 48 Large Letter Annual Flat Rate Safeplace', 
			'RoyalMail_RoyalMail48LargeLetterFlatRateSafeplace' => 'RoyalMail 48 Large Letter Flat Rate Safeplace', 
			'RoyalMail_RoyalMail24LargeLetterDailyRate' => 'RoyalMail RoyalMail 24 Large Letter Daily Rate', 
			'RoyalMail_RoyalMail24LargeLetterDailyRateSafeplace' => 'RoyalMail 24 Large Letter Daily Rate Safeplace', 
			'RoyalMail_RoyalMail48LargeLetterDailyRate' => 'RoyalMail 48 Large Letter Daily Rate', 
			'RoyalMail_RoyalMail24ParcelDailyRate' => 'RoyalMail 24 Parcel Daily Rate', 
			'RoyalMail_RoyalMail48ParcelDailyRate' => 'RoyalMail 48 Parcel Daily Rate', 
			'RoyalMail_RoyalMail24FlatRate' => 'RoyalMail 24 Flat Rate',
			'RoyalMail_RoyalMail48FlatRate' => 'RoyalMail 48 Flat Rate', 
			'RoyalMail_RoyalMail24SignedFor' => 'RoyalMail 24 Signed For', 
			'RoyalMail_RoyalMail48SignedFor' => 'RoyalMail 48 Signed For', 
			'RoyalMail_RoyalMail1stClassSignedFor' => 'RoyalMail RoyalMail 1st Class Signed For', 
			'RoyalMail_RoyalMail2ndClassSignedFor' => 'RoyalMail RoyalMail 2nd Class Signed For', 
			'RoyalMail_1stClassSignedFor' => 'RoyalMail 1st Class Signed For', 
			'RoyalMail_2ndClassSignedFor' => 'RoyalMail 2nd Class Signed For', 
			'RoyalMail_StandardLetter1stClassSignedFor' => 'RoyalMail Standard Letter 1st Class Signed For', 
			'RoyalMail_StandardLetter2ndClassSignedFor' => 'RoyalMail Standard Letter 2nd Class Signed For', 
			'RoyalMail_HerMajestysForcesSignedFor' => 'RoyalMail Her Majestys Forces Signed For', 
			'RoyalMail_RoyalMail24ParcelFlatRateSignedFor' => 'RoyalMail 24 Parcel Flat Rate Signed For', 
			'RoyalMail_RoyalMail48ParcelFlatRateSignedFor' => 'RoyalMail 48 Parcel Flat Rate Signed For', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm' => 'RoyalMail Special Delivery Guaranteed 1pm ', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm750' => 'RoyalMail Special Delivery Guaranteed 1pm 750', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm1000' => 'RoyalMail Special Delivery Guaranteed 1pm 1000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm2500' => 'RoyalMail Special Delivery Guaranteed 1pm 2500', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm5000' => 'RoyalMail Special Delivery Guaranteed 1pm 5000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm7500' => 'RoyalMail Special Delivery Guaranteed 1pm 7500', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm10000' => 'RoyalMail Special Delivery Guaranteed 1pm 10000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge750' => 'RoyalMail Special Delivery Guaranteed 1pm Age 750', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge1000' => 'RoyalMail Special Delivery Guaranteed 1pm Age 1000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge2500' => 'RoyalMail Special Delivery Guaranteed 1pm Age 2500', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge5000' => 'RoyalMail Special Delivery Guaranteed 1pm Age 5000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge7500' => 'RoyalMail Special Delivery Guaranteed 1pm Age 7500', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge10000' => 'RoyalMail Special Delivery Guaranteed 1pm Age 10000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID750' => 'RoyalMail Special Delivery Guaranteed 1pm ID 750', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID1000' => 'RoyalMail Special Delivery Guaranteed 1pm ID 1000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID2500' => 'RoyalMail Special Delivery Guaranteed 1pm ID 2500', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID5000' => 'RoyalMail Special Delivery Guaranteed 1pm ID 5000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID7500' => 'RoyalMail Special Delivery Guaranteed 1pm ID 7500', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID10000' => 'RoyalMail Special Delivery Guaranteed 1pm ID 10000', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmLA' => 'RoyalMail Special Delivery Guaranteed 1pm LA', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm1000LA' => 'RoyalMail Special Delivery Guaranteed 1pm 1000LA', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm2500LA' => 'RoyalMail Special Delivery Guaranteed 1pm 2500LA', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge750Saturday' => 'RoyalMail Special Delivery Guaranteed 1pm Age 750 Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge1000Saturday' => 'RoyalMail Special Delivery Guaranteed 1pm Age 1000 Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmAge2500Saturday' => 'RoyalMail Special Delivery Guaranteed 1pm Age 2500 Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm1000Saturday' => 'RoyalMail Special Delivery Guaranteed 1pm 1000 Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm2500Saturday' => 'RoyalMail Special Delivery Guaranteed 1pm 2500 Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmLASaturday' => 'RoyalMail Special Delivery Guaranteed 1pm LA Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm1000LASaturday' => 'RoyalMail Special Delivery Guaranteed 1pm 1000 LA Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm2500LASaturday' => 'RoyalMail Special Delivery Guaranteed 1pm 2500 LA Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmLocalCollect' => 'RoyalMail Special Delivery Guaranteed 1pm  Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm1000LocalCollect' => 'RoyalMail Special Delivery Guaranteed 1pm 1000 Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm2500LocalCollect' => 'RoyalMail Special Delivery Guaranteed 1pm 2500 Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmLALocalCollect' => 'RoyalMail Special Delivery Guaranteed 1pm LA Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm1000LALocalCollect' => 'RoyalMail Special Delivery Guaranteed 1pm 1000 LA Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm2500LALocalCollect' => 'RoyalMail Special Delivery Guaranteed 1pm 2500 LA Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmLocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm  Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm1000LocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm 1000 Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm2500LocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm 2500 Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmLALocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm LA Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm1000LALocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm 1000 LA Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pm2500LALocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm 2500 LA Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID750LocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm ID 750 Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID1000LocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm ID 1000 Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed1pmID2500LocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 1pm ID 2500 Local Collect Saturday', 
			'RoyalMail_HerMajestysForcesSpecialDelivery' => 'RoyalMail Her Majestys Forces Special Delivery', 
			'RoyalMail_HerMajestysForcesSpecialDelivery1000' => 'RoyalMail Her Majestys Forces Specia lDelivery 1000', 
			'RoyalMail_HerMajestysForcesSpecialDelivery2500' => 'RoyalMail Her Majestys Forces Special Delivery 2500', 
			'RoyalMail_SpecialDeliveryGuaranteed9am' => 'RoyalMail Special Delivery Guaranteed 9am ', 
			'RoyalMail_SpecialDeliveryGuaranteed9am750' => 'RoyalMail Special Delivery Guaranteed 9am 750', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000' => 'RoyalMail Special Delivery Guaranteed 9am 1000', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500' => 'RoyalMail Special Delivery Guaranteed 9am 2500', 
			'RoyalMail_SpecialDeliveryGuaranteed9am5000' => 'RoyalMail Special Delivery Guaranteed 9am 5000', 
			'RoyalMail_SpecialDeliveryGuaranteed9am7500' => 'RoyalMail Special Delivery Guaranteed 9am 7500', 
			'RoyalMail_SpecialDeliveryGuaranteed9am10000' => 'RoyalMail Special Delivery Guaranteed 9am 10000', 
			'RoyalMail_SpecialDeliveryGuaranteed9am750Age' => 'RoyalMail Special Delivery Guaranteed 9am 750 Age', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000Age' => 'RoyalMail Special Delivery Guaranteed 9am 1000 Age', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500Age' => 'RoyalMail Special Delivery Guaranteed 9am 2500 Age', 
			'RoyalMail_SpecialDeliveryGuaranteed9amID750' => 'RoyalMail Special Delivery Guaranteed 9am ID 750', 
			'RoyalMail_SpecialDeliveryGuaranteed9amID1000' => 'RoyalMail Special Delivery Guaranteed 9am ID 1000', 
			'RoyalMail_SpecialDeliveryGuaranteed9amID2500' => 'RoyalMail Special Delivery Guaranteed 9am ID 2500', 
			'RoyalMail_SpecialDeliveryGuaranteed9amLA' => 'RoyalMail Special Delivery Guaranteed 9am LA', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000LA' => 'RoyalMail Special Delivery Guaranteed 9am 1000 LA', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500LA' => 'RoyalMail Special Delivery Guaranteed 9am 2500 LA', 
			'RoyalMail_SpecialDeliveryGuaranteed9amSaturday' => 'RoyalMail Special Delivery Guaranteed 9am Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000Saturday' => 'RoyalMail Special Delivery Guaranteed 9am 1000 Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500Saturday' => 'RoyalMail Special Delivery Guaranteed 9am 250 0Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9amLASaturday' => 'RoyalMail Special Delivery Guaranteed 9am LA Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000LASaturday' => 'RoyalMail Special Delivery Guaranteed 9am 1000 LA Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500LASaturday' => 'RoyalMail Special Delivery Guaranteed 9am 2500 LA Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9amLocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am  Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9am750LocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am 750 Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000LocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am 1000 Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500LocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am 2500 Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9amID750LocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am ID 750 Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9amID1000LocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am ID 1000 Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9amID2500LocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am ID 2500 Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9amLALocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am LA Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000LALocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am 1000LA Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500LALocalCollect' => 'RoyalMail Special Delivery Guaranteed 9am 2500LA Local Collect', 
			'RoyalMail_SpecialDeliveryGuaranteed9amLocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am  Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000LocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am 1000 Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500LocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am 2500 Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am750AgeLocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am 750 Age Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000AgeLocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am 1000 Age Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500AgeLocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am 2500 Age Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9amLALocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am LA Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am1000LALocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am 1000 LA Local Collect Saturday', 
			'RoyalMail_SpecialDeliveryGuaranteed9am2500LALocalCollectSaturday' => 'RoyalMail Special Delivery Guaranteed 9am 2500 LA Local Collect Saturday', 
			'RoyalMail_StandardLetter1stClass' => 'RoyalMail Standard Letter 1st Class', 
			'RoyalMail_StandardLetter2ndClass' => 'RoyalMail Standard Letter 2nd Class', 
			'RoyalMail_Tracked24' => 'RoyalMail Tracked 24', 
			'RoyalMail_Tracked24Safeplace' => 'RoyalMail Tracked 24 Safeplace', 
			'RoyalMail_Tracked24HighVolume' => 'RoyalMail Tracked 24 High Volume', 
			'RoyalMail_Tracked24HighVolumeLBT' => 'RoyalMail Tracked 24 High Volume LBT', 
			'RoyalMail_Tracked24HighVolumeSafeplace' => 'RoyalMail Tracked 24 High Volume Safeplace', 
			'RoyalMail_Tracked24HighVolumeSignature' => 'RoyalMail Tracked 24 High Volume Signature', 
			'RoyalMail_Tracked24HighVolumeSignatureLocalCollect' => 'RoyalMail Tracked 24 High Volume Signature Local Collect', 
			'RoyalMail_Tracked24LBT' => 'RoyalMail Tracked 24 LBT', 
			'RoyalMail_Tracked24SignatureLBT' => 'RoyalMail Tracked 24 Signaturec LBT', 
			'RoyalMail_Tracked48LBT' => 'RoyalMail Tracked 48 LBT', 
			'RoyalMail_Tracked48SignatureLBT' => 'RoyalMail Tracked 48Signaturec LBT', 
			'RoyalMail_Tracked24Signature' => 'RoyalMail Tracked 24 Signature', 
			'RoyalMail_Tracked24SignatureLocalCollect' => 'RoyalMail Tracked 24  Signature Local Collect', 
			'RoyalMail_Tracked24SignatureAge' => 'RoyalMail Tracked 24  Signature Age', 
			'RoyalMail_Tracked24SignatureAgeLocalCollect' => 'RoyalMail Tracked 24 Signature Age Local Collect', 
			'RoyalMail_Tracked24HighVolumeAgeSignature' => 'RoyalMail Tracked 24 High Volume Age Signature',
			'RoyalMail_Tracked48' => 'RoyalMail Tracked 48', 
			'RoyalMail_Tracked48Safeplace' => 'RoyalMail Tracked 48 Safeplace', 
			'RoyalMail_Tracked48HighVolume' => 'RoyalMail Tracked 48 High Volume', 
			'RoyalMail_Tracked48HighVolumeLBT' => 'RoyalMail Tracked 48 High Volume LBT', 
			'RoyalMail_Tracked48HighVolumeLBTLocalCollect' => 'RoyalMail Tracked 48 High Volume LBT Local Collect', 
			'RoyalMail_Tracked48HighVolumeSafeplace' => 'RoyalMail Tracked 48 High Volume Safeplace', 
			'RoyalMail_Tracked48HighVolumeSignature' => 'RoyalMail Tracked 48 High Volume Signature', 
			'RoyalMail_Tracked48HighVolumeSignatureLocalCollect' => 'RoyalMail Tracked 48 High Volume Signature Local Collect', 
			'RoyalMail_Tracked48Signature' => 'RoyalMail Tracked 48 Signature', 
			'RoyalMail_Tracked48SignatureAge' => 'RoyalMail Tracked 48 Signature Age', 
			'RoyalMail_Tracked48SignatureAgeLocalCollect' => 'RoyalMail Tracked 48 Signature Age Local Collect', 
			'RoyalMail_Tracked48SignatureLocalCollect' => 'RoyalMail Tracked 48 Signature Local Collect', 
			'RoyalMail_Tracked48HighVolumeAgeSignature' => 'RoyalMail Tracked 48 High Volume Age Signature', 
			'RoyalMail_TrackedReturns24' => 'RoyalMail Tracked Returns 24', 
			'RoyalMail_TrackedReturns48' => 'RoyalMail Tracked Returns 48',
			'RRDonnelley_CourierServiceDDP' => 'RR Donnelley Courier Service DDP',
			'RRDonnelley_CourierServiceDDU' => 'RR Donnelley Courier Service DDU',
			'RRDonnelley_DomesticEconomyParcel' => 'RR Donnelley Domestic Economy Parcel',
			'RRDonnelley_DomesticParcelBPM' => 'RR Donnelley Domestic Parcel BPM',
			'RRDonnelley_DomesticPriorityParcel' => 'RR Donnelley Domestic Priority Parcel',
			'RRDonnelley_DomesticPriorityParcelBPM' => 'RR Donnelley Domestic Priority Parcel BPM',
			'RRDonnelley_EMIService' => 'RR Donnelley EMI Service',
			'RRDonnelley_EconomyParcelService' => 'RR Donnelley Economy Parcel Service',
			'RRDonnelley_IPAService' => 'RR Donnelley IPA Service',
			'RRDonnelley_ISALService' => 'RR Donnelley ISAL Service',
			'RRDonnelley_PMIService' => 'RR Donnelley PMI Service',
			'RRDonnelley_PriorityParcelDDP' => 'RR Donnelley Priority Parcel DDP',
			'RRDonnelley_PriorityParcelDDU' => 'RR Donnelley Priority Parcel DDU',
			'RRDonnelley_PriorityParcelDeliveryConfirmationDDP' => 'RR Donnelley Priority Parcel Delivery Confirmation DDP',
			'RRDonnelley_PriorityParcelDeliveryConfirmationDDU' => 'RR Donnelley Priority Parcel Delivery Confirmation DDU',
			'RRDonnelley_ePacketService' => 'RR Donnelley ePacket Service',
			'Seko_Seko' => 'Seko',
			'SingaporePost_SingaporePost' => 'Singapore Post',
			'SpeeDee_SpeeDeeDelivery' => 'Spee-Dee Delivery ',
			'SprintShip_RoutedDeliveries' => 'SprintShip Routed Deliveries',
			'SprintShip_OnDemand' => 'SprintShip On Demand',
			'SprintShip_WhiteGloveDeliveries' => 'SprintShip White Glove Deliveries',
			'StarTrack_StartrackExpress' => 'Startrack Express',
			'StarTrack_StartrackPremium' => 'Startrack Premium',
			'StarTrack_StartrackFixedPricePremium' => 'Startrack Fixed Price Premium',
			'Toll_Toll' => 'Toll',
			'TForce_SameDay' => 'TForce Same Day',
			'TForce_SameDayWhiteGlove' => 'TForce Same Day White Glove',
			'TForce_NextDay' => 'TForce Next Day',
			'TForce_NextDayWhiteGlove' => 'TForce Next Day White Glove',
			'UDS_DeliveryService' => 'UDS Delivery Service',
			'Ukrposhta_Ukrposhta' => 'Ukrposhta',
			'UPSDAP_Ground' => 'UPSDAP Ground',
			'UPSDAP_UPSStandard' => 'UPSDAP Standard',
			'UPSDAP_UPSSaver' => 'UPSDAP Saver',
			'UPSDAP_Express' => 'UPSDAP Express',
			'UPSDAP_ExpressPlus' => 'UPSDAP Express Plus',
			'UPSDAP_Expedited' => 'UPSDAP Expedited',
			'UPSDAP_NextDayAir' => 'UPSDAP Next Day Air',
			'UPSDAP_NextDayAirSaver' => 'UPSDAP Next Day Air Saver',
			'UPSDAP_NextDayAirEarlyAM' => 'UPSDAP Next Day AirE arly AM',
			'UPSDAP_2ndDayAir' => 'UPSDAP 2nd Day Air',
			'UPSDAP_2ndDayAirAM' => 'UPSDAP 2nd Day Air AM',
			'UPSDAP_3DaySelect' => 'UPSDAP 3 Day Select',
			'UPS_Ground' => 'UPS Ground',
			'UPS_UPSStandard' => 'UPS Standard',
			'UPS_UPSSaver' => 'UPS Saver',
			'UPS_Express' => 'UPS Express',
			'UPS_ExpressPlus' => 'UPS Express Plus',
			'UPS_Expedited' => 'UPS Expedited',
			'UPS_NextDayAir' => 'UPS Next Day Air',
			'UPS_NextDayAirSaver' => 'UPS Next Day Air Saver',
			'UPS_NextDayAirEarlyAM' => 'UPS Next Day AirE arly AM',
			'UPS_2ndDayAir' => 'UPS 2nd Day Air',
			'UPS_2ndDayAirAM' => 'UPS 2nd Day Air AM',
			'UPS_3DaySelect' => 'UPS 3 Day Select',
			'UPSIparcel_UPSIparcel' => 'UPS i-parcel',
			'UPSMailInnovations_First' => 'UPS First Mail Innovations',
			'UPSMailInnovations_Priority' => 'UPS Priority Mail Innovations',
			'UPSMailInnovations_ExpeditedMailInnovations' => 'UPS Expedited Mail Innovations',
			'UPSMailInnovations_PriorityMailInnovations' => 'UPS Priority Mail Innovations',
			'UPSMailInnovations_EconomyMailInnovations' => 'UPS Economy Mail Innovations',
			'USPS_First' => 'USPS First Class',
			'USPS_Priority' => 'USPS Priority Mail',
			'USPS_Express' => 'USPS Priority Mail Express',
			'USPS_ParcelSelect' => 'USPS Parcel Select',
			'USPS_LibraryMail' => 'USPS Library Mail',
			'USPS_MediaMail' => 'USPS Media Mail',
			'USPS_FirstClassMailInternational' => 'USPS First Class Mail International',
			'USPS_FirstClassPackageInternationalService' => 'USPS First Class Package International Service',
			'USPS_PriorityMailInternational' => 'USPS Priority Mail International',
			'USPS_ExpressMailInternational' => 'USPS Express Mail International',
			'Veho_nextDay' => 'Veho Next Day',
			'Veho_sameDay' => 'Veho Same Day',
			'Yanwen_Yanwen' => 'Yanwen',
			'Yodel_Yodel' => 'Yodel',
		);
	}
}

endif;
