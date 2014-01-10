<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Client_avatar extends Generic {

	private $options = array();

    function __construct() {
		
        if(!empty($_GET['mugshot'])) $this->add();
		
	}


    private function add() {
		
		if(!empty($this->error))
			return false;
		
		$params = array(
           ':client_id'  => $_GET['client_id'],		   
		);
		
		$params1 = array(
           ':folder'     => 'root',
           ':file'       => $_GET['file'],
           ':type'       => 'Image',
           ':client_id'  => $_GET['client_id'],
		   ':mugshot'    => 1
		);
		
		
    
		$sql = "UPDATE `agency_clients_documents` SET `mugshot` = 0  WHERE `client_id` = :client_id;";
        if(parent::query($sql, $params)){
			
			$sql1 = "INSERT INTO `agency_clients_documents` (`folder`,`file`,`type`,`client_id`,`mugshot`) VALUES (:folder,:file,:type,:client_id,:mugshot);";
			parent::query($sql1, $params1);
			
		}
		
		return  ' edited record.';

	}

}

$clientavatar = new Client_avatar();

?>