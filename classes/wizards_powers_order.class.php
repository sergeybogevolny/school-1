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
	    if(empty($this->options['order-date'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
		} else if(empty($this->options['order-surety'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
        }
	}


    private function add() {

		$timestamp = strtotime($this->options['order-date']);
        $this->orderdate = date('Y-m-d', $timestamp);

        $date        = $this->orderdate;
        $courier	 = $this->options['order-courier'];
        $surety      = $this->options['order-surety'];
        $serialbegin = $this->options['power-serialbegin'];
        $serialend   = $this->options['power-serialend'];
        $issued      = $this->options['power-issued'];
        $expiration  = $this->options['power-expiration'];

		if(isset($this->options['prefixmv'])){
			$prefix = $this->options['prefixmv'];
		}else{$prefix = null;}

		if(isset($this->options['serialbeginmv'])){
			$serialbegin = $this->options['serialbeginmv'];
		}else{$serialbegin = null;}

		if(isset($this->options['serialendmv'])){
			$serialend = $this->options['serialendmv'];
		}else{$serialend = null;}

		if(isset($this->options['issuedmv'])){
			$issued = $this->options['issuedmv'];
		}else{$issued = null;}

        if(isset($this->options['expirationmv'])){
			$expiration = $this->options['expirationmv'];
		}else{$expiration = null;}

		$sql = "INSERT INTO general_powers_orders(`date`,`courier`,`surety`)VALUES('$date','$courier','$surety')";

		$stmt = parent::query($sql);
		$order_id = parent::$dbh->lastInsertId();
		$count = (count($prefix)/2-1);
        $total_count = 0;
        $total_amount = 0;

		for ($i = 0 ; $i <= $count ; $i++  ){
			$timesissue = strtotime($issued[$i]);
			$issuedates = date('Y-m-d', $timesissue);

			$timeexpire = strtotime($expiration[$i]);
			$expiresdates = date('Y-m-d',$timeexpire);

			$sql1 = "INSERT INTO general_powers_orders_details (`prefix`,`serialbegin`,`serialend`,`issued`,`expiration`,`order_id`) VALUES ('$prefix[$i]','$serialbegin[$i]','$serialend[$i]','$issuedates','$expiresdates','$order_id')";
			$stmt = parent::query($sql1);

			$order_detail_id = parent::$dbh->lastInsertId();

			$sql_getprefixamount = "SELECT amount FROM general_settings_lists_prefixs WHERE name = '".$prefix[$i]."'" ;

            $stmt = parent::query($sql_getprefixamount);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $prefixamount = $row['amount'];

			$sBegin = $serialbegin[$i];
			$sEnd   = $serialend[$i];
			$count_serial = $sEnd - $sBegin ;

			for( $j=0; $j <= $count_serial; $j++ ){
				$int = $sBegin + $j;
				$serial = str_pad((int) $int,4,"0",STR_PAD_LEFT); //padding with 0
				$total_amount = $total_amount + $prefixamount;
				$total_count = $total_count + 1;
				$sql_power = "INSERT INTO general_powers(`order_id`,`orderdetail_id`,`serial`,`prefix`,`value`,`issued`,`expiration`) VALUES('$order_id','$order_detail_id','$serial','$prefix[$i]','$prefixamount','$issuedates','$expiresdates')";
				$stmt = parent::query($sql_power);
			}
		}

        $sql_total = "UPDATE  `general_powers_orders` SET `count` = $total_count, `amount` = $total_amount WHERE id = ".$order_id ;
		$stmt = parent::query($sql_total);

		echo "<div class='alert alert-success' id='status'>".$id."</div>";
	}

}

$wizardspowersorder = new Wizards_powers_order();
?>