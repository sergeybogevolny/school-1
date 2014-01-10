<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Client_bond extends Generic {

	private $options = array();

    function __construct() {
        if(!empty($_GET['powerId'])) $this->getPowerName();

		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['bond-delete'])){
                $this->flag();
                echo $this->result;

            } else {

                $this->validate();

                if ($this->options['bond-id']==-1){
                    $this->add();
                } else {
                    $this->edit();
                }

                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }

            }

            exit;

        }

	}

	private function validate() {
	    if(empty($this->options['bond-disposition'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        } else if(empty($this->options['bond-executeddate'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        } else if(empty($this->options['bond-amount'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        } else if(empty($this->options['bond-class'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        } else if(empty($this->options['bond-charge'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        } else if($this->options['bond-disposition']=='Forfeited') {
            if(empty($this->options['bond-forfeiteddate'])) {
			    $this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
            }
        } else if($this->options['bond-disposition']=='Disposed') {
            if(empty($this->options['bond-disposeddate'])) {
			    $this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
            }
        } else if (!empty($this->options['bond-setting'])){
            $setting = DateTime::createFromFormat('d M Y - h:i A', $this->options['bond-setting']);
            if ($setting==''){
                $this->error = '<div class="alert alert-error">Setting is Invalid.</div>';
            }
        }

	}

    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->options['bond-id']
		);

		$sql = "UPDATE `agency_bonds` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}

    private function add() {
		if (!empty($this->error)) return false;

		if(!empty($this->options['bond-settingdate'])){

			$timestamp = strtotime($this->options['bond-settingdate']);
			$this->settingdate = date('Y-m-d', $timestamp);

		}

		if(!empty($this->options['bond-settingtime'])){

			$time1 = strtotime($this->options['bond-settingtime']);
			$this->settingtime = date('H:i:s', $time1);

		}

		if(!empty($this->options['bond-executeddate'])){

			$timestamp1 = strtotime($this->options['bond-executeddate']);
			$this->executeddate = date('Y-m-d', $timestamp1);

		}

		if(!empty($this->options['bond-forfeitedddate'])){

			$timestamp2 = strtotime($this->options['bond-forfeitedddate']);
			$this->forfeitedddate = date('Y-m-d', $timestamp2);

		}

		if(!empty($this->options['bond-disposeddate'])){

			$timestamp3 = strtotime($this->options['bond-disposeddate']);
			$this->disposeddate = date('Y-m-d', $timestamp3);

		}

        if(isset($this->options['bond-amount'])){
            $amount = $this->options['bond-amount'];
            $amount = str_replace(",", "", $amount);
		}else{$amount = '';}

		if(isset($this->options['bond-transfer'])){
		    $transfer = 1 ;
		}else{
			$transfer = 0 ;
		}


		$params = array(
            ':amount'          => $amount,
            ':class'           => $this->options['bond-class'],
			':charge'          => $this->options['bond-charge'],
            ':casenumber'      => $this->options['bond-casenumber'],
            ':county'          => $this->options['bond-county'],
            ':court'           => $this->options['bond-court'],
			':disposition'      => $this->options['bond-disposition'],
			':executeddate'    => $this->executeddate,
			':setting'         => $this->settingdate.' '.$this->settingtime,
			':setfor'  		   => $this->options['bond-setfor'],
            ':attorney' 	   => $this->options['bond-attorney'],
			':forfeitedddate'  => $this->forfeitedddate,
			':forfeitedcomment'=> $this->options['bond-forfeitedcomment'],
			':disposeddate'	   => $this->disposeddate,
			':disposedcomment'  => $this->options['bond-disposedcomment'],
			':powers'           => $this->options['bond-powers'],
			':checkamount'      => $this->options['bond-checkamount'],
			':id'              => $this->options['client-id'],
			':transfer'        => $transfer
		);
        $sql = "INSERT INTO `agency_bonds` (`amount`,`class`,`charge`,`casenumber`,`county`,`court`,`client_id`,`disposition`,`executeddate`,`setting`,`setfor`,`attorney`,`forfeiteddate`,`forfeitedcomment`,`disposeddate`,`power_id`,`disposedcomment`,`checkamount`,`transfer`) VALUES (:amount,:class,:charge,:casenumber,:county,:court,:id,:disposition,:executeddate,:setting,:setfor,:attorney,:forfeitedddate,:forfeitedcomment,:disposeddate,:powers,:disposedcomment,:checkamount,:transfer);";

		parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    private function edit() {
		if(!empty($this->error))
			return false;

         if(!empty($this->options['bond-setting'])){
            $setting = DateTime::createFromFormat('d M Y - h:i A', $this->options['bond-setting']);
            $setting = $setting->format('Y-m-d H:i:s');
            $setting = strtotime($setting);
            $this->setting = date('Y-m-d  H:i:s', $setting);
		}

		if(!empty($this->options['bond-executeddate'])){
			$timestamp1 = strtotime($this->options['bond-executeddate']);
			$this->executeddate = date('Y-m-d', $timestamp1);
		}

		if(!empty($this->options['bond-forfeitedddate'])){
			$timestamp2 = strtotime($this->options['bond-forfeitedddate']);
			$this->forfeitedddate = date('Y-m-d', $timestamp2);
		}

		if(!empty($this->options['bond-disposeddate'])){
			$timestamp3 = strtotime($this->options['bond-disposeddate']);
			$this->disposeddate = date('Y-m-d', $timestamp3);
		}

        if(isset($this->options['bond-amount'])){
            $amount = $this->options['bond-amount'];
            $amount = str_replace(",", "", $amount);
		}else{$amount = '';}

		if(isset($this->options['bond-transfer'])){
		    $transfer = 1 ;
		}else{
			$transfer = 0 ;
		}

		$params = array(
            ':amount'        => $amount,
            ':class'         => $this->options['bond-class'],
			':charge'        => $this->options['bond-charge'],
            ':casenumber'    => $this->options['bond-casenumber'],
            ':county'        => $this->options['bond-county'],
            ':court'         => $this->options['bond-court'],
			':disposition'   => $this->options['bond-disposition'],
			':executeddate'   => $this->executeddate,
			':setting'        => $this->setting,
			':setfor'  		   => $this->options['bond-setfor'],
            ':attorney' 	   => $this->options['bond-attorney'],
			':forfeiteddate'   => $this->forfeitedddate,
			':forfeitedcomment'=> $this->options['bond-forfeitedcomment'],
			':disposeddate'    => $this->disposeddate,
			':disposedcomment' => $this->options['bond-disposedcomment'],
			':powerid'        => $this->options['bond-powers'],
			'checkamount' => $this->options['bond-checkamount'],
		    ':id'   		   => $this->options['bond-id'],
			':transfer'        => $transfer

		);
		$sql = "UPDATE `agency_bonds` SET `amount` = :amount,`transfer`= :transfer,`class` = :class, `charge` = :charge, `casenumber` = :casenumber,`county` = :county,`court` = :court, `disposition`= :disposition,`executeddate`= :executeddate,`setting`= :setting,`setfor`= :setfor,`attorney`= :attorney,`forfeiteddate`= :forfeiteddate,`forfeitedcomment`= :forfeitedcomment,`disposeddate`= :disposeddate,`disposedcomment`= :disposedcomment,`power_id`= :powerid,`checkamount`= :checkamount  WHERE `id` = :id;";
	    parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
}

    public function getBonds($id) {
        $sql = "SELECT * FROM agency_bonds WHERE flag = 0 AND client_id=".$id;
		$stmt = parent::query($sql);

		if ( $stmt->rowCount() < 1 ) {
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return false;
		} else {
            $bonds_res = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

                    if(!empty($row['setting'])){
						$setting = strtotime($row['setting']);
						$this->setting = date('d F Y - h:i A', $setting);
					}else{ $this->setting ="";}

					if(!empty($row['executeddate'])){
						$timestamp1 = strtotime($row['executeddate']);
						$this->executeddate = date('m/d/Y', $timestamp1);
					}else{ $this->executeddate ="";}

					if(!empty($row['forfeiteddate'])){
						$timestamp2 = strtotime($row['forfeiteddate']);
						$this->forfeitedddate = date('m/d/Y', $timestamp2);
					}else{ $this->forfeitedddate = "" ;}

					if(!empty($row['disposeddate'])){
						$timestamp3 = strtotime($row['disposeddate']);
						$this->disposeddate = date('m/d/Y', $timestamp3);
					}else{ $this->disposeddate = "" ;}

					  $bonds_res[] = array(
						'id' => $row['id'],
						'amount' => $row['amount'],
						'class' => $row['class'],
						'charge' => $row['charge'],
						'casenumber' => $row['casenumber'],
						'county' => $row['county'],
						'court' => $row['court'],
						'executeddate' => $this->executeddate,
						'disposition' => $row['disposition'],
						'setting' => $this->setting,
						'attorney' => $row['attorney'],
						'setfor' => $row['setfor'],
						'forfeiteddate' => $this->forfeitedddate,
						'forfeitedcomment' => $row['forfeitedcomment'],
						'disposeddate' => $this->disposeddate,
						'disposedcomment' => $row['disposedcomment'],
						'power_id' => $row['power_id'],
						'report_id' => $row['report_id'],
						'checkamount' => $row['checkamount'],
						'transfer' => $row['transfer'],
						);

			}
		}
		return json_encode($bonds_res);
	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

	public function getPowerName(){

		 $id = $_GET['powerId'];
		$sql = 'SELECT
            agency_powers.id,
            agency_powers.prefix,
            agency_powers.serial,
            agency_bonds.power_id
            FROM
            agency_powers
            LEFT JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
            WHERE agency_bonds.power_id = '.$id.' LIMIT 1';

		$stmt = parent::query($sql);
		$powers = '';
		if ($stmt->rowCount() > 0) {
			$this->powers = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$ids         = $row['id'];
				$serial     = $row['serial'];
				$prefix      = $row['prefix'];
                $powers .= $prefix.'-'.$serial;
			}
		}
				echo $powers;

	}


}

$clientbond = new Client_bond();

?>