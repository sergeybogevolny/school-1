<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");
include_once(dirname(__FILE__) . '/classes/functions-bulletin.php');

$title = 'logic';
$label = 'general';
include_once('header.php');

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'mytasks';
}

?>


<script>
		   var TYPE_LIST = '<?php echo $type ?>';
   </script>


<script src="js/logic.js"></script>
        <div class="container-fluid" id="content">

            <?php include_once('pages/search-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid " >

                <div class="row-fluid" >
                    <div class="box">
    				    <div class="box-title">
    					    <h3>Logic</h3>
    					</div>
                        <div class="span10">
                            <div style="float:left; margin-top:30px;margin-right:10px;">
                                <select name="task-type" id="task-type" class="select2-me input-large" onchange="getList()">
                                    <option value=""></option>
                                    <option value="mytasks">My Tasks</option>
                                    <option value="myassignedtasks">My Assigned Tasks</option>
                    		    </select>
                            </div>
                            <div style="float:left; margin-top:30px;margin-right:10px;">
                                <select name="task-user" id="task-user" class="select2-me input-large" style="float:left; margin-top:30px;margin-right:10px;">
                                    <option value=""></option>
                                    <option value="adam@email.com">adam@email.com</option>
                                    <option value="nishant@email.com">nishant@email.com</option>
                                    <option value="vikas@email.com">vikas@email.com</option>
                    		    </select>
                            </div>
                            <div class="" style="float:left; margin-top:30px;margin-right:10px;">
                                <button id="load" class="btn btn-primary" onclick="LoadTasks()"> Load</button>
                            </div>
                            <div class="" style="float:left; margin-top:30px;margin-right:10px;">
                                <button id="readunread" class="btn btn-primary" onclick="LoadReadunreadTasks()"> Read,Unread</button>
                            </div>
                            <div class="" style="float:left; margin-top:30px;margin-right:10px;">
                                <button id="assignedto" class="btn btn-primary" onclick="LoadAssignedtoTasks()"> Assignedto</button>
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
                       <div id="logic-data">
                        <table id="logic-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                          <thead>
                            <tr class='thefilter'>
                              <th style="display:none">Party</th>
                              <th style="display:none">Assignedby</th>
                              <th>Assigned To</th>
                              <th>Task</th>
                              <th>Priority</th>
                              <th>Read</th>
                              <th>Deadline</th>
                              <th>Progress</th>
                              <th style="display:none">logicorder</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                       </div>
                    </div>
                </div>

            </div>
			</div>
		</div>

<?php
include("footer.php");
?>
