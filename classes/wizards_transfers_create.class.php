<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_transfers_create extends Generic {

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
	    if(empty($this->options['transfer-create-date'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
		} else if(empty($this->options['transfer-create-amount'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
        }
	}

    private function add() {
		$timestamp = strtotime($this->options['transfer-create-date']);
        $this->transferdate = date('Y-m-d H:i:s', $timestamp);
        $stamp  = date('Y-m-d H:i:s');

        if(isset($this->options['transfer-create-amount'])){
            $amount = $this->options['transfer-create-amount'];
            $this->amount = str_replace(",", "", $amount);
		}else{$this->amount = '';}

        $date                   = $this->transferdate;
        $amount	                = $this->amount;
        $requestingagent        = $this->options['transfer-create-requesting-agent-select'];
        $requestingagent_id     = $this->options['requestingagent_id'];
        $county                 = $this->options['transfer-create-county-select'];
        $comment                = $this->options['transfer-create-comment'];
		$user_id = $_SESSION['nware']['user_id'];

        if ($comment!=''){
            $comment = "<p>".$comment."</p>";
        }
        $comment = str_replace("'", '"', $comment);

		$sql = "INSERT INTO general_transfers(`type`,`date`,`amount`,`requestingagent`,`requestingagent_id`,`county`) VALUES('recorded','$date','$amount','$requestingagent','$requestingagent_id','$county')";
		$stmt = parent::query($sql);
		$id = parent::$dbh->lastInsertId();

        $sql1 = "INSERT INTO general_transfers_notes (`stamp`,`comment`,`transfer_id`,`user_id`)VALUE('$stamp','$comment','$id','$user_id')";
	    $stmt1 = parent::query($sql1);

		echo "<div class='alert alert-success' id='status'>".$id."</div>";
	}
 }

$wizardstransferscreate = new Wizards_transfers_create();
?>