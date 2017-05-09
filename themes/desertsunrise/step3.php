<?php
/**
 * Final page of booking/checkout template
 *
 * @since 1.3.3
 */
global $vrp;
?>
<form
	action="<?php echo site_url('/vrp/book/confirm/'); ?>?obj[Arrival]=<?php echo esc_attr( $data->Arrival ); ?>&obj[Departure]=<?php echo esc_attr( $data->Departure ); ?>&obj[PropID]=<?php echo esc_attr( $_GET['obj']['PropID'] ); ?>"
	id="vrpbookform" method="post">
	<div class="userbox" id="guestinfodiv">
    <div class="padit">

        <div class="book-box-wrap flex">
            <div class="book-number">1</div><div class="book-title"><h3>Your Information</h3></div>
            <div class="book-box-content">
                <div class="vrp-col-md-12 vrp-col-sm-6">
                    <div class="booktable">
                        <div id="fnamediv">

                                <input type="text" placeholder="First Name*" name="booking[fname]" id="fname" value="<?= $userinfo->fname; ?>">
                        </div>

                        <div id="lnamediv">

                                <input type="text" placeholder="Last Name*" name="booking[lname]" id="lname" value="<?= $userinfo->lname; ?>">
                        </div>

                        <div id="addresstr">

                                <input type="text" name="booking[address]" placeholder="Address*" value="<?= $userinfo->address; ?>" id="straddress">
                        </div>
                        <div id="address2div">

                                <input type="text" name="booking[address2]" placeholder="Address 2"value="<?= $userinfo->address2; ?>" id="straddress2">
                        </div>
                        <div id="citydiv">

                                <input type="text" placeholder="City*" name="booking[city]" value="<?= $userinfo->city; ?>" id="strcity">
                        </div>

                        <div id="regiondiv" style="display:none">
                            <label for="region">Region*:</label>
                                <input type="text" name="booking[region]" id="region" value="<?= $userinfo->region; ?>">
                        </div>


                        <div id="statetr">

                        <td><select name="booking[state]" id="states">
                                <option value="">-- Select State --</option>
                                <?php foreach ($data->form->states as $k => $v): ?>
                                    <option value="<?php echo esc_attr($k); ?>">
                                        <?php echo esc_attr($v); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="provincetr" style="display:none">
                            <label for="provinces">Province*:</label>
                                <select name="booking[province]" id="provinces">
                                <option value="">-- Select Province --</option>
                                <?php foreach ($data->form->provinces as $k => $v): ?>
                                    <option value="<?php echo esc_attr($k); ?>">
                                        <?php echo esc_attr($v); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>






                        <div id="country">

                                <select name="booking[country]" id="country">
                                <?php foreach ($data->form->main_countries as $k => $v): ?>
                                    <option value="<?php echo esc_attr($k); ?>">
                                        <?php echo esc_attr($v); ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div id="othertr" style="display:none;">
                            <label for="othercountry">Other*:</label>
                         <select name="booking[othercountry]" id="othercountry">
                                <option value="">-- Select Country --</option>
                                <?php foreach ($data->form->countries as $k => $v): ?>
                                    <option value="<?php echo esc_attr($k); ?>">
                                        <?php echo esc_attr($v); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="zipdiv">

                                <input type="text" placeholder="Postal Code*" name="booking[zip]" value="<?= $userinfo->zip; ?>" id="strzip">
                        </div>
                        <div id="phonediv">

                                <input type="text" placeholder="Phone*" name="booking[phone]" value="<?= $userinfo->phone; ?>" id="strphone">
                        </div>
                        <div id="wphonediv">

                                <input type="text" name="booking[wphone]" placeholder="Work Phone" value="<?= $userinfo->wphone; ?>" id="strwphone">
                        </div>
                         <div id="mphonediv">

                                <input type="text" name="booking[mphone]" placeholder="Cell Phone" value="<?= $userinfo->mphone; ?>" id="strmphone">
                        </div>
                        <?php
                        if ($userinfo->id != 0) {
                            ?>
                            <div id="emaildiv">

                                    <span id="emailaddress"><?= $userinfo->email; ?></span><input style="display:none;" type="text"
                                                                                                  name="booking[email]" placeholder="Email*"
                                                                                                  value="<?= $userinfo->email; ?>"
                                                                                                  id="emailbox"> <span
                                        id="changelink">| <a href="#" id="showchange">Change</a></span>
                            </div>
                        <?php } else { ?>
                            <div id="emaildiv">

                                    <input type="text" name="booking[email]" value="<?= $userinfo->email; ?>" placeholder="Email*" id="stremailbox">
                            </div>
                        <?php } ?>

                        <div style="width: 100%">


                      <div class="select-inline"
                                <?php
                                if (isset($_GET[ 'obj' ][ 'Adults' ]) || isset($_GET[ 'obj' ][ 'Children' ])) {
                                    if (isset($_GET[ 'obj' ][ 'Adults' ])) {
                                        $adults = ((int)$_GET[ 'obj' ][ 'Adults' ]);
                                    } else {
                                        $adults = ($_SESSION[ 'adults' ]);
                                    }
                                    ?>
                            <label>Adults</label>
                                    <input type="text" placeholder="Occupants*" name="booking[adults]" value="<?= $adults; ?>"/>
                                    <?php
                                    if (isset($_GET[ 'obj' ][ 'Children' ])) {
                                        $children_count = (int)$_GET[ 'obj' ][ 'Children' ];
                                    } else {
                                        $children_count = $_SESSION[ 'children' ];
                                    }


                                    ?>
                      </div>
                            <div class="select-inline"
                                     <label>Children</label>
                                    <input type="text"   placeholder="Children*" name="booking['children']" value="<?php echo $children_count; ?>"/>
                                <?php } else { ?>
                                    <input required type="text" placeholder="Occupants*" name="booking[adults]" value="<?= $adults; ?>" id="stroccup">
                                <?php } ?>
                            </div>
                        </div>


                    </div>
                </div>




    </div>
    <br style="clear:both;"></div>






    <?php if ( isset( $data->HasInsurance ) && $data->HasInsurance ) : ?>
    <div class="book-box-wrap add-ons">
        <div class="book-number">2</div>
        <div class="book-title">
            <h3>Optional Add-ons</h3>
        </div>
        <div class="book-box-content">

            <div class="book-box-wrap">

                <div class="book-box-content">


                    <div class="padit" style="text-align:center;font-size:13px;">

                        Travel insurance is available for your trip.
                        ($<?php echo esc_html( number_format( $data->InsuranceAmount, 2 ) ); ?>) <br>
                        Would you like to purchase the optional travel insurance? <br>
                        <br>
                        <input type="radio" name="booking[acceptinsurance]" value="1" required /> Yes
                        <input type="radio" name="booking[acceptinsurance]" value="0" /> No

                        <input type="hidden" name="booking[InsuranceAmount]"
                               value="<?php echo esc_attr( $data->InsuranceAmount ); ?>">

                        <?php if ( isset( $data->InsuranceID ) ) : // Escapia Insurance ID ?>
                            <input type="hidden" name="booking[InsuranceID]"
                                   value="<?php echo $data->InsuranceID; ?>" />
                        <?php endif; ?>

                        <?php if ( isset( $data->InsuranceTaxAmount ) ) : ?>
                            <?php
                            /**
                             * Escapia Travel Insurance Tax Amount
                             *
                             * In most cases we have seen, travel insurance is not taxed so this will not
                             * be present.  In the case that travel insurance is taxed, this value is necessary
                             * to tell the server to separate this amount from the '$data->InsuranceAmount' value as
                             * the displayed '$data->InsuranceAmount' value includes the Taxes.
                             */
                            ?>
                            <input type="hidden" name="booking[InsuranceTaxAmount]"
                                   value="<?php echo $data->InsuranceTaxAmount; ?>" />
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
                <?php else : ?>
                    <input type="hidden" name="booking[acceptinsurance]" value="0">
                <?php endif; ?>




    <div class="clear"></div>
	<div id="payment" class="vrp-col-md-12 vrp-col-sm-6">
		<div class="userbox vrpstepuserbox" style="margin-top:20px;">

			<div class="book-box-wrap">
				<div class="book-number">
                    <?php if ( isset( $data->HasInsurance ) && $data->HasInsurance ) : ?>
                    3
                    <?php else : ?>
                    2
                    <?php endif;?>
                </div>
                <div class="book-title">
                    <h3>Your Payment Breakdown</h3>
                </div>
				<div class="book-box-content">

				<div class="book-box-wrap">

				<div class="book-box-content">

                    <div class="book-details bhighlighted left">
                        TOTAL RESERVATION AMOUNT
                        <span id="totalcost" class="right">$
                            <?php echo number_format($data->TotalCost, 2) ?>
                        </span>
                    </div>

                    <div class="book-details left">
                        Total Due Now
                        <span id="totaldue" class="right">$
                            <?php echo number_format($data->DueToday, 2); ?>
                        </span>
                    </div>

                    <?php if (isset($data->Payments[0])) { ?>
                    <h3>Payment Schedule</h3>
                    <table class="table table-striped payments vrp-booking-payment-schedule">
                        <?php
                        foreach ($data->Payments as $v) { ?>
                            <tr>
                                <th><?php echo $v->DueDate; ?></th>
                                <td>$<?php echo $v->Amount; ?></td>
                            </tr>
                        <?php }
                        } ?>
                    </table>

				</div>

				</div>
					<div class="padit">
						<table class="paymenttable">
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
									<td><label style="float: left" for="ccexpy">Expiration*:</label>
										<select id="cc-expire-month" name="booking[expMonth]"  style="float:left;margin-right:0.25em;">
											<?php foreach (range (1, 12) as $month): ?>
												<option value="<?= sprintf ("%02d", $month) ?>"><?= sprintf ("%02d", $month) ?></option>
											<?php endforeach; ?>
										</select>
										<span style="font-weight:bold;font-size:16px;float:left;">/</span>
										<select name="booking[expYear]" id="cc-expire-year">
											<?php foreach (range (date ("Y"), date ("Y") + 10) as $year): ?>
												<option value="<?= $year; ?>"><?= $year; ?></option>
											<?php endforeach; ?>
										</select>
									</td>
								</tr>
							<?php } else { ?>
								<tr id="expYeartr">
									<td><label for="ccexpy">Expiration*:</label>
										<select class="cc-expire-month" name="booking[expMonth]" style="width: 30%;float:left;margin-right:0.25em;">
											<?php foreach (range (1, 12) as $month): ?>
												<option value="<?= sprintf ("%02d", $month) ?>"><?= sprintf ("%02d", $month) ?></option>
											<?php endforeach; ?>
										</select><span style="font-weight:bold;font-size:16px;float:left;">/</span>
										<select class="cc-expire-year" name="booking[expYear]">
											<?php foreach (range (date ("y"), date ("y") + 10) as $year): ?>

												<option value="<?= $year; ?>"><?= $year; ?></option>
											<?php endforeach; ?>

										</select></td>
								</tr>
							<?php } ?>
						</table>
            <a href="https://www.instantssl.com/ssl-certificate.html"
			   style="text-decoration:none;margin-top:1em;overflow: auto; display: inline-block;">
				<img alt="SSL Certificate"
				     src="https://www.instantssl.com/ssl-certificate-images/support/comodo_secure_100x85_transp.png"
				     style="border: 0px;"/><br/>
				<span style="font-weight:bold;font-size:12px; padding-left:8px; color:#77BAE4;">SSL Certificate</span>
			</a><br>
					</div>

				</div>

			</div>

		</div>
	</div>

    <div class="vrpgrid_12" style="padding-top:10px">
        <div class="book-box-wrap">
            <div class="book-title-color3">
	            <h3>Comments or Special Requests</h3>
            </div>

	        <div class="padit" align="center">
	            <textarea id="vrp-booking-comments" name="booking[comments]" style="width:99%;"></textarea>
	        </div>

        </div>
    </div>

    <div class="vrpgrid_12" style="text-align:center;padding-top: 1em; padding-bottom: 1em;">
	<div style="margin:0 auto;width:80%">
			By clicking the "Book This Property Now" you are agreeing to the
			<a href="#thecontract" id="showContract"><b>terms and conditions</b></a>.
				<br><br>

			<?php if ( isset( $data->leaseid ) ) :
				// Barefoot lease id. ?>
				<input type="hidden" id="vrp-booking-leaseid" name="booking[leaseid]"
				       value="<?php echo esc_attr( $data->leaseid ); ?>"/>
			<?php endif; ?>

			<input type="hidden" name="booking[password]" value=" ">
			<input type="hidden" name="booking[password2]" value=" ">
			<input type="hidden" id="vrp-prop-id" name="booking[PropID]"
			       value="<?php echo esc_attr( $data->PropID ); ?>">
			<input type="hidden" name="booking[arrival]" value="<?php echo esc_attr( $data->Arrival ); ?>">
			<input type="hidden" name="booking[depart]" value="<?php echo esc_attr( $data->Departure ); ?>">
			<input type="hidden" name="booking[nights]" value="<?php echo esc_attr( $data->Nights ); ?>">
			<input type="hidden" name="booking[DueToday]" value="<?php echo esc_attr( $data->DueToday ); ?>">
			<input type="hidden" name="booking[TotalCost]" value="<?php echo esc_attr( $data->TotalCost ); ?>">
			<input type="hidden" name="booking[TotalBefore]"
			       value="<?php echo esc_attr( $data->TotalCost - $data->TotalTax ); ?>">
			<input type="hidden" name="booking[TotalTax]" value="<?php echo esc_attr( $data->TotalTax ); ?>">

			<?php if ( ! empty( $_GET['obj']['PromoCode'] ) || ! empty( $data->promocode ) ) : ?>
				<?php $promoCode = ( ! empty( $_GET['obj']['PromoCode'] ) ) ? $_GET['obj']['PromoCode'] : $data->promocode; ?>
				<input type="hidden" name="booking[PromoCode]" value="<?php echo $promoCode ?>">
			<?php endif; ?>

			<?php if ( ! empty( $_GET['obj']['Pets'] ) ) :
				// Currently, only applicable to Escapia PMS. ?>
				<input type="hidden" name="booking[Pets]" value="<?php echo esc_attr( $_GET['obj']['Pets'] ); ?>">
			<?php endif; ?>

			<div id="vrploadinggif" style="display:none"><b>Processing Your Booking...</b></div>
			<input type="submit" value="Book This Property Now" class="vrp-btn vrp-btn-success " id="bookingbuttonvrp">
		</div>
	</div>
</form>

<div id="theContract" aria-hidden="true">
	<div class="modal-header">
		<h3>Rental Agreement</h3>
	</div>
	<div class="modal-body">
		<?php echo wp_kses_post( nl2br( $data->booksettings->Contract ) ); ?>
	</div>
	<div class="modal-footer">
		<a href="#" id="closeContract" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
	</div>
</div>