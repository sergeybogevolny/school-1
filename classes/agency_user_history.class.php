<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Agency_user_history extends Generic {


	function __construct() {
		//print_r($curPageURL = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
		}

	public function add($label,$link) {
			$params = array(
				':user'   => $_SESSION['nware']['username'],
				':label' => $label,
				':link'  => $link
			);

			$sql = "INSERT INTO `agency_users_histories` (`user`,`label`,`link`) VALUES (:user,:label,:link);";
			parent::query($sql, $params);
	}

	function list_historymenu() {
			$sql = "
				SELECT DISTINCT	label, link
				FROM agency_users_histories
                WHERE user = '" . $_SESSION['nware']['username'] . "'
				ORDER BY stamp DESC
                LIMIT 10";

			$stmt = parent::query($sql);
			if ($stmt->rowCount() > 0) {
				$this->historyData = array();
				 while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
					$lable = $row['label'];
					$link = $row['link'];
					$this->historyData[] = array(
						'lable' => $lable,
						'link' => $link,
					);
				}
			}

		return $this->historyData;
	}



	public function displayhistorymenu() {
		$this->list_historymenu();
		foreach( $this->historyData as $data ){
			echo '<li><a href="'.$data['link'].'">'.$data['lable'].'</a></li>';
			}

	}


}

$agencyuserhistory = new Agency_user_history();

?>