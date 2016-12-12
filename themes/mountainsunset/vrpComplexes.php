<?php
/**
 * [vrpComplexes] ShortCode view
 *
 * @package VRPConnector
 */

?>
<div id="vrp">
	<?php foreach ( $data as $complex ) : ?>
		<div class="vrp-row" style="padding-bottom: 20px;">
			<div class="vrp-col-md-4">
				<img src="<?php echo esc_url( $complex->Photo ); ?>" style="padding:4px; width:95%;border: 1px solid #CCC;">
			</div>
			<div class="vrp-col-md-8">
				<h2>
					<a href="/vrp/complex/<?php echo esc_attr( $complex->page_slug ); ?>">
						<?php echo esc_html( $complex->name ); ?>
					</a>
				</h2>
				<?php echo wp_kses_post( $complex->shortdescription ); ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
