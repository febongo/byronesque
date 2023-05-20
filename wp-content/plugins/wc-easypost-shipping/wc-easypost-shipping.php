<?php
/**
 * Plugin Name: Multi-Carrier EasyPost Shipping Methods & Address Validation for WooCommerce
 * Plugin URI: https://wordpress.org/plugins/wc-easypost-shipping/
 * Description: Adds EasyPost shippping methods to Woocommerce.
 * Version: 1.6.9
 * Tested up to: 6.2
 * Requires PHP: 7.3
 * WC requires at least: 6.0
 * WC tested up to: 7.4
 * Author: OneTeamSoftware
 * Author URI: http://oneteamsoftware.com/
 * Developer: OneTeamSoftware
 * Developer URI: http://oneteamsoftware.com/
 * Text Domain: wc-easypost-shipping
 * Domain Path: /languages
 *
 * Copyright: © 2023 FlexRC, Canada.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace OneTeamSoftware\WooCommerce\Shipping;

defined('ABSPATH') || exit;

require_once(__DIR__ . '/includes/autoloader.php');
	
(new Plugin(
		__FILE__, 
		'EasyPost', 
		sprintf('<div class="notice notice-info inline"><p>%s<br/><li><a href="%s" target="_blank">%s</a><br/><li><a href="%s" target="_blank">%s</a></p></div>', 
			__('Real-time EasyPost live shipping rates', 'wc-easypost-shipping'),
			'https://1teamsoftware.com/contact-us/',
			__('Do you have any questions or requests?', 'wc-easypost-shipping'),
			'https://wordpress.org/plugins/wc-easypost-shipping/', 
			__('Do you like our plugin and can recommend to others?', 'wc-easypost-shipping')),
		'1.6.9'
	)
)->register();
