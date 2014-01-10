<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'forfeitures';
$label = '';

include("header.php");

include_once(dirname(__FILE__) . '/classes/functions-general-forfeitures.php');

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'recorded';
}
?>
    <script src="js/general-forfeitures.js"></script>

    <script>
       var TYPE_LIST = '<?php echo $type ?>';
    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/forfeitures-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/forfeitures-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="forfeitures-label"></h3>
                                    <!-- id for list-actions -->
                                    <div id='list-actions'>
                                        <select name="list-type" id="list-type" class='select2-me input-xlarge' onchange="getList()">
									        <option value="recorded">Recorded</option>
                                            <option value="questioned">Questioned</option>
                                            <option value="charged">Charged</option>
                                            <option value="documented">Documented</option>
                                            <option value="disposed">Disposed</option>
                                        </select>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='forfeitures-list'>
                                    <?php list_forfeitures($type); ?>
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
