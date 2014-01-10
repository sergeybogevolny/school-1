<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Client_document extends Generic {

	private $options = array();

    function __construct() {

        if(!empty($_GET['id'])) $this->grab();

		if(!empty($_POST)) {

			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

            if (!empty($_POST['document_modify'])){
                switch ($_POST['document_modify']){
                    case 'edit':
                        $this->edit();
                        break;
                    case 'mugshot':
                        $this->mugshot();
                        break;
                    case 'move':
                        $this->move();
                        break;

                }
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }

            } else if (!empty($_POST['document_add'])){
                $this->add();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            }
            exit;

        }

	}

    private function add() {

		if (!empty($this->error)) return false;

		$params = array(
            ':file'    => $this->options['file'],
            ':type'    => $this->options['type'],
            ':id'    => $this->options['client_id']
		);

        $sql = "INSERT INTO `agency_clients_documents` (`file`,`type`,`client_id`) VALUES (:file,:type,:id);";

		parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    private function edit() {

		if(!empty($this->error))
			return false;

		$params = array(
		   ':description'  => $this->options['document-description'],
           ':id'           => $this->options['document-id']
		);

		$sql = "UPDATE `agency_clients_documents` SET `description` = :description WHERE `id` = :id;";

        parent::query($sql, $params);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';

	}

    private function mugshot() {

		if(!empty($this->error))
			return false;

        $cid = $this->options['client-id'];
        $description = $this->options['document-description'];
        $mugshot = $this->options['current-mugshot'];
        if ($mugshot==0){
            $sql = "update agency_clients_documents set mugshot = 0 WHERE client_id = " . $cid . ";
                update agency_clients_documents set description = '" . $description . "', mugshot = 1 WHERE id = " . $this->options['document-id'];
        } else {
          $sql = "update agency_clients_documents set description = '" . $description . "', mugshot = 0 WHERE id = " . $this->options['document-id'];
        }

        parent::query($sql);
		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';

	}

    private function move() {

        if(!empty($this->error))
			return false;

        $cid = $this->options['client-id'];
        $currentfile = $this->options['current-file'];
        $currentfolder = $this->options['current-folder'];
        $newfolder = $this->options['jqxDropDownList-document-folder'];
        $description = $this->options['document-description'];

        $curfullfile = (dirname(dirname(__FILE__))) . '/documents/' . $cid . '/'  . $currentfolder . '/' . $currentfile;
        $newfullfile = (dirname(dirname(__FILE__))) . '/documents/' . $cid . '/'  . $newfolder . '/' . $currentfile;

        rename($curfullfile, $newfullfile);

        $sql = "update agency_clients_documents set folder =  '" . $newfolder . "', description = '" . $description . "' WHERE id = " . $this->options['document-id'];
        parent::query($sql);

		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';





    }

    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM agency_clients_documents WHERE id = :id;", $params);

		if( $stmt->rowCount() < 1 ){
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		} else {
            foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
			    $this->options[$field] = $value;
            echo "<div class='alert alert-success' id='status'>SUCCESS</div>";
            echo "<div class='alert alert-success' id='folder'>". $this->options['folder'] ."</div>";
            echo "<div class='alert alert-success' id='file'>". $this->options['file'] ."</div>";
            echo "<div class='alert alert-success' id='type'>". $this->options['type'] ."</div>";
            echo "<div class='alert alert-success' id='description'>". $this->options['description'] ."</div>";
            echo "<div class='alert alert-success' id='mugshot'>". $this->options['mugshot'] ."</div>";
            echo "<div class='alert alert-success' id='client_id'>". $this->options['client_id'] ."</div>";
		}
	}
}

$clientdocument = new Client_document();

?>