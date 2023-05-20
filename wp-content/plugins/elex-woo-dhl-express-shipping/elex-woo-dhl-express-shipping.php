<?php
/*
Plugin Name: ELEX WooCommerce DHL Express Shipping - Basic
Plugin URI: https://elextensions.com/plugin/woocommerce-dhl-express-ecommerce-paket-shipping-plugin-with-print-label/
Description: Integrates DHL with WooCommerce using DHL APIs. Displays Real-time shipping rates on the Cart and Checkout page.
Version: 2.2.8
WC requires at least: 2.6.0
WC tested up to: 7.5
Author: ELEXtensions
Author URI: https://elextensions.com/
Copyright: ELEXtensions.
Text Domain: wf-shipping-dhl
*/


	define('ELEX_DHL_SOFTWARE_VERSION', '4.0.8');

if (!defined('ELEX_DHL_ID')) {
	define('ELEX_DHL_ID', 'wf_dhl_shipping');
}
if (!defined('ELEX_DHL_ECOMMERCE_ID')) {
	define('ELEX_DHL_ECOMMERCE_ID', 'wf_dhl_ecommerce_shipping');
}
if (!defined('ELEX_DHL_PAKET_EXPRESS_ROOT_PATH')) {
	define('ELEX_DHL_PAKET_EXPRESS_ROOT_PATH', plugin_dir_path(__FILE__));
}


if (in_array('dhl-woocommerce-shipping/dhl-woocommerce-shipping.php', apply_filters('active_plugins', get_option('active_plugins')))) { 
	//plugin is 
	deactivate_plugins(basename(__FILE__));
	wp_die(esc_html__('Oops! You tried installing the premium version without deactivating and deleting the basic version. Kindly deactivate and delete DHL(Basic) Woocommerce Extension and then try again', 'wf-shipping-dhl'), '', array('back_link' => 1));
}

	// register_activation_hook(__FILE__, 'wf_merge_pre_activation');


	/**
	 * Check if WooCommerce is active
	 */
	require_once ABSPATH . '/wp-admin/includes/plugin.php';

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || ( is_multisite() && is_plugin_active_for_network('woocommerce/woocommerce.php') )) {

	include_once 'dhl-deprecated-functions.php';


	if (!function_exists('elex_dhl_get_settings_url')) {
		function elex_dhl_get_settings_url() {
			return version_compare(WC()->version, '2.1', '>=') ? 'wc-settings' : 'woocommerce_settings';
		}
	}

	if (!function_exists('elex_dhl_is_eu_country')) {
		function elex_dhl_is_eu_country( $sourcecode, $destinationcode) {
			$eu_countrycodes = array(
				'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE',
				'ES', 'FI', 'FR',  'GR', 'HR', 'HU', 'IE', 
				'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 
				'RO', 'SE', 'SI', 'SK'
			);
			return ( in_array($sourcecode, $eu_countrycodes, true) && in_array($destinationcode, $eu_countrycodes, true ) );
		}
	}

	if (!class_exists('Elex_Dhl_WooCommerce_Shipping_Setup')) {

		class Elex_Dhl_WooCommerce_Shipping_Setup {

			public function __construct() {
				//  add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'elex_dhl_plugin_action_links' ) );
				add_action('woocommerce_shipping_init', array($this, 'elex_dhl_wooCommerce_shipping_init'));
				add_filter('woocommerce_shipping_methods', array($this, 'ElexDhlWoocoomerceShippingMethods'));
				add_filter('admin_enqueue_scripts', array($this, 'elex_dhl_scripts'));
				// add_filter('admin_notices', array($this, 'elex_dhl_key_check'), 99);

				add_action('admin_footer', array($this, 'elex_dhl_add_bulk_action_links'), 10); //to add bulk option to orders page
				//Add Receiver EORI number
				add_action( 'woocommerce_checkout_fields' , array($this, 'elex_dhl_eori_checkout_fields') );
				 add_action( 'woocommerce_checkout_update_order_meta', array( $this ,'elex_dhl_eori_field'));
				 //Save EORI in Account Field
				 add_filter( 'woocommerce_edit_account_form' , array($this, 'elex_dhl_my_account_address_eori_number') );
				 add_action ('woocommerce_save_account_details' , array( $this , 'elex_dhl_save_account_details') , 12 , 1);

			
				include_once 'dhl_express/includes/dhl-extra-fields-show.php';
			}

			public function elex_dhl_key_check() {
				$activation_check = get_option('dhl_activation_status', 'no_key');
			
			}


			//Create EORI field at checkout 
			public function elex_dhl_eori_checkout_fields( $fields ) {
				 $general_settings = get_option('woocommerce_wf_dhl_shipping_settings');
				 $user_eori        = !empty( get_post_meta(get_current_user_id() , 'user_dhl_receiver_eori' , true) ) ? get_post_meta(get_current_user_id() , 'user_dhl_receiver_eori' , true) : '';
				 $user_vat         = !empty( get_post_meta(get_current_user_id() , 'user_dhl_receiver_vat', true ) ) ? get_post_meta(get_current_user_id() , 'user_dhl_receiver_vat', true ) : '';
				
				if ( isset( $general_settings['include_receiver_eori_vat_number'] ) && 'yes' === $general_settings['include_receiver_eori_vat_number']  ) {
					 $fields['billing']['dhl_receiver_eori'] = array(
						 'label' => 'EORI Number',
						 'type'  => 'text',
						 'required' => 0,
						 'default'   => $user_eori,
						 'class' => array ( 'update_totals_on_change' )
						 );

					 $fields['billing']['dhl_receiver_vat'] = array(
						 'label' => 'VAT Number',
						 'type'  => 'text',
						 'required' => 0,
						 'default'   => $user_vat,
						 'class' => array ( 'update_totals_on_change' )
						 );
				}

				 return $fields;
			}

			//Save the EORI checkOut field
			public function elex_dhl_eori_field( $order_id ) {
				$order = new WC_Order( $order_id );
				if (isset($_POST['elex_dhl_nonce']) && wp_verify_nonce(sanitize_text_field($_POST['elex_dhl_nonce']), 'elex_dhl_express')) {
					if (isset($_POST['dhl_receiver_eori'])) {
						$dhl_eori = sanitize_text_field($_POST['dhl_receiver_eori']);
						$dhl_vat  = isset($_POST['dhl_receiver_vat']) ? sanitize_text_field($_POST['dhl_receiver_vat']) : '' ;
						if (!empty($dhl_eori)) {
							update_post_meta(get_current_user_id(), 'user_dhl_receiver_eori', $dhl_eori);
							add_post_meta($order_id, 'elex_dhl_receiver_eori', $dhl_eori);
						} else {
							add_post_meta($order_id, 'elex_dhl_receiver_eori', '');
						}


						if (!empty($dhl_vat)) {
							update_post_meta(get_current_user_id(), 'user_dhl_receiver_vat', $dhl_vat);
							add_post_meta($order_id, 'elex_dhl_receiver_vat', $dhl_vat);
						} else {
							add_post_meta($order_id, 'elex_dhl_receiver_vat', '');
						}
					}
				}
			}
			//Function to create a field in My-Account Page
			public function elex_dhl_my_account_address_eori_number ( $address ) {
				$general_settings = get_option('woocommerce_wf_dhl_shipping_settings');

				if (isset($general_settings['include_receiver_eori_vat_number']) && 'yes' === $general_settings['include_receiver_eori_vat_number']) {
					$eori_text  = esc_html_e('EORI Number & ', 'wf-shipping-dhl');
					$vat_text   = esc_html_e('VAT Number (DHL)', 'wf-shipping-dhl');
					$label_eori = get_post_meta(get_current_user_id(), 'user_dhl_receiver_eori', true);
					$label_vat  = get_post_meta(get_current_user_id(), 'user_dhl_receiver_vat', true);
					esc_html( '<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					 
									 <label for="eori_number"> ' . $eori_text . ' </label>
									
										 
										 <input type="text" placeholder="Enter EORI Number" id="user_shipment_vat_number_dhl_elex" name="user_shipment_eori_number_dhl_elex" style="width: 100%" value=' . $label_eori . '> 
 
									 <label for="vat_number"> ' . $vat_text . ' </label>
									
										 
										 <input type="text" placeholder="Enter VAT Number" id="user_shipment_vat_number_dhl_elex" name="user_shipment_vat_number_dhl_elex" style="width: 100%" value=' . $label_vat . '> 
									 
								 </p>' ) ;
				}
			}

				//Save Eori in My-Account 
			public function elex_dhl_save_account_details ( $user_id ) {
				if (isset($_POST['elex_dhl_nonce']) && wp_verify_nonce(sanitize_text_field($_POST['elex_dhl_nonce']), 'elex_dhl_express')) {
					if (isset($_POST['user_shipment_eori_number_dhl_elex'])) {
						update_post_meta($user_id, 'user_dhl_receiver_eori', sanitize_text_field($_POST['user_shipment_eori_number_dhl_elex']));
					}
					if (isset($_POST['user_shipment_vat_number_dhl_elex'])) {
						update_post_meta($user_id, 'user_dhl_receiver_vat', sanitize_text_field($_POST['user_shipment_vat_number_dhl_elex']));
					}
				}
			}


			public function elex_dhl_add_bulk_action_links() {
				global $post_type;
				if ('shop_order' == $post_type) {
					$settings = get_option('woocommerce_' . ELEX_DHL_ID . '_settings', null);

				}
			}

		

			public function elex_dhl_scripts() {
				$page    = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
				$tab     = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';
				$section = isset( $_GET['section'] ) ? sanitize_text_field( wp_unslash( $_GET['section'] ) ) : '';
				$subtab  = isset( $_GET['subtab'] ) ? sanitize_text_field( wp_unslash( $_GET['subtab'] ) ) : '';
				if ( 'wc-settings' === $page && 'shipping' === $tab && 'wf_dhl_shipping' === $section && 'premium' === $subtab ) {
					wp_enqueue_style('wf-bootstrap', plugins_url( 'dhl-woocommerce-shipping-method\dhl_express\resources\css\bootstrap.css' ), false, true); 
				}
				wp_enqueue_style('dhl-style', plugins_url('/dhl_express/resources/css/wf_common_style.css', __FILE__), array(), '1');
				wp_enqueue_media();
			}

			public function elex_dhl_wooCommerce_shipping_init() {
				include_once 'dhl_express/includes/class-wf-dhl-woocommerce-shipping.php' ;
			}

			public function ElexDhlWoocoomerceShippingMethods( $methods) {
				$methods[] = 'Elex_Dhl_Woocoomerce_Shipping_Method';
				return $methods;
			}

		}
		new Elex_Dhl_WooCommerce_Shipping_Setup();
	}

	if (!class_exists('Elex_Dhl_Paket_WooCommerce_Shipping_Setup')) {
		class Elex_Dhl_Paket_WooCommerce_Shipping_Setup {

			public function __construct() {
				add_action('init', array($this, 'elex_dhl_load_plugin_textdomain'));

				add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'elex_dhl_plugin_action_links'));
			
			}

		

		

			public function elex_dhl_plugin_action_links( $links) {

				$expressUrl = '<a href="' . admin_url('admin.php?page=' . elex_dhl_get_settings_url() . '&tab=shipping&section=wf_dhl_shipping') . '">' . __('DHL Express', 'wf-shipping-dhl') . '</a>';		
				
				$ecommerceUrl = '<a href="' . admin_url('admin.php?page=' . elex_dhl_get_settings_url() . '&tab=shipping&section=wf_dhl_shipping') . '">' . __('DHL Ecommerce', 'wf-shipping-dhl') . '</a>';		

				$plugin_links = array(
					'<a href="' . admin_url( 'admin.php?page=' . elex_dhl_get_settings_url() . '&tab=shipping&section=wf_dhl_shipping' ) . '">' . __( 'Settings', 'wf_dhl_wooCommerce_shipping' ) . '</a>',
					'<a href="https://elextensions.com/plugin/woocommerce-dhl-express-ecommerce-paket-shipping-plugin-with-print-label/" target="_blank">' . __( 'Premium Upgrade', 'wf-shipping-canada-post' ) . '</a>',
					'<a href="https://elextensions.com/support/" target="_blank">' . __('Support', 'wf-shipping-dhl') . '</a>',
				);
				return array_merge($plugin_links, $links);
			}

		
			/**
			 * Handle localization
			 */
			public function elex_dhl_load_plugin_textdomain() {
				load_plugin_textdomain('wf-shipping-dhl', false, dirname(plugin_basename(__FILE__)) . '/i18n/');
			}
		}
		new Elex_Dhl_Paket_WooCommerce_Shipping_Setup();
	}

	if (!class_exists('Elex_DHL_Ecommerce_Shipping_Setup')) {
		class Elex_DHL_Ecommerce_Shipping_Setup {

			public function __construct() {
				//  add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'elex_dhl_plugin_action_links' ) );
				// add_action('woocommerce_shipping_init', array($this, 'elex_dhl_eCommerce_shipping_init'));
				// add_filter('woocommerce_shipping_methods', array($this, 'elex_dhl_eCommerce_shipping_methods'));

			}
	
			public function elex_dhl_eCommerce_shipping_init() {
				include_once 'dhl_eccommerce/includes/class-wf-dhl-woocommerce-shipping.php';
				

			}

			public function elex_dhl_eCommerce_shipping_methods( $methods) {
				$methods[] = 'Wf_Dhl_Ecommerce_Shipping_Method';
				return $methods;
			}

		}
		// new Elex_DHL_Ecommerce_Shipping_Setup();
	}
	// review component
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once  ABSPATH . 'wp-admin/includes/plugin.php';
	}
	include_once __DIR__ . '/review_and_troubleshoot_notify/review-and-troubleshoot-notify-class.php';
	$data                      = get_plugin_data( __FILE__ );
	$data['name']              = $data['Name'];
	$data['basename']          = plugin_basename( __FILE__ );
	$data['rating_url']        = 'https://elextensions.com/plugin/elex-woocommerce-dhl-express-ecommerce-paket-shipping-plugin-with-print-label-free-version/#reviews';
	$data['documentation_url'] = 'https://elextensions.com/knowledge-base/set-up-woocommerce-dhl-express-elex-woocommerce-dhl-express-ecommerce-paket-shipping-plugin-print-label/';
	$data['support_url']       = 'https://wordpress.org/support/plugin/elex-woo-dhl-express-shipping/';

	new \Elex_Review_Components( $data );

}
