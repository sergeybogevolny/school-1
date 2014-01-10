<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Agent_contract extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['contract-delete'])){
                $this->flag();
                echo $this->result;

            } else {

                $this->validate();

                if ($this->options['contract-id']==-1){
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
	    if(empty($this->options['contract-net'])) {
			$this->error = '<div class="alert alert-error">You must enter a Net</div>';
        }
        if(empty($this->options['contract-netminimum'])) {
			$this->error = '<div class="alert alert-error">You must enter a Net Minimum</div>';
        }
        if(empty($this->options['contract-buf'])) {
			$this->error = '<div class="alert alert-error">You must enter a BUF</div>';
        }
        if(empty($this->options['contract-bufminimum'])) {
			$this->error = '<div class="alert alert-error">You must enter a BUF Minimum</div>';
        }
	}

    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->options['contract-id']
		);

		$sql = "UPDATE `general_agents_contracts` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}

    private function add() {

		if (!empty($this->error)) return false;

		$timestamp = strtotime($this->options['contract-date']);
        $this->cdate = date('Y-m-d', $timestamp);

        $net = $this->options['contract-net'];
        $net = $net/1000;
        $buf = $this->options['contract-buf'];
        $buf = $buf/1000;

		$params = array(
            ':date'       => $this->cdate,
            ':net'        => $this->options['contract-net'],
            ':netminimum' => $this->options['contract-netminimum'],
            ':buf'  	  => $this->options['contract-buf'],
            ':bufminimum' => $this->options['contract-bufminimum'],
            ':id'         => $this->options['agent-id']
		);
        $sql = "INSERT INTO `general_agents_contracts` (`date`,`net`,`netminimum`,`buf`,`bufminimum`,`agent_id`) VALUES (:date,:net,:netminimum,:buf,:bufminimum,:id);";

		parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    private function edit() {

		if(!empty($this->error))
			return false;

		$timestamp = strtotime($this->options['contract-date']);
        $this->cdate = date('Y-m-d', $timestamp);

        $net = $this->options['contract-net'];
        $net = $net/1000;
        $buf = $this->options['contract-buf'];
        $buf = $buf/1000;

		$params = array(
            ':date'       => $this->cdate,
            ':net'        => $net,
            ':netminimum' => $this->options['contract-netminimum'],
            ':buf'  	  => $buf,
            ':bufminimum' => $this->options['contract-bufminimum'],
            ':id'         => $this->options['contract-id']
		);

		$sql = "UPDATE `general_agents_contracts` SET `date` = :date, `net` = :net, `netminimum` = :netminimum, `buf` = :buf, `bufminimum` = :bufminimum WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record</div>';

	}

    public function getContracts($id) {
		// SQL query to retrieve
        $sql = "SELECT * FROM general_agents_contracts WHERE flag = 0 AND agent_id=".$id;

		// Execute our query
		$stmt = parent::query($sql);

        $contracts_res = array();
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
		
		$timestamp = strtotime($row['date']);
        $cdate = date('m/d/Y', $timestamp);
			
            $contracts_res[] = array(
            'id' => $row['id'],
            'date' => $cdate,
            'net' => $row['net'],
            'netminimum' => $row['netminimum'],
            'buf' => $row['buf'],
            'bufminimum' => $row['bufminimum']
            );
	    }

		// Format our result in JSON
		return json_encode($contracts_res);
	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$agentcontract = new Agent_contract();

?>