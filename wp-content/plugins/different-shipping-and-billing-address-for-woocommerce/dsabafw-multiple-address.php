<?php
/**
* Plugin Name: Different Shipping And Billing Address For Woocommerce
* Description: This plugin allows create Different Shipping And Billing Address For Woocommerce plugin.
* Version: 1.0
* Copyright: 2023
* Text Domain: different-shipping-and-billing-address-for-woocommerce
* Domain Path: /languages
*/


if (!defined('ABSPATH')) {
  die('-1');
}

// Define Plugin File
if (!defined('DSABAFW_PLUGIN_FILE')) {
  define('DSABAFW_PLUGIN_FILE', __FILE__);
}

// Define Plugin Dir
if (!defined('DSABAFW_PLUGIN_DIR')) {
define('DSABAFW_PLUGIN_DIR',plugins_url('', __FILE__));
}

// Define Plugin Base Name
if (!defined('DSABAFW_BASE_NAME')) {
define('DSABAFW_BASE_NAME', plugin_basename(DSABAFW_PLUGIN_FILE));
}

// Include Plugins File
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Include Files
include_once('main/backend/dsabafw-comman.php');
include_once('main/backend/dsabafw-backend.php');
include_once('main/frontend/dsabafw-front.php');
include_once('main/resources/dsabafw-installation-require.php');
include_once('main/resources/dsabafw-language.php');
include_once('main/resources/dsabafw-load-js-css.php');

function DSABAFW_append_support_and_faq_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
  
  if ( strpos( $plugin_file_name, basename(__FILE__) ) ) {

    // You can still use `array_unshift()` to add links at the beginning.
    $links_array[] = '<a href="https://www.plugin999.com/support/">'. __('Support', 'different-shipping-and-billing-address-for-woocommerce') .'</a>';
    $links_array[] = '<a href="https://wordpress.org/support/plugin/different-shipping-and-billing-address-for-woocommerce/reviews/?filter=5">'. __('Rate the plugin ★★★★★', 'different-shipping-and-billing-address-for-woocommerce') .'</a>';
  }
 
  return $links_array;
}
add_filter( 'plugin_row_meta', 'DSABAFW_append_support_and_faq_links', 10, 4 );