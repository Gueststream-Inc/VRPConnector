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
            if (status == google.maps.GeocoderStatus.OK) {
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
            } else {
                console.log('Internal error: ' + status + address)


            }
        });
    }
        function mapAddressL(Lat, Long, address, unitInfo) {
         geocoder.geocode({'address': address}, function (results, status) {
             if (status == google.maps.GeocoderStatus.OK) {
                 bounds.extend(results[0].geometry.location);
               //  var southWest = new google.maps.LatLng(36.90731625763393,-86.51778523864743);
                // var northEast = new google.maps.LatLng(Lat,Long);
              //   var bounds = new google.maps.LatLngBounds(southWest,northEast);


            marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(Lat, Long)
            });

            map.fitBounds(bounds);

            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent(unitInfo);
                    infowindow.open(map, marker);
                }
            })(marker));
             } else {
                 console.log('Internal error: ' + status + address)


             }
        });
    }

    $(document).ready(function () {
        var vrpUnits = $('.vrp-item');

if(vrpUnits.length > 0) {

    jQuery("#vrp-map-view").on('click', function () {
       
        // Only run this if the map div & unit results are present.

        initializeResultListMap();

            vrpUnits.each(function () {
                var that = $(this);
                var unitInfoWindowContent =
                    '<img src="' + that.data('vrp-thumbnail') + '" style="max-width:150px;"> <br />' +
                    '<a href="' + that.data('vrp-url') + '" style="font-weight:bold; font-size:1.2em;">' + that.data('vrp-name') + '</a>';
               if(that.data('vrp-latitude')==""){

                mapAddress(that.data('vrp-address'),unitInfoWindowContent);

                } else {

                mapAddressL(that.data('vrp-latitude'), that.data('vrp-longitude'), that.data('vrp-address'),unitInfoWindowContent);
                }
            });
    });
        }
    });

}(jQuery, window));
