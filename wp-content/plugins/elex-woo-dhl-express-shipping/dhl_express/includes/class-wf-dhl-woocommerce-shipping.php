<?php

if (!defined('ABSPATH')) {
	exit;
}

class Elex_Dhl_Woocoomerce_Shipping_Method extends WC_Shipping_Method {

	private $found_rates;
	private $services;

	public function __construct() {
		if ( !function_exists('is_plugin_active') ) {        
			include_once ABSPATH . 'wp-admin/includes/plugin.php' ;
		}
		$this->id 				  = ELEX_DHL_ID;
		$this->method_title 	  = __('DHL Express', 'wf-shipping-dhl');
		$this->method_description = '';
		$this->services 		  = include 'data-wf-service-codes.php';
		$this->init();  
		
		
	}
	private function init() {
	   
		include_once 'data-wf-default-values.php';
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables
		$this->enabled                    = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'no';
		$this->title                      = $this->get_option('title', $this->method_title);
		$this->availability               = isset( $this->settings['availability'] ) ? $this->settings['availability'] : 'all';
		$this->countries                  = isset( $this->settings['countries'] ) ? $this->settings['countries'] : array();
		$this->origin                     = apply_filters('woocommerce_dhl_origin_postal_code', str_replace(' ', '', strtoupper($this->get_option('origin'))));
		$selected_country                 = isset($this->settings['base_country']) ? $this->settings['base_country'] : ( new WC_Countries() )->get_base_country();
		$this->origin_country             = apply_filters('woocommerce_dhl_origin_country_code', $selected_country);
		$this->origin_country_1           = $this->origin_country;
		$this->account_number             = $this->get_option('account_number');
		$this->site_id                    = $this->get_option('site_id');
		$this->site_password              = $this->get_option('site_password');
		$this->show_dhl_extra_charges     = $this->get_option('show_dhl_extra_charges');
		$this->show_dhl_insurance_charges = $this->get_option('show_dhl_insurance_charges');
		$this->freight_shipper_city       = htmlspecialchars($this->get_option('freight_shipper_city'));
		$del_bool                         =  $this->get_option( 'delivery_time' );
		$this->delivery_time              = ( 'yes' === $del_bool ) ? true : false;
		$this->latin_encoding 			  = isset($this->settings['latin_encoding']) && 'yes' === $this->settings['latin_encoding'] ? true : false;
		$utf8_support 					  = $this->latin_encoding ? '?isUTF8Support=true' : '';

		$_stagingUrl    = 'https://xmlpitest-ea.dhl.com/XMLShippingServlet' . $utf8_support;
		$_productionUrl = 'https://xmlpi-ea.dhl.com/XMLShippingServlet' . $utf8_support;

		$this->production  = ( !empty($this->settings['production']) && 'yes' === $this->settings['production'] ) ? true : false;
		$this->service_url = ( true === $this->production ) ? $_productionUrl : $_stagingUrl;

		$debug_bool            = $this->get_option('debug');
		$this->debug           = ( 'yes' === $debug_bool ) ? true : false;
		$insurance_bool        = $this->get_option('insure_contents');
		$this->insure_contents = ( 'yes' === $insurance_bool ) ? true : false;
		
		$this->request_type    = $this->get_option('request_type', 'LIST');
		$this->packing_method  = $this->get_option('packing_method', 'per_item');
		$this->boxes           = $this->get_option('boxes');
		$this->weight_boxes    = $this->get_option('weight_boxes') ? $this->get_option('weight_boxes') : array();
		$this->custom_services = $this->get_option('services', array());
		$this->offer_rates     = $this->get_option('offer_rates', 'all');
		$this->exclude_dhl_tax = $this->get_option('exclude_dhl_tax', '');

		$this->dutypayment_type   = $this->get_option('dutypayment_type', '');
		$this->dutyaccount_number = $this->get_option('dutyaccount_number', '');

		$this->dimension_unit = 'LBS_IN' === $this->get_option('dimension_weight_unit') ? 'IN' : 'CM';
		$this->weight_unit    = 'LBS_IN' === $this->get_option('dimension_weight_unit') ? 'LBS' : 'KG';

		$this->site_dimensional_unit = strtolower(get_option('woocommerce_dimension_unit'));
		$this->site_weight_unit      = strtolower(get_option('woocommerce_weight_unit'));

		$this->quoteapi_dimension_unit = $this->dimension_unit;
		$this->quoteapi_weight_unit    = 'LBS' === $this->weight_unit ? 'LB' : 'KG';

		$this->aelia_activated = is_plugin_active('woocommerce-aelia-currencyswitcher/woocommerce-aelia-currencyswitcher.php')? true: false;
		
		$this->conversion_rate = ( !empty($this->settings['conversion_rate']) && !$this->aelia_activated ) ? $this->settings['conversion_rate'] : 1;

		$this->shop_currency = $this->elex_dhl_get_currency_based_on_country_code(WC()->countries->get_base_country());

		if ( '' !== $this->shop_currency ) {
			$this->conversion_rate = apply_filters('wf_dhl_conversion_rate', $this->conversion_rate, $this->settings['dhl_currency_type'], $this->shop_currency);
		}
		
		//Time zone adjustment, which was configured in minutes to avoid time diff with server. Convert that in seconds to apply in date() functions.
		$this->timezone_offset         = !empty($this->settings['timezone_offset']) ? intval($this->settings['timezone_offset']) * 60 : 0;
		$this->insure_currency         = isset( $this->settings['insure_currency'] ) ?  $this->settings['insure_currency'] : '';
		$this->insure_converstion_rate = !empty($this->settings['insure_converstion_rate']) ? $this->settings['insure_converstion_rate'] : '';
		
		if (class_exists('wf_vendor_addon_setup')) {
			if (isset($this->settings['vendor_check']) && 'yes' === $this->settings['vendor_check'] ) {
				$this->ship_from_address = 'vendor_address'; 
			} else {
				$this->ship_from_address = 'origin_address';
			}
		} else {
			$this->ship_from_address = 'origin_address';
		}
		
		$this->weight_packing_process = !empty($this->settings['weight_packing_process']) ? $this->settings['weight_packing_process'] : 'pack_descending';
		//$this->box_max_weight           = !empty($this->settings['box_max_weight']) ? $this->settings['box_max_weight'] : '';
		$this->dhl_insurance_at_checkout = 'no';
		$this->http_req_referer 		 = '';
		$this->general_settings 		 = get_option('woocommerce_wf_dhl_shipping_settings');

		add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
		$this->woo_countries 							   = new WC_Countries();
		$this->is_woocommerce_composite_products_installed = ( in_array('woocommerce-composite-products/woocommerce-composite-products.php', get_option('active_plugins'), true) )? true: false;

		$this->is_woocommerce_multi_currency_installed = ( in_array('woocommerce-multicurrency/woocommerce-multicurrency.php', get_option('active_plugins'), true) )? true: false;
	}

	/**
	 * Is_available function.
	 *
	 * @param array $package
	 * @return bool
	 */
	public function is_available( $package ) {
		$post_data_string = '';
		
		if ( isset( $_POST['post_data'] ) ? wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['post_data'] ) ) ) : '' ) {
			parse_str( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['post_data'] ) ) ), $post_data_string );
		}

		$hide_shipping_methods_for_specific_countries = isset($this->general_settings['countries_to_hide_selected'])? $this->general_settings['countries_to_hide_selected']: 'no';
		if ( 'all' === $this->general_settings['availability'] && 'yes' === $hide_shipping_methods_for_specific_countries ) {
			$countries_to_hide_shipping_services = isset($this->general_settings['countries_to_hide_services'])? $this->general_settings['countries_to_hide_services']: array();

			if ( is_array( $countries_to_hide_shipping_services ) && !empty($countries_to_hide_shipping_services) && in_array( $package['destination']['country'], $countries_to_hide_shipping_services , true) ) {
				return false;
			}
		}
		
		/*Handling insurance and delivery signature charges when DHL real time option is disabled*/
		if ( '' !== $post_data_string ) {
			$dhl_insurance_checkout = isset($post_data_string['wf_dhl_insurance'])? 'yes': 'no';
			update_option('wf_dhl_insurance_enabled_checkout_no_real_time_enabled', $dhl_insurance_checkout);
		} else {
			/* while creating order */
			$dhl_insurance_checkout = isset($_POST['wf_dhl_insurance']) ? 'yes': 'no';
			update_option('wf_dhl_insurance_enabled_checkout_no_real_time_enabled', $dhl_insurance_checkout);
		}

		if ( 'no' === $this->enabled  || empty($this->enabled ) ) {
			return false;
		}

		if ( 'specific' === $this->availability ) {
			if ( is_array( $this->countries ) && ! in_array( $package['destination']['country'], $this->countries , true ) ) {
				return false;
			}
		} elseif ( 'excluding' === $this->availability ) {
			if ( is_array( $this->countries ) && ( in_array( $package['destination']['country'], $this->countries , true ) || ! $package['destination']['country'] ) ) {
				return false;
			}
		}
		return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', true, $package );
	}

	public function debug( $message, $type = 'notice') {
		if ($this->debug) {
			wc_add_notice($message, $type);
		}

	}

	public function admin_options() {
	   
		// Show settings
		parent::admin_options();
	}

	public function init_form_fields() {
		if (isset($_GET['page']) && 'wc-settings' === sanitize_text_field( $_GET['page'] )  ) {
			$this->form_fields = include 'data-wf-settings.php';
		}
	
	
	}

	public function generate_wf_dhl_tab_box_html() {
		$tab = ( !empty($_GET['subtab']) ) ? sanitize_text_field($_GET['subtab']) : 'general';

				echo '
                <div class="wrap">
                    <style>
                        .woocommerce-help-tip{color:darkgray !important;}
                        <style>
                        .woocommerce-help-tip {
                            position: relative;
                            display: inline-block;
                            border-bottom: 1px dotted black;
                        }

                        .woocommerce-help-tip .tooltiptext {
                            visibility: hidden;
                            width: 120px;
                            background-color: black;
                            color: #fff;
                            text-align: center;
                            border-radius: 6px;
                            padding: 5px 0;

                            /* Position the tooltip */
                            position: absolute;
                            z-index: 1;
                        }

                        .woocommerce-help-tip:hover .tooltiptext {
                            visibility: visible;
                        }
                        </style>
                    </style>
                    <hr class="wp-header-end">';
				$this->elex_dhl_shipping_page_tabs($tab);
		if ( 'auto-generate-add-on' !== $tab ) {
			echo'<script>
                        jQuery(document).ready(function(){
                            jQuery(".dhl_express_addon_auto_tab_field").closest("tr,h3").hide();
                            jQuery(".dhl_express_addon_auto_tab_field").next("p").hide();
                        });
                    </script>';  
		}
		if ( 'dhl-india-add-on' !== $tab ) {
			echo'<script>
                        jQuery(document).ready(function(){
                            jQuery(".dhl_india_tab_field").closest("tr,h3").hide();
                            jQuery(".dhl_india_tab_field").next("p").hide();
                        });
                    </script>';  
		}
		if ( 'auto-generate-add-on' !== $tab  && 'dhl-india-add-on' !== $tab ) {
			echo'<script>
                        jQuery(document).ready(function(){
                            jQuery(".woocommerce-save-button").hide();
                        });
                    </script>';
		}
		switch ($tab) {
			case 'general':
				echo '<div class="table-box table-box-main" id="general_section" style="margin-top: 0px;border: 1px solid #ccc;border-top: unset !important;padding: 5px;">';
				require_once 'settings/dhl_general_settings.php';
				echo '</div>';
				break;
			case 'rates':
				echo '<div class="table-box table-box-main" id="rates_section" style="margin-top: 0px;border: 1px solid #ccc;border-top: unset !important;padding: 5px;">';
				require_once 'settings/dhl_rates_settings.php';
				echo '</div>';
				break;
			case 'labels':
				echo '<div class="table-box table-box-main" id="labels_section" style="margin-top: 0px;
						border: 1px solid #ccc;border-top: unset !important;padding: 5px;">';
				require_once 'market.php';
				echo '</div>';
				break;
			case 'packing':
				echo '<div class="table-box table-box-main" id="packing_section" style="margin-top: 0px;
						border: 1px solid #ccc;border-top: unset !important;padding: 5px;">';
				require_once 'settings/aus_packingl_settings.php';
				echo '</div>';
				break;
			case 'premium':
				echo '<div class="table-box table-box-main" id="licence_section" style="margin-top: 0px; border: 1px solid #ccc;border-top: unset !important;padding: 5px;">';
				require_once 'settings/dhl_premium.php';
				echo '</div>';
				break;

			case 'dhl-india-add-on':
				include ELEX_DHL_INDIA_ADDON_WOOCOMMERCE_EXTENSION_PATH . 'includes/elex-dhl-india-seperate_sections.php';
				$plugin_name = 'dhl-india-addon';
				// include ELEX_DHL_INDIA_ADDON_WOOCOMMERCE_EXTENSION_PATH . 'wf_api_manager/html/html-wf-activation-window.php';


		}
				echo '
                </div>';
	}
	
	public function elex_dhl_shipping_page_tabs( $current = 'general') {
	
		
		$tag_premium = "<small style='color:green;font-size:xx-small;'>[Premium]</small>";
		$tab_premium = '<navtab>Go Premium!</navtab>';

		$tabs     = array(
					 'general'   => __('General', 'wf-shipping-dhl'),
					 'rates'     => __('Rates & Services', 'wf-shipping-dhl'),
					 'labels'    => __('Label & Tracking ' . $tag_premium, 'wf-shipping-dhl'),
					 'packing'   => __('Packaging ' . $tag_premium, 'wf-shipping-dhl'),
					 'premium'   => __($tab_premium, 'wf-shipping-dhl')
				 );
			$html = '<h2 class="nav-tab-wrapper">';
		
		foreach ($tabs as $tab => $name) {
			$class = ( $tab === $current ) ? 'nav-tab-active' : '';
			$style = ( $tab === $current ) ? 'border-bottom: 1px solid transparent !important;' : '';

			if ( 'labels' == $tab || 'packing' == $tab ) {
				$class = ( $tab == $current ) ? 'nav-tab-active' : '';
				$style = ( $tab == $current ) ? 'border-bottom: 1px solid transparent !important;' : '';
				$html .= '<a style="text-decoration:none !important;' . $style . '" class="nav-tab ' . $class . '" href="?page=' . elex_dhl_get_settings_url() . '&tab=shipping&section=wf_dhl_shipping&subtab=premium ">' . $name . '</a>';
			} elseif ( 'premium' == $tab ) {
				$class = ( $tab == $current ) ? 'nav-tab-active' : '';
				$style = ( $tab == $current ) ? 'border-bottom: 1px solid transparent !important;' : '';
				$html .= '<a style="text-decoration:none !important; color: red;' . $style . '" class="nav-tab ' . $class . '" href="?page=' . elex_dhl_get_settings_url() . '&tab=shipping&section=wf_dhl_shipping&subtab=' . $tab . '">' . $name . '</a>';
			} else {
				$class = ( $tab == $current ) ? 'nav-tab-active' : '';
				$style = ( $tab == $current ) ? 'border-bottom: 1px solid transparent !important;' : '';
				$html .= '<a style="text-decoration:none !important;' . $style . '" class="nav-tab ' . $class . '" href="?page=' . elex_dhl_get_settings_url() . '&tab=shipping&section=wf_dhl_shipping&subtab=' . $tab . '">' . $name . '</a>';
			}

			
		}
			$html .= '</h2>';
			echo wp_kses_post( $html );
	}
	

	public function generate_services_html() {
		ob_start();
		include 'html-wf-services.php';
		return ob_get_clean();
	}

	public function validate_services_field( $key) {
		$services 		 = array();
		$posted_services = isset( $_POST['dhl_service'] ) && isset( $_POST['elex_dhl_nonce'] ) && wp_verify_nonce( wp_kses_post( wp_unslash( $_POST['elex_dhl_nonce'] ) )  , 'elex_dhl_express' ) ? 
		array_map( 'wp_kses_allowed_html', wp_unslash( $_POST['dhl_service'] ) ) : array();
		foreach ($posted_services as $code => $settings) {
			$services[$code] = array(
				'name' => wc_clean($settings['name']),
				'order' => wc_clean($settings['order']),
				'enabled' => isset($settings['enabled']) ? true : false,
			);
		}

		return $services;
	}


	/**
	* Function returns the collection of countries which different WooCommerce country codes and DHL accepted country codes
	*
	* @Access public
	* @return array countries
	*/
	public function elex_dhl_country_codes_with_conflicts() {
		$countries = array( 
			'Bonaire' => array(
				'Woocommerce_country_code' => 'BQ',
				'dhl_country_code' => 'XB'
			),
			'Curacao' => array(
				'Woocommerce_country_code' => 'CW',
				'dhl_country_code' => 'XC'
			),
		);

		return $countries;
	}

	/**
	* Function returns DHL accepted country codes for a given WooCommerce country codes
	*
	* @Access public
	*/
	public function elex_dhl_get_country_codes_mapped_for_dhl( $country_code) {
		$conflict_countries_codes = $this->elex_dhl_country_codes_with_conflicts();

		foreach ($conflict_countries_codes as $conflict_countries_codes_key => $conflict_countries_codes_values) {
			if ($conflict_countries_codes_values['Woocommerce_country_code'] === $country_code) {
				return $conflict_countries_codes_values['dhl_country_code'];
			}
		}
		return $country_code;
	}

	/**
	* Function to provide next working day if mailing day is a non-working day
	 *
	* @Access public
	* @param string, string, boolean
	* @return boolean or date
	*/
	public function elex_dhl_provide_next_working_day( $requested_shipment_mailing_day, $seller_store_working_days, $recurrsion = false) {
		if ( true === $recurrsion ) {
			foreach ($seller_store_working_days as $seller_store_working_day_name => $seller_store_working_day) {
				if ('yes' === $seller_store_working_day['status'] ) {
					return gmdate('Y-m-d', strtotime('next ' . $seller_store_working_day['name']));
				}
			}
			return false;
		} else {
			foreach ($seller_store_working_days as $seller_store_working_day_name => $seller_store_working_day) {
				if (( $seller_store_working_day['value'] > $seller_store_working_days[$requested_shipment_mailing_day]['value'] ) && ( 'yes' === $seller_store_working_day['status'] )) {
					return gmdate('Y-m-d', strtotime('next ' . $seller_store_working_day['name']));
				}
			}
			return false;
		}
	}

	public function elex_dhl_get_mailing_date ( $mailing_date, $mailing_day) {
		/*Working days array with settings provided by user in settings*/
		$working_days		 = array(
			'Mon'   => array('name' => 'monday', 'status'=> isset($this->settings['working_day_monday'])? $this->settings['working_day_monday']: 'no', 'value' => 1),
			'Tue'   => array('name' => 'tuesday', 'status'=> isset($this->settings['working_day_tuesday'])? $this->settings['working_day_tuesday']: 'no', 'value' => 2),           
			'Wed'   => array('name' => 'wednesday', 'status'=> isset($this->settings['working_day_wednesday'])? $this->settings['working_day_wednesday']: 'no', 'value' => 3),
			'Thu'   => array('name' => 'thursday', 'status'=> isset($this->settings['working_day_thursday'])? $this->settings['working_day_thursday']: 'no', 'value' => 4),            
			'Fri'   => array('name' => 'friday', 'status'=> isset($this->settings['working_day_friday'])? $this->settings['working_day_friday']: 'no', 'value' => 5),          
			'Sat'   => array('name' => 'saturday', 'status'=> isset($this->settings['working_day_saturday'])? $this->settings['working_day_saturday']: 'no', 'value' => 6),            
			'Sun'   => array('name' => 'sunday', 'status'=> isset($this->settings['working_day_sunday'])? $this->general_settings['working_day_sunday']: 'no', 'value' => 7),      
		);
		$current_time 		 = current_time('H:i');
		$mailing_cutoff_time = isset($this->settings['elex_dhl_cutoff_time'])? $this->settings['elex_dhl_cutoff_time']: '';

		

		if (strtotime($current_time) >= strtotime($mailing_cutoff_time) || 'yes' !== $working_days[$mailing_day]['status'] ) {
			$next_working_date = $this->elex_dhl_provide_next_working_day($mailing_day, $working_days);
			if (!$next_working_date) {
				$recurrsion 	   = true;
				$next_working_date = $this->elex_dhl_provide_next_working_day($mailing_day, $working_days, $recurrsion);
			}

			if ($next_working_date) {
				$mailing_date = $next_working_date;
			}
		}
		return $mailing_date;
	}

	private function elex_dhl_get_dhl_requests( $dhl_packages, $package, $package_total_amt = '') {
		global $woocommerce;

		// if ( ! class_exists( 'ElexDhlWoocommerceShippingAdminHelper' ) ) {
		// include_once 'class-wf-dhl-woocommerce-shipping-admin-helper.php';
		// }

		// $woo_dhl_wrapper = new ElexDhlWoocommerceShippingAdminHelper();

		
		

		/*  According to WooCommerce The Canary Islands is a country, but according to DHL it is a part of Spain.
			If the postcodes belong to Canary Islands, we are providing country code as 'ES'
		*/
		$canary_islands_postcodes = array( 35100, 35500, 35240, 35220, 35570, 35520, 35560, 35561, 35571, 35628, 35640, 35629, 35600, 35637, 35290, 35018, 35011, 35017, 35508, 35510, 35572, 35530 );

		// Time is modified to avoid date diff with server.
		$mailing_date 	  = current_time('Y-m-d');
		$mailing_day  	  = current_time('D', strtotime($mailing_date));
		$mailing_date 	  = $this->elex_dhl_get_mailing_date($mailing_date, $mailing_day);
		$mailing_datetime = gmdate('Y-m-d', current_time('timestamp')) . 'T' . gmdate('H:i:s', current_time('timestamp'));
		

		$destination_postcode = str_replace(' ', '', strtoupper($package['destination']['postcode']));
		$pieces 			  = $this->elex_dhl_get_package_piece($dhl_packages);

		// $order_items_total = $woo_dhl_wrapper->get_order_items_total($package['contents']);
		if ($package_total_amt) {
			$total_value = $package_total_amt;
		} else {
			$total_value = $woocommerce->cart->cart_contents_total;
		}
		$currency 			   = get_woocommerce_currency();
		$total_insurance_value = 0;
		$is_dutiable 		   = '';
		$origin_postcode_city  = '';
		$paymentCountryCode	   = '';
		
		if ($this->settings['insure_contents'] == 'yes' && !empty($this->insure_converstion_rate)  && isset($_POST['wf_dhl_insurance']) && $_POST['wf_dhl_insurance'] == 'yes') {
			$total_insurance_value = round(apply_filters('wc_aelia_cs_convert', $total_value, get_woocommerce_currency(), $this->shop_currency)) * $this->insure_converstion_rate;
		} else {
			$total_insurance_value = $total_value;
		}
		
		$total_insurance_value = apply_filters('wc_aelia_cs_convert', $total_insurance_value, $this->shop_currency, get_woocommerce_currency());

		$insurance_details 		      = '';
		$additional_insurance_details ='';
		$insurance_enabled 			  = ( isset($package['dhl_insurance']) && !empty($package['dhl_insurance']) )? $package['dhl_insurance'] : 'no';

		$this->insure_currency = ( !empty($this->insure_currency) ) ? $this->insure_currency : get_woocommerce_currency();

		if ( 'yes' === $insurance_enabled ) {
			update_option('wf_dhl_insurance', 'yes');
		} else {
			update_option('wf_dhl_insurance', 'no');
		}
		
		if (is_shop()) {
			if ('yes' === $insurance_enabled  ) {
				$insurance_details 			  = $this->insure_contents ? "<InsuredValue>{$total_insurance_value}</InsuredValue><InsuredCurrency>{$this->insure_currency}</InsuredCurrency>" : '';
				$additional_insurance_details = ( $this->insure_contents && ( $this->conversion_rate || $this->insure_converstion_rate ) ) ? '<SpecialServiceType>II</SpecialServiceType><LocalSpecialServiceType>XCH</LocalSpecialServiceType>' : '';
			}
		} else {
			$this->insure_currency = ( !empty($this->insure_currency) ) ? $this->insure_currency : get_woocommerce_currency();
			if ( 'yes' === $insurance_enabled  ) {
				$insurance_details 			  = $this->insure_contents ? "<InsuredValue>{$total_insurance_value}</InsuredValue><InsuredCurrency>{$this->insure_currency}</InsuredCurrency>" : '';
				$additional_insurance_details = ( $this->insure_contents && ( $this->conversion_rate || $this->insure_converstion_rate ) ) ? '<SpecialServiceType>II</SpecialServiceType><LocalSpecialServiceType>XCH</LocalSpecialServiceType>' : '';
			}
		}

		$special_service_type_details = '';
		if ( '' !== $additional_insurance_details ) {
			$special_service_type_details = '<QtdShp><QtdShpExChrg>';
	
			if ( '' !== $additional_insurance_details ) {
				$special_service_type_details .= $additional_insurance_details;
			}
			$special_service_type_details .= '</QtdShpExChrg></QtdShp>';
		}



		//If vendor country set, then use vendor address
		if (isset($this->settings['vendor_check']) && ( 'yes' === $this->settings['vendor_check'] )) {
			if (isset($package['origin'])) {
				if (isset($package['origin']['country'])) {
					$this->origin_country_1     =     $package['origin']['country'];
					$this->origin               =     $package['origin']['postcode'];
					$this->freight_shipper_city =     $package['origin']['city'];

					$origin_postcode_city = $this->elex_get_postcode_city($this->origin_country_1, $this->freight_shipper_city, $this->origin);
				}
			}
		} else {
			$origin_postcode_city = $this->elex_get_postcode_city($this->origin_country, $this->freight_shipper_city, $this->origin);
		}

		$paymentCountryCode = isset($this->general_settings['dutypayment_country']) && !empty($this->general_settings['dutypayment_country'])? $this->general_settings['dutypayment_country']: $this->general_settings['base_country'];// obtaining payment country code from label settings

		// For multi-vendor cases
		if (isset($this->settings['vendor_check']) && 'yes' === $this->settings['vendor_check'] ) {
			$is_dutiable = ( $package['destination']['country'] === $this->origin_country_1 || elex_dhl_is_eu_country($this->origin_country_1, $package['destination']['country']) ) ? 'N' : 'Y';
		} else {
			$is_dutiable = ( $package['destination']['country'] === $this->origin_country || elex_dhl_is_eu_country($this->origin_country, $package['destination']['country']) ) ? 'N' : 'Y';
		}
		if (isset($this->settings['rate_is_dutiable']) && 'N' === $this->settings['rate_is_dutiable'] ) {
			$is_dutiable = 'N';
		}
	
		if (( 'ES' === $package['destination']['country'] ) && ( 'CE' === $package['destination']['state'] || 'ML' === $package['destination']['state'] )) {
			 $is_dutiable = 'Y';
		}
		$order_dutiable_amount = 0 !== $total_value ? $total_value: $order_items_total;

		$dutiable_content = 'Y' === $is_dutiable ? "<Dutiable><DeclaredCurrency>{$currency}</DeclaredCurrency><DeclaredValue>{$order_dutiable_amount}</DeclaredValue></Dutiable>" : '';

		$destination_city = htmlspecialchars(strtoupper($package['destination']['city']));

		/*There are different country codes for same country from WooCommerce and DHL. Here we are obtaining country code which is mapped to DHL for both source and destination countries*/
		$destination_country_code = $this->elex_dhl_get_country_codes_mapped_for_dhl($package['destination']['country']);
		if (in_array($package['destination']['postcode'], $canary_islands_postcodes , true )) {
			$destination_country_code = 'IC';
		}
		$state_as_city = apply_filters('elex_dhl_send_state_as_city_to_api', false);
		if ($state_as_city) {
			if (in_array($package['destination']['country'], $state_as_city, true)) {
				$destination_city = strtoupper($package['destination']['state']);
			}
		}
		$destination_postcode_city 			 = $this->elex_get_postcode_city($package['destination']['country'], $destination_city, $destination_postcode);
		$source_country_code 	   			 = $this->elex_dhl_get_country_codes_mapped_for_dhl($this->origin_country_1);
		$switch_account_number_action_input  = array('account_number' => $this->settings['account_number'], 'source_country_code' => $source_country_code, 'payment_country_code' => $this->settings['dutypayment_country'] , 'destination_country_code' => $package['destination']['country']);
		$switch_account_number_action_result = apply_filters('switch_account_number_action_express_dhl_elex', $switch_account_number_action_input);

		$this->account_number = isset($switch_account_number_action_result['payment_account_number'])? $switch_account_number_action_result['payment_account_number']: $switch_account_number_action_result['account_number'];

		$paymentCountryCode = isset($switch_account_number_action_result['payment_country_code'])? $switch_account_number_action_result['payment_country_code']: $switch_account_number_action_result['source_country_code'];
		
		$fetch_accountrates    = 'ACCOUNT' === $this->request_type ? '<PaymentAccountNumber>' . $this->account_number . '</PaymentAccountNumber>' : '';
		$message_reference_num = elex_dhl_generate_random_message_reference();

		
$xmlRequest 		= <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<p:DCTRequest xmlns:p="http://www.dhl.com" xmlns:p1="http://www.dhl.com/datatypes" xmlns:p2="http://www.dhl.com/DCTRequestdatatypes" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dhl.com DCT-req.xsd ">
  <GetQuote>
    <Request>
        <ServiceHeader>
            <MessageTime>{$mailing_datetime}</MessageTime>
            <MessageReference>{$message_reference_num}</MessageReference>
            <SiteID>{$this->site_id}</SiteID>
            <Password>{$this->site_password}</Password>
        </ServiceHeader>
    </Request>
    <From>
      <CountryCode>{$source_country_code}</CountryCode>
      {$origin_postcode_city}
    </From>
    <BkgDetails>
      <PaymentCountryCode>{$paymentCountryCode}</PaymentCountryCode>
      <Date>{$mailing_date}</Date>
      <ReadyTime>PT10H21M</ReadyTime>
      <DimensionUnit>{$this->quoteapi_dimension_unit}</DimensionUnit>
      <WeightUnit>{$this->quoteapi_weight_unit}</WeightUnit>
      <Pieces>
        {$pieces}
      </Pieces>
      {$fetch_accountrates}
      <IsDutiable>{$is_dutiable}</IsDutiable>
      <NetworkTypeCode>AL</NetworkTypeCode>
      {$special_service_type_details}
      {$insurance_details}
    </BkgDetails>
    <To>
      <CountryCode>{$destination_country_code}</CountryCode>
      {$destination_postcode_city}
    </To>
    {$dutiable_content}
  </GetQuote>
</p:DCTRequest>
XML;
		$xmlRequest = apply_filters('wf_dhl_rate_request', $xmlRequest, $package);
		return $xmlRequest;
	}

	private function elex_dhl_get_package_piece( $dhl_packages) {
		$pieces = '';
		if ($dhl_packages) {

			foreach ($dhl_packages as $key => $parcel) {
				$pack_type = $this->elex_dhl_get_pack_type($parcel['packtype']);
				$index     = $key + 1;
				$pieces   .= '<Piece><PieceID>' . $index . '</PieceID>';
				$pieces   .= '<PackageTypeCode>' . $pack_type . '</PackageTypeCode>';
				
				if ( !empty($parcel['Dimensions']['Height']) && !empty($parcel['Dimensions']['Length']) && !empty($parcel['Dimensions']['Width']) ) {
					$pieces .= '<Height>' . round($parcel['Dimensions']['Height']) . '</Height>';
					$pieces .= '<Depth>' . round($parcel['Dimensions']['Length']) . '</Depth>';
					$pieces .= '<Width>' . round($parcel['Dimensions']['Width']) . '</Width>';
				}
				
				$package_total_weight =(string) $parcel['Weight']['Value'];
				$package_total_weight = str_replace(',', '.', $package_total_weight);
				if ($package_total_weight < 0.001) {
					$package_total_weight = 0.001;
				} else {
					$package_total_weight = $package_total_weight;
				}
				$pieces .= '<Weight>' . round((float) $package_total_weight, 3) . '</Weight></Piece>';
			}
		}
		return $pieces;
	}

	private function elex_get_postcode_city( $country, $city, $postcode) {
		$no_postcode_country = array('AE', 'AF', 'AG', 'AI', 'AL', 'AN', 'AO', 'AW', 'BB', 'BF', 'BH', 'BI', 'BJ', 'BM', 'BO', 'BS', 'BT', 'BW', 'BZ', 'CD', 'CF', 'CG', 'CI', 'CK',
			'CL', 'CM', 'CR', 'CV', 'DJ', 'DM', 'DO', 'EC', 'EG', 'ER', 'ET', 'FJ', 'FK', 'GA', 'GD', 'GH', 'GI', 'GM', 'GN', 'GQ', 'GT', 'GW', 'GY', 'HK', 'HN', 'HT', 'IE', 'IQ', 'IR',
			'JM', 'JO', 'KE', 'KH', 'KI', 'KM', 'KN', 'KP', 'KW', 'KY', 'LA', 'LB', 'LC', 'LK', 'LR', 'LS', 'LY', 'ML', 'MM', 'MO', 'MR', 'MS', 'MT', 'MU', 'MW', 'MZ', 'NA', 'NE', 'NG', 'NI',
			'NP', 'NR', 'NU', 'OM', 'PA', 'PE', 'PF', 'PY', 'QA', 'RW', 'SA', 'SB', 'SC', 'SD', 'SL', 'SN', 'SO', 'SR', 'SS', 'ST', 'SV', 'SY', 'TC', 'TD', 'TG', 'TL', 'TO', 'TT', 'TV', 'TZ',
			'UG', 'UY', 'VC', 'VE', 'VG', 'VN', 'VU', 'WS', 'XA', 'XB', 'XC', 'XE', 'XL', 'XM', 'XN', 'XS', 'YE', 'ZM', 'ZW');

		$postcode_city = "<Postalcode>{$postcode}</Postalcode>";

		$postcode_city = !in_array( $country, $no_postcode_country , true ) ? $postcode_city : '';
		if ( !empty($city) ) {
			$postcode_city .= "<City>{$city}</City>";
		}
		return $postcode_city;
	}
	
	/**
	* @Access private
	* Function to get country code for corresponding currencies
	* @return array currencies with countries' codes as values
	*/
	public function elex_dhl_get_currency_countries() {
		return array(
			'AFN' => array( 'AF' ),
			'ALL' => array( 'AL' ),
			'DZD' => array( 'DZ' ),
			'USD' => array( 'AS', 'IO', 'GU', 'MH', 'FM', 'MP', 'PW', 'PR', 'TC', 'US', 'UM', 'VI' ),
			'EUR' => array( 'AD', 'AT', 'BE', 'CY', 'EE', 'FI', 'FR', 'GF', 'TF', 'DE', 'GR', 'GP', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'MQ', 'YT', 'MC', 'ME', 'NL', 'PT', 'RE', 'PM', 'SM', 'SK', 'SI', 'ES' ),
			'AOA' => array( 'AO' ),
			'XCD' => array( 'AI', 'AQ', 'AG', 'DM', 'GD', 'MS', 'KN', 'LC', 'VC' ),
			'ARS' => array( 'AR' ),
			'AMD' => array( 'AM' ),
			'AWG' => array( 'AW' ),
			'AUD' => array( 'AU', 'CX', 'CC', 'HM', 'KI', 'NR', 'NF', 'TV' ),
			'AZN' => array( 'AZ' ),
			'BSD' => array( 'BS' ),
			'BHD' => array( 'BH' ),
			'BDT' => array( 'BD' ),
			'BBD' => array( 'BB' ),
			'BYR' => array( 'BY' ),
			'BZD' => array( 'BZ' ),
			'XOF' => array( 'BJ', 'BF', 'ML', 'NE', 'SN', 'TG' ),
			'BMD' => array( 'BM' ),
			'BTN' => array( 'BT' ),
			'BOB' => array( 'BO' ),
			'BAM' => array( 'BA' ),
			'BWP' => array( 'BW' ),
			'NOK' => array( 'BV', 'NO', 'SJ' ),
			'BRL' => array( 'BR' ),
			'BND' => array( 'BN' ),
			'BGN' => array( 'BG' ),
			'BIF' => array( 'BI' ),
			'KHR' => array( 'KH' ),
			'XAF' => array( 'CM', 'CF', 'TD', 'CG', 'GQ', 'GA' ),
			'CAD' => array( 'CA' ),
			'CVE' => array( 'CV' ),
			'KYD' => array( 'KY' ),
			'CLP' => array( 'CL' ),
			'CNY' => array( 'CN' ),
			'HKD' => array( 'HK' ),
			'COP' => array( 'CO' ),
			'KMF' => array( 'KM' ),
			'CDF' => array( 'CD' ),
			'NZD' => array( 'CK', 'NZ', 'NU', 'PN', 'TK' ),
			'CRC' => array( 'CR' ),
			'HRK' => array( 'HR' ),
			'CUP' => array( 'CU' ),
			'CZK' => array( 'CZ' ),
			'DKK' => array( 'DK', 'FO', 'GL' ),
			'DJF' => array( 'DJ' ),
			'DOP' => array( 'DO' ),
			'ECS' => array( 'EC' ),
			'EGP' => array( 'EG' ),
			'SVC' => array( 'SV' ),
			'ERN' => array( 'ER' ),
			'ETB' => array( 'ET' ),
			'FKP' => array( 'FK' ),
			'FJD' => array( 'FJ' ),
			'GMD' => array( 'GM' ),
			'GEL' => array( 'GE' ),
			'GHS' => array( 'GH' ),
			'GIP' => array( 'GI' ),
			'QTQ' => array( 'GT' ),
			'GGP' => array( 'GG' ),
			'GNF' => array( 'GN' ),
			'GWP' => array( 'GW' ),
			'GYD' => array( 'GY' ),
			'HTG' => array( 'HT' ),
			'HNL' => array( 'HN' ),
			'HUF' => array( 'HU' ),
			'ISK' => array( 'IS' ),
			'INR' => array( 'IN' ),
			'IDR' => array( 'ID' ),
			'IRR' => array( 'IR' ),
			'IQD' => array( 'IQ' ),
			'GBP' => array( 'IM', 'JE', 'GS', 'GB' ),
			'ILS' => array( 'IL' ),
			'JMD' => array( 'JM' ),
			'JPY' => array( 'JP' ),
			'JOD' => array( 'JO' ),
			'KZT' => array( 'KZ' ),
			'KES' => array( 'KE' ),
			'KPW' => array( 'KP' ),
			'KRW' => array( 'KR' ),
			'KWD' => array( 'KW' ),
			'KGS' => array( 'KG' ),
			'LAK' => array( 'LA' ),
			'LBP' => array( 'LB' ),
			'LSL' => array( 'LS' ),
			'LRD' => array( 'LR' ),
			'LYD' => array( 'LY' ),
			'CHF' => array( 'LI', 'CH' ),
			'MKD' => array( 'MK' ),
			'MGF' => array( 'MG' ),
			'MWK' => array( 'MW' ),
			'MYR' => array( 'MY' ),
			'MVR' => array( 'MV' ),
			'MRO' => array( 'MR' ),
			'MUR' => array( 'MU' ),
			'MXN' => array( 'MX' ),
			'MDL' => array( 'MD' ),
			'MNT' => array( 'MN' ),
			'MAD' => array( 'MA', 'EH' ),
			'MZN' => array( 'MZ' ),
			'MMK' => array( 'MM' ),
			'NAD' => array( 'NA' ),
			'NPR' => array( 'NP' ),
			'ANG' => array( 'AN' ),
			'XPF' => array( 'NC', 'WF' ),
			'NIO' => array( 'NI' ),
			'NGN' => array( 'NG' ),
			'OMR' => array( 'OM' ),
			'PKR' => array( 'PK' ),
			'PAB' => array( 'PA' ),
			'PGK' => array( 'PG' ),
			'PYG' => array( 'PY' ),
			'PEN' => array( 'PE' ),
			'PHP' => array( 'PH' ),
			'PLN' => array( 'PL' ),
			'QAR' => array( 'QA' ),
			'RON' => array( 'RO' ),
			'RUB' => array( 'RU' ),
			'RWF' => array( 'RW' ),
			'SHP' => array( 'SH' ),
			'WST' => array( 'WS' ),
			'STD' => array( 'ST' ),
			'SAR' => array( 'SA' ),
			'RSD' => array( 'RS' ),
			'SCR' => array( 'SC' ),
			'SLL' => array( 'SL' ),
			'SGD' => array( 'SG' ),
			'SBD' => array( 'SB' ),
			'SOS' => array( 'SO' ),
			'ZAR' => array( 'ZA' ),
			'SSP' => array( 'SS' ),
			'LKR' => array( 'LK' ),
			'SDG' => array( 'SD' ),
			'SRD' => array( 'SR' ),
			'SZL' => array( 'SZ' ),
			'SEK' => array( 'SE' ),
			'SYP' => array( 'SY' ),
			'TWD' => array( 'TW' ),
			'TJS' => array( 'TJ' ),
			'TZS' => array( 'TZ' ),
			'THB' => array( 'TH' ),
			'TOP' => array( 'TO' ),
			'TTD' => array( 'TT' ),
			'TND' => array( 'TN' ),
			'TRY' => array( 'TR' ),
			'TMT' => array( 'TM' ),
			'UGX' => array( 'UG' ),
			'UAH' => array( 'UA' ),
			'AED' => array( 'AE' ),
			'UYU' => array( 'UY' ),
			'UZS' => array( 'UZ' ),
			'VUV' => array( 'VU' ),
			'VEF' => array( 'VE' ),
			'VND' => array( 'VN' ),
			'YER' => array( 'YE' ),
			'ZMW' => array( 'ZM' ),
			'ZWD' => array( 'ZW' ),
		);
	}
	
	private function elex_dhl_get_package_total_value( $dhl_packages) {
		$total_value = 0;
		if ($dhl_packages) {
			foreach ($dhl_packages as $key => $parcel) {
				$total_value += $parcel['InsuredValue']['Amount'] * $parcel['GroupPackageCount'];
			}
		}
		return $total_value;
	}

	public function calculate_shipping( $packages = array() ) {
		$str 		  = '';
		$http_referer = '';
		$req_uri 	  = '';
		if ( isset($_POST['woocommerce-shipping-calculator-nonce']) && wp_verify_nonce( sanitize_text_field( $_POST['woocommerce-shipping-calculator-nonce'] ) , 'woocommerce-shipping-calculator')) {
		
			if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
				$http_referer = sanitize_text_field($_SERVER['HTTP_REFERER']);
				$req_uri      = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field($_SERVER['REQUEST_URI']) : '';
			}
			
			$this->http_req_referer = $http_referer;
			
			if (isset($_POST['post_data'])) {
				parse_str(sanitize_text_field($_POST['post_data']), $str);
			}
		}
		$calculate_shipping_rates = apply_filters('disable_calculate_shipping_in_shop_page_express_dhl_elex', true);// Hook to enable/disable calculating shipping rates on the shop while adding products to the cart
		
		$is_checkout_page = false;
		$is_cart_page 	  = false;
		if (strpos($req_uri, '/checkout') > -1 || is_checkout()) {
			$is_checkout_page = true;
		}
		
		if (strpos($req_uri, '/cart') > -1 || is_cart()) {
			$is_cart_page = true;
		}

		if ( !$calculate_shipping_rates && !( $is_cart_page || $is_checkout_page ) ) {
			return;
		}

		global $woocommerce;
		// Clear rates
		$this->found_rates = array();

		/* For the Sweden, DHL accepted postcode format is 999 99 */
		if ( 'SE' === $packages['destination']['country'] ) {
			$postcode_part_1 = substr($packages['destination']['postcode'], 0, 3);
			$postcode_part_2 = substr($packages['destination']['postcode'], 3, strlen($packages['destination']['country']));
			if (' ' !== $postcode_part_2[0] ) {
				$packages['destination']['postcode'] = $postcode_part_1 . ' ' . $postcode_part_2;
			}
		}
		
		// Debugging
		$this->debug(__('dhl debug mode is on - to hide these messages, turn debug mode off in the settings.', 'wf-shipping-dhl'));
		// Packages returned should be an array regardless of filter added or not 
		$parcels = apply_filters('wf_filter_package_address', array($packages) , $this->ship_from_address);
		
		if (get_option('current_order_data') != '') {
			delete_option('current_order_data');
		}

		// Get requests
		$dhl_requests  =   array();
		$dhl_insurance = false;
		foreach ($parcels as $parcel) {

			$dhl_packs = $this->elex_dhl_get_dhl_packages( $parcel );

			/* Handling insurance charges */
			if ( 'yes' === $this->settings['insure_contents_chk'] ) {
				/* on checkout page */
				if ( '' !== $str && ( strpos($http_referer, 'checkout') > 0 || is_checkout() )) {
					$parcel['dhl_insurance'] = isset($str['wf_dhl_insurance'])? 'yes': 'no';
				} elseif (is_cart() && $this->settings['insure_contents'] == 'yes' && isset($_POST['wf_dhl_insurance']) && $_POST['wf_dhl_insurance'] == 'yes') {
					$parcel['dhl_insurance'] = 'yes';
				} else {
					/* while creating order */
					$parcel['dhl_insurance'] = isset($_POST['wf_dhl_insurance'])? 'yes': 'no';
				}
			} elseif ( 'yes' === $this->settings['insure_contents'] ) {
				$parcel['dhl_insurance'] = 'yes';
			}

			/* Handling insurance charge on shop and cart pages */
			if (is_shop() || strpos($req_uri, '/cart') > 0) {
				if ($this->settings['insure_contents'] == 'yes' && isset($_POST['wf_dhl_insurance']) && $_POST['wf_dhl_insurance'] == 'yes') {
					update_option('wf_dhl_insurance', 'yes');
					$parcel['dhl_insurance'] = 'yes';
				} else {
					$parcel['dhl_insurance'] = 'no';
					update_option('wf_dhl_insurance', 'no');
				}
			}
			
			/* Handling insurance charge while adding items to cart */
			if (strpos($req_uri, 'add_to_cart') > 0) {
				if ($this->settings['insure_contents'] == 'yes' && isset($_POST['wf_dhl_insurance']) && $_POST['wf_dhl_insurance'] == 'yes') {
					update_option('wf_dhl_insurance', 'yes');
					$parcel['dhl_insurance'] = 'yes';
				} else {
					$parcel['dhl_insurance'] = 'no';
					update_option('wf_dhl_insurance', 'no');
				}  
			}
			//For Switzerland we have to send each package as seperate request
			if ( 'CH' === $packages['destination']['country'] && 'CH' === $this->settings['base_country'] ) {
				foreach ($dhl_packs as $key => $value) {
					$dhl_individual_pack 	   = array();
					$dhl_individual_pack[$key] = $value;
					$dhl_reqs       		   = $this->elex_dhl_get_dhl_requests( $dhl_individual_pack, $parcel, $value['InsuredValue']['Amount']);
					$dhl_requests[] 		   = $dhl_reqs;
				}
			} else {
				$dhl_reqs       = $this->elex_dhl_get_dhl_requests( $dhl_packs, $parcel );
				$dhl_requests[] = $dhl_reqs;
			}
			$dhl_insurance = isset($parcel['dhl_insurance']) && ( true === $parcel['dhl_insurance'] )? true : false;
			
		}
		if ($dhl_requests) {
			$this->elex_dhl_run_package_request($dhl_requests, $dhl_insurance);
		}


		// Ensure rates were found for all packages
		$packages_to_quote_count = count($dhl_requests);
		
		if ($this->found_rates) {
			foreach ($this->found_rates as $key => $value) {
				if ($value['packages'] < $packages_to_quote_count) {
					unset($this->found_rates[$key]);
				}
			}
		}
		// Rate conversion
		if ($this->conversion_rate) {
			foreach ($this->found_rates as $key => $rate) {
				$this->found_rates[$key]['cost'] = $rate['cost'] * $this->conversion_rate;
			}
		}

		/* Handling code for WooCommerce Multi-Currency */
		if ($this->is_woocommerce_multi_currency_installed) {
			foreach ($this->found_rates as $key => $rate) {
				$custom_currency_data 			 = $this->elex_dhl_get_exchange_rate_multicurrency_woocommerce();
				$this->found_rates[$key]['cost'] = $rate['cost'] * $custom_currency_data['exchange_rate'];
			}
		}


		$this->elex_dhl_add_found_rates();
	}

	/**
	*   Function to obtain exchange/conversion rate for the selected currency when WooCommerce multi currency is installed
	*
	*   @Access public
	*   @param selected currency string
	*   @return array conversion rate, currency symbol
	*/
	public function elex_dhl_get_exchange_rate_multicurrency_woocommerce( $selected_currency = '') {
		$exchange_rate   = 1;
		$currency_symbol = get_woocommerce_currency_symbol();
		if (class_exists('WOOMC\MultiCurrency\Rate\Storage')) {
			$Storage 	  = 'WOOMC\MultiCurrency\Rate\Storage';
			$rate_storage = new $Storage();

			$Detector 		   = 'WOOMC\MultiCurrency\Currency\Detector';
			$currency_detector = new $Detector();
			$currency_detector->setup_hooks();

			$Rounder 	   = 'WOOMC\MultiCurrency\Price\Rounder';
			$price_rounder = new $Rounder();

			$Calculator 	 = 'WOOMC\MultiCurrency\Price\Calculator';
			$price_calcultor = new $Calculator( $rate_storage, $price_rounder );

			$WP 	= 'WOOMC\MultiCurrency\DAO\WP';
			$obj_wp = new $WP();

			if (empty($selected_currency)) {
				$selected_currency = $currency_detector->currency();
			}

			$custom_currency_symbol = $obj_wp->getCustomCurrencySymbol($selected_currency);

			$default_currency = $currency_detector->getDefaultCurrency();

			$exchange_rate = $rate_storage->get_rate($selected_currency, $default_currency);
		}

		return array(
			'exchange_rate' => $exchange_rate,
			'currency_symbol' => $custom_currency_symbol
		);
	}
	
	public function elex_dhl_get_dhl_packages( $package) {
		return $this->elex_dhl_per_item_shipping($package);		
	}



	private function elex_dhl_per_item_shipping( $package ) {
		$to_ship  = array();
		$group_id = 1;

	
		// Get weight of order
		foreach ($package['contents'] as $item_id => $values) {
			$skip_product = apply_filters('wf_shipping_skip_product_from_dhl_rate', false, $values, $package['contents']);
			if ($skip_product) {
				continue;
			}

			if (!$values['data']->needs_shipping()) {
				$this->debug(sprintf(esc_html__('Product # is virtual. Skipping.', 'wf-shipping-dhl'), $item_id), 'error');
				continue;
			}

			if (!$values['data']->get_weight()) {
				/* translators: %s: search term */
				$this->debug(sprintf(esc_html__('Product %s is missing weight. Aborting.', 'wf-shipping-dhl'), $values['data']->get_name()), 'error');
				return;
			}

			if (!isset($values['quantity'])) {
				$values['quantity'] = 1;
			}

			$group           = array();
			$insurance_array = array(
				'Amount' => round($values['data']->get_price()),
				'Currency' => get_woocommerce_currency()
			);

			$xa_per_item_weight = $values['data']->get_weight();

			if ($this->site_weight_unit !== $this->weight_unit) {
				$xa_per_item_weight = wc_get_weight($xa_per_item_weight, $this->weight_unit, $this->site_weight_unit);
			}

			if ($xa_per_item_weight < 0.001) {
				$xa_per_item_weight = 0.001;
			}

			$group = array(
				'GroupNumber' => $group_id,
				'GroupPackageCount' => 1,
				'Weight' => array(
					'Value' => round($xa_per_item_weight, 3),
					'Units' => $this->weight_unit
				),
				'packed_products' => array($values['data'])
			);
			
			if ( elex_dhl_get_product_length( $values['data'] ) && elex_dhl_get_product_height( $values['data'] ) && elex_dhl_get_product_width( $values['data'] )) {

				$dimensions = array( elex_dhl_get_product_length( $values['data'] ), elex_dhl_get_product_width( $values['data'] ), elex_dhl_get_product_height( $values['data'] ));

				sort($dimensions);

				if ($this->site_dimensional_unit !== $this->dimension_unit) {
					foreach ($dimensions as $index => $dimension) {
						$dimensions[$index] = wc_get_dimension($dimension, $this->dimension_unit, $this->site_dimensional_unit);
					}
				}

				$group['Dimensions'] = array(
					'Length' => $dimensions[2],
					'Width' => $dimensions[1],
					'Height' => $dimensions[0],
					'Units' => $this->dimension_unit
				);
			}
			$group['packtype'] 	   = isset($this->settings['shp_pack_type'])?$this->settings['shp_pack_type'] : 'BOX';
			$group['InsuredValue'] = $insurance_array;

			for ($i = 0; $i < $values['quantity']; $i++) {
				$to_ship[] = $group;
			}

			$group_id++;
		}

		return $to_ship;
	}
	public function elex_dhl_run_package_request( $requests, $dhl_insurance) {
		try {
			foreach ( $requests as $key => $request ) {
				$this->elex_dhl_process_result($this->elex_dhl_get_result($request), $request, $dhl_insurance);
			}            
		} catch (Exception $e) {
			$this->debug(print_r($e, true), 'error');
			return false;
		}
	}

	private function elex_dhl_get_result( $request) {

		$this->debug('DHL REQUEST: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#3d9cd2;border:1px solid #DDD;padding:5px;color:white">' . print_r(htmlspecialchars($request), true) . '</pre>');   
		$result = wp_remote_post($this->service_url, array(
			'method' => 'POST',
			'timeout' => 70,
			'sslverify' => 0,
			'body' => $request
		));

		wc_enqueue_js("
            jQuery('a.debug_reveal').on('click', function(){
                jQuery(this).closest('div').find('.debug_info').slideDown();
                jQuery(this).remove();
                return false;
            });
            jQuery('pre.debug_info').hide();
        ");

		if ( is_wp_error( $result ) ) {
			$error_message = $result->get_error_message();
			$this->debug('DHL WP ERROR: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:red;border:1px solid #DDD;padding:5px;">' . print_r(htmlspecialchars($error_message), true) . '</pre>');
		} elseif (is_array($result) && !empty($result['body'])) {
			$result = $result['body'];
		} else {
			$result = '';
		}

		if (!empty($result) && is_string($result)) {
			$this->debug('DHL RESPONSE: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#3d9cd2;border:1px solid #DDD;padding:5px;color:white">' . print_r(htmlspecialchars($result), true) . '</pre>');
		}

		libxml_use_internal_errors(true);

		$xml = '';
		
		if (!empty($result) && is_string($result)) {
			$xml = simplexml_load_string(utf8_encode($result));
		}

		if ($xml) {
			return $xml;
		} else {
			return null;
		}
	}

	public function elex_dhl_get_dhl_base_currency() {
		$base_country 	    = $this->general_settings['base_country'];
		$currency_countries = array();
		$currency_countries = $this->elex_dhl_get_currency_countries();
		$base_currency 		= '';
		//Obtaining base country currency code for provided base country code
		foreach ($currency_countries as $currency=>$countries) {
			foreach ($countries as $country) {
				if ($country === $base_country) {
					$base_currency = $currency;
				}
			}
		}

		return $base_currency;
	}

	/**
	* Function to get currency based on the country code
	*
	* @Access public
	* @param string country_code
	* @return string currency
	*/
	public function elex_dhl_get_currency_based_on_country_code( $country_code) {
		$currency_countries = array();
		$currency_countries = $this->elex_dhl_get_currency_countries();
		$currency_code 		= '';
		//Obtaining currency code for provided country code
		foreach ($currency_countries as $currency=>$countries) {
			foreach ($countries as $country) {
				if ($country === $country_code) {
					$currency_code = $currency;
				}
			}
		}

		return $currency_code;
	}

	private function elex_dhl_get_cost_based_on_currency( $qtdsinadcur, $default_charge, $charge_type) {
		$base_currency = $this->elex_dhl_get_dhl_base_currency();
		
		if (!empty($qtdsinadcur)) {
			foreach ($qtdsinadcur as $multiple_currencies) {
				if ( 'shipping' === $charge_type ) {
					if (isset($multiple_currencies['CurrencyCode']) && (string) $multiple_currencies['CurrencyCode'] === $base_currency && !empty($multiple_currencies['TotalAmount']) && ( 0 !== $multiple_currencies['TotalAmount'] )) {
						return ( $this->exclude_dhl_tax ? $multiple_currencies['TotalAmount'] - $multiple_currencies['TotalTaxAmount'] : $multiple_currencies['TotalAmount'] );   
					}
				} else {
					if (isset($multiple_currencies['CurrencyCode']) && (string) $multiple_currencies['CurrencyCode'] === $base_currency && !empty($multiple_currencies['WeightCharge']) && ( 0 !== $multiple_currencies['WeightCharge'] )) {
						return ( $this->exclude_dhl_tax ? $multiple_currencies['WeightCharge'] - $multiple_currencies['WeightChargeTax'] : $multiple_currencies['WeightCharge'] );   
					}
				}
			}
		}
		return $default_charge;
	}

	private function elex_dhl_process_result( $result, $defined_req, $dhl_inurance) {
		
		$processed_ratecode = array();
		$rate_cost_weight   = '';
		$rate_local_code 	= '';
		
		$base_currency = $this->elex_dhl_get_dhl_base_currency();

		$response 		   = json_decode(wp_json_encode($result), true);
		$response_services = isset($response['GetQuoteResponse']['BkgDetails'])? $response['GetQuoteResponse']['BkgDetails']['QtdShp']: array();

		if (isset($response_services['GlobalProductCode'])) {
			$response_services_temp = $response_services;
			$response_services 	    = array();
			$response_services[0] 	= $response_services_temp;
		}
		
		if ($response && !empty($response_services)) {
			foreach ($response_services as $response_service) {
				$rate_code 	     = $response_service['GlobalProductCode'];
				$rate_local_code = isset($response_service['LocalProductCode']) ? $response_service['LocalProductCode'] : '';
				$extra_charges   = array();

				if (!in_array($rate_code, $processed_ratecode, true)) {
					$shipping_rates_source_currency = apply_filters('wf_dhl_shipping_rates_source_currency', get_woocommerce_currency(), $result, $this);
					if (isset($response_service['CurrencyCode']) && (string) $response_service['CurrencyCode'] === $shipping_rates_source_currency) {
						$this->conversion_rate = 1;

						$rate_cost 		  = $this->exclude_dhl_tax ? floatval((string) ( $response_service['ShippingCharge'] - $response_service['TotalTaxAmount'] )) : floatval((string) $response_service['ShippingCharge']);
						$rate_cost_weight = $this->exclude_dhl_tax ? floatval((string) ( $response_service['WeightCharge'] - $response_service['WeightChargeTax'] )) : floatval((string) $response_service['WeightCharge']);
						$extra_charges 	  = $this->elex_dhl_get_dhl_extra_charges($response_service);
					} else {
						$charge_type 	  = 'shipping';
						$rate_cost        = floatval((string) $this->elex_dhl_get_cost_based_on_currency($response_service['QtdSInAdCur'], $response_service['ShippingCharge'], $charge_type));
						$charge_type 	  = 'weight';
						$rate_cost_weight = floatval((string) $this->elex_dhl_get_cost_based_on_currency($response_service['QtdSInAdCur'], $response_service['WeightCharge'], $charge_type));
						$extra_charges 	  = $this->elex_dhl_get_dhl_extra_charges($response_service);
					}
					$extra_charges['insurance_charge'] 	    = isset($extra_charges['insurance_charge'])? $extra_charges['insurance_charge']: 0;
					$extra_charges['other_charges'] 	    = isset($extra_charges['other_charges'])? $extra_charges['other_charges']: 0;
					$extra_charges['remote_area_surcharge'] = isset($extra_charges['remote_area_surcharge'])? $extra_charges['remote_area_surcharge']: 0;

					$processed_ratecode[] = $rate_code;
					$rate_id 			  = $this->id . ':' . $rate_code . '|' . $rate_local_code;
					
					$delivery_time 		= new DateInterval($response_service['DeliveryTime']);
					$delivery_time 		= $delivery_time->format('%h:%I');
					$delivery_date_time = $response_service['DeliveryDate'] . ' ' . $delivery_time;
					$delivery_date_time = apply_filters('remove_estimated_delivery_time_express_dhl_elex', $delivery_date_time);
					$rate_name 			= strval( (string) $response_service['ProductShortName'] );
					if ($rate_cost > 0) {
						$this->elex_dhl_prepare_rate($rate_code, $rate_id, $rate_name, $rate_cost, $delivery_date_time, $rate_cost_weight, $extra_charges['insurance_charge'], $extra_charges['remote_area_surcharge'], $shipping_rates_source_currency, $extra_charges['other_charges']);
					}
				}
			}
		} elseif ($result && !empty($result->GetQuoteResponse->Note)) {
			foreach ($result->GetQuoteResponse->Note->Condition as $condition) {
				/* translators: %s: error term */
				$this->debug(sprintf(esc_html_e('DHL Error:  %s', 'wf-shipping-dhl'), htmlspecialchars($condition->ConditionData)), 'error');
				return;
			}
		}
	}

	private function elex_dhl_get_dhl_extra_charges( $response_service) {

		$extra_charges = array();
		if (isset($response_service['QtdShpExChrg'])) {
			$extra_shipping_charges = $response_service['QtdShpExChrg'];
			foreach ($extra_shipping_charges as $extra_shipping_charge) {
				if (isset($extra_shipping_charges['GlobalServiceName'])) {
					$extra_shipping_charge = $extra_shipping_charges;
				}
				if (isset($extra_shipping_charge['GlobalServiceName']) && isset($extra_shipping_charge['ChargeValue'])) {

					if ( 'REMOTE AREA DELIVERY' === $extra_shipping_charge['GlobalServiceName'] ) {
						$extra_charges['remote_area_surcharge'] = $this->exclude_dhl_tax ? $extra_shipping_charge['ChargeValue'] - $extra_shipping_charge['ChargeTaxAmount'] : $extra_shipping_charge['ChargeValue'];
					} elseif ( 'SHIPMENT INSURANCE' === $extra_shipping_charge['GlobalServiceName']   || 'SHIPMENT VALUE PROTECTION' === $extra_shipping_charge['GlobalServiceName'] ) {
						$extra_charges['insurance_charge'] = $this->exclude_dhl_tax ? $extra_shipping_charge['ChargeValue'] - $extra_shipping_charge['ChargeTaxAmount'] : $extra_shipping_charge['ChargeValue'];
					} else {
						if (isset($extra_charges['other_charges'])) {
							$extra_charges['other_charges'] += $this->exclude_dhl_tax ? $extra_shipping_charge['ChargeValue'] - $extra_shipping_charge['ChargeTaxAmount'] : $extra_shipping_charge['ChargeValue'];

						} else {
							$extra_charges['other_charges'] = $this->exclude_dhl_tax ? $extra_shipping_charge['ChargeValue'] - $extra_shipping_charge['ChargeTaxAmount'] : $extra_shipping_charge['ChargeValue'];
						}
					}
				}
				if (isset($extra_shipping_charges['GlobalServiceName'])) {
					break;
				}
			}
		}
		return $extra_charges;
	}

	private function elex_dhl_prepare_rate( $rate_code, $rate_id, $rate_name, $rate_cost, $delivery_time, $rate_cost_weight, $dhl_insurance, $dhl_remote_area_surcharge, $shipping_rates_source_currency, $other_charges) {

		// Name adjustment
		if (!empty($this->custom_services[$rate_code]['name'])) {
			$rate_name = $this->custom_services[$rate_code]['name'];
		}

		// Cost adjustment %
		if (!empty($this->custom_services[$rate_code]['adjustment_percent'])) {
			$rate_cost = $rate_cost + ( $rate_cost * ( floatval($this->custom_services[$rate_code]['adjustment_percent']) / 100 ) );
		}
		// Cost adjustment
		if (!empty($this->custom_services[$rate_code]['adjustment'])) {
			$rate_cost = $rate_cost + floatval($this->custom_services[$rate_code]['adjustment']);
		}

		// Enabled check
		if (isset($this->custom_services[$rate_code]) && empty($this->custom_services[$rate_code]['enabled'])) {
			return;
		}

		// Merging
		if (isset($this->found_rates[$rate_id])) {
			$rate_cost = $rate_cost + $this->found_rates[$rate_id]['cost'];
			$packages  = 1 + $this->found_rates[$rate_id]['packages'];
		} else {
			$packages = 1;
		}

		// Sort
		if (isset($this->custom_services[$rate_code]['order'])) {
			$sort = $this->custom_services[$rate_code]['order'];
		} else {
			$sort = 999;
		}
		
		$extra_charge_basic = $dhl_insurance + $dhl_remote_area_surcharge + $other_charges;

		if ($this->conversion_rate) {
			$extra_charge_basic 	   *= $this->conversion_rate;
			$rate_cost_weight 		   *= $this->conversion_rate;
			$dhl_insurance 			   *= $this->conversion_rate;
			$dhl_remote_area_surcharge *= $this->conversion_rate;
		}

		if (isset($this->found_rates[$rate_id])) {
			$extra_charge_basic 	   +=  $this->found_rates[$rate_id]['meta_data']['Extra Charge'] + ( isset($this->found_rates[$rate_id]['meta_data']['Insurance Charge']) ? $this->found_rates[$rate_id]['meta_data']['Insurance Charge'] : 0 );
			$rate_cost_weight 		   += $this->found_rates[$rate_id]['meta_data']['Weight Charge'];
			$dhl_insurance 			   += isset($this->found_rates[$rate_id]['meta_data']['Insurance Charge']) ? $this->found_rates[$rate_id]['meta_data']['Insurance Charge'] : 0;
			$dhl_remote_area_surcharge += isset($this->found_rates[$rate_id]['meta_data']['Remote Area Surcharge']) ? $this->found_rates[$rate_id]['meta_data']['Remote Area Surcharge'] : 0;
		}

		if ($this->aelia_activated) {
			$rate_cost_weight 	= apply_filters('wc_aelia_cs_convert', $rate_cost_weight, $this->shop_currency, get_woocommerce_currency());
			$extra_charge_basic = apply_filters('wc_aelia_cs_convert', $extra_charge_basic, $this->shop_currency, get_woocommerce_currency());
		}

		$shipping_service_meta_data = array('DHL Delivery Time'=>$delivery_time,'Weight Charge'=>floatval($rate_cost_weight),'Extra Charge'=>$extra_charge_basic);

		if (  'yes' === $this->general_settings['show_dhl_extra_charges'] &&  'yes' === $this->general_settings['insure_contents'] &&  'yes' === $this->general_settings['show_dhl_insurance_charges']) {
			$extra_charge 				= $extra_charge_basic - $dhl_insurance;
			$shipping_service_meta_data = array('DHL Delivery Time'=>$delivery_time,'Weight Charge'=>floatval($rate_cost_weight),'Insurance Charge'=>$dhl_insurance,'Extra Charge'=>$extra_charge);
		}

		if ( 'yes' === $this->general_settings['show_dhl_extra_charges']  && 'yes' === $this->general_settings['show_dhl_remote_area_surcharge'] ) {
			if (  'yes' === $this->general_settings['insure_contents']  &&  'yes' === $this->general_settings['show_dhl_insurance_charges'] ) {
				$extra_charge				= $extra_charge_basic - $dhl_insurance - $dhl_remote_area_surcharge;
				$shipping_service_meta_data = array('DHL Delivery Time'=>$delivery_time,'Weight Charge'=>floatval($rate_cost_weight),'Insurance Charge'=>$dhl_insurance,'Remote Area Surcharge'=>$dhl_remote_area_surcharge, 'Extra Charge'=>$extra_charge); 
			} else {
				$extra_charge 				= $extra_charge_basic - $dhl_remote_area_surcharge;
				$shipping_service_meta_data = array('DHL Delivery Time'=>$delivery_time,'Weight Charge'=>floatval($rate_cost_weight),'Remote Area Surcharge'=>$dhl_remote_area_surcharge, 'Extra Charge'=>$extra_charge); 
			}
		}

		try {
			$this->found_rates[$rate_id] = apply_filters('wf_dhl_shipping_found_rate' , array(
				'id' => $rate_id,
				'label' => $rate_name,
				'cost' => $rate_cost,
				'sort' => $sort,
				'packages' => $packages,
				'meta_data' => apply_filters('elex_dhl_hide_delivery_time', $shipping_service_meta_data)
			), $shipping_rates_source_currency, $this);
		} catch (Error $e) {
			if (is_plugin_active('woocommerce-aelia-currencyswitcher/woocommerce-aelia-currencyswitcher.php')) {
				$this->debug('Provide proper exchange rate');
			} else {
				$this->debug(print_r($e));
			}
		}
	}

	public function elex_dhl_add_found_rates() {
		if ($this->found_rates) {

			if ( 'all' === $this->offer_rates ) {

				uasort($this->found_rates, array($this, 'elex_dhl_sort_rates'));

				foreach ($this->found_rates as $key => $rate) {
					$this->add_rate($rate);
				}
			} else {
				$cheapest_rate = '';

				foreach ($this->found_rates as $key => $rate) {
					if (!$cheapest_rate || $cheapest_rate['cost'] > $rate['cost']) {
						$cheapest_rate = $rate;
					}
				}
				$cheapest_rate['meta_data']['Service Label'] = $cheapest_rate['label'];
				$cheapest_rate['label'] 					 = $this->title;
				$this->add_rate($cheapest_rate);
			}
		}
	}

	public function elex_dhl_sort_rates( $a, $b) {
		if ($a['sort'] === $b['sort']) {
			return 0;
		}
		return ( $a['sort'] < $b['sort'] ) ? -1 : 1;
	}
	private function elex_dhl_get_pack_type( $selected) {
			$pack_type = 'BOX';
		if (  'FLY' === $selected ) {
			$pack_type = 'FLY';
		} 
		return $pack_type;    
	}

}

