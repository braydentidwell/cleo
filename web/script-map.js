var map;

// Run the initialize function for the map on window load.
google.maps.event.addDomListener(window, 'load', initialize);

// Map initialize function
function initialize(){

	var mapOptions = {
		center: new google.maps.LatLng(-34.397, 150.644),
		zoom: 8
	};

	map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
}

// Restore the map to its default state.
function enterState_Default(){
	google.maps.event.clearListeners(map, 'mousedown');
	map.setOptions({ draggableCursor: null});
}

// Change to 'placing pin' state.
function enterState_PlacingPin(){

	// Do nothing.
	if(!placingPin) return;

	map.setOptions({ draggableCursor: 'pointer' });

	// On click, place a pin on the map.
	google.maps.event.addListener(map, 'mousedown', function(event) {

		// Center the map on the selected area.
		map.setCenter(event.latLng);

		// Place a new pin on the map.
		placePin(event.latLng);

		// Restore the map to its default state.
		enterState_Default();
	});
}

// Place a pin on the map at lat/lng 'loc'
function placePin(loc){

	// Create a new pin at the location provided.
	var pin = new google.maps.Marker({
		position: loc,
		map: map,
		title: "New Story",
		icon: "img/pins/pin_placed.png"
	});
}