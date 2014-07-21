/*** Preload Images ***/
pinHover = new Image(70, 100);
pinHover.src = "img/pins/pin-glow.png";
pinPlace = new Image(55, 100);
pinPlace.src = "img/pins/pin_placed.png";

var placingPin = false;

// Load HTML content.
$(function(){
	// $("body").load("loginform.php");
});

$(document).ready(function () {

	/*** Topbar properties ***/
	// Position the middle topbar container element and the pushpin icon within it.
	$("#topbar-middle-actions").css('left', ($(window).width() / 2) - ($("#topbar-middle-actions").width() / 2));

	// ---Pushpin properties---
	$("#pushpin-placeholder").width($("#pushpin-container").width());
	$("#pushpin-container").css('left', $("#pushpin-placeholder").offset().left);
	$("#pin-button").hover(
		function(){ $("#pin-button").attr('src', "img/pins/pin-glow.png"); },
		function(){ $("#pin-button").attr('src', "img/pins/pin.png") }
	);

	// Selecting the pushpin
	$("#pin-button").click(function(e){

		if(!placingPin){
			placingPin = true;
			$("#pin-button").css({left: e.pageX - 10, top: e.pageY - ($("#pin-button").height())});
			$("#pin-button").addClass("draggable");

			// Notify the map that a pin cannot be placed.
			enterState_PlacingPin();
		}
	});

	// --Topbar Buttons--
	$("#toggle-sidebar").click(function() { toggleSidebar(); });

	/*** Sidebar properties ***/
	// Resize the sidebar
	$("#sidebar").css('height', $(window).height() - $("#sidebar").position().top);
	toggleSidebar();

	/*** Map properties ***/
	// Resize the map.
	resizeMap();
});

$(window).resize(function () {

	// Position the middle topbar container element and the pushpin icon within it.
	$("#topbar-middle-actions").css('left', ($(window).width() / 2) - ($("#topbar-middle-actions").width() / 2));
	$("#pushpin-container").css('left', $("#pushpin-placeholder").offset().left);

	// Resize the map.
	resizeMap();

	// Resize the sidebar
	$("#sidebar").css('height', $(window).height() - $("#sidebar").position().top);
});

// Dragging the pushpin.
$(document).mousemove(function(e) {

	// Move the pin button
	if(placingPin){
		$("#pin-button").css({left: e.pageX - 10, top: e.pageY - ($("#pin-button").height())});
	}
});

// Placing the pushpin.
$(document).mousedown(function(e) {

	// Place the pin
	if(placingPin){

		// Return the pin to the topbar
		$("#pin-button").removeClass("draggable");
		placingPin = false;

		// Restore the map to its original state.
		enterState_Default();
	}
});

// Adjust the map to fit the window and UI.
function resizeMap() {
	$("#map-wrapper").css('height', $(window).height() - $("#map-wrapper").position().top);
	$("#map-wrapper").css('left', $("#sidebar").position().left + $("#sidebar").width());
	$("#map-wrapper").width($(window).width() - ($("#sidebar").position().left + $("#sidebar").width()));
}

// Toggle the sidebar open or closed.
function toggleSidebar() {

	// Hide the sidebar
	if($("#sidebar").position().left == 0){
		$("#sidebar").css('left', 0 - $("#sidebar").width());
		$("#toggle-sidebar").html("Show List");
	}
	// Restore the sidebar
	else{
		$("#sidebar").css('left', 0);
		$("#toggle-sidebar").html("Hide List");
	}

	// Adjust the map
	resizeMap();
}