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

        $slast     	 	= $this->options['review_student_lastname'];
        $sfirst		 	= $this->options['review_student_firstname'];
        $smiddle     	= $this->options['review_student_middlename'];
        $sstreet   	 	= $this->options['review_student_current_street'];
        $scity		 	= $this->options['review_student_current_city'];
        $sstate      	= $this->options['review_student_current_state'];
        $szip      	 	= $this->options['review_student_current_zip'];
		
        $flast     	 	= $this->options['review_student_fatherlastname'];
        $ffirst		 	= $this->options['review_student_fatherfirstname'];
        $fmiddle     	= $this->options['review_student_fathermiddlename'];
        $fphon1type  	= $this->options['review_father_phone1_type'];
        $fphon1		 	= $this->options['review_father_phone1'];
        $fphon2type  	= $this->options['review_father_phone2_type'];
        $fphon2    	 	= $this->options['review_father_phone2'];
        $fqualificaton	= $this->options['review_father_qualification'];
        $foccupation    = $this->options['review_father_occupation'];
		
        $mlast     	 	= $this->options['review_student_motherlastname'];
        $mfirst		 	= $this->options['review_student_motherfirstname'];
        $mmiddle     	= $this->options['review_student_mothermiddlename'];
        $mphon1type  	= $this->options['review_mother_phone1_type'];
        $mphon1		 	= $this->options['review_mother_phone1'];
        $mphon2type  	= $this->options['review_mother_phone2_type'];
        $mphon2    	 	= $this->options['review_mother_phone2'];
        $mqualificaton	= $this->options['review_mother_qualification'];
        $moccupation    = $this->options['review_mother_occupation'];
		
        $pstreet   	 	= $this->options['review_student_parmanent_street'];
        $pcity		 	= $this->options['review_student_parmanent_city'];
        $pstate      	= $this->options['review_student_parmanent_state'];
        $pzip      	 	= $this->options['review_student_parmanent_zip'];
        $pcountry      	= $this->options['review_student_parmanent_country'];
        $premark     	= $this->options['review_student_parmanent_remark'];

        $glast     	 	= $this->options['review_guardian_lastname'];
        $gfirst		 	= $this->options['review_guardian_firstname'];
        $gmiddle      	= $this->options['review_guardian_middlename'];
        $gphon1type  	= $this->options['review_guardian_phone1_type'];
        $gphon1		 	= $this->options['review_guardian_phone1'];
        $gphon2type  	= $this->options['review_guardian_phone2_type'];
        $gphon2    	 	= $this->options['review_guardian_phone2'];
        $gqualificaton	= $this->options['review_guardian_qualification'];
        $goccupation    = $this->options['review_guardian_occupation'];
        $gstreet   	 	= $this->options['review_student_guardian_street'];
        $gcity		 	= $this->options['review_student_guardian_city'];
        $gstate      	= $this->options['review_student_guardian_state'];
        $gzip      	 	= $this->options['review_student_guardian_zip'];
        $gcountry      	= $this->options['review_student_guardian_country'];
        $gremark     	= $this->options['review_student_guardian_remark'];

		if (isset($_POST['personal-gender'])){
            $gender = parent::secure($_POST['personal-gender']);
        } else {
            $gender='';
        }



		$sql = "INSERT INTO student_detail
		(`student_lastname`,`student_middlename`,`student_sex`,`student_current_street`,`student_current_city`,
`student_current_state`,`student_current_zip`,`father_firstname`,`father_lastname`,`father_middlename`,`father_phone1_type`,
`father_phone1`,`father_phone2_type`,`father_phone2`,`father_qualification`,`father_occupation`,`mother_firstname`,
`mother_lastname`,`mother_middlename`,`mother_phone1_type`,`mother_phone1`,`mother_phone2_type`,`mother_phone2`,
`mother_qualification`,`mother_occupation`,`student_parmanent_street`,`student_parmanent_city`,`student_parmanent_state`,
`student_parmanent_zip`,`student_parmanent_country`,`guardian_firstname`,`guardian_middlename`,`guardian_lastname`,
`guardian_phone1_type`,`guardian_phone1`,`guardian_phone2_type`,`guardian_phone2`,`guardian_qualification`,
`guardian_occupation`,`student_guardian_street`,`student_guardian_cit`,`student_guardian_state`,`student_guardian_country`,
`student_guardian_zip`,`student_guardian_remark`,)
		VALUES
		('$slast','$smiddle','','$sstreet','$scity','$sstate','$szip','$ffirst','$flast','$fmiddle','$fphon1type','$fphon1','$fphon2type','$fphon2','$fqualificaton','$foccupation','$mfirst','$mlast','$mmiddle','$mphon1type','$mphon1','$mphon2type','$mphon2','$mqualificaton','$mqualificaton','$pstreet','$pcity','$pstate','$pzip','$pcountry','$gfirst','$glast','$gmiddle','$gphon1type','$gphon1','$gphon2type','$gphon2','$gqualificaton','$goccupation','$gstreet','$gcity','$gstate','$gcountry','$gzip','$gremark')";

print_r($_POST);
		echo "<div class='alert alert-success' id='status'></div>";

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