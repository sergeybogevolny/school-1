<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Client_account extends Generic {

	private $options = array();

    function __construct() {
        if(!empty($_GET['aid'])) $this->grab();
        if(!empty($_GET['sid'])) $this->grabschedule();

		if(!empty($_POST)) {

            if (!empty($_POST['ledger-delete'])){
                $this->flag();
                echo $this->result;
            } else if (!empty($_POST['schedule-delete'])){
                $this->deleteschedule();
                echo $this->result;
            } else if (!empty($_POST['schedule-add'])){
                $this->addschedule();
                echo $this->result;

            } else {

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
        } else if(empty($this->options['ledger-debitentry']) and empty($this->options['ledger-creditentry'])) {
			$this->error = '<div class="alert alert-error">You must enter an Entry</div>';
        } else if(empty($this->options['ledger-amount'])) {
			$this->error = '<div class="alert alert-error">You must enter an Amount</div>';
        } else if($this->options['ledger-amount']==0) {
			$this->error = '<div class="alert alert-error">You must enter an Amount greater then Zero</div>';
        }
	}

    private function flag() {

		if(!empty($this->error))
			return false;

        $clientid = parent::secure($_POST['client-id']);

		$params = array(
            ':flag' => 1,
            ':id' => parent::secure($_POST['ledger-id'])
		);

		$sql = "UPDATE `agency_clients_accounts` SET `flag` = :flag WHERE `id` = :id;";
        parent::query($sql, $params);
        $this->setBalance($clientid);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}

    private function add() {

		if (!empty($this->error)) return false;

        $date           = $this->options['ledger-date'];
        $debitentry     = $this->options['ledger-debitentry'];
        $creditentry    = $this->options['ledger-creditentry'];
        $amount         = $this->options['ledger-amount'];
        $amount         = str_replace(',', '', $amount);
        $method         = $this->options['ledger-paymentmethod'];
        $memo           = $this->options['ledger-memo'];
        $clientid       = $this->options['client-id'];

        if ($this->options['ledger-column']=='debit'){
            $sql = "INSERT INTO `agency_clients_accounts` (`date`,`entry`,`debit`,`client_id`) VALUES ('$date','$debitentry','$amount',$clientid)";
        } else if ($this->options['ledger-column']=='credit') {
           $sql = "INSERT INTO `agency_clients_accounts` (`date`,`entry`,`credit`,`paymentmethod`,`memo`,`client_id`) VALUES ('$date','$creditentry','$amount','$method','$memo',$clientid)";
        }

		$stmt = parent::query($sql);
        $this->setBalance($clientid);
        $this->result = '<div class="alert alert-success">Successfully added record</div>';

	}


    private function edit() {

		if (!empty($this->error)) return false;

        $date           = $this->options['ledger-date'];
        $debitentry     = $this->options['ledger-debitentry'];
        $creditentry    = $this->options['ledger-creditentry'];
        $amount         = $this->options['ledger-amount'];
        $amount         = str_replace(',', '', $amount);
        $method         = $this->options['ledger-paymentmethod'];
        $memo           = $this->options['ledger-memo'];
        $clientid       = $this->options['client-id'];
		$id             = $this->options['ledger-id'];

        if ($this->options['ledger-column']=='debit'){
            $sql = "UPDATE agency_clients_accounts SET `date` = '$date',`entry` = '$debitentry',`debit` = '$amount' WHERE id=$id";
		} else if ($this->options['ledger-column']=='credit') {
            $sql = "UPDATE agency_clients_accounts SET `date` = '$date',`entry` = '$creditentry',`credit` = '$amount',`paymentmethod` = '$method',`memo` = '$memo' WHERE id=$id";
        }
		$stmt = parent::query($sql);
        $this->setBalance($clientid);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    private function deleteschedule(){

        if(!empty($this->error))
			return false;

        $id = parent::secure($_POST['id']);
        $owed = 0;

        $sql = "DELETE FROM agency_clients_accounts_schedules WHERE client_id=" . $id;
		parent::query($sql);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

    }

    private function addschedule(){

        if(!empty($this->error))
			return false;

        $id = parent::secure($_POST['id']);
        $schedule = $_POST['schedule'];

        $sql = "DELETE FROM agency_clients_accounts_schedules WHERE client_id=" . $id;

        foreach($schedule as $installment) {
            $date = $installment['date'];
            $amount =$installment['amount'];
            $remaining = $installment['remaining'];
            $sql = $sql . ";INSERT INTO agency_clients_accounts_schedules (`date`,`amount`,`remaining`,`client_id`) VALUES ('".$date."','".$amount."','".$remaining."','".$id."')";
        }
        parent::query($sql);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

    }

    private function grab() {

        $this->id = parent::secure($_GET['aid']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM agency_clients_accounts WHERE id = :id;", $params);

		if( $stmt->rowCount() < 1 ){
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		} else {
            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
			    $this->options[$field] = $value;
            echo "<div class='alert alert-success' id='status'>SUCCESS</div>";
            echo "<div class='alert alert-success' id='date'>". $this->options['date'] ."</div>";
            echo "<div class='alert alert-success' id='entry'>". $this->options['entry'] ."</div>";
            echo "<div class='alert alert-success' id='debit'>". $this->options['debit'] ."</div>";
            echo "<div class='alert alert-success' id='credit'>". $this->options['credit'] ."</div>";
		}
	}

    public function getSchedule($id) {
        $sql = "SELECT date, amount, remaining FROM agency_clients_accounts_schedules WHERE client_id=" . $id . " ORDER BY date ASC";
		$stmt = parent::query($sql);
        $schedule_res = array();
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            $schedule_res[] = array('date' => $row['date'], 'amount' => $row['amount'], 'detail' => $row['remaining']);
		}
		return json_encode($schedule_res);
	}

    public function getAccountCount($id){
        $sql = "SELECT id FROM agency_clients_accounts WHERE client_id=" . $id;
		$stmt = parent::query($sql);
		return $stmt->rowCount();
    }

    public function getScheduleCount($id){
        $sql = "SELECT id FROM agency_clients_accounts_schedules WHERE client_id=" . $id;
		$stmt = parent::query($sql);
		return $stmt->rowCount();
    }

	public function getField($field) {
		if (!empty($this->options[$field]))
			return $this->options[$field];
	}


	public function setBalance($id){

        $sql1 = "SELECT *
        FROM
        agency_clients_accounts
        WHERE client_id=".$id."
        ORDER BY Date ASC, Debit DESC, Credit DESC";

		$stmt = parent::query($sql1);
		$items = '';
        $balance = 0;
		$rowCount = $stmt->rowCount();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($row['flag']==0){
                if($row['debit']!=''){
                    $balance = $balance + $row['debit'];
                }
                if($row['credit']!=''){
                    $balance = $balance - $row['credit'];
                }
            }
            $items[] = array(
			    'id'        => $row['id'],
                'balance'   => $balance,
			);
		}

		if(!empty($items)){
		    foreach($items as $item){
			    $lineid = $item['id'];
                $linebalance = $item['balance'];
			    $sql2 = "UPDATE `agency_clients_accounts` SET `balance` = '$linebalance'  WHERE `id` = '$lineid'";
			    parent::query($sql2);

		    }
        }

		$sql3 = "UPDATE `agency_clients` SET `accountbalance` = '$balance'  WHERE `id` = '$id'";
		parent::query($sql3);

	}

}

$clientaccount = new Client_account();

?>