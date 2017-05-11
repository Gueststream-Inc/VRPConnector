<?php
/**
 * Unit Page Template
 *
 * @package VRPConnector
 * @since 1.3.0
 */

global $vrp;
if (isset($_GET['search']['arrival'])) {
    $_SESSION['arrival'] = $_GET['search']['arrival'];
}

if (isset($_GET['search']['departure'])) {
    $_SESSION['depart'] = $_GET['search']['departure'];
}

$arrival="";
if (!empty($_SESSION['arrival'])) {
    $arrival = date('m/d/Y', strtotime($_SESSION['arrival']));
}
$depart="";
if (!empty($_SESSION['depart'])) {
    $depart = date('m/d/Y', strtotime($_SESSION['depart']));
}

$nights = (strtotime($depart) - strtotime($arrival)) / 86400;

?>
<div id="vrp">
    <div class="vrp-container-fluid unit vrp-col-md-12 vrp-col-sm-12">
	<div class="vrp-col-md-8 vrp-unit-info">
		<div class="vrp-row" id="unit-data"
		     data-unit-id="<?php echo esc_attr( $data->id ); ?>"
		     data-unit-slug="<?php echo esc_attr( $data->page_slug ); ?>"
		     data-unit-address1="<?php echo esc_attr( $data->Address1 ); ?>"
		     data-unit-address2="<?php echo esc_attr( $data->Address2 ); ?>"
		     data-unit-city="<?php echo esc_attr( $data->City ); ?>"
		     data-unit-state="<?php echo esc_attr( $data->State ); ?>"
		     data-unit-zip="<?php echo esc_attr( $data->PostalCode ); ?>"
		     data-unit-latitude="<?php echo esc_attr( $data->lat ); ?>"
		     data-unit-longitude="<?php echo esc_attr( $data->long ); ?>"
		     data-display-pageviews="<?php echo ( isset( $data->pageViews ) ) ? 'true' : 'false'; ?>"
		>
            <div class="vrp-row">
			<div class="vrp-col-md-9 vrp-col-sm-9">
				<div class="vrp-row vrp-pad">
                    <h2 class="unit-name"><?php echo esc_html( $data->Name ); ?></h2>
				</div>
				<div class="vrp-row vrp-pad">
					<?php echo esc_html( $data->Bedrooms ); ?> Bedroom(s) | <?php echo esc_html( $data->Bathrooms ); ?>
					Bathroom(s) | Sleeps <?php echo esc_html( $data->Sleeps ); ?>
				</div>
			</div>
			<div class="vrp-col-md-3 vrp-col-sm-3">
				<div id="vrp-favorite-button" class="vrp-favorite-button" data-unit="<?php echo esc_attr( $data->id ) ?>"></div>
             </div>
            </div>

	<div class="vrp-row">
		<div id="vrp-tabs">
			<ul>
				<li><a href="#overview">Overview</a></li>
				<li><a href="#amenities">Amenities</a></li>
				<?php if ( isset( $data->reviews[0] ) ) { ?>
					<li><a href="#reviews">Reviews</a></li>
				<?php } ?>
				<li><a href="#calendar">Calendar</a></li>
				<li><a href="#rates">Rates</a></li>
				<?php if ( isset( $data->lat ) && isset( $data->long ) ) { ?>
					<li><a href="#gmap" id="gmaplink">Map</a></li>
				<?php } ?>
                <li><a href="#inquire">Inquire</a></li>
                <li class="book-now-tab"><a href="#checkavailbox">Book Now</a></li>
			</ul>

			<!-- OVERVIEW TAB -->
			<div id="overview">
				<div class="vrp-row">
					<div class="vrp-col-md-12">
						<!-- Photo Gallery -->
                        <ul id="vrp-slider">

                            <?php
                            $count = 0;
                            foreach ($data->photos as $k => $v) {
                                ?>
                                <li data-thumb="<?php echo esc_url($v->url); ?>">
                                <img style="width:100%;height:auto;" alt="<?php echo esc_attr( $photo->caption ); ?>"
                                     src="<?php echo esc_url($v->url); ?>">
                                <?php if ( ! empty($photo->caption)) : ?>
                                    <div id="caption_
                                         <?php echo esc_attr($photo->id); ?>" class="caption">
                                        <?php echo esc_html($photo->caption); ?>
                                    </div>
                                <?php endif;?>
                                </li>
                                <?php
                                $count++;
                            } ?>

                        </ul>
                    </div>
						<br style="clear:both;" class="clearfix">
             <div class="vrp-details-wrap">
                <?php if ($data->Area != '' ){ ?><div class="details"><i class="fa fa-map-marker"></i> <?php echo $data->Area ?></div><?php } ?>
                <?php if ($data->Sleeps != '' ){ ?> <div class="details"><i class="fa fa-user picto"></i>Sleeps&nbsp;<?= $data->Sleeps; ?></div><?php } ?>
                <?php if ($data->Bedrooms != '' ){ ?><div class="details"><i class="fa fa-bed picto"></i><?= $data->Bedrooms; ?><?php if ($data->Bedrooms == 1) { ?> Bed<span class="noroom">room</span> <?php } else { ?>&nbsp;Bed<span class="noroom">room</span>s <?php } ?></div><?php } ?>
            </div>
            <br>
				</div>
				<div class="vrp-row vrp-pad">
					<div class="vrp-col-md-12">
						<div id="description">
							<p><?php echo wp_kses_post( nl2br( $data->Description ) ); ?></p>
						</div>
					</div>
				</div>
                </div>
				<div class="clearfix"></div>

            <!-- AMENITIES TAB -->
			<div id="amenities">
                <h3>Amenities</h3>
                <div class="vrp-amen-wrapper">

					<?php foreach ( $data->attributes as $amen ) { ?>

                    <div class="vrp-amen-name">
                            <?php echo esc_html( $amen->name ); ?>
                    </div>

					<?php } ?>
                    </div>
			</div>
            <!-- REVIEWS TAB -->
			<?php if ( isset( $data->reviews[0] ) ) { ?>
				<div id="reviews">
					<section id="reviews">
						<h3>Guest Reviews of
							<span class="fn">
								<?php echo esc_html( strtolower( $data->Name ) ); ?>
							</span>
						</h3>
						<span class="address serif">
							<?php echo esc_html( $data->Address2 ); ?>
							<?php echo esc_html( $data->City ); ?>
							,&nbsp;<?php echo esc_html( $data->State ); ?>
						</span>

                <?php
                $total = 0;
                $rat   = 0;
                foreach ($data->reviews as $v) {
                    $rat += $v->rating;
                    $total ++;
                }
                $av = round($rat / $total, 2);
                ?>

                <div class="hreview-aggregate" style="font-size:11px;">
                    <hr>
                    <div class="review-item vcard">
                        <a href="http://www.flipkey.com/" target="_blank" style="font-size: 1.2em;">Vacation&nbsp;Rental Reviews&nbsp;by <img class="flipkey" style="height: 1.7em; vertical-align: text-top;" src="https://www.flipkey.com/img/marketing/logos/FlipKey-Logo.png"></a>

                        <div style="float:right;text-align:center;" class="serif one-third">
                            <span class="rating"><span class="average"><?= $av; ?></span>&nbsp;out&nbsp;of&nbsp;<span class="best">5</span></span>&nbsp;stars
                            based&nbsp;on
                            <span class="count"><?= $total; ?></span>&nbsp;user&nbsp;reviews
                        </div>
                    </div>
                </div>
            <div>
              
            <div class="review_grid">
                <?php
                    $doneit = 0;
                    $block = 1;
                    foreach ($data->reviews as $review):
                            //Star Rating
                            $stars = "";
                            if ($review->rating != '') {
                                $r = explode(".", $review->rating);
                                $t = 0;
                                for ($i = 0; $i < $r[0]; $i ++) {
                                    $stars .= "<span class='stars_1' style='float:left;'> &nbsp; </span>";
                                    $t ++;
                                    
                                }
                                if (isset($r[1])) {
                                    if ($r[1] == '5') {
                                        $stars .= "<span class='stars_half' style='float:left;'> &nbsp; </span>";
                                        $t ++;
                                       
                                    }
                                }

                                if ($t < 5) {
                                    $d = 5 - $t;
                                    for ($i = 0; $i < $d; $i ++) {
                                        $stars .= "<span class='stars_0' style='float:left;'> &nbsp; </span>";
                                    }
                                }
                            }
                            ?>
                            <?php
                            if ($doneit == 1) {
                                //echo '<hr>';
                            } else {
                                $doneit ++;
                            } ?>
                            <div class="review-post <?php if ( in_array($block, array(1, 3, 6, 9, 12, 15)) ) { echo 'grid-item--width2 first'; } ?>">
                                <div class="hreview">
                                    <h4 class="title" style="margin-bottom:12px;"><?= $review->title; ?></h4>
                                    <div style="float:right;">
                                        <?= $stars; ?>
                                    </div>
                                    <b class="reviewer vcard">Review by <span class="fn"><?= $review->name; ?></span></b>
                                    
                                    <div class="description review-item vcard">
                                        <span class="serif"><?= strip_tags($review->review); ?></span><br>
                                        <b class="rating"><?= $review->rating; ?> out of 5 stars</b>
                                    </div>
                                </div>
                                <?php if ($review->response != '') { ?>
                                    <div class="reviewresponse" style="margin-top:1em;padding-top:1em;border-top:1px solid #dadada;">
                                        <h6 class="title" > Manager Response:</h6>
                                        <?= $review->response; ?>
                                    </div>
                                <?php } ?>
                            </div> <!-- close .review-post -->
                            <?php $block++ ; ?>
                        <?php endforeach; ?>

                </div>

            </div>
       
         </div>
         	<?php } ?>

			<!-- CALENDAR TAB -->
			<div id="calendar">
				<div class="vrp-row">
					<div class="vrp-col-md-12">
						<div id="availability" style="">
							<?php echo wp_kses_post( vrp_calendar( $data->avail ) ); ?>
						</div>
					</div>
				</div>
			</div>
            <!-- RATES TAB -->
			<div id="rates">
				<div class="row">
					<h3> Seasonal Rates </h3>

					<div id="rates">
						<?php

						$rate_seasons = [];
						foreach ( $data->rates as $rate ) {
							$start = date( 'm/d/Y', strtotime( $rate->start_date ) );
							$end   = date( 'm/d/Y', strtotime( $rate->end_date ) );

							if ( empty( $rate_seasons[ $start . ' - ' . $end ] ) ) {
								$rate_seasons[ $start . ' - ' . $end ] = new \stdClass();
							}

							if ( 'Monthly' === $rate->chargebasis ) {
								$rate_seasons[ $start . ' - ' . $end ]->monthly
									= '$' . number_format( $rate->amount, 2 );
							}
							if ( 'Daily' === $rate->chargebasis ) {
								$rate_seasons[ $start . ' - ' . $end ]->daily
									= '$' . number_format( $rate->amount, 2 );
							}
							if ( 'Weekly' === $rate->chargebasis ) {
								$rate_seasons[ $start . ' - ' . $end ]->weekly
									= '$' . number_format( $rate->amount, 2 );
							}
						}
						?>

						<table class="rate">
							<tr class="rate-header">
								<th>Date Range</th>
								<th>Daily</th>
								<th>Weekly</th>
								<th>Monthly</th>
							</tr>
							<?php foreach ( $rate_seasons as $date_range => $rates ) { ?>
								<tr>
									<td><?php echo esc_html( $date_range ); ?></td>
									<td><?php echo ( ! empty( $rates->daily ) ) ? esc_html( $rates->daily ) : 'N/A'; ?></td>
									<td><?php echo ( ! empty( $rates->weekly ) ) ? esc_html( $rates->weekly ) : 'N/A'; ?></td>
									<td><?php echo ( ! empty( $rates->monthly ) ) ? esc_html( $rates->monthly ) : 'N/A'; ?></td>
								</tr>
							<?php } ?>
						</table>
						* Seasonal rates are only estimates and do not reflect taxes or additional fees.
					</div>
				</div>
			</div>
            <!-- MAP TAB -->
			<div id="gmap">
				<div id="map" style="width:100%;height:500px;"></div>
			</div>
            <!-- INQUIRY TAB -->
            <!--Must be set up in the VRP Admin to receive inquiries - see settings tab in VRP ADMIN-->
            <div id="inquire">
                <form id="vrpinquire">
                    <input type="hidden" name="obj[unit_id]" value="<?= $data->id; ?>">
                    <div class="irmform">
                        <h3>Inquire about this property:</h3>
                        <div class="vrp-inquire-field">
                           <label for="Name">Name*</label>
                                <div id="iname">  <input type="text" name="obj[name]"></div></div>
                            <div class="vrp-inquire-field"><label for="Email">Email*</label>
                                <div id="iemail"><input type="text" name="obj[email]"></div></div>
                            <div class="vrp-inquire-field"> <label for="Phone">Phone Number</label>
                                    <div id="iphone" > <input type="text" name="obj[phone]"></div></div>
                            <div class="vrp-inquire-field">
                                    <label for="check-in">Desired Check-In Date*</label>
                                    <div id="icheckin"> <input type="text" name="obj[checkin]" class="datepicker"
                                           value="<?= $_SESSION['arrival']; ?>" id="icheckinput"></div>
                                <div id="inights">
                            <label for="number">Number of Nights*</label>
                                <select name="obj[nights]">
                                       <?php foreach ( range( 3, 30 ) as $v ): ?>
                                            <option value="<?= $v; ?>"><?= $v; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div><div class="vrp-inquire-field">
                                <div id="icomments"> <div>
                                        Comments &amp; Questions: </div>
                                    <textarea id="message" rows="20" cols="50" name="obj[comments]"></textarea></div></div>

                            <input type="submit" value="Submit Inquiry" id="iqbtn" class="vrp-blue">


                </form>
            </div>
		</div>
	</div>
	


</div>
</div>
    </div>



    <div class="vrp-col-md-3 vrp-col-sm-12 vrp-check-avail">
        <div id="checkavailbox" style="text-align: left;">
            <div class="heading-bar">Book Your Stay</div>
            <div id="datespicked" class="booknow-content">
                <form action="<?php echo esc_url(site_url('/vrp/book/step3/', 'https')); ?>" method="get" id="bookingform">
                    <span class="check-avail-field arrive">
                    <label for="checkin"> Check In</label>
                        <div class="date-edit-control">
                          <input type="text" id="check-availability-arrival-date" name="obj[Arrival]"
                                 class="input unitsearch"
                                 value="<?php echo esc_attr($arrival); ?>" placeholder="Check In"> </div></span>
                    <span class="check-avail-field depart">
                        <label for="checkout"> Check Out</label>
                       <div class="date-edit-control">
                           <input type="text" id="check-availability-departure-date" name="obj[Departure]"
                                  class="input unitsearch"
                                  value="<?php echo esc_attr($depart); ?>" placeholder="Check Out"></div></span>
                    <span class="check-avail-field adults"> <label for="adults"> Adults</label>
                        <div>
                            <select id="searchadults"  name="obj[Adults]">
                                <?php foreach (range(1, $data->Sleeps) as $v) {
                                    $sel = "";
                                     if ($adults == $v) {
                                         $sel = "selected=\"selected\"";
                                     }
                                ?>

                                 <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

                                <?php } ?>
                            </select>
                                                    
                                                                                       
                        </div>
                    </span>
                    <span class="check-avail-field children"> <label for="children">Children</label>
                        <div>
                                              
                         <select id="searchchildren"  name="obj[Children]">
                            <?php foreach (range(0, $data->Sleeps) as $v) {
                                $sel = "";
                                if ($children == $v) {
                                    $sel = "selected=\"selected\"";
                                }
                                ?>

                                <option value="<?= $v; ?>" <?= $sel; ?>><?= $v; ?></option>

                                <?php } ?>
                         </select>
                                                    
                        </div>
                    </span>

                    <?php if ( 'Escapia' === $data->manager->Name && ! empty( $data->additonal->PetsPolicy ) ) : ?>
                        <?php // <!-- Escapia PMS ONLY - Booking w/Pets --> ?>
                        <?php if ( 2 === $data->additonal->PetsPolicy ) : ?>
                            <?php $pets_type = 'Dog'; ?>
                        <?php elseif ( 1 === $data->additonal->PetsPolicy ) : ?>
                            <?php $pets_type = 'Cat'; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                        <?php if (!empty($petfee)): ?>
                            <span class="check-avail-field">
                                <div id="petsearch">
                                    <label for="pets">Pets</label>
                                <select name="obj[Pets]">
                                    <option value="">None</option>
                                    <option  value="<?php echo esc_attr( $data->additonal->PetsPolicy ) ?>">
                                        <?php echo esc_attr( $pets_type ) ?>(s)
                                    </option>
                                </select>
                                </div>
                            </span>
                    <?php endif; ?>


                    <?php if ( 'Barefoot' !== $data->manager->Name ) :
                        // Barefoot property management software requires Promo Codes are added during checkout and does not support using them on the initial quote request.
                        // All other PMS do support promo codes during the initial quote request: Escapia, ISILink, RNS, etc.
                        ?>
                        <span class="check-avail-field promo">
                            <div class="packagecode">
                                    <label for="packagecode">Promo Code:</label>
                                <div class="select--borderless">
                                    <span class="input-group">
                                        <input type="text" id="packagecode" name="obj[strPromotionCode]"
                                               class="input unitsearch" value="<?php echo esc_attr($_SESSION['packagecode']); ?>">
                                    </span>
                                </div>
                            </div>
                        </span>
                    <?php endif; ?>

                   <div id="errormsg">
                       <div>
                       </div>
                   </div>
            <div class="ratebreakdown">
                <table id="ratebreakdown" style="width:100%;">
                </table>
            </div>

            <div  class="check-avail-field buttons">
                    <input type="hidden" name="obj[PropID]"
                       value="<?php echo esc_attr($data->id); ?>">
                        <input type="submit" value="Book Now" id="booklink"style="display: none">
                <input type="button" id="checkbutton" class="getratesbtn vrp-blue" value="Get Rates">


            </div>
        </form>
       </div>
    </div>

 </div><!-- close check availability sidebar -->
</div>
</div>