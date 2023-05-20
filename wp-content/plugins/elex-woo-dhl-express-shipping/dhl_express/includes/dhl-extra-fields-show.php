<?php 
if (!class_exists('Elex_Dhl_Extra_Meta_Fields_Class')) {
	class Elex_Dhl_Extra_Meta_Fields_Class {
	
		public function __construct() {
			$this->settings 		= get_option( 'woocommerce_' . ELEX_DHL_ID . '_settings', null );
			$delivery_time 			= false;
			$show_dhl_extra_charges = '';
			if (!empty($this->settings) && isset($this->settings)) {
				$show_dhl_extra_charges = isset($this->settings['show_dhl_extra_charges']) ? $this->settings['show_dhl_extra_charges'] : '' ;
				$del_bool         		=  isset($this->settings['delivery_time']) ? $this->settings['delivery_time'] : 'no' ;
				$delivery_time 			= ( 'yes' === $del_bool ) ? true : false;

			}
			if (!empty($show_dhl_extra_charges) && 'yes' === $show_dhl_extra_charges ) {
				add_filter( 'woocommerce_cart_shipping_method_full_label', array($this, 'elex_dhl_add_extra_charges'), 10, 2 );
			}
			
			// Disply estimate delivery time
			if ($delivery_time) {
				add_filter( 'woocommerce_cart_shipping_method_full_label', array($this, 'elex_add_delivery_time'), 10, 2 );
			}
			
		
				
			$this->insurance_content 	 = isset($this->settings['insure_contents']) ? $this->settings['insure_contents'] : '' ;
			$this->insurance_content_chk = isset($this->settings['insure_contents_chk']) ? $this->settings['insure_contents_chk'] : '' ;

			add_filter( 'woocommerce_checkout_fields' , array($this, 'elex_dhl_custom_override_checkout_fields') );
				
			add_filter( 'woocommerce_cart_shipping_packages', array( $this, 'elex_dhl_woocommerce_cart_shipping_packages' ));
		}
			
		public function elex_dhl_woocommerce_cart_shipping_packages( $shipping = array()) {
			$this->destination_country = $shipping[0]['destination']['country'];
			foreach ($shipping as $key=>$val) {
				$str = '';
				
				if ( isset( $_POST['post_data'] ) ? wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['post_data'] ) ) ) : '' ) {
					parse_str( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['post_data'] ) ) ), $str );
				}
				
				if (isset($str['wf_dhl_insurance'])) {
					$shipping[$key]['wf_dhl_insurance'] = true;
				} elseif (!empty($this->insurance_content) && 'yes' === $this->insurance_content  && !empty($this->insurance_content_chk) && 'yes' === $this->insurance_content_chk ) {
					$shipping[$key]['wf_dhl_insurance'] = false;
				} elseif (!empty($this->insurance_content) && 'yes' === $this->insurance_content ) {
					$shipping[$key]['wf_dhl_insurance'] = true;
				} else {
					$shipping[$key]['wf_dhl_insurance'] = false;
				}
					
				if (isset($_POST['wf_dhl_insurance'])) {
					$shipping[$key]['wf_dhl_insurance'] = true;
				}

				$shipping[$key]['wf_dhl_delivery_signature'] = isset($str['wf_dhl_delivery_signature'])? true: false;
			}
			return $shipping;
		}
			
		public function elex_dhl_custom_override_checkout_fields( $fields ) {

			$insurance_specific_countries = isset($this->settings['elex_dhl_insurance_for_specific_countries'])? $this->settings['elex_dhl_insurance_for_specific_countries']: array();
			$show_insurance_checkbox 	  = false;

			if (!empty($insurance_specific_countries)) {
				if ( in_array( WC()->customer->get_shipping_country(), $insurance_specific_countries, true) ) {
					$show_insurance_checkbox = true;
				}                    
			} else {
				$show_insurance_checkbox = true;
			}
			$restrict_insurance_country = apply_filters( 'elex_dhl_restrict_insurance_countries', array() );
			if (in_array(WC()->customer->get_shipping_country(), $restrict_insurance_country , true )) {
					$show_insurance_checkbox = false;
			} 
			if (!empty($this->insurance_content) && 'yes' === $this->insurance_content  && !empty($this->insurance_content_chk) && 'yes' === $this->insurance_content_chk  && $show_insurance_checkbox) {
				// Adding custom checkout field for DHL Insurance
				$fields['billing']['wf_dhl_insurance'] = array(
					'label' => __('Enable DHL Shipping Insurance', 'wf-shipping-dhl'),
					'type'  => 'checkbox',
					'required' => 0,
					'default'   => false,
					'class' => array ( 'update_totals_on_change' )
				);
			}

			if (isset($this->settings['delivery_signature']) && 'yes' === $this->settings['delivery_signature'] ) {
				// Adding custom checkout field for DHL Signature on Delivery
				$fields['billing']['wf_dhl_delivery_signature'] = array(
					'label' => __('Enable DHL Signature on Delivery', 'wf-shipping-dhl'),
					'type'  => 'checkbox',
					'required' => 0,
					'default'   => true,
					'class' => array ( 'update_totals_on_change' )
				);
			}

			return $fields;
		}
			
		public function elex_add_delivery_time( $label, $method ) {
			if ( !is_object($method) ) {
				return $label;
			}
			$est_delivery = $method->get_meta_data();
			if ( isset($est_delivery['DHL Delivery Time']) ) {
				$est_delivery_html = '<br /><small>' . __('Est delivery: ', 'wf-shipping-dhl') . $est_delivery['DHL Delivery Time'] . '</small>';
				$est_delivery_html = apply_filters( 'wf_dhl_estimated_delivery', $est_delivery_html, $est_delivery );
				$label 			  .= $est_delivery_html;
			}
			return $label;
		}

		public function elex_dhl_add_extra_charges( $label, $method ) {
			if ( !is_object($method) ) {
				return $label;
			}

			$extra_charges 			= $method->get_meta_data();
			$tax_calculation_amount = 0;
			foreach ($method->taxes as $value) {
			   $tax_calculation_amount += $value;
			}

			if ( isset($extra_charges['Weight Charge']) ) {
				$tax_calculation_html = '';
				if ($tax_calculation_amount > 0) {
					$check_tax_type = get_option('woocommerce_tax_display_cart');
					if ('excl' !== $check_tax_type ) {
						$tax_calculation_html = '<small>+ ' . __('Taxes: ', 'wf-shipping-dhl') . wc_price($tax_calculation_amount) . '</small>';
					}
				}
				$obj 		   		= new Elex_Dhl_Woocoomerce_Shipping_Method();
				$string_append 		= $obj->exclude_dhl_tax ? '' : ' (Inc Tax,Ship,etc.)';
				$extra_charges_html = '<br /><small>' . __('Weight Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Weight Charge']) . ' + ' . __('DHL Handling Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Extra Charge']) . $string_append . ' </small>' . $tax_calculation_html;

				if (isset($extra_charges['Insurance Charge']) && 'yes' === $this->settings['show_dhl_insurance_charges'] ) {
					$extra_charges_html = '<br /><small>' . __('Weight Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Weight Charge']) . ' + ' . __('DHL Handling Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Extra Charge']) . $string_append . ' </small>' . $tax_calculation_html . ' + <small>' . __('DHL Insurance Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Insurance Charge']) . '</small>';
				}

				if (isset($extra_charges['Remote Area Surcharge']) && 'yes' === $this->settings['show_dhl_remote_area_surcharge'] ) {
					if ( 'yes' === $this->settings['show_dhl_insurance_charges']  && isset($extra_charges['Insurance Charge'])) {
						$extra_charges_html = '<br /><small>' . __('Weight Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Weight Charge']) . ' + ' . __('DHL Handling Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Extra Charge']) . $string_append . ' </small>' . $tax_calculation_html . ' + <small>' . __('DHL Insurance Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Insurance Charge']) . '</small> + <small>' . __('DHL Remote Area Surcharge: ', 'wf-shipping-dhl') . wc_price($extra_charges['Remote Area Surcharge']) . '</small>';
					} else {
						$extra_charges_html = '<br /><small>' . __('Weight Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Weight Charge']) . ' + ' . __('DHL Handling Charges: ', 'wf-shipping-dhl') . wc_price($extra_charges['Extra Charge']) . $string_append . ' </small>' . $tax_calculation_html . ' +  <small>' . __('DHL Remote Area Surcharge: ', 'wf-shipping-dhl') . wc_price($extra_charges['Remote Area Surcharge']) . '</small>';
					}

				}

				$label .= $extra_charges_html;
			}

			return $label;
		}
	}
}
	new Elex_Dhl_Extra_Meta_Fields_Class();
