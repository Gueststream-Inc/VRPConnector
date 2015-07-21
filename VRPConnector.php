<?php
/**
 * Plugin Name: VRPConnector
 * Plugin URI: http://www.gueststream.com/apps-and-tools/vrpconnector/ 
 * Description: Vacation Rental Platform Connector.
 * Author: GuestStream, Inc.
 * Version: 1.0.4
 * Author URI: http://www.gueststream.com/ 
 */

if ( !isset( $_SESSION ) ) {
	@session_start();
}
/** Constants needed throughout plugin: * */
define( 'VRP_URL', plugin_dir_url( __FILE__ ) );
define( 'VRP_PATH', dirname( __FILE__ ) . '/' );

require __DIR__ . "/vendor/autoload.php";

if(version_compare(phpversion(), '5.4.0', '<'))
{
    function vrp_phpold()
    {
        printf('<div class="error"><p>' . __('Your PHP version is too old, please upgrade to a newer version. Your version is %1$s, VRPConnector requires %2$s', 'breadcrumb-navxt') . '</p></div>', phpversion(), '5.4.0');
    }

    if(is_admin())
    {
        add_action('admin_notices', 'vrp_phpold');
    }
    return;
}

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
