<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_powers_collect extends Generic {

	private $options = array();

    function __construct() {

        if(!empty($_GET['collectjobid'])) $this->collectJobDetail();
        if(!empty($_GET['agentid'])) $this->contractDetail();
		if(!empty($_POST)) {
            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);
  			    $this->add();
				if(!empty($this->error)){
					echo $this->error;
				}else {
					echo $this->result;
				}
		}
	}

    private function add(){

        $this->date = date('Y-m-d');
        $this->stamp = date("Y-m-d H:i:s");

        $netpaymentdategeneral = strtotime($this->options['report-netpaymentdate-general']);
        $this->netpaymentdategeneral = date('Y-m-d', $netpaymentdategeneral);
		$bufpaymentdategeneral = strtotime($this->options['report-bufpaymentdate-general']);
        $this->bufpaymentdategeneral = date('Y-m-d', $bufpaymentdategeneral);

        $date                       = $this->date;
        $stamp                      = $this->stamp;
        $agency                     = $this->options['report-agency'];
        $agencyid                   = $this->options['report-agencyid'];
        $netagency                  = $this->options['report-net-agency'];
        $netminimumagency           = $this->options['report-netminimum-agency'];
        $bufagency                  = $this->options['report-buf-agency'];
        $bufminimumagency           = $this->options['report-bufminimum-agency'];
        $netcontractedagency        = $this->options['report-netcontracted-agency'];
        $bufcontractedagency        = $this->options['report-bufcontracted-agency'];
        $surety                     = $this->options['report-surety'];
        $count                      = $this->options['report-count'];
        $amountsum                  = $this->options['report-amount'];
        $netcalculatedgeneral       = $this->options['report-netcalculated-general'];
        $bufcalculatedgeneral       = $this->options['report-bufcalculated-general'];
        $netgeneral                 = $this->options['report-net-general'];
        $netminimumgeneral          = $this->options['report-netminimum-general'];
        $bufgeneral                 = $this->options['report-buf-general'];
        $bufminimumgeneral          = $this->options['report-bufminimum-general'];
        $collectid                  = $this->options['report-collectid'];

        $netpaymentamountagency    = $this->options['report-netpaymentamount-agency'];
        $bufpaymentamountagency    = $this->options['report-bufpaymentamount-agency'];

        $netpaymentdategeneral      = $this->netpaymentdategeneral;
        $netpaymentamountgeneral    = $this->options['report-netpaymentamount-general'];
        $netpaymentmethodgeneral    = $this->options['report-netpaymentmethod-general'];
        $bufpaymentdategeneral      = $this->bufpaymentdategeneral;
        $bufpaymentamountgeneral    = $this->options['report-bufpaymentamount-general'];
        $bufpaymentmethodgeneral    = $this->options['report-bufpaymentmethod-general'];

		if(isset($this->options['collectdetailidmv'])){
		    $collectdetailid = $this->options['collectdetailidmv'];
		}else{$collectdetailid = null;}

		if(isset($this->options['prefixmv'])){
		    $prefix = $this->options['prefixmv'];
		}else{$prefix = null;}

		if(isset($this->options['serialmv'])){
		    $serial = $this->options['serialmv'];
		}else{$serial = null;}

		if(isset($this->options['executedmv'])){
		    $executed = $this->options['executedmv'];
		}else{$executed = null;}

		if(isset($this->options['defendantmv'])){
		    $defendant = $this->options['defendantmv'];
		}else{$defendant = null;}

		if(isset($this->options['amountmv'])){
		    $amount = $this->options['amountmv'];
		}else{$amount = null;}

		if(isset($this->options['netcontractedagencymv'])){
		    $netcontracted = $this->options['netcontractedagencymv'];
		}else{$netcontracted = null;}

		if(isset($this->options['bufcontractedagencymv'])){
		    $bufcontracted = $this->options['bufcontractedagencymv'];
		}else{$bufcontracted = null;}

		if(isset($this->options['netcalculatedgeneralmv'])){
		    $netcalculated = $this->options['netcalculatedgeneralmv'];
		}else{$netcalculated = null;}

		if(isset($this->options['bufcalculatedgeneralmv'])){
		   $bufcalculated = $this->options['bufcalculatedgeneralmv'];
		}else{$bufcalculated = null;}

		if(isset($this->options['voidmv'])){
		    $void = $this->options['voidmv'];
		}else{$void = null;}

		if(isset($this->options['transfermv'])){
		    $transfer = $this->options['transfermv'];
		}else{$transfer = null;}

		$sql = "INSERT INTO general_powers_reports (`date`,`count`,`amount`,`netdate`,`netmethod`,`netpaid`,`bufdate`,`bufmethod`,`bufpaid`,`collect_id`,`surety`,`netcalculated`,`bufcalculated`,`net`,`netminimum`,`buf`,`bufminimum`) VALUES ('$date','$count','$amountsum','$netpaymentdategeneral','$netpaymentmethodgeneral','$netpaymentamountgeneral','$bufpaymentdategeneral','$bufpaymentmethodgeneral','$bufpaymentamountgeneral','$collectid','$surety','$netcalculatedgeneral','$bufcalculatedgeneral','$netgeneral','$netminimumgeneral','$bufgeneral','$bufminimumgeneral')";
		$stmt = parent::query($sql);
		$id = parent::$dbh->lastInsertId();

		$j = (count($amount)) ;

		for ($i = 0 ; $i < $j ; $i++){
			$sql1 = "INSERT INTO general_powers_reports_details (`report_id`,`prefix`,`serial`,`executed`,`defendant`,`amount`,`void`,`transfer`,`netcalculated`,`bufcalculated`) VALUES ($id,'$prefix[$i]','$serial[$i]','$executed[$i]','$defendant[$i]','$amount[$i]','$void[$i]','$transfer[$i]','$netcalculated[$i]','$bufcalculated[$i]' )";
			$stmt = parent::query($sql1);

			$detail_id = parent::$dbh->lastInsertId();
            if ($void[$i]==1){
                $sql2 = "UPDATE `general_powers` SET `void` = 1, `void_date` = '$date', `report_id` = '$id',`reportdetail_id` = '$detail_id', `collect_id` = '$collectid', `collectdetail_id` = '$collectdetailid[$i]'  WHERE `serial` = ".$serial[$i];
            } else {
                $sql2 = "UPDATE `general_powers` SET `void` = 0, `report_id` = '$id',`reportdetail_id` = '$detail_id', `collect_id` = '$collectid', `collectdetail_id` = '$collectdetailid[$i]'  WHERE `serial` = ".$serial[$i];
            }
		    $stmt = parent::query($sql2);

            $sql3 = 'SELECT * FROM general_powers WHERE serial = '.$serial[$i];
			$stmt = parent::query($sql3);

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$powerid =   $row['id'];
			}

            if ($void[$i]==0){
			    $sql4 = "INSERT INTO general_bonds (`executeddate`,`name`,`amount`,`transfer`,`power_id`,`report_id`,`reportdetail_id`) VALUES ('$executed[$i]','$defendant[$i]','$amount[$i]','$transfer[$i]','$powerid','$id','$detail_id')";
			    $stmt = parent::query($sql4);
            }

		    $sql7 = "UPDATE `general_powers_collects_details` SET `netcontracted` = '$netcontracted[$i]',`bufcontracted` = '$bufcontracted[$i]'  WHERE `id` = ".$collectdetailid[$i];
			$stmt = parent::query($sql7);

		}

		$sql_invoice_net = "INSERT INTO general_agents_accounts (`date`,`entry`,`debit`,`agent_id`,`type`) VALUES ('$date','Invoice','$netcontractedagency','$agencyid','net')";
		parent::query($sql_invoice_net);

		$sql_invoice_buf = "INSERT INTO general_agents_accounts (`date`,`entry`,`debit`,`agent_id`,`type`) VALUES ('$date','Invoice','$bufcontractedagency','$agencyid','buf')";
		parent::query($sql_invoice_buf);

		$sql_payment_net = "INSERT INTO general_agents_accounts (`date`,`entry`,`credit`,`agent_id`,`type`) VALUES ('$date','Payment','$netpaymentamountagency','$agencyid','net')";
		parent::query($sql_payment_net);

		$sql_payment_buf = "INSERT INTO general_agents_accounts (`date`,`entry`,`credit`,`agent_id`,`type`) VALUES ('$date','Payment','$bufpaymentamountagency','$agencyid','buf')";
		parent::query($sql_payment_buf);

		//calculate net balance
		$sqlcalculatenet = "SELECT sum(debit)-sum(credit) as balance FROM general_agents_accounts WHERE type = 'net' AND agent_id=".$agencyid ;
		$stmtnetcalculate = parent::query($sqlcalculatenet);
		$rownet = $stmtnetcalculate->fetch(PDO::FETCH_ASSOC);
		$netbalance = $rownet['balance'];
		//calculate buf balance
		$sqlcalculatebuf = "SELECT sum(debit)-sum(credit) as balance FROM general_agents_accounts WHERE type = 'buf' AND agent_id=".$agencyid ;
		$stmtbufcalculate = parent::query($sqlcalculatebuf);
		$rowbuf = $stmtbufcalculate->fetch(PDO::FETCH_ASSOC);
		$bufbalance = $rowbuf['balance'];

		$sql_agent = "UPDATE `general_agents` SET `accountnetbalance` = '$netbalance', `accountbufbalance` = '$bufbalance' WHERE `id` = ".$agencyid;
		parent::query($sql_agent);

		$sql8 = "UPDATE `general_powers_collects` SET `agent` = '$agency', `agent_id` = '$agencyid', `netcontracted` = '$netcontractedagency',`bufcontracted` = '$bufcontractedagency',`net` = '$netagency',`buf` = '$bufagency',`netminimum` = '$netminimumagency',`bufminimum` = '$bufminimumagency',`recorded` = '$stamp' WHERE `id` = '$collectid';";
		$stmt = parent::query($sql8);

		echo "<div class='alert alert-success' id='status'>".$id."</div>";
   }


   public function collectJobDetail() {

		$id = $_GET['collectjobid'];

		global $generic;
		$sql = 'SELECT
        general_powers_collects_details.id,
        general_powers_collects_details.prefix,
        general_powers_collects_details.serial,
        general_powers_collects_details.executed,
        general_powers_collects_details.defendant,
        general_powers_collects_details.amount,
        general_powers_collects_details.transfer,
        general_powers_collects_details.void
        FROM
        general_powers_collects_details
        WHERE
        general_powers_collects_details.collect_id ='.$id;

        $query = $generic->query($sql);
		$sum = '';

	    $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $list[] = array(
				    'id' 	     =>   $row['id'],
					'prefix'     =>   $row['prefix'],
					'serial'     =>   $row['serial'],
					'executed'   =>	  $row['executed'],
					'defendant'  =>	  $row['defendant'],
					'amount'     =>   $row['amount'],
					'transfer'   =>   $row['transfer'],
                    'voided'     =>   $row['void']
                );
            }

            $sql = "SELECT
            general_powers.agent_id,
            general_powers.agent,
            general_agents_contracts.net,
            general_agents_contracts.netminimum,
            general_agents_contracts.buf,
            general_agents_contracts.bufminimum,
            general_agents_contracts.date,
            general_agents_contracts.id
            FROM
            general_powers_collects_details
            INNER JOIN general_powers ON general_powers_collects_details.prefix = general_powers.prefix AND general_powers_collects_details.serial = general_powers.serial
            INNER JOIN general_agents_contracts ON general_powers.agent_id = general_agents_contracts.agent_id
            WHERE general_powers_collects_details.collect_id =".$id."
            ORDER BY general_agents_contracts.date DESC, general_agents_contracts.id DESC";

			$query = $generic->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

            $agency = $row['agent'];
            $agencyid = $row['agent_id'];
			$netagency = $row['net'];
            $netminimumagency = $row['netminimum'];
			$bufagency = $row['buf'];
            $bufminimumagency = $row['bufminimum'];

            $sql = "SELECT
            general_settings_lists_sureties.`name`,
            general_settings_lists_sureties.net,
            general_settings_lists_sureties.netminimum,
            general_settings_lists_sureties.buf,
            general_settings_lists_sureties.bufminimum
            FROM
            general_powers_collects_details
            INNER JOIN general_settings_lists_prefixs ON general_powers_collects_details.prefix = general_settings_lists_prefixs.`name`
            INNER JOIN general_settings_lists_sureties ON general_settings_lists_prefixs.surety_id = general_settings_lists_sureties.id
            WHERE general_powers_collects_details.collect_id =".$id;

            $query = $generic->query($sql);
			$row = $query->fetch(PDO::FETCH_ASSOC);

            $surety = $row['name'];
			$netgeneral = $row['net'];
            $netminimumgeneral = $row['netminimum'];
			$bufgeneral = $row['buf'];
            $bufminimumgeneral = $row['bufminimum'];

            $collect[] = array(
			    'agency' 	            =>   $agency,
				'agency_id'             =>   $agencyid,
			    'netagency' 	        =>   $netagency,
			    'netminimumagency' 	    =>   $netminimumagency,
			    'bufagency' 	        =>   $bufagency,
			    'bufminimumagency' 	    =>   $bufminimumagency,
                'surety' 	            =>   $surety,
			    'netgeneral' 	        =>   $netgeneral,
			    'netminimumgeneral' 	=>   $netminimumgeneral,
			    'bufgeneral' 	        =>   $bufgeneral,
			    'bufminimumgeneral' 	=>   $bufminimumgeneral
            );

		    echo json_encode(array('list'=>$list,'collect'=>$collect));

        }
	}

}

$wizardspowerscollect = new Wizards_powers_collect();
?>