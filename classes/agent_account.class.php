<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Agent_account extends Generic {

	private $options = array();

    function __construct() {
       //$this->routine(1);
	   
		if(!empty($_POST)) {

            if (!empty($_POST['ledger-delete'])){
                $this->flag();
                echo $this->result;
            }else {

                foreach ($_POST as $key => $value)
    				$this->options[$key] = parent::secure($value);

                $rawstamp = $this->options['ledger-date'];
                $timestamp = strtotime($rawstamp);
                $this->options['ledger-date'] = date('Y-m-d', $timestamp);

                $this->validate();

                if ($this->options['ledger-id']==-1){
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
	    if(empty($this->options['ledger-date'])) {
			$this->error = '<div class="alert alert-error">You must enter a Date</div>';
        }  else if(empty($this->options['ledger-amount'])) {
			$this->error = '<div class="alert alert-error">You must enter an Amount</div>';
        } else if($this->options['ledger-amount']==0) {
			$this->error = '<div class="alert alert-error">You must enter an Amount greater then Zero</div>';
        }
	}

    private function flag() {

		if(!empty($this->error))
			return false;

        $agentid = parent::secure($_POST['agent-id']);

		$params = array(
            ':flag' => 1,
            ':id' => parent::secure($_POST['ledger-id'])
		);

		$sql = "UPDATE `general_agents_accounts` SET `flag` = :flag WHERE `id` = :id;";
        parent::query($sql, $params);
        $this->setBalance($agentid);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}

    private function add() {

		if (!empty($this->error)) return false;

        $date           = $this->options['ledger-date'];
        $amount         = $this->options['ledger-amount'];
        $amount         = str_replace(',', '', $amount);
        $method         = $this->options['ledger-paymentmethod'];
        $agentid       = $this->options['agent-id']; //ledger-type
        $entry          = $this->options['ledger-column'];
		$type           = $this->options['ledger-type'];
		
		if($entry == 'Invoice'){
        $sql = "INSERT INTO `general_agents_accounts` (`date`,`entry`,`debit`,`agent_id`,`type`,`paymentmethod`) VALUES ('$date','$entry','$amount',$agentid,'$type','$method')";
		}
		if($entry == 'Payment'){
        $sql = "INSERT INTO `general_agents_accounts` (`date`,`entry`,`credit`,`agent_id`,`type`,`paymentmethod`) VALUES ('$date','$entry','$amount',$agentid,'$type','$method')";
		}
		
			
			
		$stmt = parent::query($sql);
        $this->setBalance($agentid);
		
        $this->result = '<div class="alert alert-success">Successfully added record</div>';

	}


    private function edit() {

		if (!empty($this->error)) return false;

        $date           = $this->options['ledger-date'];
        $amount         = $this->options['ledger-amount'];
        $amount         = str_replace(',', '', $amount);
        $method         = $this->options['ledger-paymentmethod'];
        $agentid       = $this->options['agent-id']; //ledger-type
        $entry          = $this->options['ledger-column'];
		$type           = $this->options['ledger-type'];
		$id             = $this->options['ledger-id'];

		if($entry == 'Invoice'){

            $sql = "UPDATE general_agents_accounts SET `date` = '$date',`paymentmethod` = '$method',`debit` = '$amount' WHERE id=$id";
		}
		if($entry == 'Payment'){
			 $sql = "UPDATE general_agents_accounts SET `date` = '$date',`paymentmethod` = '$method',`credit` = '$amount' WHERE id=$id";
        }

		$stmt = parent::query($sql);
        $this->setBalance($agentid);
		
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}
	
	
		public function setBalance($id){

        $sql1 = "SELECT *
        FROM
        general_agents_accounts
        WHERE agent_id=".$id."
        ORDER BY type,date ASC, debit DESC, credit DESC";

		$stmt = parent::query($sql1);
		$items = '';
        $balance_net = 0;
		$balance_buf = 0;
		$rowCount = $stmt->rowCount();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          if($row['flag']==0){
			 if($row['type'] == 'net'){
                if($row['debit']!=''){
                    $balance_net = $balance_net + $row['debit'];
                }
                if($row['credit']!=''){
                    $balance_net = $balance_net - $row['credit'];
                }
            }
		  
		  if($row['type'] == 'buf'){
                if($row['debit']!=''){
                    $balance_buf = $balance_buf + $row['debit'];
                }
                if($row['credit']!=''){
                    $balance_buf = $balance_buf - $row['credit'];
                }
            }
		
		 }  
		  
		  
		  
            $items[] = array(
			    'id'        => $row['id'],
                'balance_net'   => $balance_net,
                'balance_buf'   => $balance_buf,
				'type'   => $row['type']
			);
		}

		if(!empty($items)){
		    foreach($items as $item){
				if( $item['type'] == 'net' ){
					$lineid = $item['id'];
					$linebalance = $item['balance_net'];
					$sql2 = "UPDATE `general_agents_accounts` SET `balance` = '$linebalance'  WHERE `id` = '$lineid'";
					parent::query($sql2);
				}
				if( $item['type'] == 'buf' ){
					$lineid = $item['id'];
					$linebalance = $item['balance_buf'];
					$sql2 = "UPDATE `general_agents_accounts` SET `balance` = '$linebalance'  WHERE `id` = '$lineid'";
					parent::query($sql2);
				}
				

		    }
        }

		//$sql3 = "UPDATE `agency_clients` SET `accountbalance` = '$balance'  WHERE `id` = '$id'";
		//parent::query($sql3);

	}

	
	
	
/*	public function routine($ids){
		
		$sql = "SELECT * FROM general_agents_accounts WHERE agent_id = '$ids' ORDER BY type,date ASC, debit DESC, credit DESC";
				
		$stmt = parent::query($sql);
		$bal = '';
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			//echo '<pre>'; print_r($row);
			$bal[] = array(
			              'id'   => $row['id'],
			              'debit'  => $row['debit'],
						  'credit' => $row['credit'],
						  'type'   => $row['type']
			            );
		}
		
		$deb = 0;
		$crd = 0;
		$ball = 0;
		foreach($bal as $b){
			if( $b['type'] == 'buf' ){
				$deb = $deb + $b['debit'];
				$crd = $crd + $b['credit'];
				$balance = $deb-$crd;
				$id = $b['id'];
				$sql2 = "UPDATE `general_agents_accounts` SET `balance` = '$balance'  WHERE `id` = '$id';";
				parent::query($sql2);
			}
			
			if( $b['type'] == 'net' ){
				$deb = $deb + $b['debit'];
				$crd = $crd + $b['credit'];
				$balance = $deb-$crd;
				$id = $b['id'];
				$sql2 = "UPDATE `general_agents_accounts` SET `balance` = '$balance'  WHERE `id` = '$id';";
				parent::query($sql2);
			}
			
			
		}
	}
*/
}

$agentaccount = new Agent_account();

?>