<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_powers_distribute extends Generic {

	private $options = array();

    function __construct() {
		if(!empty($_POST)) {
            if(isset($_POST['list-filter'])) {
                $this->list_powers();
    		} else {
                foreach ($_POST as $key => $value)
					$this->options[$key] = parent::secure($value);
					$this->validate();
					$this->add();
					if(!empty($this->error)){
						echo $this->error;
					}else {
						echo $this->result;
					}
            }
        }
	}

   private function validate() {
	    if(empty($this->options['distribute-date'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
		} else if(empty($this->options['distribute-agent'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
        }
	}

    private function add() {
		$distributedate = strtotime($this->options['distribute-date']);
        $distributedate = date('Y-m-d', $distributedate);

        $agent	 = $this->options['distribute-agent'];
		$agentid = $this->options['distribute-agent-id'];

		if(isset($this->options['prefixmv'])){
			$prefix = $this->options['prefixmv'];
		}else{$prefix = null;}

		if(isset($this->options['serialmv'])){
			$serial = $this->options['serialmv'];
		}else{$serial = null;}

        if(isset($this->options['valuemv'])){
			$value = $this->options['valuemv'];
		}else{$value = null;}

        if(isset($this->options['issuedmv'])){
			$issued = $this->options['issuedmv'];
		}else{$issued = null;}

        if(isset($this->options['expirationmv'])){
			$expiration = $this->options['expirationmv'];
		}else{$expiration = null;}

        $valuesum = array_sum($value);
        $count = (count($prefix));

		$sql = "INSERT INTO general_powers_distributes (`date`,`agent`,`agent_id`,`count`,`amount`) VALUES ('$distributedate','$agent','$agentid',$count,'$valuesum')";
		$stmt = parent::query($sql);
		$distributeid = parent::$dbh->lastInsertId();

        $sql = "INSERT INTO agency_powers_intakes (`date`,`count`,`value`,`distribute_id`) VALUES ('$distributedate','$count',$valuesum,$distributeid)";
		$stmt = parent::query($sql);
		$intakeid = parent::$dbh->lastInsertId();

		$sender = $_SESSION['nware']['email'];
		$user_id = $_SESSION['nware']['user_id'];
		$url = 'wizards-powers-collect.php?'.$intakeid;
		$sqlmess = "INSERT INTO agency_messages(`sender`,`subject`,`body`,`created`, `user_id`) VALUES ('$sender', 'Intake Jobs ', 'You have jobs in intake <a href=$url >clickhere</a>', '$date','$user_id')";
		$stmt = parent::query($sqlmess);

	    for ($i = 0 ; $i < $count ; $i++  ){
	        $issuedates = strtotime($issued[$i]);
			$issuedates = date('Y-m-d', $issuedates);

			$expiresdates = strtotime($expiration[$i]);
			$expiresdates = date('Y-m-d',$expiresdates);

            $sql1 = "INSERT INTO agency_powers_intakes_details (`intake_id`,`prefix`,`serial`,`value`,`issued`,`expiration`) VALUES ('$intakeid','$prefix[$i]','$serial[$i]','$value[$i]','$issuedates','$expiresdates')";
            $stmt = parent::query($sql1);
            $sql2 = "INSERT INTO general_powers_distributes_details (`distribute_id`,`prefix`,`serial`,`value`,`issued`,`expiration`) VALUES ('$distributeid','$prefix[$i]','$serial[$i]','$value[$i]','$issuedates','$expiresdates')";
		    $stmt = parent::query($sql2);
			$distributedetailid = parent::$dbh->lastInsertId();
			$sql3 = "UPDATE  `general_powers` SET `distribute_id` = $distributeid ,`distributedetail_id` = $distributedetailid ,`agent` ='$agent' ,`agent_id` ='$agentid' WHERE serial = '$serial[$i]'";
            $stmt = parent::query($sql3);
		}

		$this->sendEmailandSms($agentid);
		echo "<div class='alert alert-success' id='status'>".$distributeid."</div>";
	}

    private function list_powers(){
        global $generic;
        $fprefix = $_POST['filter-prefix'];
        $fserial = $_POST['filter-serial'];
        $fcount = $_POST['filter-count'];
        $sql = "SELECT * FROM general_powers WHERE bond_id is null";

        if ($fprefix!=''){
            $sql = $sql . " AND prefix='".$fprefix."'";
        }
        if ($fserial!=''){
            $sql = $sql . " AND CAST(general_powers.serial AS UNSIGNED INTEGER) >=".$fserial;
        }
        $sql = $sql . " ORDER BY prefix DESC, `int` DESC";
        if ($fcount!=''){
            $sql = $sql . " LIMIT ".$fcount;
        }

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $arr[] = array(
                    'id'            => $row['id'],
                    'prefix'        => $row['prefix'],
                    'serial'        => $row['serial'],
                    'value'         => $row['value'],
                    'issued'        => $row['issued'],
                    'expiration'    => $row['expiration']
                );
          }
          echo json_encode($arr);
        }
    }


 private function sendEmailandSms($id){
	 	$sql = 'SELECT * FROM `general_agents` WHERE `id`='.$id;
		$stmt = parent::query($sql);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$email      = $row['email'];
				$phone1type = $row['phone1type'];
				$phone2type = $row['phone2type'];
				$phone3type = $row['phone3type'];
				$phone1     = $row['phone1'];
				$phone2     = $row['phone2'];
				$phone3     = $row['phone3'];

		   if ( isset($email) ) {
				$msg  = 'Intake Jobs';
				$subj = 'You have jobs in intake';

				$shortcodes = array(
					'email'   =>  $_SESSION['nware']['email'],
				  );

				if(!parent::sendEmail($email, $subj, $msg, $shortcodes))
					$this->error = _('ERROR. Mail not sent');

			 }//end email

			require '../integration/twilioservices/Twilio.php';
			require '../integration/twilioservices/config.php';

			$version     = TWILIO_API_VERSION;
			$sid         = TWILIO_ACCOUNT_SID;
			$token       = TWILIO_AUTH_TOKEN;
			$phonenumber = TWILIO_PHONE_NUMBER;

			$client = new Services_Twilio($sid, $token , $version);
			  if($phone1type == 'Mobile')
				 $client->account->sms_messages->create($phonenumber,$phone1,"You have jobs in intake");
			  if($phone2type == 'Mobile')
				 $client->account->sms_messages->create($phonenumber,$phone2,"You have jobs in intake");
			  if($phone3type == 'Mobile')
				$client->account->sms_messages->create($phonenumber,$phone3,"You have jobs in intake");

		}//end while

    }//end sms function

}

$wizardspowersdistribute = new Wizards_powers_distribute();
?>