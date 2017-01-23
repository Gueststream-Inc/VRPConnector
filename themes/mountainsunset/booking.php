<?php
/**
 * Booking Template
 *
 * @package VRPConnector
 */

if ( isset( $data->Error ) ) {
	echo esc_html( $data->Error );
	echo "<br><br><a href='/'>Please try again.</a> ";
} elseif ( ! isset( $data->Charges ) ) {
	echo "We're sorry, this property is not available at for the dates requested. <a href='/'>Please try again.</a><br><br>";
} else {
	global $wp_query;
	$query = $wp_query;
	?>
	<div id="vrp">

	<div class="modal-header">
		<h3>Reservation Details</h3>
	</div>
	<div>

		<table class="table table-striped">
			<tr>
				<td><b>Property Name:</b></td>
				<td><b><?php echo esc_html( $data->Name ); ?></b></td>
			</tr>

			<tr>
				<td>Arrival:</td>
				<td><b><?php echo esc_html( $data->Arrival ); ?></b></td>
			</tr>
			<tr>
				<td>Departure:</td>
				<td><b><?php echo esc_html( $data->Departure ); ?></b></td>
			</tr>
			<tr>
				<td>Nights:</td>
				<td><b><?php echo esc_html( $data->Nights ); ?></b></td>
			</tr>
		</table>

		<table id="ratebreakdown" class="table table-striped">
			<?php
			if ( isset( $data->Charges ) ) :
				foreach ( $data->Charges as $v ) :
					?>
					<tr>
						<td><?php echo esc_html( $v->Description ); ?>:</td>
						<td><?php if ( isset( $v->Type ) && 'discount' === $v->Type ) {
								echo '-';
							} ?>$<?php echo esc_html( number_format( $v->Amount, 2 ) ); ?>
						</td>
					</tr>
					<?php
				endforeach;
			endif;
			?>

			<?php if ( isset( $data->booksettings->HasPackages ) ) { ?>
				<tr>
					<td>Add-on Package:</td>
					<td id="packageinfo">
						$<?php echo esc_html( number_format( $data->package->packagecost, 2 ) ); ?>
					</td>
				</tr>
			<?php } ?>
			<tr>
				<td>Tax:</td>
				<td>$<?php echo esc_html( number_format( $data->TotalTax, 2 ) ); ?></td>
			</tr>
			<tr>
				<td><b>Total Cost:</b></td>
				<td id="TotalCost">
					$<?php echo esc_html( number_format( $data->TotalCost - $data->InsuranceAmount, 2 ) ); ?>
				</td>
			</tr>
		</table>

		<?php if ( isset( $data->HasInsurance ) && $data->HasInsurance ) { ?>
			<h3>Optional Travel Insurance</h3>
			<table class="table table-striped">
				<tr>
					<td>Optional Travel Insurance:</td>
					<td>$<?php echo esc_html( number_format( $data->InsuranceAmount, 2 ) ); ?></td>
				</tr>
				<tr>
					<td><b>Reservation Total with Insurance:</b></td>
					<td>$<?php echo esc_html( number_format( $data->TotalCost, 2 ) ); ?></td>
				</tr>
			</table>
		<?php } ?>
	</div>

	<div class="alert alert-info" style='text-align:center'>
		You are booking <?php echo esc_html( $data->Name ); ?>
		for <?php echo esc_html( $data->Nights ); ?> nights
		for $<?php echo esc_html( $data->TotalCost ); ?>.

		<?php
		if ( $data->TotalCost !== $data->DueToday ) {
			echo 'A deposit of $<span id="vrp-booking-due-now">' . esc_html( number_format( $data->DueToday,
					2 ) ) . '</span> is due now.';
		}
		?>
	</div>

	<div class="">
		<?php
		if ( file_exists( get_stylesheet_directory() . $query->query_vars['slug'] . '.php' ) ) {
			include( get_stylesheet_directory() . $query->query_vars['slug'] . '.php' );
		} elseif ( file_exists( __DIR__ . '/' . $query->query_vars['slug'] . '.php' ) ) {
			include $query->query_vars['slug'] . '.php';
		} else {
			echo esc_html( $query->query_vars['slug'] . '.php does not exist.' );
		}
		?>
	</div>

	<div class="clear"></div>
	<?php
}
