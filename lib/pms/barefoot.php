<?php
/**
 * Barefoot Property Management Software Support.
 *
 * @package VRPConnector
 */

namespace Gueststream\PMS;

use Gueststream\VRPConnector;

/**
 * Class Barefoot
 *
 * @package VRPConnector
 */
class Barefoot {

	/**
	 * VRP API Client.
	 *
	 * @var \Gueststream\VRPConnector;
	 */
	private $vrp_client;

	/**
	 * Barefoot constructor.
	 *
	 * @param VRPConnector $vrp_client VRP API Client.
	 */
	public function __construct( VRPConnector $vrp_client ) {
		$this->vrp_client = $vrp_client;
		// Set WordPress Hooks.
		$this->set_hooks();
	}

	/**
	 * Add WordPress Hooks.
	 */
	private function set_hooks() {
		// Ajax hooks.
		add_action( 'wp_ajax_nopriv_vrp_barefoot_update_quote_addons', [ $this, 'update_quote_addons' ] );
	}

	/**
	 * Update Quote Add-ons
	 *
	 * Ajax Request performed on the booking page when the user selects or deselects an optional booking add-on.
	 */
	public function update_quote_addons() {
		check_ajax_referer( 'vrp-xsrf-prevention', 'nonce' );

		// Lease ID generated during booking/checkout.
		$lease_id = intval( $_POST['lease_id'] );

		// Selected addons.
		$selected_addons = [];
		if ( isset( $_POST['selected_addons'] ) && is_array( $_POST['selected_addons'] ) ) {
			foreach ( $_POST['selected_addons'] as $selected_addon ) {
				array_push( $selected_addons, intval( $selected_addon ) );
			}
		}

		// un-selected (waived) addons.
		$waived_addons = [];
		if ( isset( $_POST['waived_addons'] ) && is_array( $_POST['waived_addons'] ) ) {
			foreach ( $_POST['waived_addons'] as $waived_addon ) {
				array_push( $waived_addons, intval( $waived_addon ) );
			}
		}

		$params = [
			'leaseId'        => $lease_id,
			'selectedAddons' => $selected_addons,
			'waivedAddons'    => $waived_addons,
		];

		$response_json = $this->vrp_client->call(
			'customAction/barefoot/updateQuoteAddons',
			'obj=' . wp_json_encode( $params )
		);

		$response = json_decode( $response_json );

		wp_send_json( $response );

		die();
	}
}
