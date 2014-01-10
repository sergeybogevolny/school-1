<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Dashboard_production extends Generic
{
	private $options = array();

    function __construct() {
      // print_r( preg_replace('/\s+/', '', 'niranjan singh'));
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
		if( !empty($_GET['studentname'])){
		  $sval_student = $_GET['studentname'];
		  $sval_student = preg_replace('/\s+/', '', $sval_student);
		}else{
		   $sval_student = '';
		}
		
        if( !empty($_GET['fathername'])){
		  $sval_father = $_GET['fathername'];
		  $sval_father = preg_replace('/\s+/', '', $sval_father);
		
		}else{
			$sval_father = '';
		}
		
        $sval_label = $_GET['lable'];
        

		
      if( $sval_student != '' && $sval_father == '' && empty($sval_label)){  
       
	    $sql = "SELECT * FROM student_detail  WHERE  CONCAT_WS(student_firstname,student_middlename,student_lastname) LIKE '%$sval_student%'";
	
	  }else if( $sval_student == '' && $sval_father != '' && empty($sval_label)){
	   
	    $sql = "SELECT * FROM student_detail  WHERE  CONCAT_WS(father_firstname,father_middlename,father_lastname) LIKE '%$sval_father%'";
        
	  }else if($sval_student == '' && $sval_father == '' && !empty($sval_label) ){
	    $sql = "SELECT * FROM student_detail  WHERE  label LIKE '%$sval_label%'";
	  
	  }else if($sval_student != '' && $sval_father != '' && empty($sval_label)){
	   
	    $sql = "SELECT * FROM student_detail  WHERE  CONCAT_WS(student_firstname,student_middlename,student_lastname) LIKE '%$sval_student%' AND CONCAT_WS(father_firstname,father_middlename,father_lastname) LIKE '%$sval_father%'";
	
	  }else if($sval_student == '' && $sval_father != '' && !empty($sval_label) ){
		  
	    $sql = "SELECT * FROM student_detail  WHERE  CONCAT_WS(father_firstname,father_middlename,father_lastname) LIKE '%$sval_father%' AND label LIKE '%$sval_label%'";
	
	  }else if($sval_student != '' && $sval_father == '' && !empty($sval_label) ){
		  
	    $sql = "SELECT * FROM student_detail  WHERE  CONCAT_WS(student_firstname,student_middlename,student_lastname) LIKE '%$sval_student%' AND label LIKE '%$sval_label%'";
	
	  }else if($sval_student != '' && $sval_father != '' && !empty($sval_label) ){
	    $sql = "SELECT * FROM student_detail  WHERE  CONCAT_WS(student_firstname,student_middlename,student_lastname) LIKE '%$sval_student%' AND CONCAT_WS(father_firstname,father_middlename,father_lastname) LIKE '%$sval_father%' AND label LIKE '%$sval_label%'";
	  
	  }
		

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
           // echo '<h5 id="error">No records found in search.  Please modify your search.</h5>';
			$arr[] = '';
        } else {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $sname = '';
                if ($row['student_firstname']!=""){
                  $sname = $row['student_firstname'];
                  $fname = $row['father_firstname'];
                }
                if ($row['student_middlename']!=""){
                  $sname = $sname . ' ' . $row['student_middlename'];
                  $fname = $fname . ' ' . $row['father_middlename'];
                }
                if ($row['student_lastname']!=""){
                  $sname = $sname . ' ' . $row['student_lastname'];
                  $fname = $fname . ' ' . $row['father_lastname'];
                }
                $arr[] = array(
                    'id'    	=> $row['id'],
                    'name'  	=> $sname,
 					'image' 	=> $row['image'],
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