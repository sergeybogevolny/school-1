<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_forfeitres_record extends Generic {

	private $options = array();

    function __construct() {
        if(!empty($_GET['powerid'])) $this->getGeneralPowerDetail();

		if(!empty($_POST)) {

            foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);
				$this->validate();
				$this->add();
				if(!empty($this->error)){
					echo $this->error;
				}else {
					echo $this->result;
				}

	   }
	}
	
   private function validate() {
	    if(empty($this->options['forfeiture-record-received'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
		} else if(empty($this->options['forfeiture-record-caseno'])) {
			$this->error = '<div class="alert alert-error">Required fields missing.</div>';
        }
	}

    private function add() {

        $recorded       = date('Y-m-d H:i:s');
        $received       = strtotime($this->options['forfeiture-record-received']);
        $received       = date('Y-m-d', $received);
        $caseno         = $this->options['forfeiture-record-caseno'];
        $forfeited      = strtotime($this->options['forfeiture-record-forfeited']);
        $forfeited      = date('Y-m-d', $forfeited);
        $county         = $this->options['forfeiture-record-county'];
        $amount         = $this->options['forfeiture-record-amount'];
        $amount         = str_replace(',', '', $amount);
        $defendant      = $this->options['forfeiture-record-defendant'];
		$prefix         = $this->options['forfeiture-record-prefix'];
		$serial         = $this->options['forfeiture-record-serial'];
		$comment        = $this->options['forfeiture-record-comment'];

        $civilcitation= mysql_escape_string($_FILES['file']['name']);

        if ($comment!=''){
            $comment = "<p>".$comment."</p>";
        }
        $comment = str_replace("'", '"', $comment);

		$sql = "INSERT INTO general_forfeitures (`recorded`,`received`,`civilcasenumber`,`forfeited`,`county`,`amount`,`defendant`,`prefix`,`serial`,`comment`,`civilcitation`,`type`)VALUES('$recorded','$received','$caseno','$forfeited','$county','$amount','$defendant','$prefix','$serial','$comment','$civilcitation','recorded')";

		$stmt = parent::query($sql);
        $id = parent::$dbh->lastInsertId();

		if(!empty($_FILES['file']['name'])){
			$directory = dirname(dirname(__FILE__)) ."/documents/forfeitures/".$id."/" ;
			if(!is_dir( $directory)) {
				if (!mkdir($directory, 0, true)) {
						die('Failed to create folders...');
					}
			}
			$path = dirname(dirname(__FILE__)) ."/documents/forfeitures/".$id."/";
			$location = $path . $_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'], $location);
		 } else {
		    die('error please add file');
         }

		 echo "<div class='alert alert-success' id='status'>Success</div>";
	}

	public  function getGeneralPowerDetail(){
	        $id = $_GET['powerid'];
			$sql = 'SELECT * FROM `general_powers` WHERE  id = '.$id;
			$stmt = parent::query($sql);

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$agent = $row['agent'];
				$prefix = $row['prefix'];
				$serial = $row['serial'];
				$agent_id = $row['agent_id'];
				$arr[] = array(
				         'agent'=> $agent,
						 'prefix'=>$prefix,
						 'serial'=>$serial,
						 'agentid'=>$agent_id
				          );
				}

			   echo json_encode($arr);
	}

	private function  inquestMessages(){
		$date = date('Y-m-d H:I:S');
		$sender = $_SESSION['nware']['email'];
		$user_id = $_SESSION['nware']['user_id'];
		$mess = 'we got this forfeiture notice,, we believe it is yours, please research your records,, send to us proper defendant name, power number so we can finish processing log';

		$sqlmess = "
			INSERT INTO agency_messages(`sender`,`subject`,`body`,`created`, `user_id`)
			VALUES
			('$sender', 'Forfeiture notice', '$mess', '$date','$user_id')";
		$stmt = parent::query($sqlmess);
	}

	private function  PowerSuccessMessages(){
		$date = date('Y-m-d H:I:S');
		$sender = $_SESSION['nware']['email'];
		$user_id = $_SESSION['nware']['user_id'];
		$mess = 'That forfeiture has been logged';

		$sqlmess = "
			INSERT INTO agency_messages(`sender`,`subject`,`body`,`created`, `user_id`)
			VALUES
			('$sender', 'Forfeiture success notice', '$mess', '$date','$user_id')";
		$stmt = parent::query($sqlmess);
	}

	public function list_general_defendent(){
		global $generic;
		$sql = "SELECT defendant FROM general_powers_reports_details GROUP BY defendant";
		$stmt = parent::query($sql);
		$defendant = '<option value=""></option>';
			if ($stmt->rowCount() > 0) {
				$this->counties = array();
				while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
					$name = $row['defendant'];
					//$id = $row[''];
					$defendant .= '<option value="'.$name.'">'.$name.'</option>';
				}
			}
			echo $defendant;
	}
  
    private function list_powers(){

        global $generic;
		$fprefix =  $_POST['searchvalue'];
        $sql = "SELECT * FROM general_powers WHERE bond_id is null";
        $sql = $sql . " AND (prefix  LIKE '%".$fprefix."%' OR serial LIKE '%".$fprefix."%')";
		$sql = $sql . " ORDER BY prefix DESC, `int` DESC";
        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 300 ) {
            echo '<h5>Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
             echo '<h5>'.$rcount . ' record(s) found.</h5>';
            ?>
	            <table class="table table-hover table-nomargin dataTable table-bordered loadresult">
		            <thead>
            			<tr>
                            <th class='with-checkbox'></th>
                            <th>Prefix</th>
                            <th>Serial</th>
                            <th>Amount</th>
                            <th style="display:none">Agent</th>
                            <th style="display:none">Agentid</th>
            			</tr>
		            </thead>
    		        <tbody>
          		    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
	                    if(!empty($row)){
	                    ?>
	                    <tr>
                            <td><input type="checkbox" name="check" class="checkedt  checku icheck-me"  onclick="Stepfirstvalidate()"  data-skin="square" data-color="blue" ></td>
                            <td><?php echo $row['prefix']; ?></td>
                            <?php echo "<td>" . $row['serial'] ."</td>";?>
                            <td><?php echo $row['value']; ?></td>
                            <td style="display:none"><?php echo $row['agent']; ?></td>
                            <td style="display:none"><?php echo $row['agent_id']; ?></td>
	                    </tr>
	                    <?php
                       }
                    }
          		    ?>
    		        </tbody>
                    <tfoot>
                    </tfoot>
	            </table>
            <?php
        }

    }

    private function list_defendent(){

        global $generic;
        $sval = $_POST['searchvalue'];
        $sval = ltrim($sval," ");
        $sval = rtrim($sval," ");

        $svals = explode(" ", $sval);
        $rcount = count($svals);

        $sql = "SELECT * FROM general_bonds WHERE";
        $sql = $sql . "  (name  LIKE '%".$sval."%')";
		$sql = $sql . " GROUP BY name";
        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 100 ) {

            echo '<h5>Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
             echo '<h5>'.$rcount . ' record(s) found.</h5>';
        ?>
	            <table class="table table-hover table-nomargin dataTable table-bordered loadresult">
		            <thead>
            			<tr>
                            <th class='with-checkbox'></th>
                            <th>name</th>
            			</tr>
		            </thead>
    		        <tbody>
          		    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
	                    if(!empty($row)){
	                    ?>
	                    <tr>
                            <td><input type="checkbox" name="check" class="checkedt icheck-me" value="1" onclick="Stepfirstvalidate()" data-skin="square" data-color="blue" "></td>
                            <td><?php echo $row['name']; ?></td>
                           
	                    </tr>
	                    <?php
                       }
                    }
          		    ?>
    		        </tbody>
                    <tfoot>
                    </tfoot>
	            </table>
            <?php
        }
    }
}

$wizardsforfeitresrecord = new Wizards_forfeitres_record();
?>