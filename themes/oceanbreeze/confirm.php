<div class="userbox" >
    <h3>Congratulations!</h3>
    <div class="padit">
        <b>Reservation Confirmation Number:</b> <?=$data->thebooking->BookingNumber;?><br><br>
        You have successfully booked <b><?=$data->Name;?></b> from <b><?= $data->Arrival; ?></b> for <b><?= floor($data->Nights); ?></b> nights.
        <br /><br />
        You will receive an email confirmation shortly with additional information.
    </div>

</div>
<?php 
echo '<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));

</script>
		<script type="text/javascript">

try {

  var pageTracker = _gat._getTracker("UA-xxxxxxx-xx");


  pageTracker._trackPageview();


  pageTracker._addTrans(

    "' . $data->thebooking->BookingNumber . '",                                     // Order ID

    "",                            // Affiliation

    "' . $data->TotalCost . '",                                    // Total

    "",                                     // Tax

    "",                                        // Shipping

    "",                                 // City

    "",                               // State

    ""                                       // Country

  );

 pageTracker._addItem(

    "' . $data->thebooking->BookingNumber . '",                                     // Order ID

    "",                                     // SKU

    "' . $data->Name . '",                                  // Product Name

    "",                             // Category

    "' . $data->TotalCost . '",                                    // Price

    "1"                                         // Quantity

  );



  pageTracker._trackTrans();

} catch(err) {}</script>';
?>
