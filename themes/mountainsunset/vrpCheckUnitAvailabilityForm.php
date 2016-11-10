<?php
/**
 * Template file for [vrpCheckUnitAvailabilityForm]
 *
 * @injected $data Unit Data
 */

?>

<div id="unit-data"
	 data-unit-id="<?php echo $data->id; ?>"
	 data-unit-slug="<?php echo $data->page_slug; ?>"
	 data-unit-address1="<?php echo $data->Address1; ?>"
	 data-unit-address2="<?php echo $data->Address2; ?>"
	 data-unit-city="<?php echo $data->City; ?>"
	 data-unit-state="<?php echo $data->State; ?>"
	 data-unit-zip="<?php echo $data->PostalCode; ?>"
	 data-unit-latitude="<?php echo $data->lat; ?>"
	 data-unit-longitude="<?php echo $data->long; ?>"
	 data-display-pageviews="<?php echo (isset( $data->pageViews )) ? 'true' : 'false'; ?>"

	 style="display:none;"
	></div>

<div id="checkavailbox">
	<h3>Book Your Stay!</h3><br>

	<div id="datespicked">
		Select your arrival and departure dates below to reserve this unit.<br><br>

		<form action="<?php echo esc_url( site_url( '/vrp/book/step3/', 'https' ) ); ?>"
		      method="get" id="bookingform">

			<table align="center" width="96%">
				<tr>
					<td width="40%">Arrival:</td>
					<td>
						<input type="text" id="check-availability-arrival-date"
						       name="obj[Arrival]"
						       class="input unitsearch"
						       value="<?php echo esc_attr( $_SESSION['arrival'] ); ?>">
					</td>
				</tr>
				<tr>
					<td>Departure:</td>
					<td>
						<input type="text" id="check-availability-departure-date"
						       name="obj[Departure]"
						       class="input unitsearch"
						       value="<?php echo esc_attr( $_SESSION['depart'] ); ?>">
					</td>
				</tr>

				<tr>
					<?php // Promo Codes work with Escapia/RNS/Barefoot & ISILink Powered Software ?>
					<td>Promo Code</td>
					<td>
						<input type="text" name="obj[PromoCode]" value=""
						       placeholder="Promo Code">
					</td>
				</tr>

				<tr>
					<td colspan="2" id="errormsg">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table id="ratebreakdown"></table>
					</td>
				</tr>

				<tr>
					<td>
						<input type="hidden" name="obj[PropID]" id="vrp-unit-id"
						       value="<?php echo $data->id; ?>">
						<input type="button"
						       value="Confirm Travel Dates"
						       class="bookingbutton vrp-btn"
						       id="checkbutton">
					</td>
					<td>
						<input type="submit" value="Book Now!"
						       id="booklink"
						       class="vrp-btn"
						       style="display:none;"/>
					</td>
				</tr>
			</table>

		</form>
	</div>
</div>
