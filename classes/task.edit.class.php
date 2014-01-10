<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Task extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

			if (!empty($_POST['detail-id'])){
			    //$this->result = '<div class="alert alert-success">Successfully edited record</div>';
                //echo $this->result;
                //return;
                $this->id = parent::secure($_POST['detail-id']);
                $this->task = parent::secure($_POST['detail-name']);
                $this->type = parent::secure($_POST['detail-type']);
                $this->deadline = parent::secure($_POST['detail-deadline']);
                $this->description = parent::secure($_POST['detail-description']);
                if (isset($_POST['task-important'])){
                    $this->important = parent::secure($_POST['detail-important']);
                } else {
                    $this->important = 0;
                }
                $this->validatedetail();
                $this->editdetail();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            } 

            exit;

        }

	}

	private function validatedetail() {
        if(empty($this->task)) {
			$this->error = '<div class="alert alert-error">You must enter a Task</div>';
		} else if(empty($this->type)) {
			$this->error = '<div class="alert alert-error">You must enter a Type</div>';
		} else if(empty($this->deadline)) {
			$this->error = '<div class="alert alert-error">You must enter a Deadline</div>';
		}
	}

    private function editdetail() {

		if(!empty($this->error))
			return false;

		$task         = $this->task;
        $type         = $this->type;
        $deadline     = date('Y-m-d H:i:s', strtotime($this->deadline));
        $description  = $this->description;
        $important    = $this->important;
        $id           = $this->id;

        $sql = "
			UPDATE agency_users_tasks SET
            task = '$task', type = '$type', deadline = '$deadline', description = '$description', flag_important = $important
            WHERE id = $id
		";

		$stmt = parent::query($sql);
        $this->result = '<div class="alert alert-success">Successfully edited record</div>';

	}


}

$task = new Task();
?>