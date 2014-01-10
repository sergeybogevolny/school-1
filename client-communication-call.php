<?php
// Include the Twilio PHP library
require './integration/twilioservices/Twilio/Capability.php';
require './integration/twilioservices/config.php';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Twilio REST API version
$version = TWILIO_API_VERSION;
 
// Set our Account SID and AuthToken
$accountSid = TWILIO_ACCOUNT_SID;
$authToken = TWILIO_AUTH_TOKEN;
// Our Twilio client application SID
$appSid = TWILIO_APP_SID;
     
$capability = new Services_Twilio_Capability($accountSid, $authToken);
$capability->allowClientOutgoing($appSid);
$twilio_token = $capability->generateToken();
?>