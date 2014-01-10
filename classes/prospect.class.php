<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Prospect extends Generic {

	private $options = array();

    function __construct() {

        if(!empty($_GET['id'])) $this->grab();

		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['prospect-delete'])){
                $this->flag();
                echo $this->result;

            } else {

                $this->validate();

                if ($this->options['client-id']==-1){
                    $this->unique();
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
	    if(empty($this->options['prospect-last'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter a Last Name.').'</div>';
		} else if(empty($this->options['prospect-first'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter a First Name.').'</div>';
        }
	}

    private function unique() {

        //global $generic;
        //$sql = $sql = "SELECT * FROM agency_settings_lists_counties WHERE name = '" . $this->options['county-name'] . "' AND  seat = '" . $this->options['county-seat'] . "' AND  flag = 0";
        //$query = $generic->query($sql);

		//if( $query->rowCount() > 0 ){
        //    $this->error = '<div class="alert alert-error">'._('Record already exists.').'</div>';
        //}
    }


    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->options['client-id']
		);

		$sql = "UPDATE `agency_clients` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record.</div>';

	}

    private function add() {

		if (!empty($this->error)) return false;

		$params = array(
            ':name'    => $this->options['county-name'],
            ':seat'    => $this->options['county-seat']
		);

        $sql = "INSERT INTO `agency_clients` (`name`,`seat`) VALUES (:name,:seat);";

		parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">' ._('Successfully added record.').'</div>';

	}

    private function edit() {

		if(!empty($this->error))
			return false;

		$params = array(
		   ':name'  => $this->options['county-name'],
           ':seat'  => $this->options['county-seat'],
           ':id'    => $this->options['county-id']
		);

		$sql = "UPDATE `agency_clients` SET `name` = :name, `seat` = :seat WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';

	}

    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM agency_clients WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$prospect = new Prospect();

?>