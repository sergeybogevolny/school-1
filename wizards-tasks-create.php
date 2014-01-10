<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_tasks_create.class.php');

include_once('classes/listbox.class.php');
include_once('classes/steps.class.php');

$username = $listbox->getUserName();
?>
    <link href="css/plugins/multiselect-checkbox/multiple-select.css" rel="stylesheet"  />
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script src="js/wizards-tasks-create.js"></script>
    <script src="js/plugins/multiselect-checkbox/jquery.multiple.select.js"></script>
    <script>
        var LEVEL = '<?php echo $level; ?>';
    </script>
        <div class="container-fluid" id="content">

            <?php include_once('pages/wizards-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/wizards-page-header.php'); ?>

					<div class="row-fluid">
    					<div class="span12">
    						<div class="box">
    							<div class="box-title">
    								<h3>
    									<i class="icon-signin"></i>
    									Tasks Create
    								</h3>
    							</div>
    							<div class="box-content">
                                    <div id="success" class="hide alert alert-success">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <center>Success</center>
                                    </div>
    		                        <form method="post" action="classes/wizards_tasks_create.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
                                		<div class="step" id="firstStep">
                                            <?php echo $steps->getSteps(5,1); ?>
                                            <div class="step-forms">
                                                <div class="control-group">
                                            	    <label for="textfield" class="control-label">Type</label>
                                            		<div class="controls">
                                            		    <select name="task-type" id="task-type" class='select2-me span2  input-xlarge' onchange="firstStepValidation()">
                                                            <option value=""></option>
                                                            <option value="payment">Payment</option>
                                                            <option value="court">Court</option>
                                                            <option value="problem">Problem</option>
                                                        </select>
                                            		</div>
                                            	</div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Data</label>
                                        			<div class="controls">
                                            		    <select name="task-data" id="task-data" class='select2-me span2  input-xlarge'  onchange="firstDataValidation()">
                									        <option value=""></option>
                                                        </select>
                                        			</div>
                                                </div>
                                                <input type="hidden" name="report-id" id="report-id" value="181">
                                            </div>
    									</div>
                                        <div class="step" id="secondStep">
                                            <?php echo $steps->getSteps(5,2); ?>
                                            <div class="step-forms">
                                            
                                                <div class="row-fluid" >
                                                    <div class="box">
                                                        <div class="box-title">
                                                            <h3>Conditions</h3>
                                                        </div>
                                                        <div class="span10">
                                                            <div class="span10">
                                                            <div class="query"></div>
                                                            <div class="" style="float:left; margin-top:30px;">
                                                                <a id="gv" class="btn btn-primary"> +G</a>
                                                                <a id="cv" class="btn btn-primary addCondition"> +C</a>
                                                                <a id="read" class="btn btn-primary" onclick="readInput()"> Query</a>
                                                             </div>
                                                            </div>                       
                                                         </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row-fluid" >
                                                    <div class="box">
                                                        <div class="box-title">
                                                            <h3></h3>
                                                        </div>
                                                          <div class="loading" style="display: none;">Loading...</div>
                                                       <div id="logic-data" style="display:none;">
                                                        <table id="logic-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                                                          <thead>
                                                            <tr class='thefilter'>
                                                              <th style="display:none">Where</th>
                                                              <th>Group Operator</th>
                                                              <th>Condition Operator</th>
                                                              <th style="display:none">G</th>
                                                              <th style="display:none">C</th>
                                                              <th> Field</th>
                                                              <th>Comparison</th>
                                                              <th>Value</th>
                                                              <th> </th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>
                                                          </tbody>
                                                        </table>
                                                       </div>
                                                    </div>
                                                </div>                
                                            
                                            
                                            
                                            
                                                <div class="row-fluid" >
                                                    <div class="box">
                                    				    <div class="box-title">
                                    					    <h3>Results</h3>
                                    					</div>
                                                        <div class="loading" style="display: none;">Loading...</div>
                                    					<div class="box" id="report-results"></div>
                                                    </div>
                                                    <input type="hidden" name="report-conditionraw" id="report-conditionraw" value="">
                                                    <input type="hidden" name="report-id" id="report-id" value="">
                                                </div>
                                            </div>
    									</div>
                                        <div class="step" id="thirdStep">
    										<?php echo $steps->getSteps(5,3); ?>
                                            <div class="step-forms">
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <div class="row-fluid">
                                                            <div style="float:left;margin-right:5px;">
                                                                 <h5 id="datatitle"></h5>
                                                            </div>
                                                            <div style="float:right;margin-right:5px;">
                                                                <select id="tasks-filter-useremail" class="input-large filter-fields" style="width:150px;"  multiple="multiple">
                                                                    <?php echo $username; ?>
                                                                </select>
                                                                
                                                                
                                                                
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                        <div id="tasks-text" style="display:none;"></div>
                                                        <div class="power-loading" style="display: none;">Loading...</div>
                                                        <table id="tasks-table" class="table table-hover table-nomargin table-bordered dataTable_3 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                          								    <thead>
                              							        <tr class='thefilter'>
                              									    <th class='with-checkbox'><input type="checkbox" name="check_all_1" id="check_all_1">
                                                                        <button type="button" class="btn btn-blue" id="tasks-add" style="margin-left:10px;"><i class="icon-chevron-right"></i></button>
                                                                    </th>
                                                                    <th>Focus</th>
                              										<th style="display:none"></th>
                                                                </tr>
                              							    </thead>
                              							    <tbody>
                                                            </tbody>
                    								    </table>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="row-fluid">
                                                            <div id="tasks-count"><h5>Total Count: 0</h5></div>
                                                        </div>
                                                        <table id="tasks-bin" class="table table-hover table-nomargin table-bordered dataTable_2 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                        									<thead>
                        										<tr class='thefilter'>
                        											<th class='with-checkbox'><input type="checkbox" name="check_all_2" id="check_all_2">
                                                                        <button type="button" class="btn btn-blue" id="tasks-remove" style="margin-left:10px;"><i class="icon-remove"></i></button>
                                                                    </th>
                                                                    <th>Focus</th>
                            										<th>Assigned To</th>
                                                                    <th style="display:none"></th>
                                                                </tr>
                        									</thead>
                        									<tbody>
                                                            </tbody>
                        								</table>
                                                    </div>
                                                </div>
    										</div>
    									</div>
                                        <div class="step" id="fourthStep">
    										<?php echo $steps->getSteps(5,4); ?>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Task*</label>
                                        		<div class="controls">
                                        		    <input type="text" name="task" id="task" class="input-large span6" style="margin-left:5px" onblur="fourthStepValidation()" onkeyup="fourthStepValidation()" onchange="fourthStepValidation()">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Description</label>
                                        		<div class="controls">
                                        		    <textarea  name="task-description" id="task-description" class="input-large span6" style="margin-left:5px"></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Priority*</label>
                                        		<div class="controls">
                                                    <select id="task-priority" name="task-priority" class="select2-me input-large span6" onblur="fourthStepValidation()" onkeyup="fourthStepValidation()" onchange="fourthStepValidation()">
                                                        <option value="low">Low</option>
                                                        <option value="medium" selected>Medium</option>
                                                        <option value="high">High</option>
                                                    </select>
                                                </div>
                                        	</div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Deadline*</label>
                                        		<div class="controls">
                                        		    <input type="text" name="task-deadline" id="task-deadline" class="input-large span6 datepicker" style="margin-left:5px" onblur="fourthStepValidation()" onkeyup="fourthStepValidation()" onchange="fourthStepValidation()">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="step" id="fifthStep">
    										<?php echo $steps->getSteps(5,5); ?>
                                            <div class="control-group" id="group-type">
    											<label class="control-label bold">Type</label>
    											<div class="controls">
    												<span id="review_type"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-data">
    											<label class="control-label">Data</label>
    											<div class="controls">
    												<span id="review_data"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-task">
    											<label class="control-label">Task</label>
    											<div class="controls">
    												<span id="review_task"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-description">
    											<label class="control-label">Description</label>
    											<div class="controls">
                                                    <span id="review_description"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-priority">
    											<label class="control-label">Priority</label>
    											<div class="controls">
    												<span id="review_priority"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-deadline">
    											<label class="control-label">Deadline</label>
    											<div class="controls">
    												<span id="review_deadline"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-client">
                                                <div class="span12" style="margin-bottom:10px;">
                                                    <div class="span4" id="task-client-count"></div>
                                                </div>
											    <div id="review_client" class="span8"></div>
										    </div>
                                            
                                            <div class="control-group" id="group-report">
                                               <div class="span12" style="margin-bottom:10px;">
                                                    
                                                </div> 
											    <div id="review_report" class="span8"></div>
										    </div>
                                        </div>
    									<div class="form-actions" id="wizard-actions">
    										<input type="reset" class="btn" value="Back" id="back">
    										<input type="submit" class="btn btn-primary" value="Submit" id="next">
    									</div>
    								</form>
    							</div>
    						</div>
    					</div>
    				</div>
				</div>
			</div>
		</div>
        
    <script src="js/jqueryquery/condition-logic-wizard.js"></script>
<?php
include("footer.php");
?>
