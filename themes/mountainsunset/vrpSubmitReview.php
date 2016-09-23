<?php
/**
 * [vrpSubmitReview] shortcode VRPConnector Theme File
 *
 * In order to use this shortcode the review module must be enabled in the VRP.
 *
 * @since 1.4.0
 * @var $data['allUnits']
 */
?>
<div id="vrp">

    <p id="vrp-add-review-success" style="display:none;">
        Thank you for submitting your review.  It will be processed shortly!
    </p>

    <form id="vrpSubmitReviewForm">
        <input type="hidden" name="source" value="website" />

        <!-- Property Select -->
        <div class="vrp-col-md-12">
            <label for="unitId">Property you are reviewing</label>
            <select name="prop_id" id="unitId" required="" >
                <option value=""></option>
                <?php foreach ($data['allUnits'] as $unit) : ?>
                    <option value="<?php echo $unit->id;?>"><?php echo $unit->Name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Date of Arrival -->
        <div class="vrp-col-md-12">
            <label for="arrivalDate">Approx. Date of Arrival</label>
            <input type="text" name="checkin_date" id="arrivalDate" required="" readonly/>
        </div>

        <!-- Overall Rating of Property -->
        <div class="vrp-col-md-12">
            Overall Property Rating
            <fieldset>
                <span class="star-cb-group">
                  <input type="radio" id="rating-5" name="rating" value="5"/><label for="rating-5">5</label>
                  <input type="radio" id="rating-4" name="rating" value="4"/><label for="rating-4">4</label>
                  <input type="radio" id="rating-3" name="rating" value="3"/><label for="rating-3">3</label>
                  <input type="radio" id="rating-2" name="rating" value="2"/><label for="rating-2">2</label>
                  <input type="radio" id="rating-1" name="rating" value="1"/><label for="rating-1">1</label>
                  <input type="radio" id="rating-0" name="rating" value="0" class="star-cb-clear"
                         checked="checked" required=""/><label for="rating-0">0</label>
                </span>
            </fieldset>
            <br style="clear:both;"/>
        </div>

        <!-- Review Name -->
        <div class="vrp-col-md-12">
            <label for="reviewName">Title of your review</label>
            <input type="text" name="title" id="reviewName" required="" />
        </div>

        <!-- Review Description -->
        <div class="vrp-col-md-12">
            <label for="review-description">Your review</label>
            <textarea name="review" id="review-description" maxlength="250" required=""></textarea>
            <div class="max-char-notice">(250 Characters Max)</div>
        </div>

        <div class="vrp-col-md-12">
            <h4 class="review-section-header">My Information</h4>
        </div>

        <div class="vrp-col-md-12">
            Email Address <i>(Will not be displayed)</i>
            <input type="email" name="email" required="" />
        </div>

        <div class="vrp-col-md-12">
            Name <i>(Will be displayed)</i>
            <input type="text" name="name" required="" />
        </div>

        <div class="vrp-col-md-12">
            Where I Live <i>(City, State/Region, Country)</i>
            <input type="text" name="location" required="" />
        </div>

        <div class="vrp-col-md-12 review-submit">
            <button type="submit"
                    class="vrp-btn"
                    id="vrp-btn-add-review"
                    data-sending-label="Sending">Submit Review</button>
        </div>

    </form>

</div>