<?php
// Include the Twilio PHP library
require './integration/twilioservices/Twilio.php';
require './integration/twilioservices/config.php';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Check if recipient and message are already set via POST method
if (!isset($_POST['recipient']) || !isset($_POST['message'])) {
	// If recipient or message field is empty, send error message
	$response = array(
		'status' => 'ERROR',
		'detail' => 'Phone number and message could not be left empty'
	);
	// Encode in JSON, to make it easier in Javascript
	echo json_encode($response);
	die();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get recipient number and message body
$recipient = $_POST['recipient'];
$message = $_POST['message'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Twilio REST API version
$version = TWILIO_API_VERSION;
 
// Set our Account SID and AuthToken
$accountSid = TWILIO_ACCOUNT_SID;
$authToken = TWILIO_AUTH_TOKEN;
     
// Our phone number which has been registered in Twilio
$phonenumber = TWILIO_PHONE_NUMBER;
     
// Instantiate a new Twilio Rest Client
$client = new Services_Twilio($accountSid, $authToken, $version);

// Variable to contain service response message
$response = array();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Try to sent SMS
try { 
	$sms = $client->account->sms_messages->create(
	    $phonenumber, 	// Sender, our Twilio number
	    $recipient, 	// Recipient number
	    $message,		// Our message
	    array()			// Optional parameters
	);

	// If SMS successfuly created
	$response['status'] = 'SUCCESS';
	$response['detail'] = $sms->sid;

} 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// If error occured
catch (Services_Twilio_RestException $e) {
    $response['status'] = 'ERROR';
	$response['detail'] = $e->getMessage();
}

// Output response
echo json_encode($response);
?>