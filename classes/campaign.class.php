<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Campaign extends Generic {


    function __construct() {

	}


	/////////////////////////////////////////////////////////////////sendtext
	public function send_text($phone,$message ){
	
		$version     = TWILIO_API_VERSION;
		$sid         = TWILIO_ACCOUNT_SID;
		$token       = TWILIO_AUTH_TOKEN;
		$phonenumber = TWILIO_PHONE_NUMBER;
		$client = new Services_Twilio($sid, $token , $version);
		$client->account->sms_messages->create($phonenumber,$phone,$message);
	
	}
	
	
	public function send_text2($sendtext){
		$version     = TWILIO_API_VERSION;
		$sid         = TWILIO_ACCOUNT_SID;
		$token       = TWILIO_AUTH_TOKEN;
		$phonenumber = TWILIO_PHONE_NUMBER;
		$client = new Services_Twilio($sid, $token , $version);
	
		try{
			if(!empty($sendtext))
			foreach($sendtext as $texta){
				$client->account->sms_messages->create($phonenumber,$texta['phone'],$texta['text']);
			}
		  }catch (Exception $e) {
				echo '<pre> ' . $e;
		  }
	}
	
	
	///////////////////////////////////////////////////////////////sendemail
	
	public function send_email($sendemail){
		    
			if(!empty($sendemail))
			foreach($sendemail as $aemail){
				$email   = $aemail['email'] ;
				$subject = $aemail['subject'];
				$message = $aemail['text'];
				
				//mail($email, $subject, $message);
		   }
			
	}
	
	//////////////////////////////////////////////////////////////sendautocall
	
	public function send_autocall($sendcall){
	
		$version     = TWILIO_API_VERSION;
		$sid         = TWILIO_ACCOUNT_SID;
		$token       = TWILIO_AUTH_TOKEN;
		$phonenumber = TWILIO_PHONE_NUMBER;
		$client = new Services_Twilio($sid, $token, $version);
	
		    if(!empty($sendcall))
			foreach($sendcall as $acall){
				$phone = $acall['phone'];
				$message = $acall['text'];
				$messageUrl = 'http://www.nwareindia.com/voicecall/campaign.php?message=' . urlencode($message);
				$call = $client->account->calls->create(
						$phonenumber,
						$phone,
						$messageUrl
						);
			}
		
	}
	

}

$campaign = new Campaign();

?>