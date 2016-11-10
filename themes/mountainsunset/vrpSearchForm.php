<?php
/**
 * VRP Search Form Template
 *
 * @package VRPConnector
 * @since 1.3.0
 */

global $vrp; ?>

<div class="vrpgrid_3 alpha vrpsidebar">
	<div class="vrpgrid_100  resultsfound2">
		<h2>Search Availability</h2>
	</div>

	<form action="<?php bloginfo( 'url' ); ?>/vrp/search/results/" method="get">
		<table>
			<tr>
				<th>Check In:</th>
				<td>
					<input type="text" class="vrpArrivalDate input" name="search[arrival]"
						   value="<?php echo esc_attr( $vrp->search->arrival ); ?>">
				</td>
			</tr>
			<tr>
				<th>Check Out:</th>
				<td><input type="text" class="vrpDepartureDate input" name="search[departure]"
						   value="<?php echo esc_attr( $vrp->search->depart ); ?>"></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="propSearch" class="ButtonView rounded" value="Search">
				</td>
			</tr>
		</table>
	</form>

</div>
