<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
include_once(dirname(dirname(__FILE__)) . '/classes/agency_feeds.class.php');

class Wizards_create_prospect extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {
			if(isset($_POST['search-simple'])) {
                $this->list_simpleclients();
    		} else {
                foreach ($_POST as $key => $value)
				    $this->options[$key] = parent::secure($value);
                $this->add();
            }
	    }
	}

    private function add() {

        $last     	 = $this->options['personal-last'];
        $first		 = $this->options['personal-first'];
        $middle      = $this->options['personal-middle'];
        if(!empty($this->options['personal-dob'])){
		    $dob = date('Y-m-d',strtotime($this->options['personal-dob']));
		} else {
		    $dob='NULL';
		}

		if (isset($_POST['personal-gender'])){
            $gender = parent::secure($_POST['personal-gender']);
        } else {
            $gender='';
        }

		$race       = $this->options['personal-race'];
        $phone1type = $this->options['personal-phone1type'];
        $phone1     = $this->options['personal-phone1'];
        $phone2type = $this->options['personal-phone2type'];
        $phone2     = $this->options['personal-phone2'];
        $source     = $this->options['transaction-source'];

        $address     = $this->options['personal-address'];
        $city        = $this->options['personal-city'];
        $state       = $this->options['personal-state'];
        $zip         = $this->options['personal-zip'];
        $linkid      = $this->options['personal-id'];

		if (isset($_POST['transaction-standing'])){
            $standing = parent::secure($_POST['transaction-standing']);
        } else {
            $standing='';
        }

		$jail             = $this->options['transaction-standingcustodyjail'];
		$warrant          = $this->options['transaction-standingwarrantdescription'];
		$other            = $this->options['transaction-standingotherdescription'];
		$identifiertype   = $this->options['transaction-identifiertype'];
		$identifier       = $this->options['transaction-identifier'];

		if(isset($this->options['amountmv'])){
            $amount = $this->options['amountmv'];
            $amount = str_replace(",", "", $amount);
		}else{$amount = NULL;}

		if(isset($this->options['classmv'])){
			$class = $this->options['classmv'];
		}else{$class = null;}
		if(isset($this->options['chargemv'])){
			$charge = $this->options['chargemv'];
		}else{$charge = null;}

		if(isset($this->options['countymv'])){
			$county = $this->options['countymv'];
		}else{$county = null;}
		if(isset($this->options['courtmv'])){
			$court = $this->options['courtmv'];
		}else{$court = null;}

		if(isset($this->options['casenumbermv'])){
			$casenumber = $this->options['casenumbermv'];
		}else{$casenumber = null;}

		if(isset($this->options['checkamountmv'])){
		    $checkamount = $this->options['checkamountmv'];
		}else{$checkamount = null;}

		if(isset($this->options['firstmv'])){
		    $refrencefirst = $this->options['firstmv'];
		}else{$refrencefirst = null;}

	   if(isset($this->options['lastmv'])){
		    $refrencelast = $this->options['lastmv'];
		}else{$refrencelast = null;}

		if(isset($this->options['phone1typemv'])){
		    $refrencephone1type = $this->options['phone1typemv'];
		}else{$refrencephone1type = null;}

		if(isset($this->options['phone1mv'])){
		    $refrencephone1 = $this->options['phone1mv'];
		}else{$refrencephone1 = null;}
		if(isset($this->options['phone2typemv'])){
		    $refrencephone2type = $this->options['phone2typemv'];
		}else{$refrencephone2type = null;}

		if(isset($this->options['phone2mv'])){
		    $refrencephone2 = $this->options['phone2mv'];
		}else{$refrencephone2 = null;}

		if(isset($this->options['relationmv'])){
		    $refrencerelation = $this->options['relationmv'];
		}else{$refrencerelation = null;}

		$comment    = $this->options['note-comment'];
        $subject    = $this->options['note-subject'];
		$fee        = $this->options['quote-fee'];
        $fee        = str_replace(",", "", $fee);
        $down       = $this->options['quote-down'];
        $down       = str_replace(",", "", $fee);
        $terms      = $this->options['quote-terms'];
        $user_id    = $_SESSION['nware']['user_id'];

        $callerlast           = $this->options['caller-last'];
        $callerfirst          = $this->options['caller-first'];
        $callerphone1type     = $this->options['caller-phone1type'];
		$callerphone1         = $this->options['caller-phone1'];
        $callerphone2type     = $this->options['caller-phone2type'];
		$callerphone2         = $this->options['caller-phone2'];
		$callerrelation       = $this->options['caller-relation'];

        $logged = date( 'Y-m-d h:i:s' );

                $params = array(
        			':last'     	    => $last,
        			':first'    	    => $first,
        			':middle'   	    => $middle,
        			':dob'      	    => $dob,
        			':gender'  		    => $gender,
                    ':race'  		    => $race,
                    ':address'          => $address,
                    ':city'  	        => $city,
        		    ':state'  	        => $state,
        		    ':zip'  		    => $zip,
        			':phone1type'	    => $phone1type,
        			':phone1'		    => $phone1,
        			':phone2type'	    => $phone2type,
        			':phone2'		    => $phone2,
        			':source'           => $source,
        		    ':logged'           => $logged,
        		    ':standing'         => $standing,
        		    ':jail'             => $jail,
                    ':warrant'          => $warrant,
        		    ':other'            => $other,
        		    ':identifiertype'   => $identifiertype,
        		    ':identifier'       => $identifier,
					':quotefee'         => $fee,
					':quotedown'        => $down,
					':quoteterms'       => $terms,
                    ':linkid'           => $linkid
        		);


		$sql = "INSERT INTO agency_clients
		(`type`,`last`,`first`,`middle`,`dob`,`gender`,`race`,`phone1type`,`phone1`,`phone2type`,`phone2`,`source`,`standing`,`standingcustodyjail`,`standingwarrantdescription`,`standingotherdescription`,`identifiertype`,`identifier`,`address`,`city`,`state`,`zip`,`logged`,`quotefee`,`quotedown`,`quoteterms`,`accountbalance`,`link_id`)
		VALUES
		('Prospect',:last,:first,:middle,:dob,:gender,:race,:phone1type,:phone1,:phone2type,:phone2,:source,:standing,:jail,:warrant,:other,:identifiertype,:identifier,:address,:city,:state,:zip,:logged,:quotefee,:quotedown,:quoteterms,0,:linkid)";

        $sql = str_replace("'NULL'", "NULL", $sql);
		$stmt = parent::query($sql, $params);
		$id = parent::$dbh->lastInsertId();

        if ($linkid==''){
		    $sql1 = "UPDATE `agency_clients` SET `link_id` = '$id' WHERE `id` = $id;";
		    $stmt = parent::query($sql1);
        }

		$count = (count($amount)/2)-1 ;
		$count2 = (count($refrencerelation)/2)-1 ;
		for ($i = 0 ; $i <= $count ; $i++  ){
			$sql1 = "INSERT INTO agency_bonds (`amount`,`class`,`charge`,`county`,`court`,`client_id`,`casenumber`,`checkamount`) VALUES ('$amount[$i]','$class[$i]','$charge[$i]','$county[$i]','$court[$i]','$id','$casenumber[$i]','$checkamount[$i]' )";
			$stmt = parent::query($sql1);
		}

		for ($j = 0 ; $j <= $count2 ; $j++  ){
            $sql1 = "INSERT INTO `agency_clients_references` (`last`,`first`,`phone1type`,`phone1`,`phone2type`,`phone2`,`relation`,`caller`,`client_id`) VALUES ('$refrencelast[$j]','$refrencefirst[$j]','$refrencephone1type[$j]','$refrencephone1[$j]','$refrencephone2type[$j]','$refrencephone2[$j]','$refrencerelation[$j]',0,$id);";
			$stmt = parent::query($sql1);
		}

        $sql2 = "INSERT INTO `agency_clients_notes` (`comment`,`subject`,`client_id`,`user_id`) VALUES ('$comment','$subject',$id,$user_id);";

		parent::query($sql2);

		if(!empty($callerlast)){
            $sql7 = "INSERT INTO `agency_clients_references` (`last`,`first`,`phone1type`,`phone1`,`phone2type`,`phone2`,`relation`,`caller`,`client_id`) VALUES ('$callerlast','$callerfirst','$callerphone1type','$callerphone1','$callerphone2type','$callerphone2','$callerrelation',1,$id);";
	        $stmt7 = parent::query($sql7);
		}

		$directory = dirname(dirname(__FILE__)) ."/documents/". $id ;

		if(!is_dir( $directory )) {
			mkdir($directory ."/");
			mkdir($directory ."/application/");
			mkdir($directory ."/legal/");
			mkdir($directory ."/premium/");
			mkdir($directory ."/root/");
			mkdir($directory ."/trash/");
		 }

		echo "<div class='alert alert-success' id='status'>".$id."</div>";

	}

    private function list_simpleclients(){

        global $generic;
        $sval = $_POST['search-value'];
        $sval = ltrim($sval," ");
        $sval = rtrim($sval," ");

        $svals = explode(" ", $sval);
        $rcount = count($svals);
        if ($rcount==1){
            $sfirstorlast = $svals[0];
             $sql = "SELECT * FROM agency_clients WHERE (first LIKE '%" . $sfirstorlast . "%' OR last LIKE '%" . $sfirstorlast . "%') AND flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 51";
	    } else if ($rcount==2){
            $sfirst = $svals[0];
            $slast = $svals[1];
            $sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $sfirst . "%' AND last LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 51";
        } else {
            $sfirst = $svals[0];
            $smiddle = $svals[1];
            $slast = $svals[2];
            $sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $sfirst . "%' AND  middle LIKE '%" . $smiddle . "%' AND last LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 51";
        }

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 50 ) {
            echo '<h5 id="error">Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
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
                $arr[] = array(
                    'id'    => $row['id'],
                    'name'  => $sname,
					'first' => $row['first'],
					'last' => $row['last'],
					'middle' => $row['middle'],
                    'dob'   => date('m/d/Y',strtotime($row['dob'])),
                    'ssn'   => $row['ssnlast4'],
                    'address'   => $row['address'],
                    'city'   => $row['city'],
                    'state'   => $row['state'],
                    'zip'   => $row['zip'],
                    'type'  => $row['type'],
                    'standing' => $row['standing'],
                    'logged' => date('m/d/Y h:i A',strtotime($row['logged']))
                );
          }
          echo json_encode($arr);
        }

    }

}

$wizardscreateprospect = new Wizards_create_prospect();
?>