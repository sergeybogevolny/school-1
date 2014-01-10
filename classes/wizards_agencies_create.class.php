<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_powers_order extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {

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
   
   private function validate() {
	    if(empty($this->options['agency-type'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
		} else if(empty($this->options['agency-company'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
        }
	}
	

    private function add() {
		
        $type	                = $this->options['agency-type'];
        $company	            = $this->options['agency-company'];
        $contact	            = $this->options['agency-contact'];
        $address	            = $this->options['agency-address'];
        $city	                = $this->options['agency-city'];
        $state	                = $this->options['agency-state'];
        $zip	                = $this->options['agency-zip'];
        $phone1	                = $this->options['agency-phone1'];
        $phone2	                = $this->options['agency-phone2'];
        $phone3	                = $this->options['agency-phone3'];
        $phone1type	            = $this->options['agency-phone1type'];
        $phone2type	            = $this->options['agency-phone2type'];
        $phone3type	            = $this->options['agency-phone3type'];
        $email	                = $this->options['agency-email'];
		$user_id 				= $_SESSION['nware']['user_id'];

		$sql = "INSERT INTO general_agents(`type`,`company`,`contact`,`address`,`city`,`state`,`zip`,`phone1`,`phone2`,`phone3`,`phone1type`,`phone2type`,`phone3type`,`email`) VALUES('$type','$company','$contact','$address','$city','$state','$zip','$phone1','$phone2','$phone3','$phone1type','$phone2type','$phone3type','$email')";
	    $stmt = parent::query($sql);
		echo "<div class='alert alert-success' id='status'>success</div>";
	}

}

$wizardspowersorder = new Wizards_powers_order();
?>