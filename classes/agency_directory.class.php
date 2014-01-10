<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Agency_directory extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['directory-delete'])){
                $this->flag();
                echo $this->result;

            } else {

                $this->validate();

                if ($this->options['directory-id']==-1){
                    $this->unique();
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
	    if(empty($this->options['directory-name'])) {
			$this->error = '<div class="alert alert-error">You must enter a Name</div>';
        }
	}

    private function unique() {

        global $generic;
        $sql = $sql = "SELECT * FROM agency_directory WHERE name = '" . $this->options['directory-name'] . "' AND flag = 0";
        $query = $generic->query($sql);

		if( $query->rowCount() > 0 ){
            $this->error = '<div class="alert alert-error">Record already exists</div>';
        }
    }


    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->options['directory-id']
		);

		$sql = "UPDATE `agency_directory` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}

    private function add() {

		if (!empty($this->error)) return false;

		$params = array(
            ':type'         => $this->options['directory-type'],
            ':name'         => $this->options['directory-name'],
		    ':address'      => $this->options['directory-address'],
            ':city'  	    => $this->options['directory-city'],
		    ':state'  	    => $this->options['directory-state'],
		    ':zip'  		=> $this->options['directory-zip'],
            ':latitude'	    => $this->options['directory-latitude'],
            ':longitude'	=> $this->options['directory-longitude'],
		    ':phone1type'   => $this->options['directory-phone1type'],
		    ':phone1'  	    => $this->options['directory-phone1'],
		    ':phone2type'   => $this->options['directory-phone2type'],
		    ':phone2'  	    => $this->options['directory-phone2'],
		    ':phone3type'   => $this->options['directory-phone3type'],
		    ':phone3'  	    => $this->options['directory-phone3'],
		    ':email'  	    => $this->options['directory-email'],
		    ':website'  	=> $this->options['directory-website'],
            ':isvalid'	    => $this->options['directory-isvalid']
        );

        $sql = "INSERT INTO `agency_directory` (`type`,`name`,`address`,`city`,`state`,`zip`,`latitude`,`longitude`,`phone1type`,`phone1`,`phone2type`,`phone2`,`phone3type`,`phone3`,`email`,`website`,`isvalid`) VALUES (:type,:name,:address,:city,:state,:zip,:latitude,:longitude,:phone1type,:phone1,:phone2type,:phone2,:phone3type,:phone3,:email,:website,:isvalid);";

		parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    private function edit() {

		if(!empty($this->error))
			return false;

            $id             = $this->options['directory-id'];
            $type           = $this->options['directory-type'];
            $name           = $this->options['directory-name'];
		    $address        = $this->options['directory-address'];
            $city  	        = $this->options['directory-city'];
		    $state  	    = $this->options['directory-state'];
		    $zip  		    = $this->options['directory-zip'];
            $latitude	    = $this->options['directory-latitude'];
            $longitude	    = $this->options['directory-longitude'];
		    $phone1type     = $this->options['directory-phone1type'];
		    $phone1  	    = $this->options['directory-phone1'];
		    $phone2type     = $this->options['directory-phone2type'];
		    $phone2  	    = $this->options['directory-phone2'];
		    $phone3type     = $this->options['directory-phone3type'];
		    $phone3  	    = $this->options['directory-phone3'];
		    $email  	    = $this->options['directory-email'];
		    $website  	    = $this->options['directory-website'];
            $isvalid	    = $this->options['directory-isvalid'];

		$sql = "UPDATE `agency_directory` SET `type` = '$type',`name` = '$name',`address` = '$address',`city` = '$city',`state` = '$state',`zip` = '$zip',`latitude` = '$latitude',`longitude` = '$longitude',`phone1type` = '$phone1type',`phone1` = '$phone1',`phone2type` = '$phone2type',`phone2` = '$phone2',`phone3type` = '$phone3type',`phone3` = '$phone3',`email` = '$email',`website` = '$website',`isvalid` = '$isvalid'  WHERE `id` = '$id'";

        parent::query($sql);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';

	}

    public function getDirectory() {
	    $sql = "SELECT * FROM agency_directory WHERE flag = 0";
    	$stmt = parent::query($sql);

		if ( $stmt->rowCount() < 1 ) {
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return false;
		} else {

            $directory_res = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $directory_res[] = array(
                'id'        => $row['id'],
                'type'      => $row['type'],
                'name'      => $row['name'],
                'address'   => $row['address'],
                'city'      => $row['city'],
                'state'     => $row['state'],
                'zip'       => $row['zip'],
                'latitude'  => $row['latitude'],
                'longitude' => $row['longitude'],
                'phone1type'=> $row['phone1type'],
                'phone1'    => $row['phone1'],
                'phone2type'=> $row['phone2type'],
                'phone2'    => $row['phone2'],
                'phone3type'=> $row['phone3type'],
                'phone3'    => $row['phone3'],
                'email'     => $row['email'],
                'website'   => $row['website'],
                'isvalid'   => $row['isvalid'],
                );
			}
		}

		return json_encode($directory_res);
	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$agencydirectory = new Agency_directory();

?>