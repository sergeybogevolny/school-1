<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Logic extends Generic {

	private $options = array();

    function __construct() {

        if(!empty($_GET['tasks'])) $this->loadTasks();

	}

   public function loadTasks() {

		$type = $_GET['type'];
        $user = $_GET['user'];

		global $generic;
        $sql="SELECT *,
        IF((assignedto LIKE '{private%') AND (assignedto LIKE CONCAT(CONCAT('%',assignedby),'%')),  CONCAT('a',LENGTH(assignedto) - LENGTH(REPLACE(assignedto, ':', ''))), IF((assignedto LIKE '{private%'), CONCAT('b',LENGTH(assignedto) - LENGTH(REPLACE(assignedto, ':', ''))), CONCAT('c',LENGTH(assignedto) - LENGTH(REPLACE(assignedto, ':', ''))))) AS logicorder
        FROM tasks";
        if ($type=='mytasks'){
            $sql = $sql." WHERE tasks.assignedto LIKE '%".$user."%' ORDER BY logicorder ASC";
        }
        if ($type=='myassignedtasks'){
            $sql = $sql." WHERE tasks.assignedby = '".$user."' ORDER BY logicorder ASC";
        }

        $query = $generic->query($sql);
        if( $query->rowCount() < 1 ) {
            $list = '[]';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $list[] = array(
				'id'            =>   $row['id'],
			    'partyid' 	    =>   $row['party_id'],
				'assignedby'    =>   $row['assignedby'],
				'assignedto'    =>   $row['assignedto'],
				'task'          =>	 $row['task'],
				'priority'      =>	 $row['priority'],
				'deadline'      =>   $row['deadline'],
				'progress'      =>   $row['progress'],
                'logicorder'    =>   $row['logicorder'],
              );
          }

        }

        echo json_encode($list);

	}

}

$logic = new Logic();
?>