<?php
/**
 * [vrpSpecials] Template
 *
 * @package VRPConnector
 */

?>
<h1>Specials</h1>
<?php if ( 0 === count( $data ) ) : ?>
	<p>There are no current specials. Please check back soon.</p>
<?php else : ?>
	<?php foreach ( $data as $special ) : ?>
		<div class="sbox">
			<div class="vrpcontainer_12">
				<div class="vrpgrid_3">
					<?php if ( ! empty( $special->image ) ) : ?>
						<img src="<?php echo esc_url( $special->image ); ?>" width="185px" class="simg">
					<?php endif; ?>
				</div>
			</div>
			<div class="vrpcontainer_12">
				<div class="vrpgrid_9">
					<b><?php echo esc_html( $special->title ); ?></b>
					<br>
					<br/>
					<?php echo esc_html( $special->content ); ?>
				</div>
			</div>

		</div>
		<div class="clear"></div>
	<?php endforeach; ?>
<?php endif; ?>
