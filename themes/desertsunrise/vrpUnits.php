<?php
/**
 * [vrpUnits] Shortcode Template File
 *
 * @package VRPConnector
 */

if ( $data->count > 0 ) : ?>
	<div class="row">
		<?php echo esc_html( $data->count ); ?> Units
	</div>
	<?php foreach ( $data->results as $a_unit ) : ?>
		<div class="row">
			<div class="row">
				<h2>
					<a href="<?php echo esc_url( site_url( '/vrp/unit/' . $a_unit->page_slug ) ); ?>">
						<?php echo esc_html( $a_unit->Name ); ?>
					</a>
				</h2>
			</div>
			<div class="row">
				<div class="col-md-2">
					<img src="<?php echo esc_url( $a_unit->Thumb ); ?>" class="unit_thumbnail"/>
				</div>
				<div class="col-md-10">
					<?php echo wp_kses_post( $a_unit->ShortDescription ); ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
