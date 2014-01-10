<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Settings_geo extends Generic {

	private $options = array();

    function __construct() {
		
        $this->grab();

		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

					$this->validate();
                    $this->edit();
               
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            exit;

        }

	}

	private function validate() {
	    if(empty($this->options['geo-address'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter a value.').'</div>';
        }
	}

    private function edit() {
		if(!empty($this->error))
			return false;

		$params = array(
		   ':address'  => $this->options['geo-address'],
           ':city'    => $this->options['geo-city'],
           ':state'    => $this->options['geo-state'],
           ':zip'    => $this->options['geo-zip'],
           ':latitude'    => $this->options['geo-latitude'],
           ':longitude'    => $this->options['geo-longitude'],
		   ':id'           => $this->options['id']
		);

		$sql = "UPDATE `agency_settings_geo` SET `address` = :address, `city` = :city, `state` = :state, `zip` = :zip, `latitude` = :latitude, `longitude` = :longitude WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';

	}


    private function grab() {

		$stmt   = parent::query("SELECT * FROM agency_settings_geo WHERE id = 1");

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		   $this->options[$field] = $value;
	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$settingsgeo = new Settings_geo();

?>