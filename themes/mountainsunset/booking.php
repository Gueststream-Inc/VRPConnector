<?php
if (isset($data->Error)) {
    echo $data->Error;
    echo "<br><br><a href='/'>Please try again.</a> ";
} elseif (!isset($data->Charges)) {
    echo "We're sorry, this property is not available at for the dates requested. <a href='/'>Please try again.</a><br><br>";
} else {
    global $wp_query;
    $query=$wp_query;
    ?>

    <?php
        if (isset($_GET['tester'])) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
        ?>

<div class="row">
        <div id="progressbar" class="vrpcontainer_12 vrp100 col-md-8 col-sm-12">
            <div class="vrpgrid_1 ">&nbsp; </div>
            <?php if (isset($data->booksettings->HasPackages)) { ?>
                <div class="vrpgrid_2 passed padit alpha omega">1. Select <br> Unit</div>
                <div class="vrpgrid_2 padit alpha omega <?php
                if ($query->query_vars['slug'] == 'step1a' || $query->query_vars['slug'] == 'step2' || $query->query_vars['slug'] == 'step3'
                    || $query->query_vars['slug'] == 'confirm'
                ) {
                    echo "passed";
                }
                ?>">2. Optional Add-ons
                </div>
                <div class="vrpgrid_2 padit alpha omega <?php
                if ($query->query_vars['slug'] == 'step2' || $query->query_vars['slug'] == 'step3' || $query->query_vars['slug'] == 'confirm') {
                    echo "passed";
                }
                ?>">3. Guest <br> Info
                </div>
                <div class="vrpgrid_2 padit alpha omega <?php
                if ($query->query_vars['slug'] == 'confirm') {
                    echo "passed";
                }
                ?>">4. Confirm<br>Booking
                </div>
            <?php } else { ?>
                <div class="vrpgrid_3 passed padit alpha omega">1. Select <br>Unit</div>
                <div class="vrpgrid_3 padit alpha omega <?php
                if ($query->query_vars['slug'] == 'step2' || $query->query_vars['slug'] == 'step3' || $query->query_vars['slug'] == 'confirm') {
                    echo "passed";
                }
                ?>">2. Guest <br>Info
                </div>
                <div class="vrpgrid_3 padit alpha omega <?php
                if ($query->query_vars['slug'] == 'confirm') {
                    echo "passed";
                }
                ?>">3. Confirm<br>Booking
                </div>
            <?php } ?>
            <div class="vrpgrid_1">&nbsp; </div>

            <br style="clear:both;">
        </div>
    </div>

    <br>

    <div class="vrpgrid_4">
        <div class="userbox vrpstepuserbox" id="guestinfodiv" style="font-size: 0.75em;color: rgb(29, 113, 86);">
            <div >
                <h3>Reservation Details</h3>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <tr>
                        <td><b>Property Name:</b></td>
                        <td><b><?= $data->Name; ?></b></td>
                    </tr>

                    <tr>
                        <td>Arrival:</td>
                        <td><b><?= $data->Arrival; ?></b></td>
                    </tr>
                    <tr>
                        <td>Departure:</td>
                        <td><b><?= $data->Departure; ?></b></td>
                    </tr>
                    <tr>
                        <td>Nights:</td>
                        <td><b><?= $data->Nights; ?></b></td>
                    </tr>
                    <?php
                    if (isset($data->Charges)) {
                        foreach ($data->Charges as $v):
                            ?>
                            <tr>
                                <td><?= $v->Description; ?>:</td>
                                <td><?php if (isset($v->Type) && $v->Type == 'discount') {
                                        echo "-";
                                    } ?>$<?= number_format($v->Amount, 2); ?></td>
                            </tr>
                        <?php
                        endforeach;
                    }
                    ?>



                    <?php if (isset($data->booksettings->HasPackages)) { ?>
                        <tr>
                            <td>Add-on Package:</td>
                            <td id="packageinfo">$<?= number_format($data->package->packagecost, 2); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>Tax:</td>
                        <td>$<?= number_format($data->TotalTax, 2); ?></td>
                    </tr>


                    <tr>
                        <td><b>Reservation Total:</b></td>
                        <td id="TotalCost">$<?= number_format(
                                ((isset($data->package->TotalCost) ? $data->package->TotalCost : $data->TotalCost)
                                    - $data->InsuranceAmount), 2
                            ); ?></td>
                    </tr>

                </table>

                <?php if ($data->HasInsurance) { ?>
                    <h3>Optional Travel Insurance</h3>
                    <table class="table table-striped">
                        <tr>
                            <td>Optional Travel Insurance:</td>
                            <td>$<?= number_format($data->InsuranceAmount, 2); ?></td>
                        </tr>
                        <tr>
                            <td><b>Reservation Total with Insurance:</b></td>
                            <td>$<?= number_format(
                                    (isset($data->package->TotalCost) ? $data->package->TotalCost : $data->TotalCost), 2
                                ); ?></td>
                        </tr>
                    </table>
                <?php } ?>

                <h3>Payments Schedule</h3>
                <table class="table table-striped payments">
                    <?php foreach ($data->Payments as $v): ?>
                    <tr>
                        <th><?php echo $v->DueDate;?></th>
                        <td>$<?php echo number_format($v->Amount, 2); ?></td>
                    </tr>
                   <?php endforeach; ?>
                </table>
        



            </div>
        </div>


    </div>



    <div class="vrpgrid_8">

        <?php
        if(file_exists(get_stylesheet_directory() . "/vrp/" . $query->query_vars['slug'].'.php')) {
            include(get_stylesheet_directory() . "/vrp/" . $query->query_vars['slug'] . '.php');
        } else if (file_exists(__DIR__ . '/'. $query->query_vars['slug'] . ".php")) {
            include $query->query_vars['slug'] . ".php";
        } else {
            echo esc_html($query->query_vars['slug'] . '.php does not exist.');
        }
        ?>

    </div>

    <div class="clear"></div>

<?php
}
?>