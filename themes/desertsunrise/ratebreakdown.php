<?php
$old_arrival_date = $data->Arrival;
$old_date_arrival_date = strtotime($old_arrival_date);
$new_arrival = date('l, F d, Y', $old_date_arrival_date);

$old_depart_date = $data->Departure;
$old_date_depart_date = strtotime($old_depart_date);
$new_depart = date('l, F d, Y', $old_date_depart_date);
$rent = $data->res->propertyratesdetails[0]->ratesvalue;
$cost_per_night = round(($rent / ($data->Nights)), 2); ?>

<div class="booking-breakdown">
    <div class="book-details-dates">
        <div class="book-details left"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Check In</div>
        <div class="book-details small"><?php echo $new_arrival ?></div>
    </div>
    <div class="book-details-dates">
        <div class="book-details left"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Check Out</div>
        <div class="book-details small"><?php echo $new_depart ?></div>
    </div>


    <div class="book-box-content">
        <div class="padit">

            <table id="ratebreakdown" class="table table-striped" style="margin-bottom:0;">

                <?php if (isset($data->Charges)) {
                    foreach ($data->Charges as $v):
                        if($v->Amount>0):
                        ?>
                        <tr>
                            <td><?= $v->Description; ?></td>
                            <td class="right-align">
                                <?php if (isset($v->Type) && $v->Type == 'discount') {
                                    echo "-";
                                } ?>$<?= number_format($v->Amount, 2); ?>
                            </td>
                        </tr>
                            <?php endif;?>
                    <?php endforeach;
                } ?>
                <?php if ($data->TotalTax!=0) {?>
                <tr>
                    <td>Tax</td>
                    <td class="right-align">$<?= number_format($data->TotalTax, 2); ?></td>
                </tr>
<?php }?>
                <tr class="double">
                    <td><b>Reservation Total</b></td>
                    <td class="right-align" id="TotalCost">
                        <b>$<?= number_format(($data->TotalCost - $data->InsuranceAmount), 2); ?></b>
                        <span style="display:none" id="totalnow"><?= $data->TotalCost; ?></span>
                    </td>
                </tr>

                <tr class='bhighlighted'>
                    <td>
                        <b>Total Due Now:</b>
                    </td>
                    <td class="right-align">
                        <b>$<?= number_format($data->DueToday,2); ?></b>
                    </td>
                </tr>

            </table>


            <?php if (!empty($data->Payments)) { ?>
                <h3>Payment Schedule</h3>
                <table cellspacing="5" class="vrp-booking-payment-schedule" style="width:70%;font-size:11px;font-family:verdana;">
                    <?php foreach ($data->Payments as $v) { ?>
                        <tr>
                            <td>
                                <?php

                                $b = str_replace( ',', '', $v->Amount );

                                if( is_numeric( $b ) ) {
                                    $v->Amount = $b;
                                }
                                ?>
                                <?= date("m/d/Y", strtotime($v->DueDate)); ?>
                            </td>
                            <td>
                                $<?=  number_format((float)$v->Amount, 2, '.', ''); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>

        </div>
    </div>
</div>