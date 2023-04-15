<?php
/**
 * Plugin Name: WBW Currency Switcher for WooCommerce PRO
 * Description: WBW Currency Switcher for WooCommerce PRO version.
 * Plugin URI: https://woobewoo.com/
 * Author: woobewoo.com
 * Author URI: https://woobewoo.com/
 * Version: 1.7.3
 * WC requires at least: 3.4.0
 * WC tested up to: 7.3.0
 **/
	require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'wpUpdater.php');

	register_activation_hook(__FILE__, 'woocurrencyByWoobewooProActivateCallback');
    register_deactivation_hook(__FILE__, array('modInstallerWcu', 'deactivate'));
    register_uninstall_hook(__FILE__, array('modInstallerWcu', 'uninstall'));

	add_filter('pre_set_site_transient_update_plugins', 'checkForPluginUpdatewoocurrencyByWoobewooPro');
    add_filter('plugins_api', 'myPluginApiCallwoocurrencyByWoobewooPro', 10, 3);

	if(!function_exists('getProPlugCodeWcu')) {
		function getProPlugCodeWcu() {
			return 'woocurrency_by_woobewoo_pro';
		}
	}
	if(!function_exists('getProPlugDirWcu')) {
		function getProPlugDirWcu() {
			return basename(dirname(__FILE__));
		}
	}
	if(!function_exists('getProPlugFileWcu')) {
		function getProPlugFileWcu() {
			return basename(__FILE__);
		}
	}
	if(!defined('S_YOUR_SECRET_HASH_'. getProPlugCodeWcu()))
		define('S_YOUR_SECRET_HASH_'. getProPlugCodeWcu(), 'asfafjii2ffff2@fhfohffoofoh44fho4fo');

    if(!function_exists('checkForPluginUpdatewoocurrencyByWoobewooPro')) {
        function checkForPluginUpdatewoocurrencyByWoobewooPro($checkedData) {
            if(class_exists('wpUpdaterWcu')) {
                return wpUpdaterWcu::getInstance( getProPlugDirWcu(), getProPlugFileWcu(), getProPlugCodeWcu() )->checkForPluginUpdate($checkedData);
            }
			return $checkedData;
        }
    }
    if(!function_exists('myPluginApiCallwoocurrencyByWoobewooPro')) {
        function myPluginApiCallwoocurrencyByWoobewooPro($def, $action, $args) {
            if(class_exists('wpUpdaterWcu')) {
                return wpUpdaterWcu::getInstance( getProPlugDirWcu(), getProPlugFileWcu(), getProPlugCodeWcu() )->myPluginApiCall($def, $action, $args);
            }
			return $def;
        }
    }
	/**
	 * Check if there are base (free) version installed
	 */
	if(!function_exists('woocurrencyByWoobewooProActivateCallback')) {
		function woocurrencyByWoobewooProActivateCallback() {
			if(class_exists('frameWcu')) {
				$arguments = func_get_args();
				if (function_exists('is_multisite') && is_multisite()) {
					global $wpdb;
					// $orig_id = $wpdb->blogid;
					$blog_id = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
					foreach ($blog_id as $id) {
						if (switch_to_blog($id)) {
							call_user_func_array(array('modInstallerWcu', 'check'), $arguments);
							restore_current_blog();
						}
					}
					// restore_current_blog();
					// switch_to_blog($orig_id);
				} else {
					call_user_func_array(array('modInstallerWcu', 'check'), $arguments);
				}

			}
		}
	}
	add_action('admin_notices', 'woocurrencyByWoobewooProInstallBaseMsg');
	if(!function_exists('woocurrencyByWoobewooProInstallBaseMsg')) {
		function woocurrencyByWoobewooProInstallBaseMsg() {
			if(!get_option('wcu_full_installed') || !class_exists('frameWcu')) {
				$plugName = 'WooCurrency by Woobewoo';
				$plugWpUrl = 'https://wordpress.org/plugins/woo-currency/';
				$html = '<div class="error"><p><strong style="font-size: 15px;">
					Please install Free (Base) version of '. $plugName. ' plugin, you can get it <a target="_blank" href="'. $plugWpUrl. '">here</a> or use Wordpress plugins search functionality,
					activate it, then deactivate and activate again PRO version of '. $plugName. '.
					In this way you will have full and upgraded PRO version of '. $plugName. '.</strong></p></div>';
				echo $html;
			}
		}
	}
