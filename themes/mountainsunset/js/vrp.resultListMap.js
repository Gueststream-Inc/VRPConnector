/**
 * Created by houghtelin on 4/14/16.
 */

/**
 * @todo - Pass geocoder & google to function so 'use strict' can work.
 */
(function ($, global, undefined) {

    var map, marker;
    var geocoder = new google.maps.Geocoder();
    var bounds = new google.maps.LatLngBounds();
    var infowindow = new google.maps.InfoWindow();

    function initializeResultListMap() {
        var myOptions = {
            zoom: 13,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("vrp-result-list-map"), myOptions);
    }

    function mapAddress(address,unitInfo) {
        geocoder.geocode({'address': address}, function (results, status) {

            bounds.extend(results[0].geometry.location);
            //map.setCenter(results[0].geometry.location);

            marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });

            map.fitBounds(bounds);

            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent(unitInfo);
                    infowindow.open(map, marker);
                }
            })(marker));
        });
    }

    $(document).ready(function () {
        var vrpUnits = $('.vrp-item');

        if ($('#vrp-result-list-map').length && vrpUnits.length > 0) {
            // Only run this if the map div & unit results are present.
            initializeResultListMap();

            vrpUnits.each(function () {
                var that = $(this);
                var unitInfoWindowContent =
                    '<img src="' + that.data('vrp-thumbnail') + '" style="max-width:150px;"> <br />' +
                    '<a href="' + that.data('vrp-url') + '" style="font-weight:bold; font-size:1.2em;">' + that.data('vrp-name') + '</a>';

                mapAddress(that.data('vrp-address'),unitInfoWindowContent);
            });
        }
    });

}(jQuery, window));
