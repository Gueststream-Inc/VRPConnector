;var VRP = Object.create(null);

VRP.map = (function($, global, undefined){

    $(function(){

        var map;

        var mapOptions = {
            zoom: 8,
            center: new global.google.maps.LatLng(-34.397, 150.644)
        };

        map = new global.google.maps.Map(document.getElementById('vrp-map-canvas'), mapOptions);

    });

    return {
        //returnPrivate: private()
    }

}(jQuery, window));