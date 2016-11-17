<?php
/**
 * [vrpFeaturedUnit] Shorcode Template
 *
 * This is used to display the featured units when two or more units are displayed.
 *
 * @package VRPConnector
 */

foreach ( $data as $a_featured_unit ) : ?>
	<a href="<?php echo esc_url( site_url( '/vrp/unit/' . $a_featured_unit->page_slug ) ); ?>"
	   Title="<?php echo esc_attr( $a_featured_unit->Name ); ?>">
		<img src="<?php echo esc_url( $a_featured_unit->Photo ); ?>">
	</a>
<?php endforeach; ?>
