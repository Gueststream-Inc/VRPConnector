<?php
/**
 * Plugin Name: VRPConnector
 * Plugin URI: http://www.gueststream.com/apps-and-tools/vrpconnector/ 
 * Description: Vacation Rental Platform Connector.
 * Author: GuestStream, Inc.
 * Version: 1.0.3
 * Author URI: http://www.gueststream.com/ 
 */

if ( !isset( $_SESSION ) ) {
	@session_start();
}
/** Constants needed throughout plugin: * */
define( 'VRP_URL', plugin_dir_url( __FILE__ ) );
define( 'VRP_PATH', dirname( __FILE__ ) . '/' );

require __DIR__ . "/vendor/autoload.php";

$vrp = new \Gueststream\VRPConnector;

//Activation:
register_activation_hook( __FILE__, 'vrp_flush_rewrites' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

/**
 * Flush rewrite rules upon activation/deactivation.
 */
function vrp_flush_rewrites() {
	\Gueststream\VRPConnector::rewrite_activate();
	flush_rewrite_rules();
}
