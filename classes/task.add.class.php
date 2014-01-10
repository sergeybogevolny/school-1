<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Task extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

			 if (!empty($_POST['timeline-id'])){
                $this->result = '<div class="alert alert-success">Successfully edited record</div>';
                echo $this->result;
                return;
                $this->tid = parent::secure($_POST['timeline-id']);
                $this->id = parent::secure($_POST['task-id']);
                $this->validatetimeline();
                $this->addtimeline();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            }

            exit;

        }

	}

    private function validatetimeline() {

	}

    private function addtimeline() {

		if(!empty($this->error))
			return false;

		$params = array(
           ':id'        => $this->id
		);

		//$sql    = "UPDATE `agency_clients` SET `source` = :source, `tags` = :tags, `logged` = :logged, `standing` = :standing, `jail` = :jail WHERE `id` = :id;";

        //$stmt = parent::query($sql, $params);
        $this->result = '<div class="alert alert-success">Successfully added record</div>';

	}




}

$task = new Task();

?>