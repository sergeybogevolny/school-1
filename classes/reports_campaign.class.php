<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Reports_campaign extends Generic {

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
        if(!empty($_GET['rsqlid'])){
            $this->options['rsqlid'] = parent::secure($_GET['rsqlid']);
        } else {
            $this->options['rsqlid'] = '';
        }

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
        $rsqlid = $_POST['reportsqlid'];
        $conditionraw = $_POST['conditionraw'];

        //HACK
        $conditionraw = str_replace('(  )', '', $conditionraw);

        $sql = "SELECT
        nql_report.sqlselect,
        nql_report.sqlfrom,
        nql_report.sqlwhere,
        nql_report.sqlorder,
        nql_report.sqlid,
        nql_report.`name`,
        nql_report.task
        FROM
        nql_report
        WHERE id=".$rid;

        $query = $generic->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $sqlselect      = $row['sqlselect'];
        $sqlfrom        = $row['sqlfrom'];
        $sqlwhere       = $row['sqlwhere'];
        $sqlorder       = $row['sqlorder'];
        $sqlid          = $row['sqlid'];
        $reportname     = $row['name'];

        $sqlraw = "SELECT "  .$sqlselect. " FROM " .$sqlfrom;

        if ($rsqlid!=''){
            //TODO::need to hide conditioner
            $task = strpos($rsqlid, '{task;');
            if ($task !== false) {
                $rsqlid = str_replace('{task;','',$rsqlid);
                $rsqlid = str_replace('}','',$rsqlid);
                $rsqlid = explode( ';', $rsqlid );
                $field = strpos($row['task'], 'court:');
                if ($field !== false) {
                    $field = "agency_bonds.id";
                }
                $strsql = '';
                foreach($rsqlid as $rsqlids) {
                    if ($strsql==''){
                        $strsql = $field."=".$rsqlids;
                    } else {
                        $strsql =  $strsql." OR ".$field."=".$rsqlids;
                    }
                }
                $sqlraw = $sqlraw . "  WHERE ".$sqlwhere." AND (".$strsql.")";
            } else {
                $sqlraw = $sqlraw . "  WHERE  ".$sqlwhere." AND " .$sqlid."='".$rsqlid."'";
            }
        } else {
            if ($conditionraw!=''){
                if ($sqlwhere==''){
                    $sqlraw = $sqlraw . "  WHERE " .$conditionraw;
                } else {
                    $sqlraw = $sqlraw . "  WHERE " .$sqlwhere." AND ".$conditionraw;
                }
            } else{
                if ($sqlwhere!=''){
                    $sqlraw = $sqlraw . "  WHERE " .$sqlwhere;
                }
            }
            if ($sqlorder!=''){
                $sqlraw = $sqlraw . "  ORDER BY " .$sqlorder;
            }
        }

        $query = $generic->query($sqlraw);

        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found.</h5>';
        } else {
            echo '<h5>'.$rcount . ' record(s) found.</h5>';

            $this->listreportfields($rid);

            $table = '<table class="table table-hover table-nomargin dataTable table-bordered" id="table-campaign">';
      		$table .= '<thead><tr>';
            $table .='<th><input type="checkbox" name="check-letter" value="1" id="check-letter" onclick="checkletter()">&nbspL</th>';
            $table .='<th><input type="checkbox" name="check-email" value="1" id="check-email" onclick="checkemail()">&nbspE</th>';
            $table .='<th><input type="checkbox" name="check-text" value="1" id="check-text" onclick="checktext()">&nbspT</th>';
            $table .='<th><input type="checkbox" name="check-autocall" value="1" id="check-autocall" onclick="checkautocall()">&nbspA</th>';
      		foreach ($this->listreportfields as $detail) {
      			$table .='<th>' . $detail['header'] . '</th>';
      		}
            $table .= '</tr></thead>';
            $table .= '<tbody>';

            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $table .= '<tr id="'.$row['sqlid'].'">';
                $isletter = '';
                if ($row['is_letter']==1){
                    $isletter = '<input type="checkbox" name="campaign-letter" value="0" class="campaign-letter">';
                }
                $isemail = '';
                if ($row['is_email']==1){
                    $isemail = '<input type="checkbox" name="campaign-email" value="0" class="campaign-email">';
                }
                $istext = '';
                if ($row['is_message']==1){
                    $istext = '<input type="checkbox" name="campaign-text" value="0" class="campaign-text">';
                }
                $isautocall = '';
                if ($row['is_automatedcall']==1){
                    $isautocall = '<input type="checkbox" name="campaign-autocall" value="0" class="campaign-autocall">';
                }
                $table .= '<td>'.$isletter.'</td>';
                $table .= '<td>'.$isemail.'</td>';
                $table .= '<td>'.$istext.'</td>';
                $table .= '<td>'.$isautocall.'</td>';
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
        $rsqlid = $_POST['reportsqlid'];
        $conditionraw = $_POST['conditionraw'];
        $conditionfriendly = $_POST['conditionfriendly'];
        $autocalls = $_POST['autocalls'];
        $letters = $_POST['letters'];
        $emails = $_POST['emails'];
        $texts = $_POST['texts'];
		$autocalltemplate = $_POST['autocalltemplate'];
		$texttemplate = $_POST['texttemplate'];
		$emailtemplate =$_POST['emailtemplate'];
		$lettertemplate =$_POST['lettertemplate'];
        //HACK
        $conditionraw = str_replace('(  )', '', $conditionraw);
        $conditionfriendly = str_replace('(  )', '', $conditionfriendly);
        //$conditionraw = str_replace("'", '"', $conditionraw);

        $sql = "SELECT
        nql_report.sqlselect,
        nql_report.sqlfrom,
        nql_report.sqlwhere,
        nql_report.sqlorder,
        nql_report.sqlid,
        nql_report.`generator`,
        nql_report.task
        FROM
        nql_report
        WHERE id=".$rid;

        $query = $generic->query($sql);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $sqlselect      = $row['sqlselect'];
        $sqlfrom        = $row['sqlfrom'];
        $sqlwhere       = $row['sqlwhere'];
        $sqlorder       = $row['sqlorder'];
        $sqlid          = $row['sqlid'];
        $generator      = $row['generator'];

        $sqlraw = "SELECT "  .$sqlselect. " FROM " .$sqlfrom;

        if ($rsqlid!=''){
            $pos = strpos($rsqlid, '{task;');
            if ($pos !== false) {
                $rsqlid = str_replace('{task;','',$rsqlid);
                $rsqlid = str_replace('}','',$rsqlid);
                $rsqlid = explode( ';', $rsqlid );
                $strsql = '';
                $field = strpos($row['task'], 'court:');
                if ($field !== false) {
                    $field = "agency_bonds.id";
                }
                $strsql = '';
                foreach($rsqlid as $rsqlids) {
                    if ($strsql==''){
                        $strsql = $field."=".$rsqlids;
                    } else {
                        $strsql =  $strsql." OR ".$field."=".$rsqlids;
                    }
                }
                $sqlraw = $sqlraw . "  WHERE ".$sqlwhere." AND (".$strsql.")";
            } else {
                $sqlraw = $sqlraw . "  WHERE  ".$sqlwhere." AND " .$sqlid."='".$rsqlid."'";
            }
            //$sqlraw = $sqlraw . "  WHERE " .$sqlid."='".$rsqlid."'";
        } else {
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
        }


        $params = array(
			':rid'                  => $rid,
			':sqlraw'    	        => $sqlraw,
			':conditionfriendly'   	=> $conditionfriendly,
            ':autocalls'            => $autocalls,
			':letters'              => $letters,
            ':emails'               => $emails,
            ':texts'                => $texts,
			':autocalltemplate'     => $autocalltemplate,
			':emailtemplate'        => $emailtemplate,
			':lettertemplate'       => $lettertemplate,
			':texttemplate'         => $texttemplate
        );


        $sql = "INSERT INTO `nql_reports_histories` (`report_id`,`sqlraw`,`condition`,`autocalls`,`letters`,`emails`,`texts`,`autocalltemplate`,`emailtemplate`,`lettertemplate`,`texttemplate`)
		        VALUES (:rid,:sqlraw,:conditionfriendly,:autocalls,:letters,:emails,:texts,:autocalltemplate,:emailtemplate,:lettertemplate,:texttemplate);";

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

$reportscampaign = new Reports_campaign();

?>