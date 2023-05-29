<?php
/**
 * Plugin Name: EasyPost Shipping PRO for WooCommerce
 * Plugin URI: https://1teamsoftware.com/product/woocommerce-easypost-shipping-pro/
 * Description: Displays live shipping rates at cart / checkout pages, streamlines returns, validates shipping address and simplifies creation of shipping labels with automated email tracking notifications.
 * Version: 2.1.7
 * Requires at least: 5.6
 * Tested up to: 6.2
 * Requires PHP: 7.3
 * WC requires at least: 6.0
 * WC tested up to: 7.6
 * Author: OneTeamSoftware
 * Author URI: http://oneteamsoftware.com/
 * Developer: OneTeamSoftware
 * Developer URI: http://oneteamsoftware.com/
 * Text Domain: wc-easypost-shipping
 * Domain Path: /languages
 *
 * Copyright: © 2023 FlexRC, Canada.
 */

/*********************************************************************/
/*  PROGRAM          FlexRC                                          */
/*  PROPERTY         3-7170 Ash Cres                                 */
/*  OF               Vancouver BC   V6P 3K7                          */
/*  				 Voice 604 800-7879                              */
/*                                                                   */
/*  Any usage / copying / extension or modification without          */
/*  prior authorization is prohibited                                */
/*********************************************************************/

namespace OneTeamSoftware\WC\Shipping;

defined('ABSPATH') || exit;

if (file_exists(__DIR__ . '/includes/autoloader.php')) {
	include_once(__DIR__ . '/includes/autoloader.php');
} else if (file_exists('phar://' . __DIR__ . '/includes.phar/autoloader.php')) {
	include_once('phar://' . __DIR__ . '/includes.phar/autoloader.php');
}

if (class_exists(__NAMESPACE__ . '\\PluginPro')) {
	include_once(__DIR__ . '/vendor/autoload.php');
	
	(new PluginPro(
			__FILE__, 
			'EasyPost', 
			sprintf('<div class="oneteamsoftware notice notice-info inline"><p>%s<br/><li><a href="%s" target="_blank">%s</a><br/><li><a href="%s" target="_blank">%s</a></p></div>', 
				__('Real-time EasyPost shipping rates, shipping label creation and tracking of the shipments', 'wc-easypost-shipping'),
				'https://1teamsoftware.com/contact-us/',
				__('Do you have any questions or requests?', 'wc-easypost-shipping'),
				'https://1teamsoftware.com/product/woocommerce-easypost-shipping-pro/', 
				__('Do you like our plugin and can recommend to others?', 'wc-easypost-shipping')),
			'2.1.7',
			function() {
				class ShippingMethod_wc_easypost_shipping extends ShippingMethodPro {}
			}
		)
	)->register();
} else if (is_admin()) {
	add_action('admin_notices', function() {
		echo sprintf(
			'<div class="oneteamsoftware notice notice-error error"><p><strong>%s</strong> %s %s <a href="%s" target="_blank">%s</a> %s</p></div>', 
			__('EasyPost Shipping PRO', 'wc-easypost-shipping'),
			__('plugin can not be loaded.', 'wc-easypost-shipping'),
			__('Please contact', 'wc-easypost-shipping'),
			'https://1teamsoftware.com/contact-us/',
			__('1TeamSoftware support', 'wc-easypost-shipping'),
			__('for assistance.', 'wc-easypost-shipping')
		);
	});
}