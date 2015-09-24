<?php global $vrp; ?>
<div>
    <img src="<?php echo plugins_url('/images/vrpconnector-logo.png',__FILE__);; ?>"
         alt="VRP Connector Logo"/>
</div>
<h2>Vacation Rental Platform Connector Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields('VRPConnector'); ?>


    <?php if($vrp->apiKey === false || $vrp->apiKey === '1533020d1121b9fea8c965cd2c978296'):?>
        <a href="https://secure.gueststream.com" target="_blank">
            <img width="25%" style="float:right" src="<?php echo plugins_url('/images/free_30_day_trial.png', __FILE__); ?>" alt="VRP Connector Trial"/>
        </a>
    <?php endif;?>
    <?php do_settings_sections('VRPConnector'); ?>
    <?php submit_button(); ?>
</form>
<hr>
<b>Current Status:</b>



<?php
$data = $vrp->testAPI();
if ( !isset( $data->Status ) ) {
	$data->Status = false;
}
switch ($data->Status) {
    case "Online":
        echo "<span style='color:green;'>Online</span>";
        break;
    default:
        echo "<span style='color:red;'>Error</span>";
        break;
}
?>
</div>