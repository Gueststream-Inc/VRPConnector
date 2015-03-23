;VRP.map = (function($, global, undefined){

    var geocoder;

    $(function(){

        geocoder = new google.maps.Geocoder();

    });

    var generateMap = function(geometryLocation, el) {

        var map, mapOptions;

        mapOptions = Object.create({
            zoom: 6,
            center: new global.google.maps.LatLng(geometryLocation.k, geometryLocation.D)
        });

        map = new global.google.maps.Map(el[0], mapOptions);

        //map.setCenter(geometryLocation);

        var marker = new google.maps.Marker({
            map: map,
            position: geometryLocation
        });

        el.data('vrp-processed', true);

    }

    var geocodeAddress = function(address, callback) {

        geocoder.geocode({'address': address}, function (results, status) {

            if (status != google.maps.GeocoderStatus.OK) {
                return false;
            }

            return callback(results);

        });

    }

    return {
        "processed" : function(index) {
            var listing = $('.vrp-item').get(index),
                listingMapProcessed = $(listing).data('vrp-processed');

            return listingMapProcessed;
        },

        "generate" : function(el, callback) {
            var address = el.data('vrp-address');
            //console.log(markers);
            var bool = geocodeAddress(address, function(result) {
                if(result !== false) {
                    generateMap(result[0].geometry.location, el.find('.vrp-overlay-map-container'));
                    return true;
                } else {
                    return false;
                }
            });

            callback(bool);
        }
        //returnPrivate: private()
    }

}(jQuery, window));