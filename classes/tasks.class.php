<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Tasks extends Generic {

	private $options = array();

    function __construct() {

        if(!empty($_GET['tasks'])) $this->loadTasks();
        if (!empty($_POST['campaignmenu'])){
            $this->displayCampaignmenu();
        }

	}

   public function loadTasks() {

		$type = $_GET['type'];

		global $generic;
        $sql="SELECT *,
        IF((assignedto LIKE '{private%') AND (assignedto LIKE CONCAT(CONCAT('%',assignedby),'%')),  CONCAT('a',LENGTH(assignedto) - LENGTH(REPLACE(assignedto, ':', ''))), IF((assignedto LIKE '{private%'), CONCAT('b',LENGTH(assignedto) - LENGTH(REPLACE(assignedto, ':', ''))), CONCAT('c',LENGTH(assignedto) - LENGTH(REPLACE(assignedto, ':', ''))))) AS tasksorder
        FROM tasks";
        if ($type=='client'){
            $partyid = $_GET['partyid'];
            $sql = $sql." WHERE tasks.party_id=".$partyid;
        } else {
            $filter = $_GET['filter'];
            $user = $_SESSION['nware']['email'];
            if ($type=='mytasks'){
                $sql = $sql." WHERE tasks.assignedto LIKE '%".$user."%'";
            }
            if ($type=='myassignedtasks'){
                $sql = $sql." WHERE tasks.assignedby = '".$user."'";
            }
            if ($filter!='NONE'){
                $sql = $sql." AND tasks.type = '".strtolower($filter)."'";
            }
        }
        $sql = $sql." ORDER BY tasksorder ASC";

        $query = $generic->query($sql);
        if( $query->rowCount() < 1 ) {
            $list = '';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $list[] = array(
				'id'            =>   $row['id'],
			    'partyid' 	    =>   $row['party_id'],
                'focusid' 	    =>   $row['focus_id'],
				'assignedby'    =>   $row['assignedby'],
				'assignedto'    =>   $row['assignedto'],
				'task'          =>	 $row['task'],
                'type'          =>	 $row['type'],
				'priority'      =>	 $row['priority'],
				'deadline'      =>   $row['deadline'],
				'progress'      =>   $row['progress'],
                'tasksorder'    =>   $row['tasksorder'],
              );
          }

        }

        echo json_encode($list);

	}

    function getCampaignmenu($menu,$target) {

        global $generic;

        $sql = "SELECT
        nql_report.id,
        nql_report.`name`,
        nql_report.generator
        FROM
        nql_report
        WHERE nql_report.`menu` LIKE '".$menu.":%' AND nql_report.target = '".$target."' AND nql_report.type = 'campaign' AND nql_report.generator IS NOT NULL ORDER BY `menu` ASC";

    	$query = $generic->query($sql);
        $campaignmenu = array();
        if ($query->rowCount() > 0) {
    	    while( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
    		    $id         = $row['id'];
    			$name       = $row['name'];
    			$campaignmenu[] = array(
    			    'id'        => $id,
    				'name'      => $name,
    			);
    		}
    	}
        return $campaignmenu;

    }


    function displayCampaignmenu() {
        $filter = $_POST['campaignmenu'];
        $sqlid = $_POST['sqlid'];

        $filter = strtolower($filter);
        switch ($filter){
            case "court":
                $stritem = '';
                $campaignmenu = $this->getCampaignmenu('task','client');
            	foreach( $campaignmenu as $data ){
                    //$stritem = $stritem.'<li><a href="#" onclick="ReportCampaign('.$data['id'].',sqlids)">'.$data['name'].'</a></li>';
                    ?><li><a href="#" onclick="ReportCampaign('<?php echo $data['id'];  ?>','<?php echo $sqlid; ?>')"><?php echo $data['name']; ?></a></li><?php
                }
                $campaignmenu = $this->getCampaignmenu('task','indemnitor');
            	foreach( $campaignmenu as $data ){
                    //$stritem = $stritem.'<li><a href="#" onclick="ReportCampaign('.$data['id'].',sqlids)">'.$data['name'].'</a></li>';
                    ?><li><a href="#" onclick="ReportCampaign('<?php echo $data['id'];  ?>','<?php echo $sqlid; ?>')"><?php echo $data['name']; ?></a></li><?php
                }
                //echo $stritem;
                break;
            case "payment":
                break;
        }

    }


}

$tasks = new Tasks();
?>