<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Reports extends Generic {

	private $options = array();

    function __construct() {
		
		if(!empty($_GET['value'])) $this->grab();
		if(!empty($_GET['send'])) $this->sendCompaign();
		

	}

    private function grab() {
		global $generic;
		$sql = "SELECT
				general_bonds.executeddate,
				general_bonds.`name`,
				general_bonds.amount,
				general_powers.prefix,
				general_powers.serial,
				general_bonds.disposeddate
				FROM
				general_bonds
				INNER JOIN general_powers ON general_bonds.power_id = general_powers.id
				WHERE general_bonds.disposeddate IS NOT NULL ";
		
				
				$query = $generic->query($sql);
				
				$rcount = $query->rowCount();
				if( $rcount < 1 ) {
					echo '<h5 id="error">No records found</h5>';
				} else if( $rcount > 1000 ) {
					echo '<h5 id="error">Records found exceeds limit</h5>';
				} else {
					
					while($row1 = $query->fetch(PDO::FETCH_ASSOC)){
						
						$arr[] = array(
							'executed'  	 => $row1['executeddate'],
							'defendant'      => $row1['name'],
							'amount'		 => $row1['amount'],
							'prefix' 		 => $row1['prefix'],
							'serial'	     => $row1['serial'],
							'disposedate'    => $row1['disposeddate'],
							);
				  }
				 
				 echo json_encode($arr);
				}
		
	
	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}


    private function getName($id) {
		$sql = "SELECT name FROM login_users WHERE user_id=".$id." LIMIT 1";

		$stmt = parent::query($sql);
		$name = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$name = $row['name'];
		}
		return $name;
	}
	
	
	
	public function getReportfield(){
		$sql = "SELECT * FROM  nql_report_fields ";

		$stmt = parent::query($sql);
		if ($stmt->rowCount() > 0) {
			$arr = '';
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$arr[] = array(	'id'   			 => $row['id'],
							'field' 		 => $row['field'],
							'fieldfriendly'  => $row['fieldfriendly'],
							'type'           => $row['type'],
				     );
			}
		}
		echo json_encode($arr);
	}
	
	public function getOperator(){
		$operator = $_GET['operator'];
		$sql = "SELECT type FROM  nql_report_fields where field= '".$operator."';";
         
		$stmt = parent::query($sql);
		
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $type = $row['type'];
					$sql1 = "SELECT * FROM  nql_reports_comparisions where type='".$type."'";
					
					$stmt1 = parent::query($sql1);
					
					$arr = '';
					while( $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ) {
						//print_r($row1);
						$arr[]= array(
						       'id'   			 => $row1['id'],
							   'comparison'     => $row1['comparison'],
							   'type'     => $row1['type']
						     );
					}
			}
			echo json_encode($arr);
		}
		
		
	public function getReportfieldDetail(){
		$sql = "SELECT * FROM  nql_report_fields ";

		$stmt = parent::query($sql);
		if ($stmt->rowCount() > 0) {
			$arr = '';
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$arr[] = array(	'id'   			 => $row['id'],
							'field' 		 => $row['field'],
							'fieldfriendly'  => $row['fieldfriendly'],
							'type'           => $row['type'],
				     );
			}
		}
		echo json_encode($arr);
	}
		
function sendCompaign(){
		$ids = $_GET['send'];
		
		require '../integration/twilioservices/Twilio.php';
		require '../integration/twilioservices/config.php';

		foreach( $ids as $id){
			$i[] = $id;
			foreach($i as $isval){
			  $id       = $isval[0];
			  $email	= $isval[4];
			  $message  = $isval[6];
			  $autocall = $isval[8];
			  
				  if($email == 1){
					//$this->email($id);
				  }
				  if($message == 1){
					$this->message($id);
				  }
				  if($autocall == 1){
					  $this->autocall($id);
				  }
			  
			}
						
        }
		
		return 'Message Sent to selected ';
	
	}	
	
	
 private function email($id){
	 
	 	$sql = 'SELECT * FROM `agency_clients` WHERE `id`='.$id;
		$stmt = parent::query($sql);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			
				
				$first      = $row['first'];
				$last       = $row['last'];
				$email      = $row['email'];
				$phone1type = $row['phone1type'];
				$phone2type = $row['phone2type'];
				$phone3type = $row['phone3type'];
				$phone1     = $row['phone1'];
				$phone2     = $row['phone2'];
				$phone3     = $row['phone3'];
				$amount     = number_format($row['accountbalance'], 2, '.', ',');
		
		   if ( isset($email) ) {

				$msg  = 'Intake Jobs';
				$subj = 'You have jobs in intake';

				$shortcodes = array(
					'email'   =>  $_SESSION['nware']['email'],
				  );
				
				if(!parent::sendEmail($email, $subj, $msg, $shortcodes))
					$this->error = _('ERROR. Mail not sent');

			 }//end email

		}//end while
 
    }//end sms function
	
	
 private function message($id){
	 
	 	$sql = 'SELECT * FROM `agency_clients` WHERE `id`='.$id;
		$stmt = parent::query($sql);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			
				
				$first      = $row['first'];
				$last       = $row['last'];
				$email      = $row['email'];
				$phone1type = $row['phone1type'];
				$phone2type = $row['phone2type'];
				$phone3type = $row['phone3type'];
				$phone1     = $row['phone1'];
				$phone2     = $row['phone2'];
				$phone3     = $row['phone3'];
				$amount     = number_format($row['accountbalance'], 2, '.', ',');
		

			$version     = TWILIO_API_VERSION;
			$sid         = TWILIO_ACCOUNT_SID;
			$token       = TWILIO_AUTH_TOKEN;
			$phonenumber = TWILIO_PHONE_NUMBER; 

			$messages = 'Mr./Mrs.'.$last.' '.$first.' Your balance amount is '.$amount.'. Please contact to office';
			
			$client = new Services_Twilio($sid, $token , $version);
			  if($phone1type == 'Mobile') 
				
				 $client->account->sms_messages->create($phonenumber,$phone1,$messages);
				 
			  if($phone2type == 'Mobile') 
				 
				 $client->account->sms_messages->create($phonenumber,$phone2,$messages);
			 
			  if($phone3type == 'Mobile') 
				$client->account->sms_messages->create($phonenumber,$phone3,$messages);
		}//end while
 
    }//end sms function
	
	
 private function autocall($id){
	 
	 	$sql = 'SELECT * FROM `agency_clients` WHERE `id`='.$id;
		$stmt = parent::query($sql);

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			
				
				$first      = $row['first'];
				$last       = $row['last'];
				$email      = $row['email'];
				$phone1type = $row['phone1type'];
				$phone2type = $row['phone2type'];
				$phone3type = $row['phone3type'];
				$phone1     = $row['phone1'];
				$phone2     = $row['phone2'];
				$phone3     = $row['phone3'];
				$amount     = number_format($row['accountbalance'], 2, '.', ',');
		

			$version     = TWILIO_API_VERSION;
			$sid         = TWILIO_ACCOUNT_SID;
			$token       = TWILIO_AUTH_TOKEN;
			$phonenumber = TWILIO_PHONE_NUMBER; 

			$url = "http://www.nwareindia.com/voicecall/voiceCall.php" ;
			
			$client = new Services_Twilio($sid, $token , $version);
			  if($phone1type == 'Mobile') 
				
				 $client->account->calls->create($phonenumber,$phone1, $url);				 
				 
			  if($phone2type == 'Mobile') 
				 
				 $client->account->calls->create($phonenumber, $phone2, $url );				 
			 
			  if($phone3type == 'Mobile') 
				$client->account->calls->create($phonenumber, $phone3, $url);			
		}//end while
 
    }//end sms function
	

}

$reports = new Reports();

?>