<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class General_transfer extends Generic {

	private $options = array();

    function __construct() {
		
         if(!empty($_GET['id'])) $this->grab();		

		if(!empty($_POST)) {

            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            $this->edit();

        }
	}

    private function edit() {
           
		$timestamp = strtotime($this->options['transfer-create-date']);
        $this->transferdate = date('Y-m-d', $timestamp);

        $date            = $this->transferdate;
        $amount	         = $this->options['transfer-create-amount'];
        $network         = $this->options['transfer-create-network'];
        $postingagent_id = $this->options['postingagent_id'];
        $requestingagent_id  = $this->options['requestingagent_id'];
        $id  = $this->options['id'];
		
		if(!empty($postingagent_id)){
           $postingagent    = $this->options['transfer-create-posting-agent-select'];
		}else{
           $postingagent    = $this->options['transfer-create-posting-agent-text'];
		}
		if(!empty($requestingagent_id)){
           $requestingagent = $this->options['transfer-create-requesting-agent-select'];
		}else{
           $requestingagent = $this->options['transfer-create-requesting-agent-text'];
		}
        $comment         = $this->options['transfer-create-comment'];
		
		$sql = "UPDATE general_transfers set date='$date',amount='$amount',network='$network',requestingagent='$requestingagent',postingagent='$postingagent',requestingagent_id='$requestingagent_id',postingagent_id='$postingagent_id',comment='$comment' WHERE `id` = ".$id;	
		$stmt = parent::query($sql);
		
		echo "<div class='alert alert-success' id='status'>".$id."</div>";
	}
	
	
	
    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM general_transfers WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");
        $arr = '';
	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		    $arr[] = array(
			         'id'   => $row['id'],
		             'date' =>  date('m/d/Y' , strtotime($row['date'])),
					 'amount' => $row['amount'],
					 'postingagent'=>$row['postingagent'],
					 'postingagent_id'=>$row['postingagent_id'],
					 'requestingagent'=>$row['requestingagent'],
					 'requestingagent_id'=>$row['requestingagent_id'],
					 'network'=>$row['network'],
					 'comment'=>$row['comment']
					 );
			 
			 
		}
		
		echo json_encode($arr);
		
		
	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			echo $this->options[$field];
			die('here');
	}

}

$generaltransfer = new General_transfer();
?>