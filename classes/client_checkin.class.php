<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Client_checkin extends Generic {

	private $options = array();

    function __construct() {
		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['checkin-delete'])){
                $this->flag();
                echo $this->result;

            } else {
                     
                $this->validate();

                if ($this->options['checkin-id']==-1){
                    $this->add();
                } else {
                    $this->edit();
                }

                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }

            }

            exit;

        }

	}

	private function validate() {
	    if(empty($this->options['checkin-comment'])) {
			$this->error = '<div class="alert alert-error">You must enter a Comment</div>';
        }
	}

    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->options['checkin-id']
		);

		$sql = "UPDATE `agency_clients_checkins` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record</div>';

	}

    private function add() {
      
		if (!empty($this->error)) return false;

		$params = array(
            ':comment'  => $this->options['checkin-comment'],
            ':by'         => $_SESSION['nware']['username'],
            ':id'       => $this->options['client-id']
		);

        $sql = "INSERT INTO `agency_clients_checkins` (`comment`,`by`,`client_id`) VALUES (:comment,:by,:id);";

		parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    private function edit() {

		if(!empty($this->error))
			return false;

		$params = array(
		   ':comment'   => $this->options['checkin-comment'],
           ':id'        => $this->options['checkin-id']
		);

		$sql = "UPDATE `agency_clients_checkins` SET `comment` = :comment WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record</div>';

	}

    public function getCheckins($id) {
		// SQL query to retrieve
        $sql = "SELECT * FROM agency_clients_checkins WHERE flag = 0 AND client_id=".$id;

		// Execute our query
		$stmt = parent::query($sql);

		// If no data return, inform error!
		if ( $stmt->rowCount() < 1 ) {
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return false;
		}

		// If data is exists
		else {

            $checkins_res = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $checkins_res[] = array(
                'id' => $row['id'],
                'comment' => $row['comment']
                );
			}
		}

		// Format our result in JSON
		return json_encode($checkins_res);
	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$clientcheckin = new Client_checkin();

?>