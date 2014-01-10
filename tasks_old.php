<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/tasks.class.php');

$title = 'tasks';
$label = 'tasks';
include('header.php');

include_once('classes/listbox.class.php');
$userEmail = $listbox->getUserEmail();

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'mytask';
}

if(isset($_GET['filter'])){
    $filter = $_GET['filter'];
} else {
    $filter = 'all';
}


$tasks = new Tasks();

?>
<script>
		   var TYPE_LIST = '<?php echo $type ?>';
		   var FILTER_LIST = '<?php echo $filter ?>';
        </script>
<script src="js/tasks.js"></script>

<div class="container-fluid" id="content">
  <?php include_once('pages/tasks-nav-left.php'); ?>
  <div id="main">
    <div class="container-fluid">
      <?php include_once('pages/tasks-page-header.php'); ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="box">
            <div class="box-title"> <span id="task-select">
              <h3><i class="icon-tasks"></i></h3>
              <select name="my-task-type" id="my-task-type" class='select2-me input-large' onchange="getMyTask()">
                <option value="mytask">My Tasks</option>
                <option value="myassignedtask">My Assigned Tasks</option>
              </select>
              </span> 
              <?php if( $type == 'myassignedtask' ){?> 
              <span id="task-id-select">
              
              <select name="taskfilter-type" id="taskfilter-type" class='select2-me input-large' onchange="getTaskType($(this).val())">
                <option value="all">All</option>
                <option value="payment">Payment</option>
                <option value="court">Court</option>
                <option value="problem">Problem</option>
              </select>
              </span>
             <?php } ?>
              <!-- id for list-label, remove nested -->
              <h3 id="tasks-label" style="display:none"></h3>
              
              <!-- id for list-actions -->
              <div class="actions" id='list-actions'>
              
                <?php if( $type == 'myassignedtask' ){?>
               
                    <ul                                  
                    <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle btn btn-mini" href="#"><i class="icon-plus"></i></a>
                      <ul class="dropdown-menu pull-right ">
                        <li> <a  id="tasks-add" href="#">Standard</a> </li>
                        <li> <a href="#" id="last-payment" onclick="LastPayment()">Last Payment</a> </li>
                      </ul>
                    </li>
                   </ul>
                
                
                <?php }else{ ?>
                
                    <a class="btn btn-mini" id="tasks-add" href="#"> <i class="icon-plus"></i> </a>
                
				<?php } ?>
              </div>
            </div>
            <!-- id for *-list, remove content div -->
            <div id='tasks-list'>
              <?php $tasks->getTasksList($type); ?>
            </div>
          </div>
        </div>
      </div>
      
      <!-- id for *-box, insert window body, change class horizontal -->
      <div id='tasks-box' style="display:none">
        <div class="row-fluid" >
          <form method="POST" id='task-form'>
            <div class="span6" id="LastPaymentList" style="display:none" >
              <div class="box">
                <div class="box-content nopadding" id="LastPaymentClientList"> </div>
              </div>
            </div>
            
          <!-- standard -->
            <div class="span6">
              <div class="box">
                <div class="box-content nopadding">
                  <div  class='form-horizontal form-bordered' >
                    <div class="control-group">
                      <label for="textfield" class="control-label">Task</label>
                      <div class="controls">
                        <input type="text" name="task-name" id="task-name" class="input-large span12" value="">
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Type </label>
                      <div class="controls">
                        <select id="task-type" name="task-type" class="select2-me input-large span8">
                          <option value="general">General</option>
                          <option value="problem">Problem</option>
                          <option value="payment">Payment</option>
                          <option value="court">Court</option>
                        </select>
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Deadline</label>
                      <div class="controls">
                        <input type="text" name="task-deadline" id="task-deadline" class="input-large span4 datepicker">
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Description</label>
                      <div class="controls">
                        <textarea  name="task-description" id="task-description" class="input-large span8"></textarea>
                      </div>
                    </div>
                    <?php if($type == 'myassignedtask') { ?>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Assigned User </label>
                      <div class="controls">
                        <select name="assigned-id" id="assigned-id" class="select2-me input-large span8">
                          <?php echo $userEmail; ?>
                        </select>
                      </div>
                    </div>
                    <?php }else{ ?>
                    <input type="hidden" name="assigned-id" id="assigned-id" value="<?php echo $_SESSION['nware']['user_id']; ?>">
                    <?php }?>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Important</label>
                      <div class="controls">
                        <input type="checkbox" name="task-important" id="task-important">
                      </div>
                    </div>
                    <input type="hidden" name="user-id" id="user-id" value="<?php echo $_SESSION['nware']['user_id']; ?>">
                    <input type="hidden" name="task-id" id="task-id" value="">
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary" name="task-save" id="task-save">Save</button>
                      <button type="button" class="btn" name="task-cancel" id="task-cancel">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end standard -->
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div id='jqxWindow-status' style="display:none">
  <div></div>
  <div></div>
</div>
<?php
include("footer.php");
?>
