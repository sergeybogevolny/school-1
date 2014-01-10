<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_task_create extends Generic {

	private $options = array();

    function __construct() {
		
		if(!empty($_GET['nqldata'])) $this->getNqlData();
		
		if(!empty($_POST)) {
			if(isset($_POST['datasetid'])) {
                $this->list_dataset();
    		} else {
                foreach ($_POST as $key => $value)
				    $this->options[$key] = parent::secure($value);
                $this->add();
            }
	    }
	}

    private function list_dataset(){

        global $generic;
        //$sval = $_POST['search-value'];

        $sql = "SELECT
        CONCAT_WS(' ',CONCAT_WS(', ',agency_clients.last,agency_clients.`first`),SUBSTRING(agency_clients.middle,1,1)) AS `name`,
        agency_bonds.setting,
        CONCAT_WS(':','court',agency_bonds.id) as `focus`,
        agency_bonds.id AS `focus_id`,
        agency_clients.id AS `party_id`,
        FORMAT(agency_bonds.amount,2) as f1,
        trim(CONCAT_WS(' ', trim(SUBSTRING(agency_bonds.class,1,1)), trim(agency_bonds.charge), 'setting')) as `f2`,
        DATE_FORMAT(agency_bonds.setting,'%b %d %Y %h:%i %p') as `f3`,
        '' as `f4`,
        '' as `f5`
        FROM agency_clients
        INNER JOIN agency_bonds ON agency_bonds.client_id = agency_clients.id
        WHERE agency_bonds.setting IS NOT NULL";

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found in search.  Please modify your search.</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $arr[] = array(
                    'name'  => $row['name'],
					'focustext' => trim(trim($row['f1']).' '.trim($row['f2']).' '.trim($row['f3']).' '.trim($row['f4']).' '.trim($row['f5'])),
					'partyid' => $row['party_id'],
                    'focusid'   => $row['focus_id']
                );
          }
          echo json_encode($arr);
        }


    }


    private function add() {
		if(!empty($this->error))
			return false;

        $task         = $this->options['task'];
        $deadline     = date('Y-m-d H:i:s', strtotime($this->options['task-deadline']));
        $description  = $this->options['task-description'];
        $type         = $this->options['task-type'];
        $user_id       = $_SESSION['nware']['user_id'];
	    $important     = '0';

		if(isset($this->options['tasknamemv'])){
		$name = $this->options['tasknamemv'];
		}else{$name = null;}

		if(isset($this->options['taskemailmv'])){
		$email = $this->options['taskemailmv'];
		}else{$email = null;}

		if(isset($this->options['tasktypemv'])){
		$type = $this->options['tasktypemv'];
		}else{$type = null;}

		$count = count($name);
		if(!empty($this->assignedid)){

			$assigned_id  = $this->assignedid;

		}
		else{

			$assigned_id = $_SESSION['nware']['user_id'];

		}

        $datetime = date('Y-m-d H:i:s');
        $fdeadline = date('F jS Y', strtotime($this->options['task-deadline']));

		for ($i = 0 ; $i < $count; $i++  ){


			$desc = $description.'--automated task for'.$name[$i];
			$sql1 = "SELECT * FROM login_users WHERE email = '".$email[$i]."';";
			$stmt1 = parent::query($sql1);
			while( $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ) {
				$assigned_id = $row1['user_id'];
				$sql = "
					INSERT INTO agency_users_tasks
					(task, type, assigned_date, deadline, description, user_id , assigned_id, flag_important )
					VALUES
					('$task', '$type[$i]', '$datetime', '$deadline', '$desc','$user_id', '$assigned_id', '$important')
				";
				$stmt = parent::query($sql);

			}

         }



	   echo  '<div class="alert alert-success">success</div>';

	}

    public function getLastPaymentClientList() {

		$now = date('Y-m-d');

	    $sql = "SELECT * FROM agency_clients ORDER BY nextpayment DESC";

		$stmt = parent::query($sql);
        $rcount = $stmt->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 30 ) {
            echo '<h5 id="error">Records found exceeds limit.  Please narrow your search.</h5>';
        } else {

            while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

				$arr[] = array(
						'id' => $row['id'],
						'first' => $row['first'],
						'middle' => $row['middle'],
						'last' => $row['last'],
						'nextpayment' => $row['nextpayment']
				 );

				}

				echo json_encode($arr);
			}
	}
	
	
   public function getNqlData(){
        $type = $_GET['type'];
		$level = $_GET['level'];
		
    $sql = "SELECT * FROM 
    nql_report
    WHERE nql_report.`task` LIKE '".$type.":%' AND type = 'tasks' AND level = '$level' ORDER BY `task` ASC";

		$stmt = parent::query($sql);
		$nqldata= '<option value=""></option>';
		if ($stmt->rowCount() > 0) {
			
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$name = $row['name'];
				$id   = $row['id'];
                $nqldata .= '<option value="'.$id.'">'.$name.'</option>';
			}
		}
		echo $nqldata;
	 
   }

}

$wizardstaskcreate = new Wizards_task_create();
?>