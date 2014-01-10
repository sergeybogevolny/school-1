<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Tasks extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_GET['lastpayment'])) $this->getLastPaymentClientList();
		
		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

			if (!empty($_POST['task-id'])){
                $this->id = parent::secure($_POST['task-id']);
                $this->task = parent::secure($_POST['task-name']);
                $this->type = parent::secure($_POST['task-type']);
                $this->deadline = parent::secure($_POST['task-deadline']);
                $this->description = parent::secure($_POST['task-description']);
                $this->userid  = parent::secure($_POST['user-id']);
                $this->assignedid  = parent::secure($_POST['assigned-id']);

				if (isset($_POST['task-important'])){
                    $this->important = parent::secure($_POST['task-important']);
                } else {
                    $this->important = 0;
                }
                $this->validatetask();
                $this->addtask();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            }

            exit;

        }

	}

	private function validatetask() {
        if(empty($this->task)) {
			$this->error = '<div class="alert alert-error">You must enter a Task</div>';
		} else if(empty($this->type)) {
			$this->error = '<div class="alert alert-error">You must enter a Type</div>';
		} else if(empty($this->deadline)) {
			$this->error = '<div class="alert alert-error">You must enter a Deadline</div>';
		}
	}

    private function addtask() {
		print_r($_POST); 
		if(!empty($this->error))
			return false;

        $task         = $this->task;
        $type         = $this->type;
        $deadline     = date('Y-m-d H:i:s', strtotime($this->deadline));
        $description  = $this->description;
        $important    = $this->important;
        $user_id      = $this->userid;
		
		if(!empty($this->assignedid)){
			
			$assigned_id  = $this->assignedid;
		
		}
		else{
			
			$assigned_id = $_SESSION['nware']['user_id'];
		
		}
		
        $datetime = date('Y-m-d H:i:s');
        $fdeadline = date('F jS Y', strtotime($this->deadline));
		
		if(isset($_POST['clientlist'])){
			
				$clientlist = $_POST['clientlist'];
				foreach( $clientlist as $list ){
					$desc = $description.'automated task for'.$list;
					$sql = "
						INSERT INTO agency_users_tasks
						(task, type, assigned_date, deadline, description, user_id , assigned_id, flag_important )
						VALUES
						('$task', '$type', '$datetime', '$deadline', '$desc','$user_id', '$assigned_id', '$important')
					";
					$stmt = parent::query($sql);
					$taskid = parent::$dbh->lastInsertId();
			
					$data = array(
						'task_id'       => $taskid,
						'type'          => 'new_task',
						'profile_id'    => $_SESSION['nware']['user_id'],
						'datetime'      => $datetime,
						'activity'      =>	"<p>
											<strong>Task: </strong>$task<br>
											<strong>Deadline: </strong>$fdeadline<br>
											</p>"
					);
			
				   $this->addTimeline($data);
				}
				
		
		}else{
         
				$sql = "
					INSERT INTO agency_users_tasks
					(task, type, assigned_date, deadline, description, user_id , assigned_id, flag_important )
					VALUES
					('$task', '$type', '$datetime', '$deadline', '$description','$user_id', '$assigned_id', '$important')
				";
				$stmt = parent::query($sql);
				$taskid = parent::$dbh->lastInsertId();
		
				$data = array(
					'task_id'       => $taskid,
					'type'          => 'new_task',
					'profile_id'    => $_SESSION['nware']['user_id'],
					'datetime'      => $datetime,
					'activity'      =>	"<p>
											<strong>Task: </strong>$task<br>
											<strong>Deadline: </strong>$fdeadline<br>
										</p>"
				);
		
			   $this->addTimeline($data);
		}

	   $this->result = '<div class="alert alert-success">Successfully added record</div>';

	}

    public function addTimeline($data) {
		$task_id = $data['task_id'];
		$type = $data['type'];
		$profile_id = $data['profile_id'];
		$datetime = $data['datetime'];
		$activity = $data['activity'];

		$sql = "
			INSERT INTO agency_users_timeline
			(task_id, type, profile_id, datetime, activity)
			VALUES
			($task_id, '$type', $profile_id, '$datetime', '$activity')
		";
		$stmt = parent::query($sql);
		
	}

    public function getTasksList($type) {
		
		if($type == 'mytask'){
		
			$sql = "SELECT id, task, type, deadline, flag_important	FROM agency_users_tasks WHERE user_id = ".$_SESSION['nware']['user_id']." ORDER BY flag_important DESC, assigned_date";
		
		}else if($type == 'myassignedtask'){
		
		 if(isset($_GET['filter'])){
			$filter = $_GET['filter'];
			if($filter == 'payment')
			{
			$sql = "SELECT agency_users_tasks.id, agency_users_tasks.task, agency_users_tasks.type, agency_users_tasks.deadline, agency_users_tasks.flag_important,login_users.email FROM agency_users_tasks LEFT JOIN login_users ON agency_users_tasks.assigned_id = login_users.user_id  WHERE type = 'payment' AND assigned_id = ".$_SESSION['nware']['user_id']." ORDER BY flag_important DESC, assigned_date";
			}else if($filter == 'court')
			{
			$sql = "SELECT agency_users_tasks.id, agency_users_tasks.task, agency_users_tasks.type, agency_users_tasks.deadline, agency_users_tasks.flag_important,login_users.email FROM agency_users_tasks LEFT JOIN login_users ON agency_users_tasks.assigned_id = login_users.user_id  WHERE type = 'court' AND assigned_id = ".$_SESSION['nware']['user_id']." ORDER BY flag_important DESC, assigned_date";
			
			}else if($filter == 'problem'){
			$sql = "SELECT agency_users_tasks.id, agency_users_tasks.task, agency_users_tasks.type, agency_users_tasks.deadline, agency_users_tasks.flag_important,login_users.email FROM agency_users_tasks LEFT JOIN login_users ON agency_users_tasks.assigned_id = login_users.user_id  WHERE type = 'problem' AND assigned_id = ".$_SESSION['nware']['user_id']." ORDER BY flag_important DESC, assigned_date";
			}
		 }else{
			$sql = "SELECT agency_users_tasks.id, agency_users_tasks.task, agency_users_tasks.type, agency_users_tasks.deadline, agency_users_tasks.flag_important,login_users.email FROM agency_users_tasks LEFT JOIN login_users ON agency_users_tasks.assigned_id = login_users.user_id  WHERE  assigned_id = ".$_SESSION['nware']['user_id']." ORDER BY flag_important DESC, assigned_date";
				
			}

		
		
		
		}

		$stmt = parent::query($sql);

		if ($stmt->rowCount() > 0) {
        ?>
    <table class="table table-hover table-nomargin dataTable table-bordered dataTable-nofooter dataTable  dataTable-tools" id="mytasktable">
      <thead>
        <tr>
        <?php if(isset($_GET['filter'])) echo '<th><input type="checkbox" name="tasklist" id="check_all" onclick="checkall()"></th>'; ?>  
        <th>Deadline</th>
        <?php if($type == 'myassignedtask')  echo '<th>User</th>'; ?>
          <th>Type</th>
          <th>Description</th>
          
			<!--  <th>Important</th>-->        
        </tr>
      </thead>
      <tbody>
     
        <?php while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) :
			$type = $row['type'];
			$task = $row['task'];
			$deadline = $row['deadline'];
            $important = $row['flag_important'];
			
			if(isset($row['email'])){ $email = $row['email'];}
           
		    $bookmark = "";
            if ($important=='1'){
                $bookmark = "bookmarked";
            }
            $id = $row['id'];

        ?>

	  <tr class="<?php echo $bookmark; ?>">
           
            <?php if(isset($_GET['filter'])){ ?>
            <td>
			     <input type="checkbox" class="mytask"  name="filter_task[]" id="<?php echo $id; ?>"/>
            </td>
        <?php } ?>
            <td>
			     <?php echo $deadline; ?>
            </td>
           
           <?php if( isset($email)){ ?>
           
                <td>
                     <?php echo $email; ?>
                </td>
            
            <?php } ?>
            
       	    <td class="task-type">
           			<img src="<?php echo 'img/task_list_' . $type . '.png'; ?>">
                    <?php echo  $type ; ?>
       		</td>
        	<td class="task">
                 <a href="task.php?id=<?php echo $id;?>"><?php echo $task; ?></a>
             </td>
             
          
            <!--<td class="task-actions">
                <div class='task-bookmark'><i class="icon-bookmark-empty"></i></div>
            </td>-->
    	 	

		<?php endwhile; ?>
           </tr>
          </tbody>
          <tfoot>
          </tfoot>
        </table>
        
        <?php
	    }

    }
	
   
   
   
 public function getLastPaymentClientList() {
		
		$now = date('Y-m-d');
		
	    $sql = "SELECT id, last, first, middle,nextpayment FROM agency_clients WHERE nextpayment < '".$now."' ORDER BY nextpayment DESC";
		
		$stmt = parent::query($sql);

		if ($stmt->rowCount() > 0) {
        ?>
    <table class="table table-hover table-nomargin dataTable table-bordered dataTable-nofooter">
      <thead>
        <tr>
        <th>check</th>
          <th>client</th>
          
        </tr>
      </thead>
      <tbody>
     
			<?php while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) :
                $id = $row['id'];
                $first = $row['first'];
                $middle = $row['middle'];
                $last = $row['last'];
                $nextpayment = $row['nextpayment'];
                
            ?>
    
          <tr>
                <td class="with-checkbox  sorting_1">
                     <input type="checkbox"  name="clientlist[]" id="checkLastPaymentClient" value="<?php echo $last.' '.$first; ?>"/>
                </td>
                <td>
                   <?php echo $last.' '.$first; ?>
                </td>
            
           </tr>			
          <?php endwhile; ?>
       
      </tbody>
  <tfoot>
  </tfoot>
</table>

        <?php
	    }

    }
	

}

$tasks = new Tasks();

?>