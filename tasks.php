<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'tasks';
$label = 'tasks';
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


    <script src="js/tasks.js"></script>

    <div class="container-fluid" id="content">

    <?php include_once('pages/tasks-nav-left.php'); ?>

	    <div id="main">
		    <div class="container-fluid " >
            <?php include_once('pages/tasks-page-header.php'); ?>
                <div class="row-fluid">
                    <div class="box">
    				    <div class="box-title">
    					    <h3><i class="icon-tasks"></i></h3>
                            <select name="task-type" id="task-type" class="select2-me input-large" onchange="getList()">
                                <option value="mytasks">My Tasks</option>
                                <option value="myassignedtasks">My Assigned Tasks</option>
                    		</select>
                            <div class="btn-group" style="margin-left:5px;">
                                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-filter"></i>&nbsp;<span id="filter-type">NONE</span>
                                </a>
                                <ul class="dropdown-menu dropdown-primary">
                                    <li>
                                        <a href="#" class="filter-type">NONE</a>
                                    </li>
                                    <li>
                                        <a href="#" class="filter-type">Court</a>
                                    </li>
                                    <li>
                                        <a href="#" class="filter-type">Payment</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group" id="campaign-menu" style="display:none;">
                                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-bullhorn" style="font-size:18px;"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-primary" id="campaign-items"><li>  Loading...  </li></ul>
                            </div>
    					</div>
                        <input type="hidden" name="user-id" id="user-id" value="<?php echo $_SESSION['nware']['user_id']; ?>">
                        <input type="hidden" name="user-email" id="user-email" value="<?php echo $_SESSION['nware']['email']; ?>">
                    </div>
                </div>

                <div class="row-fluid" >

                        <div id="tasks-loading">Loading...</div>
                        <table id="tasks-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                          <thead>
                            <tr>
                              <th style="display:none"></th>
                              <th style="display:none"></th>
                              <th style="display:none"></th>
                              <th>Assigned To</th>
                              <th>Task</th>
                              <th>Type</th>
                              <th>Priority</th>
                              <th>Read</th>
                              <th>Deadline</th>
                              <th>Progress</th>
                              <th style="display:none"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tbody>
                        </table>

                </div>

            </div>
			</div>
		</div>

<?php
include("footer.php");
?>
