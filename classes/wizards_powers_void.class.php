<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_powers_void extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {
            if(isset($_POST['list-filter'])) {

                $this->list_powers();

    		} else {
            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            $this->add();

        }
	  }
	}

    private function add() {

		$timestamp = strtotime($this->options['powers-void-date']);
        $this->voiddate = date('Y-m-d', $timestamp);

        $date        = $this->voiddate;
        $power	     = $this->options['powers-void-power'];
        $comment     = $this->options['powers-void-comment'];
		
		if(isset($this->options['prefixmv'])){
			$prefix = $this->options['prefixmv'];
		}else{$prefix = null;}

		if(isset($this->options['serialmv'])){
			
			$serial = $this->options['serialmv'];
		
		}else{$serial = null;}

        if(isset($this->options['valuemv'])){ 
			
			$amount = $this->options['valuemv'];
		
		}else{ $value = null; }

        $count = (count($prefix));

	    for ($i = 0 ; $i < $count ; $i++  ){
		
			$sql = "UPDATE `agency_powers` SET `void`= 1 ,`void_date`= '$date',`void_comment`='$comment',`prefix`='$prefix[$i]' WHERE serial =".$serial[$i] ;
			$stmt = parent::query($sql);
			
		}
		echo "<div class='alert alert-success' id='status'>Success</div>";
	
	}
	
 
  private function list_powers(){

        global $generic;
        $fprefix = $_POST['filter-prefix'];
        $fserial = $_POST['filter-serial'];
        $fcount = $_POST['filter-count'];

        $sql = "SELECT
				agency_powers.id,
				agency_powers.serial,
				agency_powers.prefix,
				agency_settings_lists_prefixs.amount
				FROM
				agency_powers
				INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
				WHERE agency_powers.report_id IS NULL AND agency_powers.void = 0";

        if ($fprefix!=''){
            $sql = $sql . " AND prefix='".$fprefix."'";
        }
        if ($fserial!=''){
            $sql = $sql . " AND `int`>=".$fserial;
        }
        $sql = $sql . " ORDER BY prefix DESC, `int` DESC";
        if ($fcount!=''){
            $sql = $sql . " LIMIT ".$fcount;
        }

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found</h5>';
        } else if( $rcount > 1000 ) {
            echo '<h5 id="error">Records found exceeds limit</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $arr[] = array(
                    'id'    => $row['id'],
                    'prefix'   => $row['prefix'],
                    'serial'   => $row['serial'],
                    'value'   => $row['amount']
                );
          }
          echo json_encode($arr);
        }

    }

}

$wizardspowersorvoid = new Wizards_powers_void();
?>