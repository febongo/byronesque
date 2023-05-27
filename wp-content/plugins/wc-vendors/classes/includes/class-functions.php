<?php

if ( ! class_exists( 'WCV_Dependencies' ) ) {
	require_once 'class-dependencies.php';
}

/**
 * WC Detection
 * */
if ( ! function_exists( 'wcv_is_woocommerce_activated' ) ) {
	/**
	 * Check if WooCommerce is activated
	 */
	function wcv_is_woocommerce_activated() {

		return WCV_Dependencies::woocommerce_active_check();
	}
}

/*
*
*  Get User Role
*/
if ( ! function_exists( 'wcv_get_user_role' ) ) {
	/**
	 * Get user roole from user id
	 *
	 * @param int $user_id User ID.
	 */
	function wcv_get_user_role( $user_id ) {

		global $wp_roles;
		$user  = new WP_User( $user_id );
		$roles = $user->roles;
		$role  = array_shift( $roles );

		return isset( $wp_roles->role_names[ $role ] ) ? $role : false;
	}
}


/**
 * This function gets the vendor name used throughout the interface on the front and backend
 *
 * @param boolean $singluar  Singluar or not.
 * @param boolean $upper_case Upper case or not.
 */
function wcv_get_vendor_name( $singluar = true, $upper_case = true ) {

	$vendor_singular = get_option( 'wcvendors_vendor_singular', __( 'Vendor', 'wc-vendors' ) );
	$vendor_plural   = get_option( 'wcvendors_vendor_plural', __( 'Vendors', 'wc-vendors' ) );

	$vendor_label = $singluar ? __( $vendor_singular, 'wc-vendors' ) : __( $vendor_plural, 'wc-vendors' );
	$vendor_label = $upper_case ? ucfirst( $vendor_label ) : lcfirst( $vendor_label );

	$vendor_label = apply_filters_deprecated( 'wcv_vendor_display_name', array( $vendor_label, $vendor_singular, $vendor_plural, $singluar, $upper_case ), '2.3.0', 'wcvendors_vendor_display_name' );
	return apply_filters( 'wcvendors_vendor_display_name', $vendor_label, $vendor_singular, $vendor_plural, $singluar, $upper_case );
}

/**
 * Output a single select page drop down.
 *
 * @param string $id    ID.
 * @param string $value Value.
 * @param string $class Class.
 * @param string $css   CSS.
 */
function wcv_single_select_page( $id, $value, $class = '', $css = '' ) {

	$dropdown_args = array(
		'name'             => $id,
		'id'               => $id,
		'sort_column'      => 'menu_order',
		'sort_order'       => 'ASC',
		'show_option_none' => ' ',
		'class'            => $class,
		'echo'             => false,
		'selected'         => $value,
	);

	echo str_replace( ' id=', " data-placeholder='" . esc_attr__( 'Select a page&hellip;', 'wc-vendors' ) . "' style='" . $css . "' class='" . $class . "' id=", wp_dropdown_pages( $dropdown_args ) );
}

/**
 * Get the WC Vendors Screen ids.
 *
 * @return array
 */
function wcv_get_screen_ids() {

	return apply_filters(
		'wcv_get_screen_ids',
        array(
			'wc-vendors_page_wcv-settings',
			'wc-vendors_page_wcv-commissions',
			'wc-vendors_page_wcv-extensions',
		)
	);
}

/**
 * Filterable navigation items classes for Vendor Dashboard.
 *
 * @param string $item_id Navigation item ID.
 *
 * @return string
 */
function wcv_get_dashboard_nav_item_classes( $item_id ) {

	$classes = array( 'button' );

	$classes = apply_filters_deprecated( 'wcv_dashboard_nav_item_classes', array( $classes, $item_id ), '2.3.0', 'wcvendors_dashboard_nav_item_classes' );
	$classes = apply_filters( 'wcvendors_dashboard_nav_item_classes', $classes, $item_id );

	return implode( ' ', array_map( 'sanitize_html_class', $classes ) );
}

if ( ! function_exists( 'wcv_vendor_drop_down_options' ) ) {
	/**
	 * Generate a drop down with the vendor name based on the Dsiplay name setting used in the admin
	 *
	 * @param array $users     Users.
	 * @param int   $vendor_id Vendor ID.
	 * @since 2.1.10
	 * @return string
	 */
	function wcv_vendor_drop_down_options( $users, $vendor_id ) {
		$output = '';
		foreach ( (array) $users as $user ) {
			$shop_name    = WCV_Vendors::get_vendor_sold_by( $user->ID );
			$display_name = empty( $shop_name ) ? $user->display_name : $shop_name;
			$select       = selected( $user->ID, $vendor_id, false );
			$output      .= "<option value='$user->ID' $select>$display_name</option>";
		}
		$output = apply_filters_deprecated( 'wcv_vendor_drop_down_options', array( $output ), '2.3.0', 'wcvendors_vendor_drop_down_options' );
		return apply_filters( 'wcvendors_vendor_drop_down_options', $output );
	}
}


/**
 * Set the primary role of the specified user to vendor while retaining all other roles after
 *
 * @param $user WP_User
 *
 * @since 2.1.10
 * @version 2.1.10
 */

if ( ! function_exists( 'wcv_set_primary_vendor_role' ) ) {
	/**
	 * Set primary role to vendor.
	 *
	 * @param WP_User|int $user The ID of the user or the user object.
	 * @param string      $role The role to set, default 'vendor'.
	 * @return void
	 * @version 2.4.7
	 * @since   2.4.7 - Added default role and allow ID or WP_User object.
	 */
	function wcv_set_primary_vendor_role( $user, $role = 'vendor' ) {
		if ( is_int( $user ) ) {
			$user = get_user_by( 'id', $user );
		}
		// Get existing roles.
		$existing_roles = $user->roles;
		// Remove all existing roles.
		foreach ( $existing_roles as $existing_role ) {
			$user->remove_role( $existing_role );
		}
		// Add default role/vendor first.
		$user->add_role( $role );
		unset( $existing_roles[ $role ] ); // Remove assigned role from existing roles. Avoid adding it to the end if it's already there.
		// Re-add all other roles.
		foreach ( $existing_roles as $existing_role ) {
			$user->add_role( $existing_role );
		}
	}
}

if ( ! function_exists( 'wcv_is_show_reversed_order' ) ) {

	/**
	 * Check show reversed order
	 *
	 * @since 2.4.0
	 * @return bool
	 */
	function wcv_is_show_reversed_order() {

		return wc_string_to_bool( get_option( 'wcvendors_dashboard_orders_show_reversed_orders', 'no' ) );
	}
}
