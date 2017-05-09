<?php
/**
 * Booking Template
 *
 * @package VRPConnector
 */

if ( isset( $data->Error ) ) {
	echo esc_html( $data->Error );
	echo "<br><br><a href='/'>Please try again.</a> ";
} elseif ( ! isset( $data->Charges ) ) {
	echo "We're sorry, this property is not available at for the dates requested. <a href='/'>Please try again.</a><br><br>";
} else {
	global $wp_query;
	$query = $wp_query;
	?>
	


    <div id="vrp" class="vrp-checkout">




        <div class="vrp-col-md-4 vrp-pull-right">
            <div class="userbox vrpstepuserbox">
                <div class="book-box-wrap">
                    <div class="book-details-wrap">
                        <div class="book-top">
                            <h2>Reservation Details</h2>
                            <div class="book vrpgrid_12">
                                <div class="book-image"></div>
                                <img src="<?php echo esc_url($data->unit->photos[1]->url); ?>" style="width:100%;" >
                            </div>
                        </div>

                        <div class="book-details bold"><?php echo $data->Name ?></div>

                        <div class="book-details highlight">

                            <div id="booking-ratebreakdown">
                                <?php require("ratebreakdown.php"); ?>
                            </div>

                        </div>
                <?php if (false) { ?>

                    <h3>Package Code (Optional)</h3>
                  
                    <?php if (isset($_GET['obj']['strPromotionCode']) && $_GET['obj']['strPromotionCode'] != "" ){ ?>
                        <div style="padding:1em;text-align:center;">
                        <?php echo 'Code Applied to Reservation<br/>Code Entered: <b>' . strtoupper($_GET['obj']['strPromotionCode']) . '</b>'; ?>
                        </div>
                    <?php } else { ?>

                        <form action="?<?= $pageurl; ?>" method="get" id="promoform">
                            <table cellspacing="5" style="width:90%;font-size:11px;font-family:verdana;">
                                <tr>
                                    <td><input type="text" name="obj[strPromotionCode]"></td>
                                    <td><input type="submit" value="Apply"></td>
                                    <td> <img src="/wp-content/plugins/VRPAPI/images/ajaxloader.gif" style="display:none;" class="theloadergif"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div id="cmsg" class="vrpmsg2" style="display:none;"></div>
                                    </td>
                                </tr>

                            </table>

                        <?php
                        foreach ($_GET['obj'] as $key => $value) {
                            if ($key == 'strPromotionCode') {
                                continue;
                            }
                                echo "<input type='hidden' name='obj[$key]' value='$value'>";
                            } ?>
                        </form>

                    <?php } ?>
                <?php } ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="vrp-col-md-8 book-form-details">
		<?php
		if ( file_exists( get_stylesheet_directory() . $query->query_vars['slug'] . '.php' ) ) {
			include( get_stylesheet_directory() . $query->query_vars['slug'] . '.php' );
		} elseif ( file_exists( __DIR__ . '/' . $query->query_vars['slug'] . '.php' ) ) {
			include $query->query_vars['slug'] . '.php';
		} else {
			echo esc_html( $query->query_vars['slug'] . '.php does not exist.' );
		}
		?>
	</div>
    </div>

	<div class="clear"></div>
	<?php
}
?>