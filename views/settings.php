<?php
/**
 * VRPConnector WP Admin Settings Template
 *
 * @package VRPConnector
 */

global $vrp;
$vrp_user = get_option( 'vrpUser' );
$vrp_pass = get_option( 'vrpPass' );
?>
	<div>
		<img src="<?php echo esc_url( plugins_url( '/images/vrpconnector-logo.png', __FILE__ ) ); ?>"
		     alt="VRP Connector Logo"/>
	</div>
<?php
if ( ! empty( $vrp_user ) && ! empty( $vrp_pass ) ) { ?>
	<h2>Vacation Rental Platform Access</h2>
	<?php
	echo '<div>';
	echo '<label for="vrploginbtn">Click the button below to access the VRP:</label><br/>';
	echo '<form action="http://www.gueststream.net/main/login/" method="post" id="VRPLOGIN" target="_blank">';
	echo '<input type="hidden" name="vrpUser" value="' . esc_attr( $vrp_user ) . '">';
	echo '<input type="hidden" name="vrpPass" value="' . esc_attr( $vrp_pass ) . '">';
	echo '<input id="vrploginbtn" class="button-primary" type="submit" value="LOGIN TO VRP" style="font-size:26px;font-weight:bold;padding: 0.5em 1em;line-height: 26px;/* vertical-align: top; */height: auto;margin-top: 0.5em;margin-bottom: 2em;">';
	echo '</form>';
	echo '</div>';
	echo '<hr>';
} ?>

	<h2>Vacation Rental Platform Connector Settings</h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'VRPConnector' ); ?>
		<?php if ( false === $vrp->api_key || '1533020d1121b9fea8c965cd2c978296' === $vrp->api_key ) : ?>
			<a href="https://secure.gueststream.com" target="_blank">
				<img width="25%" style="float:right"
				     src="<?php echo esc_url( plugins_url( '/images/free_30_day_trial.png', __FILE__ ) ); ?>"
				     alt="VRP Connector Trial"/>
			</a>
		<?php endif; ?>
		<?php do_settings_sections( 'VRPConnector' ); ?>
		<?php submit_button(); ?>
	</form>
	<hr>
	<b>Current Status:</b>

<?php

$data = $vrp->testAPI();

if ( ! isset( $data->Status ) ) {
	$data->Status = false;
}

switch ( $data->Status ) {
	case 'Online':
		echo "<span style='color:green;'>Online</span>";
		break;
	default:
		echo "<span style='color:red;'>Error</span>";
		break;
}
