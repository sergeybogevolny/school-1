<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_clients_payment extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {
            if(isset($_POST['search-simple'])) {

                $this->list_simpleclients();

    		} else {

                foreach ($_POST as $key => $value)
    				$this->options[$key] = parent::secure($value);
                 
                $this->add();

            }
        }
	}

    private function add() {
        
		$name           = $this->options['name'];
        $dob            = $this->options['dob'];
		$ssn		    = $this->options['ssn'];
        $date           = $this->options['ledger-date'];
        $entry          = $this->options['ledger-creditentry'];
        $method         = $this->options['ledger-paymentmethod'];
        $memo           = $this->options['ledger-memo'];
		$accountbalance = $this->options['amountmv'];
	    
		$count = count($accountbalance) ;
		
		for ($i = 0 ; $i <= $count-1 ; $i++  ){
			$getname =  explode(" ", $name[$i]);
			$first = $getname[0]; 
			if(isset($getname[2])){
				$last = $getname[2];
				$middle = $getname[1];
			 }else{
				if(isset($getname[1])){
					$last = $getname[1];
					$middle = '';
				}else{
					$last = '';
					$middle = '';
				}
			  }
			  
		   if($accountbalance[$i] != 0.00 ){ //checking credit for zero values
			$sql = "INSERT INTO agency_clients
				(`last`,`first`,`middle`,`dob`,`ssnlast4`)VALUES('$last','$first','$middle','$dob','$ssn[$i]')";
			$stmt = parent::query($sql);
			
				$id = parent::$dbh->lastInsertId();
				$sql1 = "INSERT INTO agency_clients_accounts (`date`,`entry`,`credit`,`client_id`,`paymentmethod`,`memo`) VALUES ('$date','$entry','$accountbalance[$i]','$id','$method','$memo')";
				$stmt = parent::query($sql1);
		   } //end if 
		} //end for
		 
	    echo "<div class='alert alert-success' id='status'>".$id."</div>";


	}

    private function list_simpleclients(){

        global $generic;
        $sval = $_POST['search-value'];
        $sval = ltrim($sval," ");
        $sval = rtrim($sval," ");

        $svals = explode(" ", $sval);
        $rcount = count($svals);

        if ($rcount==1){
            $sfirstorlast = $svals[0];
            $sql = $sql = "SELECT * FROM agency_clients WHERE (first LIKE '%" . $sfirstorlast . "%' OR last LIKE '%" . $sfirstorlast . "%') AND type = 'Client' AND flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        } else if ($rcount==2){
            $sfirst = $svals[0];
            $slast = $svals[1];
            $sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $sfirst . "%' AND last LIKE '%" . $slast . "%' AND type = 'Client' AND  flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        } else {
            $sfirst = $svals[0];
            $smiddle = $svals[1];
            $slast = $svals[2];
            $sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $sfirst . "%' AND  middle LIKE '%" . $smiddle . "%' AND last LIKE '%" . $slast . "%' AND type = 'Client' AND  flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        }

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 3 ) {
            echo '<h5 id="error">Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $sname = '';
                if ($row['first']!=""){
                  $sname = $row['first'];
                }
                $sname = trim($sname);
                if ($row['middle']!=""){
                  $sname = $sname . ' ' . $row['middle'];
                }
                $sname = trim($sname);
                if ($row['last']!=""){
                  $sname = $sname . ' ' . $row['last'];
                }
                $arr[] = array(
                    'id'    => $row['id'],
                    'name'  => $sname,
                    'dob'   => $row['dob'],
                    'ssn'   => $row['ssnlast4']
                );
          }
          echo json_encode($arr);
        }

    }


}

$wizardsclientspayment = new Wizards_clients_payment();
?>