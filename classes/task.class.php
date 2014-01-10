<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Task extends Generic {

	private $options = array();

    function __construct() {


		if(!empty($_GET['id'])) $this->grab();
		if(!empty($_GET['read'])) $this->readDetail();
		
		if(!empty($_POST)) {
			
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

			if (!empty($_POST['detail-id'])){
                $this->id = parent::secure($_POST['detail-id']);
                $this->task = parent::secure($_POST['detail-name']);
                $this->type = parent::secure($_POST['detail-type']);
                $this->deadline = parent::secure($_POST['detail-deadline']);
                $this->description = parent::secure($_POST['detail-description']);
                $this->priority = parent::secure($_POST['detail-priority']);
                $this->validatedetail();
                $this->editdetail();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            } 

			if (!empty($_POST['timeline-id'])){

                $this->comment = parent::secure($_POST['timeline-comment']);
                $this->progress = parent::secure($_POST['timeline-progress']);
                $this->taskid = parent::secure($_POST['task-id']);
                $this->timelineid = parent::secure($_POST['timeline-id']);

               $this->validateTimeline();
                if ($this->timelineid == -1){

                    $this->addTimeline();
                } else {
                    $this->editTimeline();
                }

                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }

            }

            exit;

        }
	}

	private function validatedetail() {
        if(empty($this->task)) {
			$this->error = '<div class="alert alert-error">You must enter a Task</div>';
		} else if(empty($this->type)) {
			$this->error = '<div class="alert alert-error">You must choose a Type</div>';
		} else if(empty($this->deadline)) {
			$this->error = '<div class="alert alert-error">You must enter a Deadline</div>';
		}else if(empty($this->description)) {
			$this->error = '<div class="alert alert-error">You must enter a Description</div>';
		}else if(empty($this->priority)) {
			$this->error = '<div class="alert alert-error">You must choose a Priority</div>';
		}
	}


	private function validateTimeline() {
        if(empty($this->comment)) {
			$this->error = '<div class="alert alert-error">You must enter a Comment</div>';
		}
	}


    private function editdetail() {

		if(!empty($this->error))
			return false;

		$task         = $this->task;
        $type         = $this->type;
        $deadline     = date('Y-m-d H:i:s', strtotime($this->deadline));
        $description  = $this->description;
        $priority    = $this->priority;
        $id           = $this->id;

        $sql = "
			UPDATE tasks SET
            task = '$task', type = '$type', deadline = '$deadline', description = '$description', priority = '$priority'
            WHERE id = $id
		";

		$stmt = parent::query($sql);
        $this->result = '<div class="alert alert-success">Successfully edited record</div>';
	}



    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );
		$stmt   = parent::query("SELECT * FROM tasks WHERE id = :id;", $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

	public function addTimeline(){
		if (!empty($this->error)) return false;
            date_default_timezone_set('America/Indianapolis');
            $date = date('Y-m-d h:i:s');
            $comment    = $this->comment;
            $progress   = $this->progress;
            $profile_id = $_SESSION['nware']['user_id'];
            $task_id    = $this->taskid;
			$generated  = 'user';
			$type       = 'update_status';


        $sql = "INSERT INTO `tasks_timelines` (`activity`,`progress`,`profile_id`,`task_id`,`generated`,`type`,`stamp`) VALUES ('$comment','$progress',$profile_id,$task_id,'$generated','$type','date');";
		parent::query($sql);

        $sql1 ="UPDATE tasks SET progress = '$progress' WHERE id = $task_id";
		parent::query($sql1);

		$this->result = '<div class="alert alert-success">Successfully added record.</div>';

	}


	public function editTimeline(){
		if (!empty($this->error)) return false;
            date_default_timezone_set('America/Indianapolis');
            $date       = date('Y-m-d h:i:s');
            $comment    = $this->comment;
            $progress   = $this->progress;
			$type       = 'update_status';
			$edit       = 1;
            $task_id    = $this->taskid;
			$id         = $this->timelineid;


        $sql ="
			UPDATE tasks_timelines SET
            activity = '$comment', progress = '$progress', type = '$type', edit = '$edit', stamp = '$date'
            WHERE id = $id
		   ";

		parent::query($sql);
        $sql1 ="
			UPDATE tasks SET
            progress = '$progress'
            WHERE id = $task_id
		   ";

		parent::query($sql1);

		$this->result = '<div class="alert alert-success">Successfully added record.</div>';

	}

    public function loadTimeline($id) {
		$sql = "SELECT * FROM tasks_timelines WHERE task_id=".$id." ORDER BY stamp DESC";
		$stmt = parent::query($sql);

		if ( $stmt->rowCount() < 1 ) {
		    echo 0;
		    return false;
		}else {

            $timeline_res = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $timeline_res[] = array(
                'id' => $row['id'],
                'activity' => $row['activity'],
                'progress' => $row['progress']
                );
			}
		}

		return json_encode($timeline_res);
	}




    public function getTimeline($id) {
		$sql = "SELECT * FROM tasks_timelines WHERE task_id=".$id." ORDER BY stamp DESC";
		$stmt = parent::query($sql); ?>

		<ul class="timeline">

        <?php $i=0; while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) :


		    $id   = $row['id'];
			$type = $row['type'];
			$profile_id = $row['profile_id'];
			$datetime = $row['stamp'];
			$comment = $row['activity'];
            $progress = $row['progress'];
			$edit     = $row['edit'];
			$generated = $row['generated'];
			$user_id   = $row['profile_id'];

			switch ($type) {
				case 'new_task' :
					$icon_color = 'grey';
					$icon = 'icon-tasks';
					$leading_text = ' created <strong>Task</strong>';
					break;
                case 'update_status' :
					$icon_color = 'grey';
					$icon = 'icon-tasks';
					$leading_text = ' updated <strong>Status</strong>';
					break;
                case 'new_campaign' :
					$icon_color = 'grey';
					$icon = 'icon-bullhorn';
					$leading_text = ' submitted <strong>Campaign</strong>';
					break;
			}

			$profile_email = $this->getEmail($profile_id);
			$time = date('h:i A', strtotime($datetime));
			$date = date('F jS Y', strtotime($datetime));

            ?>

			<li>
				<div class="timeline-content">
					<div class="left">
						<div class="icon <?php echo $icon_color; ?>">
							<i class="<?php echo $icon; ?>"></i>
						</div>
						<div class="date"><?php echo $time; ?></div>
					</div>
					<div class="activity">
					    <div class="user"><?php echo $profile_email;?><span><?php echo $leading_text; ?></span>

                            <?php if( $edit == 1 ){
					             echo '<i class="icon-pencil"></i>';
					         } ?>

                        </div>
                        <?php if ($comment!='') { ?>
                            <div>
                <?php if( $i == 0 && $generated == 'user' && $user_id == $_SESSION['nware']['user_id']) {?>
                <a href="#" onclick="LoadTimeline(<?php echo $id ?>)">
							<?php echo $comment; ?>
                 </a>
                     <?php }else{ ?>
                            <?php echo $comment; ?>
                           <?php } ?>

                            </div>


                        <?php } ?>
                        <div><strong>Date: </strong><?php echo $date; ?></div>
                        <div><strong>Progress: </strong><?php echo $progress; ?>%</div>
					</div>
				</div>
				<div class="line"></div>
			</li>
            
		<?php $i++; endwhile; ?>

		</ul>

    <?php
	}

    private function getName($id) {
		$sql = "SELECT name FROM login_users WHERE user_id=".$id." LIMIT 1";

		$stmt = parent::query($sql);
		$name = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$name = $row['name'];
		}
		return $name;
	}

    private function getEmail($id) {
		$sql = "SELECT email FROM login_users WHERE user_id=".$id." LIMIT 1";

		$stmt = parent::query($sql);
		$email = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
			$email = $row['email'];
		}
		return $email;
	}


    public function tasksReads($id) {
		$sql = "SELECT * FROM tasks_reads WHERE task_id=".$id;

		$stmt = parent::query($sql);

		$taskread = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
		   $taskread[] =  $row;
		}
		return $taskread ;
	}


	public function readDetail(){
	    $id = $_GET['id'];
		$stamp = date('Y-m-d h:i:s');

		$sql = "SELECT assignedto FROM tasks WHERE id=".$id;
		$stmt = parent::query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$assignto = $row['assignedto'];
		$changedstr = str_replace('adam@email.com:0','adam@email.com:1',$assignto);

		$sql1 = "UPDATE `tasks` SET `assignedto` = '$changedstr' WHERE id=".$id;
        parent::query($sql1);

        $sql2 = "INSERT INTO `tasks_reads` (`task_id`,`reader`,`stamp`) VALUES ('$id','adam@email.com','$stamp');";
		parent::query($sql2);

	}

	public function isTaskRead($id,$user){

	 $sql      = "SELECT assignedto FROM tasks WHERE id=".$id;
	 $stmt     = parent::query($sql);
	 $row      = $stmt->fetch(PDO::FETCH_ASSOC);
	 $assignto = $row['assignedto'];

	  if (strpos($assignto,$user) != 0){
			$sql1 = "SELECT reader FROM tasks_reads WHERE task_id = '$id' AND reader= '".$user."'";
			$stmt1 = parent::query($sql1);

			if( $stmt1->rowCount() < 1 ) {
				return false;
			 }else{
			    return true;
			 }
		}else{
		        return true;
		}
	}

    public function tasksParty($id) {
		$sql = "SELECT last, first, middle, type FROM agency_clients WHERE id=".$id;
		$stmt = parent::query($sql);

		$taskparty = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
		   $taskparty[] =  $row;
		}
		return $taskparty;
	}
	
	public function dueDateCount($date){
		
		$timestamp = "1313000474";
		$today = date('Y-m-d');
		$startTimeStamp = strtotime($today);
		$endTimeStamp = strtotime($date);
		
		$timeDiff = $endTimeStamp - $startTimeStamp;
		$numberDays = $timeDiff/86400;  
		$numberDays = $numberDays;	
		
		if($numberDays == 0)  $day = 'Today';
		if($numberDays == 1)  $day = 'Tomorrow';
		if($numberDays > 1)   $day =  $date;
		if($numberDays < 0)   $day = $numberDays;
	
		
		return $day;
	}
	
	public function getProgress($id){
		$sqltask = "SELECT progress FROM tasks WHERE id=".$id ;
		$stmttask = parent::query($sqltask);
		$rowtask = $stmttask->fetch(PDO::FETCH_ASSOC);
		$progresstask = $rowtask['progress'];
		
		$sql = "SELECT * FROM tasks_timelines WHERE task_id=".$id." ORDER BY stamp DESC LIMIT 1";
		$stmt = parent::query($sql);
		$taskprogress=''; 
		$day = '';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
			$stamp = $row['stamp'];
			
			$today = date('Y-m-d');
			$startTimeStamp = strtotime($today);
			$endTimeStamp = strtotime(date('Y-m-d',strtotime($stamp)));
			$timeDiff = abs($endTimeStamp - $startTimeStamp);
			$numberDays = $timeDiff/86400;
			if($numberDays == 0)  $day = 'Today';
			if($numberDays == 1)  $day = 'Yesterday';
			if($numberDays > 1)   $day =  $numberDays .' days ago';
					
		}
		
		   $taskprogress =  array(
		                          'progress' => $progresstask,
								  'progressupdate' => $day
								  );

         return $taskprogress;
		
	}
	

}

$task = new Task();

?>