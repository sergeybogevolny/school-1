<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Forms extends Generic {

    function __construct() {

		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['campaign'])){
                $this->agencycourtnotice1();
            }
            exit;

        }

	}

    public function getReportcolumnar($id) {

        global $generic;
        $sql = "SELECT
        nql_reports_histories.sqlraw,
        nql_reports_histories.`condition`,
        nql_report.`name`,
        nql_report.generator,
        nql_report.`level`
        FROM
        nql_reports_histories
        INNER JOIN nql_report ON nql_reports_histories.report_id = nql_report.id
        WHERE nql_reports_histories.id=".$id;

        $query = $generic->query($sql);

        if ($query->rowCount() < 1) {
			die();
		}

        $row = $query->fetch(PDO::FETCH_ASSOC);
        $this->options['sqlraw']        = $row['sqlraw'];
        $this->options['condition']     = $row['condition'];
        $this->options['report']        = $row['name'];
        $this->options['generator']     = $row['generator'];
        $level                          = $row['level'];
        $title                          = 'undefined';

        if ($level=='agency'){
            $sql = "SELECT
            agency_settings_agency.name
            FROM
            agency_settings_agency";

            $query = $generic->query($sql);

            $row = $query->fetch(PDO::FETCH_ASSOC);
            $title = $row['name'];
        }
        if ($level=='general'){
            $sql = "SELECT
            general_settings_general.name
            FROM
            general_settings_general";

            $query = $generic->query($sql);

            $row = $query->fetch(PDO::FETCH_ASSOC);
            $title = $row['name'];
        }

        $this->options['title'] = $title;

        return;

    }

    public function getReportcampaign($id) {

        global $generic;
        $sql = "SELECT
        nql_reports_histories.sqlraw,
        nql_reports_histories.`condition`,
        nql_reports_histories.`letters`,
        nql_reports_histories.`emails`,
        nql_reports_histories.`texts`,
        nql_reports_histories.`autocalls`,
        nql_reports_histories.`lettertemplate`,
        nql_reports_histories.`emailtemplate`,
        nql_reports_histories.`texttemplate`,
        nql_reports_histories.`autocalltemplate`,
        nql_report.`name`,
        nql_report.generator
        FROM
        nql_reports_histories
        INNER JOIN nql_report ON nql_reports_histories.report_id = nql_report.id
        WHERE nql_reports_histories.id=".$id;

        $query = $generic->query($sql);

        if ($query->rowCount() < 1) {
			die();
		}

        $row = $query->fetch(PDO::FETCH_ASSOC);
        $this->options['sqlraw']            = $row['sqlraw'];
        $this->options['condition']         = $row['condition'];
        $this->options['report']            = $row['name'];
        $this->options['generator']         = $row['generator'];
        $this->options['letters']           = $row['letters'];
        $this->options['emails']            = $row['emails'];
        $this->options['texts']             = $row['texts'];
        $this->options['autocalls']         = $row['autocalls'];
        $this->options['lettertemplate']    = $row['lettertemplate'];
        $this->options['emailtemplate']     = $row['emailtemplate'];
        $this->options['texttemplate']      = $row['texttemplate'];
        $this->options['autocalltemplate']  = $row['autocalltemplate'];

        return;

    }

	public function getPowerallegheny($id,$pid) {

        $stmt = parent::query("SELECT
        agency_clients.last,
        agency_clients.`first`,
        agency_clients.middle,
        agency_clients.dob,
        agency_clients.spn,
        agency_bonds.amount,
        agency_bonds.checkamount,
        agency_bonds.class,
        agency_bonds.charge,
        agency_bonds.casenumber,
        agency_bonds.court,
        agency_bonds.county,
        agency_settings_lists_courts.type,
        agency_settings_lists_courts.precinct,
        agency_settings_lists_courts.position
        FROM
        agency_clients
        INNER JOIN agency_bonds ON agency_bonds.client_id = agency_clients.id
        LEFT JOIN agency_settings_lists_courts ON agency_bonds.court = agency_settings_lists_courts.`name` AND agency_bonds.county = agency_settings_lists_courts.county
        WHERE agency_bonds.id = " . $id);

        if ($stmt->rowCount() < 1) {
		    header('./powerallegheny.php');
			die();
		}

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        $stmt = parent::query("SELECT
        agency_settings_agency.city,
        agency_settings_agency.state,
        agency_settings_agency.license
        FROM
        agency_settings_agency");

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        if ($pid!='') {
            $stmt = parent::query("SELECT
            translatex,
            translatey
            FROM
            agency_settings_lists_writer_locations
            WHERE id = " . $pid);

            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
    		    $this->options[$field] = $value;
        } else {
            $this->options['translatex'] = 0;
            $this->options['translatey'] = 0;
        }

        return;

	}

    public function getBondharristxcounty($id,$pid) {

        $stmt = parent::query("SELECT
          agency_clients.last,
          agency_clients.`first`,
          agency_clients.middle,
          agency_clients.dob,
          agency_clients.identifiertype,
          agency_clients.identifier,
          agency_clients.standingcustodyjail,
          agency_bonds.amount,
          agency_bonds.checkamount,
          agency_bonds.class,
          agency_bonds.charge,
          agency_bonds.casenumber,
          agency_bonds.court,
          agency_bonds.county,
          agency_bonds.jail
          FROM
          agency_clients
          INNER JOIN agency_bonds ON agency_bonds.client_id = agency_clients.id
          WHERE agency_bonds.id = " . $id);

        if ($stmt->rowCount() < 1) {
		    header('./bondharristxcounty.php');
			die();
		}

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        $stmt = parent::query("SELECT
        agency_settings_agency.address,
        agency_settings_agency.city,
        agency_settings_agency.state,
        agency_settings_agency.zip,
        agency_settings_agency.phone,
        agency_settings_agency.license,
        agency_settings_agency.agent
        FROM
        agency_settings_agency");

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        if ($pid!='') {
            $stmt = parent::query("SELECT
            translatex,
            translatey
            FROM
            agency_settings_lists_writer_locations
            WHERE id = " . $pid);

            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
    		    $this->options[$field] = $value;
        } else {
            $this->options['translatex'] = 0;
            $this->options['translatey'] = 0;
        }

        return;

    }

    public function getBondharristxjp($id,$pid) {

        $stmt = parent::query("SELECT
          agency_clients.last,
          agency_clients.`first`,
          agency_clients.middle,
          agency_clients.identifiertype,
          agency_clients.identifier,
          agency_clients.address AS defendantaddress,
          agency_clients.city AS defendantcity,
          agency_clients.state AS defendantstate,
          agency_clients.zip AS defendantzip,
          agency_clients.standingcustodyjail,
          agency_bonds.amount,
          agency_bonds.checkamount,
          agency_bonds.class,
          agency_bonds.charge,
          agency_bonds.casenumber,
          agency_bonds.court,
          agency_bonds.jail,
          agency_settings_lists_courts.precinct,
          agency_settings_lists_courts.position
          FROM
          agency_clients
          INNER JOIN agency_bonds ON agency_bonds.client_id = agency_clients.id
          INNER JOIN agency_settings_lists_courts ON agency_bonds.court = agency_settings_lists_courts.`name`
          WHERE agency_bonds.id = " . $id);

        if ($stmt->rowCount() < 1) {
		    header('./bondharristxjp.php');
			die();
		}

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        $stmt = parent::query("SELECT
        agency_settings_agency.address AS agencyaddress,
        agency_settings_agency.city AS agencycity,
        agency_settings_agency.state AS agencystate,
        agency_settings_agency.zip AS agencyzip
        FROM
        agency_settings_agency");

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        if ($pid!='') {
            $stmt = parent::query("SELECT
            translatex,
            translatey
            FROM
            agency_settings_lists_writer_locations
            WHERE id = " . $pid);

            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
    		    $this->options[$field] = $value;
        } else {
            $this->options['translatex'] = 0;
            $this->options['translatey'] = 0;
        }

        return;

	}

    public function getBondhoustontxcity($id,$pid) {

        $stmt = parent::query("SELECT
          agency_clients.last,
          agency_clients.`first`,
          agency_clients.middle,
          agency_clients.identifiertype,
          agency_clients.identifier,
          agency_clients.address AS defendantaddress,
          agency_clients.city AS defendantcity,
          agency_clients.state AS defendantstate,
          agency_clients.zip AS defendantzip,
          agency_clients.standing,
          agency_clients.standingcustodyjail,
          agency_bonds.amount,
          agency_bonds.checkamount,
          agency_bonds.charge,
          agency_bonds.casenumber
          FROM
          agency_clients
          INNER JOIN agency_bonds ON agency_bonds.client_id = agency_clients.id
          WHERE agency_bonds.id = " . $id);

        if ($stmt->rowCount() < 1) {
		    header('./bondhoustontxcity.php');
			die();
		}

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        $stmt = parent::query("SELECT
        agency_settings_agency.address AS agencyaddress,
        agency_settings_agency.city AS agencycity,
        agency_settings_agency.state AS agencystate,
        agency_settings_agency.zip AS agencyzip
        FROM
        agency_settings_agency");

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        if ($pid!='') {
            $stmt = parent::query("SELECT
            translatex,
            translatey
            FROM
            agency_settings_lists_writer_locations
            WHERE id = " . $pid);

            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
    		    $this->options[$field] = $value;
        } else {
            $this->options['translatex'] = 0;
            $this->options['translatey'] = 0;
        }

        return;

	}

    public function getOtherharristxaoa($id,$pid) {

        $stmt = parent::query("SELECT
          agency_clients.last,
          agency_clients.`first`,
          agency_clients.middle,
          agency_bonds.amount,
          agency_bonds.casenumber,
          agency_bonds.jail
          FROM
          agency_clients
          INNER JOIN agency_bonds ON agency_bonds.client_id = agency_clients.id
          WHERE agency_bonds.id = " . $id);

        if ($stmt->rowCount() < 1) {
		    header('./otherharristxaoa.php');
			die();
		}

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        if ($pid!='') {
            $stmt = parent::query("SELECT
            translatex,
            translatey
            FROM
            agency_settings_lists_writer_locations
            WHERE id = " . $pid);

            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
    		    $this->options[$field] = $value;
        } else {
            $this->options['translatex'] = 0;
            $this->options['translatey'] = 0;
        }

        return;
	}


	public function getAccountreceipt($id) {

        $stmt = parent::query("SELECT
          agency_clients.*,
          agency_clients_accounts.*,
		  agency_bonds.*
          FROM
          agency_clients
          INNER JOIN agency_clients_accounts ON agency_clients_accounts.client_id = agency_clients.id
          INNER JOIN agency_bonds ON agency_bonds.client_id = agency_clients.id

          WHERE agency_clients_accounts.id = " . $id);

        if ($stmt->rowCount() < 1) {
		    header('./accountreceipt.php');
			die();
		}
//

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        return;

	}


	public function getAccountinvoice($id) {

        $stmt = parent::query("SELECT
          agency_clients.last,
          agency_clients.first,
          agency_clients.address,
          agency_clients.city,
          agency_clients.state,
		  agency_clients.zip,
          agency_bonds.amount,
		  agency_bonds.casenumber,
		  agency_bonds.county,
		  agency_bonds.court,
		  agency_bonds.class,
		  agency_bonds.charge,
          agency_clients_accounts.entry,
		  agency_clients_accounts.balance,
          agency_clients_accounts.debit,
		  agency_settings_agency.*,
          agency_clients_accounts.paymentmethod
          FROM
          agency_clients
		  JOIN agency_settings_agency
          INNER JOIN agency_clients_accounts ON agency_clients_accounts.client_id = agency_clients.id
          INNER JOIN agency_bonds ON agency_bonds.client_id = agency_clients.id

          WHERE agency_clients_accounts.id = " . $id);


        if ($stmt->rowCount() < 1) {
		    header('./accountinvoice.php');
			die();
		}


        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        return;

		}


	public function getPowerwizard($id) {

        $stmt = parent::query("SELECT
				agency_powers_reports_details.* ,
				agency_settings_agency.*
				FROM agency_powers
				JOIN agency_settings_agency
				INNER JOIN agency_powers_reports ON agency_powers_reports.id = agency_powers.report_id
				INNER JOIN agency_powers_reports_details ON agency_powers_reports_details.id = agency_powers.reportdetail_id
				WHERE agency_powers.report_id = " . $id);

        if ($stmt->rowCount() < 1) {
		    header('./powerwizard.php');
			die();
		}


        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)

			//print_r($field);
			$this->options[$field] = $value;

        return;

	}


	public function getLetter($id) {

        $stmt = parent::query("SELECT
								   agency_users_tasks.task,
								   agency_users_tasks.type,
								   agency_users_tasks.deadline,
								   agency_users_tasks.flag_important,
								   login_users.email,
								   login_users.name
							  FROM agency_users_tasks
							  LEFT JOIN login_users
							  ON agency_users_tasks.assigned_id = login_users.user_id
							  WHERE  assigned_id = ".$_SESSION['nware']['user_id']." AND agency_users_tasks.id =".$id."
							  ORDER BY flag_important DESC, assigned_date"
							  );


        if ($stmt->rowCount() < 1) {
		    header('./accountinvoice.php');
			die();
		}

        foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

        return;

	}

	  public function getDistributeReport($id){
        $stmt = parent::query("SELECT
				general_powers_distributes_details.prefix,
				general_powers_distributes_details.id,
				general_powers_distributes_details.serial,
				general_powers_distributes_details.`value`,
				general_powers_orders_details.expiration,
				general_powers_distributes.id,
				general_settings_general.*
				FROM
				general_powers_distributes
				JOIN general_settings_general
				INNER JOIN general_powers_distributes_details ON general_powers_distributes_details.distribute_id = general_powers_distributes.id
				INNER JOIN general_powers_orders_details ON general_powers_orders_details.prefix = general_powers_distributes_details.prefix
				WHERE
				general_powers_distributes.id = " . $id);


			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $name[] = $row;
			}
			return $name;


	  }

	  public function getMasterReport($id){

		$stmt = parent::query( "SELECT* FROM nql_report WHERE id=".$id );


				if ($stmt->rowCount() < 1) {
					header('./accountinvoice.php');
					die();
				}

				foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
					$this->options[$field] = $value;

				return;

	  }
	  public function compaignLetter($id){
	 	$sql = 'SELECT * FROM `agency_clients` WHERE `id`='.$id;
		$stmt = parent::query( $sql );


				if ($stmt->rowCount() < 1) {
					header('./accountinvoice.php');
					die();
				}

				foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
					$this->options[$field] = $value;

				return;
	  }





     public function agencycourtnotice1(){

		require '../integration/twilioservices/Twilio.php';
		require '../integration/twilioservices/config.php';
		global $generic;

		$id = $_POST['campaignid'];
		$url = '';
		$sql = "SELECT * FROM  nql_reports_histories  WHERE nql_reports_histories.id=".$id;
		$query = $generic->query($sql);

		if ($query->rowCount() < 1) {
				die();
			 }

		$row = $query->fetch(PDO::FETCH_ASSOC);
		//echo '<pre>'; print_r($row);
		$autocall = $row['autocalls'];
		if(!empty($autocall)){
			$idss = explode(',',$autocall);
			foreach($idss as $id){
				$sql1 = $row['sqlraw'] . $id;
				$stmt1 = parent::query($sql1);
				$letter = '';

				while( $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ) {

					$phone      = '(409) 960-8884';
					$name       = $row1['name'];
					$email      = 'admin@admin.com';
					$setting    = $row1['setting'];
					$message    = $name . ',you have court part2' . $setting ;
					$url[] = array('name'=>$name,'date'=>$setting);
					//$this->sendSms($phone,$message );
					//$this->automatedCall($phone,$message );
					//$this->Sendemail($email,$message);

				 }


			}

	   }

	   echo json_encode($url);
	 }

	 private function sendSms($phone,$message ){

		$version     = TWILIO_API_VERSION;
		$sid         = TWILIO_ACCOUNT_SID;
		$token       = TWILIO_AUTH_TOKEN;
		$phonenumber = TWILIO_PHONE_NUMBER;
		$client = new Services_Twilio($sid, $token , $version);
		$client->account->sms_messages->create($phonenumber,$phone,$message);

	 }//end sms function


	function automatedCall($phone,$message){

		$version     = TWILIO_API_VERSION;
		$sid         = TWILIO_ACCOUNT_SID;
		$token       = TWILIO_AUTH_TOKEN;
		$phonenumber = TWILIO_PHONE_NUMBER;

		$client = new Services_Twilio($sid, $token, $version);

        try {
		    $messageUrl = 'http://www.nwareindia.com/voicecall/campaign.php?message=' . urlencode($message);
			$call = $client->account->calls->create(
					$phonenumber,
					$phone,
					$messageUrl
					);
		}catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}
	}

/*	function Sendemail($email,$message){

		    $subj = 'You have jobs in intake';



			if(!mail($email, $subj, $message))
				$this->error = _('ERROR. Mail not sent');
	}
*/





	public function getField($field) {
		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$forms = new Forms();

?>