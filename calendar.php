<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'calendar';
$label = '';

include("header.php");

include_once(dirname(__FILE__) . '/classes/functions-calendar.php');

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'task';
}
?>
    <script>
       var TYPE_EVENT = '<?php echo $type ?>';
	   
    </script>

    <script src="js/calendar.js"></script>

    <script>
       var TYPE_LIST = '<?php echo $type ?>';
	   
    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/calendar-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/calendar-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="calendar-label"></h3>
                                    <!-- id for list-actions -->
                                    <div id='list-actions'>
                                        <select name="list-type" id="list-type" class='select2-me input-xlarge' onchange="getList()">
									        <option value="task">Task</option>
                                            <option value="payment">Payment</option>
                                            <option value="court">Court</option>
                                            <option value="forfeiture">Forfeiture</option>
                                        </select>
                                    </div>
								</div>

                                <div class="box-content">
								    <div class="calendar"></div>
								</div>
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>

<?php
include("footer.php");
?>
