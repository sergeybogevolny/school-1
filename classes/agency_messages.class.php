<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Agency_messages extends Generic {

	private $options = array();

    function __construct() {
     
	   if(!empty($_GET['messagelist'])) $this->getMessageList() ;
	 
	   if(!empty($_GET['singlemessageid'])) $this->loadMessage();
	   
		if(!empty($_GET['messagecount'])) $this->getUnreadMessageCount();
		
		if(!empty($_POST)) {
			foreach ($_POST as $key => $value)
				$this->options[$key] = parent::secure($value);

			
                $this->recipient = parent::secure($_POST['message-to']);
				$this->subject = parent::secure($_POST['message-subject']);
                $this->body = parent::secure($_POST['message-body']);
				$this->created =   date('Y-m-d H:i:s');


                $this->validatemessage();
                $this->addMessage();
                if(!empty($this->error)){
                    echo $this->error;
                } else {
    	            echo $this->result;
                }
            

            exit;

        }

	}

	private function validatemessage() {
        if(empty($this->subject)) {
			$this->error = '<div class="alert alert-error">You must enter subject</div>';
		} else if(empty($this->body)) {
			$this->error = '<div class="alert alert-error">You must enter content</div>';
		} 
	}

    private function addMessage() {
		if(!empty($this->error))
			return false;
        $recipient    = $this->recipient;
        $sender       = $_SESSION['nware']['email'];
        $subject      = $this->subject;
        $body  		  = $this->body;
		$created      = $this->created;
        $user_id      = $_SESSION['nware']['user_id'];
		
		$sql = "
			INSERT INTO agency_messages
			(`recipient`,`sender`,`subject`,`body`,`created`, `user_id`)
			VALUES
			('$recipient','$sender', '$subject', '$body', '$created','$user_id')
		";
		$stmt = parent::query($sql);
		$messageid = parent::$dbh->lastInsertId();
		
	   $this->result = '<div class="alert alert-success">Successfully added record</div>';

	}
	
	
	
	private function readMessage($rid){
		
		$sql = "UPDATE agency_messages SET  `read` = 1 WHERE id = ".$rid;
		$stmt = parent::query($sql);
		
		$this->result = '<div class="alert alert-success">Successfully added record</div>';
	}
	
	
	public function getUnreadMessageCount() {
		$user_id= $_SESSION['nware']['user_id'];
		$this->unreadMessageCount = 0 ;

		$sql = "
			SELECT
			COUNT(*) AS UNREAD
			FROM agency_messages
			WHERE `read` = 0
			AND `user_id` = ".$user_id." 
		";
		
		$stmt = parent::query($sql);

		if ($stmt->rowCount() > 0) {
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$this->unreadMessageCount = $row['UNREAD'];
			}
		}
		
		echo $this->unreadMessageCount;
	}
	
	


    public function getMessageList() {
		
		$sql = "SELECT `id`, `sender`, `subject`, `body`, `read`,`created`	FROM agency_messages WHERE `user_id` = ".$_SESSION['nware']['user_id']." ORDER BY `created` DESC";
		$stmt = parent::query($sql);

		if ($stmt->rowCount() > 0) {
        ?>

            <table class="table table-striped table-nomargin table-mail">
              <thead>
                <tr>
                  <th colspan="3"> <div class="checker" style="float:left;margin-top:5px"><span>
                      <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                      </span></div>
                    <div class="btn-group" style="float:left"> <a data-toggle="dropdown" href="#" class="btn mini blue"> More <i class="icon-angle-down "></i> </a>
                      <ul class="dropdown-menu">
                        <li><a href="#"><i class="icon-pencil"></i> Mark as Read</a></li>
                        <li><a href="#"><i class="icon-ban-circle"></i> Spam</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                      </ul>
                    </div>
                  </th>
                  <th colspan="3" class="text-right"> <div style="float:right" >
                      <ul class="unstyled inline inbox-nav">
                        <li><span>1-30 of 789</span></li>
                        <li><i onclick="window.location.href='page1.php'" class="icon-angle-left  pagination-left"></i></li>
                        <li><i onclick="window.location.href='page2.php'" class="icon-angle-right pagination-right"></i></li>
                      </ul>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
				<?php while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) :
                                $sender  = $row['sender'];
                                $subject = $row['subject'];
                                $body    = $row['body'];
                                $read    = $row['read'];
                                $created = date('F jS Y', strtotime($row['created']));
                                $id      = $row['id'];
                            ?>
                <tr class=" <?php echo $read==1 ? " " : "unread" ?> messagedata" id="<?php echo $id; ?>">
                  <td class="inbox-small-cells"><div class="checker"><span>
                      <input type="checkbox" class="mail-checkbox">
                      </span></div></td>
                  <td class="inbox-small-cells"><i class="icon-star"></i></td>
                  
                  <td class="view-message  hidden-phone"  onclick="loadSingleMessage(<?php echo $id; ?>)"><?php echo $sender; ?></td>
                  <td class="view-message"  onclick="loadSingleMessage(<?php echo $id; ?>)"><?php echo $subject; ?></td>
                  <td class="view-message  text-right"  onclick="loadSingleMessage(<?php echo $id; ?>)"><?php echo $created; ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
            <?php
	}

  }
  
  
  function loadMessage(){
		
		$id = $_GET['singlemessageid'];
		$sql = "SELECT `sender`, `subject`, `body`, `read`,`created`	FROM agency_messages WHERE `id` = ".$id;
		
		$stmt = parent::query($sql);

		if ($stmt->rowCount() > 0) {
?>
<?php while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $sender  = $row['sender'];
                $subject = $row['subject'];
                $body    = $row['body'];
                $read    = $row['read'];
                $created = date('F jS Y', strtotime($row['created']));
				
				
				if($read == 0) $this->readMessage($id); // update read message
            ?>
             <h4 ><?php echo $subject; ?></h4>
              <div class="inbox-view-info row-fluid">
                    <div class="highlight-toolbar">
											<div class="pull-left">
                             					 <span class="bold">System</span> <span>&#60; support@system.com &#62;</span> to <span class="bold">me</span> on <?php echo $created; ?>                    
                                             </div>
                                             <div class="pull-right">
											<div class="pull-left ">	
                                            <div><a href="javascript:void(0);" class="btn pull-right" onclick="loadMessage()">Back</a> </div>
                                             </div>
                                            <div class="pull-left span2">
                                                        <div class="btn-group">
                                                        
                                                            <a class="btn "   href="#"><i class="icon-reply"></i> Reply </a>                                                        
                                                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> <span class="caret"></span></a>                                                              <ul class="dropdown-menu pull-right">
                                                                    <li><a href="#"><i class="icon-reply reply-btn"></i> Reply</a></li>
                                                                    <li><a href="#"><i class="icon-arrow-right reply-btn"></i> Forward</a></li>
                                                                    <li><a href="#"><i class="icon-print"></i> Print</a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#"><i class="icon-ban-circle"></i> Spam</a></li>
                                                                    <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                                                                    <li>
                                                                </li>
                                                              </ul>
                                                           </div>
                                                    </div>
									 </div>
                         </div>              
              </div>
            
            

            <div class="inbox-view">
              <p> <?php echo $body; ?> </p>
            </div>
            <hr>
<?php } ?>
<?php	  
   }
  }
  

}

$messages = new Agency_messages();

?>
