<?php global $vrp; ?>
<div>
    <img src="<?php echo plugins_url('/images/vrpconnector-logo.png',__FILE__);; ?>"
         alt="VRP Connector Logo"/>
</div>
<h2>Vacation Rental Platform Connector Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields('VRPConnector'); ?>
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
<div class="bootstrap-wrapper">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary">Help!</a>
        </div>
    </div>
<a class="btn btn-primary">test</a>
</div>