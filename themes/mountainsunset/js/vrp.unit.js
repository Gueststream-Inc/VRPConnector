/**
 * Unit Availability Check & Pricing Request/Breakdown
 */
var disabledDays, unitDataSource;

jQuery(document).ready(function () {

    /**
     * JavaScript applied to the unit.php VRPConnector theme file
     */
    unitDataSource = jQuery("#unit-data");

    /**
     * Determine if Unit Page Views module is enabled & log the page view if it is.
     */
    var displayPageViews = unitDataSource.data('display-pageviews');
    var unitId = unitDataSource.data('unit-id');

    if (displayPageViews == "true") {
        jQuery.get(url_paths.site_url, {vrpjax: true, act: "saveUnitPageView", par: unitId, cache: Math.random()});
    }

    jQuery("#checkbutton").click(function () {
        checkAvailability();
    });

    var unitSlug = unitDataSource.data('unit-slug');
    jQuery.get("/?vrpjax=1&act=getUnitBookedDates&par=" + unitSlug, function (data) {
        disabledDays = data;
    });

    var checkAvailArrival, checkAvailDeparture;

    checkAvailArrival = jQuery("#check-availability-arrival-date").datepicker({
        minDate: 0,
        onSelect: function () {
            var minimumDepartureDate = checkAvailArrival.datepicker('getDate');
            minimumDepartureDate.setDate(minimumDepartureDate.getDate() + 1);
            checkAvailDeparture.datepicker('setDate', minimumDepartureDate);
            checkAvailDeparture.datepicker('option', 'minDate', minimumDepartureDate);
        },
        beforeShowDay: noCheckinOrBookedDates
    });

    checkAvailDeparture = jQuery("#check-availability-departure-date").datepicker({
        onSelect: function () {
            //checkAvailability();
        },
        beforeShowDay: noBookedDates
    })

});

function noCheckinOrBookedDates(date) {
    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();

    for (var k = 0; k < disabledDays.noCheckin.length; k++) {
        if (jQuery.inArray((m + 1) + '-' + d + '-' + y, disabledDays.noCheckin) != -1 || new Date() > date) {
            //console.log('bad:  ' + (m + 1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
            return [false];
        }
    }

    return noBookedDates(date);
}

function noBookedDates(date) {
    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
    //console.log('Checking (raw): ' + m + '-' + d + '-' + y);

    for (var i = 0; i < disabledDays.bookedDates.length; i++) {
        if (jQuery.inArray((m + 1) + '-' + d + '-' + y, disabledDays.bookedDates) != -1 || new Date() > date) {
            //console.log('bad:  ' + (m + 1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
            return [false];
        }
    }

    //console.log('good:  ' + (m + 1) + '-' + d + '-' + y);
    return [true];
}

function checkAvailability() {
    jQuery("#errormsg").html('');
    jQuery("#booklink").hide();
    jQuery("#loadingicons").show();
    jQuery("#ratebreakdown").empty();
    jQuery.get("/?vrpjax=1&act=checkavailability&par=1", jQuery("#bookingform").serialize(), function (data) {
        var obj = jQuery.parseJSON(data);

        if (!obj.Error) {
            jQuery("#loadingicons").hide();
            jQuery("#thetotal,#booklink").fadeIn();
            ratebreakdown(obj);
            jQuery("#checkbutton").fadeTo(500, 0.5);
            jQuery(".unitsearch").change(function () {
                //jQuery("#booklink").hide();
                jQuery("#errormsg").html('').hide();
                jQuery("#checkbutton").fadeTo(500, 1);
            });
        } else {
            jQuery("#loadingicons").hide();
            var theerror = '<div class="alert alert-error">' + obj.Error + '</div>';
            jQuery("#errormsg").html(theerror);

        }
    });
}

function ratebreakdown(obj) {
    var tbl = jQuery("#ratebreakdown");
    for (var i in obj.Charges) {
        var row = "<tr><td>" + obj.Charges[i].Description + "</td><td>$" + obj.Charges[i].Amount + "</td></tr>";
        tbl.append(row);
    }
    if (obj.HasInsurance && obj.HasInsurance == 1) {
        var row = "<tr><td>Insurance</td><td>$" + obj.InsuranceAmount + "</td></tr>";
        tbl.append(row);
    }
    var tax = "<tr><td>Tax:</td><td>$" + obj.TotalTax + "</td></tr>";
    var total = "<tr><td><b>Total Cost:</b></td><td><b>$" + obj.TotalCost + "</b></td></tr>";
    var totaldue = "<tr class='success'><td><b>Total Due Now:</b></td><td><b>$" + obj.DueToday + "</b></td></tr>";

    tbl.append(tax);
    tbl.append(total);
    tbl.append(totaldue);

    if(obj.PromoCodeDiscount) {
        var promoCodeDiscount = "<tr><td colspan='2'>" + obj.PromoCodeDiscount.text + "</td></tr>" +
            "<tr><td>Total Savings:</td><td>$" + obj.PromoCodeDiscount.value + "</td></tr>";
        tbl.append(promoCodeDiscount);
    }
}

/**
 * Google Map
 */

function initializeGoogleMap() {
    var geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 13,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var unitLatitude = unitDataSource.data("unit-latitude");
    var unitLongitude = unitDataSource.data("unit-longitude");

    if (unitLatitude && unitLongitude) {
        console.log('lat long');
        /**
         * Latitude & Longitude are present - Use this data for mapping *
         */
        var unitMapPinLocation = new google.maps.LatLng(unitLatitude, unitLongitude);
        map.setCenter(unitMapPinLocation);

        new google.maps.Marker({
            map: map,
            position: unitMapPinLocation
        });
    } else {
        console.log('address');
        /**
         * No lat/long present - Use address for mapping
         */
        var fullUnitAddress = unitDataSource.data("unit-address1")
//                + " " + unitDataSource.data("unit-address2")
            + " " + unitDataSource.data("unit-city")
            + " " + unitDataSource.data("unit-state")
            + " " + unitDataSource.data("unit-zip");
        console.log(fullUnitAddress);

        geocoder.geocode({'address': fullUnitAddress}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            }
        });
    }
}

jQuery(document).ready(function () {
    // Unit Page Tabs
    unitTabs = jQuery("#tabs").tabs();

    // Allow outside links to open tabs
    jQuery('.open-tab').click(function (event) {
        var tab = jQuery(this).attr('href');
        unitTabs.tabs("load", 2);
    });

    // Unit Page photo gallery
    jQuery('#gallery .thumb').click(function () {
        var photoid = jQuery(this).attr('id');
        var showImage = "#vrp-photo-full-" + photoid;
        jQuery("#photo .vrp-photo-container").hide();
        jQuery("#photo " + showImage).show();
    });

    var inquireopen = false;

    jQuery("#inline").click(function () {
        if (inquireopen == false) {
            jQuery("#pinquire").slideDown();
            inquireopen = true;
        } else {
            jQuery("#pinquire").slideUp();
            inquireopen = false;
        }
    });

    jQuery("#vrpinquire").submit(function () {
        jQuery("#iqbtn").attr("disabled", "disabled");
        jQuery.post("/?vrpjax=1&act=custompost&par=addinquiry", jQuery(this).serialize(), function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.success) {
                jQuery("#vrpinquire").replaceWith("Thank you for your inquiry!");
            } else {
                var item;
                var thetotal = obj.err.length - 1;
                for (i = 0; i <= thetotal; i++) {
                    item = obj.err[i];
                    /// alert(item.name);
                    jQuery("#i" + item.name).append("<span class='errormsg'>" + item.msg + "</span>");
                }
                jQuery("#iqbtn").removeAttr("disabled");
            }
        });
        return false;
    });

    jQuery("#gmaplink").on('click', function () {
        initializeGoogleMap();
    });
});
