<?php
/**
 * View Favorites Template
 *
 * @package VRPConnector
 */

$favorites = wp_unslash( $_GET['favorites'] ); // Input var okay.
?>
<div id="vrp">
	<div align="center">
		<form id="compareprops" method="get" action="">
			<table align="center" cellspacing="10" cellpadding="20">
				<tr>
					<td>Arrival:</td>
					<td>
						<input type="text"
						       name="arrival"
						       class="input"
						       id="arrival2"
						       value="<?php echo esc_attr( $this->search->arrival ); ?>"/>
					</td>
				</tr>
				<tr>
					<td>Departure:</td>
					<td>
						<input type="text"
						       name="depart"
						       class="input"
						       id="depart2"
						       value="<?php echo esc_attr( $this->search->depart ); ?>"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php foreach ( $favorites as $unit_id ) { ?>
							<input type="hidden" name="favorites[]" value="<?php echo esc_attr( $unit_id ); ?>">
						<?php } ?>
						<input type="submit" class="vrp-btn vrp-btn-info" value="Check Availability">
					</td>
				</tr>
			</table>
		</form>
	</div>

	<table style="margin-top:50px;">
		<thead>
		<tr>
			<th>Property</th>
			<th>Beds</th>
			<th>Baths</th>
			<th>Availability</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $data->results as $prop ) { ?>
			<tr id="favorite_<?php echo esc_attr( $prop->id ) ?>">
				<td>
					<a href="/vrp/unit/<?php echo esc_attr( $prop->page_slug ); ?>">
						<img src="<?php echo esc_url( $prop->Thumb ); ?>" style="max-width:150px;">
						<?php echo esc_html( $prop->Name ); ?>
					</a>
				</td>

				<td>
					<span>
					<?php echo esc_html( $prop->Bedrooms ); ?>
					</span>
				</td>

				<td>
					</span>
					<?php echo esc_html( $prop->Bathrooms ); ?>
					</span>
				</td>
				<td>
					<span>
					<?php echo ( ! empty( $prop->unavail ) ) ? 'Not Availabile' : 'Available'; ?>
					</span>
				</td>
				<td>
					<button class="vrp-favorite-button vrp-btn btn-danger"
					        data-unit="<?php echo esc_attr( $prop->id ) ?>"></button>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>

	<div class="clear"></div>
	<div style="text-align:right;">
		<small>
			* Highest Rate Shown. Not based on occupancy.
		</small>
	</div>
</div>
