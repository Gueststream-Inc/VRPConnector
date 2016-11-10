<?php
/**
 * Created by PhpStorm.
 * User: houghtelin
 * Date: 7/22/15
 * Time: 12:03 PM
 */

require __DIR__ . '/vendor/autoload.php';

if ( ! isset( $_SESSION ) ) {
	@session_start();
}

/** Constants needed throughout plugin: * */
define( 'VRP_URL', plugin_dir_url( __FILE__ ) );
define( 'VRP_PATH', dirname( __FILE__ ) . '/' );

$vrp = new \Gueststream\VRPConnector;

register_activation_hook( __FILE__, 'vrp_flush_rewrites' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

/**
 * Flush rewrite rules upon activation/deactivation.
 */
function vrp_flush_rewrites() {
	\Gueststream\VRPConnector::rewrite_activate();
	flush_rewrite_rules();
}
