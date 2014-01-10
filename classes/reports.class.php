<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Reports extends Generic {

	private $options = array();

    function __construct() {
		
		if(!empty($_GET['field'])) $this->getReportfield() ;
		if(!empty($_GET['operator']))$this->getOperator();
		if(!empty($_GET['fieldDetailId']))$this->getReportfieldDetail();
		if(!empty($_GET['value'])) $this->grab();

	}

    private function grab() {
		global $generic;
		$data = urldecode($_GET['data']);
		//print_r($data);die();
		$frndSql = urldecode($_GET['frndsql']);
		$sql = "SELECT * FROM agency_clients_accounts WHERE $data ";
		
        $query = $generic->query($sql);
		 $insersql =  mysql_escape_string($sql);
		 $insertfrndsql =  mysql_escape_string($frndSql);
		$sql1 = "INSERT INTO nql_report (`name`,`sqlraw`,`condition`) VALUES ('Agency Account Report', '".$insersql."', '".$insertfrndsql."')" ;
		//print_r($sql1);die();
		$stmt = parent::query($sql1);
		$conditionid = parent::$dbh->lastInsertId();
       
	    $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found</h5>';
        } else if( $rcount > 1000 ) {
            echo '<h5 id="error">Records found exceeds limit</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $arr[] = array(
                    'id'       => $row['id'],
                    'date'   => $row['date'],
                    'entry'   => $row['entry'],
                    'debit'   => $row['debit'],
                    'credit'   => $row['credit'],
                    'paymentmethod'   => $row['paymentmethod'],
                    'balance'   => $row['balance'],
					
                );
          }
		  
          echo json_encode(array($arr,$conditionid));
        }
		

	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}


    private function getName($id) {
		$sql = "SELECT name FROM login_users WHERE user_id=".$id." LIMIT 1";

		$stmt = parent::query($sql);
		$name = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$name = $row['name'];
		}
		return $name;
	}
	
	
	
	public function getReportfield(){
		$id = $_GET['reportid'];
		$sql = "SELECT * FROM  nql_report_fields WHERE nicon = 1 AND nql_id=".$id;

		$stmt = parent::query($sql);
		if ($stmt->rowCount() > 0) {
			$arr = '';
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$arr[] = array(	'id'   			 => $row['id'],
							'field' 		 => $row['field'],
							'fieldfriendly'  => $row['fieldfriendly'],
							'type'           => $row['type'],
				     );
			}
		}
		echo json_encode($arr);
	}
	
	public function getOperator(){
		$operator = trim($_GET['operator'],'');
		$sql = "SELECT type FROM  nql_report_fields where field= '".$operator."';";
         
		$stmt = parent::query($sql);
		
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $type = $row['type'];
					$sql1 = "SELECT * FROM  nql_reports_comparisions where type='".$type."'";
					
					$stmt1 = parent::query($sql1);
					
					$arr = '';
					while( $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ) {
						//print_r($row1);
						$arr[]= array(
						       'id'   			 => $row1['id'],
							   'comparison'     => $row1['comparison'],
							   'type'     => $row1['type']
						     );
					}
			}
			echo json_encode($arr);
		}
		
		
	public function getReportfieldDetail(){
		$sql = "SELECT * FROM  nql_report_fields ";

		$stmt = parent::query($sql);
		if ($stmt->rowCount() > 0) {
			$arr = '';
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$arr[] = array(	'id'   			 => $row['id'],
							'field' 		 => $row['field'],
							'fieldfriendly'  => $row['fieldfriendly'],
							'type'           => $row['type'],
				     );
			}
		}
		echo json_encode($arr);
	}
		
		
		

}

$reports = new Reports();

?>


