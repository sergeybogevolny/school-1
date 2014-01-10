<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Valuelist extends Generic {

	function __construct() {

       if(!empty($_GET['valuelist'])) {

            $valuelist = $_GET['valuelist'];

            switch ($valuelist){
                case 'studentname':
                    $this->list_studentname();
                    break;
                case 'label':
                    $this->list_label();
                    break;
				case 'fathername':
                    $this->list_fathername();
            }
        }

	}

    private function list_studentname() {

        global $generic;
        $sql = 'SELECT id, student_firstname, student_middlename,student_lastname FROM student_detail';
	    $query = $generic->query($sql);
        if( $query->rowCount() < 1 ) {
            echo '[]';
        } else {
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              $agents[] = $row['student_firstname'].' '.$row['student_middlename'].' '.$row['student_lastname'];
          }
          echo json_encode($agents);
        }
	}

    private function list_label() {

        global $generic;
        $sql = 'SELECT id, label FROM student_detail';
	    $query = $generic->query($sql);
        if( $query->rowCount() < 1 ) {
            echo '[]';
        } else {
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              $attorneys[] = $row['label'];
             
          }
          echo json_encode($attorneys);
        }
	}

    private function list_fathername() {

        global $generic;
        $sql = 'SELECT id, father_firstname, father_middlename, father_lastname FROM student_detail';
	    $query = $generic->query($sql);
        if( $query->rowCount() < 1 ) {
            echo '[]';
        } else {
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
              $agents[] =  $row['father_firstname'].' '.$row['father_middlename'].' '.$row['father_lastname'];
                 
             
          }
          echo json_encode($agents);
        }
	}

}
$valuelist = new Valuelist();

?>