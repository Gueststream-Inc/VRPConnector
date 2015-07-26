<div class="userbox" >
    <h3>Congratulations!</h3>
    <div class="padit">
        <b>Reservation Confirmation Number:</b> <?php echo esc_html($data->thebooking->BookingNumber);?><br><br>
        You have successfully booked <b><?php echo esc_html($data->Name);?></b> from <b><?php echo esc_html($data->Arrival); ?></b> for <b><?php echo esc_html(floor($data->Nights)); ?></b> nights.
        <br /><br />
        You will receive an email confirmation shortly with additional information.
    </div>

</div>
<?php echo '
<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));

</script>
		<script type="text/javascript">

try {

  var pageTracker = _gat._getTracker("UA-xxxxxxx-xx");


  pageTracker._trackPageview();


  pageTracker._addTrans(

    "' . esc_js($data->thebooking->BookingNumber) . '",                                     // Order ID

    "",                            // Affiliation

    "' . esc_js($data->TotalCost) . '",                                    // Total

    "",                                     // Tax

    "",                                        // Shipping

    "",                                 // City

    "",                               // State

    ""                                       // Country

  );

 pageTracker._addItem(

    "' . esc_js($data->thebooking->BookingNumber) . '",                                     // Order ID

    "",                                     // SKU

    "' . esc_js($data->Name) . '",                                  // Product Name

    "",                             // Category

    "' . esc_js($data->TotalCost) . '",                                    // Price

    "1"                                         // Quantity

  );



  pageTracker._trackTrans();

} catch(err) {}</script>';
