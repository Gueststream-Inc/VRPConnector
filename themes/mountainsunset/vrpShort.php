<?php
/**
 * [vrpShort] Shortcode Template
 *
 * @package VRPConnector
 * @var $data
 */

$page = 0;
if ( ! empty( $_GET['page'] ) ) { // Input var okay.
	$page = sanitize_text_field( wp_unslash( $_GET['page'] ) ); // Input var okay.
}
?>
<div class="vrpcontainer_12 vrp100">
	<div class="vrpgrid_12 alpha omega ">
		<div class="vrpgrid_12">
			<a name="unitlistings"></a>

			<div id="unitsincomplex">
				Loading Units...
			</div>

			<form id="jaxform2">
				<?php foreach ( $data as $search_field => $search_value ) { ?>
					<input type="hidden"
					       name="search[<?php echo esc_attr( $search_field ); ?>]"
					       value="<?php echo esc_attr( $search_value ); ?>">
				<?php } ?>
				<input type="hidden" name="search[NoComplex]" value="1">
				<input type="hidden" name="search[showall]" value="1">
				<?php if ( ! empty( $page ) ) { ?>
					<input type="hidden" name="page" value="<?php echo esc_attr( $page ); ?>">
				<?php } ?>
			</form>
		</div>
	</div>
	<br style="clear:both;">
</div>
