<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/task.class.php');

$title = 'task';
$label = '';
include("header.php");

$task = new Task();
$stask = $task->getField('task');
$stype = $task->getField('type');
$sassignedstamp = $task->getField('assigned_date');
$sdeadline = $task->getField('deadline');
if ($sdeadline!=""){
    $sdeadline  = date('m/d/Y', strtotime($sdeadline));
}
$sdescription = $task->getField('description');
$simportant = $task->getField('flag_important');
if ($simportant==1){
    $ssimportant = 'Yes';
} else {
    $ssimportant = 'No';
}
$scompleted = $task->getField('completed_date');
$id = $task->getField('id');

?>

    <script src="js/task.js"></script>

    <script type="text/javascript">
        var DETAIL_TASK = "<?php echo $stask; ?>";
        var DETAIL_TYPE = "<?php echo $stype; ?>";
        var DETAIL_ASSIGNEDSTAMP = "<?php echo $sassignedstamp; ?>";
        var DETAIL_DEADLINE = "<?php echo $sdeadline; ?>";
        var DETAIL_DESCRIPTION = "<?php echo $sdescription; ?>";
        var DETAIL_IMPORTANT = "<?php echo $simportant; ?>";
        var DETAIL_COMPLETED = "<?php echo $scompleted; ?>";
    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/tasks-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/tasks-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
                            <div class="box">
      							<div class="box-title">
      								<h3><i class="icon-tasks"></i><?php echo $stask; ?></h3>
      							</div>
      							<div class="box-content">
                                    <div style="margin-bottom:20px;">this is a short descrption</div>
                                    <div class="pull-left">
                                            <ul class="stats">
                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
														    <a href="#" id="actions-revert">Revert</a>
													    </li>
    												</ul>
    										    </div>
                                            </li>

                                            <li class='darkblue'>
        										<i class="icon-time"></i>
        										<div class="details">
        											<span class="big">Due</span>
        											<span>Tomorrow</span>
        										</div>
        									</li>

                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-circle"></i><span class="count">3</span></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li  style="margin-left:10px;margin-right:10px;">11/20/2013 08:00 AM - Nishant</li>
														<li style="margin-left:10px;margin-right:10px;">11/20/2013 08:00 AM - Vikas</li>
                                                        <li style="margin-left:10px;margin-right:10px;">11/20/2013 08:00 AM - Adam</li>
    												</ul>
    										    </div>
                                            </li>

                                            <li class="button">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-circle-blank"></i><span class="count">2</span></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>Inna</li>
                                                        <li>Andrey</li>
    												</ul>
    										    </div>
                                            </li>

                                            <li class='darkblue'>
        										<span class="count">80%</span>
                								<div class="details" style="display:inline-block;margin-left:10px;">
                								    <span class="big">Proggres</span>
                									<span>Updated 365 days ago</span>
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
                                                <label for="textfield" class="control-label">Type</label>
                                                    <div class="controls">
                                                        <p><img src="<?php echo 'img/task_list_'.$stype.'.png'; ?>" style="margin-right:10px"><?php echo  ucfirst($stype);?></p>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Assigned</label>
                                                    <div class="controls">
                                                        <p><?php echo $sassignedstamp ;?></p>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Deadline</label>
                                                    <div class="controls">
                                                        <p><?php echo $sdeadline ;?></p>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Description</label>
                                                    <div class="controls">
                                                        <p><?php echo $sdescription ;?></p>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Important</label>
                                                    <div class="controls">
                                                        <p><?php echo $ssimportant ;?></p>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Completed</label>
                                                    <div class="controls">
                                                        <p><?php echo $scompleted ;?></p>
                                                    </div>
                                                </div>
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
                                        					    <label for="textfield" class="control-label">Task</label>
                                        						<div class="controls">
                                                                    <input type="text" name="detail-name" id="detail-name" class="input-large span12" value="">
                                        						</div>
                                        					</div>
                                        				    <div class="control-group">
                                        					    <label for="textfield" class="control-label">Type </label>
                                        						<div class="controls">
                                                                    <select id="detail-type" name="detail-type" class="select2-me input-large span8">
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
                                        						    <input type="text" name="detail-deadline" id="detail-deadline" class="input-large span4 datepicker">
                                        						</div>
                                        					</div>
                                        				    <div class="control-group">
                                        					    <label for="textfield" class="control-label">Description</label>
                                        						<div class="controls">
                                        						   <textarea  name="detail-description" id="detail-description" class="input-large span8"></textarea>
                                        						</div>
                                        					</div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Important</label>
                                        						<div class="controls">
                                        						    <input type="checkbox" name="detail-important" id="detail-important">
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
                                            <a class="btn btn-mini" href="javascript:LoadTimeline(<?php echo $id; ?>)"; class='btn'>
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


                                                            <input type="hidden" name="timeline-id" id="timeline-id" value="<?php echo $id; ?>">
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



<div id='jqxWindow-status' style="display:none">
<div></div>
<div></div>
</div>


<?php
include("footer.php");
?>
