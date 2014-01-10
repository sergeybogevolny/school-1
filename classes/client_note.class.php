<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Client_note extends Generic {

	private $options = array();

    function __construct() {
		
		if(!empty($_GET['noteid'])) $this->noteDetail();
		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['note-delete'])){
                $this->flag();
                echo $this->result;

            } else {

                $this->validate();

                if ($this->options['note-id']==-1){
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
	    if(empty($this->options['note-comment'])) {
			$this->error = '<div class="alert alert-error">You must enter a Comment</div>';
        }
	}

    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->options['note-id']
		);

		$sql = "UPDATE `agency_clients_notes` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record.</div>';

	}

    private function add() {

		if (!empty($this->error)) return false;

		$params = array(
            ':comment'    => $this->options['note-comment'],
            ':subject'    => $this->options['note-subject'],
            ':user_id'    => $_SESSION['nware']['user_id'],
            ':id'         => $this->options['client-id']
		);

        $sql = "INSERT INTO `agency_clients_notes` (`comment`,`subject`,`user_id`,`client_id`) VALUES (:comment,:subject,:user_id,:id);";

		parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully added record.</div>';

	}

    private function edit() {

		if(!empty($this->error))
			return false;

		$params = array(
		   ':comment'   => $this->options['note-comment'],
            ':subject'    => $this->options['note-subject'],
           ':id'        => $this->options['note-id'],
		   ':edit'      => 1
 		);

		$sql = "UPDATE `agency_clients_notes` SET `comment` = :comment,`subject` = :subject,`edit` = :edit  WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';

	}

    public function getNotes($id) {
		// SQL query to retrieve
       $sql = "SELECT
            agency_clients_notes.*,
            login_users.`email`,
            login_users.`avatar`
            FROM
            agency_clients_notes
            INNER JOIN login_users ON agency_clients_notes.user_id = login_users.user_id
            WHERE client_id=" . $id . " AND flag = 0 ORDER BY id DESC";

		// Execute our query
		$stmt = parent::query($sql);

		// If no data return, inform error!
		if ( $stmt->rowCount() < 1 ) {
		    echo 0;
		    return false;
		}

		// If data is exists
		else {

            $notes_res = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $notes_res[] = array(
                'id' => $row['id'],
                'subject' => $row['subject'],
                'comment' => $row['comment']
                );
			}
		}

		// Format our result in JSON
		return json_encode($notes_res);
	}
	
	
	public function noteDetail(){
		$id = $_GET['noteid'];
		global $generic;
		$sql = "SELECT
				agency_clients_notes.*,
				login_users.`email`,
				login_users.`avatar`
				FROM
				agency_clients_notes
				INNER JOIN login_users ON agency_clients_notes.user_id = login_users.user_id
				WHERE id=" . $id . " AND flag = 0 ORDER BY id DESC";
	
		$query = $generic->query($sql);
	           
		    $arr = '';
			while($row = $query->fetch(PDO::FETCH_ASSOC))
			   {
				   $arr[] = array(  'comment' =>  $row['comment'],
				                    'subject' =>  $row['subject'],     
				                 );
			   }
	         echo json_encode($arr);
	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$clientnote = new Client_note();

?>