var TWILIO_STATUS;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Wait for the DOM to be fully loaded
$(document).ready(function() {
	initializePhone();

	// Communication form
	var form = $("#communications-form");
	// Cancel button
	var cancel_btn = $("#communications-cancel");

	// On form submit
	form.submit(function(e) {
		// Prevent form to be submited
		e.preventDefault();

		// Get recipient phone number
		var recipient = $("#communications-phone").val();
		// Get message body
		var message = $("#communications-message").val();
		// Get comunication type 'sms' or 'call'
		var type = $("#communications-type").val();

		// If communication type is SMS, sent the message!
		if (type == 'sms') {
			sendSMS(recipient, message);
		}
		// If communication type is Call, make a phone call!
		else if (type == 'call') {
			if (TWILIO_STATUS == 'CONNECTED') {
                alert('hangup');
                hangup();
			}

			else if (TWILIO_STATUS == 'READY' || TWILIO_STATUS == 'DISCONNECTED') {
                alert('ready');
                makeCall(recipient);
			}
		}
	});

	cancel_btn.click(function() {
		// Get comunication type 'sms' or 'call'
		var type = $("#communications-type").val();

		if (type == 'call' && TWILIO_STATUS == 'CONNECTED') {
			hangup();
		}
	});
});

function CommunicationsSave(){
    alert('save');
    var recipient = $("#communications-phone").val();
		// Get message body
	var message = $("#communications-message").val();
		// Get comunication type 'sms' or 'call'
	var type = $("#communications-type").val();

		// If communication type is SMS, sent the message!
	if (type == 'sms') {
	    sendSMS(recipient, message);
	}
		// If communication type is Call, make a phone call!
	else if (type == 'call') {
	    if (TWILIO_STATUS == 'CONNECTED') {
            alert('hangup');
            hangup();
		}
		else if (TWILIO_STATUS == 'READY' || TWILIO_STATUS == 'DISCONNECTED') {
            alert('ready');
            makeCall(recipient);
		}
	}
}

function CommunicationsCancel(){
    alert('cancel');
    var type = $("#communications-type").val();

	if (type == 'call' && TWILIO_STATUS == 'CONNECTED') {
	    hangup();
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to send SMS via Twilio
function sendSMS(recipient, message) {
	// Communicationform element
	var form = $("#communications-form");
	// Save button in communication form
	var save_btn = $("#communications-save");

	// Clear any alert info
	$("#communications-alert").remove();

	// Set button style to indicate sending process
	save_btn.removeClass("btn-primary");
	save_btn.addClass("btn-warning disabled");
	save_btn.html("Sending...");

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Make an AJAX call to send SMS via Twilio
	$.post("./client-communication-sms.php", { recipient: recipient, message: message }).done(function(data) {
		// Parse response data
		var response = $.parseJSON(data);

		// Set button to its normal state
		save_btn.removeClass("btn-warning disabled");
		save_btn.addClass("btn-primary");
		save_btn.html("Save");

		/////////////////////////////////////////////////////////////////////////////////////////////////////
		// If error occured
		if (response.status == 'ERROR') {
			var alert = "<div id='communications-alert' class='alert alert-error'>";
			alert += "<button type='button' class='close' data-dismiss='alert'>×</button>";
			alert += "<strong>Sending Failed!</strong> " + response.detail;
			alert += "</div>";

			form.prepend(alert);
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////////
		// If message successfuly sent
		else if (response.status == 'SUCCESS') {
			var alert = "<div id='communications-alert' class='alert alert-success'>";
			alert += "<button type='button' class='close' data-dismiss='alert'>×</button>";
			alert += "<strong>Message Sent!</strong>";
			alert += "</div>";

			form.prepend(alert);
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to make a phone call via Twilio
function makeCall(recipient) {
	// Clear any alert info displyaed in SMS mode
	$("#communications-alert").remove();
	// Make a call!
	call(recipient);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to initialize and handle Twilio Client event
function initializePhone() {
	// Div object to show Twilio client status
	var twilio_status = $("#twilio-status");
	// Save button
	var save_btn = $("#communications-save");

	// Setup Twilio client
	Twilio.Device.setup(TWILIO_TOKEN);

	// When device is ready
	Twilio.Device.ready(function(device) {
		TWILIO_STATUS = 'READY';
		twilio_status.html("Ready to make a call!");
	});

	// When error is occured
	Twilio.Device.error(function(error) {
		TWILIO_STATUS = 'ERROR';
		twilio_status.html("Error occured: " + error.message);
	});

	// When call is established
	Twilio.Device.connect(function(conn) {
		TWILIO_STATUS = 'CONNECTED';
		twilio_status.html("Successfully established call");

		save_btn.html("Hangup");
		save_btn.removeClass("btn-primary");
		save_btn.addClass("btn-danger");
	});

	// When phone is disconnected
	Twilio.Device.disconnect(function(conn) {
		TWILIO_STATUS = 'DISCONNECTED';
		twilio_status.html("Call ended");

		save_btn.html("Save");
		save_btn.removeClass("btn-warning");
		save_btn.addClass("btn-primary");
	});
}

function call(recipient) {
	params = {"PhoneNumber": recipient};
	Twilio.Device.connect(params);
}

function hangup() {
	Twilio.Device.disconnectAll();
}