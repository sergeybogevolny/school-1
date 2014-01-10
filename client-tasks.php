<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');

$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'tasks';
include_once('header.php');

$id = $client->getField('id');
?>

    <script src="js/client-tasks.js"></script>

    <!--SET SOURCE -->
    <script type="text/javascript">
    </script>


        <div class="container-fluid" id="content">

            <?php include_once('pages/client-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/client-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="tasks-label"></h3>
                                    <!-- id for list-actions -->
                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="tasks-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='tasks-list'>
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

                    <!-- id for *-box, insert window body, change class horizontal -->
                    <div id='tasks-box' style="display:none">
                        <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                        <input type="hidden" name="task-id" id="task-id" value="">
                        <input type="hidden" name="user-id" id="user-id" value="<?php echo $_SESSION['nware']['user_id']; ?>">
                        <input type="hidden" name="user-email" id="user-email" value="<?php echo $_SESSION['nware']['email']; ?>">
				    </div>

                </div>

			</div>
		</div>


<?php
include("footer.php");
?>
