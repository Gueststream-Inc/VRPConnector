<?php
/**
 * Plugin Name: VRPConnector
 * Plugin URI: http://www.gueststream.com/apps-and-tools/vrpconnector/
 * Description: Vacation Rental Platform Connector.
 * Author: Gueststream
 * Version: 2.0.1
 * Author URI: http://www.gueststream.com/
 *
 * @package VRPConnector
 */

if ( version_compare( phpversion(), '5.4.0', '<' ) ) {
	/**
	 * Display Error stating PHP Version is too old. VRPConnector will not work with PHP versions prior to 5.4.0
	 */
	function vrp_phpold() {
		$old_php_ver_error_msg =
			'<div class="error"><p>' .
			__(
				'Your PHP version is too old, please upgrade to a newer version of PHP. Your PHP version is %1$s, <strong>VRPConnector</strong> requires %2$s',
				'vrpconnector'
			) .
			'</p></div>';

		printf( // WPCS: XSS OK.
			esc_html( $old_php_ver_error_msg ),
			phpversion(),
			'5.4.0'
		);
	}

	if ( is_admin() ) {
		add_action( 'admin_notices', 'vrp_phpold' );
	}

	return;
} else {
	require __DIR__ . '/loader.php';
}
