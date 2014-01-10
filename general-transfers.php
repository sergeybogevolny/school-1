<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'transfers';
$label = '';

include("header.php");

include_once(dirname(__FILE__) . '/classes/functions-general-transfers.php');

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'recorded';
}
?>
    <script src="js/general-transfers.js"></script>

    <script>
       var TYPE_LIST = '<?php echo $type ?>';
    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/transfers-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/transfers-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="transfers-label"></h3>
                                    <!-- id for list-actions -->
                                    <div id='list-actions'>
                                        <select name="list-type" id="list-type" class='select2-me input-xlarge' onchange="getList()">
									        <option value="recorded">Recorded</option>
                                            <option value="dispatched">Dispatched</option>
                                            <option value="rejected">Rejected</option>
                                            <option value="posted">Posted</option>
                                            <option value="settled">Settled</option>
                                        </select>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='transfers-list'>
                                    <?php list_transfers($type); ?>
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
