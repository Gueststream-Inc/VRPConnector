<?php
/**
 * [vrpSubmitReview] shortcode VRPConnector Theme File
 *
 * @injected $data['allUnits']
 */
?>
<style>

    .star-cb-group {
        font-size: 0;
        unicode-bidi: bidi-override;
        direction: rtl;
    }

    .star-cb-group * {
        font-size: 4rem;
    }

    .star-cb-group > input {
        display: none;
    }

    .star-cb-group > input + label {
        display: inline-block;
        overflow: hidden;
        text-indent: 9999px;
        width: 1em;
        white-space: nowrap;
        cursor: pointer;
    }

    .star-cb-group > input + label:before {
        display: inline-block;
        text-indent: -9999px;
        content: "☆";
        color: #888;
    }

    .star-cb-group > input:checked ~ label:before, .star-cb-group > input + label:hover ~ label:before, .star-cb-group > input + label:hover:before {
        content: "★";
        color: #e52;
        text-shadow: 0 0 1px #333;
    }

    .star-cb-group > .star-cb-clear + label {
        text-indent: -9999px;
        width: .5em;
        margin-left: -.5em;
    }

    .star-cb-group > .star-cb-clear + label:before {
        width: .5em;
    }

    .star-cb-group:hover > input + label:before {
        content: "☆";
        color: #888;
        text-shadow: none;
    }

    .star-cb-group:hover > input + label:hover ~ label:before, .star-cb-group:hover > input + label:hover:before {
        content: "★";
        color: #e52;
        text-shadow: 0 0 1px #333;
    }

    #vrpSubmitReviewForm fieldset {
        padding: 0;
        margin: 0;
        border: 0;
    }

    .custom-combobox {
        position: relative;
        display: inline-block;
    }

    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }

    .custom-combobox-input {
        margin: 0;
        padding: 5px 10px;
    }

    #vrpSubmitReviewForm i {
        color: #676767;
    }

    #vrpSubmitReviewForm h4.review-section-header {
        margin:20px 0 10px 0;
        border-top: 1px dashed #676767;
        padding-top: 10px;
    }

    #vrpSubmitReviewForm #review-description {
        min-height:125px;
    }

    #vrpSubmitReviewForm .max-char-notice {
        text-align: right;
        font-size: .7em;
    }

    #vrpSubmitReviewForm .review-submit {
        text-align: right;
        padding: 5px;
    }
</style>

<div id="vrp">

    <p id="vrp-add-review-success" style="display:none;">Thank you for submitting your review.  It will be processed shortly!</p>

    <form id="vrpSubmitReviewForm">
        <input type="hidden" name="source" value="website" />

        <!-- Property Select -->
        <div class="vrp-col-md-6">
            <label for="unitId">Property you are reviewing</label>
            <select name="prop_id" id="unitId" required="" >
                <option value=""></option>
                <?php foreach ($data['allUnits'] as $unit) : ?>
                    <option value="<?php echo $unit->id;?>"><?php echo $unit->Name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Date of Arrival -->
        <div class="vrp-col-md-6">
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


<script>
    (function ($) {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                    .addClass("custom-combobox")
                    .insertAfter(this.element);

                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function () {
                var selected = this.element.children(":selected"),
                    value = selected.val() ? selected.text() : "";

                this.input = $("<input>")
                    .appendTo(this.wrapper)
                    .val(value)
                    .attr("title", "")
                    .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: $.proxy(this, "_source")
                    })
                    .tooltip({
                        tooltipClass: "ui-state-highlight"
                    });

                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function () {
                var input = this.input,
                    wasOpen = false;

                $("<a>")
                    .attr("tabIndex", -1)
                    .attr("title", "Show All Properties")
                    .tooltip()
                    .appendTo(this.wrapper)
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass("ui-corner-all")
                    .addClass("custom-combobox-toggle ui-corner-right")
                    .mousedown(function () {
                        wasOpen = input.autocomplete("widget").is(":visible");
                    })
                    .click(function () {
                        input.focus();

                        // Close if already visible
                        if (wasOpen) {
                            return;
                        }

                        // Pass empty string as value to search for, displaying all results
                        input.autocomplete("search", "");
                    });
            },

            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && ( !request.term || matcher.test(text) ))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },

            _removeIfInvalid: function (event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                    .val("")
                    .attr("title", value + " didn't match any item")
                    .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },

            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);

    (function ($) {
        // Autocomplete Property Selection
        $("#unitId").combobox();
        $("#toggle").click(function () {
            $("#unitId").toggle();
        });

        // Arrival Date
        $("#arrivalDate").datepicker({});

        // Star Rating
        var logID = 'log',
            log = $('<div id="' + logID + '"></div>');
        $('body').append(log);
        $('[type*="radio"]').change(function () {
            var me = $(this);
            log.html(me.attr('value'));
        });

        jQuery(document).ready(function () {
            jQuery('#review_check_in').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            jQuery("#vrpSubmitReviewForm").submit(function(event){
                event.preventDefault();
                jQuery("#vrp-btn-add-review").attr("disabled","disabled");
                jQuery.post(url_paths.site_url + "/?vrpjax=1&act=addReview",jQuery(this).serialize(),function(response) {
                    if(response.success == true) {
                        jQuery("#vrp-add-review-success").show();
                        jQuery("#vrpSubmitReviewForm").hide();
                    }
                    if(response.success == false) {
                        response.errors.forEach(function (element, index, array) {
                            alert(element);
                        });
                        jQuery("#vrp-btn-add-review").attr("disabled",false);
                    }
                    console.log(response);
                });
                return false;
            });
        });

    })(jQuery);


</script>