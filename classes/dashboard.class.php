<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Dashboard_production extends Generic
{
	private $options = array();

    function __construct() {

        if(!empty($_GET['filter'])) $this->list_search();
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


    private function list_search(){

        global $generic;
        $sval_student = $_GET['studentname'];
        $sval_student = ltrim($sval_student," ");
        $sval_student = rtrim($sval_student," ");
        $sval_label = $_GET['lable'];
        $sval_label = ltrim($sval_label," ");
        $sval_label = rtrim($sval_label," ");
        $sval_father = $_GET['fathername'];
        $sval_father = ltrim($sval_father," ");
        $sval_father = rtrim($sval_father," ");

        $sval_student = explode(" ", $sval_student);
        $rcount = count($sval_student);
        if ($rcount==1){
            $sfirstorlast = $sval_student[0];
             $sql = "SELECT * FROM student_detail WHERE (student_firstname LIKE '%" . $sfirstorlast . "%' OR student_lastname LIKE '%" . $sfirstorlast . "%') AND flag = 0 ORDER BY student_lastname DESC, student_firstname DESC, student_middlename DESC LIMIT 51";
	    } else if ($rcount==2){
            $sfirst = $sval_student[0];
            $slast = $svals[1];
            $sql = $sql = "SELECT * FROM student_detail WHERE student_firstname LIKE '%" . $sfirst . "%' AND student_lastname LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY last DESC, student_firstname DESC, student_middlename DESC LIMIT 51";
        } else {
            $sfirst  = $sval_student[0];
            $smiddle = $sval_student[1];
            $slast   = $sval_student[2];
            $sql = $sql = "SELECT * FROM student_detail WHERE student_firstname LIKE '%" . $sfirst . "%' AND  student_middlename LIKE '%" . $smiddle . "%' AND student_lastname LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY student_lastname DESC, student_firstname DESC, student_middlename DESC LIMIT 51";
        }

        $sval_father = explode(" ", $sval_father);
        $rcount = count($sval_father);
        if ($rcount==1){
            $sfirstorlast = $sval_father[0];
             $sql = "SELECT * FROM student_detail WHERE (father_firstname LIKE '%" . $sfirstorlast . "%' OR father_lastname LIKE '%" . $sfirstorlast . "%') AND flag = 0 ORDER BY father_lastname DESC, father_firstname DESC, father_middlename DESC LIMIT 51";
	    } else if ($rcount==2){
            $sfirst = $sval_father[0];
            $slast  = $svals[1];
            $sql = $sql = "SELECT * FROM student_detail WHERE father_firstname LIKE '%" . $sfirst . "%' AND father_lastname LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY last DESC, father_firstname DESC, father_middlename DESC LIMIT 51";
        } else {
            $sfirst  = $sval_father[0];
            $smiddle = $sval_father[1];
            $slast   = $sval_father[2];
            $sql = $sql = "SELECT * FROM student_detail WHERE father_firstname LIKE '%" . $sfirst . "%' AND  father_middlename LIKE '%" . $smiddle . "%' AND father_lastname LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY student_lastname DESC, father_firstname DESC, father_middlename DESC LIMIT 51";
        }

//        $sval_father = explode(" ", $sval_label);
//        $rcount = count($sval_label);
//        if ($rcount==1){
//            $sfirstorlast = $sval_father[0];
//             $sql1 = "SELECT * FROM student_detail WHERE (father_firstname LIKE '%" . $sfirstorlast . "%' OR father_lastname LIKE '%" . $sfirstorlast . "%') AND flag = 0 ORDER BY father_lastname DESC, father_firstname DESC, father_middlename DESC LIMIT 51";
//	    } else if ($rcount==2){
//            $sfirst = $sval_father[0];
//            $slast  = $svals[1];
//            $sql1 = $sql = "SELECT * FROM student_detail WHERE father_firstname LIKE '%" . $sfirst . "%' AND father_lastname LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY last DESC, father_firstname DESC, father_middlename DESC LIMIT 51";
//        } else {
//            $sfirst  = $sval_father[0];
//            $smiddle = $sval_father[1];
//            $slast   = $sval_father[2];
//            $sql1 = $sql = "SELECT * FROM student_detail WHERE father_firstname LIKE '%" . $sfirst . "%' AND  father_middlename LIKE '%" . $smiddle . "%' AND father_lastname LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY student_lastname DESC, father_firstname DESC, father_middlename DESC LIMIT 51";
//        }

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found in search.  Please modify your search.</h5>';
			$arr[] = '';
        } else if( $rcount > 50 ) {
            echo '<h5 id="error">Records found exceeds limit.  Please narrow your search.</h5>';
						$arr[] = '';

        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $sname = '';
                if ($row['student_firstname']!=""){
                  $sname = $row['student_firstname'];
                  $fname = $row['father_firstname'];
                }
                $sname = trim($sname);
                if ($row['student_middlename']!=""){
                  $sname = $sname . ' ' . $row['student_middlename'];
                  $fname = $fname . ' ' . $row['father_middlename'];
                }
                $sname = trim($sname);
                if ($row['student_lastname']!=""){
                  $sname = $sname . ' ' . $row['student_lastname'];
                  $fname = $fname . ' ' . $row['father_lastname'];
                }
                $arr[] = array(
                    'id'    	=> $row['id'],
                    'name'  	=> $sname,
//					'first' 	=> $row['student_firstname'],
//					'last' 		=> $row['student_lastname'],
//					'middle' 	=> $row['student_middlename'],
                    'fname'  	=> $fname,
//					'ffirst' 	=> $row['father_firstname'],
//					'flast' 	=> $row['father_lastname'],
//					'fmiddle' 	=> $row['father_middlename'],
                    'created'  	=> $row['created'],
                    'class'  	=> $row['label'],
                    'section'  	=> $row['section']
                );
          }
          
        }
echo json_encode($arr);
    }

}

// Initialize Dashboard_production class
$dashboardproduction = new Dashboard_production();
?>