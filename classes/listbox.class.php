<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Listbox extends Generic {

    public function getGeneral_Agents(){
		$sql = "SELECT company, id FROM general_agents WHERE flag = 0 ORDER BY company ASC ";

		$stmt = parent::query($sql);
        $agents = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->agents = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $name = $row['company'];
				$id = $row['id'];
                $agents .= '<option value="'.$name.'" id="'.$id.'">'.$name.'</option>';
			}
		}
		return $agents;
	}
    public function getGeneral_Powers(){
		$sql = "SELECT  id,serial,prefix FROM general_powers ORDER BY id ASC ";


		$stmt = parent::query($sql);
		$powers = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->powers = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$id         = $row['id'];
				$serial     = $row['serial'];
				$prefix = $row['prefix'];
                $powers .= '<option value="'.$id.'">'.$serial.'-'.$prefix.'</option>';
			}
		}
		return $powers;
	}

    public function getAgencyfriendly(){
		$sql = "SELECT name FROM agency_settings_agency LIMIT 1";

		$stmt = parent::query($sql);
        $agency = '';
		if ($stmt->rowCount() > 0) {
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $agency = $row['name'];
			}
		}
		return $agency;
	}

    public function getAgentsfriendly(){
		$sql = "SELECT name, id FROM agency_settings_agency ORDER BY name ASC ";

		$stmt = parent::query($sql);
        $agents = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->agents = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $name = $row['name'];
				$id = $row['id'];
                $agents .= '<option value="'.$name.'" id="'.$id.'">'.$name.'</option>';
			}
		}
		return $agents;
	}

    public function getAgentrejects(){
		$sql = "SELECT name FROM general_settings_lists_agentrejects WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$agentrejects = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->payments = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $agentrejects .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $agentrejects;
	}

	public function getAttorneys(){
		$sql = "SELECT name FROM agency_settings_lists_attorneys WHERE flag = 0 ORDER BY name ASC ";

		$stmt = parent::query($sql);
        $attorneys = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->attorneys = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $name = $row['name'];
                $attorneys .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $attorneys;
	}

	public function getCharges(){
		$sql = "SELECT name FROM  agency_settings_lists_charges WHERE flag = 0 ORDER BY name ASC ";

		$stmt = parent::query($sql);
		$charges = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->charges = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $charges .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $charges;
	}


    public function getCounties(){
		$sql = "SELECT name FROM agency_settings_lists_counties WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$counties = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->counties = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $counties .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $counties;
	}




    public function getCouriers(){
		$sql = "SELECT name FROM agency_settings_lists_couriers WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$couriers = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->couriers = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $couriers .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $couriers;
		}



	public function getCourts(){
		$sql = "SELECT name FROM agency_settings_lists_courts WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$courts = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->courts = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $courts .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $courts;
	}



	public function getCreditentries(){
		$sql = "SELECT name FROM agency_settings_lists_creditentries WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$creditentries = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->creditentries = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $creditentries .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $creditentries;
	}



	 public function getDebitentries(){
		$sql = "SELECT name FROM  agency_settings_lists_debitentries WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$debitentries = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->debitentries = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $debitentries .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $debitentries;
	}

    public function getForfeituredisposes(){
		$sql = "SELECT name FROM general_settings_lists_forfeituredisposes WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$forfeituredisposes = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->payments = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $forfeituredisposes .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $forfeituredisposes;
	}

    public function getIdentifiers(){
		$sql = "SELECT name FROM  agency_settings_lists_identifiers WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$identifiers = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->identifiers = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $identifiers .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $identifiers;
	}

	public function getJails(){
		$sql = "SELECT name FROM  agency_settings_lists_jails WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$jails = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->jails = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $jails .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $jails;
	}




	public function getOffices(){
		$sql = "SELECT name FROM  agency_settings_lists_offices WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$offices = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->offices = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $offices .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $offices;
	}




	public function getPaymentmethods(){
		$sql = "SELECT name FROM agency_settings_lists_paymentsmethods WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$payments = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->payments = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $payments .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $payments;
	}





	public function getPhones(){
		$sql = "SELECT name FROM  agency_settings_lists_phones ORDER BY name ASC";

		$stmt = parent::query($sql);
		$phones = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->phones = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $phones .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $phones;
	}



	public function getPrefixs(){
		$sql = "SELECT name FROM  agency_settings_lists_prefixs WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$prefixs = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->prefixs = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $prefixs .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $prefixs;
	}

    public function getPrinters(){
		$sql = "SELECT location, id FROM agency_settings_lists_writer_locations ORDER BY location ASC ";

		$stmt = parent::query($sql);
        $printers = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->printers = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $name = $row['location'];
				$id = $row['id'];
                $printers .= '<option value="'.$id.'">'.$name.'</option>';
			}
		}
		return $printers;
	}


	public function getRaces(){
		$sql = "SELECT name FROM  agency_settings_lists_races WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$races = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->races = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $races .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $races;
	}

    public function getTransferrejects(){
		$sql = "SELECT name FROM general_settings_lists_transferrejects WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$transferrejects = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->payments = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $transferrejects .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $transferrejects;
	}

    public function getTransfersettles(){
		$sql = "SELECT name FROM general_settings_lists_transfersettles WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$transfersettles = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->payments = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $transfersettles .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $transfersettles;
	}

	public function getSetfors(){
		$sql = "SELECT name FROM  agency_settings_lists_setfors WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$setfors= '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->setfors = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $setfors .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $setfors;
	}

	public function getSources(){
		$sql = "SELECT name FROM  agency_settings_lists_sources WHERE flag = 0 ORDER BY name ASC";

		$stmt = parent::query($sql);
		$sources= '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->sources = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $sources .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $sources;
	}


	public function getStates(){
		$sql = "SELECT name FROM  agency_settings_lists_states ORDER BY name ASC";

		$stmt = parent::query($sql);
		$states= '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->states = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $states .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $states;
	}

    public function getSts(){
		$sql = "SELECT abbreviation FROM  agency_settings_lists_states ORDER BY abbreviation ASC";

		$stmt = parent::query($sql);
		$sts= '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->sts = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$abbreviation = $row['abbreviation'];
                $sts .= '<option value="'.$abbreviation.'">'.$abbreviation.'</option>';
			}
		}
		return $sts;
	}

	public function getSureties(){
		$sql = "SELECT name FROM  agency_settings_lists_sureties ORDER BY name ASC";

		$stmt = parent::query($sql);
		$sureties= '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->sureties = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
                $sureties .= '<option value="'.$name.'">'.$name.'</option>';
			}
		}
		return $sureties;
	}

	public function getUserEmail(){
		$sql = "SELECT user_id,email FROM  login_users WHERE user_id !=".$_SESSION['nware']['user_id'];

		$stmt = parent::query($sql);
		$email= '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->email = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$user_id = $row['user_id'];
				$emailuser   = $row['email'];
                $email .= '<option value="'.$user_id.'">'.$emailuser.'</option>';
			}
		}
		return $email;
	}
	
	public function getUserName(){
	   $loginemail       = $_SESSION['nware']['email'];

		$sql = "SELECT user_id,email,name FROM  login_users WHERE email != '$loginemail'";

		$stmt = parent::query($sql);
		$username= '<option value="'.$loginemail.'">'. $loginemail .'</option>';
		if ($stmt->rowCount() > 0) {
			$this->email = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$email = $row['email'];
				$name   = $row['name'];
                $username .= '<option value="'.$email.'">'.$email.'</option>';
			}
		}
		return $username;
	}

   public function getPowers(){
		$sql = 'SELECT
            agency_powers.id,
            agency_powers.prefix,
            agency_powers.serial,
            agency_bonds.power_id
            FROM
            agency_powers
            LEFT JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
            WHERE agency_bonds.power_id IS NULL';

		$stmt = parent::query($sql);
		$powers = '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->powers = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$id         = $row['id'];
				$serial     = $row['serial'];
				$prefix = $row['prefix'];
                $powers .= '<option value="'.$id.'">'.$prefix.'-'.$serial.'</option>';
			}
		}
		return $powers;
   }
   
   
	public function campaignTemplate($type,$generator){

		$sql = "SELECT * FROM  nql_reports_templates WHERE type = '$type' AND generator = '$generator'";

		$stmt = parent::query($sql);
		$model= '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			$this->email = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$genrator = $row['generator'];
				$template   = $row['template'];
                $model .= '<option value="'.$template.'">'.$template.'</option>';
			}
		}
		return $model;
	}



}
$listbox = new Listbox();

?>