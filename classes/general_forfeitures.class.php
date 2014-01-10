<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class General_forfeiture extends Generic {

	private $options = array();

    function __construct() {
		
		if(!empty($_GET['id'])) $this->grab();
		if(!empty($_GET['powerid'])) $this->getGeneralPowerDetail();
		if(!empty($_GET['powerserial'])) $this->getGeneralPowerId();

		if(!empty($_POST)) {

            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            $this->edit();

        }
	}

   private function edit() {
		
		$timestamp = strtotime($this->options['forfeiture-record-date']);
        $this->recorddate = date('Y-m-d', $timestamp);

        $date         = $this->recorddate;
        $caseno       = $this->options['forfeiture-record-caseno'];
		$county       = $this->options['forfeiture-record-county'];
		$power        = $this->options['forfeiture-record-power'];
		$agent        = $this->options['agent'];
		$agent_id     = $this->options['agent_id'];
		$serial       = $this->options['serial'];
		$prefix       = $this->options['prefix'];

		$sql = "UPDATE general_forfeitures set date='$date',civilcasenumber='$caseno',county='$county',serial='$serial',prefix='$prefix',agent='$agent',agent_id='$agent_id' WHERE `id` = '$_POST[id]'";	
		$stmt = parent::query($sql);
		echo "<div class='alert alert-success' id='status'>".$id."</div>";
	}
	
	
    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM general_forfeitures WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");
        $arr = '';
	    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		    $arr[] = array(
			         'id'   => $row['id'],
		             'date' => date('m/d/Y',strtotime($row['date'])),
					 'prefix' => $row['prefix'],
					 'serial'=>$row['serial'],
					 'amount'=>$row['amount'],
					 'agent'=>$row['agent'],
					 'agent_id'=>$row['agent_id'],
					 'civilcasenumber'=>$row['civilcasenumber'],
					 'county'=>$row['county']
					 );
			 
			 
		}
		
		echo json_encode($arr);
		
		
	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			echo $this->options[$field];
			die('here');
	}
	
	public  function getGeneralPowerDetail(){
	        $id = $_GET['powerid'];
			$sql = 'SELECT * FROM `general_powers` WHERE  id = '.$id;
			$stmt = parent::query($sql);
			
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$agent = $row['agent'];
				$prefix = $row['prefix'];
				$serial = $row['serial'];
				$agent_id = $row['agent_id'];
				$arr[] = array(
				         'agent'=> $agent,
						 'prefix'=>$prefix,
						 'serial'=>$serial,
						 'agentid'=>$agent_id
				          );
				}
				
			   echo json_encode($arr);
	}
	
	public  function getGeneralPowerId(){
	        $powerserial = $_GET['powerserial'];
			$sql = 'SELECT * FROM `general_powers` WHERE  serial = '.$powerserial;
			$stmt = parent::query($sql);
			$arr = '';
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$agent = $row['agent'];
				$prefix = $row['prefix'];
				$id     = $row['id'];
				$agent_id = $row['agent_id'];
				$arr[] = array(
				         'agent'=> $agent,
						 'prefix'=>$prefix,
						 'id'=>$id,
						 'agentid'=>$agent_id
				          );
				}
				
			   echo json_encode($arr);
	}
	

}

$generalforfeiture = new General_forfeiture();
?>