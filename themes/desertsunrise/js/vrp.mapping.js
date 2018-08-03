jQuery(document).ready(function(){
	var map;
	var mapOptions;
	var units = [];
	
	/* typesToShow variable is used to show only specific category on map
	var typesToShow; for all categories */
	var typesToShow = ['Villa'];
	var markers = [];

	jQuery.getJSON('/?vrpjax=1&act=customcall&par=loadmap', function(locations){

		if (typesToShow != undefined) {

			for (var i = 0; i < locations.length; i++) {

				if ( jQuery.inArray(locations[i].cat, typesToShow) != -1 ) {
					units.push(locations[i]);
				}
			}

		} else {
			units = locations;
		}

		initialize(units);

	});
});

function initialize(units) {
	mapOptions = {
		zoom : 12,
		center : new google.maps.LatLng(19.3221698, -81.2408689),
		mapTypeId : google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

	setMarkers(map, units);
}

var markers = [];

function setMarkers(map, units, image) {
	var infoWindow = new google.maps.InfoWindow({
		content : "Content"
	});

	for (var i = 0; i < units.length; i++) {

		var unit = units[i];
		var hasImage = false;

		if (unit.pointer != '') {
			hasImage = true;
			var image = new google.maps.MarkerImage(unit.pointer, null, null, null);
		}

		var myLatLng = new google.maps.LatLng(unit.lat, unit.lng);
		var unitImage = "<img src='" + unit.image + "'class='vrpMapImage'/>";
		var unitImageWrapper;
		var unitLink = unit.link;

		if (unitLink != '') {

			unitImageWrapper = "<div class='vrpMapImageWrapepr'><div><a class='vrpMapImageLink' href='" 
			+ unitLink + "' target='_top'><b>" + unit.name + "</b></a><br></div><div><a href='" 
			+ unitLink + "' target='_top'>" + unitImage + "</a></div></div>";

		} else {

			unitImageWrapper = unitImage + "<b>" + unit.name + "</b><br>";

		}

		var infoWindowContent = unitImageWrapper + unit.content + "<br style='clear:both;'>";

		if (hasImage) {
			var marker = new google.maps.Marker({
	            position : myLatLng,
	            map : map,
	            mapID :unit.id,
	            icon : image,
	            title : unit.name,
	            zIndex : 1,
	            html : infoWindowContent,
	            category : unit.cat
        	});

			console.log(image);

		} else {
			var marker = new google.maps.Marker({
	            position : myLatLng,
	            map : map,
	            title : unit.name,
	            zIndex : 1,
	            html : infoWindowContent,
	            category : unit.cat
	        });
		}

		markers[i] = marker;

		google.maps.event.addListener(marker, 'mouseover', function () {
	        // where I have added .html to the marker object.
	        infoWindow.setContent(this.html);
	        infoWindow.open(map, this);

	        var iwOuter = jQuery('.gm-style-iw');
	        var iwBackground = iwOuter.prev();

	        // Add background to left half of the arrow
	        iwBackground.children(':nth-child(3)').children(':nth-child(1)').children(':nth-child(1)').addClass('gm-arrow');
	        
	        // Add background to left half of the arrow
	        iwBackground.children(':nth-child(3)').children(':nth-child(2)').children(':nth-child(1)').addClass('gm-arrow');

	        // Add fixed width and haight to InfoWindows
	        iwBackground.children(':nth-child(4)').addClass('gm-fixed-size-window');
	    });

	    google.maps.event.addListener(marker, 'click', function () {
	        // where I have added .html to the marker object.
	        infoWindow.setContent(this.html);
	        infoWindow.open(map, this);

	        var iwOuter = jQuery('.gm-style-iw');
	        var iwBackground = iwOuter.prev();

	        // Add background to left half of the arrow
	        iwBackground.children(':nth-child(3)').children(':nth-child(1)').children(':nth-child(1)').addClass('gm-arrow');
	        
	        // Add background to left half of the arrow
	        iwBackground.children(':nth-child(3)').children(':nth-child(2)').children(':nth-child(1)').addClass('gm-arrow');

	        // Add fixed width and haight to InfoWindows
	        iwBackground.children(':nth-child(4)').addClass('gm-fixed-size-window');
	    });

	}
}

// Added LatLngBounds
var bounds = new google.maps.LatLngBounds();

// Creates the box layer using coordinates
var firstB = new google.maps.LatLng(19.401926, -81.419935);
var secondB = new google.maps.LatLng(19.271159, -81.076931);
bounds.extend(firstB);
bounds.extend(secondB);

google.maps.event.addDomListener(window, 'resize', function() {
	var center = map.getCenter();
	google.maps.event.trigger(map, "resize");
	map.setCenter(center);
	// Fitting the layer to window resize
	map.fitBounds(bounds);
});
