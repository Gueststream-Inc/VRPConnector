<div id="vrp" itemscope itemtype="http://schema.org/Place">
    <div class="vrp-container-fluid">
        <div class="vrp-row" id="unit-data"
             data-unit-id="<?php echo $data->id; ?>"
             data-unit-slug="<?php echo $data->page_slug; ?>"
             data-unit-address1="<?php echo $data->Address1; ?>"
             data-unit-address2="<?php echo $data->Address2; ?>"
             data-unit-city="<?php echo $data->City; ?>"
             data-unit-state="<?php echo $data->State; ?>"
             data-unit-zip="<?php echo $data->PostalCode; ?>"
             data-unit-latitude="<?php echo $data->lat; ?>"
             data-unit-longitude="<?php echo $data->long; ?>"
             data-display-pageviews="<?php echo (isset($data->pageViews)) ? "true" : "false"; ?>"
            >
            <div class="vrp-col-md-9">
                <div class="vrp-row">
                    <span itemprop="name"><?php echo esc_html($data->Name); ?></span>
                </div>
                <div class="vrp-row">
                    <?php echo esc_html($data->Bedrooms); ?> Bedroom(s) | <?php echo esc_html($data->Bathrooms); ?>
                    Bathroom(s) | Sleeps <?php echo esc_html($data->Sleeps); ?>
                </div>
            </div>
            <div class="vrp-col-md-3">
                <button class="vrp-favorite-button vrp-btn" data-unit="<?php echo $data->id ?>"></button>
            </div>
        </div>
    </div>

    <div class="vrp-row">
        <div id="tabs">
            <ul>
                <li><a href="#overview">Overview</a></li>
                <li><a href="#amenities">Amenities</a></li>
                <?php if (isset($data->reviews[0])) { ?>
                    <li><a href="#reviews">Reviews</a></li>
                <?php } ?>
                <li><a href="#calendar">Book</a></li>
                <li><a href="#rates">Rates</a></li>
                <?php if (isset($data->lat) && isset($data->long)) { ?>
                    <li><a href="#gmap" id="gmaplink">Map</a></li>
                <?php } ?>
            </ul>

            <!-- OVERVIEW TAB -->
            <div id="overview">
                <div class="vrp-row">
                    <div class="vrp-col-md-12">
                        <!-- Photo Gallery -->
                        <div id="photo">
                            <?php foreach ($data->photos as $index => $photo) : ?>
                                <?php $style = ($index > 0) ? "display:none;" : ""; ?>
                                <div id="vrp-photo-full-<?php echo $photo->id; ?>"
                                     class="vrp-photo-container"
                                     style="<?php echo esc_attr($style); ?>">
                                    <img alt="<?php echo esc_attr($photo->caption); ?>"
                                         src="<?php echo $photo->url; ?>"
                                         style="width:100%;"/>
                                    <?php if (!empty($photo->caption)) : ?>
                                        <div id="caption_<?php echo $photo->id; ?>" class="caption">
                                            <?php echo esc_html($photo->caption); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div id="gallery">
                            <?php foreach ($data->photos as $photo) : ?>
                                <?php $photo->thumb_url = (empty($photo->thumb_url)) ? $photo->url : $photo->thumb_url; ?>
                                <img class="thumb"
                                     id="<?php echo $photo->id; ?>"
                                     alt="<?php echo esc_attr($photo->caption); ?>"
                                     src="<?php echo $photo->thumb_url; ?>"/>
                            <?php endforeach; ?>
                        </div>
                        <br style="clear:both;" class="clearfix">
                    </div>
                </div>
                <div class="vrp-row">
                    <div class="vrp-col-md-12">
                        <div id="description">
                            <p itemprop="description"><?php echo wp_kses_post(nl2br($data->Description)); ?></p>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div id="amenities">
                <table class="amenTable" cellspacing="0">
                    <tr>
                        <td colspan="2" class="heading"><h4>Amenities</h4></td>
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

            <?php if (!empty($data->reviews)) : ?>
                <?php
                $totalReviews = 0;
                $ratingSum = 0;
                foreach ($data->reviews as $review) {
                    $ratingSum += $review->rating;
                    $totalReviews++;
                }
                $average = round($ratingSum / $totalReviews, 2);
                ?>

                <div id="reviews">
                    <section id="reviews">
                        <div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                            <meta itemprop="worstRating" content = "1"/>
                            <b>Average Rating: </b>
                            <span itemprop="ratingValue"><?php echo $average; ?></span>
                            out of
                            <span itemprop="bestRating">5</span> <br />
                            <b>Based on:</b> <span itemprop="reviewCount"><?php echo $totalReviews; ?></span> review(s)
                        </div>

                        <hr />

                        <?php foreach ($data->reviews as $review): ?>
                            <div class="review-post">
                                <div itemprop="review" itemscope itemtype="http://schema.org/Review">
                                    <h4 class="title" itemprop="name"><?= $review->title; ?></h4>

                                    <?php if (!empty($review->name)) : ?>
                                        <b class="reviewer vcard">Review by </b>
                                        <span itemprop="author">
                                            <?= $review->name; ?>
                                        </span>
                                        <br />
                                    <?php endif; ?>

                                    <?php if (!empty($review->review_date)) : ?>
                                        <b>Published On:</b>
                                        <span itemprop="datePublished" content="<?php echo $review->review_date; ?>">
                                            <?php echo $review->review_date; ?>
                                        </span> <br />
                                    <?php endif; ?>

                                    <b>Rating: </b>
                                    <meta itemprop="worstRating" content = "1"/>
                                    <span itemprop="ratingValue"><?= $review->rating; ?></span>
                                    out of
                                    <span itemprop="bestRating">5</span>
                                    <br />

                                    <span itemprop="description">
                                        <?= strip_tags($review->review); ?>
                                    </span>
                                </div>
                                <?php if (!empty($review->response)) : ?>
                                    <div class="reviewresponse">
                                        <h5 class="title"> Manager Response:</h5>
                                        <?= $review->response; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <hr />
                        <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- CALENDAR TAB -->
            <div id="calendar">
                <div class="vrp-row">
                    <div class="vrp-col-md-12">
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
                                                <input type="text" id="check-availability-arrival-date"
                                                       name="obj[Arrival]"
                                                       class="input unitsearch"
                                                       value="<?php echo esc_attr($_SESSION['arrival']); ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Departure:</td>
                                            <td>
                                                <input type="text" id="check-availability-departure-date"
                                                       name="obj[Departure]"
                                                       class="input unitsearch"
                                                       value="<?php echo esc_attr($_SESSION['depart']); ?>">
                                            </td>
                                        </tr>

                                        <?php if ($data->manager->Name == "Escapia" && !empty($data->additonal->PetsPolicy)) : ?>
                                            <?php //<!-- Escapia PMS ONLY - Booking w/Pets --> ?>
                                            <?php if ($data->additonal->PetsPolicy == 2) : ?>
                                                <?php $petsType = "Dog"; ?>
                                            <?php elseif ($data->additonal->PetsPolicy == 1) : ?>
                                                <?php $petsType = "Cat"; ?>
                                            <?php endif; ?>

                                            <tr>
                                                <td>Pets:</td>
                                                <td>
                                                    <select name="obj[Pets]">
                                                        <option value="">None</option>
                                                        <option
                                                            value="<?= $data->additonal->PetsPolicy ?>"><?= $petsType ?>
                                                            (s)
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        <tr>
                                            <?php // Promo Codes work with Escapia/RNS/Barefoot & ISILink Powered Software ?>
                                            <td>Promo Code</td>
                                            <td>
                                                <input type="text" name="obj[PromoCode]" value=""
                                                       placeholder="Promo Code">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" id="errormsg">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table id="ratebreakdown"></table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="hidden" name="obj[PropID]"
                                                       value="<?php echo esc_attr($data->id); ?>">
                                                <input type="button"
                                                       value="Check Availability"
                                                       class="bookingbutton vrp-btn"
                                                       id="checkbutton">
                                            </td>
                                            <td>
                                                <input type="submit" value="Book Now!"
                                                       id="booklink"
                                                       class="vrp-btn"
                                                       style="display:none;"/>
                                            </td>
                                        </tr>
                                    </table>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="vrp-col-md-12">
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

                        $rateSeasons = [];
                        foreach ($data->rates as $rate) {
                            $start = date("m/d/Y", strtotime($rate->start_date));
                            $end = date("m/d/Y", strtotime($rate->end_date));

                            if (empty($rateSeasons[$start . " - " . $end])) {
                                $rateSeasons[$start . " - " . $end] = new \stdClass();
                            }

                            if ($rate->chargebasis == 'Monthly') {
                                $rateSeasons[$start . " - " . $end]->monthly = "$" . number_format($rate->amount, 2);
                            }
                            if ($rate->chargebasis == 'Daily') {
                                $rateSeasons[$start . " - " . $end]->daily = "$" . number_format($rate->amount, 2);
                            }
                            if ($rate->chargebasis == 'Weekly') {
                                $rateSeasons[$start . " - " . $end]->weekly = "$" . number_format($rate->amount, 2);
                            }
                        }
                        ?>

                        <table class="rate">
                            <tr>
                                <th>Date Range</th>
                                <th>Daily</th>
                                <th>Weekly</th>
                                <th>Monthly</th>
                            </tr>
                            <?php foreach ($rateSeasons as $dateRange => $rates) { ?>
                                <tr>
                                    <td><?php echo $dateRange; ?></td>
                                    <td><?php echo (!empty($rates->daily)) ? $rates->daily : 'N/A'; ?></td>
                                    <td><?php echo (!empty($rates->weekly)) ? $rates->weekly : 'N/A'; ?></td>
                                    <td><?php echo (!empty($rates->monthly)) ? $rates->monthly : 'N/A'; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                        * Seasonal rates are only estimates and do not reflect taxes or additional fees.
                    </div>
                </div>
            </div>

            <div id="gmap">
                <div id="map" style="width:100%;height:500px;"></div>
            </div>

        </div>
    </div>
</div>