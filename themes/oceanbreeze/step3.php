<?php
    $userinfo = $_SESSION['userinfo'];
?>
<form
    action="/vrp/book/confirm/?obj[Arrival]=<?= $data->Arrival; ?>&obj[Departure]=<?= $data->Departure; ?>&obj[PropID]=<?= $_GET[ 'obj' ][ 'PropID' ]; ?>"
    id="vrpbookform" method="post">
<div class="userbox" id="guestinfodiv">

    <h3>Guest Information</h3>

    <div class="padit">
        <div style="float:left;width:50%">
            <table class="booktable">
                <tr id="fnametr">
                    <td><b>First Name*:</b></td>
                    <td><input type="text" name="booking[fname]" id="fname" value="<?= $userinfo->fname; ?>"></td>
                </tr>

                <tr id="lnametr">
                    <td><b>Last Name*:</b></td>
                    <td><input type="text" name="booking[lname]" id="lname" value="<?= $userinfo->lname; ?>"></td>
                </tr>

                <tr id="addresstr">
                    <td><b>Address*:</b></td>
                    <td><input type="text" name="booking[address]" value="<?= $userinfo->address; ?>"></td>
                </tr>
                <tr id="address2tr">
                    <td><b>Address 2:</b></td>
                    <td><input type="text" name="booking[address2]" value="<?= $userinfo->address2; ?>"></td>
                </tr>
                <tr id="citytr">
                    <td><b>City*:</b></td>
                    <td><input type="text" name="booking[city]" value="<?= $userinfo->city; ?>"></td>
                </tr>

                <tr id="regiontr" style="display:none">
                    <td><b>Region*:</b></td>
                    <td><input type="text" name="booking[region]" id="region" value="<?= $userinfo->region; ?>"></td>
                </tr>


                <tr id="statetr">
                    <td><b>State*:</b></td>
                    <td><select name="booking[state]" id="states">
                            <option value="">-- Select State --</option><?php
                            foreach ($data->form->states as $k => $v):
                                $sel = "";
                                if ($userinfo->state == $k) {
                                    $sel = "selected=\"selected\"";
                                }
                                ?>
                                <option value="<?= $k; ?>" <?= $sel; ?>><?= $v; ?></option>
                            <?php
                            endforeach;
                            ?></select></td>
                </tr>
                <tr id="provincetr" style="display:none">
                    <td><b>Province*:</b></td>
                    <td><select name="booking[province]" id="provinces">
                            <option value="">-- Select Province --</option><?php
                            foreach ($data->form->provinces as $k => $v):
                                $sel = "";
                                if ($userinfo->province == $k) {
                                    $sel = "selected=\"selected\"";
                                }
                                ?>
                                <option value="<?= $k; ?>"><?= $v; ?></option>
                            <?php
                            endforeach;
                            ?></select>
                    </td>
                </tr>
            </table>
        </div>
        <table class="booktable">

            <tr id="countrytr">
                <td><b>Country*:</b></td>
                <td><select name="booking[country]" id="country">


                        <?php
                        foreach ($data->form->main_countries as $k => $v):
                            $sel = "";
                            if ($userinfo->country == $k) {
                                $sel = "selected=\"selected\"";
                            }
                            ?>
                            <option value="<?= $k; ?>" <?= $sel; ?>><?= $v; ?></option>
                        <?php
                        endforeach;
                        ?>
                        <option value="other">Other</option>
                    </select></td>
            </tr>
            <tr id="othertr" style="display:none;">
                <td><b>Other*:</b></td>
                <td><select name="booking[othercountry]" id="othercountry">

                        <option value="">-- Select Country --</option><?php
                        foreach ($data->form->countries as $k => $v):
                            $sel = "";
                            if ($userinfo->country == $k) {
                                $sel = "selected=\"selected\"";
                            }
                            ?>
                            <option value="<?= $k; ?>"><?= $v; ?></option>
                        <?php
                        endforeach;
                        ?>

                    </select></td>
            </tr>
            <tr id="ziptr">
                <td><b>Postal Code*:</b></td>
                <td><input type="text" name="booking[zip]" value="<?= $userinfo->zip; ?>"></td>
            </tr>
            <tr id="phonetr">
                <td><b>Phone*:</b></td>
                <td><input type="text" name="booking[phone]" value="<?= $userinfo->phone; ?>"></td>
            </tr>
            <tr id="wphonetr">
                <td><b>Work Phone:</b></td>
                <td><input type="text" name="booking[wphone]" value="<?= $userinfo->wphone; ?>"></td>
            </tr>
            <?php
            if ($userinfo->id != 0) {
                ?>
                <tr id="emailtr">
                    <td><b>Email*:</b></td>
                    <td><span id="emailaddress"><?= $userinfo->email; ?></span><input style="display:none;" type="text"
                                                                                      name="booking[email]"
                                                                                      value="<?= $userinfo->email; ?>"
                                                                                      id="emailbox"> <span
                            id="changelink">| <a href="#" id="showchange">Change</a></span></td>
                </tr>
            <?php } else { ?>
                <tr id="emailtr">
                    <td><b>Email*:</b></td>
                    <td><input type="text" name="booking[email]" value="<?= $userinfo->email; ?>"></td>
                </tr>
            <?php } ?>

            <tr>
                <td><b>Occupants:</b></td>
                <td>
                    <?php
                    if (isset($_GET[ 'obj' ][ 'Adults' ])) {
                        $adults = (int)$_GET[ 'obj' ][ 'Adults' ];
                    } else {
                        $adults = $_SESSION[ 'adults' ];
                    }
                    ?>
                    <input type="hidden" name="booking[adults]" value="<?= $adults; ?>"/><?= $adults; ?>
                    <?php
                    if (isset($_GET[ 'obj' ][ 'Children' ])) {
                        $children_count = (int)$_GET[ 'obj' ][ 'Children' ];
                    } else {
                        $children_count = $_SESSION[ 'children' ];
                    }
                    ?>
                    <input type="hidden" name="booking['children']" value="<?php echo $children_count; ?>"/>
                </td>
            </tr>


        </table>
    </div>
    <br style="clear:both;"></div>
<div class="vrpgrid_12 alpha omega userbox" style="margin-top:20px; <?php
echo "display: none";
?>" id="passwordbox">
    <h3>Password (optional)</h3>

    <div class="padit">
        You have the option to set a password for the next time you visit our site.<br><br>
        <table style="width:70%;margin-left:20%">
            <tr id="passwordtr">
                <td><b>Password:</b></td>
                <td><input type="password" name="booking[password]" value=" "></td>
            </tr>
            <tr id="password2tr">
                <td><b>Password (Again):</b></td>
                <td><input type="password" name="booking[password2]" value=" "></td>
            </tr>
        </table>
    </div>

</div>
<?php if ($data->HasInsurance) { ?>
    <div class="vrpgrid_12 alpha omega userbox" style="margin-top:20px;">
        <h3>Optional Travel Insurance</h3>

        <div class="padit" style="text-align:center;font-size:13px;">

            Travel insurance is available for your trip. ($<?= number_format ($data->InsuranceAmount, 2); ?>) <br> Would
            you like to purchase the optional travel insurance? <br>
            <br> <input type="radio" name="booking[acceptinsurance]" value="1" checked> Yes <input type="radio"
                                                                                                   name="booking[acceptinsurance]"
                                                                                                   value="0"/> No
            <input type="hidden" name="booking[InsuranceAmount]" value="<?= $data->InsuranceAmount; ?>">
        </div>
    </div>
<?php } else { ?>
    <input type="hidden" name="booking[acceptinsurance]" value="0">
<?php } ?>
<div class="userbox" style="margin-top:20px;">
    <h3>Payment Information</h3>

    <div class="padit">
        <table class="booktable">
            <tr id="ccNumbertr">
                <td><b>Credit Card Number*:</b></td>
                <td><input type="text" name="booking[ccNumber]"></td>
            </tr>
            <tr id="ccNumbertr">
                <td><b>CVV*:</b></td>
                <td><input type="text" name="booking[cvv]"></td>
            </tr>

            <tr id="ccTypetr">
                <?php if (isset($data->booksettings->Cards)) { ?>
                    <td><b>Card Type*:</b></td>
                    <td><select name="booking[ccType]">
                            <?php
                            foreach ($data->booksettings->Cards as $k => $v):
                                ?>
                                <option value="<?= $k; ?>"><?= $v; ?></option>
                            <?php endforeach; ?>

                        </select></td>
                <?php } ?>
            </tr>
            <?php if (isset($data->booksettings->Cards)) { ?>
                <tr id="expYeartr">
                    <td><b>Expiration*:</b></td>
                    <td><select name="booking[expMonth]">
                            <?php foreach (range (1, 12) as $month): ?>

                                <option value="<?= sprintf ("%02d", $month) ?>"><?= sprintf ("%02d", $month) ?></option>
                            <?php endforeach; ?>
                        </select>/<select name="booking[expYear]">
                            <?php foreach (range (date ("Y"), date ("Y") + 10) as $year): ?>

                                <option value="<?= $year; ?>"><?= $year; ?></option>
                            <?php endforeach; ?>

                        </select></td>
                </tr>
            <?php } else { ?>
                <tr id="expYeartr">
                    <td><b>Expiration*:</b></td>
                    <td><select name="booking[expMonth]">
                            <?php foreach (range (1, 12) as $month): ?>

                                <option value="<?= sprintf ("%02d", $month) ?>"><?= sprintf ("%02d", $month) ?></option>
                            <?php endforeach; ?>
                        </select>/<select name="booking[expYear]">
                            <?php foreach (range (date ("y"), date ("y") + 10) as $year): ?>

                                <option value="<?= $year; ?>"><?= $year; ?></option>
                            <?php endforeach; ?>

                        </select></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="userbox" style="margin-top:20px;">
    <h3>Comments or Special Requests</h3>

    <div class="padit" align="center">

        <textarea style="width:90%;height:100px;" id="comments" name="booking[comments]"></textarea>

    </div>

</div>
<div class="" style="margin-top:20px; text-align:center">
    <div style="margin:0 auto;width:80%">
        By clicking the "Book This Property Now" you are agreeing to the <a href="/reservation-policies/"
                                                                            target="_blank"><b>terms and conditions</b></a>.
        <br><br>
        <?php if (isset($data->ratecalc)) { ?>
            <input type="hidden" name="booking[ratecalc]" value="1">
            <?php
            if (! isset($data->prop->ISIRate)) {
                $newrate = $data->TotalCost;
                foreach ($data->Charges as $v) {
                    if ($v->Description == 'Rent') {
                        $newrate = $v->Amount;
                    }
                }
            } else {
                $newrate = $data->prop->ISIRate;
            }
            ?>
            <input type="hidden" name="booking[newrate]" value="<?= $newrate; ?>">
        <?php } ?>


        <input type="hidden" name="booking[PropID]" value="<?= $data->PropID; ?>">
        <input type="hidden" name="booking[arrival]" value="<?= $data->Arrival; ?>">
        <input type="hidden" name="booking[depart]" value="<?= $data->Departure; ?>">
        <input type="hidden" name="booking[nights]" value="<?= $data->Nights; ?>">
        <input type="hidden" name="booking[DueToday]" value="<?= $data->DueToday; ?>">
        <input type="hidden" name="booking[TotalCost]" value="<?= $data->TotalCost; ?>">
        <input type="hidden" name="booking[TotalBefore]" value="<?= $data->TotalCost - $data->TotalTax; ?>">
        <input type="hidden" name="booking[TotalTax]" value="<?= $data->TotalTax; ?>">
        <?php
        if (isset($data->InsuranceAmount)) {
            $data->TotalCost = $data->TotalCost - $data->InsuranceAmount;
        }
        ?>
        <input type="hidden" name="booking[TotalCost]" value="<?= $data->DueToday; ?>">
        <?php if (isset($data->booksettings->HasPackages)
            && (isset($data->package->items) && count ($data->package->items) != 0)
        ) { ?>
            <input type="hidden" name="booking[packages]" value="<?= base64_encode (serialize ($data->package)); ?>">
        <?php } ?>
        <?php
        if (isset($data->promocode)) {
            ?>
            <input type="hidden" name="booking[strPromotionCode]" value="<?= $data->promocode; ?>">
        <?php
        }
        ?>
        <div id="vrploadinggif" style="display:none"><b>Processing Your Booking...</b></div>
        <input type="submit" value="Book This Property Now" class="btn btn-success " id="bookingbuttonvrp">
        <br><br>
        Only click the "Book This Property Now" button once or you may be charged twice.

    </div>
</div>
</form>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Rental Agreement</h3>
    </div>
    <div class="modal-body">
        <?= nl2br ($data->booksettings->Contract); ?>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>

    </div>


</div>

<br><br><br><br><br>
