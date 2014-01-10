<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_powers_intake extends Generic {

	private $options = array();

    function __construct() {
        if(!empty($_GET['intakejobid'])) $this->intakeJobDetail();
		if(!empty($_POST)) {

            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            $this->add();

        }
	}

    private function add() {

	    $intake_id      = $this->options['intake_id'];
	    $date = date("Y-m-d H:i:s");

        if(isset($this->options['intakeprefixmv'])){
		    $prefix = $this->options['intakeprefixmv'];
		}else{$prefix = null;}

		if(isset($this->options['intakeserialmv'])){
		    $serial = $this->options['intakeserialmv'];
		}else{$serial = null;}

		if(isset($this->options['intakevaluemv'])){
		    $value = $this->options['intakevaluemv'];
		}else{$value = null;}

        if(isset($this->options['intakeexpirationmv'])){
		    $expiration = $this->options['intakeexpirationmv'];
		}else{$expiration = null;}

        if(isset($this->options['intakeissuedmv'])){
		    $issued = $this->options['intakeissuedmv'];
		}else{$issued = null;}

		if(isset($this->options['intake_detail_id'])){
		    $intake_detail_id = $this->options['intake_detail_id'];
		}else{$intake_detail_id = null;}

		$count = (count($intake_detail_id)) ;
		$valuesum = array_sum($value);

		for ($i = 0 ; $i < $count ; $i++  ){
			$sql1 = "INSERT INTO agency_powers (`prefix`,`serial`,`issued`,`expiration`,`intakedetail_id`,`intake_id`) VALUES ('$prefix[$i]','$serial[$i]','$issued[$i]','$expiration[$i]','$intake_detail_id[$i]','$intake_id')";
            $stmt = parent::query($sql1);

			$sql2 = "UPDATE  agency_powers_intakes SET `recorded` = '$date'  WHERE id = ".$intake_id ;
			$stmt = parent::query($sql2);

		}

	    echo "<div class='alert alert-success' id='status'>".$id."</div>";

    }


    public function intakeJobDetail() {

		$id = $_GET['intakejobid'];

		global $generic;
		$sql = 'SELECT * FROM agency_powers_intakes_details WHERE intake_id = '.$id;
		$query = $generic->query($sql);

	    $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $arr[] = array(
				    'id' 	        => $row['id'],
					'intakeid'      => $row['intake_id'],
					'prefix'        => $row['prefix'],
					'serial'        => $row['serial'],
					'value'         => $row['value'],
                    'expiration'    => $row['expiration'],
                    'issued'        => $row['issued']
                );
            }

		    echo json_encode($arr);

		}

	}
}

$wizardspowersintake = new Wizards_powers_intake();
?>