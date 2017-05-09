<?php
/**
 * VRPConnector complex page template
 *
 * @package VRPConnector
 */

?>
<div class="container">
	<div class="row">
		<div id="vrp-complex-tabs">
			<ul>
				<li><a href="#description">Description</a></li>
				<li><a href="#photos">Photos</a></li>
				<li><a href="#amenities">Amenities</a></li>
				<li><a href="#units">Units</a></li>
			</ul>

			<div id="description">
				<?php echo wp_kses_post( $data->description ); ?>
			</div>

			<div id="photos">
				<?php foreach ( $data->photos as $photo ) { ?>
					<img src="<?php echo esc_url( $photo->url ); ?>">
				<?php } ?>
			</div>

			<div id="amenities">
				<?php echo wp_kses_post( $data->amenities ); ?>
			</div>

			<div id="units">
				<?php foreach ( $data->units as $unit ) { ?>
					<li>
						<a href="/vrp/unit/<?php echo esc_attr( $unit->page_slug ); ?>">
							<h2><?php echo esc_html( $unit->Name ); ?></h2>
						</a>
						<?php echo wp_kses_post( $unit->ShortDescription ); ?>
					</li>
				<?php } ?>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery('#vrp-tabs').tabs();
</script>
