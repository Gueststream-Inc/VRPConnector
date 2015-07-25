<?php
/**
 * Created by PhpStorm.
 * User: houghtelin
 * Date: 7/22/15
 * Time: 12:03 PM
 */

require __DIR__ . "/vendor/autoload.php";

if (!isset($_SESSION)) {
    @session_start();
}

/** Constants needed throughout plugin: * */
define('VRP_URL', plugin_dir_url(__FILE__));
define('VRP_PATH', dirname(__FILE__) . '/');

$vrp = new \Gueststream\VRPConnector;


// back end
function custom_admin_scripts()
{
    wp_enqueue_script('vrp-bootstrap-js', plugins_url('vrpconnector/resources/bower/bootstrap/dist/js/bootstrap.min.js'), false, null, false);
    wp_enqueue_script('vrp-bootstrap-fix', plugins_url('vrpconnector/resources/js/bootstrap-fix.js'), false, null, false);
}
add_action('admin_enqueue_scripts',	'custom_admin_scripts' );

register_activation_hook(__FILE__, 'vrp_flush_rewrites');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');

/**
 * Flush rewrite rules upon activation/deactivation.
 */
function vrp_flush_rewrites()
{
    \Gueststream\VRPConnector::rewrite_activate();
    flush_rewrite_rules();
}