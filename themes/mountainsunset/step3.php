<?php
    $userinfo = $_SESSION['userinfo'];
?>
<form
    action="/vrp/book/confirm/?obj[Arrival]=<?= $data->Arrival; ?>&obj[Departure]=<?= $data->Departure; ?>&obj[PropID]=<?= $_GET[ 'obj' ][ 'PropID' ]; ?>"
    id="vrpbookform" method="post">
<div class="userbox vrpstepuserbox" id="guestinfodiv">

    <h3>Guest Information</h3>

    <div class="padit">
        <div class="vrpgrid_6">
            <table class="booktable">
                <tr id="fnametr">
                    <td><label for="fname">First Name*:</label>
                    <input type="text" name="booking[fname]" id="fname" value="<?= $userinfo->fname; ?>"></td>
                </tr>

                <tr id="lnametr">
                    <td><label for="lname">Last Name*:</label>
                    <input type="text" name="booking[lname]" id="lname" value="<?= $userinfo->lname; ?>"></td>
                </tr>

                <tr id="addresstr">
                    <td><label for="straddress">Address*:</label>
                    <input type="text" name="booking[address]" value="<?= $userinfo->address; ?>" id="straddress"></td>
                </tr>
                <tr id="address2tr">
                    <td><label for="straddress2">Address 2:</label>
                    <input type="text" name="booking[address2]" value="<?= $userinfo->address2; ?>" id="straddress2"></td>
                </tr>
                <tr id="citytr">
                    <td><label for="strcity">City*:</label>
                    <input type="text" name="booking[city]" value="<?= $userinfo->city; ?>" id="strcity"></td>
                </tr>

                <tr id="regiontr" style="display:none">
                    <td><label for="region">Region*:</label>
                    <input type="text" name="booking[region]" id="region" value="<?= $userinfo->region; ?>"></td>
                </tr>


                <tr id="statetr">
                    <td><label for="states">State*:</label>
                    <select name="booking[state]" id="states">
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
                    <td><label for="provinces">Province*:</label>
                    <select name="booking[province]" id="provinces">
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
        <div class="vrpgrid_6">
            <table class="booktable">

                <tr id="countrytr">
                    <td><label for="country">Country*:</label>
                    <select name="booking[country]" id="country">


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
                    <td><label for="othercountry">Other*:</label>
                    <select name="booking[othercountry]" id="othercountry">

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
                    <td><label for="strzip">Postal Code*:</label>
                    <input type="text" name="booking[zip]" value="<?= $userinfo->zip; ?>" id="strzip"></td>
                </tr>
                <tr id="phonetr">
                    <td><label for="strphone">Phone*:</label>
                    <input type="text" name="booking[phone]" value="<?= $userinfo->phone; ?>" id="strphone"></td>
                </tr>
                <tr id="wphonetr">
                    <td><label for="strwphone">Work Phone:</label>
                    <input type="text" name="booking[wphone]" value="<?= $userinfo->wphone; ?>" id="strwphone"></td>
                </tr>
                <?php
                if ($userinfo->id != 0) {
                    ?>
                    <tr id="emailtr">
                        <td><label for="emailbox">Email*:</label>
                        <span id="emailaddress"><?= $userinfo->email; ?></span><input style="display:none;" type="text"
                                                                                          name="booking[email]"
                                                                                          value="<?= $userinfo->email; ?>"
                                                                                          id="emailbox"> <span
                                id="changelink">| <a href="#" id="showchange">Change</a></span></td>
                    </tr>
                <?php } else { ?>
                    <tr id="emailtr">
                        <td><label for="stremailbox">Email*:</label>
                        <input type="text" name="booking[email]" value="<?= $userinfo->email; ?>" id="stremailbox"></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td><label for="stroccup">Occupants:</label>
                        <?php
                        if (isset($_SESSION[ 'obj' ][ 'Adults' ]) || isset($_SESSION[ 'obj' ][ 'Children' ])) {
                            if (isset($_GET[ 'obj' ][ 'Adults' ])) {
                                $adults = ((int)$_GET[ 'obj' ][ 'Adults' ]) + 1;
                            } else {
                                $adults = ($_SESSION[ 'adults' ]) + 1;
                            }
                            ?>
                            <input type="hidden" name="booking[adults]" value="<?= $adults; ?>"/><?= $adults; ?> +
                            <?php
                            if (isset($_GET[ 'obj' ][ 'Children' ])) {
                                $children_count = (int)$_GET[ 'obj' ][ 'Children' ];
                            } else {
                                $children_count = $_SESSION[ 'children' ];
                            }
                            ?>
                            <input type="hidden" name="booking['children']" value="<?php echo $children_count; ?>"/>
                            <?php } else { ?>
                                <input type="text" name="booking[adults]" value="<?= $adults; ?>" id="stroccup">
                            <?php } ?>
                    </td>
                </tr>


            </table>
        </div>
    </div>
    <br style="clear:both;"></div>
<div class="userbox vrpstepuserbox" style="margin-top:20px; <?php
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
    <div class="userbox vrpstepuserbox" style="margin-top:20px;">
        <h3>Optional Travel Insurance</h3>
        <div class="padit" style="text-align:center;font-size:13px;">
            Travel insurance is available for your trip. ($<?= number_format ($data->InsuranceAmount, 2); ?>)
            <br>
            Would you like to purchase the optional travel insurance?
            <br>
            <br>
            <input type="radio" name="booking[acceptinsurance]" value="1"/> Yes
            <input type="radio" name="booking[acceptinsurance]" value="0" checked/> No
            <input type="hidden" name="booking[InsuranceAmount]" value="<?= $data->InsuranceAmount; ?>">
            <input type="hidden" name="booking[IAmount]" value="<?= $data->InsuranceAmount; ?>">
            <input type="hidden" name="booking[InsuranceID]" value="<?= $data->InsuranceID; ?>" />
        </div>
    </div>
<?php } else { ?>
    <input type="hidden" name="booking[acceptinsurance]" value="0">
<?php } ?>
<div class="vrpgrid_4">
    <div class="userbox vrpstepuserbox" style="margin-top:20px;">
        <h3>Payment Information</h3>

        <div class="padit">
            <table class="booktable">
                <tr id="ccNumbertr">
                    <td><label for="ccnum">Credit Card Number*:</label>
                    <input id="ccnum" type="text" name="booking[ccNumber]"></td>
                </tr>
                <tr id="ccNumbertr">
                    <td><label for="cccvv">CVV*:</label>
                    <input id="cccvv" type="text" name="booking[cvv]"></td>
                </tr>

                <tr id="ccTypetr">
                    <?php if (isset($data->booksettings->Cards)) { ?>
                        <td><label for="cctype">Card Type*:</label>
                        <select id ="cctype" name="booking[ccType]">
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
                        <td><label for="ccexpy">Expiration*:</label>
                        <select id="ccexpy" name="booking[expMonth]">
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
                        <td><label for="ccexpy">Expiration*:</label>
                        <select name="booking[expMonth]" style="width: 42%;float:left;margin-right:1em;">
                                <?php foreach (range (1, 12) as $month): ?>

                                    <option value="<?= sprintf ("%02d", $month) ?>"><?= sprintf ("%02d", $month) ?></option>
                                <?php endforeach; ?>
                            </select><span style="color:#fff;weight:bold;font-size:1.25em;float:left;">/</span>
                            <select style="width: 42%;float:left;margin-left:1em;" name="booking[expYear]">
                                <?php foreach (range (date ("y"), date ("y") + 10) as $year): ?>

                                    <option value="<?= $year; ?>"><?= $year; ?></option>
                                <?php endforeach; ?>

                            </select></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<div class="vrpgrid_8">
    <div class="userbox vrpstepuserbox" style="margin-top:20px;">
        <h3>Comments or Special Requests</h3>

        <div class="padit" align="center">

            <textarea style="width:90%;height:100px;" id="comments" name="booking[comments]"></textarea>

        </div>

    </div>
</div>

<div class="vrpgrid_8" style="text-align:center;padding-top: 2em;">
    <div style="margin:0 auto;width:80%;clear:both;">
        By clicking the "Book This Property Now" you are agreeing to the <a id="show-res-policies" href="#res-policies"><b>terms and conditions</b></a>.
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
        <input type="submit" value="Book This Property Now" class="btn btn-success" id="bookingbuttonvrp" style="
                                                                                                              border: 0;
                                                                                                              padding: 1em 1.5em;
                                                                                                              line-height: 0em;
                                                                                                              display: block;
                                                                                                              text-align: center;
                                                                                                              margin: 0.5em auto;
                                                                                                              float: none;">
        Only click the "Book This Property Now" button once or you may be charged twice.

    </div>
</div>
</form>

<div style="margin-top: 5em;" id="res-policies" id="myModal" class="modal hide fade ui-accordion closed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <h3>Rental Agreement</h3>
    </div>
    <div class="modal-body">
        <div>
        <?= nl2br ($data->Agreement); ?>
        </div>
    </div>

</div>

<br><br><br><br><br>
