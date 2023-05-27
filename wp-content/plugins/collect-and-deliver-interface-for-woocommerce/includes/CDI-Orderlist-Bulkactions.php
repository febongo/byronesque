<?PHP

/**
 * This file is part of the CDI - Collect and Deliver Interface plugin.
 * (c) Halyra
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/****************************************************************************************/
/* Add bulk CDI action in the WC orders listing (to add parcels in Gateway)             */
/****************************************************************************************/
class cdi_c_Orderlist_Bulkactions {
	public static function init() {
		add_action( 'admin_footer-edit.php', __CLASS__ . '::cdi_wcorderlist_bulk_action_declare' );
		add_action( 'load-edit.php', __CLASS__ . '::cdi_wcorderlist_bulk_action_exec' );
	}
	public static function cdi_wcorderlist_bulk_action_declare() {
		global $post_type;
		if ( $post_type == 'shop_order' ) {
			// Nothing more to do
		}
	}
	public static function cdi_wcorderlist_bulk_action_exec() {
		global $typenow;
		$post_type = $typenow;
		if ( $post_type == 'shop_order' ) {
			$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );
			$action = $wp_list_table->current_action();
			$allowed_actions = array( 'cdi_action_wcorderlist' );
			if ( ! in_array( $action, $allowed_actions ) ) {
				return;
			}
			check_admin_referer( 'bulk-posts' ); // security check
			if ( isset( $_REQUEST['post'] ) ) {
				$post_ids = array_map( 'intval', $_REQUEST['post'] );
			}
			if ( empty( $post_ids ) ) {
				return;
			}
			$nbcolis = 0;
			cdi_c_Gateway::cdi_c_Addgateway_open();
			foreach ( $post_ids as $post_id ) {
				cdi_c_Gateway::cdi_c_Addgateway_add( $post_id );
				$nbcolis++;
			}
			cdi_c_Gateway::cdi_c_Addgateway_close();
			if ( $nbcolis > 0 ) {
				$message = number_format_i18n( $nbcolis ) . ' parcels (from orders) added in Gateway.';
				update_option( 'cdi_o_notice_display', $message );
				$sendback = admin_url() . 'edit.php?post_type=shop_order';
				wp_redirect( $sendback );
				exit;
			}
		}
	}
}

