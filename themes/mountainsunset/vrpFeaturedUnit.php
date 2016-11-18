<?php
/**
 * [vrpFeaturedUnit] Shortcode Template
 *
 * This template is used when only one featured unit is displayed.
 *
 * @package VRPConnector
 * @var $data
 */

if ( is_array( $data ) ) : ?>
	<?php foreach ( $data as $unit ) : ?>
		<a href="<?php echo esc_url( site_url( '/vrp/unit/' . $unit->page_slug ) ); ?>"
		   Title="<?php echo esc_attr( $unit->Name ); ?>">
			<img src="<?php echo esc_url( $unit->Photo ); ?>">
		</a>
	<?php endforeach; ?>
<?php elseif ( is_object( $data ) ) : ?>
	<a href="<?php echo esc_url( site_url( '/vrp/unit/' . $data->page_slug ) ); ?>"
	   Title="<?php echo esc_attr( $data->Name ); ?>">
		<img src="<?php echo esc_url( $data->Photo ); ?>">
	</a>
<?php endif; ?>
