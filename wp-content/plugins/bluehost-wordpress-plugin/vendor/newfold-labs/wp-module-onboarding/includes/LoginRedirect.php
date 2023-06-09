<?php
namespace NewfoldLabs\WP\Module\Onboarding;

use DateTime;
use NewfoldLabs\WP\Module\Onboarding\Permissions;
use NewfoldLabs\WP\Module\Onboarding\Data\Options;

/**
 * Contains functionalities that redirect users to Onboarding on login to WordPress.
 */
class LoginRedirect {
	/**
	 * Handles the redirect to onboarding
	 *
	 * @param [type] $redirect The requested redirect URL.
	 * @param [type] $redirect_to The requested redirect URL via param.
	 * @param [type] $user The logged in user object.
	 * @return string
	 */
	public static function handle_redirect( $redirect, $redirect_to, $user ) {
		$redirect_option_name = Options::get_option_name( 'redirect' );
		if ( isset( $_GET[ $redirect_option_name ] )
		  && 'false' === $_GET[ $redirect_option_name ] ) {
			 self::disable_redirect();
		}

		$flow_exited    = false;
		$flow_completed = false;
		$flow_data      = \get_option( Options::get_option_name( 'flow' ), false );
		if ( ! empty( $flow_data ) ) {
			$flow_exited    = ( ! empty( $flow_data['hasExited'] ) );
			$flow_completed = ( ! empty( $flow_data['isComplete'] ) );
		}

		if ( \get_transient( Options::get_option_name( 'redirect_param' ) ) === '1'
		 || $flow_exited
		 || $flow_completed
		 ) {
			return $redirect;
		}

		$redirect_option = \get_option( $redirect_option_name, null );
		if ( empty( $redirect_option ) ) {
			$redirect_option = \update_option( $redirect_option_name, true );
		}
		$install_date      = new DateTime( \get_option( Options::get_option_name( 'install_date', false ), gmdate( 'M d, Y' ) ) );
		$current_date      = new DateTime( gmdate( 'M d, Y' ) );
		$interval          = $current_date->diff( $install_date );
		$interval_in_hours = ( $interval->days * 24 ) + $interval->h;

		if ( ! ( $redirect_option
		&& \get_option( Options::get_option_name( 'coming_soon', false ), 'true' ) === 'true'
		&& ( $interval_in_hours <= 72 ) ) ) {
			 return $redirect;
		}

		if ( self::is_administrator( $user ) ) {
			 return \admin_url( '/index.php?page=nfd-onboarding' );
		}

		return $redirect;
	}

	 /**
	  * Check if we have a valid user.
	  *
	  * @param \WP_User $user The WordPress user object.
	  *
	  * @return bool
	  */
	public static function is_user( $user ) {
		return $user && is_object( $user ) && is_a( $user, 'WP_User' );
	}

	/**
	 * Check if a user is an administrator.
	 *
	 * @param \WP_User $user WordPress user.
	 *
	 * @return bool
	 */
	public static function is_administrator( $user ) {
		return self::is_user( $user ) && $user->has_cap( Permissions::ADMIN );
	}

	/**
	 * Sets a transient that disables redirect to onboarding on login.
	 *
	 * @return void
	 */
	public static function disable_redirect() {
		  \set_transient( Options::get_option_name( 'redirect_param' ), '1', 30 );
	}

	/**
	 * Sets a transient that enables redirect to onboarding on login.
	 *
	 * @return void
	 */
	public static function enable_redirect() {
		  \set_transient( Options::get_option_name( 'redirect_param' ), '0', 30 );
	}

	/**
	 * Removes the onboarding login redirect action.
	 *
	 * @return bool
	 */
	public static function remove_handle_redirect_action() {
		 return \remove_action( 'login_redirect', array( __CLASS__, 'handle_redirect' ) );
	}
}
