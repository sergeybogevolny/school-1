<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Forfeiture extends Generic {

	function __construct() {
		if(!empty($_GET['id'])) $this->grab();
        if(!empty($_GET['chargepower'])) $this->chargepower();

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
        if (!empty($_POST['forfeiture-action'])){
            $action = parent::secure($_POST['forfeiture-action']);
            switch ($action) {
                case 'question':
                    $this->question();
                    echo $this->result;
                    return;
                case 'charge':
                    $this->charge();
                    echo $this->result;
                    return;
                case 'revert':
                    $this->revert();
                    echo $this->result;
                    return;
                case 'document':
                    $this->document();
                    echo $this->result;
                    return;
                case 'dispose':
                    $this->dispose();
                    echo $this->result;
                    return;
			    case 'bindocument':
					$this->bindocument();
					echo $this->result;
					return;
            }
        }

	}


    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM general_forfeitures WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

	}

	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

    private function validate() {
	    if(empty($this->options['detail-received'])) {
			$this->error = '<div class="alert alert-error">You must enter a Received Date</div>';
        }
	}

    private function edit() {
		if(!empty($this->error))
			return false;

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
		$sql = "UPDATE `general_forfeitures` SET `received` = :received, `civilcasenumber` = :civilcasenumber, `forfeited` = :forfeited, `county` = :county, `amount` = :amount, `defendant` = :defendant, `prefix` = :prefix, `serial` = :serial, `hearing` = :hearing WHERE `id` = :id;";
	    parent::query($sql, $params);

		$this->result = '<div class="alert alert-success">Successfully edited record.</div>';
    }

    private function chargepower(){
        $prefix = parent::secure($_GET['prefix']);
        $serial = parent::secure($_GET['serial']);

        $sql = "SELECT
        general_powers.agent,
        general_powers.agent_id,
		general_powers.id
        FROM
        general_powers
        WHERE general_powers.prefix='".$prefix."' AND general_powers.serial = '".$serial."'";

    	$stmt = parent::query($sql);

        $agent = array();
        $agent['id'] = -1;
        $agent['agent'] = '';
        $agent['powerid'] = -1;
        if ($stmt->rowCount() > 0) {
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			$agent['id'] = $row['agent_id'];
            $agent['agent'] = $row['agent'];
            $agent['powerid'] = $row['id'];
		}

          echo json_encode($agent);

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

		$sql = "UPDATE `general_forfeitures` SET `comment` = '$comment' WHERE `id` = $id";

        parent::query($sql);

	}

    private function question(){

	    if(!empty($this->error))
		    return false;

	    $questioned  = date("Y-m-d H:i:s");
        $questionedagent   = $this->options['forfeiture-questionedagent-select'];
        $questionedagentid   = $this->options['forfeiture-questionedagent-id'];
		$id = $this->options['forfeiture-id'];

		$sql = "UPDATE `general_forfeitures` SET `type` = 'questioned', `questioned` = '$questioned', `questionedagent` = '$questionedagent', `questionedagent_id` = '$questionedagentid'  WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully questioned Forfeiture</div>';

	}

    private function charge(){

	    if(!empty($this->error))
		    return false;
        //print_r($_POST); die();
	    $charged          = date("Y-m-d H:i:s");
        $chargedagent     = $this->options['forfeiture-chargedagent'];
        $chargedagentid   = $this->options['forfeiture-chargedagent-id'];
		$powerid         = $this->options['power-id']; 
		$id               = $this->options['forfeiture-id'];

		$sql = "UPDATE `general_forfeitures` SET `type` = 'charged', `charged` = '$charged', `postingagent` = '$chargedagent', `postingagent_id` = '$chargedagentid',`power_id` = '$powerid' WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully charged Forfeiture</div>';

	}

    private function revert(){

	    if(!empty($this->error))
		    return false;

		$id       = $this->options['forfeiture-id'];

		$sql = "UPDATE `general_forfeitures` SET `type` = 'recorded', `questioned` = NULL WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully reverted Forfeiture</div>';

	}

    private function document(){

	    if(!empty($this->error))
		    return false;
	    $documented  = date("Y-m-d H:i:s");
        $answered = strtotime($this->options['forfeiture-answerdate']);
		$answered = date('Y-m-d', $answered);
	    $answer   = $this->options['forfeiture-answer-file'];
		$id             = $this->options['forfeiture-id'];

		$sql = "UPDATE `general_forfeitures` SET `type` = 'documented', `documented` = '$documented', `documentedlevel` = 'answer', `answered` = '$answered', `answer` = '$answer' WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully documented Forfeiture</div>';

	}
	
	
	

    private function dispose(){

	    if(!empty($this->error))
		    return false;

	    $disposed  = date("Y-m-d H:i:s");
        $reason   = $this->options['forfeiture-disposereason-select'];
		$filename = $this->options['forfeiture-dispose-file'];
		$id       = $this->options['forfeiture-id'];

		$sql = "UPDATE `general_forfeitures` SET `type` = 'disposed', `disposed` = '$disposed', `disposedreason` = '$reason', `document_disposed` = '$filename' WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully disposed Forfeiture</div>';

	}
	
    private function bindocument(){

	    if(!empty($this->error))
		    return false;
	    $doc   = $this->options['bin-upload'];
		$id    = $this->options['bin-id'];
		$name  = $this->options['bin-name'];
		$sql1 = 'SELECT  * FROM general_forfeitures WHERE general_forfeitures.id = '.$id;
		$stmt1 = parent::query($sql1);
		
		while( $row = $stmt1->fetch(PDO::FETCH_ASSOC) ) {
			 $document = $row['document_hearing'];
			 $document_hearing =  $document .'|'. $doc .'#'. $name;
			 
			 $sql = "UPDATE `general_forfeitures` SET `document_hearing` = '$document_hearing' WHERE `id` = $id";
			 parent::query($sql);
	
		}

	    $this->result = '<div class="alert alert-success">Successfully documented Forfeiture</div>';

	}
	
	
	

    public function getPowerName($id){

		$sql = 'SELECT general_powers.id, general_powers.prefix, general_powers.serial FROM general_powers  WHERE general_powers.id = '.$id.' LIMIT 1';
		$stmt = parent::query($sql);
		$powers = '';
		if ($stmt->rowCount() > 0) {
			$this->powers = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$ids         = $row['id'];
				$serial     = $row['serial'];
				$prefix      = $row['prefix'];
                $powers .= $prefix.'-'.$serial;
			}
		}
				return $powers;
	}



}
$forfeiture = new Forfeiture();
?>