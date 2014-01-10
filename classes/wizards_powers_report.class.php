<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_powers_report extends Generic {

	private $options = array();

    function __construct() {
        if(!empty($_GET['surety'])) $this->getSurety();
		if(!empty($_GET['reportexecuted'])) $this->loadExecutedDetail();
		if(!empty($_GET['reportvoided'])) $this->loadVoidedDetail();
		if(!empty($_GET['reporttransfered'])) $this->loadTransferedDetail();
		if(!empty($_POST)) {
            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);
            $this->add();
        }
	}

    private function add() {

			$reportdate = strtotime($this->options['report-date']);
			$this->reportdate = date('Y-m-d', $reportdate);

			$netdate = $this->options['report-netpaymentdate'];
			if( $netdate != ''){
			   $this->netpaymentdate = date('Y-m-d', strtotime($netdate));
			}else{
			   $this->netpaymentdate = null;
			}

			$bufdate = $this->options['report-bufpaymentdate'];
			if($bufdate != ''){
			  $this->bufpaymentdate = date('Y-m-d', strtotime($bufdate));
			}else{
			  $this->bufpaymentdate = null;
			}
			$netdate       = $this->netpaymentdate;
			$netpaid        = $this->options['report-netpaymentamount'];
			$netmethod      = $this->options['report-netpaymentmethod'];
			$bufdate        = $this->bufpaymentdate;
			$bufpaid        = $this->options['report-bufpaymentamount'];
			$bufmethod      = $this->options['report-bufpaymentmethod'];
			$surety         = $this->options['report-surety'];
			$agentfriendly  = $this->options['report-agent-friendly'];

			$net        = $this->options['executed-net'];
			$netmin        = $this->options['executed-net-min'];
			$buf        = $this->options['executed-buf'];
			$bufmin        = $this->options['executed-buf-min'];

			if(isset($this->options['executedprefixmv'])){
			$executedprefix = $this->options['executedprefixmv'];
			}else{$executedprefix = null;}

			if(isset($this->options['executedserialmv'])){
			$executedserial = $this->options['executedserialmv'];
			}else{$executedserial = null;}

			if(isset($this->options['executedamountmv'])){
			$executedamount = $this->options['executedamountmv'];
			}else{$executedamount = null;}

			if(isset($this->options['executednetmv'])){
			    $executednet = $this->options['executednetmv'];
			}else{$executednet = null;}

			if(isset($this->options['executedbufmv'])){
				$executedbuf = $this->options['executedbufmv'];
			}else{$executedbuf = null;}

			if(isset($this->options['executedexecutedmv'])){
			$executedexecute = $this->options['executedexecutedmv'];
			}else{$executedexecute = null;}

			if(isset($this->options['voidprefixmv'])){
			$voidprefix = $this->options['voidprefixmv'];
			}else{$voidprefix = null;}

			if(isset($this->options['voidserialmv'])){
			$voidserial = $this->options['voidserialmv'];
			}else{$voidserial = null;}

			if(isset($this->options['voiddatemv'])){
			$voiddate = $this->options['voiddatemv'];
			}else{$voiddate = null;}

			if(isset($this->options['transferprefixmv'])){
			$transferprefix = $this->options['transferprefixmv'];
			}else{$transferprefix = null;}

			if(isset($this->options['transferserialmv'])){
			$transferserial = $this->options['transferserialmv'];
			}else{$transferserial = null;}

			if(isset($this->options['transferamountmv'])){
			$transferamount = $this->options['transferamountmv'];
			}else{$transferamount = null;}

			if(isset($this->options['transferexecutedmv'])){
			 $transferexecute = $this->options['transferexecutedmv'];
			}else{$transferexecute = null;}


			$defendant1 = '';
			$defendant2 = '';

			$date = date('Y-m-d');

            $count = 0;
			$count = $count + count($executedprefix) ;
            $count = $count + count($voidprefix) ;
            $count = $count + count($transferprefix) ;

            $sum1 = 0;
            $sum1 = $sum1 + array_sum($executedamount);
			$sum1 = $sum1 + array_sum($transferamount);

            $netcalculated = 0;
            $netcalculated = $netcalculated + array_sum($executednet);

            $bufcalculated = 0;
            $bufcalculated = $bufcalculated + array_sum($executedbuf);

        $sql = "INSERT INTO  agency_powers_reports
		(`netdate`,`netmethod`,`netpaid`,`bufdate`,`bufmethod`,`surety`,`bufpaid`,`date`,`count`,`amount`,`net`,`netminimum`,`buf`,`bufminimum`,`netcalculated`,`bufcalculated`)
		VALUES
		('$netdate','$netmethod','$netpaid','$bufdate','$bufmethod','$surety','$bufpaid','$date','$count','$sum1','$net','$netmin','$buf','$bufmin','$netcalculated','$bufcalculated')";
		$stmt = parent::query($sql);
		$report_id = parent::$dbh->lastInsertId();

		$sql1 = "INSERT INTO  general_powers_collects
		(`netdate`,`netmethod`,`netpaid`,`bufdate`,`bufmethod`,`bufpaid`,`report_id`,`date`,`count`,`amount`,`netcalculated`,`bufcalculated`,`agent_friendly`)
		VALUES
		('$netdate','$netmethod','$netpaid','$bufdate','$bufmethod','$bufpaid','$report_id','$date','$count','$sum1','$netcalculated','$bufcalculated','$agentfriendly')";
		$stmt1 = parent::query($sql1);
		$collect_id = parent::$dbh->lastInsertId();
		$this->sendMessage($collect_id);
		$sum = 0;

	// executed insert
        $countexecuted = count($executedprefix) ;
        for ($i = 0 ; $i < $countexecuted; $i++  ){

			if(isset($this->options['executednamemv'][$i])){
			    $defendant1 .= $this->options['executednamemv'][$i].' ';
			 }

			$sql21 = "INSERT INTO  agency_powers_reports_details (`prefix`,`serial`,`amount`,`executed`,`defendant`,`report_id`,`netcalculated`,`bufcalculated`) VALUES ('$executedprefix[$i]','$executedserial[$i]' ,'$executedamount[$i]','$executedexecute[$i]','$defendant1','$report_id','$executednet[$i]','$executedbuf[$i]' )";
			$stmt21 = parent::query($sql21);
			$report_detail_id2 = parent::$dbh->lastInsertId();

			$sql22 = "INSERT INTO  general_powers_collects_details (`prefix`,`serial`,`executed`,`amount`,`defendant`,`collect_id`,`netcalculated`,`bufcalculated`) VALUES ('$executedprefix[$i]','$executedserial[$i]','$executedexecute[$i]','$executedamount[$i]','$defendant1','$collect_id','$executednet[$i]','$executedbuf[$i]')";
			$stmt22 = parent::query($sql22);
			$collect_detail_id2 = parent::$dbh->lastInsertId();

		    $sql23 = "UPDATE `agency_powers` SET `report_id` = '$report_id' ,`reportdetail_id` = '$report_detail_id2'  WHERE `serial` = '$executedserial[$i]';";
			$stmt23 = parent::query($sql23);

			$sql24 = 'SELECT * FROM agency_powers WHERE  serial = '.$executedserial[$i];
			$stmt24 = parent::query($sql24);
			while($row241 = $stmt24->fetch(PDO::FETCH_ASSOC)){
			    $sq241 = "UPDATE `agency_bonds` SET `report_id` = $report_id ,`reportdetail_id` = $report_detail_id2  WHERE `power_id` = ".$row241['id'];
				parent::query($sq241);
			}
			$defendant1 = '';
		}

	//void insert

		$countvoid = count($voidprefix) ;
		for ($i = 0 ; $i < $countvoid; $i++  ){

            $sql31 = "INSERT INTO  agency_powers_reports_details (`prefix`,`serial`,`executed`,`defendant`,`report_id`,`amount`,`void`) VALUES ('$voidprefix[$i]','$voidserial[$i]','$voiddate[$i]','VOID','$report_id',0,1)";
			$stmt31 = parent::query($sql31);
			$report_detail_id3 = parent::$dbh->lastInsertId();

			$sql32 = "INSERT INTO  general_powers_collects_details (`prefix`,`serial`,`executed`,`amount`,`defendant`,`collect_id`) VALUES ('$voidprefix[$i]','$voidserial[$i]','$voiddate[$i]','0','VOID','$collect_id')";
			$stmt32 = parent::query($sql32);
			$collect_detail_id3 = parent::$dbh->lastInsertId();

		    $sql33 = "UPDATE `agency_powers` SET `report_id` = '$report_id' ,`reportdetail_id` = '$report_detail_id3'  WHERE `serial` = '$voidserial[$i]';";
			$stmt33 = parent::query($sql33);

			$sq34 = 'SELECT * FROM agency_powers WHERE  serial = '.$voidserial[$i];
			$stmt34 = parent::query($sq34);

			while($row35 = $stmt34->fetch(PDO::FETCH_ASSOC)){
			    $sql35 = "UPDATE `agency_bonds` SET `report_id` = $report_id ,`reportdetail_id` = $report_detail_id3  WHERE `power_id` = ".$row35['id'];
				parent::query($sql35);
			}

		}

	// transfer insert

		$counttransfer = count($transferprefix) ;
		for ($i = 0 ; $i < $counttransfer ; $i++  ){

			if(isset($this->options['transfernamemv'][$i])){
			    $defendant2 .= $this->options['transfernamemv'][$i].' ';
			}

			$sql41 = "INSERT INTO  agency_powers_reports_details (`prefix`,`serial`,`amount`,`executed`,`defendant`,`report_id`,`transfer`) VALUES ('$transferprefix[$i]','$transferserial[$i]','$transferamount[$i]','$transferexecute[$i]','$defendant2','$report_id',1)";
			$stmt41 = parent::query($sql41);
			$report_detail_id4 = parent::$dbh->lastInsertId();

			$sql42 = "INSERT INTO  general_powers_collects_details (`prefix`,`serial`,`executed`,`amount`,`defendant`,`collect_id`) VALUES ('$transferprefix[$i]','$transferserial[$i]','$transferexecute[$i]','$transferamount[$i]','$defendant2','$collect_id')";
			$stmt42 = parent::query($sql42);
			$collect_detail_id4 = parent::$dbh->lastInsertId();

		    $sql43 = "UPDATE `agency_powers` SET `report_id` = '$report_id' ,`reportdetail_id` = '$report_detail_id4'  WHERE `serial` = '$transferserial[$i]';";
			$stmt43 = parent::query($sql43);

			$sql44 = 'SELECT * FROM agency_powers WHERE  serial = '.$transferserial[$i];
			$stmt44 = parent::query($sql44);

			while($row45 = $stmt44->fetch(PDO::FETCH_ASSOC)){
			    $sql45 = "UPDATE `agency_bonds` SET `report_id` = $report_id ,`reportdetail_id` = $report_detail_id4,`transfer` = 1  WHERE `power_id` = ".$row45['id'];
				parent::query($sql45);
			}

			$defendant2 = '';
		}

        /*
		$sql5 = "UPDATE `general_powers_collects` SET `amount` = '$sum1', `netcalculated`='$netcalculated',`bufcalculated`='$bufcalculated' WHERE `id` = ".$collect_id;
		$stmt = parent::query($sql5);
        */

		echo "<div class='alert alert-success' id='status'>".$report_id."</div>";

	}

	private function sendMessage($collect_id){

		$sender = $_SESSION['nware']['email'];
		$user_id = $_SESSION['nware']['user_id'];
		$date = date('Y-m-d h:i:s');
		$subject = 'You have Jobs in collect';
		$sql = 'SELECT * FROM general_powers_collects WHERE id ='. $collect_id ;
		$query = parent::query($sql);
		$message = '';
		$rcount = $query->rowCount();
        if( $rcount > 0 ) {
    		$message .= '<b>Following Job is availabe </b></ br></ br>';
    		$message .= ' <table id="voided-list" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
    		<thead>
    		<tr class="thefilter">
    		<th>Submitted</th>
    		<th>By</th>
    		<th>Count</th>
    		<th>Net</th>
    		<th>BUF</th>
    		<th></th>
    		</tr>
    		</thead>
    		<tbody>';
    		while($row = $query->fetch(PDO::FETCH_ASSOC)){
    		    $message .= ' <tr>
    			<td> '.$row['date'].' </td>
    			<td>'. $row['agent_friendly'].'</td>
    			<td>'. $row['count'].' </td>
    			<td> '.$row['netpaid'].' </td>
    			<td> '.$row['bufpaid'].' </td>
    			<td > <a href="wizards-powers-collect.php?jobid='.$row['id'].'" > Click Here </a> </td>
    			</tr>';
    		}
    		$message .= '</tbody></table>';
		}else{
		    $message .= '<b><h2> you have no Job  available</h2> </b></br>';
		}

		$sqlmess = "INSERT INTO agency_messages (`sender`,`subject`,`body`,`created`, `user_id`)
		VALUES ('$sender', '$subject', '$message', '$date','$user_id')";

		$stmt = parent::query($sqlmess);

	}

	public function loadExecutedDetail(){

		global $generic;

        $surety = $_GET['reportexecuted'];
        $level = $_GET['level'];
        $fprefix = $_GET['filter-prefix'];
        $fserial = $_GET['filter-serial'];
        $fcount = $_GET['filter-count'];

        if ($level='agent'){
            $sql = "SELECT
            agency_powers.prefix,
            agency_powers.serial,
            agency_bonds.name,
            agency_bonds.executeddate,
            agency_bonds.amount,
            agency_bonds.power_id,
            agency_bonds.report_id
            FROM
            agency_powers
            INNER JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
            INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
            INNER JOIN agency_settings_lists_sureties ON agency_settings_lists_prefixs.surety_id = agency_settings_lists_sureties.id
            WHERE agency_bonds.report_id IS NULL AND agency_bonds.transfer = 0 AND agency_settings_lists_sureties.name = '".$surety."'";
        } else {
		    $sql = "SELECT
            agency_powers.prefix,
            agency_powers.serial,
            agency_clients.last,
            agency_clients.`first`,
            agency_clients.middle,
            agency_bonds.executeddate,
            agency_bonds.amount,
            agency_bonds.power_id,
            agency_bonds.report_id
            FROM
            agency_powers
            INNER JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
            INNER JOIN agency_clients ON agency_bonds.client_id = agency_clients.id
            INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
            INNER JOIN agency_settings_lists_sureties ON agency_settings_lists_prefixs.surety_id = agency_settings_lists_sureties.id
            WHERE agency_bonds.report_id IS NULL AND agency_bonds.transfer = 0 AND agency_settings_lists_sureties.name = '".$surety."'";
        }

        if ($fprefix!=''){
            $sql = $sql . " AND prefix='".$fprefix."'";
        }
        if ($fserial!=''){
            $sql = $sql . " AND CAST(agency_powers.serial AS UNSIGNED INTEGER) >=".$fserial;
        }
        $sql = $sql . " ORDER BY prefix DESC, `int` DESC";
        if ($fcount!=''){
            $sql = $sql . " LIMIT ".$fcount;
        }

		$query = $generic->query($sql);
	    $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                if ($level=='agent'){
                    $sname = $row['name'];
                    $sname = trim($sname);
                } else {
                    $sname = '';
                    if ($row['first']!=""){
                        $sname = $row['first'];
                    }
                    $sname = trim($sname);
                    if ($row['middle']!=""){
                        $sname = $sname . ' ' . $row['middle'];
                    }
                    $sname = trim($sname);
                    if ($row['last']!=""){
                        $sname = $sname . ' ' . $row['last'];
                    }
                    $sname = trim($sname);
                }

                $arr[] = array(
                    'id'         => $row['power_id'],
                    'prefix'     => $row['prefix'],
                    'serial'     => $row['serial'],
    				'executed'   => $row['executeddate'],
    				'name'       => $sname,
                    'amount'     => $row['amount']
                );

    		}

            echo json_encode($arr);

        }

	}



    public function loadVoidedDetail(){

		global $generic;

        $surety = $_GET['reportvoided'];
        $level = $_GET['level'];
        $fprefix = $_GET['filter-prefix'];
        $fserial = $_GET['filter-serial'];
        $fcount = $_GET['filter-count'];

		$sql = "SELECT
		agency_powers.prefix,
		agency_powers.serial,
        agency_settings_lists_prefixs.amount AS `value`,
		agency_powers.void_date as `voideddate`,
		agency_powers.id
		FROM
		agency_powers
		INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
		INNER JOIN agency_settings_lists_sureties ON agency_settings_lists_prefixs.surety_id = agency_settings_lists_sureties.id
		WHERE agency_powers.bond_id IS NULL AND agency_powers.report_id IS NULL AND agency_powers.void = 1 AND agency_settings_lists_sureties.name = '".$surety."'";

        if ($fprefix!=''){
            $sql = $sql . " AND prefix='".$fprefix."'";
        }
        if ($fserial!=''){
            $sql = $sql . " AND `int`>=".$fserial;
        }
        $sql = $sql . " ORDER BY prefix DESC, `int` DESC";
        if ($fcount!=''){
            $sql = $sql . " LIMIT ".$fcount;
        }

		$query = $generic->query($sql);
	    $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $arr[] = array(
                    'id'            => $row['id'],
                    'prefix'        => $row['prefix'],
                    'serial'        => $row['serial'],
                    'value'         => $row['value'],
                    'voideddate'    => $row['voideddate']
                );
            }

		    echo json_encode($arr);

		}

	}



    public function loadTransferedDetail(){

        global $generic;

        $surety = $_GET['reporttransfered'];
        $level = $_GET['level'];
        $fprefix = $_GET['filter-prefix'];
        $fserial = $_GET['filter-serial'];
        $fcount = $_GET['filter-count'];

        if ($level='agent'){
            $sql = "SELECT
            agency_powers.prefix,
            agency_powers.serial,
            agency_bonds.name,
            agency_bonds.executeddate,
            agency_bonds.amount,
            agency_bonds.power_id,
            agency_bonds.report_id
            FROM
            agency_powers
            INNER JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
            INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
            INNER JOIN agency_settings_lists_sureties ON agency_settings_lists_prefixs.surety_id = agency_settings_lists_sureties.id
            WHERE agency_bonds.report_id IS NULL AND agency_bonds.transfer = 1 AND agency_settings_lists_sureties.name = '".$surety."'";
        } else {
		    $sql = "SELECT
            agency_powers.prefix,
            agency_powers.serial,
            agency_clients.last,
            agency_clients.`first`,
            agency_clients.middle,
            agency_bonds.executeddate,
            agency_bonds.amount,
            agency_bonds.power_id,
            agency_bonds.report_id
            FROM
            agency_powers
            INNER JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
            INNER JOIN agency_clients ON agency_bonds.client_id = agency_clients.id
            INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
            INNER JOIN agency_settings_lists_sureties ON agency_settings_lists_prefixs.surety_id = agency_settings_lists_sureties.id
            WHERE agency_bonds.report_id IS NULL AND agency_bonds.transfer = 1 AND agency_settings_lists_sureties.name = '".$surety."'";
        }

        if ($fprefix!=''){
            $sql = $sql . " AND prefix='".$fprefix."'";
        }
        if ($fserial!=''){
            $sql = $sql . " AND `int`>=".$fserial;
        }
        $sql = $sql . " ORDER BY prefix DESC, `int` DESC";
        if ($fcount!=''){
            $sql = $sql . " LIMIT ".$fcount;
        }

		$query = $generic->query($sql);
	    $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                if ($level=='agent'){
                    $sname = $row['name'];
                    $sname = trim($sname);
                } else {
                    $sname = '';
                    if ($row['first']!=""){
                        $sname = $row['first'];
                    }
                    $sname = trim($sname);
                    if ($row['middle']!=""){
                        $sname = $sname . ' ' . $row['middle'];
                    }
                    $sname = trim($sname);
                    if ($row['last']!=""){
                        $sname = $sname . ' ' . $row['last'];
                    }
                    $sname = trim($sname);
                }

                $arr[] = array(
                    'id'         => $row['power_id'],
                    'prefix'     => $row['prefix'],
                    'serial'     => $row['serial'],
    				'executed'   => $row['executeddate'],
    				'name'       => $sname,
                    'amount'     => $row['amount']
                );
            }

		    echo json_encode($arr);

		}
	}

    function getSurety(){

        global $generic;

        $surety = $_GET['surety'];
        $sql = "SELECT * FROM agency_settings_lists_sureties  WHERE  name = '".$surety."'";
    	$query = $generic->query($sql);
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $arr[] = array(
                'id'        => $row['id'],
                'net'       => $row['net'],
                'netmin'    => $row['netminimum'],
                'buf'       => $row['buf'],
    			'bufmin'    => $row['bufminimum'],
    		);
    	}
        echo json_encode($arr);
    }

}

$wizardspowersreport = new Wizards_powers_report();
?>