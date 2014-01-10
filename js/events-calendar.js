// WAIT FOR THE DOM TO BE FULLY LOADED
$(document).ready(function() {
	// Our DIV element that contains our calendar
	var myCalendar = $(".calendar");

	// If DIV element for showing calendar is available, procceed! 
	if (myCalendar.length > 0) {	
		myCalendar.fullCalendar({
			// Defines the buttons and title at the top of the calendar
			header: {
				left: '',
				center: 'prev,title,next',
				right: ''
			},

			// Load events as JSON feed
			events: 'events-calendar-feed.php'
		});

		// Remove those glosy effect on button
		$(".fc-button-effect").remove();
		// Replace next button image
		$(".fc-button-next .fc-button-content").html("<i class='icon-chevron-right'></i>");
		// Replace prev button image
		$(".fc-button-prev .fc-button-content").html("<i class='icon-chevron-left'></i>");
	}
});