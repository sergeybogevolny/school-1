<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Client extends Generic {

	private $options = array();
    private $location_data;

	function __construct() {

		if(!empty($_GET['id'])) $this->grab();

		if(!empty($_GET['automatedcall'])) $this->automatedCall();
		if(!empty($_GET['automatedmessage'])) $this->automatedMessage();
		if(!empty($_GET['map'])) $this->clientGeo();

		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['client-delete'])){
                $this->cid = parent::secure($_POST['client-id']);
                $this->flag();
                echo $this->result;
            }

            else if(!empty($_POST['prospectrate'])){
				$this->cid 			 = parent::secure($_POST['client-id']);
				$this->rate  	     = parent::secure($_POST['rate']);
                $this->ratecomment  = parent::secure($_POST['ratecomment']);
                $this->validaterate();
                $this->editrate();
    	        if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
               
			}

            else if (!empty($_POST['action'])){
                $action = parent::secure($_POST['action']);
                switch ($action) {
                    case 'convert':
                        $id = parent::secure($_POST['client-id']);
                        $this->convert($id);
                        echo $this->result;
                        return;
                    case 'reject':
                        $id = parent::secure($_POST['client-id']);
                        $this->reject($id);
                        echo $this->result;
                        return;
                    case 'delete':
                        $id = parent::secure($_POST['client-id']);
                        $this->delete($id);
                        echo $this->result;
                        return;
                    case 'revert':
                        $id = parent::secure($_POST['client-id']);
                        $this->revert($id);
                        echo $this->result;
                        return;
                }
            }

			else if (!empty($_POST['personal-id'])){
                $this->last  	 = parent::secure($_POST['personal-last']);
                $this->first 	 = parent::secure($_POST['personal-first']);
                $this->middle	 = parent::secure($_POST['personal-middle']);
                $this->dob   	 = parent::secure($_POST['personal-dob']);
                $this->ssn       = parent::secure($_POST['personal-ssn']);
				$this->dli        = parent::secure($_POST['personal-dl']);
                $this->gender    = parent::secure($_POST['personal-gender']);
                $this->race      = parent::secure($_POST['personal-race']);
                $this->address   = parent::secure($_POST['personal-address']);
                $this->city      = parent::secure($_POST['personal-city']);
                $this->state     = parent::secure($_POST['personal-state']);
                $this->zip       = parent::secure($_POST['personal-zip']);
                $this->latitude  = parent::secure($_POST['personal-latitude']);
                $this->longitude = parent::secure($_POST['personal-longitude']);
                $this->phone1type= parent::secure($_POST['personal-phone1type']);
				$this->phone1	 = parent::secure($_POST['personal-phone1']);
				$this->phone2type= parent::secure($_POST['personal-phone2type']);
				$this->phone2	 = parent::secure($_POST['personal-phone2']);
                $this->phone3type= parent::secure($_POST['personal-phone3type']);
			    $this->phone3	 = parent::secure($_POST['personal-phone3']);
                $this->phone4type= parent::secure($_POST['personal-phone4type']);
				$this->phone4	 = parent::secure($_POST['personal-phone4']);
				$this->email	 = parent::secure($_POST['personal-email']);
				$this->employer	 = parent::secure($_POST['personal-employer']);
				$this->employersince= parent::secure($_POST['personal-employersince']);
                $this->isvalid	 = parent::secure($_POST['personal-isvalid']);
                $this->pid   	 = parent::secure($_POST['personal-id']);
                $this->validatepersonal();
                $this->editpersonal();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            } else if (!empty($_POST['transaction-id'])){
                $this->type				= parent::secure($_POST['transaction-type']);
                if ($this->type=='Client'){
                    $this->posted           = parent::secure($_POST['transaction-posted']);
                    $this->rejected         = '';
                }
                if ($this->type=='Reject'){
                    $this->posted           = '';
                    $this->rejected         = parent::secure($_POST['transaction-rejected']);
                }
                $this->transactiontags  = parent::secure($_POST['transaction-tags']);
                $this->logged           = parent::secure($_POST['transaction-logged']);
                $this->source 			= parent::secure($_POST['transaction-source']);
                $this->standing         = parent::secure($_POST['transaction-standing']);
                $this->jail 			= parent::secure($_POST['transaction-standingcustodyjail']);
                $this->warrant 			= parent::secure($_POST['transaction-standingwarrantdescription']);
                $this->other 			= parent::secure($_POST['transaction-standingotherdescription']);
				$this->identifiertype   = parent::secure($_POST['transaction-identifiertype']);
				$this->identifier       = parent::secure($_POST['transaction-identifier']);
				$this->tid				= parent::secure($_POST['transaction-id']);
                $this->validatetransaction();
                $this->edittransaction();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            }else if(!empty($_POST['quote-id'])){
                $this->fee    = parent::secure($_POST['quote-fee']);
                $this->down   = parent::secure($_POST['quote-down']);
                $this->terms  = parent::secure($_POST['quote-terms']);
                $this->qid   	 = parent::secure($_POST['quote-id']);
				$this->editquote();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }

			}

            exit;

        }

	}

	private function validatepersonal() {
	    if(empty($this->last)) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
		} else if(empty($this->first)) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
        }
	}

    private function validatetransaction() {
	    if(empty($this->logged)) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
		} else if(empty($this->source)) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
        }
        $logged = DateTime::createFromFormat('d M Y - h:i A', $this->logged);
        if ($logged==''){
            $this->error = '<div class="alert alert-error">Logged is Invalid.</div>';
        }
        if ($this->type=='Client'){
            if(empty($this->posted)) {
			    $this->error = '<div class="alert alert-error">Required fields missing.</div>';
		    }
            $posted = DateTime::createFromFormat('d M Y - h:i A', $this->posted);
            if ($posted==''){
                $this->error = '<div class="alert alert-error">Posted is Invalid.</div>';
            }
        }
        if ($this->type=='Reject'){
            if(empty($this->rejected)) {
			    $this->error = '<div class="alert alert-error">Required fields missing.</div>';
		    }
            $rejected = DateTime::createFromFormat('d M Y - h:i A', $this->rejected);
            if ($rejected==''){
                $this->error = '<div class="alert alert-error">Rejected is Invalid.</div>';
            }
        }
	}

    private function validaterate() {
	    if(empty($this->ratecomment)) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
		}
	}

    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->cid
		);

		$sql = "UPDATE `agency_clients` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}

    private function editpersonal() {

		if(!empty($this->error))
			return false;

        if(!empty($this->dob)){
		    $dob = strtotime($this->dob);
            $this->dob = date('Y-m-d', $dob);
        } else {
            $this->dob = NULL;
        }

		if(!empty($this->employersince)){
		    $since = strtotime($this->employersince);
            $this->since = date('Y-m-d', $since);
        } else {
            $this->since = NULL;
		}

		$params = array(
			':last'     	 => $this->last,
			':first'    	 => $this->first,
			':middle'   	 => $this->middle,
			':dob'      	 => $this->dob,
			':ssn'  		 => $this->ssn,
            ':dli'            => $this->dli,
			':gender'  		 => $this->gender,
            ':race'  		 => $this->race,
            ':address'       => $this->address,
            ':city'  	     => $this->city,
		    ':state'  	     => $this->state,
		    ':zip'  		 => $this->zip,
            ':latitude'	     => $this->latitude,
            ':longitude'	 => $this->longitude,
			':phone1type'	 => $this->phone1type,
			':phone1'		 => $this->phone1,
			':phone2type'	 => $this->phone2type,
			':phone2'		 => $this->phone2,
			':phone3type'	 => $this->phone3type,
			':phone3'		 => $this->phone3,
			':phone4type'	 => $this->phone4type,
			':phone4'		 => $this->phone4,
			':email'		 => $this->email,
			':employer'	     =>	$this->employer	,
            ':employersince' =>	$this->since,
            ':isvalid'		 => $this->isvalid,
			':id'       	 => $this->pid
		);

		$sql = "UPDATE `agency_clients` SET `last` = :last, `first` = :first, `middle` = :middle, `dob` = :dob, `ssnlast4` = :ssn, `gender` = :gender, `address` = :address, `city` = :city, `state` = :state, `zip` = :zip, `latitude` = :latitude, `longitude` = :longitude, `race` = :race, `phone1type` = :phone1type, `phone1` = :phone1, `phone2type` = :phone2type, `phone2` = :phone2, `phone3type` = :phone3type, `phone3` = :phone3, `phone4type` = :phone4type, `phone4` = :phone4, `dl` = :dli, `employer` = :employer, `employersince` = :employersince, `email` = :email, `isvalid` = :isvalid WHERE `id` = :id;";

        $stmt = parent::query($sql, $params);
        $this->result = '<div class="alert alert-success">Successfully edited record</div>';

	}

    private function edittransaction() {


		if(!empty($this->error))
			return false;


        if(!empty($this->logged)){
            $logged = DateTime::createFromFormat('d M Y - h:i A', $this->logged);
            $logged = $logged->format('Y-m-d H:i:s');
            $logged = strtotime($logged);
            $this->logged = date('Y-m-d  H:i:s', $logged);
        } else {
            $this->logged = NULL;
		}
        if(!empty($this->posted)){
            $posted = DateTime::createFromFormat('d M Y - h:i A', $this->posted);
            $posted = $posted->format('Y-m-d H:i:s');
            $posted = strtotime($posted);
            $this->posted = date('Y-m-d  H:i:s', $posted);
        } else {
            $this->posted = NULL;
		}
        if(!empty($this->rejected)){
            $rejected = DateTime::createFromFormat('d M Y - h:i A', $this->rejected);
            $rejected = $rejected->format('Y-m-d H:i:s');
            $rejected = strtotime($rejected);
            $this->rejected = date('Y-m-d  H:i:s', $rejected);
        } else {
            $this->rejected = NULL;
		}

		$params = array(
		   ':source'    => $this->source,
		   ':tags'      => $this->transactiontags,
		   ':logged'    => $this->logged,
           ':posted'    => $this->posted,
           ':rejected'  => $this->rejected,
		   ':standing'  => $this->standing,
		   ':jail'      => $this->jail,
           ':warrant'   => $this->warrant,
		   ':other'     => $this->other,
		   ':identifiertype'   => $this->identifiertype,
		   ':identifier'       => $this->identifier,
           ':id'        => $this->tid
		);
		$sql    = "UPDATE `agency_clients` SET `source` = :source, `tags` = :tags, `logged` = :logged, `posted` = :posted, `rejected` = :rejected, `standing` = :standing, `standingcustodyjail` = :jail, `standingwarrantdescription` = :warrant, `standingotherdescription` = :other, `identifiertype` = :identifiertype, `identifier` = :identifier WHERE `id` = :id;";
        $stmt = parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record</div>';

	    // checking for unique of tag and insert in agency_tag table
		$this->singletag =  explode(",", $this->transactiontags);
		foreach( $this->singletag as $tag){
				$this->tag = parent::secure($tag);
				$params = array( ':tag' => $this->tag );
				$stmt   = parent::query("SELECT * FROM agency_tags WHERE tag = :tag;", $params);

				if( $stmt->rowCount() < 1 ){
						$sql = "INSERT INTO `agency_tags` (`name`) VALUES (:tag);";
						parent::query($sql, $params);
				}
		   }


	}

    private function editquote() {


		if(!empty($this->error))
			return false;


		$params = array(
		   ':fee'    => $this->fee,
		   ':down'   => $this->down,
		   ':terms'  => $this->terms,
           ':id'     => $this->qid
		);
		$sql    = "UPDATE `agency_clients` SET `quotefee` = :fee, `quotedown` = :down, `quoteterms` = :terms WHERE `id` = :id;";
        $stmt = parent::query($sql, $params);

		$this->result = '<div class="alert alert-success">Successfully edited record</div>';


	}



    function editrate(){

		if(!empty($this->error))
			return false;

        $user_id = $_SESSION['nware']['email'];
		$timestamp = date( 'Y-m-d h:i:s' );

		$params = array(
	       ':rate'        => $this->rate,
		   ':ratecomment' => $this->ratecomment,
		   ':rateby'      => $user_id,
		   ':ratestamp'   => $timestamp,
           ':id'          => $this->cid
		 );

		$sql    = "UPDATE `agency_clients` SET `rate` = :rate, `ratecomment` = :ratecomment , `rateby` = :rateby, `ratestamp` = :ratestamp WHERE `id` = :id;";
        $stmt = parent::query($sql, $params);
        $this->result = '<div class="alert alert-success">Successfully edited record</div>';
	}

    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM agency_clients WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

    private function convert($id){
	    if(!empty($this->error))
		    return false;

		$timestamp = date( 'Y-m-d h:i:s' );

		$params = array(
            ':type' => 'Client',
            ':posted' => $timestamp,
            ':id' => $id
		);

		$sql = "UPDATE `agency_clients` SET `type` = :type, `posted` = :posted WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully converted Prospect</div>';

	}

    private function reject($id){
	    if(!empty($this->error))
		    return false;

		$timestamp = date( 'Y-m-d h:i:s' );

		$params = array(
            ':type' => 'Reject',
            ':rejected' => $timestamp,
            ':id' => $id
		);

		$sql = "UPDATE `agency_clients` SET `type` = :type, `rejected` = :rejected WHERE `id` = :id;";

        parent::query($sql, $params);

		$this->result = '<div class="alert alert-success">Successfully rejected Prospect</div>';

	}

    private function delete($id){
	    if(!empty($this->error))
		    return false;

		$params = array(
            ':flag' => '1',
            ':id' => $id
		);

		$sql = "UPDATE `agency_clients` SET `flag` = :flag WHERE `id` = :id;";
        $sql1 = "DELETE FROM  `agency_users_histories`  WHERE `link` = 'client.php?id=".$id."';";

        parent::query($sql, $params);
        parent::query($sql1, $params);

        $this->result = '<div class="alert alert-success">Successfully deleted Prospect</div>';

	}

    private function revert($id){
	    if(!empty($this->error))
		    return false;

		$params = array(
            ':type' => 'Prospect',
            ':id' => $id
		);

		$sql = "UPDATE `agency_clients` SET `type` = :type, `posted` = NULL WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully reverted Client</div>';

	}

    function timeFormat($start_time, $end_time){
    		$total_time = $end_time - $start_time;
    		$days       = floor($total_time /86400);
    		$hours      = floor($total_time /3600);
    		$minutes    = intval(($total_time/60) % 60);
    		$seconds    = intval($total_time % 60);
    		$results = "";

              if($days == -1) $results = 'Today';
    		  if($days == 0) $results = 'Today';
    		  if($days == 1) $results = 'Yesterday';
    		  if($days > 1) $results = $days . (($days > 1)?" days ago":" day ");

    		return $results;
    }

    function getCheckin($id) {
        $sql = "SELECT stamp FROM agency_clients_checkins WHERE client_id=".$id." ORDER BY stamp DESC LIMIT 1";
    	$stmt = parent::query($sql);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($row)){
            $checkin = "None Recorded";
        } else {
            $checkin = $row['stamp'];
            $checkin = date( 'F j, Y', strtotime($checkin));
        }
        return $checkin;
    }

    function getAppearance($id) {
        $sql = "SELECT agency_bonds.setting
                FROM agency_bonds INNER JOIN agency_clients ON agency_bonds.client_id = agency_clients.id
                WHERE agency_bonds.setting > CURRENT_TIMESTAMP AND agency_clients.type = 'Client'
                ORDER BY setting ASC LIMIT 1";
    	$stmt = parent::query($sql);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($row)){
            $appearance = "None Recorded";
        } else if($row['setting']===NULL){
            $appearance = "None Recorded";
        } else {
            $appearance = $row['setting'];
            $appearance = date( 'M j, Y, g:i a', strtotime($appearance));
        }
        return $appearance;
    }


    function getMugshot($id) {
        $sql = "SELECT * FROM agency_clients_documents WHERE client_id = " . $id . " AND mugshot =  1 AND flag = 0";
    	$stmt = parent::query($sql);
        $mugshot = '';

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($row)){
            $mugshot = "documents/avatar/default.png";
        } else {
            $mugshot = "documents/" . $id . "/root/" . $row['file'];
        }
        return $mugshot;
    }


	function clientGeo(){
		$stmt = parent::query("SELECT latitude, longitude FROM agency_clients");

		if ( $stmt->rowCount() < 1 ) {

		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return false;

		}else {

			$location_data = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$latitude = (double) $row['latitude'];
				$longitude = (double) $row['longitude'];
				$location_data[] = array($latitude, $longitude);

			}
			echo json_encode( $location_data);
		}
	}

   function bondSummery( $id ){
		$stmt = parent::query("SELECT SUM(amount) AS BondSum,COUNT(amount) AS BondCount FROM agency_bonds WHERE client_id =".$id);
		$bondSummery = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
		    $bondSummery = array(
			    "Sum"  => number_format($row['BondSum'], 2, '.', ''),
				"Count"=> $row['BondCount']
			);
		}
		return $bondSummery;
	}


   function transactionSummery( $id ){

        $stmt = parent::query("SELECT created FROM agency_clients WHERE type = 'Client' AND link_id =".$id." ORDER BY created ASC");
        $transactionSummery = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
		    $created[] = $row['created'];
			$transactionSummery =  array(
			    'Count'=>count($created),
				'Date' =>$created
		    );
		}
		 return $transactionSummery ;
	}

    function setAccountDue($id, $balance){

        $nextpaydate = '';
        $dayspastdue =  0;
        $dueamount  = 0;

        $sql = "SELECT date, remaining FROM agency_clients_accounts_schedules WHERE remaining < '".$balance."' AND client_id=".$id." ORDER BY remaining DESC LIMIT 1";
        $stmt = parent::query($sql);

        if ($stmt->rowCount()>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nextpaydate = $row['date'];
            $dueamount = $balance - $row['remaining'];
            if(new DateTime() > new DateTime($nextpaydate)){
                $date1 = strtotime($nextpaydate);
                $date2 = strtotime(date('Y-m-d h:i:s'));
                $diff = $date2 - $date1;
    		    $dayspastdue = floor($diff/86400);
            } else {
                $nextpaydate = date('m/d/Y', strtotime($nextpaydate));
            }
        }
        $account_data = array();
        $account_data[0]=$nextpaydate;
        $account_data[1]=$dayspastdue;
        $account_data[2]=$dueamount;
        return $account_data;
    }


    function setAccountPastDue($id, $balance){

        $nextpaydate = '';
        $dayspastdue =  0;
        $pastdueamount  = 0;

        $sql = "SELECT date FROM agency_clients_accounts_schedules WHERE remaining < '".$balance."' AND client_id=".$id." ORDER BY remaining DESC LIMIT 1";
        $stmt = parent::query($sql);

        if ($stmt->rowCount()>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nextpaydate = $row['date'];
            if(new DateTime() > new DateTime($nextpaydate)){
                $date1 = strtotime($nextpaydate);
                $date2 = strtotime(date('Y-m-d h:i:s'));
                $diff = $date2 - $date1;
    		    $dayspastdue = floor($diff/86400);
            }
            $sql = "SELECT date, remaining FROM agency_clients_accounts_schedules WHERE client_id=".$id." ORDER BY date ASC";
    	    $stmt = parent::query($sql);
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $scheduledate = $row['date'];
                if(new DateTime() > new DateTime($scheduledate)){
                    $pastdueamount = $balance - $row['remaining'];
                }
            }

        }
        $account_data = array();
        $account_data[0]=$nextpaydate;
        $account_data[1]=$dayspastdue;
        $account_data[2]=$pastdueamount;
        return $account_data;
    }

	function automatedMessage(){

		header('Content-type: text/xml');
		$message = ' hello Carla, please call. thank you';
		echo '<?xml version="1.0"?>
				 <Response>
				   <Say voice="alice">'.$message.'</Say>
				   <Play></Play>
				 </Response>';


	}

	function automatedCall(){
		$contact = $_GET['number'];
		require '../integration/twilioservices/Twilio.php';
		require '../integration/twilioservices/config.php';

		$version     = TWILIO_API_VERSION;
		$sid         = TWILIO_ACCOUNT_SID;
		$token       = TWILIO_AUTH_TOKEN;
		$phonenumber = TWILIO_PHONE_NUMBER;

		$client = new Services_Twilio($sid, $token, $version);

		try {
          // $messageUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']).'/client.class.php?automatedmessage=message';

		    $messageUrl = "http://www.nwareindia.com/voicecall/voice.php";
			$call = $client->account->calls->create(
					$phonenumber, // The number of the phone initiating the call
					$contact, // The number of the phone receiving call
					$messageUrl // The URL Twilio will request when the call is answered
					);

			echo '<div id="callStatus" class="alert alert-success "> Automated call completed</div>';

			}catch (Exception $e) {

				echo '<div id="callStatus" class="alert alert-error ">Error: ' . $e->getMessage() .'</div>';

			 }

	}




}
$client = new Client();

?>