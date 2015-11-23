<?php
if (!isset($_SESSION['arrival'])) {
    $_SESSION['arrival'] = '';
}
if (!isset($_SESSION['depart'])) {
    $_SESSION['depart'] = '';
}
?>
<div class="" id="vrp">
    <div class="vrp-row">
        <div class="vrp-col-md-12">
            <?php echo esc_html($data->Name); ?>
        </div>
    </div>

    <div class="vrp-row" style="text-align:center">
        <div class="vrp-col-md-2">
            <a href="#overview">Overview</a>
        </div>
        <div class="vrp-col-md-2">
            <a href="#map">Map</a>
        </div>
        <div class="vrp-col-md-2">
            <a href="#availability">Availability</a>
        </div>
        <div class="vrp-col-md-2">
            <a href="#amenities">Amenities</a>
        </div>
        <div class="vrp-col-md-2">
            <a href="#reviews">Reviews</a>
        </div>
    </div>

    <div class="vrp-row">
        <!-- OVERVIEW TAB -->
        <a name="overview"></a>

        <div id="overview">
            <div class="row">
                <div class="col-md-12">
                    <!-- Photo Gallery -->
                    <div id="photo">
                        <?php
                        $count = 0;
                        foreach ($data->photos as $k => $v) {
                            $style = "";
                            if ($count > 0) {
                                $style = "display:none;";
                            }
                            ?>
                            <img id="full<?php echo esc_attr($v->id); ?>"
                                 alt="<?php echo esc_attr($v->caption); ?>"
                                 src="<?php echo $v->url; ?>"
                                 style="width:100%; <?php echo esc_attr($style); ?>"/>
                            <?php
                            $count++;
                        }
                        ?>
                    </div>

                    <div id="gallery">
                        <?php foreach ($data->photos as $k => $v) : ?>
                            <?php $v->thumb_url = $v->url; ?>
                            <img class="thumb"
                                 id="<?php echo esc_attr($v->id); ?>"
                                 alt="<?php echo esc_attr($v->caption); ?>"
                                 src="<?php echo $v->thumb_url; ?>"
                                 style="height:60px; float:left; margin: 3px;"/>
                        <?php endforeach; ?>
                    </div>
                    <br style="clear:both;" class="clearfix">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                        <?php echo esc_html($data->Bedrooms); ?> Bedroom(s) /
                        <?php echo esc_html($data->Bathrooms); ?> Bathroom(s) /
                        Sleeps <?php echo esc_html($data->Sleeps); ?>
                </div>
                <div class="col-md-12">
                    <div id="description">
                        <p><?php echo wp_kses_post(nl2br($data->Description)); ?></p>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div id="amenities">
            <table class="amenTable" cellspacing="0">
                <tr>
                    <td colspan="2" class="heading">
                        <h4>Amenities</h4>
                    </td>
                </tr>
                <?php foreach ($data->attributes as $amen) { ?>
                    <tr>
                        <td class="first">
                            <b><?php echo esc_html($amen->name); ?></b>:
                        </td>
                        <td> <?php echo esc_html($amen->value); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- CALENDAR TAB -->
        <div id="calendar">
            <div class="row">
                <div class="col-md-6">
                    <div id="checkavailbox">
                        <h1 class="bookheading">Book Your Stay!</h1><br>

                        <div id="datespicked">
                            Select your arrival and departure dates below to reserve this unit.<br><br>

                            <form action="<?php echo esc_url(site_url('/vrp/book/step3/', 'https')); ?>"
                                  method="get" id="bookingform">

                                <table align="center" width="96%">
                                    <tr>
                                        <td width="40%">Arrival:</td>
                                        <td>
                                            <input type="text" id="arrival2" name="obj[Arrival]"
                                                   class="input unitsearch"
                                                   value="<?php echo esc_attr($_SESSION['arrival']); ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Departure:</td>
                                        <td>
                                            <input type="text" id="depart2" name="obj[Departure]"
                                                   class="input unitsearch"
                                                   value="<?php echo esc_attr($_SESSION['depart']); ?>">
                                        </td>
                                    </tr>
                                    <tr id="errormsg">
                                        <td colspan="2">
                                            <div></div>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div id="ratebreakdown"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="hidden" name="obj[PropID]"
                                                   value="<?php echo esc_attr($data->id); ?>">
                                            <input type="button" value="Check Availability"
                                                   class="bookingbutton rounded" id="checkbutton">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="2">
                                            <input type="submit" value="Book Now!" id="booklink" class=""
                                                   style="display:none;"/>
                                        </td>
                                    </tr>
                                </table>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div id="availability" style="">
                        <?php echo wp_kses_post(vrpCalendar($data->avail)); ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="rates">
            <div class="row">
                <h3>Seasonal Rates</h3>

                <div id="rates">
                    <?php
                    $r = [];
                    foreach ($data->rates as $v) {
                        $start = date("m/d/Y", strtotime($v->start_date));
                        $end = date("m/d/Y", strtotime($v->end_date));
                        $r[$start . " - " . $end] = new \stdClass();

                        if ($v->chargebasis == 'Monthly') {
                            $r[$start . " - " . $end]->monthly = "$" . $v->amount;
                        }
                        if ($v->chargebasis == 'Daily') {
                            $r[$start . " - " . $end]->daily = "$" . $v->amount;
                        }
                        if ($v->chargebasis == 'Weekly') {
                            $r[$start . " - " . $end]->weekly = "$" . $v->amount;
                        }
                    }
                    ?>

                    <table cellpadding="3">
                        <tr>
                            <th>Date Range</th>
                            <th>Rate</th>
                        </tr>
                        <?php
                        foreach ($r as $k => $v) {
                            if (isset($v->daily)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo esc_html($k); ?>
                                    </td>
                                    <td><?php echo esc_html($v->daily); ?>/nt</td>
                                </tr>
                            <?php }
                        } ?>
                    </table>
                    * Seasonal rates are only estimates and do not reflect taxes or additional fees.
                </div>
            </div>
        </div>

        <!-- MAP -->
        <div id="gmap">
            <div id="map" style="width:100%;height:500px;"></div>
        </div>

        <!-- REVIEWS -->
        <div id="reviews" class="vrp-row">
            <?php if (isset($data->reviews[0])) { ?>
                <?php foreach ($data->reviews as $review) : ?>
                    <?php $review->review_date_obj = new \DateTime($review->review_date); ?>
                    <div class="vrp-row" itemscope itemtype="http://schema.org/Review">
                        <div class="vrp-row title-row">
                            <div class="vrp-col-md-12">
                                    <span itemprop="headline" class="review-title">
                                        <?php echo $review->title; ?>
                                    </span>
                                    <span class="review-author" itemprop="author">
                                        by <?php echo $review->name; ?>
                                    </span>
                            </div>
                        </div>
                        <div class="vrp-row rating-row">
                            <div class="vrp-col-md-6" itemscope itemtype="http://scema.org/Rating">
                                <span itemprop="worstRating" style="display:none;">1</span>
                                    <span itemprop="ratingValue"
                                          style="display:none;"><?php echo $review->rating; ?></span>
                                <span itemprop="bestRating" style="display:none;">5</span>
                                Rating:
                                <?php foreach (range(1, $review->rating) as $star) : ?>
                                    <i class="fa fa-star"></i>
                                <?php endforeach; ?>
                            </div>
                            <div class="vrp-col-md-6 text-right">
                                Review Date:
                                    <span
                                        itemprop="dateCreated"><?php echo $review->review_date_obj->format('m/d/Y'); ?></span>
                            </div>
                        </div>
                        <div class="vrp-row">
                            <div class="vrp-col-md-12">
                                <p><span itemprop="reviewBody"><?php echo $review->review; ?></span></p>
                            </div>
                        </div>
                        <?php if (strlen($review->response) > 0) : ?>
                            <div class="vrp-row">
                                <div class="vrp-md-8 vrp-col-md-offset-2  manager-response">
                                    <div class="vrp-row">
                                        <div class="vrp-col-md-12">
                                            <strong>Managers Response: </strong>
                                        </div>
                                    </div>
                                    <div class="vrp-row">
                                        <div class="vrp-col-md-12">
                                            <p><?php echo $review->response; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php } ?>

            <button id="vrp-show-review-form">Review This Property</button>

            <p id="vrp-add-review-success" style="display:none;">Thank you for submitting your review.  It will be processed shortly!</p>

            <form id="vrp-add-review-form" style="display:none;">
                <input type="hidden" name="source" value="website">
                <input type="hidden" name="prop_id" value="<?= $data->id; ?>">

                <div class="flex_column av_one_third first">
                    <p class="first_form form_element form_fullwidth">
                        <label for="review_title">Title <abbr class="required" title="required">*</abbr></label>
                        <input id="review_title" name="title" class="text_input is_empty" type="text" data-mini="true" required="" pattern="[a-zA-Z0-9_- ]+" style="">
                    </p>
                </div>
                <div class="flex_column av_one_third">
                    <p class="first_form form_element form_fullwidth">
                        <label for="review_display_name">Guests Name <abbr class="required" title="required">*</abbr></label>
                        <input id="review_display_name" name="name" class="text_input is_empty" type="text" data-mini="true" required="" pattern="[a-zA-Z0-9_- ]+">
                    </p>
                </div>

                <div class="flex_column av_one_full">
                    <p class="first_form form_element form_fullwidth">
                        <label for="review_guest_email">Email Address <abbr class="required" title="required">*</abbr></label>
                        <input id="review_guest_email" name="email" class="text_input is_empty" type="email" data-mini="true" required="" style="">
                    </p>
                </div>

                <div class="flex_column av_one_third first">
                    <p class="first_form form_element form_fullwidth">
                        <label for="review_check_in">Check In Date <abbr class="required" title="required">*</abbr></label>
                        <input id="review_check_in" name="checkin_date" data-mini="true" type="text" required="" pattern="^(((0?[1-9]|1[012])/(0?[1-9]|1\d|2[0-8])|(0?[13456789]|1[012])/(29|30)|(0?[13578]|1[02])/31)/(19|[2-9]\d)\d{2}|0?2/29/((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$">
                    </p>
                </div>
                <div class="flex_column av_one_third">
                    <p class="first_form form_element form_fullwidth">
                        <label for="review_nights">Nights Stayed</label>
                        <input id="review_nights" name="nights" data-mini="true" type="text">
                    </p>
                </div>

                <div class="flex_column av_one_full">
                    <p class="first_form form_element form_fullwidth">
                        <label for="review_rating">Your Rating</label>
                        <select id="review_rating" name="rating">
                            <option value="0" selected="selected">Select Rating</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                    </p>
                </div>

                <p class="first_form form_element form_fullwidth" style="clear: both; margin-top: 1em;">
                    <label for="review_review" class="textare_label">Message <abbr class="required" title="required">*</abbr></label>
                    <textarea id="review_review" name="review" class="text_area is_empty" cols="40" rows="7" data-mini="true" required="" pattern="[a-zA-Z]+"></textarea>
                    <small class="error">Review is required</small>
                </p>

                <p class="form_element">
                    <input id="vrp-btn-add-review"
                           type="submit"
                           value="Submit"
                           class="button"
                           data-sending-label="Sending">
                </p>

            </form>
        </div>

    </div>
</div>


<!-- GOOGLE MAPS SCRIPT -->

<script type="text/javascript">
    var geocoder, map, value = "<?php echo esc_attr( $data->id ); ?>", image = '<?php bloginfo( 'template_directory' ); ?>/images/mapicon.png';

    function initialize() {
        geocoder = new google.maps.Geocoder();
        var myOptions = {
            zoom: 13,
            <?php if ( strlen( $data->lat ) > 0 && strlen( $data->long ) > 0 ) { ?>
            center: new google.maps.LatLng(<?php echo esc_js( $data->lat ); ?>, <?php echo esc_js( $data->long ); ?>),
            <?php } ?>
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map"), myOptions);
        <?php if ( strlen( $data->lat ) == 0 || strlen( $data->long ) == 0 ) { ?>
        codeAddress();
        <?php } ?>
    }

    function codeAddress() {
        var query = "<?php echo esc_js( $data->Address1 ) . " " . esc_js( $data->Address2 ) . " " . esc_js( $data->City ) . " " . esc_js( $data->State ) . " " . esc_js( $data->PostalCode ); ?>";
        var address = query;
        geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        //icon: image
                    });
                } else {
                    //alert("Geocode was not successful for the following reason: " + status);
                }
            }
        );
    }

    initialize();

</script>

