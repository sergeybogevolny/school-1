<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Client_reference extends Generic {

	private $options = array();

    function __construct() {
		

		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

		    if (!isset($_POST['reference-indemnify'])){
                $this->options['reference-indemnify']= 0;
            } else {
                $this->options['reference-indemnify']= 1;
            }
		   
		    if (!isset($_POST['reference-caller'])){
                $this->options['reference-caller']= 0;
            } else {
                $this->options['reference-caller']= 1;
            }
			

            if (!empty($_POST['reference-delete'])){
                $this->flag();
                echo $this->result;

            } else {

                $this->validate();

                if ($this->options['reference-id']==-1){
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
	    if(empty($this->options['reference-last'])) {
			$this->error = '<div class="alert alert-error">You must enter a Last Name</div>';
        } else if(empty($this->options['reference-first'])) {
			$this->error = '<div class="alert alert-error">You must enter a First Name</div>';
        }
	}

    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->options['reference-id']
		);

		$sql = "UPDATE `agency_clients_references` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}

    private function add() {

		if (!empty($this->error)) return false;

		$params = array(
            ':last'          => $this->options['reference-last'],
            ':first'         => $this->options['reference-first'],
            ':middle'        => $this->options['reference-middle'],
            ':address'	     => $this->options['reference-address'],
            ':city'	         => $this->options['reference-city'],
            ':state'	     => $this->options['reference-state'],
            ':zip'	         => $this->options['reference-zip'],
            ':latitude'	     => $this->options['reference-latitude'],
            ':longitude'	 => $this->options['reference-longitude'],
            ':isvalid'	     => $this->options['reference-isvalid'],
			':phone1type'	 => $this->options['reference-phone1type'],
			':phone1'		 => $this->options['reference-phone1'],
			':phone2type'	 => $this->options['reference-phone2type'],
			':phone2'		 => $this->options['reference-phone2'],
			':phone3type'	 => $this->options['reference-phone3type'],
			':phone3'		 => $this->options['reference-phone3'],
			':phone4type'	 => $this->options['reference-phone4type'],
			':phone4'		 => $this->options['reference-phone4'],
            ':relation'	     => $this->options['reference-relation'],
			':caller'	 => $this->options['reference-caller'],
			':indemnify'	 => $this->options['reference-indemnify'],
            ':id'            => $this->options['client-id']
		);

        $sql = "INSERT INTO `agency_clients_references` (`last`,`first`,`middle`,`address`,`city`,`state`,`zip`,`latitude`,`longitude`,`isvalid`,`phone1type`,`phone1`,`phone2type`,`phone2`,`phone3type`,`phone3`,`phone4type`,`phone4`,`relation`,`indemnify`,`client_id`,`caller`) VALUES (:last,:first,:middle,:address,:city,:state,:zip,:latitude,:longitude,:isvalid,:phone1type,:phone1,:phone2type,:phone2,:phone3type,:phone3,:phone4type,:phone4,:relation,:indemnify,:id,:caller);";
      	parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    private function edit() {

		if(!empty($this->error))
			return false;

		$timestamp = strtotime($this->options['reference-dob']);
        $this->dobconverted = date('Y-m-d', $timestamp);
		$params = array(
		    ':last'          => $this->options['reference-last'],
            ':first'         => $this->options['reference-first'],
            ':middle'        => $this->options['reference-middle'],
            ':address'	     => $this->options['reference-address'],
            ':city'	         => $this->options['reference-city'],
            ':state'	     => $this->options['reference-state'],
            ':zip'	         => $this->options['reference-zip'],
            ':latitude'	     => $this->options['reference-latitude'],
            ':longitude'	 => $this->options['reference-longitude'],
            ':isvalid'	     => $this->options['reference-isvalid'],
			':phone1type'	 => $this->options['reference-phone1type'],
			':phone1'		 => $this->options['reference-phone1'],
			':phone2type'	 => $this->options['reference-phone2type'],
			':phone2'		 => $this->options['reference-phone2'],
			':phone3type'	 => $this->options['reference-phone3type'],
			':phone3'		 => $this->options['reference-phone3'],
			':phone4type'	 => $this->options['reference-phone4type'],
			':phone4'		 => $this->options['reference-phone4'],
            ':relation'	     => $this->options['reference-relation'],
			':caller'	     => $this->options['reference-caller'],
			':indemnify'	 => $this->options['reference-indemnify'],
            ':id'            => $this->options['reference-id']
		);

		$sql = "UPDATE `agency_clients_references` SET `last` = :last, `first` = :first, `middle` = :middle, `address` = :address, `city` = :city, `state` = :state, `zip` = :zip, `latitude` = :latitude, `longitude` = :longitude, `isvalid` = :isvalid, `phone1type` = :phone1type, `phone1` = :phone1, `phone2type` = :phone2type, `phone2` = :phone2, `phone3type` = :phone3type, `phone3` = :phone3, `phone4type` = :phone4type, `phone4` = :phone4,  `relation` = :relation,  `caller` = :caller, `indemnify` = :indemnify  WHERE `id` = :id;";

        $stmt = parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';

	}

    public function getReferences($id) {
        $sql = "SELECT * FROM agency_clients_references WHERE FLAG = 0 AND client_id=".$id ;
		$stmt = parent::query($sql);
		if ( $stmt->rowCount() < 1 ) {
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return false;
		} else {
            $reference_res = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				if($row['document_application'] == NULL){
				   $application = '';
				}else{
				   $application = $row['document_application'];
				}

                $reference_res[] = array(
                'id' => $row['id'],
                'last' => $row['last'],
                'first' => $row['first'],
                'middle' => $row['middle'],
                'address' => $row['address'],
                'city' => $row['city'],
                'state' => $row['state'],
                'zip' => $row['zip'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'isvalid' => $row['isvalid'],
                'phone1type' => $row['phone1type'],
                'phone1' => $row['phone1'],
                'phone2type' => $row['phone2type'],
                'phone2' => $row['phone2'],
                'phone3type' => $row['phone3type'],
                'phone3' => $row['phone3'],
                'phone4type' => $row['phone4type'],
                'phone4' => $row['phone4'],
                'relation' => $row['relation'],
                'caller' => $row['caller'],
                'indemnify' => $row['indemnify'],
                'application' => $row['document_application']
                );
			}
		}

		return json_encode($reference_res);
	}
	

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$clientreference = new Client_reference();

?>