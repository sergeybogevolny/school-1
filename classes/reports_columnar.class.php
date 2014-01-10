<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Reports_columnar extends Generic {

	private $options = array();

    function __construct() {

        if(!empty($_GET['id'])) $this->grab();

        //REWORK
        if(!empty($_GET['loadfield'])) $this->loadFieldDetail();
		if(!empty($_GET['field'])) $this->getReportfield() ;
		if(!empty($_GET['operator']))$this->getOperator();

		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['load'])){
                $this->buildReport();
            }
            if (!empty($_POST['report'])){
                $this->historyReport();
            }

            exit;

        }

	}

    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM nql_report WHERE id = :id;", $params);

		if( $stmt->rowCount() < 1 ){
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		} else {
            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
			    $this->options[$field] = $value;
		}
	}

    private function buildReport(){
        global $generic;
        $rid = $_POST['reportid'];
        $conditionraw = $_POST['conditionraw'];

        //HACK
        $conditionraw = str_replace('(  )', '', $conditionraw);

        $sql = "SELECT
        nql_report.sqlselect,
        nql_report.sqlfrom,
        nql_report.sqlwhere,
        nql_report.sqlorder,
        nql_report.`name`
        FROM
        nql_report
        WHERE id=".$rid;

        $query = $generic->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $sqlselect      = $row['sqlselect'];
        $sqlfrom        = $row['sqlfrom'];
        $sqlwhere       = $row['sqlwhere'];
        $sqlorder       = $row['sqlorder'];
        $reportname     = $row['name'];

        $sqlraw = "SELECT "  .$sqlselect. " FROM " .$sqlfrom;

        if ($conditionraw!=''){
            if ($sqlwhere==''){
                $sqlraw = $sqlraw . "  WHERE " .$conditionraw;
            } else {
                $sqlraw = $sqlraw . "  WHERE " .$sqlwhere. " AND ".$conditionraw;
            }
        } else{
            if ($sqlwhere!=''){
                $sqlraw = $sqlraw . "  WHERE " .$sqlwhere;
            }
        }

        if ($sqlorder!=''){
            $sqlraw = $sqlraw . "  ORDER BY " .$sqlorder;
        }

        $query = $generic->query($sqlraw);
		
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found.</h5>';
        } else {
            echo '<h5>'.$rcount . ' record(s) found.</h5>';

            $this->listreportfields($rid);

            $table = '<table class="table table-hover table-nomargin dataTable table-bordered" id="report-table">';
      		$table .= '<thead><tr>';
      		foreach ($this->listreportfields as $detail) {
      			$table .= '<th>' . $detail['header'] . '</th>';
      		}
            $table .= '</tr></thead>';
            $table .= '<tbody>';

            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $table .= '<tr>';
                foreach ($this->listreportfields as $detail) {
                    $alias = $detail['alias'];
                    $table .= '<td>' . $row[$alias] . '</td>';
                }
                $table .= '</tr>';
            }

      		$table .= '<tbody>';
		    $table .= '</tbody><tfoot></tfoot></table>';

            echo $table;

        }

    }

    private function historyReport(){
        global $generic;
        $rid = $_POST['reportid'];
        $conditionraw = $_POST['conditionraw'];
        $conditionfriendly = $_POST['conditionfriendly'];

        //HACK
        $conditionraw = str_replace('(  )', '', $conditionraw);
        $conditionfriendly = str_replace('(  )', '', $conditionfriendly);
        //$conditionraw = str_replace("'", '"', $conditionraw);

        $sql = "SELECT
        nql_report.sqlselect,
        nql_report.sqlfrom,
        nql_report.sqlwhere,
        nql_report.sqlorder,
        nql_report.`generator`
        FROM
        nql_report
        WHERE id=".$rid;

        $query = $generic->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $sqlselect      = $row['sqlselect'];
        $sqlfrom        = $row['sqlfrom'];
        $sqlwhere       = $row['sqlwhere'];
        $sqlorder       = $row['sqlorder'];
        $generator      = $row['generator'];

        $sqlraw = "SELECT "  .$sqlselect. " FROM " .$sqlfrom;

        if ($conditionraw!=''){
            if ($sqlwhere==''){
                $sqlraw = $sqlraw . " WHERE " .$conditionraw;
            } else {
                $sqlraw = $sqlraw . " WHERE " .$sqlwhere. " AND ".$conditionraw;
            }
        } else{
            if ($sqlwhere!=''){
                $sqlraw = $sqlraw . " WHERE " .$sqlwhere;
            }
        }

        if ($sqlorder!=''){
            $sqlraw = $sqlraw . " ORDER BY " .$sqlorder;
        }

        /*
        $sql = "INSERT INTO nql_reports_histories
					(`report_id`,`sqlraw`,`condition`)
					VALUES
					('$rid','$sqlraw','$conditionfriendly')";
        */

        $params = array(
			':rid'                  => $rid,
			':sqlraw'    	        => $sqlraw,
			':conditionfriendly'   	=> $conditionfriendly
        );


        $sql = "INSERT INTO `nql_reports_histories` (`report_id`,`sqlraw`,`condition`)
		        VALUES (:rid,:sqlraw,:conditionfriendly);";

        $query = parent::query($sql, $params);
		//$query = parent::query($sql);
		$generator_id = parent::$dbh->lastInsertId();
        $link = $generator.'.php?id='.$generator_id;

        echo $link;

    }

    //REWORK
	public function loadFieldDetail(){

        global $generic;
		$id = $_GET['id'];
		$sql = "SELECT * FROM  nql_report_fields WHERE nicon = 0 AND nql_id = ".$id;

		$query =  $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found.</h5>';
		 }else {
             while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $alias[] = $row['alias'];
				$friendly[] = $row['fieldfriendly'];
		   }
           echo json_encode($alias);
        }

	}

    private function listreportfields($id) {
        global $generic;
        $sql = "SELECT * FROM  nql_report_fields WHERE datatable > 0 AND nql_id = ".$id." ORDER BY datatable";
        $query = $generic->query($sql);
		if ($query->rowCount() > 0) {
			while( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
				$reportfields =array();
				$reportfields['header'] = $row['fieldfriendly'];
				$reportfields['alias'] = $row['alias'];
				$this->listreportfields[] = $reportfields;
			}
			return $this->listreportfields;
		}
	}
	
	public function getReportfield(){
		$id = $_GET['reportid'];
		$sql = "SELECT * FROM  nql_report_fields WHERE nicon > 0 AND nql_id=".$id." ORDER BY nicon";

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
	


	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$reportscolumnar = new Reports_columnar();

?>