<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Agent extends Generic {

	private $options = array();
    private $location_data;

	function __construct() {

		if(!empty($_GET['id'])) $this->grab();

		if(!empty($_GET['map'])) $this->agentGeo();

		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['agent-delete'])){
                $this->aid = parent::secure($_POST['agent-id']);
                $this->flag();
                echo $this->result;
            }

            else if (!empty($_POST['agent-action'])){
                $action = parent::secure($_POST['agent-action']);
                switch ($action) {
                    case 'contract':
                        $id = parent::secure($_POST['agent-id']);
                        $this->contract($id);
                        echo $this->result;
                        return;
                    case 'reject':
                        $id = parent::secure($_POST['agent-id']);
                        $this->reject($id);
                        echo $this->result;
                        return;
                    case 'delete':
                        $id = parent::secure($_POST['agent-id']);
                        $this->delete($id);
                        echo $this->result;
                        return;
                    case 'revert':
                        $id = parent::secure($_POST['agent-id']);
                        $this->revert($id);
                        echo $this->result;
                        return;
                }
            }

			else if (!empty($_POST['personal-id'])){
                $this->type 	 = parent::secure($_POST['personal-type']);
                $this->company 	 = parent::secure($_POST['personal-company']);
                $this->contact 	 = parent::secure($_POST['personal-contact']);
                $this->pid   	 = parent::secure($_POST['personal-id']);

			   if($this->pid > -1 ){
			    $this->validatepersonal();
                $this->editpersonal();
			   }else{
				  $this->validatepersonal();
                  $this->addagent();
				}
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            }
			
			else if (!empty($_POST['detail-id'])){
                $this->address 	 = parent::secure($_POST['detail-address']);
                $this->city 	 = parent::secure($_POST['detail-city']);
                $this->state 	 = parent::secure($_POST['detail-state']);
                $this->zip   	 = parent::secure($_POST['detail-zip']);
                $this->phone1type= parent::secure($_POST['detail-phone1type']);
                $this->phone1    = parent::secure($_POST['detail-phone1']);
                $this->phone2type= parent::secure($_POST['detail-phone2type']);
                $this->phone2    = parent::secure($_POST['detail-phone2']);
                $this->phone3type= parent::secure($_POST['detail-phone3type']);
                $this->phone3    = parent::secure($_POST['detail-phone3']);
                $this->detailid    = parent::secure($_POST['detail-id']);

			    $this->validatedetail();
                $this->editdetail();
			   
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

	    if(isset($this->type) && empty($this->type)) {
			$this->error = '<div class="alert alert-error">You must select a Agent type</div>';
        }
	    if(empty($this->company)) {
			$this->error = '<div class="alert alert-error">You must enter a Company</div>';
        }
	    if(empty($this->contact)) {
			$this->error = '<div class="alert alert-error">You must enter a Contact</div>';
        }
	}

    private function validatedetail() {
		
	    if( empty($this->phone1type)) {
			$this->error = '<div class="alert alert-error">You must select a Primary Phone type</div>';
        }
	    if(empty( $this->phone1)) {
			$this->error = '<div class="alert alert-error">You must enter a Primary Phone</div>';
        }

	}

    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->aid
		);

		$sql = "UPDATE `general_agents` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}
	
    private function addagent() {
		if(!empty($this->error))
			return false;

		$params = array(
			':type'     	 =>$this->options['personal-type'],
			':company'     	 =>$this->options['personal-company'],
			':contact'     	 =>$this->options['personal-contact'],
			':address'     	 =>$this->options['personal-address'],
			':city'     	 =>$this->options['personal-city'],
			':state'     	 =>$this->options['personal-state'],
			':zip'     	     =>$this->options['personal-zip'],
			':latitude'      =>$this->options['personal-latitude'],
			':longitude'     =>$this->options['personal-longitude'],
			':phone1type'    =>$this->options['personal-phone1type'],
			':phone1'     	 =>$this->options['personal-phone1'],
			':phone2type'    =>$this->options['personal-phone2type'],
			':phone2'     	 =>$this->options['personal-phone2'],
			':phone3type'    =>$this->options['personal-phone3type'],
			':phone3'     	 =>$this->options['personal-phone3'],
			':email'     	 =>$this->options['personal-email'],
		);

		$sql = "INSERT INTO  `general_agents`  (`type`,`company`, `contact`, `address`, `city`, `state`, `zip`, `latitude`, `longitude`, `phone1type`, `phone1`, `phone2type`, `phone2`, `phone3type`, `phone3`,`email`) VALUES (:type,:company,:contact,:address,:city,:state,:zip,:latitude,:longitude,:phone1type,:phone1,:phone2type,:phone2,:phone3type,:phone3,:email);";

        $stmt = parent::query($sql, $params);
        $this->result = '<div class="alert alert-success">Successfully edited record</div>';

	}





    private function editpersonal() {

		if(!empty($this->error))
			return false;

		$params = array(
			':company'     	 =>$this->options['personal-company'],
			':contact'     	 =>$this->options['personal-contact'],
			':address'     	 =>$this->options['personal-address'],
			':city'     	 =>$this->options['personal-city'],
			':state'     	 =>$this->options['personal-state'],
			':zip'     	     =>$this->options['personal-zip'],
			':latitude'      =>$this->options['personal-latitude'],
			':longitude'     =>$this->options['personal-longitude'],
			':phone1type'    =>$this->options['personal-phone1type'],
			':phone1'     	 =>$this->options['personal-phone1'],
			':phone2type'    =>$this->options['personal-phone2type'],
			':phone2'     	 =>$this->options['personal-phone2'],
			':phone3type'    =>$this->options['personal-phone3type'],
			':phone3'     	 =>$this->options['personal-phone3'],
			':email'     	 =>$this->options['personal-email'],
			':id'       	 => $this->pid
		);

		$sql = "UPDATE `general_agents` SET `company` = :company, `contact` = :contact, `address` = :address, `city` = :city, `state` = :state, `zip` = :zip, `latitude` = :latitude, `longitude` = :longitude, `phone1type` = :phone1type, `phone1` = :phone1, `phone2type` = :phone2type, `phone2` = :phone2, `phone3type` = :phone3type, `phone3` = :phone3,  `email` = :email WHERE `id` = :id;";

        $stmt = parent::query($sql, $params);
        $this->result = '<div class="alert alert-success">Successfully edited record</div>';

	}
	
	
    private function editdetail() {

		if(!empty($this->error))
			return false;

		$params = array(
			':address'     	 =>$this->options['detail-address'],
			':city'     	 =>$this->options['detail-city'],
			':state'     	 =>$this->options['detail-state'],
			':zip'     	     =>$this->options['detail-zip'],
			':phone1type'    =>$this->options['detail-phone1type'],
			':phone1'     	 =>$this->options['detail-phone1'],
			':phone2type'    =>$this->options['detail-phone2type'],
			':phone2'     	 =>$this->options['detail-phone2'],
			':phone3type'    =>$this->options['detail-phone3type'],
			':phone3'     	 =>$this->options['detail-phone3'],
			':id'       	 =>$this->detailid 
		);

		$sql = "UPDATE `general_agents` SET  `address` = :address, `city` = :city, `state` = :state, `zip` = :zip,  `phone1type` = :phone1type, `phone1` = :phone1, `phone2type` = :phone2type, `phone2` = :phone2, `phone3type` = :phone3type, `phone3` = :phone3 WHERE `id` = :id;";

        $stmt = parent::query($sql, $params);
        $this->result = '<div class="alert alert-success">Successfully edited record</div>';

	}
	
	

    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM general_agents WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

    private function contract($id){
	    if(!empty($this->error))
		    return false;

        $this->cdate = date('Y-m-d');

        $net = $this->options['agent-net'];
        $net = $net/1000;
        $buf = $this->options['agent-buf'];
        $buf = $buf/1000;

		$params = array(
            ':date'       => $this->cdate,
            ':net'        => $net,
            ':netminimum' => $this->options['agent-netminimum'],
            ':buf'  	  => $buf,
            ':bufminimum' => $this->options['agent-bufminimum'],
            ':id'         => $this->options['agent-id']
		);

        $sql = "INSERT INTO `general_agents_contracts` (`date`,`net`,`netminimum`,`buf`,`bufminimum`,`agent_id`) VALUES (:date,:net,:netminimum,:buf,:bufminimum,:id);";
        parent::query($sql, $params);

        $params = array(
            ':type' => 'Contracted',
            ':id' => $id
		);

		$sql = "UPDATE `general_agents` SET `type` = :type WHERE `id` = :id;";
        parent::query($sql, $params);

        $this->result = '<div class="alert alert-success">Successfully contracted Prospect</div>';

	}

    private function reject($id){
	    if(!empty($this->error))
		    return false;

		$params = array(
            ':type' => 'Rejected',
            ':rejectreason' => $this->options['agent-rejectreason-select'],
            ':id' => $id
		);

		$sql = "UPDATE `general_agents` SET `type` = :type, `rejectedreason` = :rejectreason WHERE `id` = :id;";

        parent::query($sql, $params);

		$this->result = '<div class="alert alert-success">Successfully rejected Agent</div>';

	}

    private function revert($id){
	    if(!empty($this->error))
		    return false;

		$params = array(
            ':type' => 'Candidate',
            ':rejectreason' => '',
            ':id' => $id
		);

		$sql = "UPDATE `general_agents` SET `type` = :type, `rejectedreason` = :rejectreason WHERE `id` = :id;";

        parent::query($sql, $params);

		$this->result = '<div class="alert alert-success">Successfully reverted Agent</div>';

	}

    private function delete($id){
	    if(!empty($this->error))
		    return false;

		$params = array(
            ':flag' => '1',
            ':id' => $id
		);

		$sql = "UPDATE `general_agents` SET `flag` = :flag WHERE `id` = :id;";
        $sql1 = "DELETE FROM  `general_users_histories`  WHERE `link` = 'agent.php?id=".$id."';";

        parent::query($sql, $params);
        parent::query($sql1, $params);

        $this->result = '<div class="alert alert-success">Successfully deleted Agent</div>';

	}

	function agentGeo(){
		$stmt = parent::query("SELECT latitude, longitude FROM general_agents");

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

    function contractSummary( $id ){

        $sql = "SELECT
        count(general_agents_contracts.date) as countcontracted,
        min(general_agents_contracts.date) as firstcontracted
        FROM
        general_agents_contracts
        WHERE general_agents_contracts.agent_id = ".$id;
		$stmt = parent::query($sql);
		$contractSummmary = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
		    $contractSummmary =  array(
			    'Count' => $row['countcontracted'],
				'First' => $row['firstcontracted']
		    );
		}
		return $contractSummmary ;

	}

    function netSummary($id){
        $sql = "SELECT
        general_agents.accountnetbalance,
        sum(general_agents_accounts.debit) as debit
        FROM
        general_agents
        INNER JOIN general_agents_accounts ON general_agents_accounts.agent_id = general_agents.id
        WHERE general_agents_accounts.type = 'net' AND general_agents.id=".$id;

        $stmt = parent::query($sql);
		$netSummmary = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
		    $netSummmary =  array(
			    'Balance' => $row['accountnetbalance'],
				'Debit' => $row['debit']
		    );
		}
		return $netSummmary ;
    }

    function bufSummary($id){
        $sql = "SELECT
        general_agents.accountbufbalance,
        sum(general_agents_accounts.debit) as debit
        FROM
        general_agents
        INNER JOIN general_agents_accounts ON general_agents_accounts.agent_id = general_agents.id
        WHERE general_agents_accounts.type = 'buf' AND general_agents.id=".$id;

        $stmt = parent::query($sql);
		$bufSummmary = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
		    $bufSummmary =  array(
			    'Balance' => $row['accountbufbalance'],
				'Debit' => $row['debit']
		    );
		}
		return $bufSummmary ;
    }

}
$agent = new Agent();

?>