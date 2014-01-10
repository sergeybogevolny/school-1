<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Supplement extends Generic {

	function __construct() {
		if(!empty($_GET['id'])) $this->grab();

        foreach ($_POST as $key => $value)
    	    $this->options[$key] = parent::secure($value);

        if (!empty($_POST['comment-id'])){
            $this->comment();
        }
        if (!empty($_POST['detail-id'])){
            $this->edit();
            if(!empty($this->error)){
                echo $this->error;
            } else {
    	        echo $this->result;
            }
            return;
        }
        if (!empty($_POST['supplement-action'])){
            $action = parent::secure($_POST['supplement-action']);
            switch ($action) {
                case 'revert':
                    $this->revert();
                    echo $this->result;
                    return;
                case 'bill':
                    $this->bill();
                    echo $this->result;
                    return;
            }
        }

	}


    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM suite_supplements WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

    private function validate() {
        /*
	    if(empty($this->options['detail-received'])) {
			$this->error = '<div class="alert alert-error">You must enter a Received Date</div>';
        }
        */
	}

    private function edit() {
		if(!empty($this->error))
			return false;

        /*
		if(!empty($this->options['detail-received'])){
			$date = strtotime($this->options['detail-received']);
			$this->detailreceived = date('Y-m-d', $date);
		}
        if(!empty($this->options['detail-forfeited'])){
			$date = strtotime($this->options['detail-forfeited']);
			$this->detailforfeited = date('Y-m-d', $date);
		}
        if(!empty($this->options['detail-amount'])){
            $amount = $this->options['detail-amount'];
            $this->detailamount = str_replace(",", "", $amount);
		}

        if(!empty($this->options['detail-hearing'])){
            $this->hearing = $this->options['detail-hearing'];
            $hearing = DateTime::createFromFormat('d M Y - h:i A', $this->hearing);
            $hearing = $hearing->format('Y-m-d H:i:s');
            $hearing = strtotime($hearing);
            $this->hearing = date('Y-m-d  H:i:s', $hearing);
        } else {
            $this->hearing = NULL;
		}

		$params = array(
            ':received'         => $this->detailreceived,
            ':civilcasenumber'  => $this->options['detail-civilcasenumber'],
			':forfeited'        => $this->detailforfeited,
            ':county'           => $this->options['detail-county'],
            ':amount'           => $this->detailamount,
            ':defendant'        => $this->options['detail-defendant'],
			':prefix'           => $this->options['detail-prefix'],
			':serial'           => $this->options['detail-serial'],
            ':hearing'          => $this->hearing,
		    ':id'   		    => $this->options['detail-id']
		);
		$sql = "UPDATE `suite_supplements` SET `received` = :received, `civilcasenumber` = :civilcasenumber, `forfeited` = :forfeited, `county` = :county, `amount` = :amount, `defendant` = :defendant, `prefix` = :prefix, `serial` = :serial, `hearing` = :hearing WHERE `id` = :id;";
	    parent::query($sql, $params);
        */

		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
    }

    private function comment(){

	    if(!empty($this->error))
		    return false;

	    $comment  = $this->options['editor'];
        $comment = str_replace("'", '"', $comment);
        $comment = str_replace("&gt;", '>', $comment);
        $comment = str_replace("&lt;", '<', $comment);
        $comment = str_replace("&amp;", "&", $comment);

		$id             = $this->options['comment-id'];

		$sql = "UPDATE `suite_supplements` SET `comment` = '$comment' WHERE `id` = $id";

        parent::query($sql);

	}

    private function bill(){

	    if(!empty($this->error))
		    return false;

	    $billed  = date("Y-m-d H:i:s");
		$id = $this->options['supplement-id'];

		$sql = "UPDATE `suite_supplements` SET `type` = 'billed', `billed` = '$billed' WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully billed Supplement</div>';

	}

    private function revert(){

	    if(!empty($this->error))
		    return false;

		$id       = $this->options['supplement-id'];

		$sql = "UPDATE `suite_supplements` SET `type` = 'recorded', `contracted` = NULL WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully reverted Supplement</div>';

	}

}
$supplement = new Supplement();
?>