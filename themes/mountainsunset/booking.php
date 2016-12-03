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
	<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		 aria-hidden="true">
		<div class="modal-header">
			<h3>Reservation Details</h3>
		</div>
		<div class="modal-body">
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
				<?php
				if ( isset( $data->Charges ) ) {
					foreach ( $data->Charges as $v ) :
						?>
						<tr>
							<td><?php echo esc_html( $v->Description ); ?>:</td>
							<td><?php if ( isset( $v->Type ) && $v->Type == 'discount' ) {
									echo '-';
} ?>$<?php echo esc_html( number_format( $v->Amount, 2 ) ); ?>
							</td>
						</tr>
					<?php
					endforeach;
				}
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
					<td><b>Reservation Total:</b></td>
					<td id="TotalCost">
						<?php
						$total_cost = 0;
						if ( isset( $data->package->TotalCost ) ) {
							$total_cost = $data->package->TotalCost - $data->InsuranceAmount;
						} else {
							$total_cost = $data->TotalCost - $data->InsuranceAmount;
						}
						?>
						$<?php echo esc_html( number_format( $total_cost, 2 ) ); ?>
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
						<?php
						$total_ins = 0;
						if ( isset( $data->package->TotalCost ) ) {
							$total_ins = $data->package->TotalCost;
						} else {
							$total_ins = $data->TotalCost;
						}
						?>
						<td>$<?php echo esc_html( number_format( $total_ins, 2 ) ); ?></td>
					</tr>
				</table>
			<?php } ?>
		</div>
	</div>
	<div class="alert alert-info" style='text-align:center'>
		You are booking <?php echo esc_html( $data->Name ); ?> for <?php echo esc_html( $data->Nights ); ?> nights for
		<a href="#myModal2" data-toggle="modal">
			<span id="TotalCost2">
				<?php if ( isset( $data->package ) && isset( $data->InsuranceAmount ) ) :
					$grand_total = 0;
					if ( isset( $data->package->TotalCost ) ) {
						$grand_total = $data->package->TotalCost - $data->InsuranceAmount;
					} else {
						$grand_total = $data->TotalCost - $data->InsuranceAmount;
					}
					?>
				$<?php echo esc_html( number_format( $grand_total, 2 ) ); ?>
			</span>
		</a>.
	<?php else : ?>
		$<?php echo esc_html( $data->TotalCost ); ?></span></a>.
	<?php
	endif;
	?>
		<?php
		if ( $data->TotalCost != $data->DueToday ) {
			echo 'A deposit of <a href="#myModal2">$' . esc_html( number_format( $data->DueToday, 2 ) ) . '</a> is due now.';
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
