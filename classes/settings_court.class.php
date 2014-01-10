<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Settings_court extends Generic {

	private $options = array();

    function __construct() {

        if(!empty($_GET['id'])) $this->grab();

		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['court-delete'])){
                $this->flag();
                echo $this->result;

            } else {

                $this->validate();

                if ($this->options['court-id']==-1){
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
	    if(empty($this->options['court-name'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter a Name.').'</div>';
        } else if(empty($this->options['jqxDropDownList-court-county'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter a County.').'</div>';
        } else if(empty($this->options['jqxDropDownList-court-type'])) {
			$this->error = '<div class="alert alert-error">'._('You must enter a Type.').'</div>';
        }
	}

    private function unique() {

        global $generic;
        $sql = $sql = "SELECT * FROM agency_settings_lists_courts WHERE name = '" . $this->options['court-name'] . "' AND flag = 0";
        $query = $generic->query($sql);

		if( $query->rowCount() > 0 ){
            $this->error = '<div class="alert alert-error">'._('Record already exists.').'</div>';
        }
    }


    private function flag() {

		if(!empty($this->error))
			return false;

		$params = array(
            ':flag' => 1,
            ':id' => $this->options['court-id']
		);

		$sql = "UPDATE `agency_settings_lists_courts` SET `flag` = :flag WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully deleted record.</div>';

	}

    private function add() {

		if (!empty($this->error)) return false;

		$params = array(
            ':name'    => $this->options['court-name']
		);

        $sql = "INSERT INTO `agency_settings_lists_courts` (`name`) VALUES (:name);";

		parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">' ._('Successfully added record.').'</div>';

	}

    private function edit() {

		if(!empty($this->error))
			return false;

		$params = array(
		   ':name'  => $this->options['court-name'],
           ':id'    => $this->options['court-id']
		);

		$sql = "UPDATE `agency_settings_lists_courts` SET `name` = :name WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';

	}

    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM agency_settings_lists_courts WHERE id = :id;", $params);

		if( $stmt->rowCount() < 1 ){
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		} else {
            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
			    $this->options[$field] = $value;
            echo "<div class='alert alert-success' id='status'>SUCCESS</div>";
            echo "<div class='alert alert-success' id='name'>". $this->options['name'] ."</div>";
            echo "<div class='alert alert-success' id='county'>". $this->options['county'] ."</div>";
            echo "<div class='alert alert-success' id='type'>". $this->options['type'] ."</div>";
            echo "<div class='alert alert-success' id='precinct'>". $this->options['precinct'] ."</div>";
            echo "<div class='alert alert-success' id='position'>". $this->options['position'] ."</div>";
            echo "<div class='alert alert-success' id='term'>". $this->options['term'] ."</div>";
		}
	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}

$settingscourt = new Settings_court();

?>