<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");
include_once('classes/client.class.php');
$id = $client->getField('id');
$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'summary';
include_once('header.php');

?>

	  <script>
              var CLIENT_ID = <?php echo $_GET['id']; ?>
      </script>

	<script type="text/javascript" src="documents/mugshot/assets/js/ajaxupload.3.5.js"></script>
	<script type="text/javascript" src="documents/mugshot/assets/js/jquery.imgareaselect.min.js"></script>
	<script type="text/javascript" src="documents/mugshot/assets/webcam/webcam.js"></script>
	<script type="text/javascript" src="js/client-avatar.js"></script>



        <div class="container-fluid" id="content">

            <?php include_once('pages/client-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/client-page-header.php'); ?>

					<div class="row-fluid">
    					<div class="span12">
                            <div class="box">
                                <div class="box-title">
    							    <h3><i class="icon-camera"></i>Summary - Mugshot Camera</h3>
    							</div>
                                <div class="box-content">
                                    <div class="btn-group" id="webcam_snapshot">
                                      <button type="button" class="btn btn-small" onclick="webcamSnapshot()">Webcam Snapshot</button>
                                    </div>
                                    <!-- BEGIN UPLOAD CONTAINER -->
                                    <div id="webcam_container" style="display:none"  class="span7">
                                        <div class="alert hidden"> <button type="button" class="close" data-dismiss="alert">&times;</button> <span></span> </div>
                                        <p id="webcam">
                                        </p>
                                        <div class="crop">
                                        </div>
                                        <p class="controls">
                                            <button type="button" class="btn btn-small cancel"> <i class="icon-remove"></i> Cancel</button>
                                            <button class="btn btn-primary btn-small" onClick="webcam.snap()"> <i class="icon-camera icon-white"></i> Take Snapshot</button>
                                        </p>
                                    </div>
                                    <!-- end div #webcam_container -->

                                    <input type="hidden" name="x1" value="" id="x1" />
                                    <input type="hidden" name="y1" value="" id="y1" />
                                    <input type="hidden" name="w" value="" id="w" />
                                    <input type="hidden" name="h" value="" id="h" />

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
