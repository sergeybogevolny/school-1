<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/task.class.php');
include_once('classes/functions-client.php');

$title = 'task';
$label = '';
include("header.php");

$task = new Task();
$stask = $task->getField('task');
$stype = $task->getField('type');
$sassignedstamp = $task->getField('assigned_date');
$spriority = $task->getField('priority');
$sdeadline = $task->getField('deadline');
if ($sdeadline!=""){
    $sdeadline  = date('m/d/Y', strtotime($sdeadline));
}
$sdescription = $task->getField('description');
$sfocustext = $task->getField('focustext');

$focusid = $task->getField('focus_id');
$partyid = $task->getField('party_id');
$id = $task->getField('id');

$assignedto = $task->getField('assignedto');
$unreadtask1 = explode(";", $assignedto);
$unread = '';
foreach($unreadtask1 as $unreadtask1){
	$unreadtask2 = explode(":", $unreadtask1);
	if(isset($unreadtask2[1]) && $unreadtask2[1] == 0){
		$unread[] = $unreadtask2[0];
	 }
}
if($unread){
	$countunreadtask = count($unread);
	$unreadtask = $unread;
}else{
	$countunreadtask = 0;
}
if($task->tasksReads($id)){
	$taskread = $task->tasksReads($id);
	$counttaskread = count($taskread);
}else{
	$taskread = array();
    $counttaskread = 0;
}

$sassigned = date('m/d/Y h:i A', strtotime($task->getField('assigned')));
$sassigneby = $task->getField('assignedby');
$sassignedto = $assignedto;

$taskparty = $task->tasksParty($partyid);
foreach( $taskparty as $taskparty) {
    $spartytype = $taskparty['type'];
    $slast = $taskparty['last'];
    $sfirst = $taskparty['first'];
    $smiddle = $taskparty['middle'];
}
$sname = '';
if ($sfirst!=""){
    $sname = $sfirst;
}
$sname = trim($sname);
if ($smiddle!=""){
    $sname = $sname . ' ' . $smiddle;
}
$sname = trim($sname);
if ($slast!=""){
    $sname = $sname . ' ' . $slast;
}
$sname = trim($sname);

$currentuser = $_SESSION['nware']['email'];
$isTaskRead = $task->isTaskRead($id,$currentuser);

$duedateCount = $task->dueDateCount($sdeadline);
if($duedateCount < 0){
	$duedate = $sdeadline;
}else{
    $duedate = $duedateCount;
}

$getPreogress = $task->getProgress($id);
if( !empty($getPreogress)){
  $updatedatetimeline = $getPreogress['progressupdate'];
  $progresstimeline   = $getPreogress['progress'];
}

if(!empty($updatedatetimeline)){
  $updatedate = $updatedatetimeline;
}else{
  $updatedate = '00/00/00';
}

if(!empty($progresstimeline)){
  $progress = $progresstimeline;
}else{
  $progress = 0;
}

?>

    <script src="js/plugins/jquery-ui/jquery.ui.slider.js"></script>
    <script src="js/task.js"></script>

    <script type="text/javascript">
	    var PROGRESS   = "<?php echo $progress ?>";
        var DETAIL_TYPE = "<?php echo $stype; ?>";
        var DETAIL_TASK = "<?php echo $stask; ?>";
        var DETAIL_DESCRIPTION = "<?php echo $sdescription; ?>";
        var DETAIL_PRIORITY = "<?php echo $spriority; ?>";
        var DETAIL_DEADLINE = "<?php echo $sdeadline; ?>";
        var DETAIL_ASSIGNEDTO = "<?php echo $sassignedto; ?>";
        var DETAIL_USER = "<?php echo $currentuser; ?>";
	    var TIMELINE_SOURCE =  <?php echo $task->loadTimeline($id); ?>;
    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/task-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/task-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
                            <div class="box">
      							<div class="box-title">
      								<h3><img src="img/task_detail_<?php echo $stype; ?>.png" style="margin-top:-5px;margin-right:10px;"><?php echo strtoupper($stype)." : ".$stask; ?></h3>
      							</div>
      							<div class="box-content">
                                    <div style="margin-bottom:20px;"><?php echo $sdescription; ?></div>
                                    <div class="pull-left">
                                            <ul class="stats">
                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<?php if($isTaskRead == false){ ?>
                                                    <ul class="dropdown-menu dropdown-primary">
    													<li >
														    <a href="#" id="actions-revert" onclick="markread(<?php echo $id ?>)">Mark Read</a>
													    </li>
    												</ul>
                                                    <?php } ?>
    										    </div>
                                            </li>

                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bullhorn"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
                                                        <?php displayBondcampaignmenu("bond","client",$focusid,$partyid)?>
                                                        <?php displayBondcampaignmenu("bond","indemnitor",$focusid,$partyid)?>
    												</ul>

    										    </div>
                                            </li>


                                            <li class='darkblue extend'>
        										<img src="img/task_<?php echo $spriority; ?>_white.png">
        										<div class="details">
        											<span class="big">Priority</span>
        											<span><?php echo ucfirst($spriority); ?></span>
        										</div>
        									</li>

                                            <li class='<?php echo $duedateCount <= -1 ? 'lightred' : 'darkblue'; ?>'>
        										<i class="icon-time"></i>
        										<div class="details">
        											<span class="big">Due</span>
        											<span><?php echo $duedate; ?></span>
        										</div>
        									</li>

                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-circle"></i><span class="count"><?php echo $counttaskread ?></span></a>
    												<?php if($counttaskread != 0) {?>
                                                    <ul class="dropdown-menu dropdown-primary">
													    <?php foreach( $taskread as $taskread) { ?>
                                                            <li style="margin-left:10px;margin-right:10px;"><?php echo date('m/d/Y h:i A', strtotime($taskread['stamp'])) .' - '. $taskread['reader'] ?></li>
                                                        <?php } ?>
    												</ul>
                                                    <?php } ?>
    										    </div>
                                            </li>

                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-circle-blank"></i><span class="count"><?php echo $countunreadtask ?></span></a>
    												<?php if($countunreadtask != 0){ ?>
                                                    <ul class="dropdown-menu dropdown-primary">
                                                        <?php foreach( $unreadtask as $unreadtask){ ?>
														    <li style="margin-left:10px;margin-right:10px;"><?php echo $unreadtask; ?></li>
														<?php } ?>
    												</ul>
                                                    <?php } ?>
    										    </div>
                                            </li>

                                            <li class='darkblue'>
        										<span class="count"><?php echo $progress; ?>%</span>
                								<div class="details" style="display:inline-block;margin-left:10px;">
                								    <span class="big">Progress</span>
                									<span>Updated <?php echo $updatedate; ?></span>
                								</div>
        									</li>

                                            </ul>
                                            </div>
                                </div>
      						</div>
                        </div>
                    </div>


                    <div class="row-fluid">

                        <div class="span6" id="detail-view">

                                <div class="box">
        							<div class="box-title">
        								<h3 id="detail-label"></h3>
                                        <div class="actions" id="detail-list-actions">
                                            <a class="btn btn-mini" href="javascript:LoadDetail(<?php echo $id; ?>)"; class='btn'>
                                                <i class="glyphicon-edit"></i>
                                            </a>
                                        </div>
        							</div>

                                    <div id="detail-list">
                                        <div class="box-content nopadding">
            								<div class='form-horizontal form-bordered'>

                                                <div class="control-group">
                                                    <label for="textfield" class="control-label"><?php echo $spartytype; ?></label>
                                                    <div class="controls">
                                                        <p style="float:left;"><?php echo $sname; ?></p>
                                                        <?php if($spartytype=='Client'){?>
                                                        <div class="btn-group" style="float:right;">
                                                            <a href="client.php?id=<?php echo $partyid; ?>" class="btn btn-primary" id="party-view"><i class="icon-folder-open"></i></a>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if($spartytype=='Prospect'){?>
                                                        <div class="btn-group" style="float:right;">
                                                            <a href="#" class="btn btn-primary" id="party-view" target="_blank"><i class="icon-user"></i></a>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <?php if(($stype=='court')||($stype=='payment')){?>
                                                    <div class="controls">
                                                        <p><?php echo $sfocustext; ?></p>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Assigned</label>
                                                    <div class="controls">
                                                        <p><?php echo $sassigned; ?></p>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">By</label>
                                                    <div class="controls">
                                                        <p><?php echo $sassigneby; ?></p>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">To</label>
                                                    <div class="controls">
                                                        <p id="detail-assignedto"></p>
                                                    </div>
                                                </div>
                                                <input type="hidden">


            								</div>
            							</div>
                                    </div>

                                    <!-- id for *-box, insert window body, change class horizontal -->
                                    <div id='detail-box' style="display:none">
                                        <div class="row-fluid">
                                                <div class="box">
                                                    <div class="box-content nopadding">
                                        			    <form method="POST" class='form-horizontal form-bordered' id='detail-form'>
                                        				    <div class="control-group">
                                        					    <label for="textfield" class="control-label">Type </label>
                                        						<div class="controls">
                                                                    <select id="detail-type" name="detail-type" class="select2-me input-large span12">
                                                                        <option value="general">General</option>
                                                                        <option value="problem">Problem</option>
                                                                        <option value="payment">Payment</option>
                                                                        <option value="court">Court</option>
                                                                    </select>
                                                                </div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Task</label>
                                        						<div class="controls">
                                                                    <input type="text" name="detail-name" id="detail-name" class="input-large span12" value="">
                                        						</div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Description</label>
                                        						<div class="controls">
                                        						   <textarea  name="detail-description" id="detail-description" class="input-large span12"></textarea>
                                        						</div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Priority</label>
                                        						<div class="controls">
                                                                    <select id="detail-priority" name="detail-priority" class="select2-me input-large span12">
                                                                        <option value="low">Low</option>
                                                                        <option value="medium">Medium</option>
                                                                        <option value="high">High</option>
                                                                    </select>
                                                                </div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Deadline</label>
                                        						<div class="controls">
                                        						    <input type="text" name="detail-deadline" id="detail-deadline" class="input-large span12 datepicker">
                                        						</div>
                                        					</div>
                                                            <input type="hidden" name="detail-id" id="detail-id" value="<?php echo $id; ?>">
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-primary" id="detail-save">Save</button>
                        						                <button type="button" class="btn" id="detail-cancel">Cancel</button>
                                        					</div>
                                        				</form>
                                        			</div>
                                                </div>
                                        </div>
                                    </div>

      						    </div>
                            </div>


                             <div class="span6" id="timeline-view">

                                <div class="box">
        							<div class="box-title">
        								<h3 id="timeline-label"></h3>
                                        <div class="actions" id="timeline-list-actions">
                                           <a class="btn btn-mini" id="timeline-add" href="#">
                                                <i class="icon-plus"></i>
                                            </a>
                                        </div>
        							</div>

                                    <div id="timeline-list">
                                        <div class="box-content nopadding">
            							    <div class='form-horizontal form-bordered'>
                                                <?php echo $task->getTimeline($id); ?>
                                            </div>
            							</div>
                                    </div>

                                    <!-- id for *-box, insert window body, change class horizontal -->
                                    <div id='timeline-box' style="display:none">
                                        <div class="row-fluid">
                                                <div class="box">
                                                    <div class="box-content nopadding">
                                                        <form method="POST" class='form-horizontal form-bordered' id='timeline-form'>
                                               
                            				    <div class="control-group">
                            					    <label for="textfield" class="control-label">Progress</label>
                                                    <div class="controls">
                                                        <div class="slider" data-step="5" data-min="0" data-max="100" style="margin-left:10px;">
                                                            <div class="amount" style="top:10px;left:50%;"></div>
                                                            <div class="slide"></div>
                                                     </div>
                            					  </div>
                                                </div>
                                        
                        				    <div class="control-group">
                        					    <label for="textfield" class="control-label">Comment</label>
                        						<div class="controls">
                        						    <textarea name="timeline-comment" id="timeline-comment" class="input-block-level"></textarea>
                        						</div>
                        					</div>


                                                            <input type="hidden" name="timeline-progress" id="timeline-progress" value="">
                                                            <input type="hidden" name="timeline-id" id="timeline-id" value="">
                                                            <input type="hidden" name="task-id" id="task-id" value="<?php echo $id; ?>">

                                                            <div class="form-actions">
                                        					    <button type="submit" class="btn btn-primary" id="timeline-save">Save</button>
                        						                <button type="button" class="btn" id="timeline-cancel">Cancel</button>
                                        					</div>
                                        				</form>
                                        			</div>
                                                </div>
                                        </div>
                                    </div>

      						    </div>
                            </div>


                    </div>
				</div>

			</div>
		</div>
        
        
        



<div id="modal-error" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="error-form">
    <div class="modal-header">
	    <h3 id="modal-title-error"></h3>
	</div>
	<div id="modal-body-error">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
	</div>
</form>
</div>

<div id="modal-status" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="question-form">
    <div class="modal-header">
	    <h3 id="modal-title-status">Task - Status</h3>
	</div>
	<div class="modal-body">
        <p>progress:slider</p>
        <p>comment:textarea</p>
        <input type="hidden" name="status-id" id="status-id" value="">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="status-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>


<?php
include("footer.php");
?>
