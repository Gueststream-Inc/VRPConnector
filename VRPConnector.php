<?php
/**
 * Plugin Name: VRPConnector
 * Plugin URI: http://www.gueststream.com/apps-and-tools/vrpconnector/
 * Description: Vacation Rental Platform Connector.
 * Author: Gueststream
 * Version: 1.3.5
 * Author URI: http://www.gueststream.com/
 */

if ( version_compare( phpversion(), '5.4.0', '<' ) ) {
	function vrp_phpold() {
		printf( '<div class="error"><p>' . __( 'Your PHP version is too old, please upgrade to a newer version of PHP. Your PHP version is %1$s, <strong>VRPConnector</strong> requires %2$s', 'breadcrumb-navxt' ) . '</p></div>', phpversion(), '5.4.0' );
	}

	if ( is_admin() ) {
		add_action( 'admin_notices', 'vrp_phpold' );
	}

	return;
} else {
	require __DIR__ . '/loader.php';
}
