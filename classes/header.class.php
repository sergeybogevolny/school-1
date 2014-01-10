<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Header extends Generic
{
	private $tasksCount;

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CLASS CONSTRUCTOR
	function __construct() {

		if(isset($_POST['level'])) $this->set_level();

	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FUNCTION TO COUNT UNCOMPLETED TASK
	public function getTasksCount() {
		$this->tasksCount = 0;
        $user = $_SESSION['nware']['email'];

		$sql = "SELECT
		COUNT(*) AS TASKS
		FROM tasks
		WHERE tasks.assignedto LIKE '%".$user."%' AND flag_complete = 0";

		$stmt = parent::query($sql);

		if ($stmt->rowCount() > 0) {
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$this->tasksCount = $row['TASKS'];
			}
		}

		return $this->tasksCount;
	}

	public function set_level(){
		$level = $_POST['level'];
		if( $level == 'general'){
		  $_SESSION['level'] = 'general';
		}else if($level == 'agency'){
		   $_SESSION['level'] = 'agency';
		}else if($level == 'agent'){
		   $_SESSION['level'] = 'agent';
		}

	}


	public function getUnreadMessageCount() {

		$user_id= $_SESSION['nware']['user_id'];
		$this->unreadMessageCount = 0 ;

		$sql = "
			SELECT
			COUNT(*) AS UNREAD
			FROM agency_messages
			WHERE `read` = 0
			AND `user_id` = ".$user_id."
		";

		$stmt = parent::query($sql);

		if ($stmt->rowCount() > 0) {
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$this->unreadMessageCount = $row['UNREAD'];
			}
		}

		return $this->unreadMessageCount;
	}

    function getCampaignmenu($level,$target) {

        $sql = "SELECT
                nql_report.id,
                nql_report.`name`,
                nql_report.generator
                FROM
                nql_report
                WHERE nql_report.`level` = '".$level."' AND nql_report.`menu` LIKE 'client:%' AND nql_report.target = '".$target."' AND nql_report.type = 'campaign' AND nql_report.generator IS NOT NULL ORDER BY `menu` ASC";

		$stmt = parent::query($sql);
        $this->Campaignmenu = array();
        if ($stmt->rowCount() > 0) {
		    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $id         = $row['id'];
				$name       = $row['name'];
                $generator  = $row['generator'];
				$this->Campaignmenu[] = array(
				    'id'        => $id,
					'name'      => $name,
                    'generator' => $generator,
				);
			}
		}
        return $this->Campaignmenu;
	}

    function getColumnarmenu($level) {

        $sql = "SELECT
                nql_report.id,
                nql_report.`name`,
                nql_report.generator
                FROM
                nql_report
                WHERE nql_report.`level` = '".$level."' AND nql_report.type = 'columnar' AND nql_report.generator IS NOT NULL";

		$stmt = parent::query($sql);
        $this->Columnarmenu = array();
        if ($stmt->rowCount() > 0) {
		    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			    $id         = $row['id'];
				$name       = $row['name'];
                $generator  = $row['generator'];
				$this->Columnarmenu[] = array(
				    'id'        => $id,
					'name'      => $name,
                    'generator' => $generator,
				);
			}
		}
        return $this->Columnarmenu;
	}

    public function displayCampaignmenu($level) {
		$this->getCampaignmenu($level,'client');
		foreach( $this->Campaignmenu as $data ){
		    echo '<li><a href="reports-campaign.php?id='.$data['id'].'">'.$data['name'].'</a></li>';
		}
        $this->getCampaignmenu($level,'indemnitor');
		foreach( $this->Campaignmenu as $data ){
		    echo '<li><a href="reports-campaign.php?id='.$data['id'].'">'.$data['name'].'</a></li>';
		}
	}

    public function displayColumnarmenu($level) {
		$this->getColumnarmenu($level);
		foreach( $this->Columnarmenu as $data ){
		    echo '<li><a href="reports-columnar.php?id='.$data['id'].'">'.$data['name'].'</a></li>';
		}
	}

}

$header = new Header();

?>
