<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Transfer extends Generic {

	function __construct() {

		if(!empty($_GET['id'])) $this->grab();
        //if(!empty($_GET['powerId'])) $this->getPowerName();
        if(!empty($_GET['settlepower'])) $this->settlepower();

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
        if (!empty($_POST['transfer-action'])){
            $action = parent::secure($_POST['transfer-action']);
            switch ($action) {
                case 'dispatch':
                    $this->dispatch();
                    echo $this->result;
                    return;
                case 'reject':
                    $this->reject();
                    echo $this->result;
                    return;
                case 'revert':
                    $this->revert();
                    echo $this->result;
                    return;
                case 'post':
                    $this->post();
                    echo $this->result;
                    return;
                case 'settle':
                    $this->settle();
                    echo $this->result;
                    return;

            }
        }

	}


    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM general_transfers WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

    private function edit() {
		if(!empty($this->error))
			return false;

		if(!empty($this->options['detail-amount'])){
			$amount = $this->options['detail-amount'];
            $amount = str_replace(",","",$amount);
		}
        if(!empty($this->options['detail-postingagent-fee'])){
			$postingfee = $this->options['detail-postingagent-fee'];
            $postingfee = str_replace(",","",$postingfee);
		}
        if(!empty($this->options['detail-postingagent-received'])){
			$postingreceived = $this->options['detail-postingagent-received'];
            $postingreceived = str_replace(",","",$postingreceived);
		}
        if(!empty($this->options['detail-generalagent-fee'])){
			$generalfee = $this->options['detail-generalagent-fee'];
            $generalfee = str_replace(",","",$generalfee);
		}
        if(!empty($this->options['detail-generalagent-received'])){
			$generalreceived = $this->options['detail-generalagent-received'];
            $generalreceived = str_replace(",","",$generalreceived);
		}
		$prefix = $this->options['detail-prefix'];
        $serial = $this->options['detail-serial'];
        $type = $this->options['detail-type'];

        if ($type=='recorded'){
            $params = array(
                ':requestingagent'      => $this->options['detail-requestingagent-select'],
                ':amount'               => $amount,
    			':county'               => $this->options['detail-county-select'],
    		    ':id'   		        => $this->options['detail-id']
    		);

    		$sql = "UPDATE `general_transfers` SET `requestingagent` = :requestingagent, `amount` = :amount, `county` = :county WHERE `id` = :id;";
            parent::query($sql, $params);

        }

        if ($type=='posted'){
    		$params = array(
                ':postingfee'           => $postingfee,
                ':postingreceived'      => $postingreceived,
                ':generalfee'           => $generalfee,
    			':generalreceived'      => $generalreceived,
				':prefix'               => $prefix,
                ':serial'               => $serial,
    		    ':id'   		        => $this->options['detail-id']
    		);

    		$sql = "UPDATE `general_transfers` SET `postingfee` = :postingfee, `postingreceived` = :postingreceived, `generalfee` = :generalfee, `generalreceived` = :generalreceived, `prefix` = :prefix, `serial` = :serial WHERE `id` = :id;";
            parent::query($sql, $params);

        }

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

		$sql = "UPDATE `general_transfers` SET `comment` = '$comment' WHERE `id` = $id";

        parent::query($sql);

	}


    private function dispatch(){

	    if(!empty($this->error))
		    return false;

	    $dispatched  = date("Y-m-d H:i:s");

        $postingagent   = $this->options['transfer-postingagent-select'];
        $postingagentid   = $this->options['transfer-postingagent-id'];
		$id             = $this->options['transfer-id'];

		$sql = "UPDATE `general_transfers` SET `type` = 'dispatched', `dispatched` = '$dispatched', `postingagent` = '$postingagent', `postingagent_id` = '$postingagentid' WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully dispatched Transfer</div>';

	}

    private function reject(){

	    if(!empty($this->error))
		    return false;

	    $rejected  = date("Y-m-d H:i:s");
        $reason   = $this->options['transfer-rejectreason-select'];
		$id       = $this->options['transfer-id'];

		$sql = "UPDATE `general_transfers` SET `type` = 'rejected', `rejected` = '$rejected', `rejectedreason` = '$reason' WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully rejected Transfer</div>';

	}

    private function revert(){

	    if(!empty($this->error))
		    return false;

		$id       = $this->options['transfer-id'];

		$sql = "UPDATE `general_transfers` SET `type` = 'recorded', `rejected` = NULL, `rejectedreason` = NULL WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully reverted Transfer</div>';

	}

    private function post(){

	    if(!empty($this->error))
		    return false;

	    $posted  = date("Y-m-d H:i:s");

        $generalfee  = $this->options['transfer-general-amount'];
        $generalfee = str_replace(",", "", $generalfee);
        $postingfee     = $this->options['transfer-posting-amount'];
        $postingfee = str_replace(",", "", $postingfee);
        $id             = $this->options['transfer-id'];

		$sql = "UPDATE `general_transfers` SET `type` = 'posted', `posted` = '$posted', `generalfee` = '$generalfee', `postingfee` = '$postingfee' WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully posted Transfer</div>';

	}

    private function settle(){

	    if(!empty($this->error))
		    return false;

	    $settled  = date("Y-m-d H:i:s");
        $reason   = $this->options['transfer-settlereason-select'];
		$id       = $this->options['transfer-id'];

		$sql = "UPDATE `general_transfers` SET `type` = 'settled', `settled` = '$settled', `settledreason` = '$reason' WHERE `id` = $id";

        parent::query($sql);

	    $this->result = '<div class="alert alert-success">Successfully settled Transfer</div>';

	}

    private function settlepower(){
        $prefix = parent::secure($_GET['prefix']);
        $serial = parent::secure($_GET['serial']);

        $sql = "SELECT
		general_powers.id
        FROM
        general_powers
        WHERE general_powers.prefix='".$prefix."' AND general_powers.serial = '".$serial."'";

    	$stmt = parent::query($sql);

        $power = array();
        $power['powerid'] = -1;
        if ($stmt->rowCount() > 0) {
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $power['powerid'] = $row['id'];
		}

        echo json_encode($power);

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
$transfer = new Transfer();
?>