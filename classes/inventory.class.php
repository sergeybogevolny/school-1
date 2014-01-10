<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Inventory extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['detail-void'])){
				 $this->voidvalidate();
                $this->flag();
			    if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }

            } else {

                $this->validate();

                if ($this->options['bond-id']== ''){
					
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
		
	    if(empty($this->options['detail-name'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        } else if(empty($this->options['detail-executeddate'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        } else if(empty($this->options['detail-amount'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        }
	}
	
	private function voidvalidate() {
		
	    if(empty($this->options['detail-voided'])) {
			$this->error = '<div class="alert alert-error">Required field(s) missing value.</div>';
        }
	}
	
	private function flag() {

		if(!empty($this->error))
			return false;
		
		if(!empty($this->options['detail-voided'])){
			$timestamp1 = strtotime($this->options['detail-voided']);
			$this->voided = date('Y-m-d', $timestamp1);
		}

			
			
        $date = $this->voided;
		$powerid  = $this->options['power-id'];
		$sql = "DELETE FROM `agency_bonds`  WHERE `power_id` = $powerid;";
        parent::query($sql);
		
		$sql1 = "UPDATE `agency_powers` SET `void` = 1 , `void_date` = '$date' WHERE id = '$powerid'";
		parent::query($sql1);
		
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';
			
	}
	
	

    private function add() {

		if(!empty($this->error))
			return false;

		if(!empty($this->options['detail-executeddate'])){

			$timestamp1 = strtotime($this->options['detail-executeddate']);
			$this->executeddate = date('Y-m-d', $timestamp1);

		}
		
		if(!empty($this->options['detail-voided'])){
			$timestamp1 = strtotime($this->options['detail-voided']);
			$this->voided = date('Y-m-d', $timestamp1);
		}

        if(isset($this->options['detail-amount'])){
            $amount = $this->options['detail-amount'];
            $amount = str_replace(",", "", $amount);
		}else{$amount = '';}

		if(isset($this->options['detail-transfer'])){
		    $transfer = 1 ;
		}else{
			$transfer = 0 ;
		}
		
	   if(isset($this->options['detail-void'])){
		    $void = 1 ;
		}else{
			$void = 0 ;
		}
		
		$executeddate = $this->executeddate;
		$voided       = $this->voided;
		$name     = $this->options['detail-name'];
		$id       = $this->options['bond-id'];
		$powerid  = $this->options['power-id'];
        $sql = "INSERT INTO `agency_bonds` (`name`,`executeddate`,`amount`, `power_id`,`transfer`) VALUES ('$name','$executeddate','$amount','$powerid','$transfer');";
		parent::query($sql);
		
		$sql1 = "UPDATE `agency_powers` SET `void` = '$void',`void_date` = '$voided' WHERE id = '$powerid'";
		parent::query($sql1);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    private function edit() {
		
		//print_r($_POST); die();
		if(!empty($this->error))
			return false;

		if(!empty($this->options['detail-executeddate'])){

			$timestamp1 = strtotime($this->options['detail-executeddate']);
			$this->executeddate = date('Y-m-d', $timestamp1);

		}


        if(isset($this->options['detail-amount'])){
            $amount = $this->options['detail-amount'];
            $amount = str_replace(",", "", $amount);
		}else{$amount = '';}

		if(isset($this->options['detail-transfer'])){
		    $transfer = 1 ;
		}else{
			$transfer = 0 ;
		}
		
		$executeddate = $this->executeddate;
		$name     = $this->options['detail-name'];
		$id       = $this->options['bond-id'];
		$powerid  = $this->options['power-id'];
		
		print_r($executeddate); 

		$sql = "UPDATE `agency_bonds` SET `amount` = '$amount',`transfer`= '$transfer',`executeddate` = '$executeddate', `power_id` = '$powerid', `name` = '$name' WHERE `id` = $id;";
	    
		parent::query($sql);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
}

    public function getUnreported() {
        $sql = "SELECT
        agency_powers.id,
        agency_powers.prefix,
        agency_powers.serial,
        agency_settings_lists_prefixs.amount AS `value`,
        agency_bonds.power_id,
        agency_powers.void,
		agency_powers.void_date,
		agency_bonds.id as bond_id,
        agency_bonds.executeddate,
        agency_bonds.`name`,
        agency_bonds.amount,
        agency_bonds.transfer,
        general_powers.agent_id
        FROM
        agency_powers
        INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
        LEFT JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
        INNER JOIN general_powers ON agency_powers.serial = general_powers.serial AND agency_powers.prefix = general_powers.prefix
        WHERE agency_powers.report_id IS NULL AND general_powers.agent_id=1";

		$stmt = parent::query($sql);

		if ( $stmt->rowCount() < 1 ) {
		    //echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return true;
		} else {
            $res = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

					if(!empty($row['executeddate'])){
						$timestamp1 = strtotime($row['executeddate']);
						$this->executeddate = date('m/d/Y', $timestamp1);
					}else{ $this->executeddate ="";}

					if(!empty($row['void_date']) && $row['void_date'] != '0000-00-00'){
						$timestamp1 = strtotime($row['void_date']);
						$this->voiddate = date('m/d/Y', $timestamp1);
					}else{ $this->voiddate ="";}

                    if(!empty($row['value'])){
						$value = strtotime($row['value']);
                        $this->value = number_format($value, 2, '.', ',');
					}else{ $this->value ="";}

                    if(!empty($row['amount'])){
						$amount = $row['amount'];
                        $this->amount = number_format($amount, 2, '.', ',');
					}else{ $this->amount ="";}
                   // print_r($row['amount']);
					$res[] = array(
						'id' => $row['id'],
						'prefix' => $row['prefix'],
						'serial' => $row['serial'],
						'value' => $this->value,
						'power_id' => $row['power_id'],
						'void' => $row['void'],
						'voiddate'=>$this->voiddate,
						'executeddate' => $this->executeddate,
						'name' => $row['name'],
						'amount' => $this->amount,
						'transfer' => $row['transfer'],
                        'agent_id' => $row['agent_id'],
						'bond_id'  => $row['bond_id']
					);

			}
		}
		return json_encode($res);
	}

	public function getField($field) {
		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$inventory = new Inventory();

?>