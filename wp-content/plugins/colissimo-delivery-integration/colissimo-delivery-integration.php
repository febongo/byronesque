<?php
/*
 * Plugin Name: Colissimo Delivery Integration 
 * Description: Easy Colissimo Services with WooCommerce.
 * Version: 3.8.1
 * Author: Halyra
 *
 * Text Domain: colissimo-delivery-integration
 * Domain Path: /languages/
 *
 * Requires At Least: 5.2.0
 * Tested Up To: 6.2
 * WC requires at least: 3.6.5
 * WC tested up to: 7.5.1
 * Requires PHP: 7.0
 *
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * Copyright: (c) 2016  Halyra 
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 3, as 
 published by the Free Software Foundation.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
__( 'Colissimo Delivery Integration', 'colissimo-delivery-integration' ) ;
__( 'Easy Colissimo Services with WooCommerce.', 'colissimo-delivery-integration' ) ;

/**
 * This file is part of the Colissimo Delivery Integration plugin.
 * (c) Halyra
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!defined('ABSPATH')) exit;
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );


/**
 * Display admin notices
 */
function cdi_general_admin_notice(){
  $tokentimerswitchnewcdi = time() ;
  $oldtokentimerswitchnewcdi = get_option('cdi_tokentimerswitchnewcdi') ;
  if ($oldtokentimerswitchnewcdi && (($oldtokentimerswitchnewcdi + 600) > $tokentimerswitchnewcdi)) { // timer pour maj à 600s (10mn)
    return ;
  }
  update_option('cdi_tokentimerswitchnewcdi', $tokentimerswitchnewcdi) ;
  update_option('cdi_o_transferoldsettings', 'silent') ;
  echo '<div class="notice notice-error ">
             <h2>Bascule de votre plugin CDI <mark>Colissimo Delivery Integration</mark> vers <mark>Collect and Deliver Interface</mark>. </h2>
             <p>Le plugin <strong>CDI - Collect and Deliver Interface</strong>, remplace désormais votre plugin actuel pour plus de fonctionnalités et pour servir différents transporteurs. </p>
             <p>Vous devez installer et activer ici cette nouvelle version de <a href="' . home_url() . '/wp-admin/plugin-install.php?s=CDI&tab=search&type=term"><strong>CDI</strong> </a>.</p> 
             </div>' ;
}
add_action('admin_notices', 'cdi_general_admin_notice');


?>
